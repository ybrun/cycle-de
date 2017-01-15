<?php require_once('../../Connections/cyclede.php'); ?>
<?php
//initialize the session
if (!isset($_SESSION)) {
  session_start();
}
?>
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

$colname_texteoeuvre = "-1";
if (isset($_GET['id_pub'])) {
  $colname_texteoeuvre = $_GET['id_pub'];
}
mysql_select_db($database_cyclede, $cyclede);
$query_texteoeuvre = sprintf("SELECT id_pub, version_name, texte FROM cyclede_oeuvrespublication WHERE id_pub = %s", GetSQLValueString($colname_texteoeuvre, "int"));
$texteoeuvre = mysql_query($query_texteoeuvre, $cyclede) or die(mysql_error());
$row_texteoeuvre = mysql_fetch_assoc($texteoeuvre);
$totalRows_texteoeuvre = mysql_num_rows($texteoeuvre);
?>
<meta charset="utf8">
<style type="text/css">
.textoeuvre {
	background-color: #FFF;
	width: 80%;
}
</style>
<div class="textoeuvre">
  <table width="80%" border="0" align="center">
    <tr>
      <td><h3>Version : <?php echo $row_texteoeuvre['version_name']; ?></h3></td>
      <?php if ($_SESSION['MM_UserGroup']=="Administrateurs" or $_SESSION['MM_UserGroup']=="Culture"){ ?>
      <td width="2%"><a href="http://www.cycle-de.fr/front/modif_litterature.php?id_pub=<?php echo $row_texteoeuvre['id_pub']; ?>"><img src="http://www.cycle-de.fr/images/modif.png" width="29" height="29"></a></td>
	  <?php } ?>
    </tr>
    <tr>
      <td colspan="3"><?php echo $row_texteoeuvre['texte']; ?></td>
    </tr>
  </table>
</div>
<?php
mysql_free_result($texteoeuvre);
?>
