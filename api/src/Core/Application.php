<?php
/**
 * Created by PhpStorm.
 * User: Popov
 * Date: 11.5.2019 г.
 * Time: 17:56
 */

namespace WatchApp\Core;


use WatchApp\Core\MVC\MVCContext;
use WatchApp\Exceptions\ApplicationException;

class Application
{
    const VENDOR_NAMESPACE = 'WatchApp';
    const CONTROLLER_NAMESPACE = 'Controllers';
    const CONTROLLERS_SUPFIX = 'Controller';
    const NAMESPACE_SEPARATOR = '\\';

    private $mvcContext;

    public function __construct()
    {
        $this->mvcContext = MVCContext::instance();
    }

    public function start()
    {
        $controllerFullNameWithNamespace =
            self::VENDOR_NAMESPACE
            . self::NAMESPACE_SEPARATOR
            . self::CONTROLLER_NAMESPACE
            . self::NAMESPACE_SEPARATOR
            . ucfirst($this->mvcContext->getController())
            . self::CONTROLLERS_SUPFIX;

        if (empty($this->mvcContext->getController())) {
            throw new ApplicationException('Controller is missing');
        }

        if (empty($this->mvcContext->getAction())) {
            throw new ApplicationException('Action is missing');
        }

        if (!class_exists($controllerFullNameWithNamespace)) {
            throw new ApplicationException('Controller do not exist');
        }

        $controller = new $controllerFullNameWithNamespace;

        if (!method_exists($controller, $this->mvcContext->getAction())) {
            throw new ApplicationException('Action do not exist');
        }

        call_user_func_array([$controller, $this->mvcContext->getAction()], $this->mvcContext->getArguments());
    }
}