# PHP SDK For Ingest

Welcome to the PHP SDK for Ingest! This library has been made available to you so you can access the Ingest API simply via PHP code.

## Instantiating an Object

The files are laid out similarly to the Ingest API itself. To create a Video object for your use:

```<?php
require_once("Video.class.php");

$video = new Video($version, $credentials, $jwt);

$newVideo = $video->retrieve($id);
```

To instantiate a Video object, you must pass the API version you wish to use, and at least one of the following:

* your application credentials (an associative array with the keys *grant_type*, *client_id*, *client_secret*, and optionally *redirect_uri*, and their corresponding values)
* a valid Ingest JWT (JSON Web Token, more info available at https://jwt.io)

Assuming authentication goes well, and you pass a valid Video ID, this code would return a Video to you, via the Ingest API. The response would be an associative array, with three elements:

* status
* headers
* content

**status** contains a string like *HTTP/1.1 200 OK*.

**headers** contains an associative array with an arbitrary number of elements. These elements have the header's name (like *Content-Type*) as the key, and the header's value (like *application/json*) as the value.

**content** contains whatever the API returned as the body of the response. Ingest sends the body as JSON, but the SDK decodes it to its PHP datatype, be that a string, an object, or an array. Of course, if it's an object or an array, it may contain other objects, strings, or arrays. Please check the Ingest documentation so you know what to expect.

If there was an authentication error, this will be reported to you in the **status** and **content** fields. There may also be information in the **headers** for some errors, like trying to authenticate too often.

## Videos

### Retrieving a Video

To retrieve a video, pass the Video's ID to the *retrieve* function:

```<?php
require_once("Video.class.php");

$video = new Video($version, $credentials, $jwt);

$newVideo = $video->retrieve($id);
```

## Inputs

### Creating an Input

### Initializing an upload for an Input

### Retrieving a signature for an Input

### Uploading an Input part

### Completing an upload for an Input

### Aborting an upload for an Input

### More coming soon!
