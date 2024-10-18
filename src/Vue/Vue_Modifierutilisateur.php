<?php

namespace App\Vue;

use App\Utilitaire\Vue_Composant;

class Vue_Modifierutilisateur extends Vue_Composant
{
    public function __construct(mixed $data)
    {
        $this->data = $data;
    }

    function donneTexte(): string
    {
        $str= "
        <h1>Vous modifiez un enregistrement de utilisateur !</h1>
        <div  style='    width: 50%;    display: block;    margin: auto;'> 
            <form method='post'>
                <input type='hidden' name='case' value ='utilisateur'>
                <input type='hidden' name='action' value ='enregistrerModifier'>
                <input type='hidden' name='id' value ='".$this->data["id"]."'>
                <label for='Nom'>Nom</label>
                <input type='text' name='Nom' value='".$this->data["Nom"]."'><br>
                <label for='Prenom'>Prenom</label>
                <input type='text' name='Prenom' value='".$this->data["Prenom"]."'><br>
                <label for='Mot_de_Passe'>Mot de Passe</label>
                <input type='text' name='Mot_de_Passe' value='".$this->data["Mot_de_Passe"]."'><br>
                <button type='submit' > Modifier</button>
            </form>
        </div>
        ";
        return $str ;
    }
}