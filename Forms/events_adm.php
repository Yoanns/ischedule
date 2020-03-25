<?php
// protection de page ADMIN
   include_once('../Admin/fonctions/_protectpageadm.php');
// **************************************
// Parametres de Connexion a la BD
	include_once('../connexion.php');
// Parametres de CONFIGURATION de Employees
	include_once('../Admin/fonctions/config.php');
// **************************************
// Fonctions de traitement d image
	include_once('../Admin/fonctions/fct_traitement_image.php');
// **************************************
	include_once("../Model/class.event.php");
	include_once("../Model/class.location.php");	
	

$traiter = '';
if (isset($_POST['traiter']) && ($_POST['traiter']=='ADD' || $_POST['traiter']=='EDIT')){
	$traiter = $_POST['traiter'];
} else {
	// sinon retour a la liste
	header('location: ../admin.php#nice1');
	exit;
}


// -------------------------
// ADD an employee
// -------------------------
if ($traiter == 'ADD')
{
	$DayEvt    	=	'';
	$NameEvt	= 	'';
	$GuestEvt	= 	'';
    $BegEvt		= 	'';
    $EndEvt		= 	'';
	$DescEvt	= 	'';
	
	$IdLoc		= '';
}
// -------------------------
// EDIT an employee
// -------------------------
elseif ($traiter == 'EDIT')
{
	$IdEvt = 	    mysql_real_escape_string($_POST['IdEvt']);
	// recuperation des infos correspondantes
	$query_modif = 		"SELECT * FROM EVENT WHERE IdEvt='".$IdEvt."'";
	$result_modif = 	mysql_query($query_modif) or die('Erreur SQL :<br />'.$query_modif.'<br />'.mysql_error());
    $row_modif = 		mysql_fetch_array($result_modif);
		
	$DayEvt		=	stripslashes($row_modif['DayEvt']);
	$NameEvt	= 	stripslashes($row_modif['NameEvt']);
	$GuestEvt	= 	stripslashes($row_modif['GuestEvt']);
    $BegEvt		= 	stripslashes($row_modif['BegEvt']);
    $EndEvt		= 	stripslashes($row_modif['EndEvt']);
	$DescEvt	= 	stripslashes($row_modif['DescEvt']);	
	$IdLoc		= 	stripslashes($row_modif['IdLoc']);
	
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

	<title>Shift-Scheduler.com | <?php echo $traiter; ?> an event</title>
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
	
		<!-- jQuery Library + ALL jQuery Tools -->
<script src="http://cdn.jquerytools.org/1.2.7/full/jquery.tools.min.js"></script>
<!-- dateinput styling -->
<link rel="stylesheet" type="text/css" href="../css/dateinput.css"/>

	<!--Timepicker-->	
    <script type="text/javascript" src="../js/jquery.ui.core.min.js"></script>	
    <script type="text/javascript" src="../js/jquery.ui.timepicker.js?v=0.3.0"></script>
	<script type="text/javascript" src="../js/jquery.ui.widget.min.js"></script>
    <script type="text/javascript" src="../js/jquery.ui.tabs.min.js"></script>
    <script type="text/javascript" src="../js/jquery.ui.position.min.js"></script>
 <!--timepicker styling-->
	<link rel="stylesheet" href="../css/jquery-ui-1.8.21.custom.css" type="text/css" />
    <link rel="stylesheet" href="../css/jquery.ui.timepicker.css?v=0.3.0" type="text/css" />

		<!--<script type="text/javascript" src="../js/jquery-1.7.2.min.js"></script>
		<script type="text/javascript" src="../js/jquery-ui-1.8.20.custom.min.js"></script>
		<script>
	$(function() {
		$( "#DayEvt" ).datepicker({
			changeMonth: true,
			changeYear: true,
			altField: "#alternate",
			altFormat: "DD, d MM, yy",
			minDate: "0",
			maxDate: "3Y",
			dateFormat: "yy-mm-dd"
		});
		
	});
	</script>-->
			
</head>

<body>
<div id="containercentrer">
<br/>
<h1><?php echo $traiter; ?> AN EVENT</h1>
<br/>
<div class="row">
	<div class="twelve columns centered">
		<div class="panel">
<!-- formulaire -->
<form id="EvtForm" method="post" enctype="multipart/form-data" action="../evt_treatment_adm.php">
<fieldset>
<input type="hidden" name="traiter" value="<?php echo $traiter; ?>" />
<input type="hidden" name="IdEvt" value="<?php echo $IdEvt; ?>" />
<div class="row">
	<div class="six columns">
   	<p>
		<label for="DayEvt" >Event's day : </label>
		<input id="DayEvt" name="DayEvt" type="date" size="30" value="<?php echo $DayEvt;?>" required />
	</p>
	<p>
		<label for="NameEvt">Event's name : </label>
		<input id="NameEvt" name="NameEvt" size="30" value="<?php echo $NameEvt;?>" required/>
	</p>
	<p>
		<label for="NbGuest">Number of guests : </label>
		<input id="NbGuest" name="NbGuest" type="digits" value="<?php echo $GuestEvt;?>" size="30" required/>
	</p>
	<p>
		<label for="BegEvt">Event's start : </label>
		<input id="BegEvt" name="BegEvt" size="30" value="<?php echo $BegEvt;?>" required />
	</p>
	<p>
		<label for="EndEvt">Event's end : </label>
		<input id="EndEvt" name="EndEvt" size="30" value="<?php echo $EndEvt;?>" required />
	</p>
	
	<p>
		<label for="EndEvt">Event's location : </label>
		<select name="IdLoc" id="IdLoc" required="required" >
								 <option value="">Please select</option>
            <?php

	$Loc = new location(null);
	if (false!=$Loc->Listing())
		$listLoc=$Loc->Listing();
		
	  	if (!empty($listLoc))
	  	{
	  		while ($row=mysql_fetch_array($listLoc))
			{
				$NameLoc = $row["NameLoc"];
				$LocID = $row["IdLoc"];
				
	  	?>
            <option value="<?php echo $LocID; ?>" <?php if ($LocID == $IdLoc) echo  'selected="selected"' ;?> ><?php echo $NameLoc; ?></option>
            
            <?php
  			}
		}
	   ?>
          </select>
	</p>
</div><!-- End 6 cols-->

<div class="six columns">
	
	<p>
		<label for="DescEvt">Event's description  <span style="color:#808080; font-size:8pt;">(Optional)</span></label><br/>
		<textarea id="DescEvt" name="DescEvt" style="width:420px;" rows="6" placeholder="Enter a quick description of the event if possible"><?php echo $DescEvt;?></textarea>
	</p>
</div><!-- End 6 cols-->
</div>	<!--End row-->

<div class="row">
	<div class="twelve columns centered">
	<p style="text-align:center;">
		<button name="evtsubmit" type="submit" title="Save event" class="large green button">
		<!--<img src="../Admin/icones/save.jpg" alt="" width="24" />-->Save event</button>
	</p>
	</div> <!--End panel-->
</div> <!--End 12 cols-->
	</fieldset>
</form>
	</div> <!--End panel-->
	</div> <!--End 12 cols-->
</div>	<!--End row-->

 
 <div class="row">
	<div class="twelve columns centered" align="center">
		<a href="../admin_spr.php#nice1" title="Go back"><div class="large button red" ><img src="../Admin/icones/arrow_back.png" alt="" /> Go back</div></a>	
 	</div>
 </div>

<br/>
</div> <!--End containercentrer-->

<div id="footer"> <?php include("../footer.php");?></div>

<!-- make it happen -->
<script>
  $(":date").dateinput({
  		format:' yyyy-mm-dd',
		selectors: true,
		min:0,
		max: 600,
		yearRange:[0,3]
  });
</script>

<!-- Included JS Files -->
	<!--<script src="../js/jquery.min.js"></script>-->
	<script src="../js/foundation.js"></script>
	<script src="../js/app.js"></script>
	
</body>
</html>

<script type="text/javascript">
$(document).ready(function() {
    $('#BegEvt').timepicker({
        showLeadingZero: false,
		showPeriod: true,
		minutes: {
        starts: 0,                // First displayed minute
        ends: 45,                 // Last displayed minute
        interval: 15               // Interval of displayed minutes
    }/*,
        onHourShow: tpStartOnHourShowCallback,
        onMinuteShow: tpStartOnMinuteShowCallback*/
    });
    $('#EndEvt').timepicker({
        showLeadingZero: false,
		showPeriod: true,
		minutes: {
        starts: 0,                // First displayed minute
        ends: 45,                 // Last displayed minute
        interval: 15               // Interval of displayed minutes
    }/*,
        onHourShow: tpEndOnHourShowCallback,
        onMinuteShow: tpEndOnMinuteShowCallback*/
    });
});

/*function tpStartOnHourShowCallback(hour) {
    var tpEndHour = $('#EndEvt').timepicker('getHour');
    // Check if proposed hour is prior or equal to selected end time hour
    if (hour <= tpEndHour) { return true; }
    // if hour did not match, it can not be selected
    return false;
}
function tpStartOnMinuteShowCallback(hour, minute) {
    var tpEndHour = $('#EndEvt').timepicker('getHour');
    var tpEndMinute = $('#EndEvt').timepicker('getMinute');
    // Check if proposed hour is prior to selected end time hour
    if (hour < tpEndHour) { return true; }
    // Check if proposed hour is equal to selected end time hour and minutes is prior
    if ( (hour == tpEndHour) && (minute < tpEndMinute) ) { return true; }
    // if minute did not match, it can not be selected
    return false;
}

function tpEndOnHourShowCallback(hour) {
    var tpStartHour = $('#BegEvt').timepicker('getHour');
    // Check if proposed hour is after or equal to selected start time hour
    if (hour >= tpStartHour) { return true; }
    // if hour did not match, it can not be selected
    return false;
}
function tpEndOnMinuteShowCallback(hour, minute) {
    var tpStartHour = $('#BegEvt').timepicker('getHour');
    var tpStartMinute = $('#BegEvt').timepicker('getMinute');
    // Check if proposed hour is after selected start time hour
    if (hour > tpStartHour) { return true; }
    // Check if proposed hour is equal to selected start time hour and minutes is after
    if ( (hour == tpStartHour) && (minute > tpStartMinute) ) { return true; }
    // if minute did not match, it can not be selected
    return false;
}*/
</script>