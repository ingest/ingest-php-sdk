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
$token = ' ';

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
