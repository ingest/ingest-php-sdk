<?php

require_once("../AbstractAPIUtilities.class.php");

class Input extends AbstractAPIUtilities
{

  function __construct($jwt, $version)
  {
    //set high-level vars
    parent::__construct($jwt, $version);
  }

  function tgTest()
  {
    $curl = curl_init("http://api.tgdevsql002.trackgrptest.com/v1/device/");
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array("Authorization: JWT $this->jwt"));
    curl_setopt($curl, CURLOPT_HEADER, true);

    $response = curl_exec($curl);

    return $this->responseProcessor($response, $curl);
  }

  function create($filename, $type, $size)
  {
    $curl = curl_init($this->apiURL . "encoding/inputs/");
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(array("filename"=>$filename, "type"=>$type, "size"=>$size)));
    curl_setopt($curl, CURLOPT_HTTPHEADER, array("Authorization: Bearer $this->jwt", "Accept: $this->acceptHeader", "Content-Type: application/json"));
    curl_setopt($curl, CURLOPT_HEADER, true);

    $response = curl_exec($curl);

    return $this->responseProcessor($response, $curl);
  }

  function initializeUpload($inputId, $size, $type)
  {
    //we're doing only multi-part uploads for now
    //if we need <5MB video uploads, we'll add them later
    $curl = curl_init($this->apiURL . "encoding/inputs/{$inputId}/upload?type=amazonMP");
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(array("size"=>$size, "type"=>$type)));
    curl_setopt($curl, CURLOPT_HTTPHEADER, array("Authorization: Bearer $this->jwt", "Accept: $this->acceptHeader", "Content-Type: application/json"));
    curl_setopt($curl, CURLOPT_HEADER, true);

    $response = curl_exec($curl);

    return $this->responseProcessor($response, $curl);
  }

  function retrieveSignatureForPart($inputId, $partNumber, $uploadId, $contentMd5)
  {
    $curl = curl_init($this->apiURL . "encoding/inputs/{$inputId}/upload/sign?type=amazonMP");

    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array("Authorization: $authorizationHeader", "Accept: $this->acceptHeader", "Content-Type: application/json"));
    curl_setopt($curl, CURLOPT_HEADER, true);

    $body = array("partNumber"=>$partNumber, "uploadId"=>$uploadId);

    if(isset($contentMd5))
    {
      $headers[] = "ContentMd5: $contentMd5";
    }

    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($body));

    $response = curl_exec($curl);

    return $this->responseProcessor($response, $curl);
  }

  function uploadPart($s3URL, $file, $partNumber, $uploadId, $authorizationHeader, $xAmzDateHeader, $xAmzSecurityTokenHeader, $md5Digest)
  {
    //we're going straight to S3 in this step
    //so things look a little different

    $curl = curl_init($s3URL . "?partNumber={$partNumber}&uploadId={$uploadId}");
    curl_setopt($curl, CURLOPT_PUT,1);
    curl_setopt($curl, CURLOPT_INFILE, $file);

    $filesize = filesize($file);

    curl_setopt($curl, CURLOPT_INFILESIZE, $filesize);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

    //s3 format
    //ex. Mon, 1 Nov 2010 20:34:56 +0000
    $date = date(DATE_RSS);

    $headers = array("Authorization: $authorizationHeader", "Accept: $this->acceptHeader", "Content-Type: application/json", "Content-Length: $filesize", "Date: $date");

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
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(array("uploadId"=>$uploadId)));
    curl_setopt($curl, CURLOPT_HTTPHEADER, array("Authorization: Bearer $this->jwt", "Accept: $this->acceptHeader", "Content-Type: application/json"));
    curl_setopt($curl, CURLOPT_HEADER, true);

    $response = curl_exec($curl);

    return $this->responseProcessor($response, $curl);

  }

  function abortUpload($inputId, $uploadId)
  {
    $curl = curl_init($this->apiURL . "encoding/inputs/{$inputId}/upload/abort?type=amazonMP");
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(array("uploadId"=>$uploadId)));
    curl_setopt($curl, CURLOPT_HTTPHEADER, array("Authorization: Bearer $this->jwt", "Accept: $this->acceptHeader", "Content-Type: application/json"));
    curl_setopt($curl, CURLOPT_HEADER, true);

    $response = curl_exec($curl);

    return $this->responseProcessor($response, $curl);
  }
}
