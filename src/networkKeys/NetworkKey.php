<?php
/**
 * Network Keys are resources that provide authentication and authorization for content playback. These functions help you manage them.
 */

namespace IngestPHPSDK\NetworkKeys;

class NetworkKey extends \IngestPHPSDK\AbstractAPIUtilities
{
  function __construct($version, $accessToken, $sendRequestsToStaging = false)
  {
    //set high-level vars
    parent::__construct($version, $accessToken, $sendRequestsToStaging);
  }

  /**
   * Returns a count of all Network Keys in a specific Network.
   *
   * @param string $networkId The ID of the Network in question.
   *
   * @return array The API response, split into status, headers, and content.
   */
  function getAll($networkId)
  {
    $curl = curl_init($this->apiURL . "networks/{$networkId}/keys");

    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array("Authorization: Bearer $this->accessToken", "Accept: $this->acceptHeader"));
    curl_setopt($curl, CURLOPT_HEADER, true);

    $response = curl_exec($curl);

    return $this->responseProcessor($response, $curl);
  }

  /**
   * Creates a Network Key.
   *
   * @param string $networkId  The ID of the Network in question.
   * @param string $networkKey The key to add, in proper format (refer to main API documentation).
   * @param string $networkKeyTitle (Optional) The name of the Network Key.
   *
   * @return array The API response, split into status, headers, and content.
   */
  function add($networkId, $networkKey, $networkKeyTitle = null)
  {
    $curl = curl_init($this->apiURL . "networks/{$networkId}/keys");
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_POST, true);

    if ($networkKeyTitle != null)
    {
      $body = array("title"=>$networkKeyTitle, "key"=>$networkKey);
    }
    else
    {
      $body = array("key"=>$networkKey);
    }

    curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($body));
    curl_setopt($curl, CURLOPT_HTTPHEADER, array("Authorization: Bearer $this->accessToken", "Accept: $this->acceptHeader", "Content-Type: $this->expectedResponseContentType"));
    curl_setopt($curl, CURLOPT_HEADER, true);

    $response = curl_exec($curl);

    return $this->responseProcessor($response, $curl);
  }

  /**
   * Returns information about a specific Network Key.
   *
   * @param string $networkId    The ID of the Network in question.
   * @param string $networkKeyId The ID of the Network Key in question.
   *
   * @return array The API response, split into status, headers, and content.
   */
  function getById($networkId, $networkKeyId)
  {
    $curl = curl_init($this->apiURL . "networks/{$networkId}/keys/{$networkKeyId}");

    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array("Authorization: Bearer $this->accessToken", "Accept: $this->acceptHeader"));
    curl_setopt($curl, CURLOPT_HEADER, true);

    $response = curl_exec($curl);

    return $this->responseProcessor($response, $curl);
  }

  /**
   * Allows you to update the name of a Network Key (the key itself cannot be modified).
   *
   * @param string $networkId          The ID of the Network the Network Key is contained within.
   * @param string $networkKeyId       The ID of the Network Key in question.
   * @param array  $newNetworkKeyTitle The Network Key's new title.
   *
   * @return array The API response, split into status, headers, and content.
   */
  function update($networkId, $networkKeyId, $newNetworkKeyTitle)
  {
    $curl = curl_init($this->apiURL . "networks/{$networkId}/keys/{$networkKeyId}");
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array("Authorization: Bearer $this->accessToken", "Accept: $this->acceptHeader", "Content-Type: $this->expectedResponseContentType"));
    curl_setopt($curl, CURLOPT_HEADER, true);

    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'PATCH');
    curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode(array("title"=>$newNetworkKeyTitle)));

    $response = curl_exec($curl);

    return $this->responseProcessor($response, $curl);
  }

  /**
   * Deletes a Network Key.
   *
   * @param string $networkId    The ID of the Network the Network Key is contained within.
   * @param string $networkKeyId The ID of the Network Key in question.
   *
   * @return array The API response, split into status, headers, and content.
   */
  function delete($networkId, $networkKeyId)
  {
    $curl = curl_init($this->apiURL . "networks/{$networkId}/keys/{$networkKeyId}");
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array("Authorization: Bearer $this->accessToken", "Accept: $this->acceptHeader"));
    curl_setopt($curl, CURLOPT_HEADER, true);

    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'DELETE');

    $response = curl_exec($curl);

    return $this->responseProcessor($response, $curl);
  }

}
