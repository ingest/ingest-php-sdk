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
use ING\PHPSDK\RESOURCES\Users;
use ING\PHPSDK\RESOURCES\Videos;

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
    protected $token = NULL;

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

    private function setOpts($class) {
        $opts = $class::getDefaults();
        $opts->token = $this->getToken();
        $opts->host = $this->host;
        return $opts;
    }

    /**
     * @var Videos
     */

    public $videos;

    /**
     * @var Users
     */
    public $users;

    /**
     * IngestAPI constructor.
     *
     * @param NULL|\stdClass $config
     */
    public function __construct($config)
    {
        // create users object
        parent::__construct($config);
        $this->users = new Users($this->setOpts(Users::class));
        $this->videos = new Users($this->setOpts(Videos::class));
    }
}
