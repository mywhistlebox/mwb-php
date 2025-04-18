<?php
namespace Mwb;

use Mwb\Exceptions\MwbRestException;
use GuzzleHttp\Psr7\Utils;

/**
 * Class MwbClient
 *
 * @package Mwb
 */
class MwbClient extends BaseClient
{
    public const accessNONE = 'NONE';
    public const accessZIP5 = 'ZIP5';
    public const accessSSN4 = 'SSN4';
    public const accessSSN5 = 'SSN5';
    public const accessPHONE4 = 'PHONE4';
    public const accessCUSTOM = 'CUSTOM';

    public function ping()
    {
        $endpoint = "/test/ping";

        try {
            $response = $this->getIt($endpoint);
            if (!$response->ok()) {
                throw new MwbRestException('URL Endpoint not found. Please check to make sure path is correct.');
            }
            return $response->getContent();
        } catch(\Exception $e) {
            throw new MwbRestException($e->getMessage());
        }
    }

    public function listBoxes()
    {
        $endpoint = "/list/boxes";

        try {
            $response = $this->getIt($endpoint);
            if (!$response->ok()) {
                throw new MwbRestException('URL Endpoint not found. Please check to make sure path is correct.');
            }
            return $response->getContent();
        } catch(\Exception $e) {
            throw new MwbRestException($e->getMessage());
        }
    }

    public function listPages()
    {
        $endpoint = "/list/pages";

        try {
            $response = $this->getIt($endpoint);
            if (!$response->ok()) {
                throw new MwbRestException('URL Endpoint not found. Please check to make sure path is correct.');
            }
            return $response->getContent();
        } catch(\Exception $e) {
            throw new MwbRestException($e->getMessage());
        }
    }

    public function listFolders($parentId)
    {
        $endpoint = "/list/folders/$parentId";

        try {
            $response = $this->getIt($endpoint);
            if (!$response->ok()) {
                throw new MwbRestException('URL Endpoint not found. Please check to make sure path is correct.');
            }
            return $response->getContent();
        } catch(\Exception $e) {
            throw new MwbRestException($e->getMessage());
        }
    }

    public function listFiles($folderId)
    {
        $endpoint = "/list/files/$folderId";

        try {
            $response = $this->getIt($endpoint);
            if (!$response->ok()) {
                throw new MwbRestException('URL Endpoint not found. Please check to make sure path is correct.');
            }
            return $response->getContent();
        } catch(\Exception $e) {
            throw new MwbRestException($e->getMessage());
        }
    }

    public function listMemos($folderId)
    {
        $endpoint = "/list/memos/$folderId";

        try {
            $response = $this->getIt($endpoint);
            if (!$response->ok()) {
                throw new MwbRestException('URL Endpoint not found. Please check to make sure path is correct.');
            }
            return $response->getContent();
        } catch(\Exception $e) {
            throw new MwbRestException($e->getMessage());
        }
    }

    public function listTemplates()
    {
        $endpoint = "/list/templates";

        try {
            $response = $this->getIt($endpoint);
            if (!$response->ok()) {
                throw new MwbRestException('URL Endpoint not found. Please check to make sure path is correct.');
            }
            return $response->getContent();
        } catch(\Exception $e) {
            throw new MwbRestException($e->getMessage());
        }
    }

    public function fileInfo($fileId)
    {
        $endpoint = "/file/info/$fileId";

        try {
            $response = $this->getIt($endpoint);
            if (!$response->ok()) {
                throw new MwbRestException('URL Endpoint not found. Please check to make sure path is correct.');
            }
            return $response->getContent();
        } catch(\Exception $e) {
            throw new MwbRestException($e->getMessage());
        }
    }

    public function fileDownload($fileId, $downloadDir)
    {
        $endpoint = "/file/download/$fileId";

        $path =  tempnam($downloadDir, "dl");

        try {
            $response = $this->downloadIt($endpoint, ['sink' => $path]);
            if (!$response->ok()) {
                throw new MwbRestException('URL Endpoint not found. Please check to make sure path is correct.');
            }

            // get file name
            $headers = $response->getHeaders();

            // extract the filename from the header
            preg_match('/filename="(.+?)"/', $headers['Content-Disposition'][0], $matches);
            $filename = $matches[1];

            // rename temp file
            rename($path, $downloadDir.'/'.$filename);

            return;
        } catch(\Exception $e) {
            throw new MwbRestException($e->getMessage());
        }
    }

    public function fileSearch($filters = [])
    {
        $endpoint = "/file/search";

        $params['multipart'] = [];
        if (isset($filters['srchName'])) {
            $params['multipart'][] = ['name'=> 'srchName','contents' => $filters['srchName']];
        }
        if (isset($filters['srchSubject'])) {
            $params['multipart'][] = ['name'=> 'srchSubject','contents' => $filters['srchSubject']];
        }
        if (isset($filters['srchSender'])) {
            $params['multipart'][] = ['name'=> 'srchSender','contents' => $filters['srchSender']];
        }
        if (isset($filters['srchDateFrom'])) {
            $params['multipart'][] = ['name'=> 'srchDateFrom','contents' => $filters['srchDateFrom']];
        }
        if (isset($filters['srchDateTo'])) {
            $params['multipart'][] = ['name'=> 'srchDateTo','contents' => $filters['srchDateTo']];
        }
        if (isset($filters['srchUnread'])) {
            $params['multipart'][] = ['name'=> 'srchUnread','contents' => $filters['srchUnread'] ? 1 : 0];
        }
        if (isset($filters['srchSigned'])) {
            $params['multipart'][] = ['name'=> 'srchSigned','contents' => $filters['srchSigned'] ? 1 : 0];
        }
        if (isset($filters['srchTrash'])) {
            $params['multipart'][] = ['name'=> 'srchTrash','contents' => $filters['srchTrash'] ? 1 : 0];
        }
        if (isset($filters['srchWhistlePage'])) {
            $params['multipart'][] = ['name'=> 'srchWhistlePage','contents' => $filters['srchWhistlePage'] ? 1 : 0];
        }
        if (isset($filters['srchTemplates'])) {
            $params['multipart'][] = ['name'=> 'srchTemplates','contents' => $filters['srchTemplates'] ? 1 : 0];
        }

        try {
            $response = $this->postIt($endpoint, $params);
            if (!$response->ok()) {
                throw new MwbRestException('URL Endpoint not found. Please check to make sure path is correct.');
            }
            return $response->getContent();
        } catch(\Exception $e) {
            throw new MwbRestException($e->getMessage());
        }
    }

    public function memo($memoId)
    {
        $endpoint = "/memo/$memoId";

        try {
            $response = $this->getIt($endpoint);
            if (!$response->ok()) {
                throw new MwbRestException('URL Endpoint not found. Please check to make sure path is correct.');
            }
            return $response->getContent();
        } catch(\Exception $e) {
            throw new MwbRestException($e->getMessage());
        }
    }

    public function memoAdd($folderId, $title, $text)
    {
        $endpoint = "/memo/$folderId";

        $params['multipart'] = [
            [
                'name'     => 'title',
                'contents' => $title
            ],
            [
                'name'     => 'text',
                'contents' => $text
            ]
        ];

        try {
            $response = $this->postIt($endpoint, $params);
            if (!$response->ok()) {
                throw new MwbRestException('URL Endpoint not found. Please check to make sure path is correct.');
            }
            return $response->getContent();
        } catch(\Exception $e) {
            throw new MwbRestException($e->getMessage());
        }
    }

    public function folder($parentId, $name)
    {
        $endpoint = "/folder/$parentId";

        $params['multipart'] = [
            [
                'name'     => 'name',
                'contents' => $name
            ],
        ];

        try {
            $response = $this->postIt($endpoint, $params);
            if (!$response->ok()) {
                throw new MwbRestException('URL Endpoint not found. Please check to make sure path is correct.');
            }
            return $response->getContent();
        } catch(\Exception $e) {
            throw new MwbRestException($e->getMessage());
        }
    }

    public function folderUpload($folderId, $file_path)
    {
        $endpoint = "/folder/upload/$folderId";

        $params['multipart'] = [
            [
                'name'     => 'file',
                'contents' => Utils::tryFopen($file_path, 'r')
            ]
        ];

        try {
            $response = $this->postIt($endpoint, $params);
            if (!$response->ok()) {
                throw new MwbRestException('URL Endpoint not found. Please check to make sure path is correct.');
            }
            return $response->getContent();
        } catch(\Exception $e) {
            throw new MwbRestException($e->getMessage());
        }
    }

    public function reportLogUpload($startDate, $endDate, $limit=5000, $startAt=0)
    {
        $endpoint = "/report/log/upload";

        $params['multipart'] = [
            [
                'name'     => 'startDate',
                'contents' => $startDate
            ],
            [
                'name'     => 'endDate',
                'contents' => $endDate
            ],
            [
                'name'     => 'limit',
                'contents' => $limit
            ],
            [
                'name'     => 'startAt',
                'contents' => $startAt
            ]
        ];

        try {
            $response = $this->postIt($endpoint, $params);
            if (!$response->ok()) {
                throw new MwbRestException('URL Endpoint not found. Please check to make sure path is correct.');
            }
            return $response->getContent();
        } catch(\Exception $e) {
            throw new MwbRestException($e->getMessage());
        }
    }

    public function reportLogWhistlepage($startDate, $endDate, $limit=5000, $startAt=0)
    {
        $endpoint = "/report/log/Whistlepage";

        $params['multipart'] = [
            [
                'name'     => 'startDate',
                'contents' => $startDate
            ],
            [
                'name'     => 'endDate',
                'contents' => $endDate
            ],
            [
                'name'     => 'limit',
                'contents' => $limit
            ],
            [
                'name'     => 'startAt',
                'contents' => $startAt
            ]
        ];

        try {
            $response = $this->postIt($endpoint, $params);
            if (!$response->ok()) {
                throw new MwbRestException('URL Endpoint not found. Please check to make sure path is correct.');
            }
            return $response->getContent();
        } catch(\Exception $e) {
            throw new MwbRestException($e->getMessage());
        }
    }

    public function reportLogDownload($startDate, $endDate, $limit=5000, $startAt=0)
    {
        $endpoint = "/report/log/download";

        $params['multipart'] = [
            [
                'name'     => 'startDate',
                'contents' => $startDate
            ],
            [
                'name'     => 'endDate',
                'contents' => $endDate
            ],
            [
                'name'     => 'limit',
                'contents' => $limit
            ],
            [
                'name'     => 'startAt',
                'contents' => $startAt
            ]
        ];

        try {
            $response = $this->postIt($endpoint, $params);
            if (!$response->ok()) {
                throw new MwbRestException('URL Endpoint not found. Please check to make sure path is correct.');
            }
            return $response->getContent();
        } catch(\Exception $e) {
            throw new MwbRestException($e->getMessage());
        }
    }

    public function reportLogSignature($startDate, $endDate, $limit=5000, $startAt=0)
    {
        $endpoint = "/report/log/signature";

        $params['multipart'] = [
            [
                'name'     => 'startDate',
                'contents' => $startDate
            ],
            [
                'name'     => 'endDate',
                'contents' => $endDate
            ],
            [
                'name'     => 'limit',
                'contents' => $limit
            ],
            [
                'name'     => 'startAt',
                'contents' => $startAt
            ]
        ];

        try {
            $response = $this->postIt($endpoint, $params);
            if (!$response->ok()) {
                throw new MwbRestException('URL Endpoint not found. Please check to make sure path is correct.');
            }
            return $response->getContent();
        } catch(\Exception $e) {
            throw new MwbRestException($e->getMessage());
        }
    }

    public function reportLogSender($startDate, $endDate, $limit=5000, $startAt=0)
    {
        $endpoint = "/report/log/sender";

        $params['multipart'] = [
            [
                'name'     => 'startDate',
                'contents' => $startDate
            ],
            [
                'name'     => 'endDate',
                'contents' => $endDate
            ],
            [
                'name'     => 'limit',
                'contents' => $limit
            ],
            [
                'name'     => 'startAt',
                'contents' => $startAt
            ]
        ];

        try {
            $response = $this->postIt($endpoint, $params);
            if (!$response->ok()) {
                throw new MwbRestException('URL Endpoint not found. Please check to make sure path is correct.');
            }
            return $response->getContent();
        } catch(\Exception $e) {
            throw new MwbRestException($e->getMessage());
        }
    }

    public function reportLogAudit($startDate, $endDate, $limit=5000, $startAt=0)
    {
        $endpoint = "/report/log/audit";

        $params['multipart'] = [
            [
                'name'     => 'startDate',
                'contents' => $startDate
            ],
            [
                'name'     => 'endDate',
                'contents' => $endDate
            ],
            [
                'name'     => 'limit',
                'contents' => $limit
            ],
            [
                'name'     => 'startAt',
                'contents' => $startAt
            ]
        ];

        try {
            $response = $this->postIt($endpoint, $params);
            if (!$response->ok()) {
                throw new MwbRestException('URL Endpoint not found. Please check to make sure path is correct.');
            }
            return $response->getContent();
        } catch(\Exception $e) {
            throw new MwbRestException($e->getMessage());
        }
    }

    public function requestUpload($boxId, $email, $expireDays='3', $note='')
    {
        $endpoint = "/request/upload/$boxId";

        $params['multipart'] = [
            [
                'name'     => 'email',
                'contents' => $email
            ],
            [
                'name'     => 'expireDays',
                'contents' => $expireDays
            ],
            [
                'name'     => 'note',
                'contents' => $note
            ],
        ];

        try {
            $response = $this->postIt($endpoint, $params);
            if (!$response->ok()) {
                throw new MwbRestException('URL Endpoint not found. Please check to make sure path is correct.');
            }
            return $response->getContent();
        } catch(\Exception $e) {
            throw new MwbRestException($e->getMessage());
        }
    }

    public function requestWhistlepage($pageId, $email, $expireDays='3', $note='')
    {
        $endpoint = "/request/whistlepage/$pageId";

        $params['multipart'] = [
            [
                'name'     => 'email',
                'contents' => $email
            ],
            [
                'name'     => 'expireDays',
                'contents' => $expireDays
            ],
            [
                'name'     => 'note',
                'contents' => $note
            ],
        ];

        try {
            $response = $this->postIt($endpoint, $params);
            if (!$response->ok()) {
                throw new MwbRestException('URL Endpoint not found. Please check to make sure path is correct.');
            }
            return $response->getContent();
        } catch(\Exception $e) {
            throw new MwbRestException($e->getMessage());
        }
    }

    public function requestDownload($fileIds, $email, $accessType, $accessCode='', $expireDays=3, $note='')
    {
        $endpoint = "/request/download";

        if (!is_array($fileIds)) {
            $fileIds = [$fileIds];
        }

        $params['multipart'] = [
            [
                'name'     => 'file_ids',
                'contents' => implode(',', $fileIds)
            ],
            [
                'name'     => 'accessType',
                'contents' => $accessType
            ],
            [
                'name'     => 'accessCode',
                'contents' => $accessCode
            ],
            [
                'name'     => 'email',
                'contents' => $email
            ],
            [
                'name'     => 'expireDays',
                'contents' => $expireDays
            ],
            [
                'name'     => 'note',
                'contents' => $note
            ],
        ];

        try {
            $response = $this->postIt($endpoint, $params);
            if (!$response->ok()) {
                throw new MwbRestException('URL Endpoint not found. Please check to make sure path is correct.');
            }
            return $response->getContent();
        } catch(\Exception $e) {
            throw new MwbRestException($e->getMessage());
        }
    }
    
    public function requestSignature($fileIds, $email, $accessType, $accessCode='', $templateId=0, $expireDays=3, $note='')
    {
        $endpoint = "/request/signature";

        if (!is_array($fileIds)) {
            $fileIds = [$fileIds];
        }

        $params['multipart'] = [
            [
                'name'     => 'file_ids',
                'contents' => implode(',', $fileIds)
            ],
            [
                'name'     => 'accessType',
                'contents' => $accessType
            ],
            [
                'name'     => 'accessCode',
                'contents' => $accessCode
            ],
            [
                'name'     => 'email',
                'contents' => $email
            ],
            [
                'name'     => 'template_id',
                'contents' => $templateId
            ],
            [
                'name'     => 'expireDays',
                'contents' => $expireDays
            ],
            [
                'name'     => 'note',
                'contents' => $note
            ],
        ];

        try {
            $response = $this->postIt($endpoint, $params);
            if (!$response->ok()) {
                throw new MwbRestException('URL Endpoint not found. Please check to make sure path is correct.');
            }
            return $response->getContent();
        } catch(\Exception $e) {
            throw new MwbRestException($e->getMessage());
        }
    }

    public function userFileUpload($wbaddr, $file_path, $subject='', $note='', $confirmEmail='')
    {
        $endpoint = "/user/file/upload";

        $params['multipart'] = [
            [
                'name'     => 'address',
                'contents' => $wbaddr
            ],
            [
                'name'     => 'file',
                'contents' => Utils::tryFopen($file_path, 'r')
            ],
            [
                'name'     => 'subject',
                'contents' => $subject
            ],
            [
                'name'     => 'notes',
                'contents' => $note
            ],
            [
                'name'     => 'confirmEmail',
                'contents' => $confirmEmail
            ],
        ];

        try {
            $response = $this->postIt($endpoint, $params);
            if (!$response->ok()) {
                throw new MwbRestException('URL Endpoint not found. Please check to make sure path is correct.');
            }
            return $response->getContent();
        } catch(\Exception $e) {
            throw new MwbRestException($e->getMessage());
        }
    }

    public function userUploadString($wbaddr, $file_contents, $file_name, $subject='', $note='', $confirmEmail='')
    {
        $endpoint = "/user/file/upload";

        $params['multipart'] = [
            [
                'name'     => 'address',
                'contents' => $wbaddr
            ],
            [
                'name'     => 'file',
                'contents' => $file_contents,
                'filename' => $file_name,
            ],
            [
                'name'     => 'subject',
                'contents' => $subject
            ],
            [
                'name'     => 'notes',
                'contents' => $note
            ],
            [
                'name'     => 'confirmEmail',
                'contents' => $confirmEmail
            ],
        ];

        try {
            $response = $this->postIt($endpoint, $params);
            if (!$response->ok()) {
                throw new MwbRestException('URL Endpoint not found. Please check to make sure path is correct.');
            }
            return $response->getContent();
        } catch(\Exception $e) {
            throw new MwbRestException($e->getMessage());
        }
    }

    public function userMemoUpload($wbaddr, $title, $text)
    {
        $endpoint = "/user/memo/upload";

        $params['multipart'] = [
            [
                'name'     => 'address',
                'contents' => $wbaddr
            ],
            [
                'name'     => 'title',
                'contents' => $title
            ],
            [
                'name'     => 'text',
                'contents' => $text
            ],
        ];

        try {
            $response = $this->postIt($endpoint, $params);
            if (!$response->ok()) {
                throw new MwbRestException('URL Endpoint not found. Please check to make sure path is correct.');
            }
            return $response->getContent();
        } catch(\Exception $e) {
            throw new MwbRestException($e->getMessage());
        }
    }


    public function userFileSend($wbaddr, $fileIds, $confirmEmail='', $note='')
    {
        $endpoint = "/user/file/send";

        if (!is_array($fileIds)) {
            $fileIds = [$fileIds];
        }

        $params['multipart'] = [
            [
                'name'     => 'address',
                'contents' => $wbaddr
            ],
            [
                'name'     => 'file_ids',
                'contents' => implode(',', $fileIds)
            ],
            [
                'name'     => 'confirmEmail',
                'contents' => $confirmEmail
            ],
            [
                'name'     => 'note',
                'contents' => $note
            ],
        ];

        try {
            $response = $this->postIt($endpoint, $params);
            if (!$response->ok()) {
                throw new MwbRestException('URL Endpoint not found. Please check to make sure path is correct.');
            }
            return $response->getContent();
        } catch(\Exception $e) {
            throw new MwbRestException($e->getMessage());
        }
    }

    public function userFileSendsign($wbaddr, $fileId, $templateId=0, $note='')
    {
        $endpoint = "/user/file/send";

        $params['multipart'] = [
            [
                'name'     => 'address',
                'contents' => $wbaddr
            ],
            [
                'name'     => 'file_id',
                'contents' => $fileId
            ],
            [
                'name'     => 'template_id',
                'contents' => $templateId
            ],
            [
                'name'     => 'note',
                'contents' => $note
            ],
        ];

        try {
            $response = $this->postIt($endpoint, $params);
            if (!$response->ok()) {
                throw new MwbRestException('URL Endpoint not found. Please check to make sure path is correct.');
            }
            return $response->getContent();
        } catch(\Exception $e) {
            throw new MwbRestException($e->getMessage());
        }
    }
}
