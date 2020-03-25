<?php 
// protection de page ADMIN
    include_once('../Admin/fonctions/_protectpage.php');
// Parametres de Connexion a la BD
	include_once('../connexion.php');   
	
	// **************************************
// fonction de RESUME du "Contenu"
// ==> CHOISIR de la mise en forme du résumé (brut ou formaté)
// ==> l'un ou l'autre, mais pas les 2 !
// texte brut :
	//include_once('../Admin/fonctions/fct_resume_brut.php');
// (OU) texte formaté (html) :
	include_once('../Admin/fonctions/fct_resume_html.php');
	// ==> CHOISIR la Taille maxi du RESUME (en nombre de caractères)
	$resumeNbreCaracteres = 100;
// **************************************
		
	//include_once("../Model/class.notes.php");
	
	// pagination
$targetpage = "notes_full_list.php"; 	
	$limit = 5; 
	
	$query = "SELECT COUNT(*) AS num FROM notes WHERE IdDept = '".$_SESSION['IdDept']."'";
	$total_pages = mysql_fetch_array(mysql_query($query));
	$total_pages = $total_pages["num"];
	
	$stages = 3;
	
if (isset($_GET['page'])) {
	$page = $_GET['page']; // On recupere le numero de la page dans l'URL
} else { // si c'est la premiere fois qu'on charge la page
	$page = 1; // On se met sur la page 1 (par defaut)
}

	if($page){
		$start = ($page - 1) * $limit; 
	}else{
		$start = 0;	
		}	
	
	// Initial page num setup
	if ($page == 0){$page = 1;}
	$prev = $page - 1;	
	$next = $page + 1;							
	$lastpage = ceil($total_pages/$limit);		
	$LastPagem1 = $lastpage - 1;					
	
	
	$paginate = '';
	if($lastpage > 1)
	{	
		$paginate .= "<ul class='pagination centered'>";
		// Previous
		if ($page > 1){
			$paginate.= "<li><a href='$targetpage?page=$prev'>previous</a></Li>";
		}else{
			$paginate.= "<li class='unavailable'>previous</li>";	}
			

		
		// Pages	
		if ($lastpage < 7 + ($stages * 2))	// Not enough pages to breaking it up
		{	
			for ($counter = 1; $counter <= $lastpage; $counter++)
			{
				if ($counter == $page){
					$paginate.= "<li class='current'>$counter</li>";
				}else{
					$paginate.= "<li><a href='$targetpage?page=$counter'>$counter</a></li>";}					
			}
		}
		elseif($lastpage > 5 + ($stages * 2))	// Enough pages to hide a few?
		{
			// Beginning only hide later pages
			if($page < 1 + ($stages * 2))		
			{
				for ($counter = 1; $counter < 4 + ($stages * 2); $counter++)
				{
					if ($counter == $page){
						$paginate.= "<li class='current'>$counter</li>";
					}else{
						$paginate.= "<li><a href='$targetpage?page=$counter'>$counter</a></li>";}					
				}
				$paginate.= "...";
				$paginate.= "<a href='$targetpage?page=$LastPagem1'>$LastPagem1</a>";
				$paginate.= "<a href='$targetpage?page=$lastpage'>$lastpage</a>";		
			}
			// Middle hide some front and some back
			elseif($lastpage - ($stages * 2) > $page && $page > ($stages * 2))
			{
				$paginate.= "<li><a href='$targetpage?page=1'>1</a></li>";
				$paginate.= "<li><a href='$targetpage?page=2'>2</a></li>";
				$paginate.= "...";
				for ($counter = $page - $stages; $counter <= $page + $stages; $counter++)
				{
					if ($counter == $page){
						$paginate.= "<li class='current'>$counter</li>";
					}else{
						$paginate.= "<li><a href='$targetpage?page=$counter'>$counter</a></li>";}					
				}
				$paginate.= "...";
				$paginate.= "<li><a href='$targetpage?page=$LastPagem1'>$LastPagem1</a></li>";
				$paginate.= "<li><a href='$targetpage?page=$lastpage'>$lastpage</a></li>";		
			}
			// End only hide early pages
			else
			{
				$paginate.= "<li><a href='$targetpage?page=1'>1</a></li>";
				$paginate.= "<li><a href='$targetpage?page=2'>2</a></li>";
				$paginate.= "...";
				for ($counter = $lastpage - (2 + ($stages * 2)); $counter <= $lastpage; $counter++)
				{
					if ($counter == $page){
						$paginate.= "<li class='current'>$counter</li>";
					}else{
						$paginate.= "<li><a href='$targetpage?page=$counter'>$counter</a></li>";}					
				}
			}
		}
					
				// Next
		if ($page < $counter - 1){ 
			$paginate.= "<li><a href='$targetpage?page=$next'>next</a></li>";
		}else{
			$paginate.= "<li class='unavailable'>next</li>";
			}
			
		$paginate.= "</ul>";		
	
}

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
	<h1>DASHBOARD</h1>
<br/>
<!-- lien retour -->
<div style="text-align:center;">
<a <?php if (isset($_SESSION["IdAdmin"])){ ?>  href="../admin.php#nice7" <?php } elseif (isset($_SESSION["IdEmp"])){ ?>  href="../empl_site.php#simpleContained3" <?php } ?> >
	<div class="large button red" ><img src="../Admin/icones/arrow_back.png" alt="" /> Go back</div></a>	
</div>
<br/>

<div class="row">
	<div class="twelve columns">
		<div class="panel">
			<?php

//query: List of notesations
$notes_query = "SELECT * FROM notes WHERE IdDept = '".$_SESSION['IdDept']."' ORDER BY DateNt Desc LIMIT $start, $limit";
$notes_result = mysql_query($notes_query) or die('Erreur SQL :<br />'.$notes_query.'<br />'.mysql_error());
$notes_nombre = mysql_num_rows($notes_result);

if($notes_nombre > 0) {
?>
<h4><?php echo $total_pages; ?> note<?php if($total_pages > 1) { echo 's'; } ?></h4>
<?php
// loop for listing
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
	//$notesContenu = 	str_replace('../'.$EditeurWysiwyg,$EditeurWysiwyg,$notesContenu);
	// Résumé du Contenu
	$notesContenuResume = texte_resume($notesContent, $resumeNbreCaracteres);
	
	
?>
	<table style="border:none;">
		<tr style="border-bottom:thin #666666 solid;">
			<th style="text-align:left;"><?php echo $notesTitle; ?></th>
			<th style="text-align:right;">Posted on <?php echo date('M d, Y @ h:i A', $notesDate); ?></th>
		</tr>
		<tr>
			<td colspan="2">
<?php	if ($notesPhoto != ''){ ?>
			<img src="<?php echo $DossierNewsPhoto.$notesPhoto; ?>" <?php echo $tailleNewsPicto; ?> alt="" class="imageG" />
<?php	} ?>
			<?php echo $notesContenuResume; ?>
			... <a href="thenote.php?id=<?php echo $notesID; ?>">[Read more]</a>
			</td>
		</tr>
	</table>
	<br/>
<?php
	} //End while
	} // end if
	else { // no note
?>
 <div id="light" align="center">No note for now.</div><br/>
<?php
		} //End else
	

?><br/>
<p align="center"><?php echo $paginate;?></p>
<br/>
		</div> <!--End panel-->
	</div><!-- End 12 columns-->
</div><!--End row-->

		<br/>
<!-- lien retour -->
<div style="text-align:center;">
<a <?php if (isset($_SESSION["IdAdmin"])){ ?>  href="../admin.php#nice7" <?php } elseif (isset($_SESSION["IdEmp"])){ ?>  href="../empl_site.php#simpleContained3" <?php } ?> >
	<div class="large button red" ><img src="../Admin/icones/arrow_back.png" alt="" /> Go back</div>
</a>	
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