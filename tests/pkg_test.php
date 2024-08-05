<?php
// this script is an example of how to post an upload via MyWhistleBox REST Api
// run from browser https://test.mywhistlebox.com/rest/package/mwb-php/testing/pkg_test.php

require_once __DIR__."/../vendor/autoload.php";

use Mwb\MwbClient;

// DEFINITIONS

// these should b updated to reflect the current account
define("INSTANCE_URL", "https://test.mywhistlebox.com/api/rest/v1.0");
define("APIKEY", "cd768d97-f7ff-9ba2-51dd-f8d1406e94dd");
define("DEFAULT_WHISTLEBOX_ADDRESS", "eradin/box");
define("DEFAULT_TEST_DOCUMENT", "api_test_doc.pdf");

// INITIALIZATIOIN
$client = new MwbClient(APIKEY);
$client->setBaseUrl(INSTANCE_URL);  // optional, default is production at mywhistlebox.com

// add to url as ?endpoint=<endpoint>
$endpoint = isset($_REQUEST['endpoint']) ? $_REQUEST['endpoint'] : '/test/ping';

function response_error($resp)
{
    if ($resp['status'] == 'access') {
        echo "ERROR: Access denied.  Please check your ApiKey<br>\n";
    } else {
        echo "ERROR:". $resp['message'];
    }
}

function testPing($cl)
{
    $response = $cl->ping();
    if ($response['status'] == 'ok') {
        echo "RESULT: Server has been pinged successfully<br>\n";
    } else {
        response_error($response);
    }
}

function userUpload($cl)
{
    $response =  $cl->userUploadFile(DEFAULT_WHISTLEBOX_ADDRESS, DEFAULT_TEST_DOCUMENT);
    if ($response['status'] == 'ok') {
        echo 'RESULT: File "'.DEFAULT_TEST_DOCUMENT.'" uploaded to "'.DEFAULT_WHISTLEBOX_ADDRESS.'"<br>';
    } else {
        response_error($response);
    }
}

function listBoxes($cl)
{
    $response =  $cl->listBoxes();
    if ($response['status'] == 'ok') {
        echo "RESULT: <br>\n";
        print_r($response['boxes']);
    } else {
        response_error($response);
    }
}

# START TEST

echo "Test of MWB endpoint: $endpoint<br>\n";
echo "MWB Instance: ".INSTANCE_URL."<br>\n";

try {
    switch ($endpoint) {
        case '/test/ping': testPing($client);
            break;

        case '/user/upload': userUpload($client);
            break;

        case '/list/boxes': listBoxes($client);
            break;
        default: echo "ERROR: Invalid endpoint.  Endpoints look like /category/action.";
    }
} catch(\Exception $e) {
    echo $e->getMessage();
}
