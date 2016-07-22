<?php
/**
 * UtilsTest.php
 *
 * @author REDspace <https://redspace.com>
 * @author Jeff Hann <jeff.hann@redspace.com>
 * @copyright 2016 REDspace
 * @filesource
 */

use ING\PHPSDK\UTILS\Utils;

/**
 * Class UtilsTest
 */
class UtilsTest extends Base {
    /**
     * Test an expired token.
     *
     * @covers Utils::isExpired
     */
    public function testIsExpired() {
        $isExpired = Utils::isExpired(UtilsTest::INVALID_TOKEN);
        $this->assertTrue($isExpired);
    }

    /**
     * Test a non-expired token.
     *
     * @covers Utils::isExpired
     */
    public function testIsExpiredValid() {
        $isExpired = Utils::isExpired(UtilsTest::MALFORMED_TOKEN);
        $this->assertFalse($isExpired);
    }

    /**
     * Test that we can properly parse a token template.
     * @covers Utils::parseToken
     */
    public function testParseTokens() {
        $t = '/encoding/inputs/<%=id%>/upload/<%=method%>';
        
        $h = (object) array(
            'method' => 'methodGoesHere?',
            'id' => 'jeff'
        );
        
        $this->assertEquals('/encoding/inputs/jeff/upload/methodGoesHere?', Utils::parseTokens($t, $h));
    }
}
