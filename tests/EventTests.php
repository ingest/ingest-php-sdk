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

use IngestPHPSDK\Events\Event;

$version = 'application/vnd.ingest.v1+json';
$token = ' ';

$event = new Event($version, $token);

$countingEvents = $event->count();

if($countingEvents["status"] != "HTTP/1.1 204 No Content")
{
  echo "Events could not be counted: \n";
  var_dump($countingEvents);
}

$gettingEventTypes = $event->getTypes();

if($gettingEventTypes["status"] != "HTTP/1.1 200 OK")
{
  echo "Event types could not be retrieved: \n";
  var_dump($gettingEventTypes);
}

$gettingAllEvents = $event->getAll();

if($gettingAllEvents["status"] != "HTTP/1.1 200 OK")
{
  echo "Events could not be retrieved: \n";
  var_dump($gettingAllEvents);
}

$gettingAllEventsById = $event->getById('6b92d56b-6ade-4161-839d-9f69383d1f10');

if($gettingAllEventsById["status"] != "HTTP/1.1 200 OK")
{
  echo "Event 6b92d56b-6ade-4161-839d-9f69383d1f10 could not be retrieved: \n";
  var_dump($gettingAllEventsById);
}
