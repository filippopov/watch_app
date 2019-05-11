<?php
/**
 * Created by PhpStorm.
 * User: Popov
 * Date: 11.5.2019 г.
 * Time: 13:24
 */

namespace WatchApp\Core\MVC;


class Get
{
    private static $inst = null;

    private $data = [];

    public static function instance(&$get)
    {
        if (self::$inst === null) {
            self::$inst = new Get($get);
        }

        return self::$inst;
    }

    public function __construct(array &$get)
    {
        $this->data = &$get;
    }

    public function get(string $key)
    {
        return isset($this->data[$key]) ? $this->data[$key] : '';
    }

    public function set($key, $value)
    {
        $this->data[$key] = $value;
    }

    public function remove($key)
    {
        unset($this->data[$key]);
    }

    public function isExists($key) : bool
    {
        return array_key_exists($key, $this->data);
    }

    public function destroy()
    {
        unset($this->data);
    }
}