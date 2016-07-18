<?php
/**
 * ING/PHPSDK/IngestAPI.php
 *
 * @author REDspace <https://redspace.com>
 * @author Jeff Hann <jeff.hann@redspace.com>
 * @copyright 2016 REDspace
 * @package ING\PHPSDK
 * @filesource
 */


namespace ING\PHPSDK;

use ING\Base;

require dirname(__DIR__) . '/Base.php';

/**
 * Class IngestAPI
 *
 * @package ING\PHPSDK
 */
class IngestAPI extends Base {
    /**
     * URL to the API server.
     *
     * @var string
     */
    protected $host = 'https://api.ingest.io';

    /**
     * Age of cache (5 minutes default).
     *
     * @var int
     */
    protected $cacheAge = 300000;

    /**
     * Inputs URL template.
     *
     * @var string
     */
    protected $inputs = '/encoding/inputs';

    /**
     * Input by ID URL template.
     *
     * @var string
     */
    protected $inputsById = '/encoding/inputs/<%=id%>';

    /**
     * Input upload URL template.
     *
     * @var string
     */
    protected $inputsUpload = '/encoding/inputs/<%=id%>/upload<%=method%>';

    /**
     * Signed input upload URL template.
     *
     * @var string
     */
    protected $inputsUploadSign = '/encoding/inputs/<%=id%>/upload/sign<%=method%>';

    /**
     * Complete input upload URL template.
     *
     * @var string
     */
    protected $inputsUploadComplete = '/encoding/inputs/<%=id%>/upload/complete';

    /**
     * Abort input upload URL template.
     * @var string
     */
    protected $inputsUploadAbort = '/encoding/inputs/<%=id%>/upload/abort';

    /**
     * JWT object.
     * @var object
     */
    private $token = NULL;

    /**
     * setToken
     *
     * Accepts a new API token.
     *
     * @param (string) $token a new API token
     */
    public function setToken($token) {
       $this->token = $token;
    }

    /**
     * getToken
     *
     * Returns the current API token.
     *
     * @return object
     */
    public function getToken() {
        return $this->token;
    }
}
