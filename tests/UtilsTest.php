<?php

namespace ING\PHPSDK;

use PHPUnit\Framework\TestCase;

class UtilsTest extends TestCase
{
    private $invalid_token = 'Bearer eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJleHAiOiIxNDUwMzY2NzkxIiwic3ViIjoiMTIzNDU2Nzg5MCIsIm5hbWUiOiJKb2huIERvZSIsImFkbWluIjp0cnVlfQ.MGdv4o_sNc84OsRlsitw6D933A3zBqEEacEdp30IQeg';
    private $malformed_token = 'Bearer eyJhbGciOiJIUzI0NiIsInR5cCI6IkpXVCJ9.eyJuYW1lIjoiSm9obiBEb2UifQ.xuEv8qrfXu424LZk8bVgr9MQJUIrp1rHcPyZw_KSsds';

    public function testIsExpired()
    {
        $utils = new Utils();

        $isExpired = $utils->isExpired($this->invalid_token);
        $this->assertTrue($isExpired);

        $isExpired = $utils->isExpired($this->malformed_token);
        $this->assertFalse($isExpired);
    }

    public function testParseTokens()
    {
        $utils = new Utils();
        $t = '/encoding/inputs/<%=id%>/upload<%=method%>';
        
        $h = (object) array(
            'method' => 'methodGoesHere?',
        );
        
        $this->assertEquals('methodGoesHere?', $utils->parseTokens($t, $h));
    }
}
