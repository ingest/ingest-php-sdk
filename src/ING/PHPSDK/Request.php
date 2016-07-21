<?php
/**
 * ING/PHPSDK/Request.php
 *
 * @author REDspace <https://redspace.com>
 * @author Jeff Hann <jeff.hann@redspace.com>
 * @copyright 2016 REDspace
 * @package ING\PHPSDK
 * @filesource
 */

namespace ING\PHPSDK;

use ING\Base;

/**
 * Request class for handling all transactions to and from the API.
 *
 * @package ING\PHPSDK
 */
class Request extends Base {
    /**
     * List of valid HTTP response codes
     *
     * @var array
     * @const int
     */
    private static $validResponseCodes = Array(200, 201, 202, 204);

    const TYPE_JSON = 'JSON';
    const ERROR_URL = 'Request Error : a url is required to make the request.';
    const ERROR_RESCODE = 'Request Error: Response code returned is invalid';
    const ERROR_SETOPT = 'Error setting Curl option for request';
    const ERROR_POSTDATA = 'Request Error : error preparing post data';

    /**
     * Request method.
     *
     * `GET` or `POST`.
     *
     * @var string
     */
    protected $method = 'GET';

    /**
     * Ignore accept headers.
     *
     * @var bool
     */
    protected $ignoreAcceptHeader = false;

    /**
     * Request constructor.
     *
     * @param \ING\stdClass|NULL|\stdClass $config
     * @throws \Exception
     */
    public function __construct($config)
    {
        parent::__construct($config);

        if (isset($this->url)) {
            $this->ch = curl_init($this->url);
        } else {
            throw new \Exception(Request::ERROR_URL);
        }

        $this->setOpt(CURLOPT_RETURNTRANSFER, true);

        if ('POST' == $this->method) {
            $this->setOpt(CURLOPT_POST, true);
            $this->preparePostData($this->postData);
        }
    }

    /**
     * Request deconstruct closes curl connection
     */
    public function __destruct()
    {
        if (isset($this->url)) {
            curl_close($this->ch);
        }
    }

    /**
     * Execute curl request
     *
     * @return mixed|string
     * @throws \Exception
     */
    public function send() {
        $response = curl_exec($this->ch);

        if (false === $response) {
            throw new \Exception(curl_error($this->ch));
        }

        $this->validateResponseCode(curl_getinfo($this->ch, CURLINFO_RESPONSE_CODE));

        return $response;
    }

    /**
     * Process the POST data before we submit the request.
     *
     * @param \stdClass|null $postData
     * @throws \Exception
     */
    private function preparePostData(\stdClass &$postData = null) {
        if (false == isset($postData)) {
            throw new \Exception(Request::ERROR_POSTDATA);
        }

        $postData = (object) array(
            'data' => http_build_query($postData),
            'type' =>  Request::TYPE_JSON
        );
    }

    /**
     * Update a curl option
     *
     * @param $opt string The CURLOPT_XXX option to set.
     * @param $val string The value to be set on option.
     * @throws \Exception
     */

    private function setOpt($opt, $val) {
        if (false == curl_setopt($this->ch, $opt, $val)) {
            throw new \Exception(sprintf('%s (%s => %s', Request::ERROR_SETOPT, $opt, $val));
        }
    }

    /**
     * Accepts a HTTP response code and if it is not an accepted code throws an error.
     *
     * @uses Request::$validResponseCodes to validate response code from server.
     * @param int $responseCode HTTP response code provided by Curl request.
     * @throws \Exception
     */
    private function validateResponseCode($responseCode) {
        if (false === in_array($responseCode, Request::$validResponseCodes)) {
            throw new \Exception(sprintf('%s (%d)', Request::ERROR_RESCODE, $responseCode));
        }
    }
}
