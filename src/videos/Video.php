<?php
/**
 * Videos are a central resource in Ingest, so there are a number of important functions contained here.
 */

namespace IngestPHPSDK\Videos;

class Video extends \IngestPHPSDK\AbstractAPIUtilities
{
  function __construct($version, $accessToken)
  {
    //set high-level vars
    parent::__construct($version, $accessToken);
  }

  /**
   * Returns all the Videos your token has access to.
   *
   * @param array $options An array of various options for Video retrieval. It has more options than most resource fetches, hence their being condensed into an array. Check the main API documentation for full details.
   *
   * @return array The API response, split into status, headers, and content.
   */
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

  /**
   * Returns information about a specific Video.
   *
   * @param string $videoId The ID of the Video in question.
   *
   * @return array The API response, split into status, headers, and content.
   */
  function getById($videoId)
  {
    $curl = curl_init($this->apiURL . "videos/{$videoId}");
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array("Authorization: Bearer $this->accessToken", "Accept: $this->acceptHeader"));
    curl_setopt($curl, CURLOPT_HEADER, true);

    $response = curl_exec($curl);

    return $this->responseProcessor($response, $curl);
  }

  /**
   * Returns a count of all the Videos your token has access to.
   *
   * @param string $status  A status to filter results by. Check main API documentation for options.
   * @param string $private Whether to return videos that require a playback token or not. Check main API documentation for options.
   *
   * @return array The API response, split into status, headers, and content.
   */
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

  /**
   * Creates a Video.
   *
   * @param array $videoData The data required to create a Video. Check main API documentation for details.
   *
   * @return array The API response, split into status, headers, and content.
   */
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

  /**
   * Returns thumbnails for a specific Video.
   *
   * @param string $videoId The ID of the Video in question.
   *
   * @return array The API response, split into status, headers, and content.
   */
  function getThumbnails($videoId)
  {
    $curl = curl_init($this->apiURL . "videos/{$videoId}/thumbnails");
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array("Authorization: Bearer $this->accessToken", "Accept: $this->acceptHeader"));
    curl_setopt($curl, CURLOPT_HEADER, true);

    $response = curl_exec($curl);

    return $this->responseProcessor($response, $curl);
  }

  /**
   * Returns playlists for a specific Video.
   *
   * @param string $videoId The ID of the Video in question.
   *
   * @return array The API response, split into status, headers, and content.
   */
  function getPlaylists($videoId)
  {
    $curl = curl_init($this->apiURL . "videos/{$videoId}/playlists");
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array("Authorization: Bearer $this->accessToken", "Accept: $this->acceptHeader"));
    curl_setopt($curl, CURLOPT_HEADER, true);

    $response = curl_exec($curl);

    return $this->responseProcessor($response, $curl);
  }

  /**
   * Adds thumbnails to a Video retrieved from an external source, as opposed to uploading them from your computer.
   *
   * @param string $videoId        The ID of the Video in question.
   * @param array  $thumbnailLinks An array of image URLs.
   *
   * @return array The API response, split into status, headers, and content.
   */
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

  /**
   * Adds thumbnails to a Video from an image your computer.
   *
   * @param string $videoId  The ID of the Video in question.
   * @param string $filepath The filepath of the image to upload.
   * @param string $fileType The type of the file. Check main API documentation for options.
   *
   * @return array The API response, split into status, headers, and content.
   */
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

  /**
   * Delete thumbnail from a Video.
   *
   * @param string $videoId     The ID of the Video in question.
   * @param string $thumbnailId The ID of the thumbnail to delete.
   *
   * @return array The API response, split into status, headers, and content.
   */
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

  /**
   * Returns variants for a specific Video.
   *
   * @param string $videoId The ID of the Video in question.
   *
   * @return array The API response, split into status, headers, and content.
   */
  function getVariants($videoId)
  {
    $curl = curl_init($this->apiURL . "videos/{$videoId}/variants");
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array("Authorization: Bearer $this->accessToken", "Accept: $this->acceptHeader"));
    curl_setopt($curl, CURLOPT_HEADER, true);

    $response = curl_exec($curl);

    return $this->responseProcessor($response, $curl);
  }

  /**
   * Deletes a Video.
   *
   * @param string $videoId   The ID of the Video to delete.
   * @param int    $permanent Whether the Video should be deleted immediately, or simply disabled and deleted at some point in the future (check main API documentation for details).
   *
   * @return array The API response, split into status, headers, and content.
   */
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

  /**
   * Allows you to update the properties of a Video.
   *
   * @param string $videoId The ID of the Video to update.
   * @param array  $body   The properties to update, and what to update them to.
   *
   * @return array The API response, split into status, headers, and content.
   */
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
