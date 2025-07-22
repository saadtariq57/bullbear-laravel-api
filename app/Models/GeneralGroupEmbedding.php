<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GeneralGroupEmbedding extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'group_id',
        'name',
        'description',
        'embedding',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'embedding' => 'array',
    ];

    /**
     * Get the group that owns the embedding.
     */
    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    /**
     * Calculate cosine similarity between this embedding and another vector.
     *
     * @param array $otherVector
     * @return float
     */
    public function cosineSimilarity(array $otherVector): float
    {
        $embedding = $this->embedding;
        
        if (empty($embedding) || empty($otherVector)) {
            return 0.0;
        }

        $dotProduct = 0.0;
        $normA = 0.0;
        $normB = 0.0;

        $minLength = min(count($embedding), count($otherVector));

        for ($i = 0; $i < $minLength; $i++) {
            $dotProduct += $embedding[$i] * $otherVector[$i];
            $normA += $embedding[$i] * $embedding[$i];
            $normB += $otherVector[$i] * $otherVector[$i];
        }

        $normA = sqrt($normA);
        $normB = sqrt($normB);

        if ($normA == 0.0 || $normB == 0.0) {
            return 0.0;
        }

        return $dotProduct / ($normA * $normB);
    }
}
