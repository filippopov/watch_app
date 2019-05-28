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
        $this->response->setResponse(Response::RESPONSE_KEY_MESSAGE, 'Successfully get data!');
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

    public function editWatch()
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
        $watchId = $this->post->get('watch_id');

        $data = $this->watchService->editWatch($baseCaliber, $bezelMaterial, $braceletColor, $braceletMaterial, $brand,
            $caliber, $claspMaterial, $caseDiameter, $caseMaterial, $clasp, $dial, $dialNumerals, $frequency,
            $gender, $glass, $model, $movement, $picture, $powerReserve, $referenceNumber, $thickness,
            $watchCharacteristics, $watchFunctions, $waterResistance, $numberOfJewels, $userId, $watchId);


        $this->response->setResponse(Response::RESPONSE_KEY_SUCCESS, true);
        $this->response->setResponse(Response::RESPONSE_KEY_MESSAGE, 'Successfully edit watch!');
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

    public function watchData()
    {
        if (!$this->authenticationService->isAuthenticated())
        {
            throw new ApplicationException('User is not authenticated!');
        }

        $watchId = (int) $this->post->get('watch_id');
        $userId = (int) $this->post->get('user_id');

        $data = $this->watchService->getWatchData($watchId, $userId);

        $this->response->setResponse(Response::RESPONSE_KEY_SUCCESS, true);
        $this->response->setResponse(Response::RESPONSE_KEY_MESSAGE, 'Successfully get watch data!');
        $this->response->setResponse('data', $data);
        $this->response->getReplayJson();
        exit;
    }

    public function watchFunctions()
    {
        if (!$this->authenticationService->isAuthenticated())
        {
            throw new ApplicationException('User is not authenticated!');
        }

        $watchId = (int) $this->post->get('watch_id');

        $data = $this->watchService->watchFunctions($watchId);

        $this->response->setResponse(Response::RESPONSE_KEY_SUCCESS, true);
        $this->response->setResponse(Response::RESPONSE_KEY_MESSAGE, 'Successfully get watch functions!');
        $this->response->setResponse('data', $data);
        $this->response->getReplayJson();
        exit;
    }

    public function watchCharacteristics()
    {
        if (!$this->authenticationService->isAuthenticated())
        {
            throw new ApplicationException('User is not authenticated!');
        }

        $watchId = (int) $this->post->get('watch_id');

        $data = $this->watchService->watchCharacteristics($watchId);

        $this->response->setResponse(Response::RESPONSE_KEY_SUCCESS, true);
        $this->response->setResponse(Response::RESPONSE_KEY_MESSAGE, 'Successfully get watch characteristics!');
        $this->response->setResponse('data', $data);
        $this->response->getReplayJson();
        exit;
    }

    public function deleteWatch()
    {
        if (!$this->authenticationService->isAuthenticated())
        {
            throw new ApplicationException('User is not authenticated!');
        }

        $watchId = (int) $this->post->get('watch_id');

        $data = $this->watchService->deleteWatch($watchId);

        $this->response->setResponse(Response::RESPONSE_KEY_SUCCESS, true);
        $this->response->setResponse(Response::RESPONSE_KEY_MESSAGE, 'Successfully delete watch!');
        $this->response->setResponse('data', $data);
        $this->response->getReplayJson();
        exit;
    }

    public function deletePicture()
    {
        if (!$this->authenticationService->isAuthenticated())
        {
            throw new ApplicationException('User is not authenticated!');
        }

        $watchId = (int) $this->post->get('watchId');
        $pictureId = (int) $this->post->get('pictureId');
        $userId = (int) $this->post->get('user_id');

        $data = $this->watchService->deletePicture($pictureId, $watchId, $userId);

        $this->response->setResponse(Response::RESPONSE_KEY_SUCCESS, true);
        $this->response->setResponse(Response::RESPONSE_KEY_MESSAGE, 'Successfully delete picture!');
        $this->response->setResponse('data', $data);
        $this->response->getReplayJson();
        exit;
    }

    public function isWatchExist()
    {
        if (!$this->authenticationService->isAuthenticated())
        {
            throw new ApplicationException('User is not authenticated!');
        }

        $watchId = (int) $this->post->get('watch_id');
        $userId = (int) $this->post->get('userId');

        $data = $this->watchService->isWatchExist($watchId, $userId);

        $this->response->setResponse(Response::RESPONSE_KEY_SUCCESS, true);
        $this->response->setResponse(Response::RESPONSE_KEY_MESSAGE, 'Get watch data!');
        $this->response->setResponse('data', $data);
        $this->response->getReplayJson();
        exit;
    }

    public function getEditWatchForm()
    {
        if (!$this->authenticationService->isAuthenticated())
        {
            throw new ApplicationException('User is not authenticated!');
        }

        $watchId = (int) $this->post->get('watch_id');
        $userId = (int) $this->post->get('user_id');

        $watch = $this->watchService->isWatchExist($watchId, $userId);


        $brands = $this->watchService->getWatchBrands();
        $brands = $this->watchService->setSelectedValue($watch, $brands, 'brand_fk');
        $genders = $this->watchService->getGenders();
        $genders = $this->watchService->setSelectedValue($watch, $genders, 'gender_fk');
        $movements = $this->watchService->getMovements();
        $movements = $this->watchService->setSelectedValue($watch, $movements, 'movement_fk');
        $caseMaterials = $this->watchService->getCaseMaterials();
        $caseMaterials = $this->watchService->setSelectedValue($watch, $caseMaterials, 'case_material_fk');
        $braceletMaterials = $this->watchService->getBraceletMaterials();
        $braceletMaterials = $this->watchService->setSelectedValue($watch, $braceletMaterials, 'bracelet_material_fk');
        $braceletColors = $this->watchService->getBraceletColors();
        $braceletColors = $this->watchService->setSelectedValue($watch, $braceletColors, 'bracelet_color_fk');
        $claspMaterials = $this->watchService->getClaspMaterials();
        $claspMaterials = $this->watchService->setSelectedValue($watch, $claspMaterials, 'clasp_material_fk');
        $clasps = $this->watchService->getClaspTypes();
        $clasps = $this->watchService->setSelectedValue($watch, $clasps, 'clasp_fk');
        $bezelMaterials = $this->watchService->getBezelMaterials();
        $bezelMaterials = $this->watchService->setSelectedValue($watch, $bezelMaterials, 'bezel_material_fk');
        $glass = $this->watchService->getGlassTypes();
        $glass = $this->watchService->setSelectedValue($watch, $glass, 'glass_fk');
        $waterResistance = $this->watchService->getWaterResistance();
        $waterResistance = $this->watchService->setSelectedValue($watch, $waterResistance, 'water_resistance_fk');
        $dial = $this->watchService->getDialTypes();
        $dial = $this->watchService->setSelectedValue($watch, $dial, 'dial_fk');
        $dialNumerals = $this->watchService->getDialNumeralsTypes();
        $dialNumerals = $this->watchService->setSelectedValue($watch, $dialNumerals, 'dial_numerals_fk');

        $watchFunctions = $this->watchService->getWatchFunctions();
        $watchFunctionsByWatch = $this->watchService->watchFunctions($watchId);

        $watchFunctions = $this->watchService->setCheckedValues($watchFunctions, $watchFunctionsByWatch, 'watch_function_name');

        $watchCharacteristics = $this->watchService->getWatchCharacteristics();
        $watchCharacteristicsByWatch = $this->watchService->watchCharacteristics($watchId);

        $watchCharacteristics = $this->watchService->setCheckedValues($watchCharacteristics, $watchCharacteristicsByWatch, 'watch_characteristic_name');

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
            'watchCharacteristics' => $watchCharacteristics,
            'watchData' => $watch
        ];

        $this->response->setResponse(Response::RESPONSE_KEY_SUCCESS, true);
        $this->response->setResponse(Response::RESPONSE_KEY_MESSAGE, 'Successfully login data!');
        $this->response->setResponse('data', $data);
        $this->response->getReplayJson();
        exit;
    }
}