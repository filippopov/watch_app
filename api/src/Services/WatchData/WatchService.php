<?php
/**
 * Created by PhpStorm.
 * User: Popov
 * Date: 19.5.2019 г.
 * Time: 11:12
 */

namespace WatchApp\Services\WatchData;


use WatchApp\Core\MVC\Session;
use WatchApp\Exceptions\ApplicationException;
use WatchApp\Repositories\Picture\UploadPictureRepository;
use WatchApp\Repositories\Picture\UploadPictureWatchRepository;
use WatchApp\Repositories\User\UsersRepository;
use WatchApp\Repositories\WatchData\BezelMaterialRepository;
use WatchApp\Repositories\WatchData\BraceletColorRepository;
use WatchApp\Repositories\WatchData\BraceletMaterialsRepository;
use WatchApp\Repositories\WatchData\BrandsRepository;
use WatchApp\Repositories\WatchData\CaseMaterialsRepository;
use WatchApp\Repositories\WatchData\ClaspMaterialRepository;
use WatchApp\Repositories\WatchData\ClaspRepository;
use WatchApp\Repositories\WatchData\DialNumeralsRepository;
use WatchApp\Repositories\WatchData\DialRepository;
use WatchApp\Repositories\WatchData\GendersRepository;
use WatchApp\Repositories\WatchData\GlassRepository;
use WatchApp\Repositories\WatchData\MovementsRepository;
use WatchApp\Repositories\WatchData\WatchCharacteristicsRepository;
use WatchApp\Repositories\WatchData\WatchCharacteristicWatchRepository;
use WatchApp\Repositories\WatchData\WatchesRepository;
use WatchApp\Repositories\WatchData\WatchFunctionsRepository;
use WatchApp\Repositories\WatchData\WatchFunctionWatchRepository;
use WatchApp\Repositories\WatchData\WaterResistanceRepository;

class WatchService
{
    private $session;

    private $brandsRepository;

    private $gendersRepository;

    private $movementsRepository;

    private $caseMaterialsRepository;

    private $braceletMaterialsRepository;

    private $braceletColorRepository;

    private $claspMaterialsRepository;

    private $claspRepository;

    private $bezelMaterialRepository;

    private $glassRepository;

    private $waterResistanceRepository;

    private $dialRepository;

    private $dialNumeralsRepository;

    private $watchFunctionsRepository;

    private $watchCharacteristicRepository;

    private $watchesRepository;

    private $usersRepository;

    private $uploadPictureWatchesRepository;

    private $watchFunctionWatchRepository;

    private $watchCharacteristicWatchRepository;

    private $uploadPictureRepository;

    public function __construct()
    {
        $this->session = Session::instance($_SESSION);
        $this->brandsRepository = new BrandsRepository();
        $this->gendersRepository = new GendersRepository();
        $this->movementsRepository = new MovementsRepository();
        $this->caseMaterialsRepository = new CaseMaterialsRepository();
        $this->braceletMaterialsRepository = new BraceletMaterialsRepository();
        $this->braceletColorRepository = new BraceletColorRepository();
        $this->claspMaterialsRepository = new ClaspMaterialRepository();
        $this->claspRepository = new ClaspRepository();
        $this->bezelMaterialRepository = new BezelMaterialRepository();
        $this->glassRepository = new GlassRepository();
        $this->waterResistanceRepository = new WaterResistanceRepository();
        $this->dialRepository = new DialRepository();
        $this->dialNumeralsRepository = new DialNumeralsRepository();
        $this->watchFunctionsRepository = new WatchFunctionsRepository();
        $this->watchCharacteristicRepository = new WatchCharacteristicsRepository();
        $this->watchesRepository = new WatchesRepository();
        $this->usersRepository = new UsersRepository();
        $this->uploadPictureWatchesRepository = new UploadPictureWatchRepository();
        $this->watchFunctionWatchRepository = new WatchFunctionWatchRepository();
        $this->watchCharacteristicWatchRepository = new WatchCharacteristicWatchRepository();
        $this->uploadPictureRepository = new UploadPictureRepository();
    }

    public function getWatchBrands()
    {
        return $this->brandsRepository->findAll();
    }

    public function getGenders()
    {
        return $this->gendersRepository->findAll();
    }

    public function getMovements()
    {
        return $this->movementsRepository->findAll();
    }

    public function getCaseMaterials()
    {
        return $this->caseMaterialsRepository->findAll();
    }

    public function getBraceletMaterials()
    {
        return $this->braceletMaterialsRepository->findAll();
    }

    public function getBraceletColors()
    {
        return $this->braceletColorRepository->findAll();
    }

    public function getClaspMaterials()
    {
        return $this->claspMaterialsRepository->findAll();
    }

    public function getClaspTypes()
    {
        return $this->claspRepository->findAll();
    }

    public function getBezelMaterials()
    {
        return $this->bezelMaterialRepository->findAll();
    }

    public function getGlassTypes()
    {
        return $this->glassRepository->findAll();
    }

    public function getWaterResistance()
    {
        return $this->waterResistanceRepository->findAll();
    }

    public function getDialTypes()
    {
        return $this->dialRepository->findAll();
    }

    public function getDialNumeralsTypes()
    {
        return $this->dialNumeralsRepository->findAll();
    }

    public function getWatchFunctions()
    {
        $result =  $this->watchFunctionsRepository->findAll();

        foreach($result as $key => $value){
            $isEven = ($key + 1) % 2 === 0;
            $result[$key]['isEven'] = $isEven;
        }

        return $result;
    }

    public function createWatch($baseCaliber, $bezelMaterial, $braceletColor, $braceletMaterial, $brand,
                                $caliber, $claspMaterial, $caseDiameter, $caseMaterial, $clasp, $dial, $dialNumerals, $frequency,
                                $gender, $glass, $model, $movement, $picture, $powerReserve, $referenceNumber, $thickness,
                                $watchCharacteristics, $watchFunctions, $waterResistance, $numberOfJewels, $userId)
    {

        $params = [];

        if ($brand === '') {
            throw new ApplicationException('Please select brand!');
        }

        if ($userId === '') {
            throw new ApplicationException('User Error');
        }

        if ($model === '') {
            throw new ApplicationException('Please set model!');
        }

        $brandResult = $this->brandsRepository->findByCondition(['id' => $brand]);

        if (empty($brandResult)){
            throw new ApplicationException('Please enter valid brand!');
        }

        $userResult = $this->usersRepository->findByCondition(['id' => $userId]);

        if (empty($userResult)){
            throw new ApplicationException('Please enter valid user!');
        }

        $params = [
            'brand_fk' => $brand, 'user_id' => $userId, 'model' => $model
        ];

        if ($baseCaliber !== '') {
            $params['base_caliber'] = $baseCaliber;
        }

        if ($bezelMaterial !== '') {
            $bezelMaterialResult = $this->bezelMaterialRepository->findByCondition(['id' => $bezelMaterial]);

            if (empty($bezelMaterialResult)) {
                throw new ApplicationException('Please enter valid bezel material!');
            }

            $params['bezel_material_fk'] = $bezelMaterial;
        }

        if ($braceletColor !== '') {
            $braceletColorResult = $this->braceletColorRepository->findByCondition(['id' => $braceletColor]);

            if (empty($braceletColorResult)) {
                throw new ApplicationException('Please enter valid bracelet color!');
            }

            $params['bracelet_color_fk'] = $braceletColor;
        }

        if ($braceletMaterial !== '') {
            $braceletMaterialResult = $this->braceletMaterialsRepository->findByCondition(['id' => $braceletMaterial]);

            if (empty($braceletMaterialResult)) {
                throw new ApplicationException('Please enter valid bracelet material!');
            }

            $params['bracelet_material_fk'] = $braceletMaterial;
        }

        if ($caliber !== '') {
            $params['caliber'] = $caliber;
        }

        if ($claspMaterial !== '') {
            $claspMaterialResult = $this->claspMaterialsRepository->findByCondition(['id' => $claspMaterial]);

            if (empty($claspMaterialResult)) {
                throw new ApplicationException('Please enter valid clasp material!');
            }

            $params['clasp_material_fk'] = $claspMaterial;
        }

        if ($caseDiameter !== '') {
            $caseDiameter = (float) $caseDiameter;
            $params['case_diameter'] = $caseDiameter;
        }

        if ($caseMaterial !== '') {
            $caseMaterialResult = $this->caseMaterialsRepository->findByCondition(['id' => $caseMaterial]);

            if (empty($caseMaterialResult)) {
                throw new ApplicationException('Please enter valid case material!');
            }

            $params['case_material_fk'] = $caseMaterial;
        }

        if ($clasp !== '') {
            $claspResult = $this->claspRepository->findByCondition(['id' => $clasp]);

            if (empty($claspResult)) {
                throw new ApplicationException('Please enter valid clasp!');
            }

            $params['clasp_fk'] = $clasp;
        }

        if ($dial !== '') {
            $dialResult = $this->dialRepository->findByCondition(['id' => $dial]);

            if (empty($dialResult)) {
                throw new ApplicationException('Please enter valid dial!');
            }

            $params['dial_fk'] = $dial;
        }

        if ($dialNumerals !== '') {
            $dialNumeralsResult = $this->dialNumeralsRepository->findByCondition(['id' => $dialNumerals]);

            if (empty($dialNumeralsResult)) {
                throw new ApplicationException('Please enter valid dial numerals!');
            }

            $params['dial_numerals_fk'] = $dialNumerals;
        }

        if ($frequency !== '') {
            $frequency = (int) $frequency;
            $params['frequency'] = $frequency;
        }

        if ($gender !== '') {
            $genderResult = $this->gendersRepository->findByCondition(['id' => $gender]);

            if (empty($genderResult)) {
                throw new ApplicationException('Please enter valid gender!');
            }

            $params['gender_fk'] = $gender;
        }

        if ($gender !== '') {
            $genderResult = $this->gendersRepository->findByCondition(['id' => $gender]);

            if (empty($genderResult)) {
                throw new ApplicationException('Please enter valid gender!');
            }

            $params['gender_fk'] = $gender;
        }

        if ($glass !== '') {
            $glassResult = $this->glassRepository->findByCondition(['id' => $glass]);

            if (empty($glassResult)) {
                throw new ApplicationException('Please enter valid glass!');
            }

            $params['glass_fk'] = $glass;
        }

        if ($movement !== '') {
            $movementResult = $this->movementsRepository->findByCondition(['id' => $movement]);

            if (empty($movementResult)) {
                throw new ApplicationException('Please enter valid movement!');
            }

            $params['movement_fk'] = $movement;
        }

        if ($powerReserve !== '') {
            $powerReserve = (int) $powerReserve;
            $params['power_reserve'] = $powerReserve;
        }

        if ($referenceNumber !== '') {
            $params['reference_number'] = $referenceNumber;
        }

        if ($thickness !== '') {
            $thickness = (float) $thickness;
            $params['thickness'] = $thickness;
        }

        if ($waterResistance !== '') {
            $waterResistanceResult = $this->waterResistanceRepository->findByCondition(['id' => $waterResistance]);

            if (empty($waterResistanceResult)) {
                throw new ApplicationException('Please enter valid water resistance!');
            }

            $params['water_resistance_fk'] = $waterResistance;
        }

        if ($numberOfJewels !== '') {
            $numberOfJewels = (int) $numberOfJewels;
            $params['number_of_jewels'] = $numberOfJewels;
        }

        $params['is_active'] = 1;

        $result = $this->watchesRepository->create($params);

        if (!$result) {
            throw new ApplicationException('System Error!');
        }

        $watchId = (int) $result;

        if ($picture !== '') {
            $pictures = explode(',', $picture);

            foreach ($pictures as $pictureId) {
                $pictureId = (int) $pictureId;
                $isSavePicture = $this->savePicture($watchId, $pictureId);
            }
        }

        if ($watchCharacteristics !== '') {
            foreach ($watchCharacteristics as $watchCharacteristic) {
                $watchCharacteristicId = (int) $watchCharacteristic;
                $isSaveWatchCharacteristic = $this->saveWatchCharacteristic($watchId, $watchCharacteristicId);
            }
        }

        if ($watchFunctions !== '') {
            foreach ($watchFunctions as $watchFunction) {
                $watchFunctionId = (int) $watchFunction;
                $isSaveWatchFunction = $this->saveWatchFunction($watchId, $watchFunctionId);
            }
        }

        return $result;
    }

    public function editWatch($baseCaliber, $bezelMaterial, $braceletColor, $braceletMaterial, $brand,
                                $caliber, $claspMaterial, $caseDiameter, $caseMaterial, $clasp, $dial, $dialNumerals, $frequency,
                                $gender, $glass, $model, $movement, $picture, $powerReserve, $referenceNumber, $thickness,
                                $watchCharacteristics, $watchFunctions, $waterResistance, $numberOfJewels, $userId, $watchId)
    {

        $params = [];

        $isExistWatch = $this->watchesRepository->findByCondition(['id' => $watchId, 'user_id' => $userId, 'is_active' => 1]);

        if (empty($isExistWatch)) {
            throw new ApplicationException('No watch!');
        }

        if ($brand === '') {
            throw new ApplicationException('Please select brand!');
        }

        if ($userId === '') {
            throw new ApplicationException('User Error');
        }

        if ($model === '') {
            throw new ApplicationException('Please set model!');
        }

        $brandResult = $this->brandsRepository->findByCondition(['id' => $brand]);

        if (empty($brandResult)){
            throw new ApplicationException('Please enter valid brand!');
        }

        $userResult = $this->usersRepository->findByCondition(['id' => $userId]);

        if (empty($userResult)){
            throw new ApplicationException('Please enter valid user!');
        }

        $params = [
            'brand_fk' => $brand, 'user_id' => $userId, 'model' => $model
        ];

        if ($baseCaliber !== '') {
            $params['base_caliber'] = $baseCaliber;
        }

        if ($bezelMaterial !== '') {
            $bezelMaterialResult = $this->bezelMaterialRepository->findByCondition(['id' => $bezelMaterial]);

            if (empty($bezelMaterialResult)) {
                throw new ApplicationException('Please enter valid bezel material!');
            }

            $params['bezel_material_fk'] = $bezelMaterial;
        }

        if ($braceletColor !== '') {
            $braceletColorResult = $this->braceletColorRepository->findByCondition(['id' => $braceletColor]);

            if (empty($braceletColorResult)) {
                throw new ApplicationException('Please enter valid bracelet color!');
            }

            $params['bracelet_color_fk'] = $braceletColor;
        }

        if ($braceletMaterial !== '') {
            $braceletMaterialResult = $this->braceletMaterialsRepository->findByCondition(['id' => $braceletMaterial]);

            if (empty($braceletMaterialResult)) {
                throw new ApplicationException('Please enter valid bracelet material!');
            }

            $params['bracelet_material_fk'] = $braceletMaterial;
        }

        if ($caliber !== '') {
            $params['caliber'] = $caliber;
        }

        if ($claspMaterial !== '') {
            $claspMaterialResult = $this->claspMaterialsRepository->findByCondition(['id' => $claspMaterial]);

            if (empty($claspMaterialResult)) {
                throw new ApplicationException('Please enter valid clasp material!');
            }

            $params['clasp_material_fk'] = $claspMaterial;
        }

        if ($caseDiameter !== '') {
            $caseDiameter = (float) $caseDiameter;
            $params['case_diameter'] = $caseDiameter;
        }

        if ($caseMaterial !== '') {
            $caseMaterialResult = $this->caseMaterialsRepository->findByCondition(['id' => $caseMaterial]);

            if (empty($caseMaterialResult)) {
                throw new ApplicationException('Please enter valid case material!');
            }

            $params['case_material_fk'] = $caseMaterial;
        }

        if ($clasp !== '') {
            $claspResult = $this->claspRepository->findByCondition(['id' => $clasp]);

            if (empty($claspResult)) {
                throw new ApplicationException('Please enter valid clasp!');
            }

            $params['clasp_fk'] = $clasp;
        }

        if ($dial !== '') {
            $dialResult = $this->dialRepository->findByCondition(['id' => $dial]);

            if (empty($dialResult)) {
                throw new ApplicationException('Please enter valid dial!');
            }

            $params['dial_fk'] = $dial;
        }

        if ($dialNumerals !== '') {
            $dialNumeralsResult = $this->dialNumeralsRepository->findByCondition(['id' => $dialNumerals]);

            if (empty($dialNumeralsResult)) {
                throw new ApplicationException('Please enter valid dial numerals!');
            }

            $params['dial_numerals_fk'] = $dialNumerals;
        }

        if ($frequency !== '') {
            $frequency = (int) $frequency;
            $params['frequency'] = $frequency;
        }

        if ($gender !== '') {
            $genderResult = $this->gendersRepository->findByCondition(['id' => $gender]);

            if (empty($genderResult)) {
                throw new ApplicationException('Please enter valid gender!');
            }

            $params['gender_fk'] = $gender;
        }

        if ($gender !== '') {
            $genderResult = $this->gendersRepository->findByCondition(['id' => $gender]);

            if (empty($genderResult)) {
                throw new ApplicationException('Please enter valid gender!');
            }

            $params['gender_fk'] = $gender;
        }

        if ($glass !== '') {
            $glassResult = $this->glassRepository->findByCondition(['id' => $glass]);

            if (empty($glassResult)) {
                throw new ApplicationException('Please enter valid glass!');
            }

            $params['glass_fk'] = $glass;
        }

        if ($movement !== '') {
            $movementResult = $this->movementsRepository->findByCondition(['id' => $movement]);

            if (empty($movementResult)) {
                throw new ApplicationException('Please enter valid movement!');
            }

            $params['movement_fk'] = $movement;
        }

        if ($powerReserve !== '') {
            $powerReserve = (int) $powerReserve;
            $params['power_reserve'] = $powerReserve;
        }

        if ($referenceNumber !== '') {
            $params['reference_number'] = $referenceNumber;
        }

        if ($thickness !== '') {
            $thickness = (float) $thickness;
            $params['thickness'] = $thickness;
        }

        if ($waterResistance !== '') {
            $waterResistanceResult = $this->waterResistanceRepository->findByCondition(['id' => $waterResistance]);

            if (empty($waterResistanceResult)) {
                throw new ApplicationException('Please enter valid water resistance!');
            }

            $params['water_resistance_fk'] = $waterResistance;
        }

        if ($numberOfJewels !== '') {
            $numberOfJewels = (int) $numberOfJewels;
            $params['number_of_jewels'] = $numberOfJewels;
        }

        $params['is_active'] = 1;

        $result = $this->watchesRepository->update($watchId, $params);

        if (!$result) {
            throw new ApplicationException('System Error!');
        }

        if ($picture !== '') {
            $pictures = explode(',', $picture);

            foreach ($pictures as $pictureId) {
                $pictureId = (int) $pictureId;
                $isSavePicture = $this->savePicture($watchId, $pictureId);
            }
        }

        $findWatchCharacteristics = $this->watchCharacteristicWatchRepository->findByCondition(['watch_fk' => $watchId]);

        if (!empty($findWatchCharacteristics)) {
            foreach ($findWatchCharacteristics as $findWatchCharacteristic) {
                $id = isset($findWatchCharacteristic['id']) ? $findWatchCharacteristic['id'] : 0;
                $this->watchCharacteristicWatchRepository->delete($id);
            }
        }

        $findWatchFunctions = $this->watchFunctionWatchRepository->findByCondition(['watch_fk' => $watchId]);

        if (!empty($findWatchFunctions)) {
            foreach ($findWatchFunctions as $findWatchFunction) {
                $id = isset($findWatchFunction['id']) ? $findWatchFunction['id'] : 0;
                $this->watchFunctionWatchRepository->delete($id);
            }
        }

        if ($watchCharacteristics !== '') {
            foreach ($watchCharacteristics as $watchCharacteristic) {
                $watchCharacteristicId = (int) $watchCharacteristic;
                $isSaveWatchCharacteristic = $this->saveWatchCharacteristic($watchId, $watchCharacteristicId);
            }
        }

        if ($watchFunctions !== '') {
            foreach ($watchFunctions as $watchFunction) {
                $watchFunctionId = (int) $watchFunction;
                $isSaveWatchFunction = $this->saveWatchFunction($watchId, $watchFunctionId);
            }
        }

        return $result;
    }

    public function getWatchCharacteristics()
    {
        $result = $this->watchCharacteristicRepository->findAll();

        foreach($result as $key => $value){
            $isEven = ($key + 1) % 2 === 0;
            $result[$key]['isEven'] = $isEven;
        }

        return $result;
    }

    public function getWatchesModelsByUserId(int $userId) : array
    {
        if (!$userId) {
            throw new ApplicationException('User problem!');
        }

        $user = $this->usersRepository->findByCondition(['id' => $userId]);

        if (empty($user)) {
            throw new ApplicationException('User do not exist');
        }

        return $this->watchesRepository->getWatchesModelsByUserId($userId);
    }

    public function getWatchPictures(int $watchId, int $userId) : array
    {
        if (!$userId) {
            throw new ApplicationException('User problem!');
        }

        $user = $this->usersRepository->findByCondition(['id' => $userId]);

        if (empty($user)) {
            throw new ApplicationException('User do not exist');
        }

        if (!$watchId) {
            throw new ApplicationException('Watch problem!');
        }

        $watch = $this->watchesRepository->findByCondition(['id' => $watchId]);

        if (empty($watch)) {
            throw new ApplicationException('Watch do not exist');
        }

        return $this->watchesRepository->getWatchPictures($watchId, $userId);
    }

    public function getWatchData(int $watchId, int $userId) : array
    {
        if (!$userId) {
            throw new ApplicationException('User problem!');
        }

        $user = $this->usersRepository->findByCondition(['id' => $userId]);

        if (empty($user)) {
            throw new ApplicationException('User do not exist');
        }

        if (!$watchId) {
            throw new ApplicationException('Watch problem!');
        }

        $watch = $this->watchesRepository->findByCondition(['id' => $watchId]);

        if (empty($watch)) {
            throw new ApplicationException('Watch do not exist');
        }

        return $this->watchesRepository->getWatchData($watchId, $userId);
    }

    public function watchFunctions(int $watchId) : array
    {
        if (!$watchId) {
            throw new ApplicationException('Watch problem!');
        }

        $watch = $this->watchesRepository->findByCondition(['id' => $watchId]);

        if (empty($watch)) {
            throw new ApplicationException('Watch do not exist');
        }

        return $this->watchesRepository->getWatchFunctions($watchId);
    }

    public function watchCharacteristics(int $watchId) : array
    {
        if (!$watchId) {
            throw new ApplicationException('Watch problem!');
        }

        $watch = $this->watchesRepository->findByCondition(['id' => $watchId]);

        if (empty($watch)) {
            throw new ApplicationException('Watch do not exist');
        }

        return $this->watchesRepository->getWatchCharacteristics($watchId);
    }

    public function deleteWatch(int $watchId)
    {
        if (!$watchId) {
            throw new ApplicationException('Watch problem!');
        }

        $watch = $this->watchesRepository->findByCondition(['id' => $watchId]);

        if (empty($watch)) {
            throw new ApplicationException('Watch do not exist');
        }

        return $this->watchesRepository->update($watchId, ['is_active' => 0]);
    }

    public function isWatchExist(int $watchId, int $userId)
    {
        if (!$watchId) {
            throw new ApplicationException('Watch problem!');
        }

        $watch = $this->watchesRepository->findByCondition(['id' => $watchId]);

        if (empty($watch)) {
            throw new ApplicationException('Watch do not exist');
        }

        return $this->watchesRepository->findByCondition(['id' => $watchId, 'is_active' => 1, 'user_id' => $userId]);
    }

    public function deletePicture(int $pictureId, int $watchId, int $userId)
    {
        if (!$watchId) {
            throw new ApplicationException('Watch problem!');
        }

        if (!$pictureId) {
            throw new ApplicationException('Picture problem!');
        }

        $picture = $this->uploadPictureRepository->getPicture($pictureId, $watchId, $userId);

        if (empty($picture)) {
            throw new ApplicationException('Picture do not exist!');
        }

        return $this->uploadPictureRepository->update($pictureId, ['is_active' => 0]);
    }

    public function setSelectedValue(array $watch, array $table, string $column):array
    {
        $watch = isset($watch[0]) ? $watch[0] : [];
        $watchValue = isset($watch[$column]) ? $watch[$column] : '';

        if (!empty($table)) {
            foreach($table as $key => $value) {
                $table[$key]['selected'] = '';

                if ($watchValue == $value['id']) {
                    $table[$key]['selected'] = 'selected';
                }
            }
        }

        return $table;
    }

    public function setCheckedValues(array $functions, array $functionsByWatch, string $index) : array
    {
        if (!empty($functions) && !empty($functionsByWatch)) {
            foreach ($functions as $key => $function) {
                $functions[$key]['checked'] = '';
            }

            foreach ($functions as $key => $function) {
                foreach ($functionsByWatch as $functionByWatch) {
                    if (($function['id'] == $functionByWatch['id']) && ($function['name'] == $functionByWatch[$index])) {
                        $functions[$key]['checked'] = 'checked';
                    }
                }
            }
        }

        return $functions;
    }

    private function savePicture(int $watchId, int $pictureId)
    {
        $result = $this->uploadPictureWatchesRepository->create(['watch_fk' => $watchId, 'upload_picture_fk' => $pictureId]);

        if (!$result) {
            throw new ApplicationException('Pictures can not be save!');
        }

        return $result;
    }

    private function saveWatchCharacteristic(int $watchId, int $watchCharacteristicId)
    {
        $result = $this->watchCharacteristicWatchRepository->create(['watch_fk' => $watchId, 'watch_characteristic_fk' => $watchCharacteristicId]);

        if (!$result) {
            throw new ApplicationException('Watch Characteristic can not be save!');
        }

        return $result;
    }

    private function saveWatchFunction(int $watchId, int $watchFunctionId)
    {
        $result = $this->watchFunctionWatchRepository->create(['watch_fk' => $watchId, 'watch_function_fk' => $watchFunctionId]);

        if (!$result) {
            throw new ApplicationException('Watch Function can not be save!');
        }

        return $result;
    }
}