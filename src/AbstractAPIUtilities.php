<?php
namespace IngestPHPSDK;

abstract class AbstractAPIUtilities
{
  function __construct($version, $accessToken)
  {
    //set some defaults
    $this->apiURL = "https://api.ingest.io/";
    $this->acceptHeader = $version;
    $this->accessToken = $accessToken;
    $this->expectedResponseContentType = "application/json";
  }

  /**
   * Creates chunks of arbitrary size from an input file, for use in multi-part uploads.
   *
   * @param string $filePath  Where the file to chunk is located.
   * @param int    $chunkSize (Optional) The desired chunk size in bytes.
   */
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

  /**
   * Converts raw cURL response string into structured array.
   *
   * @param string $response The raw cURL response string.
   * @param string $curl     The cURL handle (so it's closed here, not left up to the developer to remember).
   *
   * @return array The API response, split into status, headers, and content.
   */
  //takes in response string and curl handle
  //returns formatted array
  function responseProcessor($response, $curl)
  {
    if(preg_match("/^HTTP\/1\.1 100 Continue\r\n\r\n/", $response) === 1)
    {
      //take off 100 Continue responses
      $response = substr($response, strpos($response, "100 Continue") + 16);
    }

    //would like to use Content-Length header
    //not reliably provided
    $contentLength = strlen($response) - strpos($response, "\r\n\r\n");

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
