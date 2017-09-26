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
$token = ' ';

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
