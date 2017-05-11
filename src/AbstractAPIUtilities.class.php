<?php

abstract class AbstractAPIUtilities
{
  function __construct($jwt, $version)
  {
    $this->apiURL = "https://api.ingest.io/";
    $this->acceptHeader = $version;
    $this->jwt = $jwt;
  }

  //for refresh tokens
  function setJWT($jwt)
  {
    $this->jwt = $jwt;
  }

  //takes in response string and curl handle
  //returns formatted array
  function responseProcessor($response, $curl)
  {
    //grab content length
    $contentLength = curl_getinfo($curl, CURLINFO_CONTENT_LENGTH_DOWNLOAD);

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
