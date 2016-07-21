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

/**
 * Class Resources
 *
 * @package ING\PHPSDK\RESOURCES
 */
class Resources extends Base
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
    private $tokenSource = null;

    /**
     * @var null
     */
    private $resource = null;

    /**
     * Return a list of the requested resource for the current user and network.
     *
     * @param $headers
     */
    public function getAll($headers) {

    }

    /**
     * Return a resource that matches the supplied id.
     *
     * @param $id
     */
    public function getById($id) {

    }

    /**
     * Return the resources currently in the trash.
     *
     * @param $headers
     */
    public function getTrashed($headers) {

    }

    /**
     * Add a new resource.
     *
     * @param $resources
     */
    public function add($resources) {

    }

    /**
     * Update an existing resource with new content.
     *
     * @param $resource
     */
    public function update($resource) {

    }

    /**
     * Delete an existing resource
     *
     * @param $resource
     */
    public function delete($resource) {

    }

    /**
     *  Permanently delete an existing resource.
     *
     * @param $resource
     */
    public function permanentDelete($resource) {

    }

    /**
     * Return a subset of items that match the search terms.
     *
     * @param $input
     * @param $headers
     * @param $trash
     */
    public function search ($input, $headers, $trash) {

    }

    /**
     * Return a subset of items that match the search terms in the trash
     *
     * @param $input
     * @param $headers
     */
    public function searchTrash($input, $headers) {

    }

    /**
     * Get the total count of resources.
     *
     * @return int
     */
    public function count() {

    }

    /**
     * Get the total count of resources in the trash.
     *
     * @return int
     */
    public function trashCount() {

    }
}
