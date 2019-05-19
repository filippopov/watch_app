<?php
/**
 * Created by PhpStorm.
 * User: Popov
 * Date: 11.5.2019 г.
 * Time: 18:39
 */

namespace WatchApp\Core;


use WatchApp\Services\Helpers\HelperService;

class Response
{
    const RESPONSE_KEY_SUCCESS = 'success';
    const RESPONSE_KEY_MESSAGE = 'message';

    private $helperService;

    private $response = [
        self::RESPONSE_KEY_SUCCESS => false,
        self::RESPONSE_KEY_MESSAGE => ''
    ];

    public function __construct()
    {
        $this->helperService = new HelperService();
    }

    public function setResponse($key, $value)
    {
        $this->response[$key] = $value;
    }

    public function getReplayJson()
    {
        echo $this->helperService->safe_json_encode($this->response);
    }
}