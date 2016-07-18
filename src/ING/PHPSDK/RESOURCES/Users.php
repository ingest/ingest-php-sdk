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

require dirname(__DIR__) . '/Request.php';

/**
 * Class Users
 *
 * @package ING\PHPSDK\RESOURCES
 */
class Users extends Base {
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

    /**
     * Retrieve information for the current user.
     */
    public function getCurrentUserInfo() {

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

$z = Users::getDefaults();
$z->revoke = 'abcd';
$a = new Users($z);
var_dump($a);