<?php
// ***************************************************************
// protection de page ADMIN
   include_once('./Admin/fonctions/_protectpageadm.php');
// **************************************
// Parametres de Connexion a la BD
	include_once('connexion.php');
// **************************************
	include_once('Model/class.address.php');
	include_once('Model/class.location.php');
	
		
/*-------------------------------------------------*/

$traiter = '';
if (isset($_POST['traiter']) && ($_POST['traiter']=='ADD' || $_POST['traiter']=='EDIT' || $_POST['traiter']=='DELETE' )){
	$traiter = $_POST['traiter'];
}  

else {
	// sinon retour a la liste
	header('location: ./admin_spr.php#nice5');
	exit;
} 
		
// -------------------------
// Treatment : ADD
// -------------------------
if ($traiter == 'ADD')
{
		
	// Get information from form 			
	$NameLoc	=	mysql_real_escape_string($_POST['NameLoc']);
	
	$Street		=	mysql_real_escape_string($_POST['Street']);
	$City		=	mysql_real_escape_string($_POST['City']);
	$State		=	mysql_real_escape_string($_POST['State']);
	$ZipCode	=	mysql_real_escape_string($_POST['Zip']);
	
	// on cree une nouvelle entree dans la table
	$address = new address(null);
	$address ->  Add($Street,$City,$State,$ZipCode);
	
	// recuperation de d id en selectionnant LA DERNIERE fiche cree
	$result_maxid = mysql_query("SELECT MAX(IdAddr) AS idmax FROM address;");
	$val_maxid = 	mysql_fetch_array($result_maxid);
	$IdAddr = 		$val_maxid['idmax'];
	
	$location = new location(null);
	$location -> AddLoc($NameLoc,$IdAddr);
	
	
	
}
// -------------------------
// Traitement : EDIT
// -------------------------
elseif ($traiter == 'EDIT')
{
	// Get information from form 			
	$IdLoc	=	mysql_real_escape_string($_POST['IdLoc']);
	$NameLoc	=	mysql_real_escape_string($_POST['NameLoc']);
	
	$Street		=	mysql_real_escape_string($_POST['Street']);
	$City		=	mysql_real_escape_string($_POST['City']);
	$State		=	mysql_real_escape_string($_POST['State']);
	$ZipCode	=	mysql_real_escape_string($_POST['Zip']);
	
	$location = new location($IdLoc);
	$IdAddr		=	$location -> IdAddr;
	$location -> EditLoc($NameLoc,$IdAddr);
	
	$address = new address($IdAddr);
	$address ->  Edit($Street,$City,$State,$ZipCode);
		
	// ----------------------

}
// -------------------------
// Traitement : DELETE
// -------------------------
elseif ($traiter == 'DELETE')
{
	$IdLoc		=	mysql_real_escape_string($_POST['IdLoc']);
	// suppression dans la BD
	$location = new location($IdLoc);
	$IdAddr = $location -> IdAddr;	
	$address = new address($IdAddr);
	
	$location -> DeleteLoc($IdLoc);
	$address ->  Delete($IdAddr);	
	
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
<title>Shift-Scheduler | <?php echo $traiter; ?> a location</title>
	<link rel="shortcut icon" type="image/x-icon" href="./Admin/icones/ischedule_logo1.ico">
	
<!-- Included CSS Files -->
	<link rel="stylesheet" media="screen" type="text/css" href="css/foundation.css">
	<link rel="stylesheet" media="screen" type="text/css" href="./css/app.css">
	<link rel="stylesheet" media="screen" type="text/css" href="Admin/css_adm/news_ADM_style.css" />

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

<h1>LOCATIONS MANAGEMENT</h1><br/>


<?php
// -------------------------

// re-affichage
if ($traiter == 'ADD' )
{
	// recuperation de d id en selectionnant LA DERNIERE fiche cree
	$maxidLoc = mysql_query("SELECT MAX(IdLoc) AS idmax FROM location;");
	$maxidVal = mysql_fetch_array($maxidLoc);
	$IdLoc = 	$maxidVal['idmax'];
	
	$location = new location($IdLoc);
	$NameLoc	=	$location -> NameLoc;
	$IdAddr		=	$location -> IdAddr;
	
	$address = new address($IdAddr);
	$Street = $address -> Street;
	$City = $address -> City;
	$State = $address -> State;
	$ZipCode = $address -> ZipCode;
	
	
?>
<div class="container">
		<div class="alert-box centered success">
			Addition successful.
			<a href="" class="close">&times;</a>
		</div>
</div>

<br/>

	<div class="panel">
<div class="row">

<div class="twelve columns">
<fieldset>
	<h4  style="text-align:center;">Location summary</h4>
			<p class="space">
				<label class="label15"  style="text-align:right; color:#21409A;">Name: </label><?php echo $NameLoc; ?>
			</p>
			<div class="clearfix"></div>
		
		<p class="space">
				<label class="label15"  style="text-align:right; color:#21409A;">Address: </label>
				<p style="margin-left:50px;"><?php echo $Street; ?><br/><?php echo $City.", ".$State." ".$ZipCode; ?></p>
			</p>
			<div class="clearfix"></div>
					
	</fieldset>
		</div> <!--End 12 cols-->
	
	</div> <!--End rows-->
</div> <!--End panel-->
<?php
}

if ($traiter == 'EDIT')
{
	$IdLoc	=	mysql_real_escape_string($_POST['IdLoc']);
	$location = new location($IdLoc);
	$NameLoc	=	$location -> NameLoc;
	$IdAddr		=	$location -> IdAddr;
	
	$address = new address($IdAddr);
	$Street = $address -> Street;
	$City = $address -> City;
	$State = $address -> State;
	$ZipCode = $address -> ZipCode;
	
	
?>
<div class="container">
	<div class="alert-box centered success">
		Edition successful.
		<a href="" class="close">&times;</a>
	</div>
</div>

<br/>

	<div class="panel">
<div class="row">

<div class="twelve columns">
<fieldset>
	<h4  style="text-align:center;">Location summary</h4>
			<p class="space">
				<label class="label15"  style="text-align:right; color:#21409A;">Name: </label><?php echo $NameLoc; ?>
			</p>
			<div class="clearfix"></div>
		
		<p class="space">
				<label class="label15"  style="text-align:right; color:#21409A;">Address: </label>
				<p style="margin-left:50px;"><?php echo $Street; ?><br/><?php echo $City.", ".$State." ".$ZipCode; ?></p>
			</p>
			<div class="clearfix"></div>
					
	</fieldset>
		</div> <!--End 12 cols-->
	
	</div> <!--End rows-->
</div> <!--End panel-->
<?php
}
		
// -------------------------
if ($traiter == 'DELETE') { ?>
	<div id="container">	
		<div class="alert-box centered success ">
	Deletion successful.
	<a href="" class="close">&times;</a>
		</div>
	</div>
<?php
	}
	?>	

<div class="clearfix"></div>
<!-- lien retour -->
<div style="text-align:center;">
<a href="./admin_spr.php#nice5"><div class="large button red" ><img src="./Admin/icones/arrow_back.png" alt="" /> Go back</div></a>	
</div>
<br/>

</div> <!--End containercentrer-->


<div id="footer"> <?php include("footer.php");?></div>


	<!-- Included JS Files -->
	<script src="js/jquery.min.js"></script>
	<script src="js/foundation.js"></script>
	<script src="js/app.js"></script>

</body>
</html>