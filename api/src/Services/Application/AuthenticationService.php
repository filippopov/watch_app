<?php
/**
 * Created by PhpStorm.
 * User: Popov
 * Date: 11.5.2019 г.
 * Time: 18:51
 */

namespace WatchApp\Services\Application;


use WatchApp\Core\MVC\Session;

class AuthenticationService implements AuthenticationServiceInterface
{
    private $session;

    public function __construct()
    {
        $this->session = Session::instance($_SESSION);
    }

    public function isAuthenticated(): bool
    {
        return $this->session->isExists('id');
    }

    public function logout()
    {
        $this->session->destroy();
    }

    public function getUserId()
    {
        return $this->session->get('id');
    }
}