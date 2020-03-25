<?php
// protection de page ADMIN
   include_once('../Admin/fonctions/_protectpage.php');
// **************************************
// Parametres de Connexion a la BD
	include_once('../connexion.php');
// Parametres de CONFIGURATION de Employees
	include_once('../Admin/fonctions/config.php');
// **************************************
// Fonctions de traitement d image
	include_once('../Admin/fonctions/fct_traitement_image.php');
// **************************************
	include_once("../Model/class.post.php");		
	include_once('../Model/class.department.php'); 
	include_once("../Model/class.skills.php");	
	include_once('../Model/class.sunday.php');
	include_once('../Model/class.monday.php');
	include_once('../Model/class.tuesday.php');
	include_once('../Model/class.wednesday.php');
	include_once('../Model/class.thursday.php');
	include_once('../Model/class.friday.php');
	include_once('../Model/class.saturday.php');

$traiter = '';
if (isset($_POST['traiter']) && ($_POST['traiter']=='ADD' || $_POST['traiter']=='EDIT')){
	$traiter = $_POST['traiter'];
} else {
	// sinon retour a la liste
	header('location: ../admin.php#nice4');
	exit;
}


// -------------------------
// ADD an employee
// -------------------------
if ($traiter == 'ADD')
{
	$persID    		=	'';
	$persFirstName	= 	'';
	$persLastName	= 	'';
    $persEmail		= 	'';
    $persPhone		= 	'';
	$persDOB		= 	'';
    $persFirstDay	= 	'';
    $PhotoAvant		= 	'';
    $IdPost			=	0;
	$persWorkHrs	=	'';
	$persSkill = '';
	
	 $SunBeg   =	'';	
	 $SunEnd   =	'';	
	 $MonBeg   =	'';	
	 $MonEnd   =	'';	
	 $TuesBeg  =	'';	
	 $TuesEnd  =	'';	
	 $WedBeg   =	'';	
	 $WedEnd   =	'';	
	 $ThursBeg =	'';	
	 $ThursEnd =	'';	
	 $FriBeg   =	'';	
	 $FriEnd   =	'';	
	 $SatBeg   =	'';	
	 $SatEnd   =	'';
	
}
// -------------------------
// EDIT an employee
// -------------------------
elseif ($traiter == 'EDIT')
{
	$persID = 	    mysql_real_escape_string($_POST['persID']);
	// recuperation des infos correspondantes
	$query_modif = 		"SELECT * FROM PERSON WHERE IdPers='".$persID."'";
	$result_modif = 	mysql_query($query_modif) or die('Erreur SQL :<br />'.$query_modif.'<br />'.mysql_error());
    $row_modif = 		mysql_fetch_array($result_modif);
	
	$persFirstName	= 	stripslashes($row_modif['FirstName']);
	$persLastName	= 	stripslashes($row_modif['LastName']);
    $persEmail		= 	stripslashes($row_modif['Email']);
    $persPhone		= 	stripslashes($row_modif['Phone']);
	$persDOB		= 	stripslashes($row_modif['DOB']);
    $persFirstDay	= 	stripslashes($row_modif['FirstDay']);
    $PhotoAvant		= 	stripslashes($row_modif['Avatar']);
	$persWorkHrs	= 	stripslashes($row_modif['WorkHrs']);
    $IdPost			=	$row_modif['IdPost'];
	
	$skills = new skills($persID);
	$persSkill = $skills ->Skill;
	
	$Sunday = new sunday($persID);
	$Monday = new monday($persID);
	$Tuesday = new tuesday($persID);
	$Wednesday = new wednesday($persID);
	$Thursday = new thursday($persID);
	$Friday = new friday($persID);
	$Saturday = new saturday($persID);
	
	 $SunBeg   =	$Sunday ->BegSun;	
	 $SunEnd   =	$Sunday ->EndSun;	
	 $MonBeg   =	$Monday ->BegMon;	
	 $MonEnd   =	$Monday ->EndMon;	
	 $TuesBeg  =	$Tuesday ->BegTues;	
	 $TuesEnd  =	$Tuesday ->EndTues;	
	 $WedBeg   =	$Wednesday ->BegWed;	
	 $WedEnd   =	$Wednesday ->EndWed;	
	 $ThursBeg =	$Thursday ->BegThurs;	
	 $ThursEnd =	$Thursday ->EndThurs;	
	 $FriBeg   =	$Friday ->BegFri;	
	 $FriEnd   =	$Friday ->EndFri;	
	 $SatBeg   =	$Saturday ->BegSat;	
	 $SatEnd   =	$Saturday ->BegSat;
	 
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

	<title>Shift-Scheduler.com | <?php echo $traiter; ?> an employee</title>
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

<link rel="stylesheet" media="screen" type="text/css" href="../Admin/css_adm/style.css" />
		<script type="text/javascript" src="../js/jquery-1.7.2.min.js"></script>
		<script type="text/javascript" src="../js/jquery-ui-1.8.20.custom.min.js"></script>
		<script>
	$(function() {
		$( "#DOB" ).datepicker({
			changeMonth: true,
			changeYear: true,
			altField: "#alternate",
			altFormat: "D, d M, yy",
			minDate: "-50Y",
			maxDate: "-15Y",
			dateFormat: "yy-mm-dd"
		});
		$( "#FirstDay" ).datepicker({
			changeMonth: true,
			changeYear: true,
			altField: "#altern",
			altFormat: "D, d M, yy",
			minDate: "-50Y",
			maxDate: "+1Y",
			dateFormat: "yy-mm-dd"
		});
	});
	</script>
			
	
<!--Timepicker-->	
    <script type="text/javascript" src="../js/jquery.ui.core.min.js"></script>	
    <script type="text/javascript" src="../js/jquery.ui.timepicker.js?v=0.3.0"></script>
	<script type="text/javascript" src="../js/jquery.ui.widget.min.js"></script>
    <script type="text/javascript" src="../js/jquery.ui.tabs.min.js"></script>
    <script type="text/javascript" src="../js/jquery.ui.position.min.js"></script>

<!--timepicker styling-->
	<link rel="stylesheet" href="../css/jquery-ui-1.8.20.custom.css" type="text/css" />
    <link rel="stylesheet" href="../css/jquery.ui.timepicker.css?v=0.3.0" type="text/css" />

	
<!--Availability-->
<script type="text/javascript">
function show_sunday() {

	if ($('#Sunday').attr('checked')) {
    	$('#SlotSunday').show();
	}
	else if ($('#Sunday').attr('checked') != true) {
    	$('#SlotSunday').hide();
		$("#SunBeg").val('');
		$("#SunEnd").val('');
	}
}

function show_monday() {

	if ($('#Monday').attr('checked')) {
    	$('#SlotMonday').show();
	}
	else if ($('#Monday').attr('checked') != true) {
    	$('#SlotMonday').hide();
		$("#MonBeg").val('');
		$("#MonEnd").val('');
	}
}

function show_tuesday() {

	if ($('#Tuesday').attr('checked')) {
    	$('#SlotTuesday').show();
	}
	else if ($('#Tuesday').attr('checked') != true) {
    	$('#SlotTuesday').hide();
		$("#TuesBeg").val('');
		$("#TuesEnd").val('');
	}
}

function show_wednesday() {

	if ($('#Wednesday').attr('checked')) {
    	$('#SlotWednesday').show();
	}
	else if ($('#Wednesday').attr('checked') != true) {
    	$('#SlotWednesday').hide();
		$("#WedBeg").val('');
		$("#WedEnd").val('');
	}
}

function show_thursday() {

	if ($('#Thursday').attr('checked')) {
    	$('#SlotThursday').show();
	}
	else if ($('#Thursday').attr('checked') != true) {
    	$('#SlotThursday').hide();
		$("#ThursBeg").val('');
		$("#ThursEnd").val('');

	}
}

function show_friday() {

	if ($('#Friday').attr('checked')) {
    	$('#SlotFriday').show();
	}
	else if ($('#Friday').attr('checked') != true) {
    	$('#SlotFriday').hide();
		$("#FriBeg").val('');
		$("#FriEnd").val('');
	}
}

function show_saturday() {

	if ($('#Saturday').attr('checked')) {
    	$('#SlotSaturday').show();
	}
	else if ($('#Saturday').attr('checked') != true) {
    	$('#SlotSaturday').hide();
		$("#SatBeg").val('');
		$("#SatEnd").val('');
	}
}

</script>


 <script type="text/javascript">
            $(document).ready(function() {
                $('#SunBeg').timepicker({
    showPeriod: true,
    showLeadingZero: true,
	minutes: {
        starts: 0,                // First displayed minute
        ends: 45,                 // Last displayed minute
        interval: 15               // Interval of displayed minutes
    }
});
				$('#SunEnd').timepicker({
    showPeriod: true,
    showLeadingZero: true,
	minutes: {
        starts: 0,                // First displayed minute
        ends: 45,                 // Last displayed minute
        interval: 15               // Interval of displayed minutes
    }
});
				$('#MonBeg').timepicker({
    showPeriod: true,
    showLeadingZero: true,
	minutes: {
        starts: 0,                // First displayed minute
        ends: 45,                 // Last displayed minute
        interval: 15               // Interval of displayed minutes
    }
});
				$('#MonEnd').timepicker({
    showPeriod: true,
    showLeadingZero: true,
	minutes: {
        starts: 0,                // First displayed minute
        ends: 45,                 // Last displayed minute
        interval: 15               // Interval of displayed minutes
    }
});
				$('#TuesBeg').timepicker({
    showPeriod: true,
    showLeadingZero: true,
	minutes: {
        starts: 0,                // First displayed minute
        ends: 45,                 // Last displayed minute
        interval: 15               // Interval of displayed minutes
    }
});
				$('#TuesEnd').timepicker({
    showPeriod: true,
    showLeadingZero: true,
	minutes: {
        starts: 0,                // First displayed minute
        ends: 45,                 // Last displayed minute
        interval: 15               // Interval of displayed minutes
    }
});
				$('#WedBeg').timepicker({
    showPeriod: true,
    showLeadingZero: true,
	minutes: {
        starts: 0,                // First displayed minute
        ends: 45,                 // Last displayed minute
        interval: 15               // Interval of displayed minutes
    }
});
				$('#WedEnd').timepicker({
    showPeriod: true,
    showLeadingZero: true,
	minutes: {
        starts: 0,                // First displayed minute
        ends: 45,                 // Last displayed minute
        interval: 15               // Interval of displayed minutes
    }
});
				$('#ThursBeg').timepicker({
    showPeriod: true,
    showLeadingZero: true,
	minutes: {
        starts: 0,                // First displayed minute
        ends: 45,                 // Last displayed minute
        interval: 15               // Interval of displayed minutes
    }
});
				$('#ThursEnd').timepicker({
    showPeriod: true,
    showLeadingZero: true,
	minutes: {
        starts: 0,                // First displayed minute
        ends: 45,                 // Last displayed minute
        interval: 15               // Interval of displayed minutes
    }
});
				$('#FriBeg').timepicker({
    showPeriod: true,
    showLeadingZero: true,
	minutes: {
        starts: 0,                // First displayed minute
        ends: 45,                 // Last displayed minute
        interval: 15               // Interval of displayed minutes
    }
});
				$('#FriEnd').timepicker({
    showPeriod: true,
    showLeadingZero: true,
	minutes: {
        starts: 0,                // First displayed minute
        ends: 45,                 // Last displayed minute
        interval: 15               // Interval of displayed minutes
    }
});
				$('#SatBeg').timepicker({
    showPeriod: true,
    showLeadingZero: true,
	minutes: {
        starts: 0,                // First displayed minute
        ends: 45,                 // Last displayed minute
        interval: 15               // Interval of displayed minutes
    }
});
				$('#SatEnd').timepicker({
    showPeriod: true,
    showLeadingZero: true,
	minutes: {
        starts: 0,                // First displayed minute
        ends: 45,                 // Last displayed minute
        interval: 15               // Interval of displayed minutes
    }
});
            });
        </script>

<!--Validation-->
<script type="text/javascript">
$(document).ready(function() {
    $("#persID").keydown(function(event) {
        // Allow: backspace, delete, tab, escape, and enter
        if ( event.keyCode == 46 || event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 27 || event.keyCode == 13 || 
             // Allow: Ctrl+A
            (event.keyCode == 65 && event.ctrlKey === true) || 
             // Allow: home, end, left, right
            (event.keyCode >= 35 && event.keyCode <= 39)) {
                 // let it happen, don't do anything
                 return;
        }
        else {
            // Ensure that it is a number and stop the keypress
            if (event.shiftKey || (event.keyCode < 48 || event.keyCode > 57) && (event.keyCode < 96 || event.keyCode > 105 )) {
                event.preventDefault(); 
            }   
        }
    });
	// Disable right click
	$("#persID").bind("contextmenu",function(e){
	        return false;
	    });
	
	 $("#Phone").keydown(function(event) {
        // Allow: backspace, delete, tab, escape, and enter
        if ( event.keyCode == 46 || event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 27 || event.keyCode == 13 || 
             // Allow: Ctrl+A
            (event.keyCode == 65 && event.ctrlKey === true) || 
             // Allow: home, end, left, right
            (event.keyCode >= 35 && event.keyCode <= 39)) {
                 // let it happen, don't do anything
                 return;
        }
        else {
            // Ensure that it is a number and stop the keypress
            if (event.shiftKey || (event.keyCode < 48 || event.keyCode > 57) && (event.keyCode < 96 || event.keyCode > 105 )) {
                event.preventDefault(); 
            }   
        }
    });
	// Disable right click
	$("#Phone").bind("contextmenu",function(e){
	        return false;
	    });
	
	 $("#WorkHrs").keydown(function(event) {
        // Allow: backspace, delete, tab, escape, and enter
        if ( event.keyCode == 46 || event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 27 || event.keyCode == 13 || 
             // Allow: Ctrl+A
            (event.keyCode == 65 && event.ctrlKey === true) || 
             // Allow: home, end, left, right
            (event.keyCode >= 35 && event.keyCode <= 39)) {
                 // let it happen, don't do anything
                 return;
        }
        else {
            // Ensure that it is a number and stop the keypress
            if (event.shiftKey || (event.keyCode < 48 || event.keyCode > 57) && (event.keyCode < 96 || event.keyCode > 105 )) {
                event.preventDefault(); 
            }   
        }
    });
	// Disable right click
	$("#WorkHrs").bind("contextmenu",function(e){
	        return false;
	    });
	
});

</script>
  
</head>

<body onLoad="show_sunday(); show_monday(); show_tuesday(); show_wednesday(); show_thursday(); show_friday(); show_saturday();">
<div id="containercentrer">
<br/>
<h1><?php echo $traiter; ?> AN EMPLOYEE</h1>
<br/>
<!-- formulaire -->
<form id="monForm" method="post" enctype="multipart/form-data" action="../treatment.php">
<!--<fieldset>-->
<input type="hidden" name="traiter" value="<?php echo $traiter; ?>" />
<input type="hidden" name="PhotoAvant" value="<?php echo $PhotoAvant; ?>" />


			<div class="panel">
	<div class="row">
		<div class="seven columns">
        	<fieldset>
			
			<h4 style="text-align:center;">PERSONAL INFORMATION</h4>
			<p>
				<label for="DayEvt">PSU ID   <br>
                                <span style="color:#808080; font-size:8pt;">9 digits, no dash, no space</span> </label>
				<input id="persID" name="persID" type="text" maxlength=9 value="<?php echo $persID; ?>" required /> 
			</p>
			
            <p>
				<label for="DayEvt"> First Name  </label>
				<input id="FirstName" name="FirstName" type="text" size="40" value="<?php echo $persFirstName; ?>" required />
			</p>
            <p>
				<label for="DayEvt">  Last Name  </label>
				<input id="LastName" name="LastName" type="text" size="40" value="<?php echo $persLastName; ?>" required />
			</p>
            <p>
				<label for="DayEvt"> Date of Birth  </label>
				<input type="text" name="DOB" id="DOB" value="<?php echo $persDOB; ?>" required><input type="text" id="alternate" size="16" disabled="disabled">
			</p>
            <p>
				<label for="DayEvt">  Email Address  </label>
				<input id="Email" name="Email" type="email" size="40" value="<?php echo $persEmail; ?>" required /> 
			</p>
            <p>
				<label for="DayEvt">  Phone Number<br>
                                <span style="color:#808080; font-size:8pt;">10 digits, no dashes</span>  </label>
				<input id="Phone" name="Phone" type="text" maxlength=10 size=15 value="<?php echo $persPhone; ?>" required />
			</p>
            <p>
				<label for="DayEvt"> First day of work   </label>
				<input type="text" name="FirstDay" id="FirstDay" required value="<?php echo $persFirstDay; ?>"/><input type="text" id="altern" size="16" disabled="disabled">
			</p>
            <p>
				<label for="DayEvt"> Hours of work a week </label>
				<input id="WorkHrs" name="WorkHrs" type="text" maxlength=2 size=15 value="<?php echo $persWorkHrs; ?>" required />
			</p>
			<div class="clearfix"></div>
            <p>
				<label for="DayEvt" > Position<br/>   </label>
				 <select name="IdPost" id="IdPost" required="required" >
								 <option value=""><span style="color:#808080; font-size:8pt;">(Select a position)</span></option>
            <?php

$post=new post(null);
	if(false!=$post->Listing())
		$listepost=$post->Listing();
		
	  	if(!empty($listepost))
	  	{
	  		while($lgne=mysql_fetch_array($listepost))
			{
	  	?>
            <option value="<?php echo $lgne[0]; ?>" <?php if ($lgne[0] == $IdPost) echo  'selected="selected"' ;?> ><?php echo $lgne[1]; ?></option>
            
            <?php
  			}
		}
	   ?>
          </select>   
			</p>
			<div class="clearfix"></div>
            <br/>
            
			</fieldset>
		<div class="clearfix"></div>
			<br/>
<div class="row">
	<div class="six columns">
		<p style="text-align:center;">            
         		<button name="addpers" type="submit" value="<?php echo $traiter; ?>" class="medium radius button green"><img src="../Admin/icones/<?php echo $traiter; ?>.png" alt="" /><span><?php echo $traiter; ?> Employee </span></button>	
		</p>
	</div> <!--End 6 cols-->
	
	<div class="six columns">
				<a href="../admin.php#nice4"><div class="large radius button red" ><img src="../Admin/icones/ANNULER.png" alt="" /> <span> Cancel</span></div></a>	
	</div> <!--End 6 cols-->
</div>	<!--End row-->
<br/>
										
		<!--</div>--> <!--End panel-->
	</div> <!--End 7 cols-->


		<div class="five columns">
			<!--<div class="panel">-->
			<fieldset>
<?php
// -------------------------
if ($traiter == 'ADD' || $traiter == 'EDIT')
{
?>
	<!-- photo -->
	<h4 style="text-align:center;">ADD A PICTURE</h4>
	
	<p>
<?php	if ($PhotoAvant != ''){ ?>
		<img <?php echo fctaffichimage("../Avatars/".$PhotoAvant, 150, 150); ?> alt="<?php echo $PhotoAvant; ?>" title="<?php echo $PhotoAvant; ?>" /><br />
    	<label for="idPHOTOdelete">delete ? </label>
    	<input type="checkbox" id="idPHOTOdelete" name="PHOTOdelete" value="ON"><br />
<?php	} ?>
    <label for="PHOTO">Add/edit a picture : </label> (<?php echo $ImageExtOK; ?>)<br />
    <input type="file" id="PHOTO" name="PHOTO" size="20"><br />
	<div class="clearfix"></div>
    <label for="idphotolargeur" class="label14">Width (display) : 
	<select size="1" id="idphotolargeur" name="photolargeur">
		<option value="100">picto : 100px</option>
		<option value="200">mini : 200px</option>
		<option value="300" selected="selected">normal : 300px</option>
		<option value="450">medium : 450px</option>
		<option value="600">large : 600px</option>
	</select>
	</label>
	</p>
	
	
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
	<h4 style="text-align:center;">PHOTO</h4>
		<img <?php echo fctaffichimage($DossierNewsPhotoCourt.$PhotoAvant, 150, 150); ?> alt="<?php echo $PhotoAvant; ?>" title="<?php echo $PhotoAvant; ?>" /><br />
		(the photo will be deleted.)<br />
	</p>
<?php	} ?>

<?php
} 
?>
</fieldset>
								
		<fieldset>
		<h4 style="text-align:center;">SKILLS</h4>
			<label for="radio1"><input name="skill" type="radio" id="radio1" value="MEDIUM" <?php if ($persSkill == 'MEDIUM') echo 'checked="checked"';?>  required="required" > Medium</label>
			<label for="radio2"><input name="skill" type="radio" id="radio2" value="GOOD" <?php if ($persSkill == 'GOOD') echo 'checked="checked"';?> required > Good</label>
		 	<label for="radio3"> <input name="skill" type="radio" id="radio3" value="EXCELLENT" <?php if ($persSkill == 'EXCELLENT') echo 'checked="checked"';?> required > Excellent</label>
					
		</fieldset>
		
			
								
		<fieldset>
	
		<h4 style="text-align:center;">AVAILABILITY</h4>
		
				<p>
					<label for="Sunday"><input type="checkbox" id="Sunday" name="Sunday" value="SUNDAY" <?php if ($SunBeg != '') echo 'checked="checked"';?> onClick="show_sunday()" /> Sunday</label>
					<div id="SlotSunday" style="display:none; float:right;">
						<label for="FromSlotSunday" style="display:inline; float:right;">From :<input id="SunBeg" name="SunBeg" value="<?php echo $SunBeg;?>" /></label><br/>
						<label for="ToSlotSunday" style="display:inline; float:right;">To :<input id="SunEnd" name="SunEnd" value="<?php echo $SunEnd;?>" /></label>
					</div>					
				</p>
				
				<div class="clearfix"></div>
				<p>
					<label for="Monday"><input type="checkbox" id="Monday" value="MONDAY" <?php if ($MonBeg != '') echo 'checked="checked"';?> onClick="show_monday()"/> Monday</label>
					<div id="SlotMonday" style="display:none; float:right;">
						<label for="FromSlotMonday" style="display:inline; float:right;">From :<input id="MonBeg" name="MonBeg" value="<?php echo $MonBeg;?>" /></label><br/>
						<label for="ToSlotMonday" style="display:inline; float:right;">To :<input id="MonEnd" name="MonEnd" value="<?php echo $MonEnd;?>" /></label>
					</div>					
				</p>
				
				<div class="clearfix"></div>
				<p>
					<label for="Tuesday"><input type="checkbox" id="Tuesday" value="TUESDAY" <?php if ($TuesBeg != '') echo 'checked="checked"';?> onClick="show_tuesday()"/> Tuesday</label>
					<div id="SlotTuesday" style="display:none; float:right;">
						<label for="FromSlotTuesday" style="display:inline; float:right;">From :<input id="TuesBeg" name="TuesBeg" value="<?php echo $TuesBeg;?>" /></label><br/>
						<label for="ToSlotTuesday" style="display:inline; float:right;">To :<input id="TuesEnd" name="TuesEnd" value="<?php echo $TuesEnd;?>" /></label>
					</div>
				</p>
				
				<div class="clearfix"></div>
				<p>
					<label for="Wednesday"><input type="checkbox" id="Wednesday" value="WEDNESDAY" <?php if ($WedBeg != '') echo 'checked="checked"';?> onClick="show_wednesday()"/> Wednesday</label>
					<div id="SlotWednesday" style="display:none; float:right;">
						<label for="FromSlotWednesday" style="display:inline; float:right;">From :<input id="WedBeg" name="WedBeg" value="<?php echo $WedBeg;?>" /></label><br/>
						<label for="ToSlotWednesday" style="display:inline; float:right;">To :<input id="WedEnd" name="WedEnd" value="<?php echo $WedEnd;?>" /></label>
					</div>
				</p>
				
				<div class="clearfix"></div>
				<p>
					<label for="Thursday"><input type="checkbox" id="Thursday" value="THURSDAY" <?php if ($ThursBeg != '') echo 'checked="checked"';?> onClick="show_thursday()"/> Thursday</label>
					<div id="SlotThursday" style="display:none; float:right;">
						<label for="FromSlotThursday" style="display:inline; float:right;">From :<input id="ThursBeg" name="ThursBeg" value="<?php echo $ThursBeg;?>" /></label><br/>
						<label for="ToSlotThursday" style="display:inline; float:right;">To :<input id="ThursEnd" name="ThursEnd" value="<?php echo $ThursEnd;?>" /></label>
					</div>
				</p>
				
				<div class="clearfix"></div>
				<p>
					<label for="Friday"><input type="checkbox" id="Friday" value="FRIDAY" <?php if ($FriBeg != '') echo 'checked="checked"';?> onClick="show_friday()"/> Friday</label>
					<div id="SlotFriday" style="display:none; float:right;">
						<label for="FromSlotFriday" style="display:inline; float:right;">From :<input id="FriBeg" name="FriBeg" value="<?php echo $FriBeg;?>" /></label><br/>
						<label for="ToSlotFriday" style="display:inline; float:right;">To :<input id="FriEnd" name="FriEnd" value="<?php echo $FriEnd;?>" /></label>
					</div>
				</p>
				
				<div class="clearfix"></div>
				<p>
					<label for="Saturday"><input type="checkbox" id="Saturday" value="SATURDAY" <?php if ($SatBeg != '') echo 'checked="checked"';?> onClick="show_saturday()"> Saturday</label>
					<div id="SlotSaturday" style="display:none; float:right;">
						<label for="FromSlotSaturday" style="display:inline; float:right;">From :<input id="SatBeg" name="SatBeg" value="<?php echo $SatBeg;?>" /></label><br/>
						<label for="ToSlotSaturday" style="display:inline; float:right;">To :<input id="SatEnd" name="SatEnd" value="<?php echo $SatEnd;?>" /></label>
					</div>
				</p>
					
		</fieldset>
		
								
		</div> <!--End panel-->
	</div> <!--End 12 cols-->
</div>	<!--End row-->
<!--</fieldset>-->
</form>

</div>	

<div id="footer"> <?php include("../footer.php");?></div>


<!-- Included JS Files -->
	<!--<script src="../js/jquery.min.js"></script>-->
	<script src="../js/foundation.js"></script>
	<script src="../js/app.js"></script>
	
</body>
</html>
