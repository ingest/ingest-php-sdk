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
    const TOKEN = 'eyJhbGciOiJSUzI1NiIsInR5cCI6IkpXVCJ9.eyJhdWQiOiJodHRwczovLyouaW5nZXN0LmlvIiwiY2lkIjoiSmVmZiIsImV4cCI6MTQ2OTY0MzMyMiwianRpIjoiNGRlNzhhYzctZGI3YS00MDg0LWExMzgtOTBjYzRkNDc0NDEwIiwiaWF0IjoxNDY5NTU2OTIyLCJpc3MiOiJodHRwczovL2xvZ2luLmluZ2VzdC5pbyIsIm50dyI6ImZlZDZlOTI1LWRlZTQtNDFjYy1iZTRhLTQ3OWNhYmMxNDlhNSIsInNjb3BlIjp7ImFjdGlvbnMiOlsicmVhZF92aWRlb3MiLCJ3cml0ZV92aWRlb3MiXX0sInN1YiI6ImMzM2E3ZmI2LTEyNDYtNDYzNC05YzAyLWEyOTE0OWVlMzk1NCJ9.rpJyd7v1sZHK9nvlW6gj3RHyDVvG0gi-rynsbxarMkVKOzcSjHInZBPvFgntBNS-KjeGp9v_BsANtIcyHImOzD2FqvLLEcwh90PAkXzXkrm9P7CbtMTdeGav-qs-ypGZ2Z5OhXsH9TTFXyjKFU3MMJVmsuhxfDh-r7m-LnnBMqvWiMiamEP590-2wDnWzbmdmsYJO_OBrmj1yLnz2o8MM54bA-yMf6k_AtCPIqM0fjCC_-hrwNMhCGHB4BFgFeesc7YQP9R2wFrDxub_xuHj04kph32JTpu_f_Isx_RDZ85HYAfcIiMhzK0PxC-Gs2LVoHExBn1F4N3Y9jH2xq8Djw';

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
