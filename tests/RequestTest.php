<?php
/**
 * ING/PHPSDK/TESTS/RequestTests.php
 *
 * @author REDspace <https://redspace.com>
 * @author Jeff Hann <jeff.hann@redspace.com>
 * @copyright 2016 REDspace
 * @package ING\PHPSDK\TESTS
 * @filesource
 */

namespace ING\PHPSDK\TESTS;

use PHPUnit\Framework\TestCase;
use ING\PHPSDK\Request;

/**
 * Class RequestTest
 * @package ING\PHPSDK\TESTS
 */
class RequestTest extends TestCase
{
    /**
     * Test that an exception is thrown when a invalid URL is provided.
     *
     * @covers Request::send
     * @expectedException Exception
     */
    public function testInvalidURL()
    {
        $config = Request::getDefaults();
        $config->url = 'http://fakefakefake.com/';
        $req = new Request($config);
        $req->send();
    }

    /**
     * Test that an exception is thrown when a page returns a 404.
     *
     * @covers Request::validateResponseCode
     * @expectedException Exception
     */
    public function testInvalidResponseCode()
    {
        $config = Request::getDefaults();
        $config->url = 'https://ingest.io/idontexist.html';
        $req = new Request($config);
        $req->send();
    }

    /**
     * Test that we can sucessfully load some sample content.
     *
     * @covers Request::send
     */
    public function testGetPage()
    {
        $config = Request::getDefaults();
        $config->url = 'http://example.com/';
        $req = new Request($config);
        $this->assertNotNull($req->send());
    }
}
