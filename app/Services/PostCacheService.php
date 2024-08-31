<?php

namespace App\Services;

use App\Enums\Role;
use App\Models\Post;
use Illuminate\Support\Facades\Cache;

class PostCacheService
{  
    /**
     * Generate cache key for Posts.
     */
    public function generateCacheKeyForPosts($user, $page=1): string
    {
        if($user->role == Role::Admin) 
        {
            $cacheKey = "dashboard_posts_groups_all_page_{$page}";
        } else {
            $groupIds = $user->postGroups->pluck('id')->sort()->toArray();
            $cacheKey = "dashboard_posts_groups_" . implode('_', $groupIds) . "_page_{$page}";

            // Store the cache key in each group's list for storing, updating or deleting posts.
            $this->storeCacheKeyForGroups($cacheKey, $groupIds);
        }

        return $cacheKey;
    }

    /**
     * Store cache key in lists associated with group IDs.
     */
    public function storeCacheKeyForGroups(string $cacheKey, array $groupIds): void
    {
        foreach ($groupIds as $groupId) {
            // Fetch the current list of cache keys for this group ID
            $cacheKeyList = Cache::get("group_cache_keys_{$groupId}", []);
            // Add the new cache key to the list
            $cacheKeyList[] = $cacheKey;
            // Store the updated list back in the cache
            Cache::put("group_cache_keys_{$groupId}", $cacheKeyList, now()->addMinutes(10)); // 1 hour expiry, adjust as needed
        }
    }

    /**
     * Invalidate all cache keys for post groups.
     */
    public function invalidateCacheKeysForPostGroups(Mixed $post): void
    {
        $groupIds = $post->postGroups->pluck('id')->toArray();
        foreach ($groupIds as $groupId) {
            $this->forgetCacheKeysForGroup($groupId);
        }
    }

    /**
     * Invalidate all cache keys associated with a group ID.
     */
    public function forgetCacheKeysForGroup(int $groupId): void
    {
        $cacheKeyList = Cache::get("group_cache_keys_{$groupId}", []);
        foreach ($cacheKeyList as $cacheKey) {
            Cache::forget($cacheKey);
        }
        // Clear the group list and the group all list
        Cache::forget("group_cache_keys_{$groupId}");
        $this->forgetCacheKeysForAllGroups();
    }

    /**
     * Remove all cache keys for all post pages.
     */
    public function forgetCacheKeysForAllGroups()
    {
       // clear cache for all post pages
       $itemsPerPage = config('post-pagination.items'); //5 items per page
       $posts = Post::paginate($itemsPerPage, 'id');
       $totalPages = $posts->lastPage();
       for ($page = 1; $page <= $totalPages; $page++) {
           $cacheKey = "dashboard_posts_groups_all_page_{$page}";
           Cache::forget($cacheKey);
       }
    }
}