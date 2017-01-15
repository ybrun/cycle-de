<?php require_once ('ScriptLibrary/ban_ip.php') ;?>
<!doctype html>
<html>
<head>
<meta charset="utf8">
<meta name="robots" content="noindex">
<!-- TemplateBeginEditable name="doctitle" -->
<title>Le Cycle des Dragons Ecarlates</title>
<!-- TemplateEndEditable -->
<!-- TemplateBeginEditable name="head" -->
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
<!-- TemplateEndEditable -->
</head>

<body>
<div class="gridContainer clearfix">
  <div id="LayoutDiv1" class="header"><!-- TemplateBeginEditable name="header" -->
    <?php include ('front/inc/header/header.inc.php'); ?> 
<!-- TemplateEndEditable --></div>
  <div class="sidebar1" id="LayoutDiv3" align="center"><!-- TemplateBeginEditable name="sidebar1" -->
   <?php include ('front/inc/sidebar/stats/stats.php'); ?>
   </p>
<!--TemplateEndEditable --></div>
<div id="LayoutDiv4" class="content"><!-- TemplateBeginEditable name="content" -->
  <h1>Instructions</h1>
  <p>Notez que le code CSS de ces mises en forme contient une grande quantit&eacute; de commentaires. Si vous travaillez principalement en mode Cr&eacute;ation, jetez un coup d'&oelig;il au code afin d'obtenir des conseils sur l'utilisation du code CSS pour les mises en forme liquides. Vous pouvez supprimer ces commentaires avant de lancer votre site. Pour en savoir plus sur les techniques utilis&eacute;es dans ces mises en forme CSS, consultez l'article suivant sur le centre pour d&eacute;veloppeurs Adobe : <a href="http://www.adobe.com/go/adc_css_layouts">http://www.adobe.com/go/adc_css_layouts</a>.</p>
  <h2>Mise en page</h2>
  <p>Comme il s'agit d'une mise en page &agrave; une colonne, le .content n'est pas flottant. </p>
  <h3>Remplacement du logo</h3>
  <p>Dans la zone .header, un espace r&eacute;serv&eacute; pour image a &eacute;t&eacute; utilis&eacute; &agrave; l'endroit o&ugrave; vous souhaiterez probablement placer un logo. Il est conseill&eacute; de supprimer l'espace r&eacute;serv&eacute; et de le remplacer par votre logo li&eacute;. </p>
  <p> Notez que si vous utilisez l'inspecteur Propri&eacute;t&eacute;s pour acc&eacute;der &agrave; l'image de votre logo &agrave; l'aide de la zone SRC (au lieu de supprimer l'espace r&eacute;serv&eacute; puis de le remplacer), vous devez veiller &agrave; supprimer les propri&eacute;t&eacute;s int&eacute;gr&eacute;es d'arri&egrave;re-plan et d'affichage. Ces styles int&eacute;gr&eacute;s servent uniquement &agrave; permettre l'affichage de l'espace r&eacute;serv&eacute; du logo dans des navigateurs &agrave; des fins de d&eacute;monstration. </p>
  <p>Pour supprimer les styles int&eacute;gr&eacute;s, assurez-vous que le panneau Styles CSS est bien en mode Actuel. S&eacute;lectionnez l'image puis, dans le volet Propri&eacute;t&eacute;s du panneau Styles CSS, cliquez &agrave; l'aide du bouton droit puis supprimez les propri&eacute;t&eacute;s d'affichage et d'arri&egrave;re-plan. Bien entendu, vous pouvez toujours acc&eacute;der directement au code et y supprimer les styles int&eacute;gr&eacute;s depuis l'image ou l'espace r&eacute;serv&eacute;.</p>

<!-- TemplateEndEditable --></div>
<div id="LayoutDiv6" class="footer"><!-- TemplateBeginEditable name="footer" -->
  <?php include('front/inc/footer/footer_users.inc.php');?>
<!-- TemplateEndEditable --></div>
</div>
</body>
</html>
