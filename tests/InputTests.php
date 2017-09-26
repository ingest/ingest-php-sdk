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

use IngestPHPSDK\Inputs\Input;

$version = 'application/vnd.ingest.v1+json';
$token = ' ';

$input = new Input($version, $token);

$countingInputs = $input->count();

if($countingInputs["status"] != "HTTP/1.1 204 No Content")
{
  echo "Inputs could not be counted: \n";
  var_dump($countingInputs);
}

$gettingAllInputs = $input->getAll();

if($gettingAllInputs["status"] != "HTTP/1.1 200 OK")
{
  echo "Inputs could not be retrieved: \n";
  var_dump($gettingAllInputs);
}

$filename = "movie.mp4";
$type = "video/mp4";
$size = 54102;

$creatingAnInput = $input->create($filename, $type, $size);

if($creatingAnInput["status"] != "HTTP/1.1 201 Created")
{
  echo "Input could not be created: \n";
  var_dump($creatingAnInput);
}
else
{
  $inputId = $creatingAnInput["content"]->id;
}

if(isset($inputId))
{
  $gettingAllInputsById = $input->getById($inputId);

  if($gettingAllInputsById["status"] != "HTTP/1.1 200 OK")
  {
    echo "Input $inputId could not be retrieved: \n";
    var_dump($gettingAllInputsById);
  }

  $body = array("type"=>"video/mp4");

  $updatingAnInput = $input->update($inputId, $body);

  if($updatingAnInput["status"] != "HTTP/1.1 200 OK")
  {
    echo "Input $inputId could not be updated: \n";
    var_dump($updatingAnInput);
  }

  $deletingAnInput = $input->delete($inputId);

  if($deletingAnInput["status"] != "HTTP/1.1 202 Accepted")
  {
    echo "Input $inputId could not be deleted: \n";
    var_dump($deletingAnInput);
  }
}
else
{
  echo "Input tests were not conducted due to creation failure. \n";
}
