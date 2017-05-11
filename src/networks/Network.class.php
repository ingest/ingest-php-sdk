<?php

require_once("../AbstractAPIUtilities.class.php");

class Network extends AbstractAPIUtilities
{
  function __construct($version, $credentials, $jwt)
  {
    //set high-level vars
    parent::__construct($version, $credentials, $jwt);
  }
}
