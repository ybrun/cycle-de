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
$id_chapitres = isset($_GET['id_chapitres']) ? $_GET['id_chapitres'] : false;
/* Si on a une région, on procède à la requête */
if(false !== $id_chapitres)
{
    /* Cération de la requête pour avoir les départements de cette région */
    $sql5 = "SELECT `id_pub`, `version_name`".
            " FROM `cyclede_oeuvrespublication`".
            " WHERE `chapitres` = ". $id_chapitres ."".
            " ORDER BY `id_pub` DESC;";
    $connexion = mysql_connect($serveur, $admin, $mdp);
    mysql_select_db($base, $connexion);
    $rech_versions = mysql_query($sql5, $connexion);
    /* Un petit compteur pour les départements */
    $nd4 = 0;
    /* On crée deux tableaux pour les numéros et les noms des départements */
    $code_versions = array();
    $nom_versions = array();
    /* On va mettre les numéros et noms des départements dans les deux tableaux */
    while(false != ($ligne_versions = mysql_fetch_assoc($rech_versions)))
    {
        $code_versions[] = $ligne_versions['id_pub'];
        $nom_versions[]  = $ligne_versions['version_name'];
        $nd4++;
    }
    /* Maintenant on peut construire la liste déroulante */
    $liste4 = "";
    $liste4 .= '<select name="versions" id="versions" onChange="getTexteoeuvres(this.value);"><option value="vide">- - - Choisissez une version - - -</option>'."\n";
    for($d4 = 0; $d4 < $nd4; $d4++)
    {
        $liste4 .= '  <option value="'. $code_versions[$d4] .'">'. htmlentities($nom_versions[$d4]) .'</option>'."\n";
    }
    $liste4 .= '</select>'."\n";

    /* Un petit coup de balai */
    mysql_free_result($rech_versions);
    /* Affichage de la liste déroulante */
    echo($liste4);
}
/* Sinon on retourne un message d'erreur */
else
{
    echo("<p>Une erreur s'est produite. La région sélectionnée comporte une donnée invalide.</p>\n");
}
?>