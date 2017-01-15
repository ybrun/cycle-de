<?php require_once ('../ScriptLibrary/ban_ip.php') ;?>
<?php require_once('../Connections/cyclede.php'); ?>
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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE cyclede_oeuvrespublication SET type=%s, `cycle`=%s, oeuvres=%s, chapitres=%s, version_name=%s, texte=%s WHERE id_pub=%s",
                       GetSQLValueString($_POST['type'], "int"),
                       GetSQLValueString($_POST['cycle'], "int"),
                       GetSQLValueString($_POST['oeuvres'], "int"),
                       GetSQLValueString($_POST['chapitres'], "int"),
                       GetSQLValueString($_POST['version_name'], "text"),
                       GetSQLValueString($_POST['answer'], "text"),
                       GetSQLValueString($_POST['id_pub'], "int"));

  mysql_select_db($database_cyclede, $cyclede);
  $Result1 = mysql_query($updateSQL, $cyclede) or die(mysql_error());

  $updateGoTo = "http://www.cyclede-corp.fr/front/geek-zone/litterature.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
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

$colname_texteoeuvre = "-1";
if (isset($_GET['id_pub'])) {
  $colname_texteoeuvre = $_GET['id_pub'];
}
mysql_select_db($database_cyclede, $cyclede);
$query_texteoeuvre = sprintf("SELECT cyclede_oeuvrespublication.id_pub, cyclede_oeuvrespublication.type, cyclede_typeoeuvres.type_name, cyclede_oeuvrespublication.cycle, cyclede_cycleoeuvres.cycle_name, cyclede_oeuvrespublication.oeuvres, cyclede_oeuvres.oeuvres_name, cyclede_oeuvrespublication.chapitres, cyclede_chapitresoeuvres.chapitres_name, cyclede_oeuvrespublication.version_name, cyclede_oeuvrespublication.texte FROM cyclede_oeuvrespublication, cyclede_typeoeuvres, cyclede_cycleoeuvres, cyclede_oeuvres, cyclede_chapitresoeuvres WHERE id_pub = %s AND cyclede_oeuvrespublication.type = cyclede_typeoeuvres.id AND cyclede_oeuvrespublication.cycle = cyclede_cycleoeuvres.id_cycle AND cyclede_oeuvrespublication.oeuvres = cyclede_oeuvres.id_oeuvres AND cyclede_oeuvrespublication.chapitres=cyclede_chapitresoeuvres.id_chapitres", GetSQLValueString($colname_texteoeuvre, "int"));
$texteoeuvre = mysql_query($query_texteoeuvre, $cyclede) or die(mysql_error());
$row_texteoeuvre = mysql_fetch_assoc($texteoeuvre);
$totalRows_texteoeuvre = mysql_num_rows($texteoeuvre);
$_SESSION['MM_UserGroup'] = $row_profil_users['profil'];

	session_start();
?>
<!doctype html>
<!--[if lt IE 7]> <html class="ie6 oldie"> <![endif]-->
<!--[if IE 7]>    <html class="ie7 oldie"> <![endif]-->
<!--[if IE 8]>    <html class="ie8 oldie"> <![endif]-->
<!--[if gt IE 8]><!-->
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
<!-- InstanceEndEditable -->
</head>

<body>
<div class="gridContainer clearfix">
  <div class="header" id="LayoutDiv1"><!-- InstanceBeginEditable name="header" -->
    <?php include ('inc/header/header.inc.php'); ?>
  <!-- InstanceEndEditable --></div>
  <div class="sidebar1" id="LayoutDiv3" align="center"><!-- InstanceBeginEditable name="sidebar1" -->
		<?php include ('inc/sidebar/stats/stats.php'); ?>
		<!-- InstanceEndEditable --></div>
<div id="LayoutDiv4" class="content"><!-- InstanceBeginEditable name="content" -->
          <div align="center"><form name="form1" id="form1" method="POST" action="<?php echo $editFormAction; ?>">
	<label for="test"></label>
	<span class='center spaced'>
		<div class='center spaced'>
			<p>
			  <label for="test"></label>
		  </p>
			<table width="80%" border="1" class="tab_cadrehov">
			  <tr>
			    <th scope="row"><input name="id_pub" type="hidden" id="id_pub" value="<?php echo $row_texteoeuvre['id_pub']; ?>">
		        Type</th>
			    <td><input name="type" type="hidden" id="type" value="<?php echo $row_texteoeuvre['type']; ?>">
		        <?php echo $row_texteoeuvre['type_name']; ?></td>
		      </tr>
			  <tr>
			    <th scope="row">Cycle</th>
			    <td><input name="cycle" type="hidden" id="cycle" value="<?php echo $row_texteoeuvre['cycle']; ?>">
		        <?php echo $row_texteoeuvre['cycle_name']; ?></td>
		      </tr>
			  <tr>
			    <th scope="row">Oeuvre</th>
			    <td><input name="oeuvres" type="hidden" id="oeuvres" value="<?php echo $row_texteoeuvre['oeuvres']; ?>">
		        <?php echo $row_texteoeuvre['oeuvres_name']; ?></td>
		      </tr>
			  <tr>
			    <th scope="row">Chapitre</th>
			    <td><input name="chapitres" type="hidden" id="chapitres" value="<?php echo $row_texteoeuvre['chapitres']; ?>">
		        <?php echo $row_texteoeuvre['chapitres_name']; ?></td>
		      </tr>
			  <tr>
			    <th scope="row">Version</th>
			    <td><input name="version_name" type="hidden" id="version_name" value="<?php echo $row_texteoeuvre['version_name']; ?>">
		        <?php echo $row_texteoeuvre['version_name']; ?></td>
		      </tr>
			  <tr>
			    <td colspan="2" scope="row"> <script language='javascript' type='text/javascript'>tinyMCE.init({
         		language : 'fr',
         		mode : 'exact',
        		elements: 'answer',
         		valid_elements: '*[*]',
         		browser_spellcheck : true,
         		plugins : 'table,directionality,searchreplace',
         		theme : 'advanced',
         		entity_encoding : 'raw', 
				theme_advanced_buttons1_add : 'ltr,rtl,search,replace',					
				theme_advanced_toolbar_location : 'top',
         		theme_advanced_toolbar_align : 'left',
	 			theme_advanced_statusbar_location : 'none',
         		theme_advanced_buttons1 : 'bold,italic,underline,strikethrough,fontsizeselect,formatselect,separator,justifyleft,justifycenter,justifyright,justifyfull,bullist,numlist,outdent,indent',
         		theme_advanced_buttons2 : 'forecolor,backcolor,separator,hr,separator,link,unlink,anchor,separator,tablecontrols,undo,redo,cleanup,code,separator',
         		theme_advanced_buttons3 : ''});
			    </script>
                <div align="center"><textarea cols='150' rows='60' id='answer' name='answer'><?php echo $row_texteoeuvre['texte']; ?></textarea></div></th>
		      </tr>
		  </table>
		</div>
	</span>
  	<div align="center">
    	<input type="submit" name="publish" id="publish" value="Publier" />
	</div>
  	<input type="hidden" name="MM_update" value="form1">
</form></div>

        <!-- InstanceEndEditable --></div>
<div id="LayoutDiv6" class="footer"><!-- InstanceBeginEditable name="footer" -->
  <?php include('inc/footer/footer_users.inc.php');?>
<!-- InstanceEndEditable --></div>
</div>
</body>
<!-- InstanceEnd --></html>
<?php
mysql_free_result($profil_users);

mysql_free_result($texteoeuvre);
?>