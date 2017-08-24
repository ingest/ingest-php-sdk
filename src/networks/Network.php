<?php
namespace IngestPHPSDK\Networks;

class Network extends \IngestPHPSDK\AbstractAPIUtilities
{

  function __construct($version, $accessToken)
  {
    //set high-level vars
    parent::__construct($version, $accessToken);
  }

  function getAll()
  {
    $curl = curl_init($this->apiURL . "networks");
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array("Authorization: Bearer $this->accessToken", "Accept: $this->acceptHeader"));
    curl_setopt($curl, CURLOPT_HEADER, true);

    $response = curl_exec($curl);

    return $this->responseProcessor($response, $curl);
  }

  function getById($networkId)
  {
    $curl = curl_init($this->apiURL . "networks/{$networkId}");
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array("Authorization: Bearer $this->accessToken", "Accept: $this->acceptHeader"));
    curl_setopt($curl, CURLOPT_HEADER, true);

    $response = curl_exec($curl);

    return $this->responseProcessor($response, $curl);
  }

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
