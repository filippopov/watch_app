<?php
/**
 * Created by PhpStorm.
 * User: Popov
 * Date: 19.5.2019 г.
 * Time: 11:12
 */

namespace WatchApp\Services\WatchData;


use WatchApp\Core\MVC\Session;
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
use WatchApp\Repositories\WatchData\WatchFunctionsRepository;
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

    public function getWatchCharacteristics()
    {
        $result = $this->watchCharacteristicRepository->findAll();

        foreach($result as $key => $value){
            $isEven = ($key + 1) % 2 === 0;
            $result[$key]['isEven'] = $isEven;
        }

        return $result;
    }
}