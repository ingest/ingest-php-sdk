<?php
/**
 * ING/PHPSDK/CacheTest
 *
 * @author REDspace <https://redspace.com>
 * @author Jeff Hann <jeff.hann@redspace.com>
 * @copyright 2016 REDspace
 * @package ING\PHPSDK
 * @filesource
 */

namespace ING\PHPSDK;

use ING\PHPSDK\UTILS\Cache;
use PHPUnit\Framework\TestCase;

class CacheTest extends TestCase {
    const LONG_TTL = 3600;
    const SHORT_TTL = 60;
    const NO_TTL = 0;

    private static $testData = array(
        'C' => 321,
        'D' => 'vanilla'
    );

    public function testRetrieveExpired() {
        $key = 'test-expired';

        Cache::save($key, CacheTest::$testData, (time() + CacheTest::NO_TTL));

        // Retrieve the item and test it is false
        $this->assertFalse(Cache::retrieve($key));
    }

    public function testRetrieve() {
        $key = 'test-item';

        Cache::save($key, CacheTest::$testData, (time() + CacheTest::LONG_TTL));

        // Retrieve the item and test it matches what we originally sent
        $this->assertEquals(Cache::retrieve($key), CacheTest::$testData);
    }

    public function testRemove() {
        $key = 'test-item';

        Cache::save($key, CacheTest::$testData, (time() + CacheTest::LONG_TTL));
        Cache::remove($key);

        $this->assertFalse(Cache::retrieve($key));
    }
}