<?php
// ***************************************************************
// NEWS : TRAITEMENT des donnees (Titrenotes, Contenunotes)
// ***************************************************************
// protection de page ADMIN
   include_once('./Admin/fonctions/_protectpage.php');
// **************************************
// Parametres de Connexion a la BD
	include_once('connexion.php');
// **************************************
// Parametres de CONFIGURATION de la NEWS
	include_once('./Admin/fonctions/config.php');
// **************************************
// Fonctions de traitement d image
	include_once('./Admin/fonctions/fct_traitement_image.php');
// **************************************
$traiter = '';
if (isset($_POST['traiter']) && ($_POST['traiter']!='ADD' || $_POST['traiter']!='EDIT' || $_POST['traiter']!='DELETE')){
	$traiter = $_POST['traiter'];
} else {
	// sinon retour a la liste
	header('location: ./admin.php#nice7');
	exit;
}
// -------------------------
// Traitement : ADD
// -------------------------
if ($traiter == 'ADD')
{
	$notesTitle 	= 	mysql_real_escape_string($_POST['notesTitle']);
	$notesContent 	= 	mysql_real_escape_string($_POST['notesContent']);
	$IdDept			=	mysql_real_escape_string($_POST['IdDept']);
	$PhotoAvant		=	mysql_real_escape_string($_POST['PhotoAvant']);
	$FicheAvant		=	mysql_real_escape_string($_POST['FicheAvant']);
	// on cree une nouvelle entree dans la table
	// note : on met la date du jour avec : time()
	$query_insert = 	"INSERT INTO notes".
						" (TitleNt, ContentNt, DateNt, IdDept) ".
						" VALUES('".$notesTitle."','".$notesContent."','".time()."','".$IdDept."')";
	mysql_query($query_insert) or die('Error SQL :<br />'.$query_insert.'<br />'.mysql_error());
	// ----------------------
	// traitement photo ?
	// recuperation de d id en selectionnant LA DERNIERE fiche cree
	$result_maxid = 	mysql_query("SELECT MAX(IdNt) AS idmax FROM notes");
	$val_maxid = 		mysql_fetch_array($result_maxid);
	$notesID = 			$val_maxid['idmax'];
	// ----------------------
	// traitement photo ?
	include('./Admin/fonctions/notes_photo.php');
	// ----------------------
	// traitement fichier ?
	include('./Admin/fonctions/file.php');
}
// -------------------------
// Traitement : EDIT
// -------------------------
elseif ($traiter == 'EDIT')
{
	$notesID 		= 	mysql_real_escape_string($_POST['notesID']);
	$notesTitle 	= 	mysql_real_escape_string($_POST['notesTitle']);
	$notesContent 	= 	mysql_real_escape_string($_POST['notesContent']);
	$IdDept			=	mysql_real_escape_string($_POST['IdDept']);
	$PhotoAvant		=	mysql_real_escape_string($_POST['PhotoAvant']);
	$FicheAvant		=	mysql_real_escape_string($_POST['FicheAvant']);
	// modification : on met a jour la notes
	// (note : on ne change pas la date)
	$query_update = 	"UPDATE notes SET ".
						" TitleNt='".$notesTitle."',ContentNt='".$notesContent."' WHERE IdNt='".$notesID."'";
	mysql_query($query_update) or die('Error SQL :<br />'.$query_update.'<br />'.mysql_error());
	// ----------------------
	// traitement photo ?
	include('./Admin/fonctions/notes_photo.php');
	// ----------------------
	// traitement fichier ?
	include('./Admin/fonctions/file.php');
}
// -------------------------
// Traitement : DELETE
// -------------------------
elseif ($traiter == 'DELETE')
{
	$notesID = 			mysql_real_escape_string($_POST['notesID']);
	// suppression dans la BD
	$query_delete = 	"DELETE FROM notes WHERE IdNt='".$notesID."'";
    mysql_query($query_delete) or die('Error SQL :<br />'.$query_delete.'<br />'.mysql_error());
    // Suppression de la PHOTO du dossier
    if ($_POST['PhotoAvant'] != '')
	{ unlink($DossierNewsPhotoCourt.$_POST['PhotoAvant']); }
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
	<link rel="shortcut icon" type="image/x-icon" href="./Admin/icones/ischedule_logo1.ico">
<!-- Included CSS Files -->
	<link rel="stylesheet" href="./css/foundation.css">
	<link rel="stylesheet" href="./css/app.css">
	<link rel="stylesheet" media="screen" type="text/css" href="./Admin/css_adm/news_ADM_style.css" />

	<!--[if lt IE 9]>
		<link rel="stylesheet" href="./css/ie.css">
	<![endif]-->
	
	<script src="./js/modernizr.foundation.js"></script>

	<!-- IE Fix for HTML5 Tags -->
	<!--[if lt IE 9]>
		<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
</head>

<body>
<div id="containercentrer">


<h1>ADMINISTRATION OF NOTES</h1>
<h2><?php echo $traiter; ?> A NOTE</h2>
<?php
// -------------------------
// erreur d upload photo ?
if (@$msgErreurPhoto != '')
{
	echo '<span class="important">'.$msgErreurPhoto.'</span><br />';
}
// -------------------------
// erreur d upload fichier ?
if (@$msgErreurFiche != '')
{
	echo '<span class="important">'.$msgErreurFiche.'</span><br />';
}
// -------------------------
// re-affichage
if ($traiter == 'ADD' || $traiter == 'EDIT')
{
	$notes_query = 	"SELECT * FROM notes WHERE IdNt = '".$notesID."'; ";
	$notes_result = 	mysql_query($notes_query);
while ($notes_row = mysql_fetch_array($notes_result))
{
	$notesID = 		$notes_row['IdNt'];
	$notesTitle = 	stripslashes($notes_row['TitleNt']);
	$notesContent = 	stripslashes($notes_row['ContentNt']);
	$notesDate = 	$notes_row['DateNt'];
	$notesPhoto = 	$notes_row['PhotoNt'];
	$notesFiche = 	$notes_row['FileNt'];
	// Editeur WYSIWYG : on doit indiquer correctement le chemin vers le dossier
	// (pour affichage correct des "smyleys", par exemple)
	$notesContent = 		str_replace('../'.$EditeurWysiwyg,$EditeurWysiwyg,$notesContent);
?>
	 <table style="border:none;">
		<tr style="border-bottom:thin #666666 solid;">
			<th width="70%" style="text-align:left;"><?php echo $notesTitle; ?></th>
			<th width="30%" style="text-align:right;">Posted on <?php echo date('M d, Y @ h:i A', $notesDate); ?></th>
		</tr>
		<tr>
			<td colspan="2">
<?php	if ($notesPhoto != ''){ ?>
			<img src="<?php echo $DossierNewsPhoto.$notesPhoto; ?>" alt="" class="imageG" />
<?php	} ?>
			<?php echo $notesContent; ?>
			</td>
		</tr>
		<tr>
			<td colspan="2">
				<!-- fiche PDF -->
	<?php	
			if($notesFiche != '') { ?>
				<span>
				<a href="<?php echo $DossierNewsFichier.$notesFiche; ?>" onClick="javascript:window.open(this.href); return false;">
				<img src="Admin/icones/PDF.png" alt="<?php echo $notesFiche; ?>" title="<?php echo $notesFiche; ?>" />
				Download the attached file</a>
				</span>
				<?php }  ?>
			</td>
		</tr>
	</table>
			<br/>
<?php
	} // Fin de la boucle
}
// -------------------------
if ($traiter == 'DELETE') { ?>
	<!--<div id="container">-->	
		<div class="alert-box centered success ">
	The note has been deleted.
	<a href="" class="close">&times;</a>
		</div>
	<!--</div>-->
<?php } ?>


<!-- lien retour -->
<div style="text-align:center;">
<a href="./admin.php#nice7"><div class="large button red" ><img src="./Admin/icones/arrow_back.png" alt="" /> Go back</div></a>
</div>
<br/>

</div><!-- End containercentrer-->
<div id="footer"> <?php include("footer.php");?></div>


	<!-- Included JS Files -->
	<script src="js/jquery.min.js"></script>
	<script src="js/foundation.js"></script>
	<script src="js/app.js"></script>

</body>
</html>