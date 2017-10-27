# PHP SDK For Ingest

Welcome to the PHP SDK for Ingest! This library has been made available to you so you can access the Ingest API simply via PHP code.

## Installation

Importing our SDK into your PHP project is super easy with Composer (https://getcomposer.org). Just run the following command:

```
composer require ingest/php-sdk
```

and you're done!

## Instantiating an Object

The files are laid out similarly to the Ingest API itself. To create a Video object *(or an Input, or a Profile, or any other object)* for your use:

```
<?php

require dirname(__DIR__) . '/vendor/autoload.php';

use \IngestPHPSDK\videos\Video;

$version = "application/vnd.ingest.v1+json";

$accessToken = "your.access_token.here";

$video = new Video($version, $accessToken);

$allVideos = $video->getAll();
```

To instantiate a Video object, you must pass the API version you wish to use and a valid access token. This code would then return a list of all videos available to you, via the Ingest API. The response would be an associative array, with three elements:

* status
* headers
* content

**status** contains a string like *HTTP/1.1 200 OK*.

**headers** contains an associative array with an arbitrary number of elements. These elements have the header's name (like *Content-Type*) as the key, and the header's value (like *application/json*) as the value.

**content** contains whatever the API returned as the body of the response. Ingest sends the body as JSON, but the SDK decodes it to its PHP datatype, be that a string, an object, or an array. Of course, if it's an object or an array, it may contain other objects, strings, or arrays. Please check the Ingest documentation so you know what to expect.

If there was an authentication error, this will be reported to you in the **status** and **content** fields. There may also be information in the **headers** for some errors, like trying to query the API too often; also, for the *count()* methods below, the count will be returned in a header (usually *Resource-Count*, but check the main API documentation to be sure).

## Videos

### Retrieving all Videos

The default method is:

```
$allVideos = $video->getAll();
```

This will return a list of all the videos you can access.

Sometimes, the results will be paginated. In order to access the next page, pass the value that was provided to you on the *Next-Range* header as an argument:

```
$allVideos = $video->getAll(array("range"=>"contents of Next-Range"));
```

To search, provide a string contained in the title *(Note: queries are trimmed of leading and trailing whitespace before submission)*:

```
$allVideos = $video->getAll(array("search"=>'Inges'));
```

You can also filter by status (check the main API for a list of valid statuses):

```
$allVideos = $video->getAll(array("status"=>'draft'));
```

And by whether a video requires a playback token or not (i.e. private):

```
$allVideos = $video->getAll(array("private"=>true));
```

### Retrieving a Video

```
$id = "8d790637-fc1c-4833-afe2-52f6a7957638";

$requestedVideo = $video->getById($id);
```

### Creating a Video

Title is the only mandatory property, please check the main API documentation for a full list:

```
$video->add(array("title"=>"I Am Jack's Inability To Come Up With A Clever Test Title"));
```

### Counting Videos

You can count all the videos you have access to:

```
$video->count();
```

Filter them by status (check main API documentation for a full list):

```
$video->count('draft');
```

And filter them by whether they require a playback token or not (known as "private"):

```
$video->count('draft', true);
$video->count(null, true);
```

### Get a Video's thumbnails

```
$video->getThumbnails('113b2c94-e605-4075-bf83-b57c2428f0e8');
```

### Get a Video's variants

```
$video->getVariants('113b2c94-e605-4075-bf83-b57c2428f0e8');
```

### Adding external thumbnails to a Video

You can provide multiple external thumbnails in the supplied array, or just one:

```
$video->addExternalThumbnails('113b2c94-e605-4075-bf83-b57c2428f0e8', array("https://image.shutterstock.com/z/stock-vector-wow-73726918.jpg"));
```

### Uploading a thumbnail to a Video

```
$video->uploadThumbnail('113b2c94-e605-4075-bf83-b57c2428f0e8', 'daisy.jpg');
```

### Deleting a thumbnail from a Video

If you attempt to delete a Video's only thumbnail, you will raise an error:

```
$video->deleteThumbnail('113b2c94-e605-4075-bf83-b57c2428f0e8', '4cbac085-e064-4729-b49a-4811c12cf311');
```

### Updating a Video

Provide the property name, and the desired new value:

```
$video->update('113b2c94-e605-4075-bf83-b57c2428f0e8', array("title"=>"newTitle"));
```

### Deleting a Video

By default, this merely puts the video in Ingest's trash, making it publicly inaccessible and set for permanent deletion a short time from now:

```
$video->delete('113b2c94-e605-4075-bf83-b57c2428f0e8');
```

If you wish to permanently delete the video immediately, pass in a *1* as the second argument:

```
$video->delete('113b2c94-e605-4075-bf83-b57c2428f0e8', 1);
```

**PLEASE BE VERY CAREFUL WITH THIS.**

## Networks

### Retrieving all Networks

```
$allNetworks = $network->getAll();
```

### Retrieving a Network

```
$id = "8d790637-fc1c-4833-afe2-52f6a7957638";

$requestedNetwork = $network->getById($id);
```

### Updating a Network

Properties available to be updated can be found in the main API documentation:

```
$networkId = "8d790637-fc1c-4833-afe2-52f6a7957638";
$body = array("thingYouWantToChange"=>"thing's new value");

$updatedNetwork = $network->update($networkId, $body);
```

### Inviting a User to a Network
```
$networkId = "8d790637-fc1c-4833-afe2-52f6a7957638";
$invitedUserName = "Person YouWantToInvite";
$invitedUserEmail = "their@email.com";

$result = $network->inviteUser($networkId, $invitedUserName, $invitedUserEmail);
```

### Linking a User to a Network
```
$networkId = "8d790637-fc1c-4833-afe2-52f6a7957638";
$userId = "8fc890ae-75e4-4d60-8c53-22bf2e9bd4e2";

$result = $network->linkUser($networkId, $userId);
```

### Unlinking a User from a Network
```
$networkId = "8d790637-fc1c-4833-afe2-52f6a7957638";
$userId = "8fc890ae-75e4-4d60-8c53-22bf2e9bd4e2";

$result = $network->unlinkUser($networkId, $userId);
```

## Inputs

### Creating an Input

To create an Input, pass a filename, type, and size to the *create* function:

```
$filename = "bunnySmall.mp4";
$type = "video/mp4";
$size = 1057551;

$newInput = $input->create($filename, $type, $size);
```

### Initializing an upload for an Input

Once you've created the Input, you can tell the API you'd like to begin uploading parts of it:

```
$inputId = "2d01e2c8-fbb6-4b7b-9855-8c75aa59ec18";
$size = 1057551;
$contentType = "video/mp4";
$uploadType = "amazon";

$uploadData = $input->initializeUpload($inputId, $size, $contentType, $uploadType);
```

To begin a multi-part upload, pass `amazonMP` as the _$contentType_ argument.

### Creating file parts

There are many ways you can do it, but one way is by passing through the file with `fseek()` and `fread()`. You can then keep the parts in memory, write them to disc, whatever you'd prefer.

You can use the `chunkFile` function provided by the SDK:

```
$input = new Input($version);

//size optional, defaults to 5,000,000 bytes
$input->chunkFile($filePath, $chunkSizeInBytes)
```

By default, this will separate the file into chunks of the specified size, and write these chunks to the current folder, with `chunk` appended. So *"testvideo.mp4"* would become *"testvideo_chunk1.mp4", "testvideo_chunk2.mp4", "testvideo_chunk3.mp4"...* and so on.

### Retrieving a signature for an Input (Multi-Part)

Once you've initialized the upload, you'll need a signature for each part, as well as an upload URL. They can be retrieved like so:

```
$inputId = "cdac2053-9740-4ce2-89e1-d88997c56463";
$uploadType = "amazonMP";
$partNumber = 1;
$uploadId = "7db00eb8-f2a2-41dc-a091-4811de5d65fb";

$signature = $input->retrieveSignatureForPart($inputId, $uploadType, $partNumber, $uploadId);
```

### Retrieving a signature for an Input (Single-Part)

Once you've initialized the upload, you'll need a signature for each part, as well as an upload URL. They can be retrieved like so:

```
$inputId = "2d01e2c8-fbb6-4b7b-9855-8c75aa59ec18";
$uploadType = "amazon";

$signature = $input->retrieveSignatureForPart($inputId, $uploadType);
```

### Uploading an Input part

When you sign an upload, you should receive in your response a URL pointing to Amazon S3, as well as several values that must be set as headers for Amazon to accept the upload.

To upload a part, provide:
* the aforementioned URL and header values
* the path of the part you will be uploading

For more info, visit Amazon's official documentation: http://docs.aws.amazon.com/AmazonS3/latest/API/mpUploadUploadPart.html

```
$s3URL = "https://s3.amazonaws.com/...";
$filePath = "filename_chunk1.mp4";
$authorizationHeader = "AWS ...";
$xAmzDateHeader = "Thu, 21 Sep 2017 13:27:14 +0000";
$xAmzSecurityTokenHeader = "Tm93IHRoaXMgaXMgdGhlIHN0b3J5IGFsbCBhYm91dCBob3cKTXkgbGlmZSBnb3QgZmxpcHBlZCwgdHVybmVkIHVwc2lkZSBkb3duCkFuZCBJJ2QgbGlrZSB0byB0YWtlIGEgbWludXRlIGp1c3Qgc2l0IHJpZ2h0IHRoZXJlCkknbGwgdGVsbCB5b3UgaG93IEkgYmVjYW1lIHRoZSBwcmluY2Ugb2YgYSB0b3duIGNhbGxlZCBCZWwgQWlyCgo=";

$uploadResult = $input->uploadPart($s3URL, $filePath, $authorizationHeader, $xAmzDateHeader, $xAmzSecurityTokenHeader);
```

### Completing an upload for an Input

If you've initialized a multi-part upload, S3 doesn't know when you're done, so you need to tell it. Compared to the upload process so far, this last bit is pretty simple:

```
$inputId = "cdac2053-9740-4ce2-89e1-d88997c56463";
$uploadId = "7db00eb8-f2a2-41dc-a091-4811de5d65fb";

$completionResult = $input->completeUpload($inputId, $uploadId);
```

### Aborting an upload for an Input

Once a multi-part upload has started, it must be explicitly either completed or aborted. Otherwise the parts will just float around aimlessly on the server, taking up space and costing money.

```
$inputId = "cdac2053-9740-4ce2-89e1-d88997c56463";
$uploadId = "7db00eb8-f2a2-41dc-a091-4811de5d65fb";

$abortResult = $input->abortUpload($inputId, $uploadId);
```

### Counting Inputs

To count the number of inputs available, you can optionally filter them by a set of filters available in the main API documentation:

```
$input->count();
$input->count('trashed');
```

### Retrieving all Inputs

This retrieval method also supports filtering:

```
$input->getAll();
$input->getAll('new');
```

### Retrieving an Input

```
$input->getById('17577b37-7e31-428d-88be-64ebedb531e7');
```

### Updating an Input

Properties available to be updated can be found in the main API documentation:

```
$inputId = '17577b37-7e31-428d-88be-64ebedb531e7';
$body = array("type"=>"video/mp4");

$input->update($inputId, $body);
```

### Deleting an Input

```
$inputId = '17577b37-7e31-428d-88be-64ebedb531e7';

$input->delete($inputId);
```

## Profiles

### Counting Profiles

To count all the Profiles you have access to:

```
$profile->count();
```

You can also return only deleted Profiles:
```
$profile->count('trashed');
```

### Retrieving all Profiles

To fetch details of all the Profiles you have access to:

```
$profile->getAll();
```

You can also return only deleted Profiles:

```
$profile->getAll('trashed');
```

Or search for Profiles by title (note that queries are stripped of leading and trailing whitespace before submission):

```
$profile->getAll(null, 'apple');
```

### Retrieving a Profile

To fetch details of a specific profile:

```
$response = $profile->getById('3035a523-0fc9-4c82-94a8-a56bd46f280c');
```

### Creating a Profile

To create a Profile, simply provide the requisite information (check the main API documentation for a full schema):

*Note: Profile names can only contain alphanumeric characters, whitespace, and dashes. No punctuation (ex. "Ingest's New Profile").*

```
$profileData = array(
  "name"=>"Ingest Profile",
  "text_tracks"=>array(
    "webvtt",
    "dfxp"
  ),
  "digital_rights"=>array(
    "type"=>"mpeg_cenc",
    "data"=>array(
      "licence_server_url"=>"valid url here"
    )
  ),
  "type"=>"mp4",
  "data"=>array(
    "what_your_data_is_depends_on"=>"your_type"
  )
);


$profile->add($profileData);
```

### Updating a Profile

Unlike many entity types in Ingest, Profiles must be updated by passing the full object to the API. This is necessary to ensure all parts remain in a compatible state.

Here's a simple way of complying with the requirement:

```
$response = $profile->getById('3035a523-0fc9-4c82-94a8-a56bd46f280c');

//in production code, you should also check the Status and Headers array elements
//for errors and/or potentially important information
$profileToUpdate = $response["content"];

$profileToUpdate->name = "Ingest Profile New Name";

//provide the Profile ID, and the full Profile object
$profile->update('3035a523-0fc9-4c82-94a8-a56bd46f280c', $profileToUpdate);
```

### Deleting a Profile

To disable a Profile, simply provide its ID:

```
$profile->delete('3035a523-0fc9-4c82-94a8-a56bd46f280c');
```

## Jobs

### Counting Jobs

To count all the Jobs you have access to:

```
$job->count();
```

### Retrieving all Jobs

To fetch details of all the Jobs you have access to:

```
$job->getAll();
```

### Retrieving a Job

To fetch details of a specific job:

```
$response = $job->getById('3035a523-0fc9-4c82-94a8-a56bd46f280c');
```

### Creating a Job

To create a Job, simply provide the requisite information (check the main API documentation for a full schema):

```
$inputs = array('17577b37-7e31-428d-88be-64ebedb531e7', '73a9eedb-e9b7-4586-a8bf-24daa85202fb');
$video = 'dc606ed9-393f-4e2c-9675-5f918a0f8c94';
$profile = '3817a152-4248-4bf7-a5a8-25b89b51fd31';

$job->add($inputs, $video, $profile);
```

### Deleting a Job

To delete a Job, simply provide its ID:

```
$job->delete('3035a523-0fc9-4c82-94a8-a56bd46f280c');
```

## Network Keys

### Retrieving all Network Keys

To fetch details of all the Network Keys you have access to, provide the Network ID:

```
$networkKey->getAll('42ebe6ad-622d-4680-9e31-58fb2000b3ed');
```

### Retrieving a Network Key

To fetch details of a Network Key, provide the Network ID and the ID of the relevant Network Key:

```
$networkKey->getById('42ebe6ad-622d-4680-9e31-58fb2000b3ed', '7c4df655-e2e9-4fba-a49e-3b265216bf9b');
```

### Creating a Network Key

To create a Network Key, provide the Network ID, the key itself, and (optionally) a name:

```
$key = "For details on key format, please refer to the main API documentation, or the Ingest general help section.";

$networkKey->add('42ebe6ad-622d-4680-9e31-58fb2000b3ed', $key);
$networkKey->add('42ebe6ad-622d-4680-9e31-58fb2000b3ed', $key, 'Optional Key Title');
```

### Updating a Network Key

You cannot update the actual key portion of a Network Key (instead, create a new key, activate it, and delete the old one), but you can update the title:

```
$networkKey->update('2f13d69f-98cf-445f-8568-a2fea8ac565c', '7c4df655-e2e9-4fba-a49e-3b265216bf9b', 'New Title');
```

### Deleting a Network Key

To delete a Network Key, simply provide its ID, along with the ID of its associated Network:

```
$networkKey->delete('42ebe6ad-622d-4680-9e31-58fb2000b3ed', '7c4df655-e2e9-4fba-a49e-3b265216bf9b');
```

## Users

### Counting Users

To retrieve a count of all Users you have access to:

```
$user->count();
```

### Retrieving all Users

To retrieve basic information about all Users you have access to:

```
$user->getAll();
```

### Retrieving a User

To retrieve detailed information about a specific User:

```
$user->getById('ea2ed255-310c-4426-9881-c4fe8fab4ae1');
```

### Retrieving the current User

To retrieve detailed information about the User whose authorization token was passed with the request:

```
$user->getCurrentUserInfo();
```

### Updating a User

To update a User, provide the User's ID, as well as the properties to be updated. Properties available to be updated can be found in the main API documentation:

```
$user->update('ea2ed255-310c-4426-9881-c4fe8fab4ae1', array("name"=>"New N. Ame"));
```

### Transferring User Authorship

To transfer authorship of a User's Videos to another User, provide the ID of the User being transferred from, and the ID of the User being transferred to:

```
$user->transferUserAuthorship('ea2ed255-310c-4426-9881-c4fe8fab4ae1', '837052dc-e65d-4b1e-84ac-c7befe9bd8f6');
```

### Revoking a User's session token

This will log the User out:

```
$user->revokeUser('ea2ed255-310c-4426-9881-c4fe8fab4ae1');
```

### Revoking the current User's session token

Note that this will invalidate the token currently being used, requiring you to re-instantiate the User object with a new token:

```
$user->revokeCurrentUser();
```

## Events

### Counting Events

To retrieve a count of all the Events that have occurred in your Network:

```
$event->count();
```

### Retrieving all Event types

To retrieve a list of possible Event types:

```
$event->getTypes();
```

### Retrieving all Events

To retrieve details on all Events that have occurred in your Network:

```
$event->getAll();
```

### Retrieving an Event

To retrieve details about a specific Event:

```
$event->getById('dcdeeef8-bda5-4c46-aa5e-8d4e069dc360');
```

### More coming soon!
