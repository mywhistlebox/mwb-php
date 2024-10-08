# mwb-php

The MyWhistleBox PHP SDK makes it simpler to integrate your PHP applications using the MyWhistleBox REST API. Using the SDK, you will be able to upload files to you box or others, send requests and much more.

## Installation

To install the SDK, you will need to be using [Composer](http://getcomposer.org/)
in your project.
If you aren't using Composer yet, it's really simple! Here's how to install
composer:

```bash
curl -sS https://getcomposer.org/installer | php
```

## Required minimum php version
 - minimum php version 7.4

### Steps to install the SDK Package

- To install the **stable release**, run the following command in your project directory:
        
        $ composer require mywhistlebox/mwb-php

## Getting started

### Authentication

To make the API requests, you need to create a `MwbClient` and provide it with an apikey which can be obtained from your MyWhistleBox Account Settings (API Key tab).  Only Enterprise plans will have access to the required keys.

We recommend that you store your credentials in the `MWB_AUTH_KEY` environment variable, so as to avoid the possibility of accidentally committing them to source control. If you do this, you can initialise the client with no arguments and it will automatically fetch them from the environment variable.

```php
<?php
require 'vendor/autoload.php';
use Mwb\MwbClient;

$client = new MwbClient("<apikey>");
```

### Client Methods

Once you create a client instance, you can use it to call MyWhistleBox methods.  The list of methods is described at <a href="https://github.com/mywhistlebox/mwb-php/blob/main/methods.md">here</a>.

### Method Response

All methods return a json object in the following general format.

```php
Response {
    status: "ok",
    key: object | value,
    ....
}
```

in addition, if a method results in an error, the response will look like:

```php
Response {
    status: "error",
    code: <error code string>,
    message: <error message string>
}
```

## Simple Ping Test
To make sure you are authenicating properly, we recommend using the Ping method as a test. A simple Ping test may look like so:

```php
<?php
require 'vendor/autoload.php';
use Mwb\MwbClient;

$client = new MwbClient(APIKEY);
$response = $client->ping();
if ($response['status'] == 'ok') {
    echo "RESULT: Server has been pinged successfully<br>\n";
} else {
    if ($response['status'] == 'access') {
        echo "ERROR: Access denied.  Please check your ApiKey<br>\n";
    } else {
        echo "ERROR:". $response['message'];
    }
}
```

## Examples

### List Boxes

```php
<?php
require 'vendor/autoload.php';
use Mwb\MwbClient;

$client = new MwbClient(APIKEY);
$response =  $client->listBoxes();
if ($response['status'] == 'ok') {
   print_r($response);
} else {
    if ($response['status'] == 'access') {
        echo "ERROR: Access denied.  Please check your ApiKey<br>\n";
    } else {
        echo "ERROR:". $response['message'];
    }
}
```

### Send an upload request

```php
<?php
require 'vendor/autoload.php';
use Mwb\MwbClient;

$client = new MwbClient(APIKEY);
$response =  $client->requestUpload(<box_id>, <email_address>);
if ($response['status'] == 'ok') {
   print_r($response);
} else {
    if ($response['status'] == 'access') {
        echo "ERROR: Access denied.  Please check your ApiKey<br>\n";
    } else {
        echo "ERROR:". $response['message'];
    }
}
```

## Reporting issues
Report any feedback or problems with this version by [opening an issue on Github](https://github.com/mywhistlebox/mwb-php/issues).

