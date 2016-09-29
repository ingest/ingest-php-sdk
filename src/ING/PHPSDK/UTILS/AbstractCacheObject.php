<?php
/**
 * ING/PHPSDK/TOOLS/AbstractCacheObject.php
 *
 * @author REDspace <https://redspace.com>
 * @author Jeff Hann <jeff.hann@redspace.com>
 * @copyright 2016 REDspace
 * @package ING\PHPSDK\TOOLS
 * @filesource
 */

namespace ING\PHPSDK\UTILS;

/**
 * Abstract base class for cache objects
 *
 * @package ING\PHPSDK\UTILS
 */
abstract class AbstractCacheObject {
    /**
     * Expiry time of object in seconds.
     * @var int
     */
    protected $ttl;

    /**
     * JSON encoded data.
     * @var string
     */
    protected $value;

    /**
     * CacheObjectBase constructor, accepts key, value, and TTL and
     * returns reference to the object.
     * @param $ttl int
     * @param $value mixed
     */
    abstract public function __construct($ttl, $value);

    /**
     * Returns the JSON decoded value if TTL is valid, if expire returns false
     */
    abstract public function get();

    /**
     * Checks the TTL of the object and verifies if it is valid
     */
    abstract protected function checkTTL();
}
