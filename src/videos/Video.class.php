<?php

require_once("../AbstractAPIUtilities.class.php");

class Video extends AbstractAPIUtilities
{
  function __construct($version, $credentials, $jwt)
  {
    //set high-level vars
    parent::__construct($version, $credentials, $jwt);
  }

  function tgTest()
  {
    $curl = curl_init("http://api.tgdevsql002.trackgrptest.com/v1/device/");
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array("Authorization: JWT $this->jwt"));
    curl_setopt($curl, CURLOPT_HEADER, true);

    $response = curl_exec($curl);

    return $this->responseProcessor($response, $curl);
  }

  function retrieve($videoId)
  {
    $curl = curl_init($this->apiURL . "videos/{$videoId}");
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array("Authorization: JWT $this->jwt", "Accept: $this->acceptHeader"));
    curl_setopt($curl, CURLOPT_HEADER, true);

    $response = curl_exec($curl);

    return $this->responseProcessor($response, $curl);
  }
}
