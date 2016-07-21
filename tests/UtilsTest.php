<?php
/**
 * ING/PHPSDK/TESTS/UtilsTest.php
 *
 * @author REDspace <https://redspace.com>
 * @author Jeff Hann <jeff.hann@redspace.com>
 * @copyright 2016 REDspace
 * @package ING\PHPSDK\TESTS
 * @filesource
 */

namespace ING\PHPSDK\TESTS;

use PHPUnit\Framework\TestCase;
use ING\PHPSDK\Utils;

/**
 * Class UtilsTest
 * @package ING\PHPSDK\TESTS
 */
class UtilsTest extends TestCase {
    /**
     * Example of a invalid, expired token.
     *
     * @const string
     */
    const INVALID_TOKEN = 'Bearer eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJleHAiOiIxNDUwMzY2NzkxIiwic3ViIjoiMTIzNDU2Nzg5MCIsIm5hbWUiOiJKb2huIERvZSIsImFkbWluIjp0cnVlfQ.MGdv4o_sNc84OsRlsitw6D933A3zBqEEacEdp30IQeg';

    /**
     * Example of a malformed invalid token.
     *
     * @const string
     */
    const MALFORMED_TOKEN = 'Bearer eyJhbGciOiJIUzI0NiIsInR5cCI6IkpXVCJ9.eyJuYW1lIjoiSm9obiBEb2UifQ.xuEv8qrfXu424LZk8bVgr9MQJUIrp1rHcPyZw_KSsds';

    /**
     * Test an expired token.
     *
     * @covers Utils::isExpired
     */
    public function testIsExpired() {
        $utils = new Utils();

        $isExpired = $utils->isExpired(UtilsTest::INVALID_TOKEN);
        $this->assertTrue($isExpired);
    }

    /**
     * Test a non-expired token.
     *
     * @covers Utils::isExpired
     */
    public function testIsExpiredValid() {
        $utils = new Utils();

        $isExpired = $utils->isExpired(UtilsTest::MALFORMED_TOKEN);
        $this->assertFalse($isExpired);
    }

    /**
     * Test that we can properly parse a token template.
     * @covers Utils::parseToken
     */
    public function testParseTokens() {
        $utils = new Utils();
        $t = '/encoding/inputs/<%=id%>/upload<%=method%>';
        
        $h = (object) array(
            'method' => 'methodGoesHere?',
        );
        
        $this->assertEquals('methodGoesHere?', $utils->parseTokens($t, $h));
    }
}
