<?php require_once ('../ScriptLibrary/ban_ip.php') ;?>
<?php require_once('../Connections/cyclede.php'); ?>
<?php
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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "actualite")) {
  $updateSQL = sprintf("UPDATE cyclede_actualites SET `date`=%s, titre=%s, type=%s, actualites=%s WHERE id=%s",
                       GetSQLValueString($_POST['date_actualite'], "date"),
					   GetSQLValueString($_POST['titre'], "text"),
                       GetSQLValueString($_POST['section_site'], "text"),
                       GetSQLValueString($_POST['modif_actualite'], "text"),
                       GetSQLValueString($_POST['id'], "int"));

  mysql_select_db($database_cyclede, $cyclede);
  $Result1 = mysql_query($updateSQL, $cyclede) or die(mysql_error());

  $updateGoTo = "http://www.cycle-de.fr/front/index.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: http://www.cycle-de.fr/front/index.php"));
}

mysql_select_db($database_cyclede, $cyclede);
$query_section = "SELECT * FROM cyclede_type_actualite ORDER BY type_actualite ASC";
$section = mysql_query($query_section, $cyclede) or die(mysql_error());
$row_section = mysql_fetch_assoc($section);
$totalRows_section = mysql_num_rows($section);

$colname_news_dyn = "-1";
if (isset($_GET['id'])) {
  $colname_news_dyn = $_GET['id'];
}
mysql_select_db($database_cyclede, $cyclede);
$query_news_dyn = sprintf("SELECT * FROM cyclede_actualites WHERE id = %s", GetSQLValueString($colname_news_dyn, "int"));
$news_dyn = mysql_query($query_news_dyn, $cyclede) or die(mysql_error());
$row_news_dyn = mysql_fetch_assoc($news_dyn);
$totalRows_news_dyn = mysql_num_rows($news_dyn);

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
?>
<?php
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "Administrateurs,Contributeurs";
$MM_donotCheckaccess = "false";

// *** Restrict Access To Page: Grant or deny access to this page
function isAuthorized($strUsers, $strGroups, $UserName, $UserGroup) { 
  // For security, start by assuming the visitor is NOT authorized. 
  $isValid = False; 

  // When a visitor has logged into this site, the Session variable MM_Username set equal to their username. 
  // Therefore, we know that a user is NOT logged in if that Session variable is blank. 
  if (!empty($UserName)) { 
    // Besides being logged in, you may restrict access to only certain users based on an ID established when they login. 
    // Parse the strings into arrays. 
    $arrUsers = Explode(",", $strUsers); 
    $arrGroups = Explode(",", $strGroups); 
    if (in_array($UserName, $arrUsers)) { 
      $isValid = true; 
    } 
    // Or, you may restrict access to only certain users based on their username. 
    if (in_array($UserGroup, $arrGroups)) { 
      $isValid = true; 
    } 
    if (($strUsers == "") && false) { 
      $isValid = true; 
    } 
  } 
  return $isValid; 
}

$MM_restrictGoTo = "http://www.cycle-de.fr/no_authorized.php";
if (!((isset($_SESSION['MM_Username'])) && (isAuthorized("",$MM_authorizedUsers, $_SESSION['MM_Username'], $_SESSION['MM_UserGroup'])))) {   
  $MM_qsChar = "?";
  $MM_referrer = $_SERVER['PHP_SELF'];
  if (strpos($MM_restrictGoTo, "?")) $MM_qsChar = "&";
  if (isset($_SERVER['QUERY_STRING']) && strlen($_SERVER['QUERY_STRING']) > 0) 
  $MM_referrer .= "?" . $_SERVER['QUERY_STRING'];
  $MM_restrictGoTo = $MM_restrictGoTo. $MM_qsChar . "accesscheck=" . urlencode($MM_referrer);
  header("Location: ". $MM_restrictGoTo); 
  exit;
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
<link href="../Styles/Fluid Grid Layout/boilerplate.css" rel="stylesheet" type="text/css">
<link href="../Styles/grid_layout_v4.css" rel="stylesheet" type="text/css">
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
<script src="../Styles/Fluid%20Grid%20Layout/respond.min.js"></script>
<script type='text/javascript' src="../ScriptLibrary/tiny_mce/tiny_mce.js"></script>
<style type="text/css">
.Style5 {color: #FFFFCC}
.Style7 {color: #660033; }
</style>
<!-- InstanceEndEditable -->
</head>

<body>
<div class="gridContainer clearfix">
  <div id="LayoutDiv1" class="header"><!-- InstanceBeginEditable name="header" -->
    <?php include ('inc/header/header.inc.php'); ?>
    <!-- end .header -->
<!-- InstanceEndEditable --></div>
  <div class="sidebar1" id="LayoutDiv3" align="center"><!-- InstanceBeginEditable name="sidebar1" -->
   <?php include ('inc/sidebar/stats/stats.php'); ?>
   </p>
<!-- InstanceEndEditable --></div>
<div id="LayoutDiv4" class="content"><!-- InstanceBeginEditable name="content" -->
    <h1 align="center" class="Style7">Ajouter une actualit&eacute;.</h1>
    <p align="center" class="Style5">&nbsp;</p>
    <form action="<?php echo $editFormAction; ?>" method="POST" name="actualite" id="actualite">
		<div align="center">
			<table width="1000" border="1" class="tab_cadrehov">
				<tr class="noHover">
					<th width="50">
						<div align="center">
							<input name="id" type="hidden" id="id" value="<?php echo $row_news_dyn['id']; ?>">
							<strong><?php echo $row_news_dyn['date']; ?></strong>
							<input name="date_actualite" type="hidden" id="date_actualite" value="<?php echo $row_news_dyn['date']; ?>" />
						</div>
					</th>
					<th width="441">
						<p><strong>Titre : </strong>
						<input name="titre" type="text" id="titre" value="<?php echo $row_news_dyn['titre']; ?>" size="50">
						<em>( 
							<select name="section_site" id="section_site">
							<?php
								do {  
							?>
							<option value="<?php echo $row_section['type_actualite']?>"<?php if (!(strcmp($row_section['type_actualite'], $row_news_dyn['type']))) {echo "selected=\"selected\"";} ?>><?php echo $row_section['type_actualite']?></option>
							<?php
								} while ($row_section = mysql_fetch_assoc($section));
								$rows = mysql_num_rows($section);
								if($rows > 0) {
									mysql_data_seek($section, 0);
									$row_section = mysql_fetch_assoc($section);
								}
							?>
							</select>
							<a href="http://www.dmic-corp.fr/front/admin/config_intitules_types_actualites.php" target="pop-up1" onClick="window.open('','pop-up1','width=1075,height=800,top=150,left=200,toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=0,resizable=0')"><img src="http://www.dmic-corp.fr/images/add_dropdown.png" alt="" width="11" height="11"></a>
                        </em>
                        <em>
						) </em></p>
					</th>
				</tr>
				<tr>
					<td colspan="2"><div align="justify"><label>
						<script language='javascript' type='text/javascript'>tinyMCE.init({
							language : 'fr',
							mode : 'exact',
							elements: 'modif_actualite',
							valid_elements: '*[*]',
							browser_spellcheck : true,
							plugins : 'table,directionality,searchreplace',
							theme : 'advanced',
							entity_encoding : 'raw', theme_advanced_buttons1_add : 'ltr,rtl,search,replace',theme_advanced_toolbar_location : 'top',
							theme_advanced_toolbar_align : 'left',
							theme_advanced_statusbar_location : 'none',
							theme_advanced_buttons1 : 'bold,italic,underline,strikethrough,fontsizeselect,formatselect,separator,justifyleft,justifycenter,justifyright,justifyfull,bullist,numlist,outdent,indent',
							theme_advanced_buttons2 : 'forecolor,backcolor,separator,hr,separator,link,unlink,anchor,separator,tablecontrols,undo,redo,cleanup,code,separator',
							theme_advanced_buttons3 : ''});
						</script>
						<div class='center spaced'>
							<textarea name='modif_actualite' cols='125' rows='15' id='modif_actualite' onBlur="MM_validateForm('answer','','R');return document.MM_returnValue"><?php echo $row_news_dyn['actualites']; ?></textarea>
						</div>
					</label></div></td>
				</tr>
			</table>
			<input type="submit" name="submit" id="submit" value="Publier" />
			<input type="hidden" name="MM_update" value="actualite">
		</div>
	</form>
    <p align="center" class="Style5">&nbsp;</p>
  <!-- end .content -->
<!-- InstanceEndEditable --></div>
<div id="LayoutDiv6" class="footer"><!-- InstanceBeginEditable name="footer" -->
  <?php include('inc/footer/footer_users.inc.php');?>
<!-- InstanceEndEditable --></div>
</div>
</body>
<!-- InstanceEnd --></html>
<?php
mysql_free_result($section);

mysql_free_result($news_dyn);
?>
