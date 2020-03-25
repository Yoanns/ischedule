<?php
// ***************************************************************
// NEWS : TRAITEMENT des donnees (Titrenews, Contenunews)
// ***************************************************************
// protection de page ADMIN
   include_once('./Admin/fonctions/_protectpageadm.php');
// **************************************
// Parametres de Connexion a la BD
	include_once('connexion.php');
// **************************************

$traiter = '';
if (isset($_POST['traiter']) && ($_POST['traiter']=='ADD' || $_POST['traiter']=='DELETE')){
	$traiter = $_POST['traiter'];
} else {
	// sinon retour a la liste
	header('location: ./admin_spr.php#nice3');
	exit;
}
		
// -------------------------
// Treatment : ADD
// -------------------------
if ($traiter == 'ADD')
{		
	// Get information from form employee			
	$persID   = 	$_POST['persID'];
	 if(empty($persID))
	 	{ ?>
		<!-- Included CSS Files -->
	<link rel="stylesheet" href="./css/foundation.css">
	<link rel="stylesheet" href="./css/app.css">
	<link rel="stylesheet" media="screen" type="text/css" href="./Admin/css_adm/news_ADM_style.css" />

    		<div class="alert-box warning " style="text-align:center;">
	You have not selected any employee.
	<a href="" class="close">&times;</a>
</div>
<div align="center">
<a href="admin_spr.php#nice3" class="red button" style="text-align:center;"><img src="./Admin/icones/arrow_back.png" alt="" />Go back to list</a>
</div>
  		<?php
		}
 	 else
  		{
   			$N = count($persID);
    		for($i=0; $i < $N; $i++)
    			{
					// on cree une nouvelle entree dans la table
					$query_insert = "INSERT INTO ADMIN (IdPers) VALUES(".$persID[$i].")";
					mysql_query($query_insert) or die('Erreur SQL :<br />'.$query_insert.'<br />'.mysql_error());
    			}
 		}	
	
	// ----------------------
}

// -------------------------
// Traitement : DELETE
// -------------------------
elseif ($traiter == 'DELETE')
{
	$persID = 			mysql_real_escape_string($_POST['persID']);
	// suppression dans la BD
	$query_delete = 	"DELETE FROM ADMIN WHERE IdPers='".$persID."';";
    mysql_query($query_delete) or die('Erreur SQL :<br />'.$query_delete.'<br />'.mysql_error());
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
	<title>Shift-Scheduler.com | <?php echo $traiter; ?> A MANAGER</title>
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

<h1>ADMINISTRATION OF MANAGERS</h1>
<h2><?php echo $traiter; ?> A MANAGER</h2>


<?php
// -------------------------

// re-affichage
if ($traiter == 'ADD' )
{

?>
<div class="row">
<div class="alert-box success" style="text-align:center">
	Addition successful.
	<a href="" class="close">&times;</a>
</div>
</div>

<?php
}

		
// -------------------------
if ($traiter == 'DELETE') { ?>
		<div class="alert-box success " style="text-align:center">
	The manager has been deleted.
	<a href="" class="close">&times;</a>
</div>


<?php } ?>

<!-- lien retour -->
	<div class="twelve columns centered" align="center">
<a href="./admin_spr.php#nice3"><div class="large button red" ><img src="./Admin/icones/arrow_back.png" alt="" /> Go back</div></a>
</div>


</div>

<div id="footer"> <?php include("footer.php");?></div>


	<!-- Included JS Files -->
	<script src="js/jquery.min.js"></script>
	<script src="js/foundation.js"></script>
	<script src="js/app.js"></script>

</body>
</html>