<?php
/**
 * codes.php
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
?>
<!DOCTYPE html>

<html dir="ltr" xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
<head>
<title>3en1Compteur : Codes à insérer</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<style type="text/css">
html{background:#f9f9f9;}body{background:#fff;color:#333;font-family:sans-serif;margin:2em auto;padding:1em 2em;-webkit-border-radius:3px;border-radius:3px;border:1px solid #dfdfdf;max-width:700px;}h1{border-bottom:1px solid #dadada;clear:both;color:#666;font:24px Georgia,"Times New Roman",Times,serif;margin:30px 0 0;padding:0;padding-bottom:7px;}h1 a{font-size:40px;}textarea{background:#f9f9f9;border:1px dashed #888;color:#21759b;font-family:"Courier New", Courier, monospace;padding:10px;width:675px;}#title{color:#21759b;font-size:35px;text-decoration:none;margin:6px 0 14px;border-bottom:0;text-align:center;}
</style>

</head>

<body>
<div>
<?php
$abspath = realpath('counter.php');

// code à insérer
$show = <<<SHOW
<?php
include_once('$abspath');
echo "Total : \$c_alltime <br />";
echo "Aujourd'hui : \$c_today <br />";
echo "En ligne : \$c_online";
?>
SHOW;

// crédits
$petitkiwi = <<<PK
&lt;a href="http://www.petit-kiwi.com/" title="Petit Kiwi"&gt;Petit Kiwi&lt;/a&gt;
PK;

$notoon = <<<NOTOON
&lt;a href="http://www.notoon.com/" title="NotoOn"&gt;NotoOn&lt;/a&gt;
NOTOON;
?>
	<h1 id="title">Rappel</h1>

	<h1>Insertion du code</h1>
	<p><label for="show">Copiez-collez ce code dans chaque page affichant le compteur</label>
	<textarea id="show" rows="7" cols="85" onfocus="this.select()"><?php echo $show; ?></textarea></p>

	<h1>Si vous aimez ce script, un petit lien serait très apprécié</h1>
	<p><label for="petitkiwi">Lien vers le site du script</label>
	<textarea id="petitkiwi" rows="2" cols="85" onfocus="this.select()"><?php echo $petitkiwi; ?></textarea></p>
	<p><label for="notoon">Lien vers le site de l'auteur</label>
	<textarea id="notoon" rows="2" cols="85" onfocus="this.select()"><?php echo $notoon; ?></textarea></p>
</div>
</body>
</html>