<?php
/**
 * Events are triggered by multiple happenings within your Ingest account, these functions help you access and manipulate them.
 */

namespace IngestPHPSDK\Events;

class Event extends \IngestPHPSDK\AbstractAPIUtilities
{
  function __construct($version, $accessToken)
  {
    //set high-level vars
    parent::__construct($version, $accessToken);
  }

  /**
   * Returns a count of all Events that have occurred in your Network.
   *
   * @return array The API response, split into status, headers, and content.
   */
  function count()
  {
    $curl = curl_init($this->apiURL . "events");

    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array("Authorization: Bearer $this->accessToken", "Accept: $this->acceptHeader"));
    curl_setopt($curl, CURLOPT_HEADER, true);

    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'HEAD');

    $response = curl_exec($curl);

    return $this->responseProcessor($response, $curl);
  }

  /**
   * Returns all the Event types that exist.
   *
   * @return array The API response, split into status, headers, and content.
   */
  function getTypes()
  {
    $curl = curl_init($this->apiURL . "events/types");

    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array("Authorization: Bearer $this->accessToken", "Accept: $this->acceptHeader"));
    curl_setopt($curl, CURLOPT_HEADER, true);

    $response = curl_exec($curl);

    return $this->responseProcessor($response, $curl);
  }

  /**
   * Returns all the Events that have occurred in your Network.
   *
   * @return array The API response, split into status, headers, and content.
   */
  function getAll()
  {
    $curl = curl_init($this->apiURL . "events");

    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array("Authorization: Bearer $this->accessToken", "Accept: $this->acceptHeader"));
    curl_setopt($curl, CURLOPT_HEADER, true);

    $response = curl_exec($curl);

    return $this->responseProcessor($response, $curl);
  }

  /**
   * Returns all the Events that have occurred in your Network.
   *
   * @param string $eventId The ID of the Event you wish to retrieve.
   *
   * @return array The API response, split into status, headers, and content.
   */
  function getById($eventId)
  {
    $curl = curl_init($this->apiURL . "events/{$eventId}");

    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array("Authorization: Bearer $this->accessToken", "Accept: $this->acceptHeader"));
    curl_setopt($curl, CURLOPT_HEADER, true);

    $response = curl_exec($curl);

    return $this->responseProcessor($response, $curl);
  }

}
