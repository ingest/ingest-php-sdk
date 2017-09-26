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

use IngestPHPSDK\NetworkKeys\NetworkKey;

$version = 'application/vnd.ingest.v1+json';
$token = ' ';

$networkKey = new NetworkKey($version, $token);

$networkId = '42ebe6ad-622d-4680-9e31-58fb2000b3ed';

$gettingAllNetworkKeys = $networkKey->getAll($networkId);

if($gettingAllNetworkKeys["status"] != "HTTP/1.1 200 OK")
{
  echo "Network Keys could not be retrieved: \n";
  var_dump($gettingAllNetworkKeys);
}

$key = <<<KEY
-----BEGIN PUBLIC KEY-----
MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQC6pJvDZT3L3NelUDJ9dTn7ta2W
lg7rm1Uei66MMEZp3u3CZl5A3iX7AAZULDkno3hvWU8GNtCoaOfy0MG0KtZIzLvS
+4dOr4UXov+Kv+fvwiteAqWAcRnOP+sZA1SagnYmrPOZPEKnLwgKvWnnqXKmQaTW
eXERvSobCVGCivtxoQIDAQAB
-----END PUBLIC KEY-----
KEY;

$creatingANetworkKey = $networkKey->add($networkId, $key);

if($creatingANetworkKey["status"] != "HTTP/1.1 201 Created")
{
  echo "Network Key could not be created: \n";
  var_dump($creatingANetworkKey);
}
else
{
  $networkKeyId = $creatingANetworkKey["content"]->id;
}

if(isset($networkKeyId))
{
  $gettingAllNetworkKeysById = $networkKey->getById($networkId, $networkKeyId);

  if($gettingAllNetworkKeysById["status"] != "HTTP/1.1 200 OK")
  {
    echo "Network Key $networkKeyId could not be retrieved: \n";
    var_dump($gettingAllNetworkKeysById);
  }

  $updatingANetworkKey = $networkKey->update($networkId, $networkKeyId, 'New Name');

  if($updatingANetworkKey["status"] != "HTTP/1.1 200 OK")
  {
    echo "Network Key $networkKeyId could not be updated: \n";
    var_dump($updatingANetworkKey);
  }

  $deletingANetworkKey = $networkKey->delete($networkId, $networkKeyId);

  if($deletingANetworkKey["status"] != "HTTP/1.1 202 Accepted")
  {
    echo "Network Key $networkKeyId could not be deleted: \n";
    var_dump($deletingANetworkKey);
  }
}
else
{
  echo "Network Key tests were not conducted due to creation failure. \n";
}
