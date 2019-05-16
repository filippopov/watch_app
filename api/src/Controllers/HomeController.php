<?php
/**
 * Created by PhpStorm.
 * User: Popov
 * Date: 12.5.2019 г.
 * Time: 16:50
 */

namespace WatchApp\Controllers;


use WatchApp\Core\MVC\Post;
use WatchApp\Core\Response;

class HomeController
{
    private $post;

    private $response;

    public function __construct()
    {
        $this->post = Post::instance($_POST);
        $this->response = new Response();
    }

    public function homePage()
    {
        $session_id = $this->post->get('session_id');
        $user_id = $this->post->get('user_id');

        var_dump($session_id, $user_id);
    }
}