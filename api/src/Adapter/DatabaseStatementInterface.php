<?php
/**
 * Created by PhpStorm.
 * User: Popov
 * Date: 12.5.2019 г.
 * Time: 8:19
 */

namespace WatchApp\Adapter;


interface DatabaseStatementInterface
{
    public function execute(array $args = []): bool;

    public function fetch();

    public function fetchAll();

    public function fetchObject(string $class);

    public function rowCount();
}