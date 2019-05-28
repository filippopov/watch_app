<?php
/**
 * Created by PhpStorm.
 * User: Popov
 * Date: 22.5.2019 г.
 * Time: 14:40
 */

namespace WatchApp\Repositories\Picture;


use WatchApp\Repositories\AbstractRepository;

class UploadPictureRepository extends AbstractRepository
{
    public function __construct()
    {
        parent::__construct();
    }

    public function setOptions()
    {
        return [
            'tableName' => 'upload_picture',
            'primaryKeyName' => 'id'
        ];
    }

    public function getPicture(int $pictureId, int $watchId, int $userId)
    {
        $qry = "
            SELECT
                up.id AS pictureId,
                up.path,
                up.user_id,
                up.is_active,
                upw.watch_fk AS watchId
            FROM upload_picture AS up
            INNER JOIN upload_picture_watches AS upw ON (upw.upload_picture_fk = up.id)
            WHERE up.is_active = 1
            AND up.id = :pictureId
            AND upw.watch_fk = :watch_id
            AND up.user_id = :user_id
        ";

        $stmt = $this->db->prepare($qry);

        $stmt->execute([':pictureId' => $pictureId, ':watch_id' => $watchId, ':user_id' => $userId]);

        return $stmt->fetchAll();
    }
}