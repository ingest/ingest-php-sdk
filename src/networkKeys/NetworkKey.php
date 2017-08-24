<?php
namespace IngestPHPSDK\NetworkKeys;

class NetworkKey extends \IngestPHPSDK\AbstractAPIUtilities
{
  function __construct($version, $accessToken)
  {
    //set high-level vars
    parent::__construct($version, $accessToken);
  }

  function getAll($networkId)
  {
    $curl = curl_init($this->apiURL . "networks/{$networkId}/keys");

    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array("Authorization: Bearer $this->accessToken", "Accept: $this->acceptHeader"));
    curl_setopt($curl, CURLOPT_HEADER, true);

    $response = curl_exec($curl);

    return $this->responseProcessor($response, $curl);
  }

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

  function getById($networkId, $networkKeyId)
  {
    $curl = curl_init($this->apiURL . "networks/{$networkId}/keys/{$networkKeyId}");

    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array("Authorization: Bearer $this->accessToken", "Accept: $this->acceptHeader"));
    curl_setopt($curl, CURLOPT_HEADER, true);

    $response = curl_exec($curl);

    return $this->responseProcessor($response, $curl);
  }

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
