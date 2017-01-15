<?php
/**
 * counter.php
 *
 * @package 3en1compteur
 * @version 3.0
 * @author NotoOn (http://www.notoon.com/)
 * @url http://www.petit-kiwi.com/
 *
 * Ce code est publié sous contrat Creative Commons.
 * Cela signifie que vous pouvez le copier, le modifier, le distribuer gratuitement
 * à condition de citer l'auteur original et garder cette licence.
 */


	/************************************
	 * Récupération de la configuration *
	 ************************************/

// Chemin absolu
if ( !defined('ABSPATH') ) {
	define('ABSPATH', dirname(__FILE__) . '/');
}

// Existence du fichier config.inc.php
if (file_exists(ABSPATH . 'config.inc.php')) {
	require_once(ABSPATH . 'config.inc.php');

	// Connexion BDD
	$dbc = @mysqli_connect('dmiccorpglde.mysql.db', 'dmiccorpglde', 'Password7', 'dmiccorpglde');
	if (!$dbc) {
		trigger_error('Connexion à la BDD impossible : ' . mysqli_connect_error() );
		exit();
	}

	// Récupération des données témoins
	$qry = "SELECT DATE_FORMAT(c_lastvisit, '%Y-%m-%d') AS c_lastvisit, c_total
			FROM $db_table
			WHERE c_host = 'temoin'";
	$res = @mysqli_query($dbc,$qry) or die(mysqli_error($dbc));
	$data = mysqli_fetch_array($res, MYSQLI_ASSOC);

	// Nombre de visites total
	$total = $data['c_total'];

	// Dernier jour traité
	$saved_date = $data['c_lastvisit'];

	// Aujourd'hui et maintenant
	$today = date('Y-m-d');
	$now = time();

	// Si changement de jour
	if ( ($today != $saved_date) ) {
		// Le nombre de visites de chaque visiteur de la base est remis à 0
		$qry = "UPDATE $db_table SET c_total = 0 WHERE c_host != 'temoin'";
		$res = @mysqli_query($dbc,$qry) or die(mysqli_error($dbc));

		// La date stockée est mise à jour à la date d'aujourd'hui
		$qry = "UPDATE $db_table SET c_lastvisit = CURDATE() WHERE c_host = 'temoin'";
		$res = @mysqli_query($dbc,$qry) or die(mysqli_error($dbc));

		// On vide les lignes obsolètes
		$exceed = $now - ($keep*60*60);
		$qry = "DELETE FROM $db_table WHERE c_host != 'temoin' AND UNIX_TIMESTAMP(c_lastvisit) < $exceed";
		$res = @mysqli_query($dbc,$qry) or die(mysqli_error($dbc));
	}


	/***********************************
	 * Fonction de vérification des IP *
	 ***********************************/

	// Fonction qui vérifie si l'IP est exclue du comptage ou pas
	function ipcheck($ip_to_match, $ip_array) {
		if (is_array($ip_array)) {
			foreach ($ip_array as $ip) {
				if (strpos($ip_to_match, $ip)===0)
				return true;
			}
		}
		return false;
	}


	/**************************
	 * Traitement des visites *
	 **************************/

	$ip = $_SERVER['REMOTE_ADDR'];

	// Si l'IP n'est pas dans la liste de celles à exclure
	if ( ipcheck($ip, $exclude) != true) {
		// On compte le nombre d'entrées correspondant à l'IP de notre visiteur
		$res = @mysqli_query($dbc, "SELECT COUNT(*) FROM $db_table WHERE c_ip = '$ip'") or die(mysqli_error($dbc));
		$row = mysqli_fetch_row($res);
		$match = $row[0];

		// Si aucune IP ne correspond, le visiteur est nouveau dans la base de données
		if ($match == 0) {
			$iphost = gethostbyaddr($ip);
			// Alors on ajoute son heure de connexion, son IP, et on initialise son nombre de visites à 1
			$qry = "INSERT INTO $db_table (c_firstvisit, c_lastvisit, c_total, c_ip, c_host) VALUES (NOW(), NOW(), 1, '$ip', '$iphost')";
			$res = @mysqli_query($dbc,$qry) or die(mysqli_error($dbc));
			// Et on incrémente le nombre de visiteurs
			$qry = "UPDATE $db_table SET c_total = c_total+1 WHERE c_host = 'temoin'";
			$res = @mysqli_query($dbc,$qry) or die(mysqli_error($dbc));
		}
		// Si il est déjà dans la base, alors :
		// - soit la période est dépassée, alors le visiteur est considéré comme nouveau
		// - soit il est déjà venu dans la même période d'unicité d'un visiteur
		else {
			// On récupère toutes les données qui lui correspondent
			$qry = "SELECT UNIX_TIMESTAMP(c_firstvisit) AS c_firstvisit FROM $db_table WHERE c_ip = '$ip'";
			$res = @mysqli_query($dbc,$qry) or die(mysqli_error($dbc));
			$data = mysqli_fetch_array($res, MYSQLI_ASSOC);

			// On récupère la date de ses première et dernière visites
			$firstvisit = $data['c_firstvisit'];

			// Si la période est dépassée
			if ( ($now - $firstvisit) > ($unique * 60 * 60) ) {
				// Incrémentation du compteur total
				$qry = "UPDATE $db_table SET c_total = c_total+1 WHERE c_host = 'temoin'";
				$res = @mysqli_query($dbc,$qry) or die(mysqli_error($dbc));
				// On compte le visiteur comme nouveau, même si c'est dans la même journée
				$qry = "UPDATE $db_table SET c_firstvisit = NOW(), c_lastvisit = NOW(), c_total = c_total+1 WHERE c_ip = '$ip'";
				$res = @mysqli_query($dbc,$qry) or die(mysqli_error($dbc));
			}
			// Sinon on est dans la même période d'unicité
			else {
				// On met uniquement à jour l'heure de son dernier passage
				$qry = "UPDATE $db_table SET c_lastvisit = NOW() WHERE c_ip = '$ip'";
				$res = @mysqli_query($dbc,$qry) or die(mysqli_error($dbc));
			}
		}
	}


	/************************
	 * Stockage des données *
	 ************************/

	// Nombre de visites total
	$qry = "SELECT c_total FROM $db_table WHERE c_host = 'temoin'";
	$res = @mysqli_query($dbc,$qry) or die(mysqli_error($dbc));
	$alltime = mysqli_fetch_array($res, MYSQLI_ASSOC);
		$c_alltime = $alltime['c_total'];

	// Nombres de visiteurs quotidiens
	$qry = "SELECT SUM(c_total) AS c_total FROM $db_table WHERE c_host != 'temoin'";
	$res = @mysqli_query($dbc,$qry) or die(mysqli_error($dbc));
	$today = mysqli_fetch_array($res, MYSQLI_ASSOC);
		$c_today = $today['c_total'];

	// Nombre de visiteurs en ligne
	$lastmin = $now - ($interval*60);
	$res = @mysqli_query($dbc,"SELECT COUNT(*) FROM $db_table WHERE (c_host != 'temoin') AND (UNIX_TIMESTAMP(c_lastvisit) >= $lastmin)") or die(mysqli_error($dbc));
	$row = mysqli_fetch_row($res);
		$c_online = $row[0];

	// On ferme la connexion à la base de données
	mysqli_free_result($res);
	mysqli_close($dbc);
} else {
	echo '<strong>Le fichier config.inc.php manque à l\'appel !</strong>';
	exit();
}
?>