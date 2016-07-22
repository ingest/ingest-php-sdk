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
class Base extends TestCase {
    /**
     * Host to local REST server.
     * @var string
     */
    const HOST = 'http://local.weasley.teamspace.ad:8080';

    /**
     * A valid auth token.
     * @var string
     */
    const TOKEN = 'eyJhbGciOiJSUzI1NiIsInR5cCI6IkpXVCJ9.eyJhdWQiOiJodHRwczovLyouaW5nZXN0LmlvIiwiY2lkIjoiSmVmZiIsImV4cCI6MTQ2OTI4MDAxNywianRpIjoiOGFmOWFjMTgtMTc5MC00MmY4LTg0MjYtMmFkNWVmNDA3MTk2IiwiaWF0IjoxNDY5MTkzNjE3LCJpc3MiOiJodHRwczovL2xvZ2luLmluZ2VzdC5pbyIsIm50dyI6ImZlZDZlOTI1LWRlZTQtNDFjYy1iZTRhLTQ3OWNhYmMxNDlhNSIsInNjb3BlIjp7ImFjdGlvbnMiOlsicmVhZF92aWRlb3MiLCJ3cml0ZV92aWRlb3MiXX0sInN1YiI6ImMzM2E3ZmI2LTEyNDYtNDYzNC05YzAyLWEyOTE0OWVlMzk1NCJ9.OseN-Egnj3Co9cL_-MW04-9q-b7a2H1Tpj13G9izbcWiUeLc_Av_04-o9LBhJIEKVpdE4keluD-Qx_s8jrTm4uWHbd6GhgHOPJgIEkRsCufgSg6s54LOrMTD0MDdz4o3gKviucxceQZy_kZpOG2oESi4YdhIqzKmazpwuC8D578swSz7G4aB-dhd5HW4s5UCm0epkGhdLw3mD6lw84I92uP8V-gsd4P1pi2D9LLtTTajNCfanscessZkm5e26-fj_KubSb5XKajzMmJNRQLVGoba0rhInDKArqMwlo1GLQrk_XI1VaMr4nMw6-XK-DuxPabxR6BxOMvYPoy72RNz3w';

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

    static function API() {
        $options = IngestAPI::getDefaults();
        $options->host = Base::HOST;
        $options->token = Base::TOKEN;

        return new IngestAPI($options);
    }
}