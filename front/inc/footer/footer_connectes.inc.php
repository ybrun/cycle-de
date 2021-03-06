<?php
// Connexion à MySQL
$hostname_dmic = "dmiccorpglroot.mysql.db";
$database_dmic = "dmiccorpglroot";
$username_dmic = "dmiccorpglroot";
$password_dmic = "Password7";
mysql_pconnect($hostname_dmic, $username_dmic, $password_dmic);
mysql_select_db($database_dmic);

// -------
// ÉTAPE 1 : on vérifie si l'IP se trouve déjà dans la table.
// Pour faire ça, on n'a qu'à compter le nombre d'entrées dont le champ "ip" est l'adresse IP du visiteur.
$retour = mysql_query('SELECT COUNT(*) AS nbre_entrees FROM dmic_connectes WHERE ip=\'' . $_SERVER['REMOTE_ADDR'] . '\'');
$donnees = mysql_fetch_array($retour);

if ($donnees['nbre_entrees'] == 0) // L'IP ne se trouve pas dans la table, on va l'ajouter.
{
    mysql_query('INSERT INTO dmic_connectes VALUES(\'' . $_SERVER['REMOTE_ADDR'] . '\', ' . time() . ')');
}
else // L'IP se trouve déjà dans la table, on met juste à jour le timestamp.
{
    mysql_query('UPDATE dmic_connectes SET timestamp=' . time() . ' WHERE ip=\'' . $_SERVER['REMOTE_ADDR'] . '\'');
}

// -------
// ÉTAPE 2 : on supprime toutes les entrées dont le timestamp est plus vieux que 5 minutes.

// On stocke dans une variable le timestamp qu'il était il y a 5 minutes :
$timestamp_5min = time() - (60 * 5); // 60 * 5 = nombre de secondes écoulées en 5 minutes
mysql_query('DELETE FROM dmic_connectes WHERE timestamp < ' . $timestamp_5min);

// -------
// ÉTAPE 3 : on compte le nombre d'IP stockées dans la table. C'est le nombre de visiteurs connectés.
$retour = mysql_query('SELECT COUNT(*) AS nbre_entrees FROM dmic_connectes');
$donnees = mysql_fetch_array($retour);


// Ouf ! On n'a plus qu'à afficher le nombre de connectés !
echo '<p>Il y a actuellement ' . $donnees['nbre_entrees'] . ' visiteurs connectés !</p>';
?>
