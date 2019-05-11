<?php
/**
 * Created by PhpStorm.
 * User: Popov
 * Date: 11.5.2019 г.
 * Time: 13:24
 */

namespace WatchApp\Core\MVC;


class Session
{
    private static $inst = null;

    private $data = [];

    public static function instance(&$session)
    {
        if (self::$inst === null) {
            self::$inst = new Session($session);
        }

        return self::$inst;
    }

    private function __construct(&$data)
    {
        $this->data = &$data;
    }

    public function get($key)
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

    public function isExists($key): bool
    {
        return array_key_exists($key, $this->data);
    }

    public function destroy()
    {
        unset($this->data);
        session_destroy();
    }
}