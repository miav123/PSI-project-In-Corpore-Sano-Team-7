<?php

/*
 *  Mia Vucinic 0224/2019
 */

namespace App\Models;

use CodeIgniter\Database\ConnectionInterface;

/**
 * UnosHraneModel_charts_v1 - class that fetches current week's, month's or average year's training data from the database.
 * @version 1.0
 * @author Mia Vucinic
 */
class UnosHraneModel_charts_v1 {
    /**
     * @var $db ConnectionInterface
     */
    protected $db;

    /**
     * Constructor
     * @param ConnectionInterface $db
     */
    public function __construct(ConnectionInterface &$db) {
        $this->db = &$db;
    }

    /**
     * Function that fetches current week's data for user whose id is passed as parameter.
     * Returns number of calories (result) consumed by the user for each day of the current week (day_of_week).
     * Only days for which record exists are counted.
     * @param $user_id
     * @return array|array[]
     */
    public function getCurrentWeekDataForUser($user_id) {
        $user_id = $this->db->escape($user_id);
        return $this->db->query("
                                    WITH RECURSIVE days_in_week (id_day) AS (
                                        SELECT(1)
                                        UNION ALL
                                        SELECT id_day + 1 FROM days_in_week WHERE id_day < 7
                                    )
                                    
                                    SELECT id_day AS day_of_week, COALESCE((
                                        SELECT SUM(kolicina_svake_nam_u_g / 100 * kcal_na_100g)
                                        FROM `obrok_sadrzi_namirnice`, `namirnica`, `unos_hrane`
                                        WHERE id_kor = {$user_id} AND YEARWEEK(DATE(datum), 1) = YEARWEEK(DATE(NOW()), 1) AND DAYOFWEEK(DATE(datum)) = id_day AND `obrok_sadrzi_namirnice`.id_nam = `namirnica`.id_nam AND `unos_hrane`.`id_obr` = `obrok_sadrzi_namirnice`.`id_obr`
                                        GROUP BY DATE(datum)
                                    ), 0) as result
                                    FROM `days_in_week`
                                    ORDER BY day_of_week ASC")
            ->getResultArray();
    }

    /**
     * Function that fetches current month's data for user whose id is passed as parameter.
     * Returns number of calories (result) consumed by the user for each day of the current month (day_in_month).
     * Only days for which record exists are counted.
     * @param $user_id
     * @return array|array[]
     */
    public function getCurrentMonthDataForUser($user_id) {
        $user_id = $this->db->escape($user_id);
        return $this->db->query("
                                    WITH RECURSIVE days_in_month (id_day) AS (
                                        SELECT(1)
                                        UNION ALL
                                        SELECT id_day + 1 FROM days_in_month WHERE id_day < (
                                            SELECT
                                            CASE 
                                                WHEN MONTH(NOW()) = 1 OR MONTH(NOW()) = 3 OR MONTH(NOW()) = 5 OR MONTH(NOW()) = 7 OR MONTH(NOW()) = 8 OR MONTH(NOW()) = 10 OR MONTH(NOW()) = 12 THEN 31
                                                WHEN MONTH(NOW()) = 4 OR MONTH(NOW()) = 6 OR MONTH(NOW()) = 9 OR MONTH(NOW()) = 11 THEN 30
                                                WHEN MONTH(NOW()) = 2 AND ((YEAR(NOW()) % 4 = 0 AND YEAR(NOW()) % 100 <> 0) OR YEAR(NOW()) % 400 = 0) THEN 29
                                                WHEN MONTH(NOW()) = 2 AND NOT ((YEAR(NOW()) % 4 = 0 AND YEAR(NOW()) % 100 <> 0) OR YEAR(NOW()) % 400 = 0) THEN 28
                                            END
                                        )
                                    )
                                    
                                    SELECT id_day AS day_in_month, MONTH(DATE(NOW())) AS month, COALESCE(
                                    (
                                        SELECT SUM(kolicina_svake_nam_u_g / 100 * kcal_na_100g)
                                        FROM `obrok_sadrzi_namirnice`, `namirnica`, `unos_hrane`
                                        WHERE id_kor = {$user_id} AND MONTH(NOW()) = MONTH(DATE(datum)) AND DAY(DATE(datum)) = id_day AND `obrok_sadrzi_namirnice`.id_nam = `namirnica`.id_nam AND `unos_hrane`.`id_obr` = `obrok_sadrzi_namirnice`.`id_obr`
                                        GROUP BY DATE(datum)
                                    ), 0) as result
                                    FROM `days_in_month`
                                    ORDER BY day_in_month ASC")
            ->getResultArray();
    }

    /**
     * Function that fetches current year's data for user whose id is passed as parameter.
     * Returns average number of calories (result) consumed by the user for each month (month) of the current year.
     * Only days for which record exists are counted.
     * @param $user_id
     * @return array|array[]
     */
    public function getCurrentYearDataForUser($user_id) {
        $user_id = $this->db->escape($user_id);
        return $this->db->query("
                                    WITH RECURSIVE months (id_month) AS (
                                        SELECT(1)
                                        UNION ALL
                                        SELECT id_month + 1 FROM months WHERE id_month < 12
                                    )
                                    
                                    SELECT id_month as month, COALESCE((
                                        SELECT AVG(result)
                                        FROM 
                                        (
                                            SELECT SUM(kolicina_svake_nam_u_g / 100 * kcal_na_100g) AS result, datum
                                            FROM `obrok_sadrzi_namirnice`, `namirnica`, `unos_hrane`
                                            WHERE id_kor = {$user_id} AND YEAR(NOW()) = YEAR(DATE(datum)) AND `obrok_sadrzi_namirnice`.`id_nam` = `namirnica`.`id_nam` AND `unos_hrane`.`id_obr` = `obrok_sadrzi_namirnice`.`id_obr`
                                            GROUP BY DATE(datum)
                                        ) q
                                        WHERE MONTH(DATE(datum)) = id_month
                                        GROUP BY MONTH(datum)
                                    ), 0) as result
                                    FROM `months`
                                    ORDER BY month ASC")
            ->getResultArray();
    }
}
