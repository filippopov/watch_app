<?php
/**
 * Created by PhpStorm.
 * User: Popov
 * Date: 11.5.2019 г.
 * Time: 13:25
 */

namespace WatchApp\Core\MVC;


class MVCContext
{
    private static $inst = null;
    private $controller = '';
    private $action = '';
    private $urlJunk = '';
    private $arguments = [];

    public static function instance()
    {
        if (self::$inst === null) {
            self::$inst = new MVCContext();
        }

        return self::$inst;
    }

    private function __construct()
    {

    }

    /**
     * @param string $controller
     */
    public function setController(string $controller)
    {
        $this->controller = $controller;
    }

    /**
     * @param string $action
     */
    public function setAction(string $action)
    {
        $this->action = $action;
    }

    /**
     * @param string $urlJunk
     */
    public function setUrlJunk(string $urlJunk)
    {
        $this->urlJunk = $urlJunk;
    }

    /**
     * @param array $arguments
     */
    public function setArguments(array $arguments)
    {
        $this->arguments = $arguments;
    }

    /**
     * @return string
     */
    public function getController() : string
    {
        return $this->controller;
    }

    /**
     * @return string
     */
    public function getAction() : string
    {
        return $this->action;
    }

    /**
     * @return string
     */
    public function getUrlJunk() : string
    {
        return $this->urlJunk;
    }

    /**
     * @return array
     */
    public function getArguments() : array
    {
        return $this->arguments;
    }
}