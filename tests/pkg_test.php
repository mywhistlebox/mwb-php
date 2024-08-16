<?php
// this script is used to test the MyWhistleBox REST Api on a local server
// run from browser http://localhost/mywhistleboxsdk/mwb-php/tests/pkg_test.php?endpoint=<endpoint>

require_once __DIR__."/../vendor/autoload.php";

use Mwb\MwbClient;

// DEFINITIONS

// these should be updated to reflect the current account
define("INSTANCE_URL", "https://test.mywhistlebox.com/api/rest/v1.0");
define("APIKEY", "cd768d97-f7ff-9ba2-51dd-f8d1406e94dd");
define("DEFAULT_WHISTLEBOX_ADDRESS", "eradin/box");
define("DEFAULT_TEST_DOCUMENT", "api_test_doc.pdf");
define("DEFAULT_EMAIL", "eradin@tellami.com");

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

function reportLogUpload($cl) {
    $response =  $cl->reportLogUpload('', '');
    if ($response['status'] == 'ok') {
        print_r($response);
    } else {
        response_error($response);
    }
}

function reportLogWhistlepage($cl) {
    $response =  $cl->reportLogWhistlepage('', '');
    if ($response['status'] == 'ok') {
        print_r($response);
    } else {
        response_error($response);
    }
}

function reportLogDownload($cl) {
    $response =  $cl->reportLogDownload('', '');
    if ($response['status'] == 'ok') {
        print_r($response);
    } else {
        response_error($response);
    }
}

function reportLogSignature($cl) {
    $response =  $cl->reportLogSignature('', '');
    if ($response['status'] == 'ok') {
        print_r($response);
    } else {
        response_error($response);
    }
}

function reportLogSender($cl) {
    $response =  $cl->reportLogSender('', '');
    if ($response['status'] == 'ok') {
        print_r($response);
    } else {
        response_error($response);
    }
}

function reportLogAudit($cl) {
    $response =  $cl->reportLogAudit('', '');
    if ($response['status'] == 'ok') {
        print_r($response);
    } else {
        response_error($response);
    }
}

function requestUpload($cl, $boxId) {
    $response =  $cl->requestUpload($boxId, DEFAULT_EMAIL);
    if ($response['status'] == 'ok') {
        print_r($response);
    } else {
        response_error($response);
    }
}

function requestWhistlepage($cl, $pageId) {
    $response =  $cl->requestWhistlepage($pageId, DEFAULT_EMAIL);
    if ($response['status'] == 'ok') {
        print_r($response);
    } else {
        response_error($response);
    }
}

function requestDownload($cl, $fileId) {
    $response =  $cl->requestDownload($fileId, DEFAULT_EMAIL, 'NONE');
    if ($response['status'] == 'ok') {
        print_r($response);
    } else {
        response_error($response);
    }
}

function requestSignature($cl, $fileId) {
    $response =  $cl->requestSignature($fileId, DEFAULT_EMAIL, 'NONE');
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
        reportLogUpload($endpoint);
    } elseif ($endpoint == '/report/log/download') {
        reportLogDownload($endpoint);
    } elseif ($endpoint == '/report/log/whistlepage') {
        reportLogWhistlepage($endpoint);
    } elseif ($endpoint == '/report/log/signature') {
        reportLogSignature($endpoint);
    } elseif ($endpoint == '/report/log/sender') {
        reportLogSender($endpoint);
    } elseif ($endpoint == '/report/log/audit') {
        reportLogAudit($endpoint);

    } elseif (checkEndpoint($endpoint, '/request/upload/\d+')) {
        [$r, $u, $boxId] = explode('/', $endpoint);
        requestUpload($endpoint, $boxId);
    } elseif (checkEndpoint($endpoint, '/request/whistlepage/\d+')) {
        [$r, $w, $pageId] = explode('/', $endpoint);
        requestWhistlepage($endpoint, $pageId);
    } elseif (checkEndpoint($endpoint, '/request/signature/?(\d+)?')) {
        [$r, $s, $fileId] = explode('/', $endpoint);
        requestSignature($endpoint, $fileId);
    } elseif (checkEndpoint($endpoint, '/request/download/?(\d+)?')) {
        [$r, $d, $fileId] = explode('/', $endpoint);
        requestDownload($endpoint, $fileId);

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
