<?php
/**
 * A series of tests to ensure proper functionality of the Ingest API and its SDK.
 *
 * The tests follow a consistent structure:
 * - instantiate the object
 * - call the method
 * - check the returned value against the expected value
 * - if not expected, notify
 *
 * Some tests depend on other tests having previously executed successfully, such as deleting a previously created resource.
 *
 * Some tests, such as Events, rely on the user providing test data, as it cannot be created.
 */

require dirname(__DIR__) . '/vendor/autoload.php';

use IngestPHPSDK\Users\User;

$version = 'application/vnd.ingest.v1+json';
$token = ' ';

$user = new User($version, $token);

$countingUsers = $user->count();

if($countingUsers["status"] != "HTTP/1.1 204 No Content")
{
  echo "Users could not be counted: \n";
  var_dump($countingUsers);
}

$retrievingCurrentUserInfo = $user->getCurrentUserInfo();

if($retrievingCurrentUserInfo["status"] != "HTTP/1.1 200 OK")
{
  echo "Could not retrieve current user info: \n";
  var_dump($retrievingCurrentUserInfo);
}

$retrievingSpecificUserInfo = $user->getById('ea2ed255-310c-4426-9881-c4fe8fab4ae1');

if($retrievingSpecificUserInfo["status"] != "HTTP/1.1 200 OK")
{
  echo "Could not retrieve info for User ea2ed255-310c-4426-9881-c4fe8fab4ae1: \n";
  var_dump($retrievingSpecificUserInfo);
}

$gettingAllUsers = $user->getAll();

if($gettingAllUsers["status"] != "HTTP/1.1 200 OK")
{
  echo "Users could not be retrieved: \n";
  var_dump($gettingAllUsers);
}

$updatingAUser = $user->update('ea2ed255-310c-4426-9881-c4fe8fab4ae1', array("name"=>"Stephen Smith"));

if($updatingAUser["status"] != "HTTP/1.1 200 OK")
{
  echo "User ea2ed255-310c-4426-9881-c4fe8fab4ae1 could not be updated: \n";
  var_dump($updatingAUser);
}
