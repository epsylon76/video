<?php
//modele file d'attente

class file_attente
{
    function add($id_partage, $immediat)
    {
        global $DB_con;
        $query = $DB_con->prepare("INSERT INTO `file_attente` (`id_partage`, `immediat`) VALUES (:id_partage, :immediat)");
        $query->bindParam(':id_partage', $id_partage);
        $query->bindParam(':immediat', $immediat);
        $query->execute();
    }

    function liste()
    {
        global $DB_con;
        $query = $DB_con->prepare("SELECT  `partage`.`email`, partage.date,  file_attente.immediat, file_attente.done, partage.admin_login FROM `file_attente` LEFT JOIN `partage` ON `partage`.`id` = `file_attente`.`id_partage` WHERE 1 ORDER BY `file_id` DESC");
        $query->execute();
        $res = $query->fetchAll(PDO::FETCH_NUM);
        return $res;
    }

    function one_file($immediat)
    {
        global $DB_con;
        $one = $DB_con->prepare("SELECT * FROM `file_attente` LEFT JOIN `partage` ON `partage`.`id` = `file_attente`.`id_partage` WHERE `done` = '0000-00-00 00:00:00' AND `immediat` = :immediat ORDER BY `file_attente`.`file_id` ASC LIMIT 1");
        $one->bindParam(':immediat', $immediat);
        $one->execute();
        $res = $one->fetch();
        return $res;
    }

    function reste($type)
    {
        global $DB_con;
        if ($type == 'immediat') {
            $one = $DB_con->prepare("SELECT COUNT(*) FROM `file_attente` WHERE `done` = '0000-00-00 00:00:00' AND `immediat` = 1");
        } elseif ($type == 'programme') {
            $one = $DB_con->prepare("SELECT COUNT(*) FROM `file_attente` WHERE `done` = '0000-00-00 00:00:00' AND `immediat` = 0");
        } elseif ($type == 'all') {
            $one = $DB_con->prepare("SELECT COUNT(*) FROM `file_attente` WHERE `done` = '0000-00-00 00:00:00' ");
        }
        $one->execute();
        $res = $one->fetch();
        return $res[0];
    }

    function renvoi_bulk($date, $immediat)
    {
        global $DB_con;
        $query = $DB_con->prepare("SELECT * FROM `file_attente` LEFT JOIN `partage` ON `partage`.`id` = `file_attente`.`id_partage` WHERE DATE(`partage`.`date`) = :date");
        $query->bindParam(':date', $date);
        $query->execute();
        $res = $query->fetchAll();
        if ($res) {
            foreach ($res as $un) {
                $upd = $DB_con->prepare("UPDATE `file_attente` SET `done` = '0000-00-00 00:00:00', `immediat` = :immediat WHERE `file_id` = :id");
                $upd->bindParam(':id', $un['file_id']);
                $upd->bindParam(':immediat', $immediat);
                $upd->execute();
            }
        }
    }
}
