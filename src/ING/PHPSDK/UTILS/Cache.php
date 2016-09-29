<?php
/**
 * ING/PHPSDK/TOOLS/Cache.php
 *
 * @author REDspace <https://redspace.com>
 * @author Jeff Hann <jeff.hann@redspace.com>
 * @copyright 2016 REDspace
 * @package ING\PHPSDK\TOOLS
 * @filesource
 */

namespace ING\PHPSDK\UTILS;

class Cache extends AbstractCache  {
    /**
     * Retrieve the cached result for the provided key.
     *
     * @param $key
     * @return mixed
     */
    static public function retrieve($key) {
        if (isset(Cache::$cacheStore[$key])) {
            return Cache::$cacheStore[$key]->get();
        } else {
            return false;
        }
    }

    /**
     * Remove a result from the cache.
     *
     * @param $key
     * @return mixed
     */
    static public function remove($key) {
        unset(Cache::$cacheStore[$key]);
    }

    /**
     *  Save the new result with its time to live.
     *
     * @param $key
     * @param $value
     * @return bool
     */
    static public function save($key, $value, $ttl) {
        Cache::$cacheStore[$key] = new CacheObject($ttl, $value);
    }

    /**
     * Return an object representing the differences between the provided
     * object and the cached object.
     *
     * @param $key
     * @param $item
     * @param $forced
     */
    static public function diff($key, $item, $forced) {
        // TODO: Implement diff() method.
    }

    /**
     * Return an object representing the differences between the
     * provided objects and the cached object.
     * Similar to diff, but accepts an array of objects.
     *
     * @param $key
     * @param $item
     * @param $forced
     */
    static public function diffArray($key, $item, $forced) {
        // TODO: Implement diffArray() method.
    }
}
