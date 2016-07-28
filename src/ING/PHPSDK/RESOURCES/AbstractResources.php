<?php
/**
 * ING/PHPSDK/RESOURCES/Users.php
 *
 * @author REDspace <https://redspace.com>
 * @author Jeff Hann <jeff.hann@redspace.com>
 * @copyright 2016 REDspace
 * @package ING\PHPSDK\RESOURCES
 * @filesource
 */

namespace ING\PHPSDK\RESOURCES;

use ING\Base;
use ING\PHPSDK\Request;
use ING\PHPSDK\UTILS\Utils;

/**
 * Class AbstractResources
 *
 * @package ING\PHPSDK\RESOURCES
 */
abstract class AbstractResources extends Base
{
    /**
     * @var string
     */
    protected $host = 'https://api.ingest.io';

    /**
     * @var string
     */
    protected $all = '/<%=resource%>';

    /**
     * @var string
     */
    protected $byId = '/<%=resource%>/<%=id%>';

    /**
     * @var string
     */
    protected $trash = '/<%=resource%>?filter=trashed';

    /**
     * @var array
     */
    protected $deleteMethods = array(
        'permanent' => '?permanent=1'
    );

    /**
     * @var string
     */
    protected $search = '/<%=resource%>?search=<%=input%>';

    /**
     * @var null
     */
    protected $token = null;

    /**
     * @var null
     */
    protected $resource = null;

    /**
     * @var object
     */
    public $users;

    /**
     * Return a list of the requested resource for the current user and network.
     *
     * @param $headers
     * @return mixed|string
     */
    public function getAll($headers = null)
    {
        $opts = array(
            'url' => $this->assembleURL($this->all),
        );

        $req = $this->buildRequest($opts);
        return $req->send()->body;
    }

    /**
     * Return a resource that matches the supplied id.
     *
     * @param $id
     * @return mixed|string
     */
    public function getById($id)
    {
        $opts = array(
           'url' => $this->assembleURL($this->byId, array('id' => $id)),
        );

        $req = $this->buildRequest($opts);
        return $req->send()->body;
    }

    /**
     * Return the resources currently in the trash.
     *
     * @param $headers
     */
    public function getTrashed($headers = null)
    {
        $opts = array(
            'url' => $this->assembleURL($this->trash)
        );

        $req = $this->buildRequest($opts);
        return $req->send()->body;
    }

    /**
     * Add a new resource.
     *
     * @param $resources
     */
    public function add($resources)
    {
    }

    /**
     * Update an existing resource with new content.
     *
     * @param $resource
     */
    public function update($resource)
    {
    }

    /**
     * Delete an existing resource
     *
     * @param $resource
     */
    public function delete($resource)
    {
    }

    /**
     *  Permanently delete an existing resource.
     *
     * @param $resource
     */
    public function permanentDelete($resource)
    {
    }

    /**
     * Return a subset of items that match the search terms.
     *
     * @param $input
     * @param $headers
     * @param $trash
     */
    public function search($input, $headers, $trash)
    {
    }

    /**
     * Return a subset of items that match the search terms in the trash
     *
     * @param $input
     * @param $headers
     */
    public function searchTrash($input, $headers)
    {
    }

    /**
     * Get the total count of resources.
     *
     * @return int
     */
    public function count()
    {
        $opts = array(
            'url' => $this->assembleURL($this->all),
            'method' => 'HEAD'
        );

        $req = $this->buildRequest($opts);
        return $req->send()->header;
    }

    /**
     * Get the total count of resources in the trash.
     *
     * @return int
     */
    public function trashCount()
    {
        $opts = array(
            'url' => $this->assembleURL($this->trash),
            'method' => 'HEAD'
        );

        $req = $this->buildRequest($opts);
        return $req->send()->header;
    }

    /**
     * Assemble a full URL based on the host and a array of keys
     *
     * @param string $route
     * @param array $keys
     * @return string
     */
    protected function assembleURL(string $route, array $keys = array())
    {
        $keys['resource'] = $this->resource;
        return Utils::parseTokens($this->host . $route, $keys);
    }

    /**
     * Build a new Request object based on the provided options
     * @param array $opts
     * @return Request
     */
    protected function buildRequest(array $opts)
    {
        $options = Request::getDefaults();
        $options->token = $this->token;

        foreach ($opts as $key => $val) {
            $options->$key = $val;
        }

        return new Request($options);
    }
}
