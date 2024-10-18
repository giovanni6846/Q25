<?php

namespace App\Modele;

use App\Utilitaire\Singleton_ConnexionPDO;
use PDO;

class Modele_Utilisateur
{

static function  utilisateur_Select()
{
        $connexionPDO = Singleton_ConnexionPDO::getInstance();
        $requetePreparee = $connexionPDO->prepare('
        select *
        from `utilisateur`
        order by id');
        $reponse = $requetePreparee->execute(); //$reponse boolean sur l'état de la requête
        $tableauReponse = $requetePreparee->fetchAll(PDO::FETCH_ASSOC);
        return $tableauReponse;
    }

    public static function utilisateur_Insert(mixed $Nom, mixed $Prenom, mixed $Mot_de_Passe)
    {
        $connexionPDO = Singleton_ConnexionPDO::getInstance();
        $requetePreparee = $connexionPDO->prepare('
    INSERT INTO `utilisateur` (Nom, Prenom, Mot_de_Passe) VALUES (:Nom, :Prenom, :Mot_de_Passe)');

        $reponse = $requetePreparee->execute(array(
            "Nom" => $Nom,
            "Prenom" => $Prenom,
            "Mot_de_Passe" => $Mot_de_Passe,
        ));

        return $reponse;
    }

    public static function utilisateur_Delete(mixed $id)
    {
        $connexionPDO = Singleton_ConnexionPDO::getInstance();
        $requetePreparee = $connexionPDO->prepare('
        delete from `utilisateur` where id=:id');
        $reponse = $requetePreparee->execute(array(
            "id" => $id
        ));
        return $reponse;
    }

    public static function utilisateur_SelectById(mixed $id)
    {
        $connexionPDO = Singleton_ConnexionPDO::getInstance();
        $requetePreparee = $connexionPDO->prepare('
        select * from `utilisateur` where id=:id');
        $reponse = $requetePreparee->execute(array(
            "id" => $id
        ));
        $tableauReponse = $requetePreparee->fetch(PDO::FETCH_ASSOC);
        return $tableauReponse;
    }

    public static function utilisateur_Update(mixed $id, mixed $Nom, mixed $Prenom, mixed $Mot_de_Passe)
    {
        $connexionPDO = Singleton_ConnexionPDO::getInstance();
        $requetePreparee = $connexionPDO->prepare('
    UPDATE `utilisateur` SET Nom = :Nom, Prenom = :Prenom, Mot_de_Passe = :Mot_de_Passe WHERE id = :id');

        $reponse = $requetePreparee->execute(array(
            "id" => $id,
            "Nom" => $Nom,
            "Prenom" => $Prenom,
            "Mot_de_Passe" => $Mot_de_Passe,
        ));

        return $reponse;
    }


}