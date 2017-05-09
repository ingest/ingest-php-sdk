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

  }

  function get($id)
  {

  }
}
