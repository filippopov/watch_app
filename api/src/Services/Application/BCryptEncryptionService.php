<?php
/**
 * Created by PhpStorm.
 * User: Popov
 * Date: 12.5.2019 г.
 * Time: 7:47
 */

namespace WatchApp\Services\Application;


class BCryptEncryptionService implements EncryptionServiceInterface
{
    public function hash($password)
    {
        return password_hash($password, PASSWORD_BCRYPT);
    }

    public function verify($password, $hash)
    {
        return password_verify($password, $hash);
    }
}