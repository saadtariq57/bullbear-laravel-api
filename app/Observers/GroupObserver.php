<?php

namespace App\Observers;

use App\Models\Group;
use App\Models\GeneralGroupEmbedding;
use App\Services\EmbeddingService;
use Illuminate\Support\Facades\Log;

class GroupObserver
{
    private EmbeddingService $embeddingService;

    public function __construct(EmbeddingService $embeddingService)
    {
        $this->embeddingService = $embeddingService;
    }

    /**
     * Handle the Group "created" event.
     */
    public function created(Group $group): void
    {
        if ($this->isGeneralCategory($group)) {
            $this->generateEmbedding($group);
        }
    }

    /**
     * Handle the Group "updated" event.
     */
    public function updated(Group $group): void
    {
        if ($this->isGeneralCategory($group)) {
            // Check if description or name was updated
            if ($group->wasChanged(['group_title', 'about', 'category_id'])) {
                $this->updateEmbedding($group);
            }
        } else {
            // If category changed from general to something else, delete embedding
            if ($group->wasChanged('category_id')) {
                $this->deleteEmbedding($group);
            }
        }
    }

    /**
     * Handle the Group "deleted" event.
     */
    public function deleted(Group $group): void
    {
        $this->deleteEmbedding($group);
    }

    /**
     * Handle the Group "restored" event.
     */
    public function restored(Group $group): void
    {
        if ($this->isGeneralCategory($group)) {
            $this->generateEmbedding($group);
        }
    }

    /**
     * Handle the Group "force deleted" event.
     */
    public function forceDeleted(Group $group): void
    {
        $this->deleteEmbedding($group);
    }

    /**
     * Check if the group belongs to a "general" category
     */
    private function isGeneralCategory(Group $group): bool
    {
        // Load the category relationship if not already loaded
        if (!$group->relationLoaded('category')) {
            $group->load('category');
        }

        if (!$group->category) {
            return false;
        }

        // Check if category name contains "general" (case-insensitive)
        $categoryName = strtolower($group->category->name);
        return str_contains($categoryName, 'general') || 
               str_contains($categoryName, 'discussion') ||
               str_contains($categoryName, 'community');
    }

    /**
     * Generate embedding for a group
     */
    private function generateEmbedding(Group $group): void
    {
        try {
            $text = $this->embeddingService->prepareGroupText(
                $group->group_title ?? '',
                $group->about ?? ''
            );

            if (empty(trim($text))) {
                Log::warning('GroupObserver: No text available for embedding generation', [
                    'group_id' => $group->id,
                    'group_title' => $group->group_title,
                ]);
                return;
            }

            $embedding = $this->embeddingService->generateEmbeddingWithRetry($text);

            if ($embedding) {
                GeneralGroupEmbedding::updateOrCreate(
                    ['group_id' => $group->id],
                    [
                        'name' => $group->group_title,
                        'description' => $text,
                        'embedding' => $embedding,
                    ]
                );

                Log::info('GroupObserver: Successfully generated embedding', [
                    'group_id' => $group->id,
                    'group_title' => $group->group_title,
                    'embedding_dimension' => count($embedding),
                ]);
            }

        } catch (\Exception $e) {
            Log::error('GroupObserver: Failed to generate embedding', [
                'group_id' => $group->id,
                'group_title' => $group->group_title,
                'error' => $e->getMessage(),
            ]);
        }
    }

    /**
     * Update embedding for a group
     */
    private function updateEmbedding(Group $group): void
    {
        // Delete existing embedding if it exists
        $this->deleteEmbedding($group);
        
        // Generate new embedding
        $this->generateEmbedding($group);
    }

    /**
     * Delete embedding for a group
     */
    private function deleteEmbedding(Group $group): void
    {
        try {
            $deleted = GeneralGroupEmbedding::where('group_id', $group->id)->delete();
            
            if ($deleted > 0) {
                Log::info('GroupObserver: Deleted embedding', [
                    'group_id' => $group->id,
                    'group_title' => $group->group_title,
                ]);
            }
        } catch (\Exception $e) {
            Log::error('GroupObserver: Failed to delete embedding', [
                'group_id' => $group->id,
                'error' => $e->getMessage(),
            ]);
        }
    }
}
