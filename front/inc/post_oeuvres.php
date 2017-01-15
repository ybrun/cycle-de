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

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "chgdept")) {
  $insertSQL = sprintf("INSERT INTO cyclede_oeuvrespublication (type, cycle, oeuvres, chapitres, version_name, texte) VALUES (%s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['types'], "int"),
					   GetSQLValueString($_POST['cycles'], "int"),
					   GetSQLValueString($_POST['oeuvres'], "int"),
					   GetSQLValueString($_POST['chapitres'], "int"),
                       GetSQLValueString($_POST['version'], "text"),
                       GetSQLValueString($_POST['answer'], "text"));

  mysql_select_db($database_cyclede, $cyclede);
  $Result1 = mysql_query($insertSQL, $cyclede) or die(mysql_error());

  $insertGoTo = "http://www.cycle-de.fr/front/oeuvres.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

echo("<?xml version=\"1.0\" encoding=\"iso-8859-1\"?>\n");
/* Variables de connexion : ajustez ces paramètres selon votre propre environnement */
$serveur = "dmiccorpglde.mysql.db";
$admin   = "dmiccorpglde";
$mdp     = "Password7";
$base    = "dmiccorpglde";
?>

<link href="../../Styles/Fluid%20Grid%20Layout/boilerplate.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="inc/cycles_xhr.js" charset="iso_8859-1"></script>
<?php
/* Requête SQL de récupération des données de la première liste */
$sql = "SELECT `id` AS idt, `type_name` ".
       "FROM `cyclede_typeoeuvres` ".
       "ORDER BY `type_name`;";
/* Connexion et exécution de la requête */
$connexion = mysql_connect($serveur, $admin, $mdp);
if($connexion != false)
{
    $choixbase = mysql_select_db($base, $connexion);
    $recherche = mysql_query($sql, $connexion);
    /* Création du tableau PHP des valeurs récupérées */
    $types = array();
    /* Index du département par tableau régional */
    $id = 0;
    while($ligne = mysql_fetch_assoc($recherche))
    {
        $types[$ligne['idt']] = $ligne['type_name'];
    }
?>

<form name="chgdept" action="<?php echo $editFormAction; ?>" method="POST" id="chgdept">
    <table width="650" border="1" align="center" class="tab_cadrehov">
      <tr>
        <th width="146" scope="row"><div align="center"><strong>Type d'oeuvres</strong></div></th>
        <td width="488"><select name="types" id="types" onchange="getCycles(this.value);">
          <option value="vide">- - - Choisissez un type d'oeuvre - - -</option>
          <?php
    /* Construction de la premi&egrave;re liste : on se sert du tableau PHP */
    foreach($types as $nr => $nom)
    {
        ?>
          <option value="<?php echo($nr); ?>"><?php echo($nom); ?></option>
          <?php
    }
    ?>
        </select>
          <a href="/front/new_type_oeuvres.php"><img src="/images/add_dropdown.png" width="11" height="11"></a>
          <!-- ICI, le secret : on met un bloc avec un id ou va s'ins&eacute;rer le code de
         la seconde liste d&eacute;roulande --></td>
      </tr>
      <tr>
        <th scope="row"><div align="center"><strong>Cycle</strong></div></th>
        <td><script type="text/javascript" src="inc/oeuvres_xhr.js" charset="iso_8859-1"></script>
      <span id="blocCycles"></span><a href="/front/new_titre_cycle.php"><img src="/images/add_dropdown.png" width="11" height="11"></a></td>
      </tr>
      <tr>
        <th scope="row"><div align="center"><strong>Oeuvres</strong></div></th>
        <td><script type="text/javascript" src="inc/chapitres_xhr.js" charset="iso_8859-1"></script>
      <span id="blocOeuvres"></span><a href="/front/new_titre_oeuvres.php"><img src="/images/add_dropdown.png" width="11" height="11"></a></td>
      </tr>
      <tr>
        <th scope="row"><div align="center"><strong>Chapitres</strong></div></th>
        <td><span id="blocChapitres"></span><a href="/front/new_titre_chapitres.php"><img src="/images/add_dropdown.png" width="11" height="11"></a></td>
      </tr>
      <tr>
        <th scope="row"><div align="center"><strong>Versions</strong></div></th>
        <td><label for="version"></label>
        <input name="version" type="text" id="version" size="40" />
        </td>
      </tr>
      <tr>
        <th colspan="2" scope="row"><div class='center spaced'><label for="test"></label>
  <p><script language='javascript' type='text/javascript'>tinyMCE.init({
         language : 'fr',
         mode : 'exact',
         elements: 'answer',
         valid_elements: '*[*]',
         browser_spellcheck : true,
         plugins : 'table,directionality,searchreplace',
         theme : 'advanced',
         entity_encoding : 'raw', theme_advanced_buttons1_add : 'ltr,rtl,search,replace',theme_advanced_toolbar_location : 'top',
         theme_advanced_toolbar_align : 'left',
	 theme_advanced_statusbar_location : 'none',
         theme_advanced_buttons1 : 'bold,italic,underline,strikethrough,fontsizeselect,formatselect,separator,justifyleft,justifycenter,justifyright,justifyfull,bullist,numlist,outdent,indent',
         theme_advanced_buttons2 : 'forecolor,backcolor,separator,hr,separator,link,unlink,anchor,separator,tablecontrols,undo,redo,cleanup,code,separator',
         theme_advanced_buttons3 : ''});</script><span class='center spaced'>
  <textarea cols='120' rows='60' id='answer' name='answer'></textarea></span></div></p></th>
      </tr>
      <tr>
        <th colspan="2" scope="row"><div align='center'><input type="submit" name="publish" id="publish" value="Publier" /></div></th>
      </tr>
    </table>
    <input type="hidden" name="MM_insert" value="chgdept" />
</form>
<p>
  <?php
}
else
{
    /*  Si vous arrivez ici, vous avez un gros problème avec la connexion au serveur de base de données */
?>
  <?php
}
?>
<p>
