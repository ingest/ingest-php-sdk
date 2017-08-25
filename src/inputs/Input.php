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

  /**
   * Returns information about a specific Input.
   *
   * @param string $inputId The ID of the Input in question.
   *
   * @return array The API response, split into status, headers, and content.
   */
  function getById($inputId)
  {
    $curl = curl_init($this->apiURL . "encoding/inputs/{$inputId}");
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array("Authorization: Bearer $this->accessToken", "Accept: $this->acceptHeader"));
    curl_setopt($curl, CURLOPT_HEADER, true);

    $response = curl_exec($curl);

    return $this->responseProcessor($response, $curl);
  }

  /**
   * Create an Input.
   *
   * @param string $filename The name of the file to be created as an Input.
   * @param string $type     The file type (check main API documentation for options).
   * @param string $size     The file size, in bytes.
   *
   * @return array The API response, split into status, headers, and content.
   */
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

  /**
   * Allows you to update the properties of a Input.
   *
   * @param string $inputId The ID of the Input to update.
   * @param array  $body    The properties to update, and what to update them to.
   *
   * @return array The API response, split into status, headers, and content.
   */
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

  /**
   * Deletes an Input.
   *
   * @param string $inputId The ID of the Input to delete.
   *
   * @return array The API response, split into status, headers, and content.
   */
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

  /**
   * Initializes an upload to Ingest.
   *
   * @param string $networkId   The ID of the Network the file will be uploaded to.
   * @param string $size        The file size, in bytes.
   * @param string $contentType The type of content that will be uploaded (check main API documentation for details).
   * @param string $uploadType  The type of upload that will be performed (check main API documentation for details).
   *
   * @return array The API response, split into status, headers, and content.
   */
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

  /**
   * Retrieves the Ingest upload signature for each individual file part.
   *
   * @param string $inputId    The ID of the Input the file is a part of.
   * @param string $partNumber The number of this particular file part.
   * @param string $uploadId   The ID of the upload this part is involved in.
   * @param string $contentMd5 What will be in the ContentMd5 header (check main API documentation for details).
   * @param string $uploadType The type of upload that will be performed (check main API documentation for details).
   *
   * @return array The API response, split into status, headers, and content.
   */
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

  /**
   * Upload a part to Ingest.
   *
   * @param string $s3URL                   The URL you have been provided with to upload the part (check main API documentation for details).
   * @param string $filePath                The location of the file part.
   * @param string $partNumber              The number of the part in the upload.
   * @param string $uploadId                The ID of the upload the part is involved in.
   * @param string $authorizationHeader     The header previously provided (check main API documentation for details).
   * @param string $xAmzDateHeader          The header previously provided (check main API documentation for details).
   * @param string $xAmzSecurityTokenHeader The header previously provided (check main API documentation for details).
   * @param string $md5Digest               What the contents of the Content-MD5 header will be (check main API documentation for details).
   *
   * @return array The API response, split into status, headers, and content.
   */
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

  /**
   * Completes an upload.
   *
   * @param string $inputId  The ID of the Input being uploaded.
   * @param string $uploadId The ID of the upload being conducted.
   *
   * @return array The API response, split into status, headers, and content.
   */
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

  /**
   * Completes an upload.
   *
   * @param string $inputId  The ID of the Input being uploaded.
   * @param string $uploadId The ID of the upload being conducted.
   *
   * @return array The API response, split into status, headers, and content.
   */
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
