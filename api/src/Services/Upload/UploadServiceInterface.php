<?php
/**
 * Created by PhpStorm.
 * User: Popov
 * Date: 22.5.2019 г.
 * Time: 12:03
 */

namespace WatchApp\Services\Upload;


interface UploadServiceInterface
{
    public function upload($fileInfo, $destination, $userId): array;
}