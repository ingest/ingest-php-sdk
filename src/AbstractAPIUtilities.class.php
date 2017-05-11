<?php

abstract class AbstractAPIUtilities
{
  function __construct($version, $credentials, $jwt)
  {
    //set some defaults
    $this->apiURL = "https://api.ingest.io/";
    $this->acceptHeader = $version;

    //determine if we're acting as an application or a user
    //aka read-only or read-write
    if(isset($jwt))
    {
      $this->jwt = $jwt;
    }
    else
    {
      $this->jwt = $this->authenticate($credentials);

      if($this->jwt["error"])
      {
        return "Could not construct object, error in authentication: " . $this->jwt["errorCode"] . " - " . $this->jwt["errorMessage"];
      }
      else
      {
        $this->jwt = $this->jwt["jwt"];
      }
    }
  }

  function authenticate($credentials)
  {
    $curl = curl_init();

    $url = "https://login.ingest.io/token?grant_type={$credentials["grant_type"]}&client_id={$credentials["client_id"]}&client_secret={$credentials["client_secret"]}";

    if(isset($credentials["redirect_uri"]))
    {
      $url .= "&redirect_uri={$credentials["redirect_uri"]}";
    }

    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, "{}");
    curl_setopt($curl, CURLOPT_HTTPHEADER, array("Authorization: Bearer $this->jwt", "Accept: $this->acceptHeader", "Content-Type: application/json"));
    curl_setopt($curl, CURLOPT_HEADER, true);

    $response = curl_exec($curl);

    $response = $this->responseProcessor($response, $curl);

    //grab status code off return
    preg_match('/HTTP\/[^ ]* ([^ ]*) (.*)/', $response["status"], $matches);

    if($matches[1] >= 400)
    {
      return array("error"=>true, "errorCode"=>$matches[1], "errorMessage"=>$matches[2]);
    }
    else
    {
      //this may be the wrong access notation
      //but it's close enough for now
      return array("error"=>false, "jwt"=>$response["content"]->access_token);
    }
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
