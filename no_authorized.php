<?php require_once ('ScriptLibrary/ban_ip.php') ;?>
<?php require_once('Connections/cyclede.php'); ?>
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

$colname_profil_users = "-1";
if (isset($_SESSION['MM_Username'])) {
  $colname_profil_users = $_SESSION['MM_Username'];
}
mysql_select_db($database_cyclede, $cyclede);
$query_profil_users = sprintf("SELECT profil FROM cyclede_users WHERE login = %s", GetSQLValueString($colname_profil_users, "text"));
$profil_users = mysql_query($query_profil_users, $cyclede) or die(mysql_error());
$row_profil_users = mysql_fetch_assoc($profil_users);
$totalRows_profil_users = mysql_num_rows($profil_users);
$_SESSION['MM_UserGroup'] = $row_profil_users['profil'];

	session_start();
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
<link href="Styles/Fluid Grid Layout/boilerplate.css" rel="stylesheet" type="text/css">
<link href="Styles/grid_layout_v4.css" rel="stylesheet" type="text/css">
<!-- 
Pour en savoir plus sur les commentaires conditionnels autour des balises HTML en haut du fichier :
paulirish.com/2008/conditional-stylesheets-vs-css-hacks-answer-neither/

Procédez comme suit si vous utilisez une version personnalisée de modernizr (http://www.modernizr.com/) :
* insérez ici le lien vers votre js
* supprimez le lien ci-dessous vers html5shiv
* ajoutez la classe "no-js" aux balises HTML en haut
* vous pouvez aussi supprimer le lien vers respond.min.js si vous avez inclus MQ Polyfill dans votre version de modernizr 
-->
<!--[if lt IE 9]>
<script src="//html5shiv.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->
<script src="Styles/Fluid%20Grid%20Layout/respond.min.js"></script>
<!-- InstanceEndEditable -->
</head>

<body>
<div class="gridContainer clearfix">
  <div id="LayoutDiv1" class="header"><!-- InstanceBeginEditable name="header" -->
   <?php include ('front/inc/header/header.inc.php'); ?>
    <!-- end .header -->
<!-- InstanceEndEditable --></div>
  <div class="sidebar1" id="LayoutDiv3" align="center"><!-- InstanceBeginEditable name="sidebar1" -->
   <?php include ('front/inc/sidebar/stats/stats.php'); ?>
   </p>
<!-- InstanceEndEditable --></div>
<div id="LayoutDiv4" class="content"><!-- InstanceBeginEditable name="content" -->
<h1 align="center"><span class="Style3">Vous n'&eacirc;tes pas autoris&eacute; &agrave; acc&eacute;der dans cette section. Veuillez vous reconnecter.</span></h1>
  <p align="center">&nbsp;</p>
  <div id="firstboxlogin">
    <div id="logo_login"></div>
    <div id="text-login">
      Bienvenu sur le portail du Cycle des Dragons Ecarlates.				
      </div>
    <p></p>
    <div id="boxlogin">
      <form action="<?php echo $loginFormAction; ?>" method="POST" name="connexion" id="connexion">
        <fieldset>
          <legend>Authentification</legend>
          <div class="loginrow">
            <span class="loginlabel">
              <label for="login2">Login</label>
              </span>
            <span class="loginformw">
              <input name="login" type="text" id="login2" size="50"required>
              </span>
            </div>
          <div class="loginrow">
            <span class="loginlabel">
              <label for="password">Mot de passe</label>
              </span>
            <span class="loginformw">
              <input name="password" type="password" id="password" size="50" required>
              </span>
            </div>
          </fieldset>
        <p>&nbsp;</p>
        <p align="center"><span><input type="submit" name="connexion2" id="connexion2" value="Connexion" class="submit"></span></p>
        </form>
      </div>
    <p>&nbsp;</p>
    <p align="center">&nbsp;</p>
  </div>
  <!-- end .content -->
<!-- InstanceEndEditable --></div>
<div id="LayoutDiv6" class="footer"><!-- InstanceBeginEditable name="footer" -->
  <?php include('front/inc/footer/footer_users.inc.php');?>
  <!-- end .footer -->
<!-- InstanceEndEditable --></div>
</div>
</body>
<!-- InstanceEnd --></html>
