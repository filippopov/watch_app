<?php
/**
 * Created by PhpStorm.
 * User: Popov
 * Date: 12.5.2019 г.
 * Time: 7:46
 */

namespace WatchApp\Services\Application;


interface EncryptionServiceInterface
{
    public function hash($password);

    public function verify($password, $hash);
}