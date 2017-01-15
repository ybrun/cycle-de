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
$id_oeuvres = isset($_GET['id_oeuvres']) ? $_GET['id_oeuvres'] : false;
/* Si on a une région, on procède à la requête */
if(false !== $id_oeuvres)
{
    /* Cération de la requête pour avoir les départements de cette région */
    $sql4 = "SELECT `id_chapitres`, `chapitres_name`".
            " FROM `cyclede_chapitresoeuvres`".
            " WHERE `oeuvres` = ". $id_oeuvres ."".
            " ORDER BY `chapitres_name`;";
    $connexion = mysql_connect($serveur, $admin, $mdp);
    mysql_select_db($base, $connexion);
    $rech_chapitres = mysql_query($sql4, $connexion);
    /* Un petit compteur pour les départements */
    $nd3 = 0;
    /* On crée deux tableaux pour les numéros et les noms des départements */
    $code_chapitres = array();
    $nom_chapitres = array();
    /* On va mettre les numéros et noms des départements dans les deux tableaux */
    while(false != ($ligne_chapitres = mysql_fetch_assoc($rech_chapitres)))
    {
        $code_chapitres[] = $ligne_chapitres['id_chapitres'];
        $nom_chapitres[]  = $ligne_chapitres['chapitres_name'];
        $nd3++;
    }
    /* Maintenant on peut construire la liste déroulante */
    $liste3 = "";
    $liste3 .= '<select name="chapitres" id="chapitres" onchange="getVersions(this.value);"><option value="vide">- - - Choisissez un chapitres - - -</option>'."\n";
    for($d3 = 0; $d3 < $nd3; $d3++)
    {
        $liste3 .= '  <option value="'. $code_chapitres[$d3] .'">'. htmlentities($nom_chapitres[$d3]) .'</option>'."\n";
    }
    $liste3 .= '</select>'."\n";
    /* Un petit coup de balai */
    mysql_free_result($rech_chapitres);
    /* Affichage de la liste déroulante */
    echo($liste3);
}
/* Sinon on retourne un message d'erreur */
else
{
    echo("<p>Une erreur s'est produite. La région sélectionnée comporte une donnée invalide.</p>\n");
}
?>