<?php

class partage
{

  function check_cle_email($cle, $email)
  {
    //vérifie lors de l'accès si l'email a la bonne clé
    global $DB_con;
    $requete = "SELECT * from `partage` where `email` = :email AND `cle` = :cle";
    $query = $DB_con->prepare($requete);
    $query->bindParam(':cle', $cle);
    $query->bindParam(':email', $email);
    $query->execute();
    $res = $query->rowCount();
    if ($res >= 1) {
      return true;
    } else {
      return false;
    }
  }

  function check_partage($cle, $id)
  {
    //vérifie que le partage demandé a bien la bonne clé (empeche de mettre un id au hasard)
    global $DB_con;
    $requete = "SELECT * from `partage` where `id` = :id AND `cle` = :cle";
    $query = $DB_con->prepare($requete);
    $query->bindParam(':cle', $cle);
    $query->bindParam(':id', $id);
    $query->execute();
    $res = $query->rowCount();
    if ($res >= 1) {
      return true;
    } else {
      return false;
    }
  }

  function liste_partages($cle)
  {
    global $DB_con;
    $requete = "SELECT `id`,`chemin`,`type_partage` from `partage` where `cle` = :cle";
    $query = $DB_con->prepare($requete);
    $query->bindParam(':cle', $cle);
    $query->execute();
    $results = $query->fetchAll();
    return $results;
  }

  function nb_partages($chemin)
  {
    global $DB_con;
    $requete = "SELECT * from `partage` where `chemin` = :chemin";
    $query = $DB_con->prepare($requete);
    $query->bindParam(':chemin', $chemin);
    $query->execute();
    $res = $query->rowCount();
    return $res;
  }

  function set_partage($chemin, $email, $type_partage, $admin_login, $email_type, $immediat)
  {
    global $DB_con;
    $cle = $email . '42';
    $cle = sha1($cle);
    $now = date('Y-m-d H:i:s');
    $date = date('Y-m-d');
    $requete = "INSERT INTO `partage` (`chemin`,`email`,`cle`,`date`,`type_partage`,`admin_login`,`email_type`,`date_click`) VALUES (:chemin, :email, :cle, :now, :type_partage, :admin_login, :email_type, :date)";
    $query = $DB_con->prepare($requete);
    $query->bindParam(':chemin', $chemin);
    $query->bindParam(':email', $email);
    $query->bindParam(':cle', $cle);
    $query->bindParam(':type_partage', $type_partage);
    $query->bindParam(':admin_login', $admin_login);
    $query->bindParam(':email_type', $email_type);
    $query->bindParam(':date', $date);
    $query->bindParam(':now', $now);
    $query->execute();
    $return['id'] = $DB_con->lastInsertId();
    $return['cle'] = $cle;
    return $return;
  }

  function unset_partage($id)
  {
    global $DB_con;
    $requete = "DELETE FROM `partage`  WHERE `id` = :id";
    $query = $DB_con->prepare($requete);
    $query->bindParam(':id', $id);
    $query->execute();
  }

  function get_partage($id)
  {
    global $DB_con;
    $requete = "SELECT * from `partage` where `id` = :id";
    $query = $DB_con->prepare($requete);
    $query->bindParam(':id', $id);
    $query->execute();
    $result = $query->fetch();
    return $result;
  }

  function get_cle_with_chemin($chemin)
  {
    global $DB_con;
    $requete = "SELECT `cle` from `partage` where `chemin` = :chemin";
    $query = $DB_con->prepare($requete);
    $query->bindParam(':chemin', $chemin);
    $query->execute();
    $result = $query->fetch();
    return $result;
  }

  function get_type_partage($id)
  {
    global $DB_con;
    $requete = "SELECT `type_partage` from `partage` where `id` = :id";
    $query = $DB_con->prepare($requete);
    $query->bindParam(':id', $id);
    $query->execute();
    $result = $query->fetch();
    return $result['type_partage'];
  }

  function cle_from_email($email)
  {
    global $DB_con;
    $requete = "SELECT `cle` from `partage` where `email` = :email";
    $query = $DB_con->prepare($requete);
    $query->bindParam(':email', $email);
    $query->execute();
    $cle = $query->fetch();
    $cle = $cle[0];
    return $cle;
  }

  function last_partage($email)
  {
    global $DB_con;
    $requete = "SELECT MAX(`date`) from `partage` where `email` = :email";
    $query = $DB_con->prepare($requete);
    $query->bindParam(':email', $email);
    $query->execute();
    $last = $query->fetch();

    $last = $last[0];
    if ($last == '') {
      $last = '1970-01-01 12:00:00';
    }

    $now = new DateTime();
    $max_partage = new DateTime($last);

    $interval = $max_partage->diff($now);
    $hours = $interval->h;
    $hours = $hours + ($interval->days * 24);

    return $hours;
  }


  function clic_24h()
  {
    global $DB_con;
    $clics = $DB_con->prepare(
      "SELECT COUNT('id') FROM `historique`
      WHERE `action` LIKE '%dl_%'
      AND `date` > DATE_SUB(NOW(), INTERVAL 24 HOUR)"
    );
    $clics->execute();
    $clics = $clics->fetch();
    $clics = $clics[0];
    return $clics;
  }

  function clic_total()
  {
    global $DB_con;
    $clics = $DB_con->prepare(
      "SELECT COUNT('id') FROM `historique`
      WHERE `action` LIKE '%dl_%' "
    );
    $clics->execute();
    $clics = $clics->fetch();
    $clics = $clics[0];
    return $clics;
  }

  function introuvables($data)
  {
    global $DB_con;
    $requete = "SELECT * from `partage`";
    $query = $DB_con->prepare($requete);
    $query->execute();
    $results = $query->fetchAll();
    $i = 0;
    $introuvable = false;
    foreach ($results as $ligne) {
      $date = new DateTime($ligne['date']);
      $date_aff = $date->format('d/m/Y H:i');

      if (file_exists($data . $ligne['chemin'])) {
        $exist = true;
      } else {
        $introuvable[$i]['id'] = $ligne['id'];
        $introuvable[$i]['chemin'] = $ligne['chemin'];
        $i++;
      }
    }
    return $introuvable;
  }


  function get_partage_date_unique($date)
  {
    global $DB_con;
    $date1 = $date . ' 00:00:00';
    $date2 = $date . ' 23:59:59';
    $requete = "SELECT * from `partage` where `date` BETWEEN :date1 AND :date2 GROUP BY `email`";
    $query = $DB_con->prepare($requete);
    $query->bindParam(':date1', $date1);
    $query->bindParam(':date2', $date2);
    $query->execute();
    $result = $query->fetchAll(PDO::FETCH_ASSOC);
    return $result;
  }
}//class partage
