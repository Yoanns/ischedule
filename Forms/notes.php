<?php
// ***************************************************************
// ADMIN NEWS : FORMULAIRE "ajouter"/"modifier"/"supprimer"
// Editeur WYSIWYG : ckeditor
// ***************************************************************
// protection de page ADMIN
   include_once('../Admin/fonctions/_protectpage.php');
// **************************************
// Parametres de Connexion a la BD
	include_once('../connexion.php');
// **************************************
// Parametres de CONFIGURATION de la NEWS
	include_once('../Admin/fonctions/config.php');
// **************************************
// Fonctions de traitement d image
	include_once('../Admin/fonctions/fct_traitement_image.php');
// **************************************
// Editeur WYSIWYG utilise : FCKeditor
	include_once('../utilities/ckeditor/ckeditor.php') ;
// **************************************
$traiter = '';
if (isset($_POST['traiter']) && ($_POST['traiter']!='ADD' || $_POST['traiter']!='EDIT' )){
	$traiter = $_POST['traiter'];
} else {
	// sinon retour a la liste
	header('location: ./admin.php#nice7');
	exit;
}
// -------------------------
// ADD une News
// -------------------------
if ($traiter == 'ADD')
{
	$notesID = 			0;
	$notesTitle = 		'';
    $notesContent = 		'';
    $PhotoAvant = 		'';
    $fichierAvant =		'';
	$IdDept = $_SESSION["IdDept"];
}
// -------------------------
// EDIT une News
// -------------------------
elseif ($traiter == 'EDIT')
{
	$notesID = 			mysql_real_escape_string($_POST['notesID']);
	// recuperation des infos correspondantes
	$query_modif 	= 	"SELECT * FROM notes WHERE IdNt='".$notesID."'";
	$result_modif	= 	mysql_query($query_modif) or die('Erreur SQL :<br />'.$query_modif.'<br />'.mysql_error());
    $row_modif 		= 	mysql_fetch_array($result_modif);
    $notesTitle 	= 	stripslashes($row_modif['TitleNt']);
    $notesContent 	= 	stripslashes($row_modif['ContentNt']);
    $PhotoAvant 	= 	$row_modif['PhotoNt'];
    $fichierAvant 	=	$row_modif['FileNt'];
	$IdDept 		= 	$_SESSION["IdDept"];
}

// -------------------------
?>

<!DOCTYPE html>

<!-- paulirish.com/2008/conditional-stylesheets-vs-css-hacks-answer-neither/ -->
<!--[if lt IE 7]> <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js lt-ie9 lt-ie8" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
<head>
	<meta charset="utf-8" />

	<!-- Set the viewport width to device width for mobile -->
	<meta name="viewport" content="width=device-width" />
	<meta name="author" content="Yoann SENIN - yoanns[at]gmail.com" />
	<meta name="robots" content="noindex,nofollow" />

	<title>Shift-Scheduler.com | <?php echo $traiter; ?> A NOTE</title>
	<link rel="shortcut icon" type="image/x-icon" href="../Admin/icones/ischedule_logo1.ico">
  
	<!-- Included CSS Files -->
	<link rel="stylesheet" href="../css/foundation_style.css">
	<link rel="stylesheet" href="../css/app.css">
	<link rel="stylesheet" media="screen" type="text/css" href="../Admin/css_adm/news_ADM_style.css" />

	<!--[if lt IE 9]>
		<link rel="stylesheet" href="../css/ie.css">
	<![endif]-->
	
	<script src="../js/modernizr.foundation.js"></script>

	<!-- IE Fix for HTML5 Tags -->
	<!--[if lt IE 9]>
		<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->


<!-- Editeur WYSIWYG : ckeditor -->
<script type="text/javascript" src="../utilities/ckeditor/ckeditor.js"></script>
<script type="text/javascript" src="../utilities/ckeditor/plugins/dialog/dialogDefinition.js"></script>

<!-- scripts - fin -->

</head>
<body>
<div id="containercentrer">

<h1>ADMINISTRATION OF NOTES</h1>
<h2><?php echo $traiter; ?> A NOTE</h2>

<div class="row">
	<div class="twelve columns">
		<div class="panel">
<!-- formulaire -->
<form id="monForm" method="post" enctype="multipart/form-data" action="../notes_treatment.php" >
<fieldset>
<input type="hidden" name="traiter" value="<?php echo $traiter; ?>" />
<input type="hidden" name="notesID" value="<?php echo $notesID; ?>" />
<input type="hidden" name="IdDept" value="<?php echo $IdDept; ?>" />
<input type="hidden" name="PhotoAvant" value="<?php echo $PhotoAvant; ?>" />
<input type="hidden" name="FicheAvant" value="<?php echo $FicheAvant; ?>" />

<div class="seven columns">
	<h4>NOTE</h4>
	<p>
	<!-- titre -->
	<label for="idnotesTitle">Title : </label>
	<input type="text" id="idnotesTitle" name="notesTitle" size="80" value="<?php echo $notesTitle; ?>" required />
	</p>
	<p><!-- contenu :  Editeur WYSIWYG fckeditor -->
    <label for="idarticleContenu">Content :</label> <br/>
	<textarea class="champobligatoire" id="idnotesContent" name="notesContent"><?php echo $notesContent; ?></textarea>
	<script type="text/javascript">
				CKEDITOR.replace( 'notesContent');
			</script>
	</p>
</div>
<div class="four columns">
<?php
// -------------------------
if ($traiter == 'ADD' || $traiter == 'EDIT')
{
?>
	<!-- photo -->
	<h4>Attach a picture</h4>
	<p>
<?php	if ($PhotoAvant != ''){ ?>
		<img <?php echo fctaffichimage($DossierNewsPhotoCourt.$PhotoAvant, 150, 150); ?> alt="<?php echo $PhotoAvant; ?>" title="<?php echo $PhotoAvant; ?>" /><br />
    	<label for="idPHOTOdelete">delete? </label>
    	<input type="checkbox" id="idPHOTOdelete" name="PHOTOdelete" value="ON"><br />
<?php	} ?>
    <label for="PHOTO">Add/edit a picture : </label> (<?php echo $ImageExtOK; ?>)<br />
    <input type="file" id="PHOTO" name="PHOTO" size="20"><br />
    <label for="idphotolargeur">width (display) : </label>
	<select size="1" id="idphotolargeur" name="photolargeur">
		<option value="100">picto : 100px</option>
		<option value="200">mini : 200px</option>
		<option value="300" selected="selected">normal : 300px</option>
		<option value="450">medium : 450px</option>
		<option value="600">large : 600px</option>
	</select>
	</p>
	<hr />
	<!-- Fichier -->
	<h4>Attach a file</h4>
	<p>
<?php	if ($fichierAvant != ''){ ?>
		<a href="<?php echo $DossierNewsFichierCourt.$fichierAvant; ?>" onclick="javascript:window.open(this.href); return false;">
		<img src="<?php echo $DossierIcones; ?>PDF.png" alt="<?php echo $fichierAvant; ?>" /></a>
		<label for="idFicheDelete">delete?  </label>
		<input type="checkbox" id="idFicheDelete" name="FicheDelete" value="ON"><br />
<?php	} ?>
	<label for="idfiche">Add/edit a file :</label> (<?php echo $FichierExtOK; ?>)<br />
	<input type="file" id="idfiche" name="fiche" size="20">
	</p>
	<hr />
<?php
}
// -------------------------
elseif ($traiter == 'DELETE' && $PhotoAvant != '')
{
?>
<?php	if ($PhotoAvant != ''){ ?>
	<hr />
	<p>
	<!-- Photo -->
	<h4>PHOTO</h4>
		<img <?php echo fctaffichimage($DossierNewsPhotoCourt.$PhotoAvant, 150, 150); ?> alt="<?php echo $PhotoAvant; ?>" title="<?php echo $PhotoAvant; ?>" /><br />
		(the photo will be deleted)<br />
	</p>
<?php	} ?>
<?php	if ($fichierAvant != ''){ ?>
	<hr />
	<!-- Fichier -->
	<h4>FICHIER</h4>
	<p>
		<a href="<?php echo $DossierNewsFichierCourt.$fichierAvant; ?>" onclick="javascript:window.open(this.href); return false;">
		<img src="<?php echo $DossierIcones; ?>PDF.png" alt="<?php echo $fichierAvant; ?>" /></a><br />
		(the file will be deleted)<br />
	<hr />
	</p>
<?php	} ?>
<?php
} 
?>
<div class="row">
	<div class="six columns">
		<div style="text-align:center;">
			<button name="bt<?php echo $traiter; ?>" type="submit" class="large green button">
			<!--<img src="../Admin/icones/note_add.png" alt="" width="24" />--><span><?php echo $traiter; ?> NOTE</span></button>
		</div>
	</div>
			
	<div class="six columns">
		<div style="text-align:center;">
			<a href="../admin.php#nice7"><div class="large red button"><!--<img src="../Admin/icones/ANNULER.png" alt="" />--><span>CANCEL</span></div></a> 
		</div>
	</div>	
</div>
			</fieldset>
		</form><br />
		</div>
	</div>
</div>

</div><!-- End containercentrer-->

<div id="footer"> <?php include("../footer.php");?></div>

	<!-- Included JS Files -->
	<script src="../js/jquery.min.js"></script>
	<script src="../js/foundation.js"></script>
	<script src="../js/app.js"></script>


</body>
</html>