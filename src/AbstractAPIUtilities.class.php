<?php

// contain basic stuff for authorizing, connecting, sending requests, processing responses, and disconnecting from the API
abstract class AbstractAPIUtilities
{
  function __construct($jwt)
  {
    $this->apiURL = "https://api.ingest.io";
    $this->acceptHeader = "application/vnd.ingest.v1+json";
    $this->jwt = $jwt;
  }

  //for refresh tokens
  function setJWT($jwt)
  {
    $this->jwt = $jwt;
  }
}
