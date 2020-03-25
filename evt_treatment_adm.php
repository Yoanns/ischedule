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
	include_once('Model/class.event.php');
	include_once('Model/class.location.php');
	include_once('Admin/fonctions/functions.php');


$traiter = '';
if (isset($_POST['traiter']) && ($_POST['traiter']=='ADD' || $_POST['traiter']=='EDIT' || $_POST['traiter']=='DELETE')){
	$traiter = $_POST['traiter'];
} else {
	// sinon retour a la liste
	header('location: ./admin_spr.php#nice1');
	exit;
}
		
// -------------------------
// Treatment : ADD
// -------------------------
if ($traiter == 'ADD')
{
		
	// Get information from form employee			
	$DayEvt    	=	mysql_real_escape_string($_POST['DayEvt']);
	$NameEvt	= 	mysql_real_escape_string($_POST['NameEvt']);
	$GuestEvt	= 	mysql_real_escape_string($_POST['NbGuest']);
    $BegEvt		= 	mysql_real_escape_string($_POST['BegEvt']);
    $EndEvt		= 	mysql_real_escape_string($_POST['EndEvt']);
	$DescEvt	= 	mysql_real_escape_string($_POST['DescEvt']);
	$IdLoc		= 	mysql_real_escape_string($_POST['IdLoc']);
    
		
	// on cree une nouvelle entree dans la table
	$evt = new event(null);
	$evt ->AddEvt($NameEvt, $GuestEvt, $DescEvt, $DayEvt, $BegEvt, $EndEvt, $IdLoc);
	
	// recuperation de d id en selectionnant LA DERNIERE fiche cree
	$result_maxid = 	mysql_query("SELECT MAX(IdEvt) AS idmax FROM event;");
	$val_maxid = 		mysql_fetch_array($result_maxid);
	$IdEvt = 			$val_maxid['idmax'];

	// ----------------------					
}
// -------------------------
// Traitement : EDIT
// -------------------------
elseif ($traiter == 'EDIT')
{
	$IdEvt		= 	mysql_real_escape_string($_POST['IdEvt']);
	$DayEvt    	=	mysql_real_escape_string($_POST['DayEvt']);
	$NameEvt	= 	mysql_real_escape_string($_POST['NameEvt']);
	$GuestEvt	= 	mysql_real_escape_string($_POST['NbGuest']);
    $BegEvt		= 	mysql_real_escape_string($_POST['BegEvt']);
    $EndEvt		= 	mysql_real_escape_string($_POST['EndEvt']);
	$DescEvt	= 	mysql_real_escape_string($_POST['DescEvt']);
	$IdLoc		= 	mysql_real_escape_string($_POST['IdLoc']);
		
	// modification : on met a jour la personne
	$evt = new event($IdEvt);
	$evt ->EditEvt($NameEvt, $GuestEvt, $DescEvt, $DayEvt, $BegEvt, $EndEvt, $IdLoc);
	// ----------------------
}
// -------------------------
// Traitement : DELETE
// -------------------------
elseif ($traiter == 'DELETE')
{
	$IdEvt		= 	mysql_real_escape_string($_POST['IdEvt']);
	// suppression dans la BD
	$evt = new event($IdEvt);
	$evt ->Delete($IdEvt);
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
	<title>Shift-Scheduler.com | <?php echo $traiter; ?> an event</title>
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

<h1>ADMINISTRATION OF EVENTS</h1>
<h2><?php echo $traiter; ?> an event</h2>


<?php
// -------------------------

// re-affichage
if ($traiter == 'ADD' )
{
	$event = new event($IdEvt);
?>
<div id="container">
<div class="row">
<div class="alert-box centered success">
	Addition successful.
	<a href="" class="close">&times;</a>
</div>
</div>
</div>
<br/>
<div class="row">
<div class="ten centered columns">
	<div class="panel">
<table>
			<thead>
			<tr style="border:1px dashed #CCCCCC">
				<td width="35%"></td>
				<th width="10%">Guests</th>
				<th width="25%">Time slot</th>
				<th>Duration</th>
				<th>Location</th>
			</tr>
			</thead>
			<?php 
			$evtBeg =  $event ->BegEvt;
			$evtEnd =  $event ->EndEvt;
			$IdLoc = $event -> IdLoc;
			$Loc = new location($IdLoc);
			$NameLoc = $Loc -> NameLoc;
			
			$X = strtotime($evtBeg) ;
			$Y = strtotime($evtEnd);
			
	if ($X > $Y)
		{
			$hours = strtotime("+1 day");
			$temp = dateDiff($X, $Y) ;
			$duration =  dateDiff($hours, $temp) ;
		}
	elseif ($X <= $Y) $duration =  dateDiff($X, $Y) ;
	
	
	 	?>
			
			<tr style="border:1px dashed #CCCCCC">
				<th><?php echo $event ->NameEvt; ?></th>
				<td><?php echo $event ->GuestEvt; ?></td>
				<td><?php echo $event ->BegEvt." - ".$event ->EndEvt; ?></td>
				<td><?php echo $duration; ?></td>
				<td><?php echo $NameLoc; ?></td>
				
			</tr>
		</table>
		<br/>
		<div style=" text-align:center;">
<form method="post" name="formvoirFiche" action="./Forms/events_adm.php">
		<input type="hidden" name="traiter" value="ADD" />
		<button name="btAddEvt" class="nice medium green button" type="submit" title="Add another event">
		<img src="Admin/icones/date_add.png" alt="Add another event" width="24"/>Add another event</button>
	</form>
	<br/>
</div>
		</div>
	</div>
</div>
<?php
}

if ($traiter == 'EDIT')
{
	$event = new event($IdEvt);
	
?>
<div id="container">
<div class="row">
<div class="alert-box centered success">
	Edition successful.
	<a href="" class="close">&times;</a>
</div>
</div>
</div>
<br/>
<div class="row">
<div class="ten centered columns">
	<div class="panel">
<table>
			<thead>
			<tr style="border:1px dashed #CCCCCC">
				<td width="35%"></td>
				<th width="10%">Guests</th>
				<th width="25%">Time slot</th>
				<th>Duration</th>
				<th>Location</th>
			</tr>
			</thead>
			<?php 
			$evtBeg =  $event ->BegEvt;
			$evtEnd =  $event ->EndEvt;
			$IdLoc = $event -> IdLoc;
			$Loc = new location($IdLoc);
			$NameLoc = $Loc -> NameLoc;
			
			
			$duration =  dateDiff($evtBeg, $evtEnd) ;
	
	 	?>
			
			<tr style="border:1px dashed #CCCCCC">
				<th><?php echo $event ->NameEvt; ?></th>
				<td><?php echo $event ->GuestEvt; ?></td>
				<td><?php echo $event ->BegEvt." - ".$event ->EndEvt; ?></td>
				<td><?php echo $duration; ?></td>
				<td><?php echo $NameLoc; ?></td>
				
			</tr>
		</table>
		<br/>
		</div>
	</div>
</div>
<?php
}
		
// -------------------------
if ($traiter == 'DELETE') { ?>
	<div id="container">	
		<div class="alert-box centered success ">
	The event has been deleted.
	<a href="" class="close">&times;</a>
</div>
</div>
<?php } ?>
</div>

<!-- lien retour -->
	<div style="text-align:center;">
		<a href="./admin_spr.php#nice1"><div class="large button red" ><img src="./Admin/icones/arrow_back.png" alt="" /> Go back</div></a>
	</div>

<div id="footer"> <?php include("footer.php");?></div>

	<!-- Included JS Files -->
	<script src="js/jquery.min.js"></script>
	<script src="js/foundation.js"></script>
	<script src="js/app.js"></script>

</body>
</html>