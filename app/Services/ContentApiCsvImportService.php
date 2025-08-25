<?php

namespace App\Services;

use App\Models\RichTvContentApi;
use Illuminate\Http\UploadedFile;

class ContentApiCsvImportService
{
    /**
     * Import content APIs from a CSV uploaded file.
     *
     * @param UploadedFile $file
     * @param bool $dryRun If true, validate and compute results without saving
     * @param int $maxRows Maximum number of data rows to process
     * @return array{total:int,created:int,updated:int,skipped:int,errors:array<int,array{line:int,error:string,row:array}>,duplicates_in_file:int}
     */
    public function importFromUploadedFile(UploadedFile $file, bool $dryRun = false, int $maxRows = 5000): array
    {
        $path = $file->getRealPath();
        $handle = fopen($path, 'r');
        if ($handle === false) {
            return [
                'total' => 0,
                'created' => 0,
                'updated' => 0,
                'skipped' => 0,
                'errors' => [ ['line' => 0, 'error' => 'Unable to open uploaded file', 'row' => []] ],
                'duplicates_in_file' => 0,
            ];
        }

        $total = 0;
        $created = 0;
        $updated = 0;
        $skipped = 0;
        $errors = [];
        $seenUrls = [];
        $duplicatesInFile = 0;

        // Read header
        $header = fgetcsv($handle);
        if ($header === false) {
            fclose($handle);
            return [
                'total' => 0,
                'created' => 0,
                'updated' => 0,
                'skipped' => 0,
                'errors' => [ ['line' => 1, 'error' => 'Missing header row', 'row' => []] ],
                'duplicates_in_file' => 0,
            ];
        }

        // Map header -> index (case-insensitive)
        $map = [];
        foreach ($header as $idx => $col) {
            $map[strtolower(trim($col))] = $idx;
        }
        $required = ['name', 'url', 'description'];
        foreach ($required as $req) {
            if (!array_key_exists($req, $map)) {
                fclose($handle);
                return [
                    'total' => 0,
                    'created' => 0,
                    'updated' => 0,
                    'skipped' => 0,
                    'errors' => [ ['line' => 1, 'error' => "Missing required column: {$req}", 'row' => []] ],
                    'duplicates_in_file' => 0,
                ];
            }
        }

        $line = 1; // header line
        while (($row = fgetcsv($handle)) !== false) {
            $line++;
            if ($row === [null] || (count($row) === 1 && trim((string) $row[0]) === '')) {
                $skipped++;
                continue;
            }
            if ($total >= $maxRows) {
                $errors[] = ['line' => $line, 'error' => 'Max row limit reached; remaining rows ignored', 'row' => []];
                break;
            }
            $total++;

            $name = isset($row[$map['name']]) ? trim($row[$map['name']]) : '';
            $url = isset($row[$map['url']]) ? trim($row[$map['url']]) : '';
            $description = isset($row[$map['description']]) ? trim($row[$map['description']]) : '';

            // Normalize whitespace
            $name = preg_replace('/\s+/', ' ', $name ?? '');
            $url = preg_replace('/\s+/', '', $url ?? '');
            $description = preg_replace('/\s+/', ' ', $description ?? '');

            // Validate
            if ($name === '') {
                $errors[] = ['line' => $line, 'error' => 'Name is required', 'row' => ['name' => $name, 'url' => $url, 'description' => $description]];
                $skipped++;
                continue;
            }
            if (mb_strlen($name) > 255) {
                $errors[] = ['line' => $line, 'error' => 'Name too long (>255)', 'row' => ['name' => $name]];
                $skipped++;
                continue;
            }
            if ($url === '' || filter_var($url, FILTER_VALIDATE_URL) === false) {
                $errors[] = ['line' => $line, 'error' => 'Invalid URL', 'row' => ['url' => $url]];
                $skipped++;
                continue;
            }
            if (mb_strlen($url) > 255) {
                $errors[] = ['line' => $line, 'error' => 'URL too long (>255)', 'row' => ['url' => $url]];
                $skipped++;
                continue;
            }
            if ($description === '') {
                $errors[] = ['line' => $line, 'error' => 'Description is required', 'row' => []];
                $skipped++;
                continue;
            }

            // De-dup within file by URL
            $urlKey = strtolower($url);
            if (isset($seenUrls[$urlKey])) {
                $duplicatesInFile++;
                $skipped++;
                continue;
            }
            $seenUrls[$urlKey] = true;

            if ($dryRun) {
                $existing = RichTvContentApi::where('url', $url)->first(['id']);
                if ($existing) {
                    $updated++;
                } else {
                    $created++;
                }
                continue;
            }

            // Upsert by URL
            $existing = RichTvContentApi::where('url', $url)->first();
            if ($existing) {
                $existing->update([
                    'name' => $name,
                    'description' => $description,
                ]);
                $updated++;
            } else {
                RichTvContentApi::create([
                    'name' => $name,
                    'url' => $url,
                    'description' => $description,
                ]);
                $created++;
            }
        }

        fclose($handle);

        return [
            'total' => $total,
            'created' => $created,
            'updated' => $updated,
            'skipped' => $skipped,
            'errors' => $errors,
            'duplicates_in_file' => $duplicatesInFile,
        ];
    }
}


