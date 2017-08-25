<?php
/**
 * Jobs are composed of Inputs to synthesize, a Profile stating how they are to be synthesized, and a Video that is to be associated to their synthesized result.
 */

namespace IngestPHPSDK\Jobs;

class Job extends \IngestPHPSDK\AbstractAPIUtilities
{
  function __construct($version, $accessToken)
  {
    //set high-level vars
    parent::__construct($version, $accessToken);
  }

  /**
   * Returns a count of all Jobs your token has access to.
   *
   * @return array The API response, split into status, headers, and content.
   */
  function count()
  {
    $curl = curl_init($this->apiURL . "encoding/jobs");

    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array("Authorization: Bearer $this->accessToken", "Accept: $this->acceptHeader"));
    curl_setopt($curl, CURLOPT_HEADER, true);

    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'HEAD');

    $response = curl_exec($curl);

    return $this->responseProcessor($response, $curl);
  }

  /**
   * Returns information about all Jobs your token has access to.
   *
   * @return array The API response, split into status, headers, and content.
   */
  function getAll()
  {
    $curl = curl_init($this->apiURL . "encoding/jobs");

    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array("Authorization: Bearer $this->accessToken", "Accept: $this->acceptHeader"));
    curl_setopt($curl, CURLOPT_HEADER, true);

    $response = curl_exec($curl);

    return $this->responseProcessor($response, $curl);
  }

  /**
   * Creates a Job.
   *
   * @param array  $inputs    An array of Input IDs to synthesize.
   * @param string $profileId The ID of the Profile that controls how they are to be synthesized.
   * @param string $videoId   The ID of the Video the synthesized Inputs will be associated with.
   *
   * @return array The API response, split into status, headers, and content.
   */
  function add($inputs, $profileId, $videoId)
  {
    $curl = curl_init($this->apiURL . "encoding/jobs");
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode(array("inputs"=>$inputs, "profile"=>$profileId, "video"=>$videoId)));
    curl_setopt($curl, CURLOPT_HTTPHEADER, array("Authorization: Bearer $this->accessToken", "Accept: $this->acceptHeader", "Content-Type: $this->expectedResponseContentType"));
    curl_setopt($curl, CURLOPT_HEADER, true);

    $response = curl_exec($curl);

    return $this->responseProcessor($response, $curl);
  }

  /**
   * Returns a specific Job.
   *
   * @param string $jobId The ID of the Job you wish to retrieve.
   *
   * @return array The API response, split into status, headers, and content.
   */
  function getById($jobId)
  {
    $curl = curl_init($this->apiURL . "encoding/jobs/{$jobId}");

    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array("Authorization: Bearer $this->accessToken", "Accept: $this->acceptHeader"));
    curl_setopt($curl, CURLOPT_HEADER, true);

    $response = curl_exec($curl);

    return $this->responseProcessor($response, $curl);
  }

  /**
   * Deletes a Job.
   *
   * @param string $jobId The ID of the Job to delete.
   *
   * @return array The API response, split into status, headers, and content.
   */
  function delete($jobId)
  {
    $curl = curl_init($this->apiURL . "encoding/jobs/{$jobId}");
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array("Authorization: Bearer $this->accessToken", "Accept: $this->acceptHeader"));
    curl_setopt($curl, CURLOPT_HEADER, true);

    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'DELETE');

    $response = curl_exec($curl);

    return $this->responseProcessor($response, $curl);
  }

}
