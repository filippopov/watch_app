<?php

use WatchApp\Core\MVC\MVCContext;
use WatchApp\Core\Application;
use WatchApp\Core\Response;

require_once 'vendor/autoload.php';

session_start();

$uri = $_SERVER['REQUEST_URI'];
$self = $_SERVER['PHP_SELF'];
$self = str_replace("index.php", "", $self);
$uri = str_replace($self, "", $uri);
$params = explode("/", $uri);
$controllerName = array_shift($params);
$actionName = array_shift($params);

$mvcContext = MVCContext::instance();
$mvcContext->setController($controllerName);
$mvcContext->setAction($actionName);
$mvcContext->setUrlJunk($self);
$mvcContext->setArguments($params);

try {
    $app = new Application();
    $app->start();
} catch (Exception $e) {
    $response = new Response();
    $response->setResponse(Response::RESPONSE_KEY_SUCCESS, false);
    $response->setResponse(Response::RESPONSE_KEY_MESSAGE, $e->getMessage());

    $response->getReplayJson();
    exit;
}