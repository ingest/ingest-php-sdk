<?php
namespace IngestPHPSDK;

abstract class AbstractAPIUtilities
{
  function __construct($version)
  {
    //set some defaults
    $this->apiURL = "https://api.ingest.info/";
    $this->acceptHeader = $version;
  }

  function chunkFile($filePath, $chunkSize = 5000000)
  {
    //figure out how many chunks are needed
    $numChunks = ceil(filesize($filePath)/$chunkSize);

    //open the handle of the source file
    $handle = fopen($filePath, "rb");

    for ($i=0; $i < $numChunks ; $i++)
    {
      //open the handle of the chunk
      //set filename to original filename, without leading folders or trailing extension, followed by _chunk and the chunk number
      $chunkNumber = $i + 1;
      $chunkHandle = fopen(basename($filePath, ".".pathinfo($filePath, PATHINFO_EXTENSION))."_chunk{$chunkNumber}.".pathinfo($filePath, PATHINFO_EXTENSION), "wb");

      //read chunk data into memory
      $contents = fread($handle, $chunkSize);

      //write chunk to disc (optional, you could do this all in memory if you wanted)
      fwrite($chunkHandle, $contents);

      //close chunk handle
      fclose($chunkHandle);
    }

    //close source file handle
    fclose($handle);

  }

  function generateTokens($refreshToken, $clientId, $clientSecret)
  {
    $curl = curl_init();

    $url = "https://login.ingest.info/token?grant_type=refresh_token&client_id={$clientId}&client_secret={$clientSecret}&refresh_token={$refreshToken}";

    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_HEADER, true);

    $response = curl_exec($curl);

    return $this->responseProcessor($response, $curl);

  }

  function setAccessToken($accessToken)
  {
    $this->accessToken = $accessToken;
  }

  //takes in response string and curl handle
  //returns formatted array
  function responseProcessor($response, $curl)
  {
    //grab content length
    $contentLength = curl_getinfo($curl, CURLINFO_CONTENT_LENGTH_DOWNLOAD);

    //sometimes, no Content-Length header
    if(is_null($contentLength))
    {
      $contentLength = strlen($response) - strpos($response, "\r\n\r\n");
    }

    //split response into content and headers
    //count backwards from end of string, then json_decode result
    $content = json_decode(substr($response, $contentLength * -1));
    //reverse of getting content
    $headersString = substr($response, 0, strlen($response) - $contentLength);

    //explode headers string into array
    $headersArray = explode("\n", $headersString);
    $headers = array();

    //grab status code
    $status = trim(array_shift($headersArray));

    foreach($headersArray as $headerArrayElement)
    {
      //don't process newlines or empty lines
      if(!empty(trim($headerArrayElement)))
      {
        //split header into name and value
        //e.g. "Content-Type: application/json"
        //only grabs first instance, in case value contains colons (like a URL, for instance)
        $splitPoint = strpos($headerArrayElement, (": "));

        //split same as content vs headers
        $headerName = substr($headerArrayElement, 0, $splitPoint);
        //trim off leading ": "
        $headerValue = substr($headerArrayElement, $splitPoint + 2);

        //assign key/value pairs, trim excessive whitespace
        $headers[$headerName] = trim($headerValue);
      }
    }

    //put it all together, send it back from whence it came
    $formattedResponse = array("status"=>$status, "headers"=>$headers, "content"=>$content);

    //close here rather than closing in calling context
    curl_close($curl);

    return $formattedResponse;
  }
}
