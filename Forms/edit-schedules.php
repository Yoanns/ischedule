<?php
// protection de page ADMIN
   include_once('../Admin/fonctions/_protectpage.php');
// **************************************
// Parametres de Connexion a la BD
	include_once('../connexion.php');
	// On recupere l URL de la page d'origine
	//$nomPageOrigine = $_SERVER["HTTP_REFERER"];
	
	include_once("../Model/class.schedules.php");	
	include_once("../Model/class.event.php");
	include_once("../Model/class.post.php");	
	include_once("../Model/class.person.php");
	
	include_once('../Model/class.sunday.php');
	include_once('../Model/class.monday.php');
	include_once('../Model/class.tuesday.php');
	include_once('../Model/class.wednesday.php');
	include_once('../Model/class.thursday.php');
	include_once('../Model/class.friday.php');
	include_once('../Model/class.saturday.php');

$traiter = '';
if (isset($_POST['traiter']) && ($_POST['traiter']=='EDIT')){
	$traiter = $_POST['traiter'];
	$persID = mysql_real_escape_string($_POST['persID']);
	$Day = mysql_real_escape_string($_POST['Day']);
	$IdPost = mysql_real_escape_string($_POST['IdPost']);
} else {
	// sinon retour a la liste
	header('location: ../admin.php#nice2');
	exit;
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
	<title>Shift-Scheduler.com | Editing schedules</title>
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
   
   	
		
		<script type="text/javascript" src="../js/jquery-1.7.2.min.js"></script>
		<script type="text/javascript" src="../js/jquery-ui-1.8.20.custom.min.js"></script>

				
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

<h1>Editing schedules</h1>

<div class="clearfix"></div>
<br />

<div class="row">
	<div class="twelve columns">
			<div class="panel">
	<table>
			<tr> 
				<th>
<?php 
		
		
	  	if(!empty($Day))
	  	{
	  		
			$day = strtotime($Day);
			$theday = date("l M j, Y",$day);
						
			 echo "Editing the schedule for <strong>".$theday."</strong>" ;
			 
		}
		
		
			 ?> 
			 
			 </th>
			</tr>
		</table>
<div class="clearfix"></div>		
	<br/>

<div class="panel">
	<div class="row">
		<div class="twelve centered columns">	
<?php
	$post = new post($IdPost);
	$postLabel = $post ->LabPost;
?>
<h3><?php echo $postLabel; ?></h3>


<form name="FormSet" method="post" action="../sched_treatment.php">
	<input type="hidden" name="traiter" value="<?php echo $traiter; ?>" />
	<input type="hidden" name="IdPost" value="<?php echo $IdPost; ?>" />
	<input type="hidden" name="Day" value="<?php echo $Day; ?>" />
	<input type="hidden" name="persID" value="<?php  echo $persID; ?>" />
		
		<br/>
		
		<table>
			<thead>
			<tr style="border:thin dotted #666666; padding:5px;">
				<td width="30%"></td>
				<th>Start of shift</th>
				<th>End of shift</th>
				<th>Work hours per week</th>
			</tr>
			</thead>
	<?php
			
						$employee = new person($persID);
						$persFirstName	= 	$employee -> FirstName;
						$persLastName	= 	$employee -> LastName;
						$persWorkHrs	= 	$employee -> WorkHrs;
						$IdDept			=	$_SESSION["IdDept"];
						$IdPost 		= 	$employee -> IdPost;
						
						$shift_query = "SELECT * FROM schedules WHERE IdPers = '$persID' AND Day = '$Day'" ;
						$shift_result =  mysql_query($shift_query) or die('SQL Error :<br />'.$shift_query.'<br />'.mysql_error());
						
						while ($shift_row = mysql_fetch_array($shift_result))
							{						
								$from = $shift_row[2];
								$to = $shift_row[3];
							}

	
	?>		
			<tr style="border:thin dotted #666666; padding:5px;">
				<th><?php echo $persLastName.", ".$persFirstName; ?></th>
			    <td><input name="Start<?php echo $persID ;?>" type="text"  id="Start<?php echo $persID ;?>" style="width: 100px;" value="<?php echo $from ;?>" required = "required"/>       </td>
				<td><input name="End<?php echo $persID ;?>" type="text" id="End<?php echo $persID ;?>" style="width: 100px;" value="<?php echo $to ;?>" required = "required"/></td>
				<td><?php echo $persWorkHrs ;?></td>
			</tr>
<script type="text/javascript">
            $(document).ready(function() {
                $('#Start<?php echo $persID ;?>').timepicker({
    showPeriod: true,
    showLeadingZero: true,
	minutes: {
        starts: 0,                // First displayed minute
        ends: 45,                 // Last displayed minute
        interval: 15               // Interval of displayed minutes
    }
});
				$('#End<?php echo $persID ;?>').timepicker({
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
		
			<tr>
				<!--<td>				</td>-->
				<td colspan="6" style="padding:5px;">
                    <button name="setsc" type="submit" value="<?php echo $traiter; ?>" class="medium button blue" style="margin:5px; vertical-align:middle;"><img src="../Admin/icones/calendar_add.png" alt="" width="24" /><?php echo $traiter; ?> the schedules </button>	
					<a href="../admin.php#nice2" style="margin:5px; vertical-align:middle;"><div class="medium button red"><img src="../Admin/icones/ANNULER.png" alt="" /> Cancel</div> </a>
				</td>
			</tr>
		</table><br/>
	</form>
		</div><!--End div 12 cols-->
	</div><!--End div row-->
</div><!--End div panel-->


</div> <!--End div containercentrer-->

<!-- lien retour -->
<div class="VALIDATION-FINALE">
<a href="../admin.php#nice2"><div class="large button red" ><img src="../Admin/icones/arrow_back.png" alt="" /> Go back</div></a>	
</div>

<div id="footer"> <?php include("../footer.php");?></div>


	<!-- Included JS Files -->
	<!--<script src="../js/jquery.min.js"></script>-->
	<script src="../js/foundation.js"></script>
	<script src="../js/app.js"></script>


</body>
</html>