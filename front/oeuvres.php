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

$colname_profil_users = "-1";
if (isset($_SESSION['MM_Username'])) {
  $colname_profil_users = $_SESSION['MM_Username'];
}
mysql_select_db($database_cyclede, $cyclede);
$query_profil_users = sprintf("SELECT profil FROM cyclede_users WHERE login = %s", GetSQLValueString($colname_profil_users, "text"));
$profil_users = mysql_query($query_profil_users, $cyclede) or die(mysql_error());
$row_profil_users = mysql_fetch_assoc($profil_users);
$totalRows_profil_users = mysql_num_rows($profil_users);

$maxRows_essais = 5;
$pageNum_essais = 0;
if (isset($_GET['pageNum_essais'])) {
  $pageNum_essais = $_GET['pageNum_essais'];
}
$startRow_essais = $pageNum_essais * $maxRows_essais;

mysql_select_db($database_cyclede, $cyclede);
$query_essais = "SELECT cyclede_oeuvrespublication.id_pub, cyclede_typeoeuvres.type_name, cyclede_cycleoeuvres.cycle_name,  cyclede_oeuvres.oeuvres_name, cyclede_chapitresoeuvres.chapitres_name, cyclede_oeuvrespublication.version_name FROM cyclede_typeoeuvres, cyclede_oeuvrespublication, cyclede_cycleoeuvres, cyclede_oeuvres, cyclede_chapitresoeuvres WHERE cyclede_oeuvrespublication.type = 4 AND cyclede_typeoeuvres.id = cyclede_oeuvrespublication.type AND cyclede_cycleoeuvres.id_cycle = cyclede_oeuvrespublication.`cycle` AND cyclede_oeuvres.id_oeuvres = cyclede_oeuvrespublication.oeuvres AND cyclede_chapitresoeuvres.id_chapitres = cyclede_oeuvrespublication.chapitres ORDER BY cyclede_oeuvrespublication.id_pub DESC";
$query_limit_essais = sprintf("%s LIMIT %d, %d", $query_essais, $startRow_essais, $maxRows_essais);
$essais = mysql_query($query_limit_essais, $cyclede) or die(mysql_error());
$row_essais = mysql_fetch_assoc($essais);

if (isset($_GET['totalRows_essais'])) {
  $totalRows_essais = $_GET['totalRows_essais'];
} else {
  $all_essais = mysql_query($query_essais);
  $totalRows_essais = mysql_num_rows($all_essais);
}
$totalPages_essais = ceil($totalRows_essais/$maxRows_essais)-1;

$maxRows_nouvelles = 5;
$pageNum_nouvelles = 0;
if (isset($_GET['pageNum_nouvelles'])) {
  $pageNum_nouvelles = $_GET['pageNum_nouvelles'];
}
$startRow_nouvelles = $pageNum_nouvelles * $maxRows_nouvelles;

mysql_select_db($database_cyclede, $cyclede);
$query_nouvelles = "SELECT cyclede_oeuvrespublication.id_pub, cyclede_typeoeuvres.type_name, cyclede_cycleoeuvres.cycle_name,  cyclede_oeuvres.oeuvres_name, cyclede_chapitresoeuvres.chapitres_name, cyclede_oeuvrespublication.version_name FROM cyclede_typeoeuvres, cyclede_oeuvrespublication, cyclede_cycleoeuvres, cyclede_oeuvres, cyclede_chapitresoeuvres WHERE cyclede_oeuvrespublication.type = 3 AND cyclede_typeoeuvres.id = cyclede_oeuvrespublication.type AND cyclede_cycleoeuvres.id_cycle = cyclede_oeuvrespublication.`cycle` AND cyclede_oeuvres.id_oeuvres = cyclede_oeuvrespublication.oeuvres AND cyclede_chapitresoeuvres.id_chapitres = cyclede_oeuvrespublication.chapitres ORDER BY cyclede_oeuvrespublication.id_pub DESC";
$query_limit_nouvelles = sprintf("%s LIMIT %d, %d", $query_nouvelles, $startRow_nouvelles, $maxRows_nouvelles);
$nouvelles = mysql_query($query_limit_nouvelles, $cyclede) or die(mysql_error());
$row_nouvelles = mysql_fetch_assoc($nouvelles);

if (isset($_GET['totalRows_nouvelles'])) {
  $totalRows_nouvelles = $_GET['totalRows_nouvelles'];
} else {
  $all_nouvelles = mysql_query($query_nouvelles);
  $totalRows_nouvelles = mysql_num_rows($all_nouvelles);
}
$totalPages_nouvelles = ceil($totalRows_nouvelles/$maxRows_nouvelles)-1;

$maxRows_poesies = 5;
$pageNum_poesies = 0;
if (isset($_GET['pageNum_poesies'])) {
  $pageNum_poesies = $_GET['pageNum_poesies'];
}
$startRow_poesies = $pageNum_poesies * $maxRows_poesies;

mysql_select_db($database_cyclede, $cyclede);
$query_poesies = "SELECT cyclede_oeuvrespublication.id_pub, cyclede_typeoeuvres.type_name, cyclede_cycleoeuvres.cycle_name,  cyclede_oeuvres.oeuvres_name, cyclede_chapitresoeuvres.chapitres_name, cyclede_oeuvrespublication.version_name FROM cyclede_typeoeuvres, cyclede_oeuvrespublication, cyclede_cycleoeuvres, cyclede_oeuvres, cyclede_chapitresoeuvres WHERE cyclede_oeuvrespublication.type = 1 AND cyclede_typeoeuvres.id = cyclede_oeuvrespublication.type AND cyclede_cycleoeuvres.id_cycle = cyclede_oeuvrespublication.`cycle` AND cyclede_oeuvres.id_oeuvres = cyclede_oeuvrespublication.oeuvres AND cyclede_chapitresoeuvres.id_chapitres = cyclede_oeuvrespublication.chapitres ORDER BY cyclede_oeuvrespublication.id_pub DESC";
$query_limit_poesies = sprintf("%s LIMIT %d, %d", $query_poesies, $startRow_poesies, $maxRows_poesies);
$poesies = mysql_query($query_limit_poesies, $cyclede) or die(mysql_error());
$row_poesies = mysql_fetch_assoc($poesies);

if (isset($_GET['totalRows_poesies'])) {
  $totalRows_poesies = $_GET['totalRows_poesies'];
} else {
  $all_poesies = mysql_query($query_poesies);
  $totalRows_poesies = mysql_num_rows($all_poesies);
}
$totalPages_poesies = ceil($totalRows_poesies/$maxRows_poesies)-1;

$maxRows_romans_sf = 5;
$pageNum_romans_sf = 0;
if (isset($_GET['pageNum_romans_sf'])) {
  $pageNum_romans_sf = $_GET['pageNum_romans_sf'];
}
$startRow_romans_sf = $pageNum_romans_sf * $maxRows_romans_sf;

mysql_select_db($database_cyclede, $cyclede);
$query_romans_sf = "SELECT cyclede_oeuvrespublication.id_pub, cyclede_typeoeuvres.type_name, cyclede_cycleoeuvres.cycle_name,  cyclede_oeuvres.oeuvres_name, cyclede_chapitresoeuvres.chapitres_name, cyclede_oeuvrespublication.version_name FROM cyclede_typeoeuvres, cyclede_oeuvrespublication, cyclede_cycleoeuvres, cyclede_oeuvres, cyclede_chapitresoeuvres WHERE cyclede_oeuvrespublication.type = 2 AND cyclede_typeoeuvres.id = cyclede_oeuvrespublication.type AND cyclede_cycleoeuvres.id_cycle = cyclede_oeuvrespublication.`cycle` AND cyclede_oeuvres.id_oeuvres = cyclede_oeuvrespublication.oeuvres AND cyclede_chapitresoeuvres.id_chapitres = cyclede_oeuvrespublication.chapitres ORDER BY cyclede_oeuvrespublication.id_pub DESC";
$query_limit_romans_sf = sprintf("%s LIMIT %d, %d", $query_romans_sf, $startRow_romans_sf, $maxRows_romans_sf);
$romans_sf = mysql_query($query_limit_romans_sf, $cyclede) or die(mysql_error());
$row_romans_sf = mysql_fetch_assoc($romans_sf);

if (isset($_GET['totalRows_romans_sf'])) {
  $totalRows_romans_sf = $_GET['totalRows_romans_sf'];
} else {
  $all_romans_sf = mysql_query($query_romans_sf);
  $totalRows_romans_sf = mysql_num_rows($all_romans_sf);
}
$totalPages_romans_sf = ceil($totalRows_romans_sf/$maxRows_romans_sf)-1;

mysql_select_db($database_cyclede, $cyclede);
$query_type = "SELECT id, type_name FROM cyclede_typeoeuvres ORDER BY type_name ASC";
$type = mysql_query($query_type, $cyclede) or die(mysql_error());
$row_type = mysql_fetch_assoc($type);
$totalRows_type = mysql_num_rows($type);

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
<link href="../Styles/Fluid Grid Layout/boilerplate.css" rel="stylesheet" type="text/css">
<link href="../Styles/grid_layout_v4.css" rel="stylesheet" type="text/css">
<link href="../SpryAssets/SpryTabbedPanels.css" rel="stylesheet" type="text/css">
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
<script src="../SpryAssets/SpryTabbedPanels.js" type="text/javascript"></script>
<script type='text/javascript' src="../ScriptLibrary/tiny_mce/tiny_mce.js"></script>
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
  <h1 align="center">Oeuvres.</h1>
  <p align="center">&nbsp;</p>
  <p>
  <?php if ($_SESSION['MM_UserGroup']=='Administrateurs' or $_SESSION['MM_UserGroup']=='Contributeurs') { ?>
  <a href="http://www.cycle-de.fr/front/new_litterature.php"><input type="submit" name="new_version" id="new_version" value="Nouvelle version" /></a>
  <?php } ?>
  </p>
  <div id="TabbedPanels1" class="TabbedPanels">
    <ul class="TabbedPanelsTabGroup">
      <li class="TabbedPanelsTab" tabindex="0">News</li>
      <li class="TabbedPanelsTab" tabindex="0">Parcourir</li>
    </ul>
    <div class="TabbedPanelsContentGroup">
      <div class="TabbedPanelsContent">
        <table width="80%" border="0" align="center">
          <tr>
            <td><table width="100%" border="1" align="center" class="tab_cadrehov">
              <tr>
                <th colspan="4" scope="col">Essais</th>
                </tr>
              <tr>
                <th>Cycle</th>
                <th>Oeuvres</th>
                <th>Chapitre</th>
                <th>Version</th>
              </tr>
              <?php do { ?>
                <tr>
                  <td><?php echo $row_essais['cycle_name']; ?></td>
                  <td><?php echo $row_essais['oeuvres_name']; ?></td>
                  <td><?php echo $row_essais['chapitres_name']; ?></td>
                  <td><a href="http://www.cyclede-corp.fr/front/lecture.php?id_pub=<?php echo $row_essais['id_pub']; ?>" target="_blank"><?php echo $row_essais['version_name']; ?></a></td>
                </tr>
                <?php } while ($row_essais = mysql_fetch_assoc($essais)); ?>
            </table></td>
            <td>&nbsp;</td>
            <td><table width="100%" border="1" align="center" class="tab_cadrehov">
              <tr>
                <th colspan="4" scope="col">Nouvelles</th>
              </tr>
              <tr>
                <th>Cycle</th>
                <th>Oeuvres</th>
                <th>Chapitre</th>
                <th>Version</th>
              </tr>
              <?php do { ?>
                <tr>
                  <td><?php echo $row_nouvelles['cycle_name']; ?></td>
                  <td><?php echo $row_nouvelles['oeuvres_name']; ?></td>
                  <td><?php echo $row_nouvelles['chapitres_name']; ?></td>
                  <td><a href="http://www.cyclede-corp.fr/front/lecture.php?id_pub=<?php echo $row_nouvelles['id_pub']; ?>" target="_blank"><?php echo $row_nouvelles['version_name']; ?></a></td>
                </tr>
                <?php } while ($row_nouvelles = mysql_fetch_assoc($nouvelles)); ?>
            </table></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td><table width="100%" border="1" align="center" class="tab_cadrehov">
              <tr>
                <th colspan="4" scope="col">Po&eacute;sies</th>
              </tr>
              <tr>
                <th>Cycle</th>
                <th>Oeuvres</th>
                <th>Chapitre</th>
                <th>Version</th>
              </tr>
              <?php do { ?>
                <tr>
                  <td><?php echo $row_poesies['cycle_name']; ?></td>
                  <td><?php echo $row_poesies['oeuvres_name']; ?></td>
                  <td><?php echo $row_poesies['chapitres_name']; ?></td>
                  <td><a href="http://www.cyclede-corp.fr/front/lecture.php?id_pub=<?php echo $row_poesies['id_pub']; ?>" target="_blank"><?php echo $row_poesies['version_name']; ?></a></td>
                </tr>
                <?php } while ($row_poesies = mysql_fetch_assoc($poesies)); ?>
            </table></td>
            <td>&nbsp;</td>
            <td><table width="100%" border="1" align="center" class="tab_cadrehov">
              <tr>
                <th colspan="4" scope="col">Romans de Sciences-Fiction/Fantasy</th>
                </tr>
              <tr>
                <th>Cycle</th>
                <th>Oeuvres</th>
                <th>Chapitre</th>
                <th>Version</th>
              </tr>
              <?php do { ?>
                <tr>
                  <td><?php echo $row_romans_sf['cycle_name']; ?></td>
                  <td><?php echo $row_romans_sf['oeuvres_name']; ?></td>
                  <td><?php echo $row_romans_sf['chapitres_name']; ?></td>
                  <td><a href="http://www.cycle-de.fr/front/lecture.php?id_pub=<?php echo $row_romans_sf['id_pub']; ?>" target="_blank"><?php echo $row_romans_sf['version_name']; ?></a></td>
                </tr>
                <?php } while ($row_romans_sf = mysql_fetch_assoc($romans_sf)); ?>
            </table></td>
          </tr>
        </table>
      </div>
      <div class="TabbedPanelsContent">
      <script type="text/javascript" src="inc/cycles_xhr.js" charset="iso_8859-1"></script>
			<?php
				echo("<?xml version=\"1.0\" encoding=\"iso-8859-1\"?>\n");
				/* Variables de connexion : ajustez ces paramètres selon votre propre environnement */
				$serveur = "dmiccorpglde.mysql.db";
				$admin   = "dmiccorpglde";
				$mdp     = "Password7";
				$base    = "dmiccorpglde";
			?>
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
            <form action="<?php echo($_SERVER['PHP_SELF']); ?>" method="get" id="chgdept">
                <table width="30%" border="1" align="center" class="tab_cadrehov">
                  <tr>
                    <th width="15%" scope="row">Types</th>
                    <td width="15%"><select name="types" id="types" onchange="getCycles(this.value);">
                      <option value="vide">- - - Types - - -</option>
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
                    <!-- ICI, le secret : on met un bloc avec un id ou va s'ins&eacute;rer le code de
                     la seconde liste d&eacute;roulande --></td>
                  </tr>
                  <tr>
                    <th scope="row">Cycles</th>
                    <td>
						<script type="text/javascript" src="inc/oeuvres_xhr.js" charset="iso_8859-1"></script>
                        <span id="blocCycles"></span><br />
                    </td>
                  </tr>
                  <tr>
                    <th scope="row">Oeuvres</th>
                    <td><script type="text/javascript" src="inc/chapitres_xhr.js" charset="iso_8859-1"></script>
                        <span id="blocOeuvres"></span><br /></td>
                  </tr>
                  <tr>
                    <th scope="row">Chapitres</th>
                    <td><script type="text/javascript" src="inc/versions_xhr.js" charset="iso_8859-1"></script>
                        <span id="blocChapitres"></span><br /></td>
                  </tr>
                  <tr>
                    <th scope="row">Versions</th>
                    <td>
                    <script type="text/javascript" src="inc/texteoeuvres_xhr.js" charset="iso_8859-1"></script>
                    <span id="blocVersions"></span><br /></td>
                  </tr>
                </table>
            </form>
            <p align="center">
              <?php
            }
            else
            {
                /*  Si vous arrivez ici, vous avez un gros problème avec la connexion au serveur de base de données */
            ?>
            
              <?php
            }
            ?>
            <p align="center">
            	<span id="blocTexteoeuvres"></span><br />
          </span>            
      </div>
    </div>
  </div>
  <p>&nbsp;</p>
<!-- InstanceEndEditable --></div>
<div id="LayoutDiv6" class="footer"><!-- InstanceBeginEditable name="footer" -->
  <?php include('inc/footer/footer_users.inc.php');?>
  <script type="text/javascript">
var TabbedPanels1 = new Spry.Widget.TabbedPanels("TabbedPanels1");
  </script>
<!-- InstanceEndEditable --></div>
</div>
</body>
<!-- InstanceEnd --></html>
<?php
mysql_free_result($profil_users);

mysql_free_result($essais);

mysql_free_result($nouvelles);

mysql_free_result($poesies);

mysql_free_result($romans_sf);

mysql_free_result($type);
?>
