<?php
/**
 * Users are entities able to create and manipulate resources within your Ingest account, according to their permissions. These functions help manage them.
 */

namespace IngestPHPSDK\Users;

class User extends \IngestPHPSDK\AbstractAPIUtilities
{
  function __construct($version, $accessToken)
  {
    //set high-level vars
    parent::__construct($version, $accessToken);
  }

  /**
   * Returns a count of all Users your token has access to.
   *
   * @return array The API response, split into status, headers, and content.
   */
  function count()
  {
    $curl = curl_init($this->apiURL . "users");

    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array("Authorization: Bearer $this->accessToken", "Accept: $this->acceptHeader"));
    curl_setopt($curl, CURLOPT_HEADER, true);

    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'HEAD');

    $response = curl_exec($curl);

    return $this->responseProcessor($response, $curl);
  }

  /**
   * Returns information about the User whose token is passed with the request.
   *
   * @return array The API response, split into status, headers, and content.
   */
  function getCurrentUserInfo()
  {
    $curl = curl_init($this->apiURL . "users/me");

    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array("Authorization: Bearer $this->accessToken", "Accept: $this->acceptHeader"));
    curl_setopt($curl, CURLOPT_HEADER, true);

    $response = curl_exec($curl);

    return $this->responseProcessor($response, $curl);

  }

  /**
   * Returns information about the User whose ID is passed with the request.
   *
   * @return array The API response, split into status, headers, and content.
   */
  function getById($userId)
  {
    $curl = curl_init($this->apiURL . "users/{$userId}");

    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array("Authorization: Bearer $this->accessToken", "Accept: $this->acceptHeader"));
    curl_setopt($curl, CURLOPT_HEADER, true);

    $response = curl_exec($curl);

    return $this->responseProcessor($response, $curl);
  }

  /**
   * Returns information about all Users your token has access to.
   *
   * @return array The API response, split into status, headers, and content.
   */
  function getAll()
  {
    $curl = curl_init($this->apiURL . "users");

    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array("Authorization: Bearer $this->accessToken", "Accept: $this->acceptHeader"));
    curl_setopt($curl, CURLOPT_HEADER, true);

    $response = curl_exec($curl);

    return $this->responseProcessor($response, $curl);
  }

  /**
   * Allows you to update the properties of a User.
   *
   * @param string $userId The ID of the User to update.
   * @param array  $body   The properties to update, and what to update them to.
   *
   * @return array The API response, split into status, headers, and content.
   */
  function update($userId, $body)
  {
    $curl = curl_init($this->apiURL . "users/{$userId}");
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array("Authorization: Bearer $this->accessToken", "Accept: $this->acceptHeader", "Content-Type: $this->expectedResponseContentType"));
    curl_setopt($curl, CURLOPT_HEADER, true);

    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'PATCH');
    curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($body));

    $response = curl_exec($curl);

    return $this->responseProcessor($response, $curl);

  }

  /**
   * Allows you to transfer authorship of resources like Videos from User to User.
   *
   * @param string $UserIdTransferredFrom The ID of the User that currently has the authorship.
   * @param string $UserIdTransferredTo The ID of the User that will get the authorship.
   *
   * @return array The API response, split into status, headers, and content.
   */
  function transferUserAuthorship($UserIdTransferredFrom, $UserIdTransferredTo)
  {
    $curl = curl_init($this->apiURL . "users/{$UserIdTransferredFrom}/transfer/{$UserIdTransferredTo}");
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array("Authorization: Bearer $this->accessToken", "Accept: $this->acceptHeader"));
    curl_setopt($curl, CURLOPT_HEADER, true);

    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'PATCH');

    $response = curl_exec($curl);

    return $this->responseProcessor($response, $curl);
  }

  /**
   * Revokes the token passed with the request.
   *
   * @return array The API response, split into status, headers, and content.
   */
  function revokeCurrentUser()
  {
    $curl = curl_init($this->apiURL . "users/me/revoke");
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array("Authorization: Bearer $this->accessToken", "Accept: $this->acceptHeader"));
    curl_setopt($curl, CURLOPT_HEADER, true);

    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'DELETE');

    $response = curl_exec($curl);

    return $this->responseProcessor($response, $curl);
  }

  /**
   * Revokes the session of the User whose ID is provided.
   *
   * @param string $userId The ID of the User whose session will be revoked.
   *
   * @return array The API response, split into status, headers, and content.
   */
  function revokeUser($userId)
  {
    $curl = curl_init($this->apiURL . "users/{$userId}/revoke");
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array("Authorization: Bearer $this->accessToken", "Accept: $this->acceptHeader"));
    curl_setopt($curl, CURLOPT_HEADER, true);

    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'DELETE');

    $response = curl_exec($curl);

    return $this->responseProcessor($response, $curl);
  }

}
