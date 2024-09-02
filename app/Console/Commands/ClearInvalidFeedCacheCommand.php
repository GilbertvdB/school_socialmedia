<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;

class ClearInvalidFeedCacheCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:clear-invalid-feed-cache';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clear invalid cache keys for posts in the dashboard feed';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {   
        $expiredGroupCacheKeys = $this->getExpiredGroupCacheKeys();
        $expiredCacheKeysList = $this->extractCacheKeysFrom($expiredGroupCacheKeys);
        $this->invalidateCacheKeysFrom($expiredCacheKeysList);

        $this->info('Invalid post feed cache keys cleared successfully.');
    }

    /**
     * Get all expired group cache keys list.
     */
    private function getExpiredGroupCacheKeys(): Collection
    {
        $tenMinutesBeforeNow = now()->subMinutes(10)->getTimestamp();  // Define the threshold time

        $expiredGroupCacheKeys = DB::table('cache')
        ->where('key', 'LIKE', "group_cache_keys_%")
        ->where('expiration', '<', $tenMinutesBeforeNow)
        ->get();

        return $expiredGroupCacheKeys;
    }

    /**
     * Extract all page cache keys from the group cache key list and merge into 1 list.
     */
    private function extractCacheKeysFrom(collection $expiredGroupCacheKeys): array
    {
        $cacheKeyList = []; // list for cache keys 'dashboard_posts_groups_%_page_%'
        $cacheKeyGroupList = []; // list for cache keys 'group_cache_keys_%'

        foreach($expiredGroupCacheKeys as $expiredGroupCacheKey)
        {   
            $cacheKeyGroupList[] = $expiredGroupCacheKey->key;
            $array = unserialize($expiredGroupCacheKey->value);
            // Merge the unserialized array into the cacheKeyList, ensuring no duplicates
            $cacheKeyList = array_unique(array_merge($cacheKeyList, $array));
        }

        $expiredCacheKey = array_merge($cacheKeyList, $cacheKeyGroupList);
        
        return $expiredCacheKey;
    }

    /**
     * Invalidate all cache keys in the expired cache key list.
     */
    private function invalidateCacheKeysFrom(array $expiredCacheKeysList): void
    {
        foreach ($expiredCacheKeysList as $cacheKey) {
            $this->info("Clearing cache key: {$cacheKey}");
            Cache::forget($cacheKey);
        }
    }
}
