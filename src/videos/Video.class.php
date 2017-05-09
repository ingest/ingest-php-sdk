<?php

require_once("../AbstractAPIUtilities.class.php");

class Video extends AbstractAPIUtilities
{

  function __construct($jwt)
  {
    //set high-level vars
    parent::__construct($jwt);
  }

  //we'll start with these two to start
  function create($data)
  {
    $curl = curl_init($this->apiURL . "/videos/");
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array("Authorization: Bearer $this->jwt", "Accept: $this->acceptHeader", "Content-Type: application/json"));

    return curl_exec();
  }

  function get($id)
  {
    $curl = curl_init($this->apiURL . "/videos/" . $id);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array("Authorization: Bearer $this->jwt", "Accept: $this->acceptHeader"));

    return curl_exec();
  }
}
