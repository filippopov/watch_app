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
                    AND up.is_active = 1
                    ORDER BY upw.id
                    LIMIT 1) AS path
            FROM watches AS w
            INNER JOIN brands AS b ON (w.brand_fk = b.id)
            WHERE w.user_id = :user_id AND w.is_active = 1;
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
                INNER JOIN watches AS w ON (upw.watch_fk = w.id)
                WHERE upw.watch_fk = :watch_id
                AND up.user_id = :user_id
                AND w.is_active = 1
                AND up.is_active = 1
        ";

        $stmt = $this->db->prepare($qry);

        $stmt->execute([':watch_id' => $watchId, ':user_id' => $userId]);

        return $stmt->fetchAll();
    }

    public function getWatchData(int $watchId, int $userId) : array
    {
        $qry = "SELECT
                    b.name AS brand_name,
                    w.model,
                    w.reference_number,
                    g.name AS gender_name,
                    m.name AS movement_name,
                    cm.name AS case_material_name,
                    bm.name AS bracelet_material_name,
                    w.case_diameter,
                    bc.name AS bracelet_color_name,
                    clm.name AS clasp_material_name,
                    c.name AS clasp_name,
                    bem.name AS bezel_material_name,
                    w.thickness,
                    gla.name AS glass_name,
                    wr.name AS water_resistance_name,
                    d.name AS dial_name,
                    dn.name AS dial_numeral_name,
                    w.caliber,
                    w.base_caliber,
                    w.power_reserve,
                    w.number_of_jewels,
                    w.frequency
                FROM watches AS w
                LEFT JOIN brands AS b ON (w.brand_fk = b.id)
                LEFT JOIN genders AS g ON (w.gender_fk = g.id)
                LEFT JOIN movements AS m ON (w.movement_fk = m.id)
                LEFT JOIN case_materials AS cm ON (w.case_material_fk = cm.id)
                LEFT JOIN bracelet_material AS bm ON (w.bracelet_material_fk = bm.id)
                LEFT JOIN bracelet_color AS bc ON (w.bracelet_color_fk = bc.id)
                LEFT JOIN clasp_material AS clm ON (w.clasp_material_fk = clm.id)
                LEFT JOIN clasp AS c ON (w.clasp_fk = c.id)
                LEFT JOIN bezel_material AS bem ON (w.bezel_material_fk = bem.id)
                LEFT JOIN glass AS gla ON (w.glass_fk = gla.id)
                LEFT JOIN water_resistance AS wr ON (w.water_resistance_fk = wr.id)
                LEFT JOIN dial AS d ON (w.dial_fk = d.id)
                LEFT JOIN dial_numerals AS dn ON (w.dial_numerals_fk = dn.id)
                WHERE w.id = :watch_id
                AND w.user_id = :user_id
                AND w.is_active = 1
                LIMIT 1;
        ";

        $stmt = $this->db->prepare($qry);

        $stmt->execute([':watch_id' => $watchId, ':user_id' => $userId]);

        return $stmt->fetchAll();
    }

    public function getWatchFunctions(int $watchId) : array
    {
        $qry = "
            SELECT
                wf.name AS watch_function_name,
                wf.id
            FROM watch_function_watch AS wfw
            INNER JOIN watch_functions AS wf ON (wfw.watch_function_fk = wf.id)
            WHERE wfw.watch_fk = :watch_id;
        ";

        $stmt = $this->db->prepare($qry);

        $stmt->execute([':watch_id' => $watchId]);

        return $stmt->fetchAll();
    }

    public function getWatchCharacteristics (int $watchId) : array
    {
        $qry = "
            SELECT
                wc.name AS watch_characteristic_name,
                wc.id
            FROM watch_characteristic_watch AS wcw
            INNER JOIN watch_characteristics AS wc ON (wcw.watch_characteristic_fk = wc.id)
            WHERE wcw.watch_fk = :watch_id;
        ";

        $stmt = $this->db->prepare($qry);

        $stmt->execute([':watch_id' => $watchId]);

        return $stmt->fetchAll();
    }
}