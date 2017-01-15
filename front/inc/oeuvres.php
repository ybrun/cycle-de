<?php
/**
 * Code qui sera aeeplé par un objet XHR et qui
 * retournera la liste déroulante des départements
 * correspondant à la région sélectionnée.
 */
/* Paramètres de connexion */
$serveur = "dmiccorpglde.mysql.db";
$admin   = "dmiccorpglde";
$mdp     = "Password7";
$base    = "dmiccorpglde";

/* On récupère l'identifiant de la région choisie. */
$id_cycle = isset($_GET['id_cycle']) ? $_GET['id_cycle'] : false;
/* Si on a une région, on procède à la requête */
if(false !== $id_cycle)
{
    /* Cération de la requête pour avoir les départements de cette région */
    $sql5 = "SELECT `id_oeuvres`, `oeuvres_name`".
            " FROM `cyclede_oeuvres`".
            " WHERE `cycle` = ". $id_cycle ."".
            " ORDER BY `oeuvres_name`;";
    $connexion = mysql_connect($serveur, $admin, $mdp);
    mysql_select_db($base, $connexion);
    $rech_oeuvres = mysql_query($sql5, $connexion);
    /* Un petit compteur pour les départements */
    $nd4 = 0;
    /* On crée deux tableaux pour les numéros et les noms des départements */
    $code_oeuvres = array();
    $nom_oeuvres = array();
    /* On va mettre les numéros et noms des départements dans les deux tableaux */
    while(false != ($ligne_oeuvres = mysql_fetch_assoc($rech_oeuvres)))
    {
        $code_oeuvres[] = $ligne_oeuvres['id_oeuvres'];
        $nom_oeuvres[]  = $ligne_oeuvres['oeuvres_name'];
        $nd4++;
    }
    /* Maintenant on peut construire la liste déroulante */
    $liste4 = "";
    $liste4 .= '<select name="oeuvres" id="oeuvres" onChange="getChapitres(this.value);"><option value="vide">- - - Oeuvres - - -</option>'."\n";
    for($d4 = 0; $d4 < $nd4; $d4++)
    {
        $liste4 .= '  <option value="'. $code_oeuvres[$d4] .'">'. htmlentities($nom_oeuvres[$d4]) .'</option>'."\n";
    }
    $liste4 .= '</select>'."\n";

    /* Un petit coup de balai */
    mysql_free_result($rech_oeuvres);
    /* Affichage de la liste déroulante */
    echo($liste4);
}
/* Sinon on retourne un message d'erreur */
else
{
    echo("<p>Une erreur s'est produite. La région sélectionnée comporte une donnée invalide.</p>\n");
}
?>