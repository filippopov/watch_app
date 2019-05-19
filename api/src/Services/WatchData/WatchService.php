<?php
/**
 * Created by PhpStorm.
 * User: Popov
 * Date: 19.5.2019 г.
 * Time: 11:12
 */

namespace WatchApp\Services\WatchData;


use WatchApp\Core\MVC\Session;
use WatchApp\Repositories\WatchData\BraceletMaterialsRepository;
use WatchApp\Repositories\WatchData\BrandsRepository;
use WatchApp\Repositories\WatchData\CaseMaterialsRepository;
use WatchApp\Repositories\WatchData\GendersRepository;
use WatchApp\Repositories\WatchData\MovementsRepository;

class WatchService
{
    private $session;

    private $brandsRepository;

    private $gendersRepository;

    private $movementsRepository;

    private $caseMaterialsRepository;

    private $braceletMaterialsRepository;

    public function __construct()
    {
        $this->session = Session::instance($_SESSION);
        $this->brandsRepository = new BrandsRepository();
        $this->gendersRepository = new GendersRepository();
        $this->movementsRepository = new MovementsRepository();
        $this->caseMaterialsRepository = new CaseMaterialsRepository();
        $this->braceletMaterialsRepository = new BraceletMaterialsRepository();
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
}