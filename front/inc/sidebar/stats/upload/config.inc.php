<?php
/**
 * config.inc.php
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

// Paramètres de connexion
define('DB_HOST', 'serveur_bdd'); // serveur de la base de données (localhost en général)
define('DB_USER', 'nom_utilisateur'); // nom d'utilisateur de la base de données
define('DB_PASSWORD', 'mot_de_passe'); // mot de passe
define('DB_NAME', 'nom_bdd'); // nom de la base de données
$db_table = 'compteur'; // nom de la table qui sera créée à l'installation

// Paramètres du compteur
$keep = 48;	// durée de conservation (en heures) des IPs en base (défaut : 48h)
$interval = 5;	// intervalle de temps (en minutes) pour compter le nombre de connectés des X dernières minutes (défaut : 5 minutes)
$unique = 24;	// durée (en heures) pendant laquelle une IP est comptée comme unique (défaut : 24h)
$initial = 0;	// nombre initial de visiteurs au compteur
$exclude = array();	// liste des IPs (partielles ou complètes) à ne pas comptabiliser. Ex : array('127.0.0.1', '168.254.')
?>