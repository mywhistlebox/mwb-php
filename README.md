# mwb-php

The MyWhistleBox PHP SDK makes it simpler to integrate your PHP applications using the MyWhistleBox REST API. Using the SDK, you will be able to upload files to you box or others, send requests and much more.

**Supported PHP Versions**: This SDK works with PHP 7.3+.

## Installation

### Steps to install the SDK Package

- To install the **stable release**, run the following command in the project directory:
        
        $ composer require mywhistlebox/mwb-php

## Getting started

### Authentication

To make the API requests, you need to create a `RestClient` and provide it with authentication credentials (which can be found at [https://console.mywhistlebox.com/dashboard/](https://console.mywhistlebox.com/dashboard/)).

We recommend that you store your credentials in the `MWB_AUTH_ID` and the `MWB_AUTH_TOKEN` environment variables, so as to avoid the possibility of accidentally committing them to source control. If you do this, you can initialise the client with no arguments and it will automatically fetch them from the environment variables:

```php
<?php
require 'vendor/autoload.php';
use mywhistlebox\RestClient;

$client = new RestClient();
```

Alternatively, you can specifiy the authentication credentials while initializing the `RestClient`.

```php
<?php
require 'vendor/autoload.php';
use mywhistlebox\RestClient;

$client = new RestClient("<auth_id>", "<auth_token>");
```

## The Basics
The SDK uses consistent interfaces to create, retrieve, update, delete and list resources. The pattern followed is as follows:

```php
<?php
$client->resources->create($params) # Create
$client->resources->get($id) # Get
$client->resources->update($id, $params) # Update
$client->resources->delete($id) # Delete
$client->resources->list() # List all resources, max 20 at a time
```

You can also use the `resource` directly to update and delete it. For example,

```php
<?php
$resource = $client->resources->get($id)
$resource->update($params) # update the resource
$resource->delete() # Delete the resource
```

Also, using `$client->resources->list()` would list the first 20 resources by default (which is the first page, with `limit` as 20, and `offset` as 0). To get more, you will have to use `limit` and `offset` to get the second page of resources.

## Examples

### Send a message

```php
<?php
require 'vendor/autoload.php';
use mywhistlebox\RestClient;

$client = new RestClient();
$message_created = $client->messages->create([ 
        "src" => "+14156667778", 
        "dst" => "+14156667777", 
        "text"  =>"Hello, this is a sample text from mywhistlebox"
]);
```

### Make a call

```php
<?php
require 'vendor/autoload.php';
use mywhistlebox\RestClient;

$client = new RestClient();
$call_made = $client->calls->create(
    '+14156667778',
    ['+14156667777'],
    'https://answer.url'
);
```

### Lookup a number

```php
<?php
require 'vendor/autoload.php';
use mywhistlebox\RestClient;

$client = new RestClient("<auth_id>", "<auth_token>");
$response = $client->lookup->get("<number-goes-here>");
```

### Generate mywhistlebox XML

```php
<?php
require 'vendor/autoload.php';
use mywhistlebox\XML\Response;

$response = new Response();
$response->addSpeak('Hello, world!');
echo($response->toXML());
```

This generates the following XML:

```xml
<?xml version="1.0" encoding="utf-8"?>
<Response>
  <Speak>Hello, world!</Speak>
</Response>
```

### Run a PHLO

```php
<?php
/**
 * Example for API Request
 */
require 'vendor/autoload.php';
use mywhistlebox\Resources\PHLO\PhloRestClient;
use mywhistlebox\Exceptions\mywhistleboxRestException;
$client = new PhloRestClient("<auth_id>", "<auth_token>");
$phlo = $client->phlo->get("<phlo_id>");
try {
    $response = $phlo->run(["field1" => "value1", "field2" => "value2"]); // These are the fields entered in the PHLO console
    print_r($response);
} catch (mywhistleboxRestException $ex) {
    print_r($ex);
}
?>
```

### More examples
More examples are available [here](https://github.com/mywhistlebox/mywhistlebox-examples-php). Also refer to the [guides for configuring the PHP laravel to run various scenarios](https://www.mywhistlebox.com/docs/sms/quickstart/php-laravel/) & use it to test out your integration in under 5 minutes.

## Reporting issues
Report any feedback or problems with this version by [opening an issue on Github](https://github.com/mywhistlebox/mywhistlebox-php/issues).

## Local Development
> Note: Requires latest versions of Docker & Docker-Compose. If you're on MacOS, ensure Docker Desktop is running.
1. Export the following environment variables in your host machine:
```bash
export mywhistlebox_AUTH_ID=<your_auth_id>
export mywhistlebox_AUTH_TOKEN=<your_auth_token>
export mywhistlebox_API_DEV_HOST=<mywhistleboxapi_dev_endpoint>
export mywhistlebox_API_PROD_HOST=<mywhistleboxapi_public_endpoint>
```
2. Run `make build`. This will create a docker container in which the sdk will be setup and dependencies will be installed.
> The entrypoint of the docker container will be the `setup_sdk.sh` script. The script will handle all the necessary changes required for local development.
3. The above command will print the docker container id (and instructions to connect to it) to stdout.
4. The testing code can be added to `<sdk_dir_path>/php-sdk-test/test.php` in host  
 (or `/usr/src/app/php-sdk-test/test.php` in container)
5. The sdk directory will be mounted as a volume in the container. So any changes in the sdk code will also be reflected inside the container.
> To use the local code in the test file, import the sdk in test file using:   
`require /usr/src/app/vendor/autoload.php`   
(Local sdk code will be mounted at `/usr/src/app` inside the container and `vendor` directory will be created by setup script while installing dependencies).
6. To run test code, run `make run CONTAINER=<cont_id>` in host.
7. To run unit tests, run `make test CONTAINER=<cont_id>` in host.
> `<cont_id>` is the docker container id created in 2.
(The docker container should be running)

> Test code and unit tests can also be run within the container using
`make run` and `make test` respectively. (`CONTAINER` argument should be omitted when running from the container)
