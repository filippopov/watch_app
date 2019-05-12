<?php
/**
 * Created by PhpStorm.
 * User: Popov
 * Date: 11.5.2019 г.
 * Time: 12:20
 */

namespace WatchApp\Controllers;


use WatchApp\Adapter\Database;
use WatchApp\Config\DbConfig;
use WatchApp\Core\MVC\Post;
use WatchApp\Core\MVC\Session;
use WatchApp\Repositories\User\UsersRepository;

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

    public function register($email, $password)
    {
        $userRepository = new UsersRepository();
        $userRepository->create([
            'email' => $email,
            'password' => $password,
            'is_active' => 1
        ]);


    }
}