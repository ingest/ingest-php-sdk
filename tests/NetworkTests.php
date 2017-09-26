<?php
/**
 * A series of tests to ensure proper functionality of the Ingest API and its SDK.
 *
 * The tests follow a consistent structure:
 * - instantiate the object
 * - call the method
 * - check the returned value against the expected value
 * - if not expected, notify
 *
 * Some tests depend on other tests having previously executed successfully, such as deleting a previously created resource.
 *
 * Some tests, such as Events, rely on the user providing test data, as it cannot be created.
 */

require dirname(__DIR__) . '/vendor/autoload.php';

use IngestPHPSDK\Networks\Network;

$version = 'application/vnd.ingest.v1+json';
$token = ' ';

$network = new Network($version, $token);

$networkId = '42ebe6ad-622d-4680-9e31-58fb2000b3ed';

$gettingAllNetworks = $network->getAll();

if($gettingAllNetworks["status"] != "HTTP/1.1 200 OK")
{
  echo "Networks could not be retrieved: \n";
  var_dump($gettingAllNetworks);
}

$gettingAllNetworksById = $network->getById($networkId);

if($gettingAllNetworksById["status"] != "HTTP/1.1 200 OK")
{
  echo "Network Key $networkKeyId could not be retrieved: \n";
  var_dump($gettingAllNetworksById);
}

$updatingANetwork = $network->update($networkId, array("name"=>"new name"));

if($updatingANetwork["status"] != "HTTP/1.1 200 OK")
{
  echo "Network $networkId could not be updated: \n";
  var_dump($updatingANetwork);
}

$invitedUserName = "Person YouWantToInvite";
$invitedUserEmail = "their@email.com";

$invitingAUser = $network->inviteUser($networkId, $invitedUserName, $invitedUserEmail);

if($invitingAUser["status"] != "HTTP/1.1 204 No Content")
{
  echo "User $invitedUserName at $invitedUserEmail could not be invited to Network {$networkId}: \n";
  var_dump($invitingAUser);
}

$userId = "8fc890ae-75e4-4d60-8c53-22bf2e9bd4e2";

$linkingAUser = $network->linkUser($networkId, $userId);

if($linkingAUser["status"] != "HTTP/1.1 200 OK")
{
  echo "User $userId could not be linked to Network {$networkId}: \n";
  var_dump($linkingAUser);
}

$unlinkingAUser = $network->unlinkUser($networkId, $userId);

if($unlinkingAUser["status"] != "HTTP/1.1 200 OK")
{
  echo "User $userId could not be unlinked from Network {$networkId}: \n";
  var_dump($unlinkingAUser);
}
