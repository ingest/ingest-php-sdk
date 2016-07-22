<?php
/**
 * UsersTests.php
 *
 * @author REDspace <https://redspace.com>
 * @author Jeff Hann <jeff.hann@redspace.com>
 * @copyright 2016 REDspace
 * @filesource
 */

require_once 'Base.php';

/**
 * Class UsersTest
 */
class UsersTest extends Base {
    /**
     * @covers Users::getAll
     */
    public function testGetAll() {
        $api = UsersTest::API();
        $users = $api->users;
        $users->getAll();

        // TODO: Actually test something :P
    }

    /**
     * @covers Users::currentUserInfo()
     */
//    public function testCurrentUserInfo() {
//        $options = Users::getDefaults();
//        $options->token = UsersTest::TOKEN;
//        $options->host = UsersTest::HOST;
//        $users = new Users($options);
//        $users->getCurrentUserInfo();
//    }
}