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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "new_categorie")) {
  $insertSQL = sprintf("INSERT INTO cyclede_typeoeuvres (type_name, type_commentaire) VALUES (%s, %s)",
                       GetSQLValueString($_POST['type_name'], "text"),
                       GetSQLValueString($_POST['commentaire'], "text"));

  mysql_select_db($database_cyclede, $cyclede);
  $Result1 = mysql_query($insertSQL, $cyclede) or die(mysql_error());

  $insertGoTo = "/front/new_litterature.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

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
<script src="../Styles/Fluid%20Grid%20Layout/respond.min.js"></script>
<script type='text/javascript' src="../ScriptLibrary/tiny_mce/tiny_mce.js"></script>
<!-- InstanceEndEditable -->
</head>

<body>
<div class="gridContainer clearfix">
  <div class="header" id="LayoutDiv1"><!-- InstanceBeginEditable name="header" -->
<?php include ('inc/header/header.inc.php'); ?>
    <!-- end .header -->
<!-- InstanceEndEditable --></div>
  <div class="sidebar1" id="LayoutDiv3" align="center"><!-- InstanceBeginEditable name="sidebar1" -->
<?php include ('inc/sidebar/stats/stats.php');?>
  <!-- end .sidebar1 -->
<!-- InstanceEndEditable --></div>
<div id="LayoutDiv4" class="content"><!-- InstanceBeginEditable name="content" -->
    <h1 align="center" class="Style7">Litt&eacute;rature.</h1>
  <h2 align="center" class="Style7">Nouveau type d'oeuvre.</h2>
  <p align="center">&nbsp;</p>
  <form action="<?php echo $editFormAction; ?>" method="POST" name="new_categorie" id="new_categorie">
    <label></label>
    <table width="300" border="1" align="center" bordercolor="#92BEE1" class="tab_cadrehov">
      <tr>
        <th bordercolor="#92BEE1" scope="col"><div align="center" class="Style7">Nom</div></th>
        <th bordercolor="#92BEE1" scope="col"><label>
          <input name="type_name" type="text" id="type_name" value="" size="100" />
          </label></th>
      </tr>
      <tr>
        <th bordercolor="#92BEE1" scope="row"><div align="right" class="Style7 Style7">
          <div align="center">Commentaire</div>
          </div></th>
        <td bordercolor="#92BEE1"><label>
          <script type='text/javascript' src='../../../glpi/lib/tiny_mce/tiny_mce.js'></script>
<script language='javascript' type='text/javascript'>tinyMCE.init({
         language : 'fr',
         mode : 'exact',
         elements: 'commentaire',
         valid_elements: '*[*]',
         browser_spellcheck : true,
         plugins : 'table,directionality,searchreplace',
         theme : 'advanced',
         entity_encoding : 'raw', theme_advanced_buttons1_add : 'ltr,rtl,search,replace',theme_advanced_toolbar_location : 'top',
         theme_advanced_toolbar_align : 'left',
	 theme_advanced_statusbar_location : 'none',
         theme_advanced_buttons1 : 'bold,italic,underline,strikethrough,fontsizeselect,formatselect,separator,justifyleft,justifycenter,justifyright,justifyfull,bullist,numlist,outdent,indent',
         theme_advanced_buttons2 : 'forecolor,backcolor,separator,hr,separator,link,unlink,anchor,separator,tablecontrols,undo,redo,cleanup,code,separator',
         theme_advanced_buttons3 : ''});</script>
<div class='center spaced'><textarea name='commentaire' cols='100' rows='30' id='commentaire' onBlur="MM_validateForm('answer','','R');return document.MM_returnValue"></textarea>
</div>
          </label></td>
        </tr>
      <tr>
        <th bordercolor="#92BEE1" scope="row">&nbsp;</th>
        <td bordercolor="#92BEE1"><label>
          <input type="submit" name="submit" id="submit" value="Envoyer" />
          </label></td>
        </tr>
      </table>
    <label> </label>
    <input type="hidden" name="MM_insert" value="new_categorie" />
    </form>
  <h2 align="center" class="Style18"></h2>
  <h1>&nbsp;</h1>
<!-- InstanceEndEditable --></div>
<div id="LayoutDiv6" class="footer"><!-- InstanceBeginEditable name="footer" -->
  <?php include('inc/footer/footer_users.inc.php');?>
<!-- InstanceEndEditable --></div>
</div>
</body>
<!-- InstanceEnd --></html>