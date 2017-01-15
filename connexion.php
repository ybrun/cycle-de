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

mysql_select_db($database_cyclede, $cyclede);
$query_users = "SELECT * FROM cyclede_users ORDER BY login ASC";
$users = mysql_query($query_users, $cyclede) or die(mysql_error());
$row_users = mysql_fetch_assoc($users);
$totalRows_users = mysql_num_rows($users);
?>
<?php
// *** Validate request to login to this site.
if (!isset($_SESSION)) {
  session_start();
}

$loginFormAction = $_SERVER['PHP_SELF'];
if (isset($_GET['accesscheck'])) {
  $_SESSION['PrevUrl'] = $_GET['accesscheck'];
}

if (isset($_POST['login'])) {
  $loginUsername=$_POST['login'];
  $password=md5($_POST['password']);
  $MM_fldUserAuthorization = "profil";
  $MM_redirectLoginSuccess = "http://www.cycle-de.fr/front/index.php";
  $MM_redirectLoginFailed = "http://www.cycle-de.fr/no_authorized.php";
  $MM_redirecttoReferrer = false;
  mysql_select_db($database_cyclede, $cyclede);
  	
  $LoginRS__query=sprintf("SELECT login, password, profil FROM cyclede_users WHERE login=%s AND password=%s",
  GetSQLValueString($loginUsername, "text"), GetSQLValueString($password, "text")); 
   
  $LoginRS = mysql_query($LoginRS__query, $cyclede) or die(mysql_error());
  $loginFoundUser = mysql_num_rows($LoginRS);
  if ($loginFoundUser) {
    
    $loginStrGroup  = mysql_result($LoginRS,0,'profil');
    
	if (PHP_VERSION >= 5.1) {session_regenerate_id(true);} else {session_regenerate_id();}
    //declare two session variables and assign them
    $_SESSION['MM_Username'] = $loginUsername;
    $_SESSION['MM_UserGroup'] = $loginStrGroup;	      

    if (isset($_SESSION['PrevUrl']) && false) {
      $MM_redirectLoginSuccess = $_SESSION['PrevUrl'];	
    }
    header("Location: " . $MM_redirectLoginSuccess );
  }
  else {
    header("Location: ". $MM_redirectLoginFailed );
  }
}
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
<!-- InstanceEndEditable --></div>
</div>
</body>
<!-- InstanceEnd --></html>
<?php
mysql_free_result($users);
?>
