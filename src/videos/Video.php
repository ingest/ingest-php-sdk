<?php
namespace IngestPHPSDK\Videos;

class Video extends \IngestPHPSDK\AbstractAPIUtilities
{
  function __construct($version, $accessToken)
  {
    //set high-level vars
    parent::__construct($version, $accessToken);
  }

  function getAll($options = null)
  {

    $search = $options["search"];
    $status = $options["status"];
    $private = $options["private"];
    $range = $options["range"];

    $queryString = "?";

    if (isset($search))
    {
      $queryString .= "search=" . urlencode(trim($search));

      if (isset($status) || isset($private))
      {
        $queryString .= "&";
      }
    }

    if (isset($status))
    {
      $queryString .= "status={$status}";

      if (isset($private))
      {
        $queryString .= "&";
      }
    }

    if (isset($private))
    {
      $queryString .= "private={$private}";
    }

    $curl = curl_init($this->apiURL . "videos" . $queryString);

    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

    if(isset($range))
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

  function getById($videoId)
  {
    $curl = curl_init($this->apiURL . "videos/{$videoId}");
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array("Authorization: Bearer $this->accessToken", "Accept: $this->acceptHeader"));
    curl_setopt($curl, CURLOPT_HEADER, true);

    $response = curl_exec($curl);

    return $this->responseProcessor($response, $curl);
  }

  function count($status = null, $private = null)
  {
    $queryString = "?";

    if ($status != null)
    {
      $queryString .= "status={$status}";

      if ($private != null)
      {
        $queryString .= "&";
      }
    }

    if ($private != null)
    {
      $queryString .= "private={$private}";
    }

    $curl = curl_init($this->apiURL . "videos" . $queryString);

    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array("Authorization: Bearer $this->accessToken", "Accept: $this->acceptHeader"));
    curl_setopt($curl, CURLOPT_HEADER, true);

    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'HEAD');

    $response = curl_exec($curl);

    return $this->responseProcessor($response, $curl);
  }

  function add($videoData)
  {
    $curl = curl_init($this->apiURL . "videos");
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($videoData));
    curl_setopt($curl, CURLOPT_HTTPHEADER, array("Authorization: Bearer $this->accessToken", "Accept: $this->acceptHeader", "Content-Type: $this->expectedResponseContentType"));
    curl_setopt($curl, CURLOPT_HEADER, true);

    $response = curl_exec($curl);

    return $this->responseProcessor($response, $curl);
  }

  function getThumbnails($videoId)
  {
    $curl = curl_init($this->apiURL . "videos/{$videoId}/thumbnails");
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array("Authorization: Bearer $this->accessToken", "Accept: $this->acceptHeader"));
    curl_setopt($curl, CURLOPT_HEADER, true);

    $response = curl_exec($curl);

    return $this->responseProcessor($response, $curl);
  }

  function getPlaylists($videoId)
  {
    $curl = curl_init($this->apiURL . "videos/{$videoId}/playlists");
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array("Authorization: Bearer $this->accessToken", "Accept: $this->acceptHeader"));
    curl_setopt($curl, CURLOPT_HEADER, true);

    $response = curl_exec($curl);

    return $this->responseProcessor($response, $curl);
  }

  function addExternalThumbnails($videoId, $thumbnailLinks)
  {
    $curl = curl_init($this->apiURL . "videos/{$videoId}/thumbnails");
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($thumbnailLinks));
    curl_setopt($curl, CURLOPT_HTTPHEADER, array("Authorization: Bearer $this->accessToken", "Accept: $this->acceptHeader", "Content-Type: $this->expectedResponseContentType"));
    curl_setopt($curl, CURLOPT_HEADER, true);

    $response = curl_exec($curl);

    return $this->responseProcessor($response, $curl);
  }

  //not working yet
  function uploadThumbnail($videoId, $filePath, $fileType)
  {
    $cFile = curl_file_create($filePath);

    $image = array('type' => $fileType ,'image'=> $cFile);

    $curl = curl_init($this->apiURL . "videos/{$videoId}/thumbnail");

    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $image);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array("Authorization: Bearer $this->accessToken", "Accept: $this->acceptHeader", "Content-Type: multipart/form-data"));
    curl_setopt($curl, CURLOPT_HEADER, true);

    $response = curl_exec($curl);


    return $this->responseProcessor($response, $curl);

  }

  function deleteThumbnail($videoId, $thumbnailId)
  {
    $curl = curl_init($this->apiURL . "videos/{$videoId}/thumbnail/{$thumbnailId}");
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array("Authorization: Bearer $this->accessToken", "Accept: $this->acceptHeader"));
    curl_setopt($curl, CURLOPT_HEADER, true);

    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'DELETE');

    $response = curl_exec($curl);

    return $this->responseProcessor($response, $curl);
  }

  function getVariants($videoId)
  {
    $curl = curl_init($this->apiURL . "videos/{$videoId}/variants");
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array("Authorization: Bearer $this->accessToken", "Accept: $this->acceptHeader"));
    curl_setopt($curl, CURLOPT_HEADER, true);

    $response = curl_exec($curl);

    return $this->responseProcessor($response, $curl);
  }

  function delete($videoId, $permanent = null)
  {

    $queryString = "?";

    if($permanent != null)
    {
      $queryString .= "permanent={$permanent}";
    }

    $curl = curl_init($this->apiURL . "videos/{$videoId}" . $queryString);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array("Authorization: Bearer $this->accessToken", "Accept: $this->acceptHeader"));
    curl_setopt($curl, CURLOPT_HEADER, true);

    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'DELETE');

    $response = curl_exec($curl);

    return $this->responseProcessor($response, $curl);
  }

  function update($videoId, $body)
  {
    $curl = curl_init($this->apiURL . "videos/{$videoId}");
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array("Authorization: Bearer $this->accessToken", "Accept: $this->acceptHeader", "Content-Type: $this->expectedResponseContentType"));
    curl_setopt($curl, CURLOPT_HEADER, true);

    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'PATCH');
    curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($body));

    $response = curl_exec($curl);

    return $this->responseProcessor($response, $curl);
  }
}
