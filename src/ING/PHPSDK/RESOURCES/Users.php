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

use ING\PHPSDK\Request;

/**
 * Class Users
 *
 * @package ING\PHPSDK\RESOURCES
 */
class Users extends AbstractResources {
    /**
     * Current user URL template.
     *
     * @var string
     */
    protected $currentUser = '/users/me';

    /**
     * User transfer URL template.
     *
     * @var string
     */
    protected $transfer = '/users/<%=oldId%>/transfer/<%=newId%>';

    /**
     * Revoke user permission URL template.
     *
     * @var string
     */
    protected $revoke = '/revoke';

    protected $resource = 'users';

    /**
     * Retrieve information for the current user.
     */
    public function getCurrentUserInfo() {
        $options = Request::getDefaults();
        $options->url = $this->host . $this->currentUser;
        $request = new Request($options);

        return $request->send();
    }

    /**
     * Transfer all authorship currently under the specified user onto another.
     * This includes all videos & playlists.
     * This task is commonly used in conjunction with permanently deleting a user.
     */
    public function transferUserAuthorship() {

    }

    /**
     * Revokes the authorization token for the current user.
     */
    public function revokeCurrentUser() {

    }
}
