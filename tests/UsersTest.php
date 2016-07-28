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
class UsersTest extends Base
{
    /**
     * @covers Users::getAll
     */
    public function testGetAll()
    {
        $api = UsersTest::API();
        $users = $api->users;
        $this->assertNotNull(json_decode($users->getAll()));
    }
    
    /**
     * @covers Vidoes::getById
     */
    public function testGetById()
    {
        $api = UsersTest::API();
        $users = $api->users;
        $this->assertNotNull(json_decode($users->getById('c33a7fb6-1246-4634-9c02-a29149ee3954')));
    }

    // /**
    // * @covers Users::count
    // */
    // public function testCount()
    // {
    //     $api = UsersTest::API();
    //     $users = $api->users;
        // $c = $users->count();
        // print_r("\n\ntestCount()");
        // var_dump($c);
        // $this->assertInternalType("int", $c);
        // $this->assertGreaterThanOrEqual(0, $c);
   //  }

    /**
     * @covers Users::currentUserInfo
     */
   public function testCurrentUserInfo()
   {
       $api = UsersTest::API();
       $users = $api->users;
       $this->assertNotNull(json_decode($users->getCurrentUserInfo()));
   }
}
