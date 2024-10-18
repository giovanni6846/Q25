<?php
try {
    $test = false;
    $first = true;
    $createDatabase = false;
    $USERRoot = "";
    while (!$test) {
        if (!$first) {
            echo "Erreur de connexion à la base de données. Veuillez réessayer.\n";
            echo "Quel paramètre voulez-vous modifier ?\n";
            echo "1. IPBDD\n";
            echo "2. BDD\n";
            echo "3. USERBDD\n";
            echo "4. MDPBDD\n";
            echo "5. Tout\n";
            echo "6. Quitter\n";
            echo "7. Aide\n";
            $choix = readline();
            switch ($choix) {
                // Cas similaires aux précédents
            }
        } else {
            echo "Quelle est l'ip ou le nom FQDN du serveur de base de données [127.0.0.1] ?\n";
            $IPBDD = readline();
            if ($IPBDD == "") {
                $IPBDD = "127.0.0.1";
            }
            $createDatabase = "";
            while ($createDatabase != "o" && $createDatabase != "n" && $createDatabase != "O" && $createDatabase != "N") {
                echo "Faut-il créer la base de données ? (O/n)\n";
                $createDatabase = readline();
                if ($createDatabase == "") {
                    $createDatabase = "o";
                }
            }

            if ($createDatabase == "n" || $createDatabase == "N") {
                echo "**** Base de données existante ****\n";
                echo "Quelle est la base de données [BDDMVC2024]?\n";
                $BDD = readline();
                if ($BDD == "") {
                    $BDD = "BDDMVC2024";
                }

                echo "Quel est l'utilisateur ayant les droits sur cette base de données [" . $BDD . "_user]?\n";
                $USERBDD = readline();
                if ($USERBDD == "") {
                    $USERBDD = $BDD . "_user";
                }

                echo "Quel est son mot de passe (vide = ne rien saisir) ?\n";
                $MDPBDD = readline();
                if ($MDPBDD == "") {
                    $MDPBDD = "";
                }
            } else {
                echo "**** Base de données sera donc crée ****\n";
                //La base de données est à créer
                echo "Quelle sera la base de données [BDDMVC2024]?\n";
                $BDD = readline();
                if ($BDD == "") {
                    $BDD = "BDDMVC2024";
                }

                echo "Quel est l'utilisateur ayant les droits de créer cette base de données [root] ?\n";
                $USERRoot = readline();
                if ($USERRoot == "") {
                    $USERRoot = "root";
                }

                echo "Quel est son mot de passe ? (vide = entrer) \n";
                $MDPBDDRoot = readline();

                echo "Quel sera l'utilisateur pour administrer $BDD [" . $BDD . "_user] ?";
                $USERBDD = readline();
                if ($USERBDD == "") {
                    $USERBDD = $BDD . "_user";
                }
            }
        }

        if (!(!$first && $choix <= 5)) {
            echo "Tentative de connexion à la base de données...\n";
            if ($createDatabase) {
                try {
                    $instancePdo = new PDO('mysql:host=' . $IPBDD . ';charset=UTF8', $USERRoot, $MDPBDDRoot, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
                    echo "Connecté en tant que $USERRoot\n";
                    $test = true;

                    //La connexion est établie
                    //On va déterminer si la base de données existe déjà
                    $rqt = "SHOW DATABASES LIKE '$BDD';";
                    $result = $instancePdo->query($rqt);
                    $row = $result->fetch();
                    if ($row) {
                        echo "La base de données existe déjà. Voulez-vous la supprimer ? (O/n)\n";
                        $choix = readline();
                        if ($choix == "") {
                            $choix = "o";
                        }
                        if ($choix == "o" || $choix == "O") {
                            $rqt = "DROP DATABASE $BDD;";
                            $instancePdo->query($rqt);
                            echo "Base de données supprimée.\n";
                        } else {
                            $first = false;
                            $test = false;
                        }
                    }

                    //Création de la base de données
                    $rqt = "CREATE DATABASE $BDD;";
                    $instancePdo->query($rqt);
                    echo "Base de données créée.\n";

                    //Génération aléatoire du mot de passe
                    $MDPBDD = bin2hex(random_bytes(10));

                    //On recherche si l'utilisateur BDD existe déjà
                    $rqt = "SELECT user FROM mysql.user WHERE user = '$USERBDD'";
                    $result = $instancePdo->query($rqt);
                    $row = $result->fetch();
                    if ($row) {
                        echo "L'utilisateur existe déjà. Voulez-vous le supprimer ? (O/n)\n";
                        $choix = readline();
                        if ($choix == "") {
                            $choix = "o";
                        }
                        if ($choix == "o" || $choix == "O") {
                            $rqt = "DROP USER '$USERBDD'@'%';";
                            $instancePdo->query($rqt);
                            echo "Utilisateur supprimé.\n";
                        } else {
                            echo "Il est impossible de continuer sans utilisateur.\n";
                            die();
                        }
                    }

                    //Création de l'utilisateur
                    $rqt = "CREATE USER '$USERBDD'@'%' IDENTIFIED BY '$MDPBDD';";
                    $instancePdo->query($rqt);
                    echo "Utilisateur créé.\n";
                    //Attribution des droits
                    $rqt = "GRANT ALL PRIVILEGES ON $BDD.* TO '$USERBDD'@'%';";
                    $instancePdo->query($rqt);
                    echo "Droits attribués.\n";

                    $rqt = "CREATE TABLE $BDD.Table (id INT PRIMARY KEY NOT NULL AUTO_INCREMENT, champ1 VARCHAR(255), champ2 VARCHAR(255));";
                    $instancePdo->query($rqt);
                    $test = true;

                    $rqt = "CREATE TABLE $BDD.utilisateur (id INT PRIMARY KEY NOT NULL AUTO_INCREMENT, Nom VARCHAR(255), Prenom VARCHAR(255), Mot_de_Passe VARCHAR(255));";
                    $instancePdo->query($rqt);
                    $test = true;

                } catch (PDOException $e) {
                    echo $e->getMessage();
                    echo "\n";
                    $first = false;
                }
            }
        }
    }

# Chemin vers fichier texte
    $file = "paramBDD.txt";
# Ouverture en mode écriture
    $fileopen = (fopen("$file", 'w'));
    fwrite($fileopen, "IPBDD $IPBDD\n");
    fwrite($fileopen, "BDD $BDD\n");
    fwrite($fileopen, "USERBDD $USERBDD\n");
    fwrite($fileopen, "MDPBDD $MDPBDD\n");
# On ferme le fichier proprement
    fclose($fileopen);

    echo "Base de données OK\n";

    include "." . DIRECTORY_SEPARATOR . "vendor" . DIRECTORY_SEPARATOR . "autoload.php";

    $pdo = \App\Utilitaire\Singleton_ConnexionPDO::getInstance();

    echo "Installation finie.\n";
    die();
}
catch (Exception $e){
    echo "Erreur : " . $e->getMessage() . "\n";
    die();
}
?>
