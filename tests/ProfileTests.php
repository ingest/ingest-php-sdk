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

use IngestPHPSDK\Profiles\Profile;

$version = 'application/vnd.ingest.v1+json';
$token = 'eyJhbGciOiJSUzI1NiIsInR5cCI6IkpXVCJ9.eyJhdWQiOiJodHRwczovLyouaW5nZXN0LmluZm8iLCJjaWQiOiJJbmdlc3REYXNoYm9hcmQiLCJleHAiOjE1MDM2NzgwMTQsImp0aSI6IjI4OGIxNDA2LTFlZDYtNDhiZi05MDA5LTdkZGI1ZmZjOTZlZCIsImlhdCI6MTUwMzU5MTYxNCwiaXNzIjoiaHR0cHM6Ly9sb2dpbi5pbmdlc3QuaW5mbyIsIm50dyI6IjQyZWJlNmFkLTYyMmQtNDY4MC05ZTMxLTU4ZmIyMDAwYjNlZCIsInNjb3BlIjp7ImFjdGlvbnMiOlsicGVyc29uYWwiLCJyZWFkX2JpbGxpbmciLCJyZWFkX2NsaWVudHMiLCJyZWFkX2V2ZW50cyIsInJlYWRfaG9va3MiLCJyZWFkX2lucHV0cyIsInJlYWRfam9icyIsInJlYWRfbGl2ZSIsInJlYWRfbmV0S2V5cyIsInJlYWRfbmV0d29ya3MiLCJyZWFkX3BsYXlsaXN0cyIsInJlYWRfcHJvZmlsZXMiLCJyZWFkX3VzZXJzIiwicmVhZF92aWRlb3MiLCJ3cml0ZV9iaWxsaW5nIiwid3JpdGVfY2xpZW50cyIsIndyaXRlX2hvb2tzIiwid3JpdGVfaW5wdXRzIiwid3JpdGVfam9icyIsIndyaXRlX2xpdmUiLCJ3cml0ZV9sb2NrZWRfcHJvZmlsZXMiLCJ3cml0ZV9uZXRLZXlzIiwid3JpdGVfbmV0d29ya3MiLCJ3cml0ZV9wbGF5bGlzdHMiLCJ3cml0ZV9wcm9maWxlcyIsIndyaXRlX3VzZXJzIiwid3JpdGVfdmlkZW9zIl19LCJzdWIiOiJlYTJlZDI1NS0zMTBjLTQ0MjYtOTg4MS1jNGZlOGZhYjRhZTEifQ.cvhn-YM-56Asq3yF4SdjEOzWd6VE-AVcnAAVxHxqjhVlE6YDlWLzyUthiAkLmQi0fAJoqXiYGv0oP3fRrJcf1SHAwai301gq1yZOKGbkB-9-N2IALsgKa_ClafPsoc06G6wIuhQ7_KbCPxqYgzyR-tnP59oqJjEkQegw8FkSLB_TFNiHPlWbrj6OG3xd0BH5KTi-u0oFNDwFHlWoofqOlXTD0bsfokGfAykX1w1FMVjiukkwoBuNDyqSjtpRIDUKtj5tp9fnJDvr3vMAEK4EmO15pZaOrMtj5O1AtLYY1FdWxyIxoxscJCmkAnJS3BeryKmqJTu4wZE_LWmdCEePew';

$profile = new Profile($version, $token);

$countingProfiles = $profile->count();

if($countingProfiles["status"] != "HTTP/1.1 204 No Content")
{
  echo "Profiles could not be counted: \n";
  var_dump($countingProfiles);
}

$gettingAllProfiles = $profile->getAll();

if($gettingAllProfiles["status"] != "HTTP/1.1 200 OK")
{
  echo "Profiles could not be retrieved: \n";
  var_dump($gettingAllProfiles);
}

$profileData = array(
  "name"=>"Ingest Profile",
  "text_tracks"=>array(
    "webvtt",
    "dfxp"
  ),
  "digital_rights"=>array(
    "type"=>"mpeg_cenc",
    "data"=>array(
      "licence_server_url"=>"valid url here"
    )
  ),
  "type"=>"mp4",
  "data"=>array(
    "what_your_data_is_depends_on"=>"your_type"
  )
);


$creatingAProfile = $profile->add($profileData);

if($creatingAProfile["status"] != "HTTP/1.1 201 Created")
{
  echo "Profile could not be created: \n";
  var_dump($creatingAProfile);
}
else
{
  $profileId = $creatingAProfile["content"]->id;
}

if(isset($profileId))
{
  $gettingAllProfilesById = $profile->getById($profileId);

  if($gettingAllProfilesById["status"] != "HTTP/1.1 200 OK")
  {
    echo "Profile $profileId could not be retrieved: \n";
    var_dump($gettingAllProfilesById);
  }

  $body = array("name"=>"newTitle");

  $updatingAProfile = $profile->update($profileId, $body);

  if($updatingAProfile["status"] != "HTTP/1.1 200 OK")
  {
    echo "Profile $profileId could not be updated: \n";
    var_dump($updatingAProfile);
  }

  $deletingAProfile = $profile->delete($profileId);

  if($deletingAProfile["status"] != "HTTP/1.1 202 Accepted")
  {
    echo "Profile $profileId could not be deleted: \n";
    var_dump($deletingAProfile);
  }
}
else
{
  echo "Profile tests were not conducted due to creation failure. \n";
}
