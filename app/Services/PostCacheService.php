<?php

namespace App\Services;

use App\Models\Post;
use Illuminate\Support\Facades\Cache;

class PostCacheService
{  
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
     * Invalidate all cache for post.
     */
    public function invalidateCacheForPosts(Mixed $post): void
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
        // Optionally, clear the list itself
        Cache::forget("group_cache_keys_{$groupId}");
        $this->forgetAdminCachedPages();
    }

    /**
     * Remove all cache keys for all post pages.
     */
    public function forgetAdminCachedPages()
    {
       // clear cache for all post pages
       $posts = Post::paginate(5, 'id');
       $totalPages = $posts->lastPage();
       for ($page = 1; $page <= $totalPages; $page++) {
           $cacheKey = "dashboard_posts_Admin_page_{$page}";
           Cache::forget($cacheKey);
       }
    }
}