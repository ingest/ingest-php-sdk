<?php
/**
 * Networks are the main organizing resource in Ingest. These functions help you manage them.
 */

namespace IngestPHPSDK\Networks;

class Network extends \IngestPHPSDK\AbstractAPIUtilities
{

  function __construct($version, $accessToken, $sendRequestsToStaging = false)
  {
    //set high-level vars
    parent::__construct($version, $accessToken, $sendRequestsToStaging);
  }

  /**
   * Returns all the Networks your token has access to.
   *
   * @return array The API response, split into status, headers, and content.
   */
  function getAll()
  {
    $curl = curl_init($this->apiURL . "networks");
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array("Authorization: Bearer $this->accessToken", "Accept: $this->acceptHeader"));
    curl_setopt($curl, CURLOPT_HEADER, true);

    $response = curl_exec($curl);

    return $this->responseProcessor($response, $curl);
  }

  /**
   * Returns a specific Network.
   *
   * @param string $networkId The ID of the Network to retrieve.
   *
   * @return array The API response, split into status, headers, and content.
   */
  function getById($networkId)
  {
    $curl = curl_init($this->apiURL . "networks/{$networkId}");
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array("Authorization: Bearer $this->accessToken", "Accept: $this->acceptHeader"));
    curl_setopt($curl, CURLOPT_HEADER, true);

    $response = curl_exec($curl);

    return $this->responseProcessor($response, $curl);
  }

  /**
   * Allows you to update the properties of a Network.
   *
   * @param string $networkId The ID of the Network to update.
   * @param array  $body      The properties to update, and what to update them to.
   *
   * @return array The API response, split into status, headers, and content.
   */
  function update($networkId, $body)
  {
    $curl = curl_init($this->apiURL . "networks/{$networkId}");
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array("Authorization: Bearer $this->accessToken", "Accept: $this->acceptHeader", "Content-Type: $this->expectedResponseContentType"));
    curl_setopt($curl, CURLOPT_HEADER, true);

    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'PATCH');
    curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($body));

    $response = curl_exec($curl);

    return $this->responseProcessor($response, $curl);
  }

  /**
   * Allows you to invite someone to a Network by email.
   *
   * @param string $networkId        The ID of the Network they are being invited to.
   * @param string $invitedUserName  The name of the person being invited.
   * @param string $invitedUserEmail The email address of the person being invited.
   *
   * @return array The API response, split into status, headers, and content.
   */
  function inviteUser($networkId, $invitedUserName, $invitedUserEmail)
  {
    $curl = curl_init($this->apiURL . "networks/{$networkId}/invite");
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array("Authorization: Bearer $this->accessToken", "Accept: $this->acceptHeader", "Content-Type: $this->expectedResponseContentType"));
    curl_setopt($curl, CURLOPT_HEADER, true);

    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode(array("name"=>$invitedUserName, "email"=>$invitedUserEmail)));

    $response = curl_exec($curl);

    return $this->responseProcessor($response, $curl);
  }

  /**
   * Allows you to link an existing User to a Network.
   *
   * @param string $networkId    The ID of the Network they are being invited to.
   * @param string $linkedUserId The ID of the User being invited.
   *
   * @return array The API response, split into status, headers, and content.
   */
  function linkUser($networkId, $linkedUserId)
  {
    $curl = curl_init($this->apiURL . "networks/{$networkId}");
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array("Authorization: Bearer $this->accessToken", "Accept: $this->acceptHeader", "Content-Type: $this->expectedResponseContentType"));
    curl_setopt($curl, CURLOPT_HEADER, true);

    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'LINK');
    curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode(array("id"=>$linkedUserId)));

    $response = curl_exec($curl);

    return $this->responseProcessor($response, $curl);
  }

  /**
   * Allows you to unlink a User from a Network.
   *
   * @param string $networkId    The ID of the Network they are being unlinked from.
   * @param string $linkedUserId The ID of the User being unlinked.
   *
   * @return array The API response, split into status, headers, and content.
   */
  function unlinkUser($networkId, $unlinkedUserId)
  {
    $curl = curl_init($this->apiURL . "networks/{$networkId}");
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array("Authorization: Bearer $this->accessToken", "Accept: $this->acceptHeader", "Content-Type: $this->expectedResponseContentType"));
    curl_setopt($curl, CURLOPT_HEADER, true);

    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'UNLINK');
    curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode(array("id"=>$unlinkedUserId)));

    $response = curl_exec($curl);

    return $this->responseProcessor($response, $curl);
  }
}
