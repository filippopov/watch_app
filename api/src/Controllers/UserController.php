<?php
/**
 * Created by PhpStorm.
 * User: Popov
 * Date: 11.5.2019 г.
 * Time: 12:20
 */

namespace WatchApp\Controllers;


use WatchApp\Core\MVC\Post;
use WatchApp\Core\MVC\Session;

class UserController
{
    private $session;

    private $post;

    private $userService;

    public function __construct()
    {
        $this->session = Session::instance($_SESSION);
        $this->post = Post::instance($_POST);
    }

    public function register($proba, $opa)
    {
        var_dump('hi', $proba, $opa);
    }
}