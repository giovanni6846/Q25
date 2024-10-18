<?php

namespace App\Vue;

use App\Utilitaire\Vue_Composant;

class Vue_Ajouterutilisateur extends Vue_Composant
{
    private string $msgErreur;

    public function __construct( string $msgErreur ="")
    {
        $this->msgErreur=$msgErreur;
    }

    function donneTexte(): string
    {
        $str= "
<h1>Ajouter un utilisateur</h1>
<div  style='    width: 50%;    display: block;    margin: auto;'> 
<form>
    <table> 
        <tr> <td>id</td><td>Automatique !</td> </tr>
         <tr>    <td>Nom</td><td> <input type='text' name='Nom'> </td></tr>
        <tr>     <td>Prenom</td> <td> <input type='text' name='Prenom'> </td></tr>
        <tr>     <td>Mot de passe</td> <td> <input type='text' name='Mot_de_Passe'> </td></tr>
    </table>
    <input type='hidden' name='case' value ='utilisateur'>
    <button type='submit' name = 'action' value='enregistrerAjouter'> Ajouter !!</button>
    </form>
</div>
        $this->msgErreur
    ";
        return $str ;
    }
}