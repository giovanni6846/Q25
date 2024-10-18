<?php

$Vue->setMenu(new \App\Vue\Vue_Menu_Utilisateur());
switch ($action) {
    case "defaut":
        $data = \App\Modele\Modele_Utilisateur::utilisateur_Select();
        $Vue->addToCorps(new \App\Vue\Vue_Accueilutilisateur($data));
        break;
    case "ajouter":
        $Vue->addToCorps(new \App\Vue\Vue_Ajouterutilisateur());
        break;
    case "enregistrerAjouter":
        $data = \App\Modele\Modele_Utilisateur::utilisateur_Insert($_REQUEST["Nom"], $_REQUEST["Prenom"], $_REQUEST["Mot_de_Passe"]);

        $data = \App\Modele\Modele_Utilisateur::utilisateur_Select();
        $Vue->addToCorps(new \App\Vue\Vue_Accueilutilisateur($data));
        break;
    case "supprimer":
        $data = \App\Modele\Modele_Utilisateur::utilisateur_Delete($_REQUEST["id"]);
        $data = \App\Modele\Modele_Utilisateur::utilisateur_Select();
        $Vue->addToCorps(new \App\Vue\Vue_Accueilutilisateur($data));
        break;
    case "modifier":
        $data = \App\Modele\Modele_Utilisateur::utilisateur_SelectById($_REQUEST["id"]);
        $Vue->addToCorps(new \App\Vue\Vue_Modifierutilisateur($data));
        break;
    case "enregistrerModifier":
        \App\Modele\Modele_Utilisateur::utilisateur_Update($_REQUEST["id"], $_REQUEST["Nom"], $_REQUEST["Prenom"], $_REQUEST["Mot_de_Passe"]);
        $data = \App\Modele\Modele_Utilisateur::utilisateur_Select();
        $Vue->addToCorps(new \App\Vue\Vue_Accueilutilisateur($data));
        break;

}