<?php
/**
 * Base.php
 *
 * @author REDspace <https://redspace.com>
 * @author Jeff Hann <jeff.hann@redspace.com>
 * @copyright 2016 REDspace
 * @filesource
 */

use PHPUnit\Framework\TestCase;
use ING\PHPSDK\IngestAPI;

/**
 * Base class for all tests to extend.
 */
class Base extends TestCase
{
    /**
     * Host to local REST server.
     * @var string
     */
    const HOST = 'http://local.weasley.teamspace.ad:8080';

    /**
     * A valid auth token.
     * @var string
     */
    const TOKEN = 'eyJhbGciOiJSUzI1NiIsInR5cCI6IkpXVCJ9.eyJhdWQiOiJodHRwczovLyouaW5nZXN0LmlvIiwiY2lkIjoiSmVmZiIsImV4cCI6MTQ2OTgwMDk2OCwianRpIjoiMzJjNTY3NTAtMTE3Yy00NzVjLTljZGQtYWI1MzU5YTJjMmQ0IiwiaWF0IjoxNDY5NzE0NTY4LCJpc3MiOiJodHRwczovL2xvZ2luLmluZ2VzdC5pbyIsIm50dyI6ImZlZDZlOTI1LWRlZTQtNDFjYy1iZTRhLTQ3OWNhYmMxNDlhNSIsInNjb3BlIjp7ImFjdGlvbnMiOlsicmVhZF92aWRlb3MiLCJ3cml0ZV92aWRlb3MiXX0sInN1YiI6ImMzM2E3ZmI2LTEyNDYtNDYzNC05YzAyLWEyOTE0OWVlMzk1NCJ9.j1Zmz1wQWCODcEgTFELDH8KYiSYUSwxrAbmf8ieVNJ1rtKXRho0l6N4KYuw5msC4yJWGXV3NiKuxLvwRdr-jtiQ1qhYRDV-c7cPCNGjwWFDwTknF7OciFAsxo0j_Mfi0gJtJ8ZO3HLkVvQdtBuVYe4xaJRv_6cWAFtS1xXPIpcpv4BD5EBLRqGJNevbCWC2_tvhkrHcF0F7U4yz1-5DHvIKKo_YJdkSXtWylgkP_bumL-bb5lBQSQ6EhUb_Y-8_FKAtwc4qQ4Xwi_GBHYi9LGc_vgMaZP80Zfulwog4Zwml95c_vMDvKEnASqV_DwQKoB1KEU6nzwFbwhyT3YVIMPw';

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

    public static function API()
    {
        $options = IngestAPI::getDefaults();
        $options->host = Base::HOST;
        $options->token = Base::TOKEN;

        return new IngestAPI($options);
    }
}
