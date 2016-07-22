<?php
/**
 * ING/PHPSDK/TESTS/CacheTest
 *
 * @author REDspace <https://redspace.com>
 * @author Jeff Hann <jeff.hann@redspace.com>
 * @copyright 2016 REDspace
 * @package ING\PHPSDK\TESTS
 * @filesource
 */

namespace ING\PHPSDK\TESTS;

use ING\PHPSDK\UTILS\Cache;
use PHPUnit\Framework\TestCase;

/**
 * Class CacheTest
 * @package ING\PHPSDK\TESTS
 */
class CacheTest extends TestCase {
    /**
     * One hour cache time in seconds.
     *
     * @var int
     */
    const LONG_TTL = 3600;

    /**
     * One minute cache time in seconds.
     *
     * @var int
     */
    const SHORT_TTL = 60;

    /**
     * No cache time in seconds.
     *
     * /var int
     */
    const NO_TTL = 0;

    /**
     * Sample data for testing cache.
     *
     * @var array
     */
    private static $testData = array(
        'C' => 321,
        'D' => 'vanilla'
    );

    /**
     * Test that `false` is returned when retrieving a expired cache object.
     */
    public function testRetrieveExpired() {
        $key = 'test-expired';

        Cache::save($key, CacheTest::$testData, (time() + CacheTest::NO_TTL));

        // Retrieve the item and test it is false
        $this->assertFalse(Cache::retrieve($key));
    }

    /**
     * Test that we can retrieve a cache object and it matches what we sent.
     */
    public function testRetrieve() {
        $key = 'test-item';

        Cache::save($key, CacheTest::$testData, (time() + CacheTest::LONG_TTL));

        // Retrieve the item and test it matches what we originally sent
        $this->assertEquals(Cache::retrieve($key), CacheTest::$testData);
    }

    /**
     * Test that we can remove a cache object and `false` is returned once we try to request it.
     */
    public function testRemove() {
        $key = 'test-item';

        Cache::save($key, CacheTest::$testData, (time() + CacheTest::LONG_TTL));
        Cache::remove($key);

        $this->assertFalse(Cache::retrieve($key));
    }
}