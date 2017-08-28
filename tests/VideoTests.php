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

use IngestPHPSDK\Videos\Video;

$version = 'application/vnd.ingest.v1+json';
$token = 'eyJhbGciOiJSUzI1NiIsInR5cCI6IkpXVCJ9.eyJhdWQiOiJodHRwczovLyouaW5nZXN0LmluZm8iLCJjaWQiOiJJbmdlc3REYXNoYm9hcmQiLCJleHAiOjE1MDM2NzgwMTQsImp0aSI6IjI4OGIxNDA2LTFlZDYtNDhiZi05MDA5LTdkZGI1ZmZjOTZlZCIsImlhdCI6MTUwMzU5MTYxNCwiaXNzIjoiaHR0cHM6Ly9sb2dpbi5pbmdlc3QuaW5mbyIsIm50dyI6IjQyZWJlNmFkLTYyMmQtNDY4MC05ZTMxLTU4ZmIyMDAwYjNlZCIsInNjb3BlIjp7ImFjdGlvbnMiOlsicGVyc29uYWwiLCJyZWFkX2JpbGxpbmciLCJyZWFkX2NsaWVudHMiLCJyZWFkX2V2ZW50cyIsInJlYWRfaG9va3MiLCJyZWFkX2lucHV0cyIsInJlYWRfam9icyIsInJlYWRfbGl2ZSIsInJlYWRfbmV0S2V5cyIsInJlYWRfbmV0d29ya3MiLCJyZWFkX3BsYXlsaXN0cyIsInJlYWRfcHJvZmlsZXMiLCJyZWFkX3VzZXJzIiwicmVhZF92aWRlb3MiLCJ3cml0ZV9iaWxsaW5nIiwid3JpdGVfY2xpZW50cyIsIndyaXRlX2hvb2tzIiwid3JpdGVfaW5wdXRzIiwid3JpdGVfam9icyIsIndyaXRlX2xpdmUiLCJ3cml0ZV9sb2NrZWRfcHJvZmlsZXMiLCJ3cml0ZV9uZXRLZXlzIiwid3JpdGVfbmV0d29ya3MiLCJ3cml0ZV9wbGF5bGlzdHMiLCJ3cml0ZV9wcm9maWxlcyIsIndyaXRlX3VzZXJzIiwid3JpdGVfdmlkZW9zIl19LCJzdWIiOiJlYTJlZDI1NS0zMTBjLTQ0MjYtOTg4MS1jNGZlOGZhYjRhZTEifQ.cvhn-YM-56Asq3yF4SdjEOzWd6VE-AVcnAAVxHxqjhVlE6YDlWLzyUthiAkLmQi0fAJoqXiYGv0oP3fRrJcf1SHAwai301gq1yZOKGbkB-9-N2IALsgKa_ClafPsoc06G6wIuhQ7_KbCPxqYgzyR-tnP59oqJjEkQegw8FkSLB_TFNiHPlWbrj6OG3xd0BH5KTi-u0oFNDwFHlWoofqOlXTD0bsfokGfAykX1w1FMVjiukkwoBuNDyqSjtpRIDUKtj5tp9fnJDvr3vMAEK4EmO15pZaOrMtj5O1AtLYY1FdWxyIxoxscJCmkAnJS3BeryKmqJTu4wZE_LWmdCEePew';

$video = new Video($version, $token);

$countingVideos = $video->count();

if($countingVideos["status"] != "HTTP/1.1 204 No Content")
{
  echo "Videos could not be counted: \n";
  var_dump($countingVideos);
}

$gettingAllVideos = $video->getAll();

if($gettingAllVideos["status"] != "HTTP/1.1 200 OK")
{
  echo "Videos could not be retrieved: \n";
  var_dump($gettingAllVideos);
}

$creatingAVideo = $video->add(array("title"=>"I Am Jack's Inability To Come Up With A Clever Test Title"));

if($creatingAVideo["status"] != "HTTP/1.1 201 Created")
{
  echo "Video could not be created: \n";
  var_dump($creatingAVideo);
}
else
{
  $videoId = $creatingAVideo["content"]->id;
}

if(isset($videoId))
{
  $gettingAllVideosById = $video->getById($videoId);

  if($gettingAllVideosById["status"] != "HTTP/1.1 200 OK")
  {
    echo "Video $videoId could not be retrieved: \n";
    var_dump($gettingAllVideosById);
  }

  $body = array("title"=>"newTitle");

  $updatingAVideo = $video->update($videoId, $body);

  if($updatingAVideo["status"] != "HTTP/1.1 200 OK")
  {
    echo "Video $videoId could not be updated: \n";
    var_dump($updatingAVideo);
  }

  $retrievingThumbnails = $video->getThumbnails($videoId);

  if($retrievingThumbnails["status"] != "HTTP/1.1 200 OK")
  {
    echo "Thumbnails for Video $videoId could not be retrieved: \n";
    var_dump($retrievingThumbnails);
  }

  $retrievingPlaylists = $video->getPlaylists($videoId);

  if($retrievingPlaylists["status"] != "HTTP/1.1 200 OK")
  {
    echo "Playlists for Video $videoId could not be retrieved: \n";
    var_dump($retrievingPlaylists);
  }

  $retrievingVariants = $video->getVariants($videoId);

  if($retrievingVariants["status"] != "HTTP/1.1 200 OK")
  {
    echo "Variants for Video $videoId could not be retrieved: \n";
    var_dump($retrievingVariants);
  }

  $addingExternalThumbnails = $video->addExternalThumbnails($videoId, array("https://image.shutterstock.com/z/stock-vector-wow-73726918.jpg"));

  if($addingExternalThumbnails["status"] != "HTTP/1.1 201 Created")
  {
    echo "External thumbnail could not be created for Video {$videoId}: \n";
    var_dump($addingExternalThumbnails);
  }

  $deletingAVideo = $video->delete($videoId);

    if($deletingAVideo["status"] != "HTTP/1.1 202 Accepted")
    {
      echo "Video $videoId could not be deleted: \n";
      var_dump($deletingAVideo);
    }
}
else
{
  echo "Video tests were not conducted due to creation failure. \n";
}
