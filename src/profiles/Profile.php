<?php
/**
 * Profiles control the settings by which Inputs are synthesized into outputs, which are then associated to Videos.
 */

namespace IngestPHPSDK\Profiles;

class Profile extends \IngestPHPSDK\AbstractAPIUtilities
{
  function __construct($version, $accessToken, $sendRequestsToStaging = false)
  {
    //set high-level vars
    parent::__construct($version, $accessToken, $sendRequestsToStaging);
  }

  /**
   * Returns a count of all Profiles your token has access to.
   *
   * @param string $filter (Optional) A filter for the Profiles that are displayed. See main API documentation for options.
   *
   * @return array The API response, split into status, headers, and content.
   */
  function count($filter = null)
  {
    if($filter != null)
    {
      $curl = curl_init($this->apiURL . "encoding/profiles?filter={$filter}");
    }
    else
    {
      $curl = curl_init($this->apiURL . "encoding/profiles");
    }

    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array("Authorization: Bearer $this->accessToken", "Accept: $this->acceptHeader"));
    curl_setopt($curl, CURLOPT_HEADER, true);

    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'HEAD');

    $response = curl_exec($curl);

    return $this->responseProcessor($response, $curl);
  }

  /**
   * Returns information about all Profiles your token has access to.
   *
   * @param string $filter (Optional) A filter for the Profiles that are displayed. See main API documentation for options.
   * @param string $filter (Optional) The string by which Profile titles are searched for.
   *
   * @return array The API response, split into status, headers, and content.
   */
  function getAll($filter = null, $search = null)
  {
    $queryString = "?";

    if ($filter != null)
    {
      $queryString .= "filter={$filter}";

      if ($search != null)
      {
        $queryString .= "&";
      }
    }

    if ($search != null)
    {
      $queryString .= "search=" . urlencode(trim($search));
    }

    $curl = curl_init($this->apiURL . "encoding/profiles" . $queryString);

    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array("Authorization: Bearer $this->accessToken", "Accept: $this->acceptHeader"));
    curl_setopt($curl, CURLOPT_HEADER, true);

    $response = curl_exec($curl);

    return $this->responseProcessor($response, $curl);
  }

  /**
   * Creates a Profile.
   *
   * @param array $body The data required to create a Profile. Check main API documentation for details.
   *
   * @return array The API response, split into status, headers, and content.
   */
  function add($body)
  {
    $curl = curl_init($this->apiURL . "encoding/profiles");
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($body));
    curl_setopt($curl, CURLOPT_HTTPHEADER, array("Authorization: Bearer $this->accessToken", "Accept: $this->acceptHeader", "Content-Type: $this->expectedResponseContentType"));
    curl_setopt($curl, CURLOPT_HEADER, true);

    $response = curl_exec($curl);

    return $this->responseProcessor($response, $curl);
  }

  /**
   * Returns a specific Profile.
   *
   * @param string $profileId The ID of the Profile you wish to retrieve.
   *
   * @return array The API response, split into status, headers, and content.
   */
  function getById($profileId)
  {
    $curl = curl_init($this->apiURL . "encoding/profiles/{$profileId}");

    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array("Authorization: Bearer $this->accessToken", "Accept: $this->acceptHeader"));
    curl_setopt($curl, CURLOPT_HEADER, true);

    $response = curl_exec($curl);

    return $this->responseProcessor($response, $curl);
  }

  /**
   * Allows you to update the properties of a Profile.
   *
   * @param string $profileId The ID of the Profile to update.
   * @param array  $body      The full Profile object, including updated properties. This is different from many resource update functions, due to the complexity of Profiles.
   *
   * @return array The API response, split into status, headers, and content.
   */
  function update($profileId, $body)
  {
    $curl = curl_init($this->apiURL . "encoding/profiles/{$profileId}");
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array("Authorization: Bearer $this->accessToken", "Accept: $this->acceptHeader", "Content-Type: $this->expectedResponseContentType"));
    curl_setopt($curl, CURLOPT_HEADER, true);

    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'PUT');
    curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($body));

    $response = curl_exec($curl);

    return $this->responseProcessor($response, $curl);
  }

  /**
   * Deletes a Profile.
   *
   * @param string $profileId The ID of the Profile that will be deleted.
   *
   * @return array The API response, split into status, headers, and content.
   */
  function delete($profileId)
  {
    $curl = curl_init($this->apiURL . "encoding/profiles/{$profileId}");
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array("Authorization: Bearer $this->accessToken", "Accept: $this->acceptHeader"));
    curl_setopt($curl, CURLOPT_HEADER, true);

    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'DELETE');

    $response = curl_exec($curl);

    return $this->responseProcessor($response, $curl);
  }
}
