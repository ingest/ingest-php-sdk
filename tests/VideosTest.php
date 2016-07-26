<?php
/**
 * VidseosTest.php
 *
 * @author REDspace <https://redspace.com>
 * @author Jeff Hann <jeff.hann@redspace.com>
 * @copyright 2016 REDspace
 * @filesource
 */

require_once 'Base.php';

/**
 * Class VideosTest
 */
class VideosTest extends Base {
    /**
     * @covers Videos::getAll()
     */
    public function testGetAll() {
        $api = VideosTest::API();
        $videos = $api->videos;
        $videos->getAll();
    }

    /**
     * @covers Vidoes::getById()
     */
    public function testGetById() {
        $api = VideosTest::API();
        $videos = $api->videos;
        $videos->getById('f0ca2824-efa1-4117-9052-32ff9e173cf5');
    }

    /**
     * @covers Vidoes::count()
     */
    public function testCount() {
        $api = VideosTest::API();
        $videos = $api->videos;
        $videos->count();
    }
}