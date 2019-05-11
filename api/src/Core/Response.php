<?php
/**
 * Created by PhpStorm.
 * User: Popov
 * Date: 11.5.2019 г.
 * Time: 18:39
 */

namespace WatchApp\Core;


class Response
{
    const RESPONSE_KEY_SUCCESS = 'success';
    const RESPONSE_KEY_MESSAGE = 'message';

    private $response = [
        self::RESPONSE_KEY_SUCCESS => false,
        self::RESPONSE_KEY_MESSAGE => ''
    ];

    public function setResponse($key, $value)
    {
        $this->response[$key] = $value;
    }

    public function getReplayJson()
    {
        echo json_encode($this->response);
    }
}