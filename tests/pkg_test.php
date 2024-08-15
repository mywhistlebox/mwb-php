<?php
// this script is an example of how to post an upload via MyWhistleBox REST Api
// run from browser https://{your domain or localhost}/rest/package/mwb-php/testing/pkg_test.php

require_once __DIR__."/../vendor/autoload.php";

use Mwb\MwbClient;

// DEFINITIONS

// these should be updated to reflect the current account
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

function checkEndpoint($string, $re)
{
    return preg_match("%$re%", $string);
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

function listBoxes($cl)
{
    $response =  $cl->listBoxes();
    if ($response['status'] == 'ok') {
        echo "RESULT: <br>\n";
        print_r($response);
    } else {
        response_error($response);
    }
}

function listPages($cl)
{
    $response =  $cl->listPages();
    if ($response['status'] == 'ok') {
        echo "RESULT: <br>\n";
        print_r($response);
    } else {
        response_error($response);
    }
}

function listFolders($cl, $parentId)
{
    $response =  $cl->listFolders($parentId);
    if ($response['status'] == 'ok') {
        echo "RESULT: <br>\n";
        print_r($response);
    } else {
        response_error($response);
    }
}

function listFiles($cl, $folderId)
{
    $response =  $cl->listFiles($folderId);
    if ($response['status'] == 'ok') {
        echo "RESULT: <br>\n";
        print_r($response);
    } else {
        response_error($response);
    }
}

function listMemos($cl, $folderId)
{
    $response =  $cl->listMemos($folderId);
    if ($response['status'] == 'ok') {
        echo "RESULT: <br>\n";
        print_r($response);
    } else {
        response_error($response);
    }
}

function fileInfo($cl, $fileId)
{
    $response =  $cl->fileInfo($fileId);
    if ($response['status'] == 'ok') {
        echo "RESULT: <br>\n";
        print_r($response);
    } else {
        response_error($response);
    }
}

function fileDownload($cl, $fileId)
{
    $response =  $cl->listMemos($fileId);
    if ($response['status'] == 'ok') {
        echo "RESULT: <br>\n";
        print_r($response);
    } else {
        response_error($response);
    }
}

function memo($cl, $fileId)
{
    $response =  $cl->memo($fileId);
    if ($response['status'] == 'ok') {
        echo "RESULT: <br>\n";
        print_r($response);
    } else {
        response_error($response);
    }
}

function memoAdd($cl, $folderId)
{
    $response =  $cl->memoAdd($folderId, 'New Memo', 'This is example text.');
    if ($response['status'] == 'ok') {
        echo "RESULT: <br>\n";
        print_r($response);
    } else {
        response_error($response);
    }
}

function folder($cl, $parentId)
{
    $response =  $cl->folder($parentId, "New Folder");
    if ($response['status'] == 'ok') {
        echo "RESULT: <br>\n";
        print_r($response);
    } else {
        response_error($response);
    }
}

function folderUpload($cl, $folderId)
{
    $response =  $cl->folderUpload($folderId, DEFAULT_TEST_DOCUMENT);
    if ($response['status'] == 'ok') {
        echo "RESULT: <br>\n";
        print_r($response);
    } else {
        response_error($response);
    }
}

function userFileUpload($cl)
{
    $response =  $cl->userFileUpload(DEFAULT_WHISTLEBOX_ADDRESS, DEFAULT_TEST_DOCUMENT);
    if ($response['status'] == 'ok') {
        echo 'RESULT: File "'.DEFAULT_TEST_DOCUMENT.'" uploaded to "'.DEFAULT_WHISTLEBOX_ADDRESS.'"<br>';
        print_r($response);
    } else {
        response_error($response);
    }
}

function userFileSend($cl, $fileId)
{
    $response =  $cl->userFileSend(DEFAULT_WHISTLEBOX_ADDRESS, $fileId);
    if ($response['status'] == 'ok') {
        echo 'RESULT: File "'.$response['sentFile'][0]['name'].'" uploaded to "'.DEFAULT_WHISTLEBOX_ADDRESS.'"<br>';
        print_r($response);
    } else {
        response_error($response);
    }
}

function userMemoUpload($cl)
{
    $response =  $cl->userMemoUpload(DEFAULT_WHISTLEBOX_ADDRESS, 'New Uploaded Memo', 'Uploaded memo text');
    if ($response['status'] == 'ok') {
        echo 'RESULT: memo uploaded to "'.DEFAULT_WHISTLEBOX_ADDRESS.'"<br>';
        print_r($response);
    } else {
        response_error($response);
    }
}

# START TEST

echo "Test of MWB endpoint: $endpoint<br>\n";
echo "MWB Instance: ".INSTANCE_URL."<br>\n";

try {
    if ($endpoint == '/test/ping') {
        testPing($client);

    } elseif ($endpoint == '/list/boxes') {
        listBoxes($client);
    } elseif ($endpoint == '/list/pages') {
        listPages($client);
    } elseif (checkEndpoint($endpoint, '/list/folders/\d+')) {
        [$l, $f, $parentId] = explode('/', $endpoint);
        listFolders($client, $parentId);
    } elseif (checkEndpoint($endpoint, '/list/files/\d+')) {
        [$l, $f, $folderId] = explode('/', $endpoint);
        listfiles($client, $folderId);
    } elseif (checkEndpoint($endpoint, '/list/memos/\d+')) {
        [$l, $m, $folderId] = explode('/', $endpoint);
        listMemos($client, $folderId);

    } elseif (checkEndpoint($endpoint, '/file/info/\d+')) {
        [$f, $i, $fileId] = explode('/', $endpoint);
        fileInfo($client, $fileId);
    } elseif (checkEndpoint($endpoint, '/file/download/\d+')) {
        [$f, $d, $fileId] = explode('/', $endpoint);
        fileDownload($endpoint, $fileId);

    } elseif (checkEndpoint($endpoint, '/memo/\d+') && strtoupper($httptype == 'P')) {
        [$m, $folderId] = explode('/', $endpoint);
        memoAdd($client, $folderId);
    } elseif (checkEndpoint($endpoint, '/memo/\d+')) {
        [$m, $folderId] = explode('/', $endpoint);
        memo($client, $folderId);

    } elseif (checkEndpoint($endpoint, '/folder/\d+')) {
        [$f, $folderId] = explode('/', $endpoint);
        folder($client, $folderId);
    } elseif (checkEndpoint($endpoint, '/folder/upload/\d+')) {
        [$f, $u, $folderId] = explode('/', $endpoint);
        folderUpload($endpoint, $folderId);

    } elseif ($endpoint == '/report/log/upload') {
        reportLog($endpoint);
    } elseif ($endpoint == '/report/log/download') {
        reportLog($endpoint);
    } elseif ($endpoint == '/report/log/whistlepage') {
        reportLog($endpoint);
    } elseif ($endpoint == '/report/log/signature') {
        reportLog($endpoint);
    } elseif ($endpoint == '/report/log/sender') {
        reportLog($endpoint);
    } elseif ($endpoint == '/report/log/audit') {
        reportLog($endpoint);

    } elseif (checkEndpoint($endpoint, '/request/upload/\d+')) {
        requestUpload($endpoint);
    } elseif (checkEndpoint($endpoint, '/request/whistlepage/\d+')) {
        requestWhistlepage($endpoint);
    } elseif (checkEndpoint($endpoint, '/request/signature/?(\d+)?')) {
        requestSignature($endpoint);
    } elseif (checkEndpoint($endpoint, '/request/download/?(\d+)?')) {
        requestDownload($endpoint);

    } elseif ($endpoint == '/user/file/upload') {
        userFileUpload($endpoint);
    } elseif (checkEndpoint($endpoint, '/user/file/send/?(\d+)?')) {
        [$u, $f, $s, $fileId] = explode('/', $endpoint);
        userFileSend($endpoint, $fileId);
    } elseif ($endpoint == '/user/memo/upload') {
        userMemoUpload($endpoint);
    } else {
        echo "ERROR: Invalid endpoint.  Please check the programmers guide for proper format.";
    }
} catch(\Exception $e) {
    echo $e->getMessage();
}
