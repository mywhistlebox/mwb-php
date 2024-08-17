<?php
// this script is used to test the MyWhistleBox REST Api on a local server
// run from browser http://localhost/mywhistleboxsdk/mwb-php/tests/pkg_test.php?endpoint=<endpoint>

require_once __DIR__."/../vendor/autoload.php";

use Mwb\MwbClient;

// DEFINITIONS

// these should be updated to reflect the current account
define("INSTANCE_URL", "https://test.mywhistlebox.com/api/rest/v1.0");
define("APIKEY", "dae57b7c-8a60-4a02-2bbf-921b64c0b669");
define("DEFAULT_WHISTLEBOX_ADDRESS", "apitest/box");
define("DEFAULT_REQUEST_EMAIL", "eradin1@gmail.com");
define("TMPDIR", "./downloads/");

// standard defaults
define("DEFAULT_TEST_DOCUMENT", "api_test_doc.pdf");
define("DEFAULT_REQUEST_EXPIRES_DAYS", "1");
define("DEFAULT_REQUEST_ACCESS_TYPE", "NONE");
define("DEFAULT_REQUEST_ACCESS_CODE", "");
define("DEFAULT_START_DATE", "");
define("DEFAULT_END_DATE", "");

// INITIALIZATIOIN
$client = new MwbClient(APIKEY);
$client->setBaseUrl(INSTANCE_URL);  // optional, default is production at mywhistlebox.com

// add to url as ?endpoint=<endpoint>
$endpoint = isset($_REQUEST['endpoint']) ? $_REQUEST['endpoint'] : '/test/ping';

// optional type override
$httptype = isset($_REQUEST['httptype']) ? $_REQUEST['httptype'] : '';

// helper functions
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


// endpoint functions

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
    $response =  $cl->fileDownload($fileId, TMPDIR);
    echo "RESULT: Downloaded file to ".TMPDIR."<br>\n";
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
        echo 'RESULT: File "'.$response['sentStatus'][0]['file'].'" uploaded to "'.DEFAULT_WHISTLEBOX_ADDRESS.'"<br>';
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

function reportLogUpload($cl) {
    $response =  $cl->reportLogUpload(DEFAULT_START_DATE, DEFAULT_END_DATE);
    if ($response['status'] == 'ok') {
        print_r($response);
    } else {
        response_error($response);
    }
}

function reportLogWhistlepage($cl) {
    $response =  $cl->reportLogWhistlepage(DEFAULT_START_DATE, DEFAULT_END_DATE);
    if ($response['status'] == 'ok') {
        print_r($response);
    } else {
        response_error($response);
    }
}

function reportLogDownload($cl) {
    $response =  $cl->reportLogDownload(DEFAULT_START_DATE, DEFAULT_END_DATE);
    if ($response['status'] == 'ok') {
        print_r($response);
    } else {
        response_error($response);
    }
}

function reportLogSignature($cl) {
    $response =  $cl->reportLogSignature(DEFAULT_START_DATE, DEFAULT_END_DATE);
    if ($response['status'] == 'ok') {
        print_r($response);
    } else {
        response_error($response);
    }
}

function reportLogSender($cl) {
    $response =  $cl->reportLogSender(DEFAULT_START_DATE, DEFAULT_END_DATE);
    if ($response['status'] == 'ok') {
        print_r($response);
    } else {
        response_error($response);
    }
}

function reportLogAudit($cl) {
    $response =  $cl->reportLogAudit(DEFAULT_START_DATE, DEFAULT_END_DATE);
    if ($response['status'] == 'ok') {
        print_r($response);
    } else {
        response_error($response);
    }
}

function requestUpload($cl, $boxId) {
    $response =  $cl->requestUpload($boxId, DEFAULT_REQUEST_EMAIL);
    if ($response['status'] == 'ok') {
        print_r($response);
    } else {
        response_error($response);
    }
}

function requestWhistlepage($cl, $pageId) {
    $response =  $cl->requestWhistlepage($pageId, DEFAULT_REQUEST_EMAIL);
    if ($response['status'] == 'ok') {
        print_r($response);
    } else {
        response_error($response);
    }
}

function requestDownload($cl, $fileId) {
    $response =  $cl->requestDownload($fileId, DEFAULT_REQUEST_EMAIL, DEFAULT_REQUEST_ACCESS_TYPE);
    if ($response['status'] == 'ok') {
        print_r($response);
    } else {
        response_error($response);
    }
}

function requestSignature($cl, $fileId) {
    $response =  $cl->requestSignature($fileId, DEFAULT_REQUEST_EMAIL, DEFAULT_REQUEST_ACCESS_TYPE);
    if ($response['status'] == 'ok') {
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
        $ps = explode('/', $endpoint);
        listFolders($client, $ps[3]);
    } elseif (checkEndpoint($endpoint, '/list/files/\d+')) {
        $ps = explode('/', $endpoint);
        listfiles($client, $ps[3]);
    } elseif (checkEndpoint($endpoint, '/list/memos/\d+')) {
        $ps = explode('/', $endpoint);
        listMemos($client, $ps[3]);

    } elseif (checkEndpoint($endpoint, '/file/info/\d+')) {
        $ps = explode('/', $endpoint);
        fileInfo($client, $ps[3]);
    } elseif (checkEndpoint($endpoint, '/file/download/\d+')) {
        $ps = explode('/', $endpoint);
        fileDownload($client, $ps[3]);

    } elseif (checkEndpoint($endpoint, '/memo/\d+') && strtoupper($httptype == 'P')) {
        $ps = explode('/', $endpoint);
        memoAdd($client, $ps[2]);
    } elseif (checkEndpoint($endpoint, '/memo/\d+')) {
        $ps = explode('/', $endpoint);
        memo($client, $ps[2]);

    } elseif (checkEndpoint($endpoint, '/folder/\d+')) {
        $ps = explode('/', $endpoint);
        folder($client, $ps[2]);
    } elseif (checkEndpoint($endpoint, '/folder/upload/\d+')) {
        $ps = explode('/', $endpoint);
        folderUpload($client, $ps[3]);

    } elseif ($endpoint == '/report/log/upload') {
        reportLogUpload($client);
    } elseif ($endpoint == '/report/log/download') {
        reportLogDownload($client);
    } elseif ($endpoint == '/report/log/whistlepage') {
        reportLogWhistlepage($client);
    } elseif ($endpoint == '/report/log/signature') {
        reportLogSignature($client);
    } elseif ($endpoint == '/report/log/sender') {
        reportLogSender($client);
    } elseif ($endpoint == '/report/log/audit') {
        reportLogAudit($client);

    } elseif (checkEndpoint($endpoint, '/request/upload/\d+')) {
        $ps = explode('/', $endpoint);
        requestUpload($client, $ps[3]);
    } elseif (checkEndpoint($endpoint, '/request/whistlepage/\d+')) {
        $ps = explode('/', $endpoint);
        requestWhistlepage($client, $ps[3]);
    } elseif (checkEndpoint($endpoint, '/request/signature/?(\d+)?')) {
        $ps = explode('/', $endpoint);
        requestSignature($client, $ps[3]);
    } elseif (checkEndpoint($endpoint, '/request/download/?(\d+)?')) {
        $ps = explode('/', $endpoint);
        requestDownload($client, $ps[3]);

    } elseif ($endpoint == '/user/file/upload') {
        userFileUpload($client);
    } elseif (checkEndpoint($endpoint, '/user/file/send/?(\d+)?')) {
        $ps = explode('/', $endpoint);
        userFileSend($client, $ps[4]);
    } elseif ($endpoint == '/user/memo/upload') {
        userMemoUpload($client);
    } else {
        echo "ERROR: Invalid endpoint.  Please check the programmers guide for proper format.";
    }
} catch(\Exception $e) {
    echo $e->getMessage();
}
