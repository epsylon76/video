<?php

class tag{

    function set_tag($nom_chemin, $nom_tag, $type){
        global $DB_con;
        if(!$this->cheminExists($nom_chemin)){
            
            $requete = "INSERT INTO `chemin` (nom_chemin, type) VALUES (:nom_chemin, :type)";
            $query = $DB_con->prepare($requete);
            $query->bindParam(':nom_chemin', $nom_chemin);
            $query->bindParam(':type', $type);
            $query->execute();     
            
            
            $id_chemin = $DB_con->lastInsertId();
        }

        if(!isset($id_chemin)){
            $id_chemin = $this->get_IdChemin_from_NomChemin($nom_chemin);
        }

        if(!$this->tagExistsForChemin($nom_tag, $id_chemin)){

            $requete = "INSERT INTO `tag` (nom_tag, id_chemin) VALUES (:nom_tag, :id_chemin)";
            $query = $DB_con->prepare($requete);
            $query->bindParam(':nom_tag', $nom_tag);
            $query->bindParam(':id_chemin', $id_chemin);
            $query->execute();
        }else{
            echo "Ce tag existe deja pour ce chemin";
        }
       
    }

    function get_tag(){
        global $DB_con;
        $requete = "SELECT * FROM tag t JOIN chemin c ON t.id_chemin = c.id_chemin";
        $query = $DB_con->prepare($requete);
        $query->execute();
        $results = $query->fetchAll(PDO::FETCH_ASSOC);
        return $results;
    }

    function get_IdChemin_from_NomChemin($nom_chemin){
        global $DB_con;
        $requete = "SELECT id_chemin FROM chemin WHERE nom_chemin = :nom_chemin";
        $query = $DB_con->prepare($requete);
        $query->bindParam(':nom_chemin', $nom_chemin);
        $query->execute();
        $results = $query->fetchColumn();
        return $results;
    }


    function tagExists($nom_tag) {
        global $DB_con;
        $requete = "SELECT COUNT(*) FROM tag WHERE nom_tag = :nom_tag";
        $query = $DB_con->prepare($requete);
        $query->bindParam(':nom_tag', $nom_tag);
        $query->execute();

        $results = $results = $query->fetchColumn(); 
    
        return ($results > 0);
    }

    function cheminExists($nom_chemin){
        global $DB_con;
        $requete = "SELECT COUNT(*) FROM chemin WHERE nom_chemin = :nom_chemin";
        $query = $DB_con->prepare($requete);
        $query->bindParam(':nom_chemin', $nom_chemin);
        $query->execute();
    
        $results = $query->fetchColumn(); 
    
        return ($results > 0); 
    }


    function tagExistsForChemin($nom_tag, $id_chemin) {
        global $DB_con;
        $requete = "SELECT COUNT(*) FROM tag WHERE nom_tag = :nom_tag AND id_chemin = :id_chemin";
        $query = $DB_con->prepare($requete);
        $query->bindParam(':nom_tag', $nom_tag);
        $query->bindParam(':id_chemin', $id_chemin);
        $query->execute();
        $results = $query->fetchColumn();
        return ($results > 0);
    }
    


}

?>