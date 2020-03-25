<?php
// protection de page ADMIN
   include_once('../Admin/fonctions/_protectpageadm.php');
// **************************************
// Parametres de Connexion a la BD
	include_once('../connexion.php');
			

$traiter = '';
if (isset($_POST['traiter']) && ($_POST['traiter']=='ADD')){
	$traiter = $_POST['traiter'];
} else {
	// sinon retour a la liste
	header('location: ../admin_spr.php#nice3');
	exit;
}
// -------------------------
// ADD an employee
// -------------------------
if ($traiter == 'ADD')
{
	// recuperation des infos correspondantes
	$query_add = 	"SELECT IdPers, LastName, FirstName FROM person 
					WHERE IdPers NOT IN (SELECT IdPers FROM admin)
					AND IdPers NOT IN (SELECT IdPers FROM admin_spr)
					ORDER BY LastName";
	$result_add = 	mysql_query($query_add) or die('Erreur SQL :<br />'.$query_add.'<br />'.mysql_error());
    $nb_add = mysql_num_rows($result_add);
	
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
	<title>Shift-Scheduler.com | <?php echo $traiter; ?> A MANAGER</title>
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
	

    <link href="../css/main.css" rel="stylesheet" media="screen" type="text/css" />
    
	
</head>

<body>
<div id="containercentrer">
<br/>
<h1><?php echo $traiter; ?> A MANAGER </h1>
<br/>
<div class="row">
			<div class="twelve centered columns">
			<div class="panel">
<!-- formulaire -->
<form id="ManagerForm" method="post" enctype="multipart/form-data" action="../adm_treatment.php">
<input type="hidden" name="traiter" value="ADD" />
	<ul class="block-grid mobile four-up">
<?php
if ($nb_add > 0)
	{
		while ( $row_add = 		mysql_fetch_array($result_add))
			{ 				
    			$persID 	=	$row_add['IdPers'];
				$FirstName	= 	stripslashes($row_add['FirstName']);
				$LastName	= 	stripslashes($row_add['LastName']);
	?>
					<li><input type="checkbox" value="<?php echo $persID ;?>" id="persID" name="persID[]"/><?php echo $LastName.", ".$FirstName ;?> </li>
		<?php
			}
			?>
				</ul>
				<div class="row">
                                <button name="addManager" type="submit" value="<?php echo $traiter; ?>" class="medium button green">
									<img src="../Admin/icones/ADD.png" alt="" />Add manager</button>	
								
					<br/>
				</div>
		<?php
	}
	else echo '<div id="light" align="center">Nobody else is available to be a manager.</div>';
		?>
		
</form><br/>
</div> <!--End panel-->
</div><!-- End 12 columns-->
</div>	<!--End row-->	

<div class="row">
	<div class="twelve columns centered" align="center">
		<a href="../admin_spr.php#nice3" title="Go back"><div class="large button red" ><img src="../Admin/icones/arrow_back.png" alt="" /> Go back</div></a>	
	</div>
</div>

						<br/>
</div>	

<div id="footer"> <?php include("../footer.php");?></div>


	<!-- Included JS Files -->
	<script src="../js/jquery.min.js"></script>
	<script src="../js/foundation.js"></script>
	<script src="../js/app.js"></script>


</body>
</html>
