<?php

require_once("../AbstractAPIUtilities.class.php");

class NetworkKey extends AbstractAPIUtilities
{
  function __construct($jwt, $version)
  {
    //set high-level vars
    parent::__construct($jwt, $version);
  }
}
