<?php
/**
 * Created by PhpStorm.
 * User: Popov
 * Date: 22.5.2019 г.
 * Time: 21:40
 */

namespace WatchApp\Repositories\WatchData;


use WatchApp\Repositories\AbstractRepository;

class WatchesRepository extends AbstractRepository
{
    public function __construct()
    {
        parent::__construct();
    }

    public function setOptions()
    {
        return [
            'tableName' => 'watches',
            'primaryKeyName' => 'id'
        ];
    }

    public function getWatchesModelsByUserId(int $userId) : array
    {
        $qry = "
            SELECT
                b.name AS brands_name,
                w.model,
                w.id AS watch_id,
                    (SELECT
                        up.path
                    FROM upload_picture_watches AS upw
                    INNER JOIN upload_picture AS up ON (upw.upload_picture_fk = up.id)
                    WHERE upw.watch_fk = w.id
                    ORDER BY upw.id
                    LIMIT 1) AS path
            FROM watches AS w
            INNER JOIN brands AS b ON (w.brand_fk = b.id)
            WHERE w.user_id = :user_id;
        ";

        $stmt = $this->db->prepare($qry);

        $stmt->execute([':user_id' => $userId]);

        return $stmt->fetchAll();
    }

    public function getWatchPictures(int $watchId, int $userId) : array
    {
        $qry = "SELECT
                    upw.id AS upw_id,
                    upw.watch_fk,
                    up.user_id,
                    up.path,
                    up.id AS up_id
                FROM upload_picture_watches AS upw
                INNER JOIN upload_picture AS up ON (upw.upload_picture_fk = up.id)
                WHERE upw.watch_fk = :watch_id
                AND up.user_id = :user_id
        ";

        $stmt = $this->db->prepare($qry);

        $stmt->execute([':watch_id' => $watchId, ':user_id' => $userId]);

        return $stmt->fetchAll();
    }
}