<?php

require dirname(__DIR__) . '/vendor/autoload.php';

use IngestPHPSDK\NetworkKeys\NetworkKey;

$version = 'application/vnd.ingest.v1+json';
$token = 'eyJhbGciOiJSUzI1NiIsInR5cCI6IkpXVCJ9.eyJhdWQiOiJodHRwczovLyouaW5nZXN0LmluZm8iLCJjaWQiOiJJbmdlc3REYXNoYm9hcmQiLCJleHAiOjE1MDM2NzgwMTQsImp0aSI6IjI4OGIxNDA2LTFlZDYtNDhiZi05MDA5LTdkZGI1ZmZjOTZlZCIsImlhdCI6MTUwMzU5MTYxNCwiaXNzIjoiaHR0cHM6Ly9sb2dpbi5pbmdlc3QuaW5mbyIsIm50dyI6IjQyZWJlNmFkLTYyMmQtNDY4MC05ZTMxLTU4ZmIyMDAwYjNlZCIsInNjb3BlIjp7ImFjdGlvbnMiOlsicGVyc29uYWwiLCJyZWFkX2JpbGxpbmciLCJyZWFkX2NsaWVudHMiLCJyZWFkX2V2ZW50cyIsInJlYWRfaG9va3MiLCJyZWFkX2lucHV0cyIsInJlYWRfam9icyIsInJlYWRfbGl2ZSIsInJlYWRfbmV0S2V5cyIsInJlYWRfbmV0d29ya3MiLCJyZWFkX3BsYXlsaXN0cyIsInJlYWRfcHJvZmlsZXMiLCJyZWFkX3VzZXJzIiwicmVhZF92aWRlb3MiLCJ3cml0ZV9iaWxsaW5nIiwid3JpdGVfY2xpZW50cyIsIndyaXRlX2hvb2tzIiwid3JpdGVfaW5wdXRzIiwid3JpdGVfam9icyIsIndyaXRlX2xpdmUiLCJ3cml0ZV9sb2NrZWRfcHJvZmlsZXMiLCJ3cml0ZV9uZXRLZXlzIiwid3JpdGVfbmV0d29ya3MiLCJ3cml0ZV9wbGF5bGlzdHMiLCJ3cml0ZV9wcm9maWxlcyIsIndyaXRlX3VzZXJzIiwid3JpdGVfdmlkZW9zIl19LCJzdWIiOiJlYTJlZDI1NS0zMTBjLTQ0MjYtOTg4MS1jNGZlOGZhYjRhZTEifQ.cvhn-YM-56Asq3yF4SdjEOzWd6VE-AVcnAAVxHxqjhVlE6YDlWLzyUthiAkLmQi0fAJoqXiYGv0oP3fRrJcf1SHAwai301gq1yZOKGbkB-9-N2IALsgKa_ClafPsoc06G6wIuhQ7_KbCPxqYgzyR-tnP59oqJjEkQegw8FkSLB_TFNiHPlWbrj6OG3xd0BH5KTi-u0oFNDwFHlWoofqOlXTD0bsfokGfAykX1w1FMVjiukkwoBuNDyqSjtpRIDUKtj5tp9fnJDvr3vMAEK4EmO15pZaOrMtj5O1AtLYY1FdWxyIxoxscJCmkAnJS3BeryKmqJTu4wZE_LWmdCEePew';

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
