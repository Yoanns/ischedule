<?php
// ***************************************************************
// NEWS - FICHE DETAILLEE
// ***************************************************************
// protection de page ADMIN
    include_once('../Admin/fonctions/_protectpage.php');

// Parametres de Connexion a la BD
	include_once('../connexion.php');
// -------------------------
// Parametres de Configuration Generale de la NEWS
	include_once('../Admin/fonctions/config.php');
// **************************************
// On recupere l URL de la page d'origine
	$nomPageOrigine = $_SERVER["HTTP_REFERER"];
// -------------------------
if (isset($_GET['id']) && $_GET['id']!='')
{
	// On recupere l id dans l'URL
	$notesID = 		mysql_real_escape_string($_GET['id']);
} 
elseif (isset($_POST['notesID']) && $_POST['notesID']!='')
{
	// On recupere l id dans l'URL
	$notesID = 		mysql_real_escape_string($_POST['notesID']);
}
else {
	// sinon recuperation de id de LA DERNIERE fiche cree
	$result_maxid = mysql_query("SELECT MAX(IdNt) AS idmax FROM notes");
	$val_maxid = 	mysql_fetch_array($result_maxid);
	$notesID = 		$val_maxid['idmax'];
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

	<title>Shift-Scheduler.com | Dashboard</title>
	<link rel="shortcut icon" type="image/x-icon" href="../Admin/icones/ischedule_logo1.ico">
  
	<!-- Included CSS Files -->
	<link rel="stylesheet" href="../css/foundation.css">
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

</head>

<body>
<div id="containercentrer">
<h1>NOTE</h1>
<br />

<div class="row">
	<div class="twelve columns">
		<div class="panel">
<?php
// -------------------------
// Affichage des Notes
// -------------------------
// On recupere les infos dans la BD
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
			<th style="text-align:left;"><?php echo $notesTitle; ?></th>
			<th style="text-align:right;">Posted on <?php echo date('M d, Y @ h:i A', $notesDate); ?></th>
		</tr>
		<tr>
			<td colspan="2">
<?php	if ($notesPhoto != ''){ ?>
			<img src="<?php echo $DossierNewsPhotoCourt.$notesPhoto; ?>" alt="" class="imageG" />
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
				<a href="<?php echo $DossierNewsFichierCourt.$notesFiche; ?>" onClick="javascript:window.open(this.href); return false;">
				<img src="../Admin/icones/<?php if (strtolower(substr($notesFiche, -3))=='doc') echo "file_extension_doc";
												elseif (strtolower(substr($notesFiche, -3))=='pdf') echo "file_extension_pdf";
												elseif (strtolower(substr($notesFiche, -3))=='xls') echo "file_extension_xls";?>.png" alt="" title="<?php echo $notesFiche; ?>" />
				Download the attached file</a>
				</span>
				<?php }  ?>
			</td>
		</tr>
	</table>
			
			
<?php
} // (fin du while)
	mysql_free_result($notes_result);
?>
<br />
		</div>
	</div>
</div>
<br/>
<!-- lien retour -->
<div style="text-align:center;">
<a href="notes_full_list.php"><div class="large button red" ><img src="../Admin/icones/arrow_back.png" alt="" /> Go back</div></a>	
</div>
<br/>

</div><!-- End containercentrer-->

<div id="footer"> <?php include("../footer.php");?></div>

	<!-- Included JS Files -->
	<script src="../js/jquery.min.js"></script>
	<script src="../js/foundation.js"></script>
	<script src="../js/app.js"></script>


</body>
</html>