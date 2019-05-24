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
use WatchApp\Services\Upload\UploadService;
use WatchApp\Services\WatchData\WatchService;

class HomeController
{
    private $post;

    private $response;

    private $watchService;

    private $session;

    private $authenticationService;

    private $uploadService;

    public function __construct()
    {
        $this->post = Post::instance($_POST);
        $this->response = new Response();
        $this->watchService = new WatchService();
        $this->session = Session::instance($_SESSION);
        $this->authenticationService = new AuthenticationService();
        $this->uploadService = new UploadService();
    }

    public function homePage()
    {
        if (!$this->authenticationService->isAuthenticated())
        {
            throw new ApplicationException('User is not authenticated!');
        }

        $userId = (int) $this->post->get('userId');
        $data = $this->watchService->getWatchesModelsByUserId($userId);

        $this->response->setResponse(Response::RESPONSE_KEY_SUCCESS, true);
        $this->response->setResponse(Response::RESPONSE_KEY_MESSAGE, 'Successfully login data!');
        $this->response->setResponse('data', $data);
        $this->response->getReplayJson();
        exit;
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

    public function uploadPicture()
    {
        if (!$this->authenticationService->isAuthenticated())
        {
            throw new ApplicationException('User is not authenticated!');
        }

        $userId = $this->post->get('userId');

        $uploaded = $this->uploadService->upload($_FILES['file'], 'uploades', $userId);

        $this->response->setResponse(Response::RESPONSE_KEY_SUCCESS, true);
        $this->response->setResponse(Response::RESPONSE_KEY_MESSAGE, 'Successfully uploaded data!');
        $this->response->setResponse('data', $uploaded);
        $this->response->getReplayJson();
        exit;
    }

    public function addWatch()
    {
        if (!$this->authenticationService->isAuthenticated())
        {
            throw new ApplicationException('User is not authenticated!');
        }

        $baseCaliber = $this->post->get('base_caliber');
        $bezelMaterial = $this->post->get('bazel_material');
        $braceletColor = $this->post->get('bracelet_color');
        $braceletMaterial = $this->post->get('bracelet_material');
        $brand = $this->post->get('brand');
        $caliber = $this->post->get('caliber');
        $claspMaterial = $this->post->get('calsp_material');
        $caseDiameter = $this->post->get('case_diameter');
        $caseMaterial = $this->post->get('case_material');
        $clasp = $this->post->get('clasp');
        $dial = $this->post->get('dial');
        $dialNumerals = $this->post->get('dial_numerals');
        $frequency = $this->post->get('frequency');
        $gender = $this->post->get('gender');
        $glass = $this->post->get('glass');
        $model = $this->post->get('model');
        $movement = $this->post->get('movement');
        $picture = $this->post->get('picture');
        $powerReserve = $this->post->get('power_reserve');
        $referenceNumber = $this->post->get('reference_number');
        $thickness = $this->post->get('thickness');
        $watchCharacteristics = $this->post->get('watch_characteristics');
        $watchFunctions = $this->post->get('watch_functions');
        $waterResistance = $this->post->get('water_resistance');
        $numberOfJewels = $this->post->get('number_of_jewels');
        $userId = $this->post->get('userId');

        $data = $this->watchService->createWatch($baseCaliber, $bezelMaterial, $braceletColor, $braceletMaterial, $brand,
            $caliber, $claspMaterial, $caseDiameter, $caseMaterial, $clasp, $dial, $dialNumerals, $frequency,
            $gender, $glass, $model, $movement, $picture, $powerReserve, $referenceNumber, $thickness,
            $watchCharacteristics, $watchFunctions, $waterResistance, $numberOfJewels, $userId);


        $this->response->setResponse(Response::RESPONSE_KEY_SUCCESS, true);
        $this->response->setResponse(Response::RESPONSE_KEY_MESSAGE, 'Successfully add watch!');
        $this->response->setResponse('data', $data);
        $this->response->getReplayJson();
        exit;
    }

    public function watchPictures()
    {
        if (!$this->authenticationService->isAuthenticated())
        {
            throw new ApplicationException('User is not authenticated!');
        }

        $watchId = (int) $this->post->get('watch_id');
        $userId = (int) $this->post->get('user_id');

        $data = $this->watchService->getWatchPictures($watchId, $userId);

        $this->response->setResponse(Response::RESPONSE_KEY_SUCCESS, true);
        $this->response->setResponse(Response::RESPONSE_KEY_MESSAGE, 'Successfully get pictures!');
        $this->response->setResponse('data', $data);
        $this->response->getReplayJson();
        exit;
    }
}