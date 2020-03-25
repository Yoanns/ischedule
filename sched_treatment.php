<?php
// protection de page ADMIN
   include_once('./Admin/fonctions/_protectpage.php');
// **************************************
// Parametres de Connexion a la BD
	include_once('connexion.php');
// **************************************
	include_once('Model/class.schedules.php');
	include_once('Model/class.week.php');
	include_once('Model/class.person.php');
	include_once('Model/class.post.php');
	include_once('Admin/fonctions/functions.php');
	
$traiter = '';
if (isset($_POST['traiter']) && ($_POST['traiter']=='SET' || $_POST['traiter']=='EDIT')){
	$traiter = mysql_real_escape_string($_POST['traiter']);
	
} else {
	// sinon retour a la liste
	header('location: ./admin.php#nice2');
	exit;
}

// -------------------------
// Traitement : SET
// -------------------------
if ($traiter == 'SET')
{
	 $IdPost = $_POST['IdPost'];
	 $Day = $_POST['Day'];
	 
	 $emp_query = "SELECT * FROM person WHERE IdPost = '$IdPost'";
	 $emp_result =  mysql_query($emp_query) or die('Erreur SQL :<br />'.$emp_query.'<br />'.mysql_error());
while ($emp_row = mysql_fetch_array($emp_result))
	{
		$persID = $emp_row["IdPers"];
		if ( (isset($_POST["Start".$persID])) && ($_POST["Start".$persID] != '') && (isset($_POST["End".$persID])) && ($_POST["End".$persID] != ''))
			{
				$BegShift = mysql_real_escape_string($_POST["Start".$persID]);
				$EndShift = mysql_real_escape_string($_POST["End".$persID]);
				$schedules = new schedules(null,null);
				$schedules -> AddSch($persID,$Day,$BegShift,$EndShift);
			
			}
	}

}

elseif ($traiter == 'EDIT')
{
	$persID = mysql_real_escape_string($_POST['persID']);
	$day = mysql_real_escape_string($_POST['Day']);
	if ( (isset($_POST["Start".$persID])) && ($_POST["Start".$persID] != '') && (isset($_POST["End".$persID])) && ($_POST["End".$persID] != ''))
			{
				$BegShift = mysql_real_escape_string($_POST["Start".$persID]);
				$EndShift = mysql_real_escape_string($_POST["End".$persID]);
				$schedules = new schedules($persID,$day);
				$schedules -> EditSch($persID,$day,$BegShift,$EndShift);
			
			}
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

	<title>Shift-Scheduler.com | Setting the schedules</title>
	<link rel="shortcut icon" type="image/x-icon" href="./Admin/icones/ischedule_logo1.ico">
  
	<!-- Included CSS Files -->
	<link rel="stylesheet" href="css/foundation.css">
	<link rel="stylesheet" href="css/app.css">
	<link rel="stylesheet" media="screen" type="text/css" href="Admin/css_adm/news_ADM_style.css" />

	<!--[if lt IE 9]>
		<link rel="stylesheet" href="./css/ie.css">
	<![endif]-->
	
	<script src="js/modernizr.foundation.js"></script>

	<!-- IE Fix for HTML5 Tags -->
	<!--[if lt IE 9]>
		<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
</head>

<body>
<div id="containercentrer">

<h1>ADMINISTRATION OF SCHEDULES</h1>

<div class="containercentrer">
<?php


if ($traiter == 'SET') {
	
	$post = new post($IdPost);
	$LabPost = $post ->LabPost;
		?>
	
 <div id="container">
<div class="row">
<div class="alert-box centered success">
	<?php echo $LabPost;?>'s schedules successfully set.
	<a href="" class="close">&times;</a>
</div>
</div>
</div><br/>
<table width="80%">
			<thead>
			<tr>
				<td width="50%"></td>
				<th>Start of shift</th>
				<th>End of shift</th>
				<td></td>
			</tr>
			</thead>
<?php
$pers_query = "SELECT * FROM person
               WHERE IdPost = '".$IdPost."'
			   AND IdPers IN (SELECT IdPers FROM schedules WHERE Day='".$Day."')
			   ORDER BY LastName";
	 $pers_result = mysql_query($pers_query) or die('Erreur SQL :<br />'.$pers_query.'<br />'.mysql_error());
	
	
	while ($pers_row = mysql_fetch_array($pers_result))
	{
	$persID = 	stripslashes($pers_row['IdPers']);
	$FirstName = stripslashes($pers_row['FirstName']);
	$LastName = stripslashes($pers_row['LastName']);
	
	$sched_query = "SELECT * FROM schedules WHERE Day='".$Day."' AND IdPers = '".$persID."' ";
	$sched_result = mysql_query($sched_query) or die('Erreur SQL :<br />'.$sched_query.'<br />'.mysql_error());
	$nb_sched = mysql_num_rows($sched_result);
	
if ($nb_sched > 0)
	{
	while ($sched_row = mysql_fetch_array($sched_result))
	{
	$BegShift = stripslashes($sched_row['BegShift']);
	$EndShift = stripslashes($sched_row['EndShift']);
	
	$X = strtotime($BegShift) ;
	$Y = strtotime($EndShift);
			
	if ($X > $Y)
		{
			$hours = strtotime("+1 day");
			$temp = dateDiff($X, $Y) ;
			$for =  dateDiff($hours, $temp) ;
		}
	else $for =  dateDiff($X, $Y) ;
		
		?>		
	
			<tr style="border:1px dashed #CCCCCC">
				<th><?php echo $FirstName." ".$LastName; ?></th>
			  	<td><?php echo $BegShift; ?></td>
				<td><?php echo $EndShift; ?></td>
				<td><?php echo $for; ?></td>
			</tr>
			<?php
			
		} // Fin de la boucle	
		
	}// end if $nb_sched > 0
	elseif ($nb_sched == 0) 
		{ ?>
			<tr style="border:1px dashed #CCCCCC">
				<td colspan="8"> <div align="center">No schedule has been set for that day.</div></td>
			</tr>
			
			<?php
			}		
		} //End While $pers_row	
					
			?>
			</table>
		<br/>
		<div align="center">
<form method="post" name="formvoirFiche" action="./Forms/set-schedules.php">
		<input type="hidden" name="traiter" value="SET" />
		<button name="btAddSch" class="nice medium green button" type="submit" title="Set the schedules">
		<img src="Admin/icones/calendar_add.png" alt="Set the schedules" width="24"/>Set more schedules</button>
	</form>
</div>

		<?php 
		
	}
		
if ($traiter == 'EDIT') {

?>
	<div id="container">
<div class="row">
<div class="alert-box centered success">
	The schedule has been successfully edited.
	<a href="" class="close">&times;</a>
</div>
</div>
</div><br/>
<table width="80%">
			<thead>
			<tr>
				<td width="50%"></td>
				<th>Start of shift</th>
				<th>End of shift</th>
				<td></td>
			</tr>
			</thead>
<?php

	$sched_query = "SELECT * FROM schedules WHERE Day='".$day."' AND IdPers = '".$persID."' ";
	$sched_result = mysql_query($sched_query) or die('Erreur SQL :<br />'.$sched_query.'<br />'.mysql_error());
	
	while ($sched_row = mysql_fetch_array($sched_result))
	{
	$BegShift = stripslashes($sched_row['BegShift']);
	$EndShift = stripslashes($sched_row['EndShift']);
	
	$X = strtotime($BegShift) ;
	$Y = strtotime($EndShift);
			
	if ($X > $Y)
		{
			$hours = strtotime("+1 day");
			$temp = dateDiff($X, $Y) ;
			$for =  dateDiff($hours, $temp) ;
		}
	else $for =  dateDiff($X, $Y) ;
	
	$person = new person($persID);
	$FirstName = $person -> FirstName;
	$LastName = $person -> LastName;
		
		?>		
	
			<tr style="border:1px dashed #CCCCCC">
				<th><?php echo $FirstName." ".$LastName; ?></th>
			  	<td><?php echo $BegShift; ?></td>
				<td><?php echo $EndShift; ?></td>
				<td><?php echo $for; ?></td>
				
			</tr>
			<?php
			
		} // Fin de la boucle	
		
		?>
			</table>
		
		<?php 
	
}		
?>
</div>

<!-- lien retour -->
<div class="VALIDATION-FINALE">
<a href="./admin.php#nice2"><div class="large button red" ><img src="./Admin/icones/arrow_back.png" alt="" /> Go back</div></a>
</div>

</div>

<div id="footer"> <?php include("footer.php");?></div>


	<!-- Included JS Files -->
	<script src="js/jquery.min.js"></script>
	<script src="js/foundation.js"></script>
	<script src="js/app.js"></script>

</body>
</html>