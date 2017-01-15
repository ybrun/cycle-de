<?php require_once('../Connections/cyclede.php'); ?>
<?php require_once ('../ScriptLibrary/ban_ip.php') ;?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}

$currentPage = $_SERVER["PHP_SELF"];

//initialize the session
if (!isset($_SESSION)) {
  session_start();
}

if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}

$maxRows_news = 10;
$pageNum_news = 0;
if (isset($_GET['pageNum_news'])) {
  $pageNum_news = $_GET['pageNum_news'];
}
$startRow_news = $pageNum_news * $maxRows_news;

mysql_select_db($database_cyclede, $cyclede);
$query_news = "SELECT * FROM cyclede_actualites ORDER BY `date` DESC";
$query_limit_news = sprintf("%s LIMIT %d, %d", $query_news, $startRow_news, $maxRows_news);
$news = mysql_query($query_limit_news, $cyclede) or die(mysql_error());
$row_news = mysql_fetch_assoc($news);

if (isset($_GET['totalRows_news'])) {
  $totalRows_news = $_GET['totalRows_news'];
} else {
  $all_news = mysql_query($query_news);
  $totalRows_news = mysql_num_rows($all_news);
}
$totalPages_news = ceil($totalRows_news/$maxRows_news)-1;

$colname_profil_users = "-1";
if (isset($_SESSION['MM_Username'])) {
  $colname_profil_users = $_SESSION['MM_Username'];
}
mysql_select_db($database_cyclede, $cyclede);
$query_profil_users = sprintf("SELECT profil FROM cyclede_users WHERE login = %s", GetSQLValueString($colname_profil_users, "text"));
$profil_users = mysql_query($query_profil_users, $cyclede) or die(mysql_error());
$row_profil_users = mysql_fetch_assoc($profil_users);
$totalRows_profil_users = mysql_num_rows($profil_users);

$queryString_news = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_news") == false && 
        stristr($param, "totalRows_news") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_news = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_news = sprintf("&totalRows_news=%d%s", $totalRows_news, $queryString_news);
$_SESSION['MM_UserGroup'] = $row_profil_users['profil'];
?>
<!doctype html>
<html><!-- InstanceBegin template="/Templates/modele_cycle-de.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>
<meta charset="utf8">
<meta name="robots" content="noindex">
<!-- InstanceBeginEditable name="doctitle" -->
<title>Le Cycle des Dragons Ecarlates</title>
<!-- InstanceEndEditable -->
<!-- InstanceBeginEditable name="head" -->
<link href="../Styles/Fluid Grid Layout/boilerplate.css" rel="stylesheet" type="text/css">
<link href="../Styles/grid_layout_v4.css" rel="stylesheet" type="text/css">
<!-- 
Pour en savoir plus sur les commentaires conditionnels autour des balises HTML en haut du fichier :
paulirish.com/2008/conditional-stylesheets-vs-css-hacks-answer-neither/
 
Procédez comme suit si vous utilisez une version personnalisée de modernizr (http://www.modernizr.com/) :
* insérez ici le lien vers votre js
* supprimez le lien ci-dessous vers html5shiv
* ajoutez la classe "no-js" aux balises HTML en haut
* vous pouvez aussi supprimer le lien vers respond.min.js si vous avez inclus MQ Polyfill dans votre version de modernizr 
-->
<!--[if lt IE 9]>
<script src="//html5shiv.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->
<script src="../Styles/Fluid%20Grid%20Layout/respond.min.js"></script>
<!-- InstanceEndEditable -->
</head>
 
<body>
<div class="gridContainer clearfix">
  <div id="LayoutDiv1" class="header"><!-- InstanceBeginEditable name="header" -->
    <?php include ('inc/header/header.inc.php'); ?> 
<!-- InstanceEndEditable --></div>
  <div class="sidebar1" id="LayoutDiv3" align="center"><!-- InstanceBeginEditable name="sidebar1" -->
   <?php include ('inc/sidebar/stats/stats.php'); ?>
   </p>
<!-- InstanceEndEditable --></div>
<div id="LayoutDiv4" class="content"><!-- InstanceBeginEditable name="content" -->
  <h1 align="center">Actualit&eacute;s.</h1>
<p align="center">&nbsp;</p>
  <?php if ($_SESSION['MM_UserGroup']=='Administrateurs' or $_SESSION['MM_UserGroup']=='Contributeurs' or $_SESSION['MM_UserGroup']=='Formateurs') { ?><a href="http://www.cycle-de.fr/front/new_actualite.php"><input type="submit" name="Nouvelle actualit&eacute;" id="Nouvelle actualit&eacute;" value="Nouvelle actualit&eacute" class="submit">
  </a><?php } ?>
<p align="center">&nbsp;</p>
<table width="50" border="0" align="center">
  <tr class="Style7">
    <?php if ($pageNum_news > 0) { // Show if not first page ?>
    <th scope="col"><a href="<?php printf("%s?pageNum_news=%d%s", $currentPage, 0, $queryString_news); ?>"><img src="http://www.cycle-de.fr/images/first.png" width="12" height="10" /></a></th>
    <th scope="col"><a href="<?php printf("%s?pageNum_news=%d%s", $currentPage, max(0, $pageNum_news - 1), $queryString_news); ?>"><img src="http://www.cycle-de.fr/images/left.png" width="10" height="10" /></a></th>
    <?php } // Show if not first page ?>
    <th scope="col"><div align="center">De</div></th>
    <th scope="col"><div align="center"><?php echo ($startRow_news + 1) ?></div></th>
    <th scope="col"><div align="center">&agrave;</div></th>
    <th scope="col"><div align="center"><?php echo min($startRow_news + $maxRows_news, $totalRows_news) ?></div></th>
    <th scope="col"><div align="center">sur</div></th>
    <th scope="col"><div align="center"><?php echo $totalRows_news ?></div></th>
    <?php if ($pageNum_news < $totalPages_news) { // Show if not last page ?>
    <th scope="col"><a href="<?php printf("%s?pageNum_news=%d%s", $currentPage, min($totalPages_news, $pageNum_news + 1), $queryString_news); ?>"><img src="http://www.cycle-de.fr/images/right.png" width="10" height="10" /></a></th>
    <th scope="col"><a href="<?php printf("%s?pageNum_news=%d%s", $currentPage, $totalPages_news, $queryString_news); ?>"><img src="http://www.cycle-de.fr/images/last.png" width="12" height="10" /></a></th>
    <?php } // Show if not last page ?>
  </tr>
</table>
<?php do { ?>
<table width="60%" align="center" class="tab_cadrehov">
  <tbody>
    <tr class="noHover">
      <th width="491"><div align="center" class="Style11"><?php echo $row_news['date']; ?></div></th>
      <th width="748"><strong><?php echo $row_news['titre'] . ''; ?></strong><em>(<?php echo $row_news['type']; ?>)</em></th>
      <?php if ($_SESSION['MM_UserGroup']=='Administrateurs' or $_SESSION['MM_UserGroup']=='Contributeurs' or $_SESSION['MM_UserGroup']=='Formateurs') { ?>
      <td width="32" rowspan="2"><label><a href="http://www.cycle-de.fr/front/modif_actualite.php?id=<?php echo $row_news['id']; ?>"><img src="http://www.cycle-de.fr/images/modif.png" width="29" height="29" align="middle"></a></label></td>
      <?php } ?>
    </tr>
    <tr>
      <td colspan="2"><?php echo $row_news['actualites']; ?></td>
    </tr>
    </tbody>
</table>
<br>
<?php } while ($row_news = mysql_fetch_assoc($news)); ?>
<table width="50" border="0" align="center">
  <tr class="Style7">
    <?php if ($pageNum_news > 0) { // Show if not first page ?>
    <th scope="col"><a href="<?php printf("%s?pageNum_news=%d%s", $currentPage, 0, $queryString_news); ?>"><img src="http://www.cycle-de.fr/images/first.png" width="12" height="10" /></a></th>
    <th scope="col"><a href="<?php printf("%s?pageNum_news=%d%s", $currentPage, max(0, $pageNum_news - 1), $queryString_news); ?>"><img src="http://www.cycle-de.fr/images/left.png" width="10" height="10" /></a></th>
    <?php } // Show if not first page ?>
    <th scope="col"><div align="center">De</div></th>
    <th scope="col"><div align="center"><?php echo ($startRow_news + 1) ?></div></th>
    <th scope="col"><div align="center">&agrave;</div></th>
    <th scope="col"><div align="center"><?php echo min($startRow_news + $maxRows_news, $totalRows_news) ?></div></th>
    <th scope="col"><div align="center">sur</div></th>
    <th scope="col"><div align="center"><?php echo $totalRows_news ?></div></th>

    <?php if ($pageNum_news < $totalPages_news) { // Show if not last page ?>
    <th scope="col"><a href="<?php printf("%s?pageNum_news=%d%s", $currentPage, min($totalPages_news, $pageNum_news + 1), $queryString_news); ?>"><img src="http://www.cycle-de.fr/images/right.png" width="10" height="10" /></a></th>
    <th scope="col"><a href="<?php printf("%s?pageNum_news=%d%s", $currentPage, $totalPages_news, $queryString_news); ?>"><img src="http://www.cycle-de.fr/images/last.png" width="12" height="10" /></a></th>
    <?php } // Show if not last page ?>
  </tr>
</table>
<p>&nbsp;</p>
 
<!-- InstanceEndEditable --></div>
<div id="LayoutDiv6" class="footer"><!-- InstanceBeginEditable name="footer" -->
  <?php include('inc/footer/footer_users.inc.php');?>
<!-- InstanceEndEditable --></div>
</div>
</body>
<!-- InstanceEnd --></html>
<?php
mysql_free_result($news);

mysql_free_result($profil_users);
?>
