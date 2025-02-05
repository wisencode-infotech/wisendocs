<?php

namespace App\Helpers;

use App\Models\Version;
use Illuminate\Support\Facades\Cache;

/**
 * Class SystemUtils
 * A utility class for managing application-level common operations.
 *
 * This class provides methods to interact with the application at
 * both the very top and very bottom of the layer.
 */
class SystemUtils
{
    /**
     * Cache key prefix used to standardize and avoid key collisions.
     *
     * @var string
     */
    public $cache_key_prefix = '_wisendocs_cache_';

    public $version_identifier = 1;

    /**
     * Generate a standardized cache key with the defined prefix.
     *
     * This method appends the provided key to the predefined cache key prefix
     * to ensure that all cache keys are unique and consistent across the application.
     *
     * @param string $key The original key to be used for the cache.
     * @return string The fully qualified cache key with the prefix applied.
     */
    public function _getCacheKey(string $key): string
    {
        return $this->cache_key_prefix . 'version_' . $this->version_identifier . '_' . $key;
    }

    /**
     * Set version identifier for the process
     *
     * This method set version identifier from given
     * \App\Models\Version object
     *
     * @param \App\Models\Version $version The version object
     * @return \App\Helpers\SystemUtils $this object
     */
    public function setVersionIdentifier(Version $version)
    {
        $this->version_identifier = $version->identifier ?? 1;

        return $this;
    }

    /**
     * Store a value in the cache.
     *
     * @param string $key The cache key.
     * @param mixed $value The value to store.
     * @param int|null $ttl Time-to-live in seconds (optional). Defaults to Laravel's configuration.
     * @return bool True if the cache was successfully stored, false otherwise.
     */
    public function cache(string $key, $value, int $ttl = null): bool
    {
        return Cache::put($this->_getCacheKey($key), $value, $ttl);
    }

    /**
     * Cache a value forever until it is manually cleared.
     *
     * If the cache key already exists, the cached value is returned.
     * Otherwise, the callback is executed, its return value is cached, and then returned.
     *
     * @param string $key The cache key.
     * @param callable $callback The callback to generate the value if not cached.
     * @return mixed The cached value or the generated value from the callback.
     */
    public function cacheForever(string $key, callable $callback)
    {
        // Use Cache::rememberForever to handle caching and return the stored value
        return Cache::rememberForever($this->_getCacheKey($key), $callback);
    }

    /**
     * Retrieve a value from the cache.
     *
     * @param string $key The cache key.
     * @param mixed $default The default value to return if the key doesn't exist.
     * @return mixed The cached value or the default value.
     */
    public function cached(string $key, $default = null)
    {
        return Cache::get($this->_getCacheKey($key), $default);
    }

    /**
     * Refresh a cached value by clearing the existing cache and storing a new value.
     *
     * @param string $key The cache key.
     * @param mixed $value The new value to store.
     * @param int|null $ttl Time-to-live in seconds (optional). Defaults to Laravel's configuration.
     * @return bool True if the cache was successfully refreshed, false otherwise.
     */
    public function refreshCached(string $key, $value, int $ttl = null): bool
    {
        $this->clearCached($this->_getCacheKey($key));

        return $this->cache($this->_getCacheKey($key), $value, $ttl);
    }

    /**
     * Remove a specific cache key.
     *
     * @param string $key The cache key to remove.
     * @return bool True if the cache key was successfully removed, false otherwise.
     */
    public function clearCached(string $key): bool
    {
        return Cache::forget($this->_getCacheKey($key));
    }

    /**
     * Clear all cache data.
     *
     * @return void
     */
    public function clearAllCache(): void
    {
        Cache::flush();
    }
}