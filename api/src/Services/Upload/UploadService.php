<?php
/**
 * Created by PhpStorm.
 * User: Popov
 * Date: 22.5.2019 г.
 * Time: 12:03
 */

namespace WatchApp\Services\Upload;


use WatchApp\Exceptions\ApplicationException;
use WatchApp\Repositories\Picture\UploadPictureRepository;

class UploadService implements UploadServiceInterface
{
    private $uploadPictureRepository;

    public function __construct()
    {
        $this->uploadPictureRepository = new UploadPictureRepository();
    }

    public function upload($fileInfo, $destination, $userId): array
    {
        $picturePath = [];
        $pictureIds = [];

        if (!empty($fileInfo)) {
            foreach($fileInfo['name'] as $position => $name) {
                $picturePath[] = $this->uploadPicture($fileInfo, $position, $destination);
            }
        }

        if (!empty($picturePath)) {
            $pictureIds[] = $this->savePicture($picturePath, $userId);
        }


        return $pictureIds;
    }

    private function uploadPicture($fileInfo, $position, $destination)
    {
        if (strstr($fileInfo['type'][$position], 'image') === false) {
            throw new ApplicationException('Invalid image file');
        }

        if ($fileInfo['size'][$position] > 3000000) {
            throw new ApplicationException('File is too big');
        }

        $fileName = $destination
            . '/' . uniqid() . '_' . $fileInfo['name'][$position];

        $result = move_uploaded_file($fileInfo['tmp_name'][$position], $fileName);

        $fileName = dirname($_SERVER['PHP_SELF']) .
            '/'
            .
            $fileName;

        if ($result == false) {
            throw new ApplicationException("Upload failed");
        }

        return $fileName;
    }

    private function savePicture(array $pictures, $userId) : array
    {
        $pictureIds = [];
        if (!empty($pictures)) {
            foreach($pictures as $path) {
                $result = $this->uploadPictureRepository->create(['path' => $path, 'user_id' => $userId, 'is_active' => 1]);
                if (!$result) {
                    throw new ApplicationException('Can not save pictures!');
                }

                $pictureIds[] = $result;
            }
        }

        return $pictureIds;
    }
}