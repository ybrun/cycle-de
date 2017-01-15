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
$idt = isset($_GET['idt']) ? $_GET['idt'] : false;
/* Si on a une région, on procède à la requête */
if(false !== $idt)
{
    /* Cération de la requête pour avoir les départements de cette région */
    $sql2 = "SELECT `id_cycle`, `cycle_name`".
            " FROM `cyclede_cycleoeuvres`".
            " WHERE `type` = ". $idt ."".
            " ORDER BY `cycle_name`;";
    $connexion = mysql_connect($serveur, $admin, $mdp);
    mysql_select_db($base, $connexion);
    $rech_cycles = mysql_query($sql2, $connexion);
    /* Un petit compteur pour les départements */
    $nd2 = 0;
    /* On crée deux tableaux pour les numéros et les noms des départements */
    $code_cycles = array();
    $nom_cycles = array();
    /* On va mettre les numéros et noms des départements dans les deux tableaux */
    while(false != ($ligne_cycles = mysql_fetch_assoc($rech_cycles)))
    {
        $code_cycles[] = $ligne_cycles['id_cycle'];
        $nom_cycles[]  = $ligne_cycles['cycle_name'];
        $nd2++;
    }
    /* Maintenant on peut construire la liste déroulante */
    $liste2 = "";
    $liste2 .= '<select name="cycles" id="cycles" onChange="getOeuvres(this.value);"><option value="vide">- - - Cycles - - -</option>'."\n";
    for($d2 = 0; $d2 < $nd2; $d2++)
    {
        $liste2 .= '  <option value="'. $code_cycles[$d2] .'">'. htmlentities($nom_cycles[$d2]) .'</option>'."\n";
    }
    $liste2 .= '</select>'."\n";

    /* Un petit coup de balai */
    mysql_free_result($rech_cycles);
    /* Affichage de la liste déroulante */
    echo($liste2);
}
/* Sinon on retourne un message d'erreur */
else
{
    echo("<p>Une erreur s'est produite. La région sélectionnée comporte une donnée invalide.</p>\n");
}
?>