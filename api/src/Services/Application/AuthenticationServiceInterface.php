<?php
/**
 * Created by PhpStorm.
 * User: Popov
 * Date: 11.5.2019 г.
 * Time: 21:14
 */

namespace WatchApp\Services\Application;


interface AuthenticationServiceInterface
{
    public function isAuthenticated(): bool;

    public function logout();

    public function getUserId();
}