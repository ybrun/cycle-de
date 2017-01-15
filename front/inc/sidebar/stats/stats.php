<link rel="stylesheet" type="text/css" href="Styles/dmxNavigationMenu.css" />
<link rel="stylesheet" type="text/css" href="../Styles/dmxNavigationMenu.css" />
<link rel="stylesheet" type="text/css" href="../../Styles/dmxNavigationMenu.css" />
<div id="menu_user" class="dmxNavigationMenu dark_black">
<div align="center"><table border="0" align="center">
  <tr>
    <th scope="col"><div align="left">
      <h3><u>Global</u></h3>
    </div></th>
  </tr>
  <tr>
    <td><div align="left">
      <img src="http://www.dmic-corp.fr/images/visiteurs.png" width="16" height="16">
      <?php
// Connexion à MySQL
$hostname_cyclede = "dmiccorpglde.mysql.db";
$database_cyclede = "dmiccorpglde";
$username_cyclede = "dmiccorpglde";
$password_cyclede = "Password7";
mysql_pconnect($hostname_cyclede, $username_cyclede, $password_cyclede);
mysql_select_db($database_cyclede);

// -------
// ÉTAPE 1 : on vérifie si l'IP se trouve déjà dans la table.
// Pour faire ça, on n'a qu'à compter le nombre d'entrées dont le champ "ip" est l'adresse IP du visiteur.
$retour = mysql_query('SELECT COUNT(*) AS nbre_entrees FROM cyclede_connectes WHERE ip=\'' . $_SERVER['REMOTE_ADDR'] . '\'');
$donnees = mysql_fetch_array($retour);

if ($donnees['nbre_entrees'] == 0) // L'IP ne se trouve pas dans la table, on va l'ajouter.
{
    mysql_query('INSERT INTO cyclede_connectes VALUES(\'' . $_SERVER['REMOTE_ADDR'] . '\', ' . time() . ')');
}
else // L'IP se trouve déjà dans la table, on met juste à jour le timestamp.
{
    mysql_query('UPDATE cyclede_connectes SET timestamp=' . time() . ' WHERE ip=\'' . $_SERVER['REMOTE_ADDR'] . '\'');
}

// -------
// ÉTAPE 2 : on supprime toutes les entrées dont le timestamp est plus vieux que 5 minutes.

// On stocke dans une variable le timestamp qu'il était il y a 5 minutes :
$timestamp_5min = time() - (60 * 5); // 60 * 5 = nombre de secondes écoulées en 5 minutes
mysql_query('DELETE FROM cyclede_connectes WHERE timestamp < ' . $timestamp_5min);

// -------
// ÉTAPE 3 : on compte le nombre d'IP stockées dans la table. C'est le nombre de visiteurs connectés.
$retour = mysql_query('SELECT COUNT(*) AS nbre_entrees FROM cyclede_connectes');
$donnees = mysql_fetch_array($retour);


// Ouf ! On n'a plus qu'à afficher le nombre de connectés !
echo $donnees['nbre_entrees'] . ' visiteurs connectés';
?>
    </div></td>
  </tr>
  <tr>
    <td><div align="left">
      <img src="http://www.dmic-corp.fr/images/pages.png" width="16" height="16">
      <?php
if(file_exists('compteur_pages_vues.txt'))
{
        $compteur_f = fopen('compteur_pages_vues.txt', 'r+');
        $compte = fgets($compteur_f);
}
else
{
        $compteur_f = fopen('compteur_pages_vues.txt', 'a+');
        $compte = 0;
}
$compte++;
fseek($compteur_f, 0);
fputs($compteur_f, $compte);
fclose($compteur_f); 
echo '<strong>'.$compte.'</strong> pages vues.';
?>
    </div></td>
  </tr>
  <tr>
    <td><div align="left">
      <img src="http://www.dmic-corp.fr/images/statistiques.png" width="16" height="16">
      <?php
include_once('front/inc/sidebar/stats/upload/counter.php');
include_once('inc/sidebar/stats/upload/counter.php');
include_once('../inc/sidebar/stats/upload/counter.php');
echo " $c_today visites aujourd'hui<br />";
?>
    </div></td>
  </tr>
  <tr>
    <td><div align="left"><div align="left"><img src="http://www.dmic-corp.fr/images/statistiques.png" width="16" height="16">
      <?php 
	include_once('front/inc/sidebar/stats/upload/counter.php');
	include_once('inc/sidebar/stats/upload/counter.php');
	include_once('../inc/sidebar/stats/upload/counter.php');
	echo " $c_alltime visites depuis le 30/03/2016<br />"; ?></div></td>
  </tr>
 
</table>
</div>
</div>
<p></p>
<iframe frameborder="0" height="450px" width="100%" src="https://fr.ulule.com/sabre-laser/widget.html" scrolling="no"></iframe>