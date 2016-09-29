<?php
/**
 * ING/PHPSDK/TOOLS/AbstractCache.php
 *
 * @author REDspace <https://redspace.com>
 * @author Jeff Hann <jeff.hann@redspace.com>
 * @copyright 2016 REDspace
 * @package ING\PHPSDK\TOOLS
 * @filesource
 */

namespace ING\PHPSDK\UTILS;

/**
 * Abstract base class for Cache so that users can easily
 * extend this for use with memcache, redis, etc
 *
 * @package ING\PHPSDK\UTILS
 */
abstract class AbstractCache {
    /**
     * Expiry time of the object in seconds since Thursday, 1 January 1970.
     * @var integer
     */
    static protected $ttl;

    /**
     * Associated array storing all cache objects.
     *
     * @var array
     */
    static protected $cacheStore = array();

    /**
     * Retrieve the cached result for the provided key.
     *
     * @param $key
     */
    abstract static public function retrieve($key);

    /**
     * Remove a result from the cache.
     *
     * @param $key
     */
    abstract static public function remove($key);

    /**
     *  Save the new result with its time to live.
     *
     * @param $key
     * @param $value
     * @param $ttl
     */
    abstract static public function save($key, $value, $ttl);

    /**
     * Return an object representing the differences between the provided
     * object and the cached object.
     *
     * @param $key
     * @param $item
     * @param $forced
     */
    abstract static public function diff($key, $item, $forced);

    /**
     * Return an object representing the differences between the
     * provided objects and the cached object.
     * Similar to diff, but accepts an array of objects.
     *
     * @param $key
     * @param $item
     * @param $forced
     */
    abstract static public function diffArray($key, $item, $forced);
}
