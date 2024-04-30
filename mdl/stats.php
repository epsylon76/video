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

    function calcul_taille_by_period()
    {
        global $DB_con;
        $requete = "SELECT CONCAT(DATE_FORMAT(`heure`, '%Y-%m-%d %H:'), LPAD(FLOOR(MINUTE(`heure`) / 10)  * 10, 2, '0')) AS periode,
        SUM(taille) AS total_taille FROM `bande_passante` GROUP BY periode ORDER BY heure";
        $query = $DB_con->prepare($requete);
        $query->execute();
        $results = $query->fetchAll();
        return $results;
    }


    
}


?>