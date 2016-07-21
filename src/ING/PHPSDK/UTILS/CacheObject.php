<?php
/**
 * ING/PHPSDK/TOOLS/CacheObject.php
 *
 * @author REDspace <https://redspace.com>
 * @author Jeff Hann <jeff.hann@redspace.com>
 * @copyright 2016 REDspace
 * @package ING\PHPSDK\TOOLS
 * @filesource
 */

namespace ING\PHPSDK\UTILS;


/**
 * Cache object to handle encoding/decoding of data and validating TTL's.
 *
 * @package ING\PHPSDK\UTILS
 */
class CacheObject extends AbstractCacheObject {
    /**
     * CacheObjectBase constructor, accepts key, value, and TTL and
     * returns reference to the object.
     * @param $ttl int
     * @param $value mixed
     */
    public function __construct($ttl, $value) {
        $this->ttl = $ttl;
        $this->value = $value;

        return $this;
    }

    /**
     * Returns the value if TTL is valid, if expire returns false
     *
     * @return mixed False when object has expired,
     * elsewise returns the value.
     */
    public function get() {
        return ($this->checkTTL() ? $this->value : false);
    }

    /**
     * Checks the TTL of the object and verifies if it is valid
     *
     * @return bool True if the object is still valid, false if it has expired.
     */
    protected function checkTTL() {
        return (time() < $this->ttl ? true : false);
    }
}
