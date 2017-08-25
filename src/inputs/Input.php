<?php
/**
 * Inputs can be a variety of media, later synthesized through a Profile to be part of a Video resource.
 */

namespace IngestPHPSDK\Inputs;

class Input extends \IngestPHPSDK\AbstractAPIUtilities
{

  function __construct($version, $accessToken)
  {
    //set high-level vars
    parent::__construct($version, $accessToken);
  }

  /**
   * Returns a count of all Inputs your token has access to.
   *
   * @param string $filter (Optional) What to filter the results by (check main API documentation for options).
   *
   * @return array The API response, split into status, headers, and content.
   */
  function count($filter = null)
  {
    if ($filter == null)
    {
      $curl = curl_init($this->apiURL . "encoding/inputs");
    }
    else
    {
      $curl = curl_init($this->apiURL . "encoding/inputs?filter={$filter}");
    }

    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array("Authorization: Bearer $this->accessToken", "Accept: $this->acceptHeader"));
    curl_setopt($curl, CURLOPT_HEADER, true);

    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'HEAD');

    $response = curl_exec($curl);

    return $this->responseProcessor($response, $curl);
  }

  /**
   * Returns information about all Inputs your token has access to.
   *
   * @param string $filter (Optional) What to filter the results by (check main API documentation for options).
   * @param string $range  (Optional) The range to display in results, for pagination purposes. Check main API documentation for full details.
   *
   * @return array The API response, split into status, headers, and content.
   */
  function getAll($filter = null, $range = null)
  {
    if($filter == null)
    {
      $curl = curl_init($this->apiURL . "encoding/inputs");
    }
    else
    {
      $curl = curl_init($this->apiURL . "encoding/inputs?filter={$filter}");
    }

    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

    if($range != null)
    {
      curl_setopt($curl, CURLOPT_HTTPHEADER, array("Range: $range", "Authorization: Bearer $this->accessToken", "Accept: $this->acceptHeader"));
    }
    else
    {
      curl_setopt($curl, CURLOPT_HTTPHEADER, array("Authorization: Bearer $this->accessToken", "Accept: $this->acceptHeader"));
    }

    curl_setopt($curl, CURLOPT_HEADER, true);

    $response = curl_exec($curl);

    return $this->responseProcessor($response, $curl);
  }

  function getById($inputId)
  {
    $curl = curl_init($this->apiURL . "encoding/inputs/{$inputId}");
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array("Authorization: Bearer $this->accessToken", "Accept: $this->acceptHeader"));
    curl_setopt($curl, CURLOPT_HEADER, true);

    $response = curl_exec($curl);

    return $this->responseProcessor($response, $curl);
  }

  function create($filename, $type, $size)
  {
    $curl = curl_init($this->apiURL . "encoding/inputs");
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode(array("filename"=>$filename, "type"=>$type, "size"=>$size)));
    curl_setopt($curl, CURLOPT_HTTPHEADER, array("Authorization: Bearer $this->accessToken", "Accept: $this->acceptHeader", "Content-Type: $this->expectedResponseContentType"));
    curl_setopt($curl, CURLOPT_HEADER, true);

    $response = curl_exec($curl);

    return $this->responseProcessor($response, $curl);
  }

  function update($inputId, $body)
  {
    $curl = curl_init($this->apiURL . "encoding/inputs/$inputId");
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array("Authorization: Bearer $this->accessToken", "Accept: $this->acceptHeader", "Content-Type: $this->expectedResponseContentType"));
    curl_setopt($curl, CURLOPT_HEADER, true);

    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'PATCH');
    curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($body));

    $response = curl_exec($curl);

    return $this->responseProcessor($response, $curl);
  }

  function delete($inputId)
  {
    $curl = curl_init($this->apiURL . "encoding/inputs/$inputId");
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array("Authorization: Bearer $this->accessToken", "Accept: $this->acceptHeader"));
    curl_setopt($curl, CURLOPT_HEADER, true);

    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'DELETE');

    $response = curl_exec($curl);

    return $this->responseProcessor($response, $curl);
  }

  function initializeUpload($inputId, $size, $contentType, $uploadType)
  {
    $curl = curl_init($this->apiURL . "encoding/inputs/{$inputId}/upload?type={$uploadType}");
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode(array("size"=>$size, "type"=>$contentType)));
    curl_setopt($curl, CURLOPT_HTTPHEADER, array("Authorization: Bearer $this->accessToken", "Accept: $this->acceptHeader", "Content-Type: $this->expectedResponseContentType"));
    curl_setopt($curl, CURLOPT_HEADER, true);

    $response = curl_exec($curl);

    return $this->responseProcessor($response, $curl);
  }

  function retrieveSignatureForPart($inputId, $partNumber, $uploadId, $contentMd5, $uploadType)
  {
    $curl = curl_init($this->apiURL . "encoding/inputs/{$inputId}/upload/sign?type={$uploadType}");

    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array("Authorization: $authorizationHeader", "Accept: $this->acceptHeader", "Content-Type: $this->expectedResponseContentType"));
    curl_setopt($curl, CURLOPT_HEADER, true);

    if($uploadType == "amazonMP")
    {
      $body = array("partNumber"=>$partNumber, "uploadId"=>$uploadId);
      curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($body));
    }

    if(isset($contentMd5))
    {
      $headers[] = "ContentMd5: $contentMd5";
    }

    $response = curl_exec($curl);

    return $this->responseProcessor($response, $curl);
  }

  function uploadPart($s3URL, $filePath, $partNumber, $uploadId, $authorizationHeader, $xAmzDateHeader, $xAmzSecurityTokenHeader, $md5Digest)
  {
    //we're going straight to S3 in this step
    //so things look a little different

    $curl = curl_init($s3URL . "?partNumber={$partNumber}&uploadId={$uploadId}");
    curl_setopt($curl, CURLOPT_PUT,1);

    $fileStream = fopen($filePath, "r");
    curl_setopt($curl, CURLOPT_INFILE, $fileStream);

    $filesize = filesize($filePath);
    curl_setopt($curl, CURLOPT_INFILESIZE, $filesize);

    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

    $headers = array("Authorization: $authorizationHeader",
      "Accept: $this->acceptHeader",
      "Content-Type: $this->expectedResponseContentType",
      "Content-Length: $filesize",
      "x-amz-date: $xAmzDateHeader",
      "x-amz-security-token: $xAmzSecurityTokenHeader",
    );

    if(isset($md5Digest))
    {
      $headers[] = "Content-MD5: $md5Digest";
    }

    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    $response = curl_exec($curl);

    return $this->responseProcessor($response, $curl);
  }

  function completeUpload($inputId, $uploadId)
  {
    $curl = curl_init($this->apiURL . "encoding/inputs/{$inputId}/upload/complete");
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode(array("uploadId"=>$uploadId)));
    curl_setopt($curl, CURLOPT_HTTPHEADER, array("Authorization: Bearer $this->accessToken", "Accept: $this->acceptHeader", "Content-Type: $this->expectedResponseContentType"));
    curl_setopt($curl, CURLOPT_HEADER, true);

    $response = curl_exec($curl);

    return $this->responseProcessor($response, $curl);

  }

  function abortUpload($inputId, $uploadId)
  {
    $curl = curl_init($this->apiURL . "encoding/inputs/{$inputId}/upload/abort?type=amazonMP");
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode(array("uploadId"=>$uploadId)));
    curl_setopt($curl, CURLOPT_HTTPHEADER, array("Authorization: Bearer $this->accessToken", "Accept: $this->acceptHeader", "Content-Type: $this->expectedResponseContentType"));
    curl_setopt($curl, CURLOPT_HEADER, true);

    $response = curl_exec($curl);

    return $this->responseProcessor($response, $curl);
  }
}
