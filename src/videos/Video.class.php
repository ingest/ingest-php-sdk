<?php

require_once(dirname(__DIR__) . "/AbstractAPIUtilities.class.php");

class Video extends AbstractAPIUtilities
{
  function __construct($version)
  {
    //set high-level vars
    parent::__construct($version);
  }

  function retrieveAll()
  {
    $curl = curl_init($this->apiURL . "videos");
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array("Authorization: Bearer $this->accessToken", "Accept: $this->acceptHeader"));
    curl_setopt($curl, CURLOPT_HEADER, true);

    $response = curl_exec($curl);

    return $this->responseProcessor($response, $curl);
  }

  function retrieve($videoId)
  {
    $curl = curl_init($this->apiURL . "videos/{$videoId}");
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array("Authorization: Bearer $this->accessToken", "Accept: $this->acceptHeader"));
    curl_setopt($curl, CURLOPT_HEADER, true);

    $response = curl_exec($curl);

    return $this->responseProcessor($response, $curl);
  }
}
