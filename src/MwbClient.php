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

    public function userUploadFile($wbaddr, $file_path, $subject='', $note='', $confirmEmail='')
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

    public function userSend($fileId, $wbaddr, $confirmEmail='')
    {
        $endpoint = "/user/file/send";

        $params['form_params'] = [
          'address' => $wbaddr,
          'fileId' => $fileId,
          'confirmEmail' => $confirmEmail,
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
