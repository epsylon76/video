<?php

class stats
{
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
        $requete = "SELECT `type`, SUM(`taille`) as 'volume' FROM `bande_passante` WHERE `heure` BETWEEN :date_debut AND :date_fin GROUP BY `type`";
        $query = $DB_con->prepare($requete);
        $query->bindParam(':date_debut', $date_debut);
        $query->bindParam(':date_fin', $date_fin);
        $query->execute();
        $results = $query->fetchAll(PDO::FETCH_ASSOC);
        return $results;
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
