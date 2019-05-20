<?php
/**
 * Created by PhpStorm.
 * User: Popov
 * Date: 12.5.2019 г.
 * Time: 16:50
 */

namespace WatchApp\Controllers;


use WatchApp\Core\MVC\Post;
use WatchApp\Core\MVC\Session;
use WatchApp\Core\Response;
use WatchApp\Exceptions\ApplicationException;
use WatchApp\Services\Application\AuthenticationService;
use WatchApp\Services\WatchData\WatchService;

class HomeController
{
    private $post;

    private $response;

    private $watchService;

    private $session;

    private $authenticationService;



    public function __construct()
    {
        $this->post = Post::instance($_POST);
        $this->response = new Response();
        $this->watchService = new WatchService();
        $this->session = Session::instance($_SESSION);
        $this->authenticationService = new AuthenticationService();
    }

    public function homePage()
    {
        $session_id = $this->post->get('session_id');
        $user_id = $this->post->get('user_id');

    }

    public function getWatchFormData()
    {
        if (!$this->authenticationService->isAuthenticated())
        {
            throw new ApplicationException('User is not authenticated!');
        }

        $brands = $this->watchService->getWatchBrands();
        $genders = $this->watchService->getGenders();
        $movements = $this->watchService->getMovements();
        $caseMaterials = $this->watchService->getCaseMaterials();
        $braceletMaterials = $this->watchService->getBraceletMaterials();
        $braceletColors = $this->watchService->getBraceletColors();
        $claspMaterials = $this->watchService->getClaspMaterials();
        $clasps = $this->watchService->getClaspTypes();
        $bezelMaterials = $this->watchService->getBezelMaterials();
        $glass = $this->watchService->getGlassTypes();
        $waterResistance = $this->watchService->getWaterResistance();
        $dial = $this->watchService->getDialTypes();
        $dialNumerals = $this->watchService->getDialNumeralsTypes();
        $watchFunctions = $this->watchService->getWatchFunctions();
        $watchCharacteristics = $this->watchService->getWatchCharacteristics();


        $data = [
            'brands' => $brands,
            'genders' => $genders,
            'movements' => $movements,
            'caseMaterials' => $caseMaterials,
            'braceletMaterials' => $braceletMaterials,
            'braceletColors' => $braceletColors,
            'claspMaterials' => $claspMaterials,
            'clasps' => $clasps,
            'bezelMaterials' => $bezelMaterials,
            'glass' => $glass,
            'waterResistance' => $waterResistance,
            'dial' => $dial,
            'dialNumerals' => $dialNumerals,
            'watchFunctions' => $watchFunctions,
            'watchCharacteristics' => $watchCharacteristics
        ];

        $this->response->setResponse(Response::RESPONSE_KEY_SUCCESS, true);
        $this->response->setResponse(Response::RESPONSE_KEY_MESSAGE, 'Successfully login data!');
        $this->response->setResponse('data', $data);
        $this->response->getReplayJson();
        exit;
    }
}