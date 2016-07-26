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
     * @covers Vidoes::getById
     */
    public function testGetById() {
        $api = UsersTest::API();
        $users = $api->users;
        $users->getById('c33a7fb6-1246-4634-9c02-a29149ee3954');
    }

    /**
    * @covers Users:getTrashed
    */
    public function testGetTrashed() {
        $api = UsersTest::API();
        $users = $api->users;
        $users->getTrashed();
    }

    /**
    * @covers Users::count
    */
    public function testCount() {
        $api = UsersTest::API();
        $users = $api->users;
        $users->count();
    }

    /**
    * @covers Users::trashCount
    */
    public function testTrashCount() {
        $api = UsersTest::API();
        $users = $api->users;
        $users->trashCount();
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
