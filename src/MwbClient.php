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

    public function fileDownload($fileId)
    {
        $endpoint = "/file/download/$fileId";

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
                'name'     => 'fileIds',
                'contents' => $fileIds
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
}
