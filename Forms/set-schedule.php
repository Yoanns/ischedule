<?php
// protection de page ADMIN
   include_once('../Admin/fonctions/_protectpage.php');
// **************************************
// Parametres de Connexion a la BD
	include_once('../connexion.php');
	// On recupere l URL de la page d'origine
	$nomPageOrigine = $_SERVER["HTTP_REFERER"];
	
	include("../Model/class.schedule.php");	

$traiter = '';
if (isset($_POST['traiter']) && ($_POST['traiter']=='SET')){
	$traiter = $_POST['traiter'];
	$persID = 	    mysql_real_escape_string($_POST['persID']);
} else {
	// sinon retour a la liste
	header('location: ../admin.php#nice4');
	exit;
}
//Initializing variables
	
	 $IdWk = '';	 
	 $SunBegHr='';	
	 $SunEndHr='';	
	 $MonBegHr='';	
	 $MonEndHr='';	
	 $TuesBegHr='';	
	 $TuesEndHr='';	
	 $WedBegHr='';	
	 $WedEndHr='';	
	 $ThursBegHr='';	
	 $ThursEndHr='';	
	 $FriBegHr='';	
	 $FriEndHr='';	
	 $SatBegHr='';	
	 $SatEndHr='';
	 
	// Select the person's name whose schedule is being set
	$pers_query = "SELECT FirstName, LastName FROM person WHERE IdPers = '".$persID."'";
	$pers_result = mysql_query($pers_query) or die('Erreur SQL :<br />'.$pers_query.'<br />'.mysql_error());
	$person = mysql_fetch_array($pers_result);
	
	 
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name="robots" content="noindex,nofollow" />
<title>Shift-Scheduler.com | Setting <?php echo $person[0]." ".$person[1]."'s"; ?> schedule</title>
	<link rel="shortcut icon" type="image/x-icon" href="../Admin/icones/ischedule_logo1.ico">
<link rel="stylesheet" media="screen" type="text/css" href="../Admin/css_adm/news_ADM_style.css" />

<!-- <link href="../css/main.css" rel="stylesheet" media="screen" type="text/css" />-->
    <link href="../css/jquery.ketchup.css" rel="stylesheet" media="screen" type="text/css" />
	
    <script src="../js/jquery.js" type="text/javascript"></script>
    <script src="../js/jquery.ketchup.js" type="text/javascript"></script>
    <script src="../js/jquery.ketchup.validations.js" type="text/javascript"></script>
    <script src="../js/jquery.ketchup.helpers.js" type="text/javascript"></script>
    <script src="../js/scaffold.js" type="text/javascript"></script>

<!-- Datepick setting-->	
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
	<link rel="stylesheet" href="../css/jquery-ui-1.8.20.custom.css" type="text/css" />
    <link rel="stylesheet" href="../css/jquery.ui.timepicker.css?v=0.3.0" type="text/css" />

</head>

<body>
<div id="containercentrer">

<h1>Setting <?php echo $person[0]." ".$person[1]."'s"; ?> schedule</h1>

<div style="clear:both;">
<br />
	<form name="FormSet" method="post" action="../sched_treatment.php">
	<input type="hidden" name="traiter" value="<?php echo $traiter; ?>" />
	<input type="hidden" name="persID" value="<?php echo $persID; ?>" />
		<table>
			<tr>
				<td width="42%" align="right" style="padding-right:5px;color:#000;">                                
			 <!-- Select the week:<br></td>
				<td colspan="1"><label for="start-date"></label> -->
				
							<!-- HTML5 date input -->
							<input type="date" name="start-date" id="start-date" required="required" /><br>
							<span style="color:#808080; font-size:8pt;">Pick any day in the concerned week</span>
							
					<!-- make it happen -->
					<script>
 						 $(":date").dateinput({
						 	format: 'yyyy-mm-dd',	// the format displayed for the user
							selectors: false,        // whether month/year dropdowns are shown
							min: -1,                // min selectable day (1 days backwards)	
							firstDay: 0             // which day starts a week. 0 = sunday, 1 = monday etc..
						 });
					</script>
			</td>
			
			</tr>
		</table> 
		<br/>
		
		<table>
			<thead>
			<tr>
				<td width="9%"></td>
				<th width="13%">Sunday</th>
				<th width="13%">Monday</th>
				<th width="13%">Tuesday</th>
				<th width="13%">Wednesday</th>
				<th width="13%">Thursday</th>
				<th width="13%">Friday</th>
				<th width="13%">Saturday</th>
			</tr>
			</thead>
			
			<tr>
				<th>Start of shift</th>
			    <td><input type="text" style="width: 70px;" id="SunBegHr" name="SunBegHr" value="" />       </td>
				<td><input name="MonBegHr" type="text" id="MonBegHr" style="width: 70px;" value="" /></td>
				<td><input name="TuesBegHr" type="text" id="TuesBegHr" style="width: 70px;" value="" /></td>
				<td><input name="WedBegHr" type="text" id="WedBegHr" style="width: 70px;" value="" /></td>
				<td><input name="ThursBegHr" type="text" id="ThursBegHr" style="width: 70px;" value="" /></td>
				<td><input name="FriBegHr" type="text" id="FriBegHr" style="width: 70px;" value="" /></td>
				<td><input name="SatBegHr" type="text" id="SatBegHr" style="width: 70px;" value="" /></td>
			</tr>
			
			<tr>
				<th>End of shift</th>
			    <td><input name="SunEndHr" type="text" id="SunEndHr" style="width: 70px;" value="" /></td>
				<td><input name="MonEndHr" type="text" id="MonEndHr" style="width: 70px;" value="" /></td>
				<td><input name="TuesEndHr" type="text" id="TuesEndHr" style="width: 70px;" value="" /></td>
				<td><input name="WedEndHr" type="text" id="WedEndHr" style="width: 70px;" value="" /></td>
				<td><input name="ThursEndHr" type="text" id="ThursEndHr" style="width: 70px;" value="" /></td>
				<td><input name="FriEndHr" type="text" id="FriEndHr" style="width: 70px;" value="" /></td>
				<td><input name="SatEndHr" type="text" id="SatEndHr" style="width: 70px;" value="" /></td>
			</tr>
			
			<tr>
				<td>				</td>
				<td colspan="7" style="padding:5px;">
                    <button name="setsc" type="submit" value="<?php echo $traiter; ?>" class="large button blue"><img src="../Admin/icones/schedule.jpg" alt="" width="24" /><?php echo $traiter; ?> Schedule </button>	
					<a href="<?php echo $nomPageOrigine; ?>"><div class="large button red"><img src="../Admin/icones/ANNULER.png" alt="" /> Cancel</div> </a>
				</td>
			</tr>
		</table>
	</form>
<script>
			$('#FormSet').ketchup({}, {
				'.required'    : 'required',              //all fields in the form with the class 'required'
 				'#start-date': ' date'
				//'#end-date': ' date'
			});
	</script>
	
</div>
</div>
</body>
</html>
 <script type="text/javascript">
            $(document).ready(function() {
                $('#SunBegHr').timepicker({
    showPeriod: true,
    showLeadingZero: true,
	minutes: {
        starts: 0,                // First displayed minute
        ends: 45,                 // Last displayed minute
        interval: 15               // Interval of displayed minutes
    }
});
				$('#SunEndHr').timepicker({
    showPeriod: true,
    showLeadingZero: true,
	minutes: {
        starts: 0,                // First displayed minute
        ends: 45,                 // Last displayed minute
        interval: 15               // Interval of displayed minutes
    }
});
				$('#MonBegHr').timepicker({
    showPeriod: true,
    showLeadingZero: true,
	minutes: {
        starts: 0,                // First displayed minute
        ends: 45,                 // Last displayed minute
        interval: 15               // Interval of displayed minutes
    }
});
				$('#MonEndHr').timepicker({
    showPeriod: true,
    showLeadingZero: true,
	minutes: {
        starts: 0,                // First displayed minute
        ends: 45,                 // Last displayed minute
        interval: 15               // Interval of displayed minutes
    }
});
				$('#TuesBegHr').timepicker({
    showPeriod: true,
    showLeadingZero: true,
	minutes: {
        starts: 0,                // First displayed minute
        ends: 45,                 // Last displayed minute
        interval: 15               // Interval of displayed minutes
    }
});
				$('#TuesEndHr').timepicker({
    showPeriod: true,
    showLeadingZero: true,
	minutes: {
        starts: 0,                // First displayed minute
        ends: 45,                 // Last displayed minute
        interval: 15               // Interval of displayed minutes
    }
});
				$('#WedBegHr').timepicker({
    showPeriod: true,
    showLeadingZero: true,
	minutes: {
        starts: 0,                // First displayed minute
        ends: 45,                 // Last displayed minute
        interval: 15               // Interval of displayed minutes
    }
});
				$('#WedEndHr').timepicker({
    showPeriod: true,
    showLeadingZero: true,
	minutes: {
        starts: 0,                // First displayed minute
        ends: 45,                 // Last displayed minute
        interval: 15               // Interval of displayed minutes
    }
});
				$('#ThursBegHr').timepicker({
    showPeriod: true,
    showLeadingZero: true,
	minutes: {
        starts: 0,                // First displayed minute
        ends: 45,                 // Last displayed minute
        interval: 15               // Interval of displayed minutes
    }
});
				$('#ThursEndHr').timepicker({
    showPeriod: true,
    showLeadingZero: true,
	minutes: {
        starts: 0,                // First displayed minute
        ends: 45,                 // Last displayed minute
        interval: 15               // Interval of displayed minutes
    }
});
				$('#FriBegHr').timepicker({
    showPeriod: true,
    showLeadingZero: true,
	minutes: {
        starts: 0,                // First displayed minute
        ends: 45,                 // Last displayed minute
        interval: 15               // Interval of displayed minutes
    }
});
				$('#FriEndHr').timepicker({
    showPeriod: true,
    showLeadingZero: true,
	minutes: {
        starts: 0,                // First displayed minute
        ends: 45,                 // Last displayed minute
        interval: 15               // Interval of displayed minutes
    }
});
				$('#SatBegHr').timepicker({
    showPeriod: true,
    showLeadingZero: true,
	minutes: {
        starts: 0,                // First displayed minute
        ends: 45,                 // Last displayed minute
        interval: 15               // Interval of displayed minutes
    }
});
				$('#SatEndHr').timepicker({
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