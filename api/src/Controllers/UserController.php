<?php
/**
 * Created by PhpStorm.
 * User: Popov
 * Date: 11.5.2019 г.
 * Time: 12:20
 */

namespace WatchApp\Controllers;


use WatchApp\Core\MVC\Post;
use WatchApp\Core\Response;
use WatchApp\Services\Application\AuthenticationService;
use WatchApp\Services\User\UserService;

class UserController
{
    private $post;

    private $userService;

    private $response;

    private $authenticationService;

    public function __construct()
    {
        $this->post = Post::instance($_POST);
        $this->userService = new UserService();
        $this->response = new Response();
        $this->authenticationService = new AuthenticationService();
    }

    public function register()
    {
        $email = $this->post->get('email');
        $password = $this->post->get('password');
        $repeatPass = $this->post->get('repeatPass');

        $data = $this->userService->register($email, $password, $repeatPass);

        $this->response->setResponse(Response::RESPONSE_KEY_SUCCESS, true);
        $this->response->setResponse(Response::RESPONSE_KEY_MESSAGE, 'Successfully user registration!');
        $this->response->setResponse('data', $data);
        $this->response->getReplayJson();
        exit;
    }

    public function login()
    {
        $email = $this->post->get('email');
        $password = $this->post->get('password');

        $data = $this->authenticationService->login($email, $password);

        $this->response->setResponse(Response::RESPONSE_KEY_SUCCESS, true);
        $this->response->setResponse(Response::RESPONSE_KEY_MESSAGE, 'Successfully login user!');
        $this->response->setResponse('data', $data);
        $this->response->getReplayJson();
        exit;
    }

    public function logout()
    {
        $this->authenticationService->logout();
        $this->response->setResponse(Response::RESPONSE_KEY_SUCCESS, true);
        $this->response->setResponse(Response::RESPONSE_KEY_MESSAGE, 'Successfully logout user!');
        $this->response->getReplayJson();
        exit;
    }
}