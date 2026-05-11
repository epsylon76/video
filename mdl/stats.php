<?php

class stats
{
    private function normalized_type_sql()
    {
        return "CASE
            WHEN `type` = 'téléchargement_photos' THEN 'dl_photos'
            WHEN `type` = 'téléchargement_videos' THEN 'dl_video'
            ELSE `type`
        END";
    }

    function set_stats($type, $heure, $taille)
    {
        global $DB_con;
        $requete = "INSERT INTO `bande_passante` (`type`,`heure`,`taille`) VALUES (:type, :heure , :taille)";
        $query = $DB_con->prepare($requete);
        $query->bindParam(':type', $type);
        $query->bindParam(':heure', $heure);
        $query->bindParam(':taille', $taille);
        $query->execute();
    }

    function calcul_taille_by_period($minute)
    {
        global $DB_con; //Attention ta requete est vulnérable à l'injection SQL !
        $requete = "SELECT CONCAT(DATE_FORMAT(`heure`, '%H:'), LPAD(FLOOR(MINUTE(`heure`) / :minute)  * :minute, 2, '0')) AS periode,
        SUM(taille) AS total_taille FROM `bande_passante` GROUP BY periode ORDER BY heure";
        $query = $DB_con->prepare($requete);
        $query->bindParam(':minute', $minute);
        $query->execute();
        $results = $query->fetchAll();
        return $results;
    }


    function get_stats($date_debut, $date_fin)
    {
        global $DB_con;
        $requete = "SELECT `type`, SUM(`taille`) as 'volume' FROM `bande_passante` WHERE `heure` BETWEEN :date_debut AND :date_fin GROUP BY `type` ORDER BY `heure` ASC";
        $query = $DB_con->prepare($requete);
        $query->bindParam(':date_debut', $date_debut);
        $query->bindParam(':date_fin', $date_fin);
        $query->execute();
        $results = $query->fetchAll(PDO::FETCH_ASSOC);
        return $results;
    }

    function get_stats_by_period($date_debut, $date_fin, $period_seconds = 600)
    {
        global $DB_con;
        $requete = "SELECT
                FROM_UNIXTIME(FLOOR(UNIX_TIMESTAMP(`heure`) / :period_seconds_div) * :period_seconds_mul) AS `periode`,
                `type`,
                SUM(`taille`) AS `volume`
            FROM `bande_passante`
            WHERE `heure` >= :date_debut
                AND `heure` < :date_fin
            GROUP BY `periode`, `type`
            ORDER BY `periode` ASC";
        $query = $DB_con->prepare($requete);
        $query->bindValue(':period_seconds_div', (int) $period_seconds, PDO::PARAM_INT);
        $query->bindValue(':period_seconds_mul', (int) $period_seconds, PDO::PARAM_INT);
        $query->bindValue(':date_debut', $date_debut);
        $query->bindValue(':date_fin', $date_fin);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    function get_available_types()
    {
        global $DB_con;
        $type_sql = $this->normalized_type_sql();
        $requete = "SELECT $type_sql AS `type`, COUNT(*) AS `actions`, SUM(`taille`) AS `volume`
            FROM `bande_passante`
            GROUP BY $type_sql
            ORDER BY `volume` DESC";
        $query = $DB_con->prepare($requete);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    function get_stats_by_bucket($date_debut, $date_fin, $bucket, $period_seconds = 600, $types = array())
    {
        global $DB_con;
        $type_sql = $this->normalized_type_sql();

        switch ($bucket) {
            case 'hour':
                $period_sql = "DATE_FORMAT(`heure`, '%Y-%m-%d %H:00:00')";
                break;
            case 'day':
                $period_sql = "DATE(`heure`)";
                break;
            case 'week':
                $period_sql = "STR_TO_DATE(CONCAT(YEARWEEK(`heure`, 3), ' Monday'), '%X%V %W')";
                break;
            default:
                $period_sql = "FROM_UNIXTIME(FLOOR(UNIX_TIMESTAMP(`heure`) / :period_seconds_div) * :period_seconds_mul)";
                break;
        }

        $where = "`heure` >= :date_debut AND `heure` < :date_fin";
        $params = array(
            ':date_debut' => $date_debut,
            ':date_fin' => $date_fin,
        );

        if (!empty($types)) {
            $placeholders = array();
            foreach (array_values($types) as $index => $type) {
                $placeholder = ':type_' . $index;
                $placeholders[] = $placeholder;
                $params[$placeholder] = $type;
            }
            $where .= " AND $type_sql IN (" . implode(',', $placeholders) . ")";
        }

        $requete = "SELECT
                $period_sql AS `periode`,
                $type_sql AS `type`,
                SUM(`taille`) AS `volume`,
                COUNT(*) AS `actions`
            FROM `bande_passante`
            WHERE $where
            GROUP BY `periode`, `type`
            ORDER BY `periode` ASC";
        $query = $DB_con->prepare($requete);
        if ($bucket === 'minute') {
            $query->bindValue(':period_seconds_div', (int) $period_seconds, PDO::PARAM_INT);
            $query->bindValue(':period_seconds_mul', (int) $period_seconds, PDO::PARAM_INT);
        }
        foreach ($params as $placeholder => $value) {
            $query->bindValue($placeholder, $value);
        }
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    function get_summary($date_debut, $date_fin, $types = array())
    {
        global $DB_con;
        $type_sql = $this->normalized_type_sql();
        $where = "`heure` >= :date_debut AND `heure` < :date_fin";
        $params = array(
            ':date_debut' => $date_debut,
            ':date_fin' => $date_fin,
        );

        if (!empty($types)) {
            $placeholders = array();
            foreach (array_values($types) as $index => $type) {
                $placeholder = ':type_' . $index;
                $placeholders[] = $placeholder;
                $params[$placeholder] = $type;
            }
            $where .= " AND $type_sql IN (" . implode(',', $placeholders) . ")";
        }

        $requete = "SELECT
                $type_sql AS `type`,
                SUM(`taille`) AS `volume`,
                COUNT(*) AS `actions`
            FROM `bande_passante`
            WHERE $where
            GROUP BY `type`
            ORDER BY `volume` DESC";
        $query = $DB_con->prepare($requete);
        foreach ($params as $placeholder => $value) {
            $query->bindValue($placeholder, $value);
        }
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    function get_top_days($date_debut, $date_fin, $types = array(), $limit = 10)
    {
        global $DB_con;
        $type_sql = $this->normalized_type_sql();
        $where = "`heure` >= :date_debut AND `heure` < :date_fin";
        $params = array(
            ':date_debut' => $date_debut,
            ':date_fin' => $date_fin,
        );

        if (!empty($types)) {
            $placeholders = array();
            foreach (array_values($types) as $index => $type) {
                $placeholder = ':type_' . $index;
                $placeholders[] = $placeholder;
                $params[$placeholder] = $type;
            }
            $where .= " AND $type_sql IN (" . implode(',', $placeholders) . ")";
        }

        $requete = "SELECT DATE(`heure`) AS `jour`, SUM(`taille`) AS `volume`, COUNT(*) AS `actions`
            FROM `bande_passante`
            WHERE $where
            GROUP BY DATE(`heure`)
            ORDER BY `volume` DESC
            LIMIT :limit";
        $query = $DB_con->prepare($requete);
        foreach ($params as $placeholder => $value) {
            $query->bindValue($placeholder, $value);
        }
        $query->bindValue(':limit', (int) $limit, PDO::PARAM_INT);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    function get_hourly_distribution($date_debut, $date_fin, $types = array())
    {
        global $DB_con;
        $type_sql = $this->normalized_type_sql();
        $where = "`heure` >= :date_debut AND `heure` < :date_fin";
        $params = array(
            ':date_debut' => $date_debut,
            ':date_fin' => $date_fin,
        );

        if (!empty($types)) {
            $placeholders = array();
            foreach (array_values($types) as $index => $type) {
                $placeholder = ':type_' . $index;
                $placeholders[] = $placeholder;
                $params[$placeholder] = $type;
            }
            $where .= " AND $type_sql IN (" . implode(',', $placeholders) . ")";
        }

        $requete = "SELECT HOUR(`heure`) AS `hour`, SUM(`taille`) AS `volume`, COUNT(*) AS `actions`
            FROM `bande_passante`
            WHERE $where
            GROUP BY HOUR(`heure`)
            ORDER BY `hour` ASC";
        $query = $DB_con->prepare($requete);
        foreach ($params as $placeholder => $value) {
            $query->bindValue($placeholder, $value);
        }
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    function get_stats2()
    {
        global $DB_con;
        $requete = "SELECT * FROM `bande_passante` ORDER BY heure";
        $query = $DB_con->prepare($requete);
        $query->execute();
        $results = $query->fetchAll();
        return $results;
    }
}
