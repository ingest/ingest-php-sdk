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
$token = 'eyJhbGciOiJSUzI1NiIsInR5cCI6IkpXVCJ9.eyJhdWQiOiJodHRwczovLyouaW5nZXN0LmluZm8iLCJjaWQiOiJJbmdlc3REYXNoYm9hcmQiLCJleHAiOjE1MDM2NzgwMTQsImp0aSI6IjI4OGIxNDA2LTFlZDYtNDhiZi05MDA5LTdkZGI1ZmZjOTZlZCIsImlhdCI6MTUwMzU5MTYxNCwiaXNzIjoiaHR0cHM6Ly9sb2dpbi5pbmdlc3QuaW5mbyIsIm50dyI6IjQyZWJlNmFkLTYyMmQtNDY4MC05ZTMxLTU4ZmIyMDAwYjNlZCIsInNjb3BlIjp7ImFjdGlvbnMiOlsicGVyc29uYWwiLCJyZWFkX2JpbGxpbmciLCJyZWFkX2NsaWVudHMiLCJyZWFkX2V2ZW50cyIsInJlYWRfaG9va3MiLCJyZWFkX2lucHV0cyIsInJlYWRfam9icyIsInJlYWRfbGl2ZSIsInJlYWRfbmV0S2V5cyIsInJlYWRfbmV0d29ya3MiLCJyZWFkX3BsYXlsaXN0cyIsInJlYWRfcHJvZmlsZXMiLCJyZWFkX3VzZXJzIiwicmVhZF92aWRlb3MiLCJ3cml0ZV9iaWxsaW5nIiwid3JpdGVfY2xpZW50cyIsIndyaXRlX2hvb2tzIiwid3JpdGVfaW5wdXRzIiwid3JpdGVfam9icyIsIndyaXRlX2xpdmUiLCJ3cml0ZV9sb2NrZWRfcHJvZmlsZXMiLCJ3cml0ZV9uZXRLZXlzIiwid3JpdGVfbmV0d29ya3MiLCJ3cml0ZV9wbGF5bGlzdHMiLCJ3cml0ZV9wcm9maWxlcyIsIndyaXRlX3VzZXJzIiwid3JpdGVfdmlkZW9zIl19LCJzdWIiOiJlYTJlZDI1NS0zMTBjLTQ0MjYtOTg4MS1jNGZlOGZhYjRhZTEifQ.cvhn-YM-56Asq3yF4SdjEOzWd6VE-AVcnAAVxHxqjhVlE6YDlWLzyUthiAkLmQi0fAJoqXiYGv0oP3fRrJcf1SHAwai301gq1yZOKGbkB-9-N2IALsgKa_ClafPsoc06G6wIuhQ7_KbCPxqYgzyR-tnP59oqJjEkQegw8FkSLB_TFNiHPlWbrj6OG3xd0BH5KTi-u0oFNDwFHlWoofqOlXTD0bsfokGfAykX1w1FMVjiukkwoBuNDyqSjtpRIDUKtj5tp9fnJDvr3vMAEK4EmO15pZaOrMtj5O1AtLYY1FdWxyIxoxscJCmkAnJS3BeryKmqJTu4wZE_LWmdCEePew';

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
