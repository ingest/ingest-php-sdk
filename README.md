# PHP SDK For Ingest

Welcome to the PHP SDK for Ingest! This library has been made available to you so you can access the Ingest API simply via PHP code.

## Instantiating an Object

The files are laid out similarly to the Ingest API itself. To create a Video object *(or an Input, or a Profile, or any other object)* for your use:

```
<?php
use \IngestPHPSDK\Videos\Video;

$version = "application/vnd.ingest.v1+json";

$accessToken = "your.access_token.here";

$video = new Video($version, $accessToken);

$newVideo = $video->retrieveAll();
```

To instantiate a Video object, you must pass the API version you wish to use and a valid access token. This code would then return a list of all videos available to you, via the Ingest API. The response would be an associative array, with three elements:

* status
* headers
* content

**status** contains a string like *HTTP/1.1 200 OK*.

**headers** contains an associative array with an arbitrary number of elements. These elements have the header's name (like *Content-Type*) as the key, and the header's value (like *application/json*) as the value.

**content** contains whatever the API returned as the body of the response. Ingest sends the body as JSON, but the SDK decodes it to its PHP datatype, be that a string, an object, or an array. Of course, if it's an object or an array, it may contain other objects, strings, or arrays. Please check the Ingest documentation so you know what to expect.

If there was an authentication error, this will be reported to you in the **status** and **content** fields. There may also be information in the **headers** for some errors, like trying to query the API too often.

## Videos

### Retrieving a Video

To retrieve a video, pass the Video's ID to the *retrieve* function:

```<?php
use \IngestPHPSDK\Videos\Video;

$version = "application/vnd.ingest.v1+json";

$accessToken = "your.access_token.here";

$video = new Video($version, $accessToken);

$id = "8d790637-fc1c-4833-afe2-52f6a7957638";

$newVideo = $video->retrieve($id);
```

### Retrieving all Videos

To retrieve all videos, use the *retrieveAll* function:

```<?php
use \IngestPHPSDK\Videos\Video;

$version = "application/vnd.ingest.v1+json";

$accessToken = "your.access_token.here";

$video = new Video($version, $accessToken);

$newVideos = $video->retrieveAll();
```

## Inputs

### Creating an Input

To create an Input, pass a filename, type, and size to the *create* function:

```
$filename = "movie.mp4";
$type = "video/mp4";
$size = 54102

$newInput = $input->create($filename, $type, $size);
```

### Initializing an upload for an Input

Once you've created the Input, you can tell the API you'd like to begin uploading parts of it:

```
$inputId = "cdac2053-9740-4ce2-89e1-d88997c56463";
$size = 54102;
$type = "video/mp4";

$uploadData = $input->initializeUpload($inputId, $size, $type);
```

### Creating file parts

There are many ways you can do it, but one way is by passing through the file with `fseek()` and `fread()`. You can then keep the parts in memory, write them to disc, whatever you'd prefer.

You can use the `chunkFile` function provided by the SDK:

```
$input = new Input($version);

//size optional, defaults to 5,000,000 bytes
$input->chunkFile($filePath, $chunkSizeInBytes)
```

By default, this will separate the file into chunks of the specified size, and write these chunks to the current folder, with `chunk` appended. So *"testvideo.mp4"* would become *"testvideo_chunk1.mp4", "testvideo_chunk2.mp4", "testvideo_chunk3.mp4"...* and so on.

### Retrieving a signature for an Input

Once you have the URL to upload parts of your Input to, you'll need a signature for each part. It can be retrieved like so:

```
$inputId = "cdac2053-9740-4ce2-89e1-d88997c56463";
$partNumber = 1;
$uploadId = "7db00eb8-f2a2-41dc-a091-4811de5d65fb";
$contentMd5 = "Q2hlY2sgSW50ZWdyaXR5IQ=="; // Content-MD5 = md5 + base64: http://www.ietf.org/rfc/rfc1864.txt

$signature = retrieveSignatureForPart($inputId, $partNumber, $uploadId, $contentMd5)
```

`$contentMd5` is optional, but a nice way of ensuring your file was not corrupted en route to the destination server.

### Uploading an Input part

When you initialize an upload, you should receive in your response a URL pointing to Amazon S3, as well as several values that must be set as headers for Amazon to accept the upload.

To upload a part, provide:
* the aforementioned URL and header values
* the path of the part you will be uploading
* (if desired) the value to set for the *Content-MD5* header

For more info, visit Amazon's official documentation: http://docs.aws.amazon.com/AmazonS3/latest/API/mpUploadUploadPart.html

```
$s3URL = "https://s3.amazon.com/fake";
$file = "movie1.mp4"
$partNumber = 1;
$uploadId = "7db00eb8-f2a2-41dc-a091-4811de5d65fb";
$authorizationHeader = "whatever";
$xAmzDateHeader = "the API tells you";
$xAmzSecurityTokenHeader = "to send";
$md5Digest = "Q2hlY2sgSW50ZWdyaXR5IQ==";

$uploadResult = uploadPart($s3URL, $file, $partNumber, $uploadId, $authorizationHeader, $xAmzDateHeader, $xAmzSecurityTokenHeader, $md5Digest);
```

### Completing an upload for an Input

S3 doesn't know how many parts are in your upload, so you need to tell it when you're done. Compared to the upload process, it's pretty simple:

```
$inputId = "cdac2053-9740-4ce2-89e1-d88997c56463";
$uploadId = "7db00eb8-f2a2-41dc-a091-4811de5d65fb";

$completionResult = $input->completeUpload($inputId, $uploadId);
```

### Aborting an upload for an Input

Once an upload has started, it must be explicitly either completed or aborted. Otherwise the parts will just float around aimlessly on the server, taking up space and costing money.

```
$inputId = "cdac2053-9740-4ce2-89e1-d88997c56463";
$uploadId = "7db00eb8-f2a2-41dc-a091-4811de5d65fb";

$abortResult = $input->abortUpload($inputId, $uploadId);
```

### More coming soon!
