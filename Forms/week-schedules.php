<?php
// protection de page ADMIN
	include_once('../Admin/fonctions/_protectpage.php');
	include_once('../Admin/fonctions/functions.php');
// **************************************
// Parametres de Connexion a la BD
	include_once('../connexion.php');
// **************************************
	include_once('../Model/class.schedules.php');
	include_once("../Model/class.post.php");	
	include_once("../Model/class.person.php");
	
	include_once('../Model/class.sunday.php');
	include_once('../Model/class.monday.php');
	include_once('../Model/class.tuesday.php');
	include_once('../Model/class.wednesday.php');
	include_once('../Model/class.thursday.php');
	include_once('../Model/class.friday.php');
	include_once('../Model/class.saturday.php');
	
	$IdDept = $_SESSION["IdDept"];
	
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

	<title>Shift-Scheduler.com | SCHEDULES OF THE WEEK</title>
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

<h1>SCHEDULES OF THE WEEK</h1>

<br/>

<!-- lien retour -->
<div class="VALIDATION-FINALE">
<a class="red button" href="../admin.php#nice2"><img src="../Admin/icones/arrow_back.png" alt="" /> Go Back</a>
</div>

<?php

	$day = strtotime(date("Y-m-d"));
		
	$Sunday = strtotime(first_day_of_week ($day));
	$Monday = strtotime("+1 days",$Sunday);
	$Tuesday = strtotime("+2 days",$Sunday);
	$Wednesday = strtotime("+3 days",$Sunday);
	$Thursday = strtotime("+4 days",$Sunday);
	$Friday = strtotime("+5 days",$Sunday);
	$Saturday =  strtotime("+6 days",$Sunday);
	
		?>
 
<br/>

<div class="row">
	<div class="twelve columns centered">
		<div class="panel">

		
	<table>
			<thead>
			<tr>
				<td></td>
				<th style="border:thin dotted #666666; padding:5px;">Sunday<br/><?php echo date('M j',$Sunday);?></th>
				<th style="border:thin dotted #666666; padding:5px;">Monday<br/><?php echo date('M j',$Monday);?></th>
				<th style="border:thin dotted #666666; padding:5px;">Tuesday<br/><?php echo date('M j',$Tuesday);?></th>
				<th style="border:thin dotted #666666; padding:5px;">Wednesday<br/><?php echo date('M j',$Wednesday);?></th>
				<th style="border:thin dotted #666666; padding:5px;">Thursday<br/><?php echo date('M j',$Thursday);?></th>
				<th style="border:thin dotted #666666; padding:5px;">Friday<br/><?php echo date('M j',$Friday);?></th>
				<th style="border:thin dotted #666666; padding:5px;">Saturday<br/><?php echo date('M j',$Saturday);?></th>
				<td style="border:thin dotted #666666; padding:5px; width:6%">Hours</td>
			</tr>
			</thead>

<?php
	$post_query = "SELECT * FROM post WHERE IdDept = '".$IdDept."' ORDER BY LabPost ASC";
	$post_result = mysql_query($post_query) or die('Erreur SQL :<br />'.$post_query.'<br />'.mysql_error());
	 while ($post_row = mysql_fetch_array($post_result))
		{
			$postID  = 	stripslashes($post_row['IdPost']);
			$postLab = 	stripslashes($post_row['LabPost']);
?>
			
			<tr style="border:1px dashed #CCCCCC; text-align:center;"> <td colspan="9"><h4 style="text-align:center"><?php echo $postLab; ?></h4></td></tr>
<?php
 // Retrieve the name of the employees
	 $pers_query = "SELECT * FROM person
               WHERE IdPost = '".$postID."'
			   ORDER BY LastName";
	 $pers_result = mysql_query($pers_query) or die('Erreur SQL :<br />'.$pers_query.'<br />'.mysql_error());
	 $pers_num = mysql_num_rows($pers_result);
	 
if ($pers_num > 0)
	{
	while ($pers_row = mysql_fetch_array($pers_result))
	{
	$persID = 	stripslashes($pers_row['IdPers']);
	$FirstName = stripslashes($pers_row['FirstName']);
	$LastName = stripslashes($pers_row['LastName']);
	$WorkHrs = stripslashes($pers_row['WorkHrs']);
	$cnt = 0;

?>			
			<tr>
				<th style="border:thin dotted #666666; padding:5px;"><?php echo $FirstName." ".$LastName; ?></th>
				
<?php
//Sunday
	$sun_query = "SELECT * FROM schedules WHERE Day='".date('Y-m-d',$Sunday)."' AND IdPers = '".$persID."' ";
	$sun_result = mysql_query($sun_query) or die('Erreur SQL :<br />'.$sun_query.'<br />'.mysql_error());
	$nb_sun = mysql_num_rows($sun_result);
	
if ($nb_sun > 0)
	{
	while ($sun_row = mysql_fetch_array($sun_result))
	{
	$BegShift = stripslashes($sun_row['BegShift']);
	$EndShift = stripslashes($sun_row['EndShift']);
	
	$X = strtotime($BegShift) ;
	$Y = strtotime($EndShift);
			
	if ($X > $Y)
		{
			$hours = strtotime("+1 day");
			$temp = dateDiff($X, $Y) ;
			$for =  dateDiff($hours, $temp) ;
		}
	else $for =  dateDiff($X, $Y) ;
	$cnt = $cnt + $for ;
	
?>
			  	<td style="border:thin dotted #666666; padding:5px;"><?php echo $BegShift." - ".$EndShift; ?></td>
<?php
	} // End while
	} // End if
elseif ($nb_sun == 0)
	{
	$BegShift = '';
	$EndShift = '';
	
	$for =  dateDiff($BegShift, $EndShift) ;
	?>
			  	<td style="border:thin dotted #666666; padding:5px;"><?php echo $BegShift." - ".$EndShift; ?></td>
<?php
} // end elseif

//Monday
$mon_query = "SELECT * FROM schedules WHERE Day='".date('Y-m-d',$Monday)."' AND IdPers = '".$persID."' ";
	$mon_result = mysql_query($mon_query) or die('Erreur SQL :<br />'.$mon_query.'<br />'.mysql_error());
	$nb_mon = mysql_num_rows($mon_result);
	
if ($nb_mon > 0)
	{
	while ($mon_row = mysql_fetch_array($mon_result))
	{
	$BegShift = stripslashes($mon_row['BegShift']);
	$EndShift = stripslashes($mon_row['EndShift']);
	
	$X = strtotime($BegShift) ;
	$Y = strtotime($EndShift);
			
	if ($X > $Y)
		{
			$hours = strtotime("+1 day");
			$temp = dateDiff($X, $Y) ;
			$for =  dateDiff($hours, $temp) ;
		}
	else $for =  dateDiff($X, $Y) ;
	$cnt = $cnt + $for ;
	
?>
			  	<td style="border:thin dotted #666666; padding:5px;"><?php echo $BegShift." - ".$EndShift; ?></td>
<?php
	} // End while
	} // End if
elseif ($nb_mon == 0)
	{
	$BegShift = '';
	$EndShift = '';
	
	$for =  dateDiff($BegShift, $EndShift) ;
	?>
			  	<td style="border:thin dotted #666666; padding:5px;"><?php echo $BegShift." - ".$EndShift; ?></td>
<?php
} // end elseif


//Tuesday
$tues_query = "SELECT * FROM schedules WHERE Day='".date('Y-m-d',$Tuesday)."' AND IdPers = '".$persID."' ";
	$tues_result = mysql_query($tues_query) or die('Erreur SQL :<br />'.$tues_query.'<br />'.mysql_error());
	$nb_tues = mysql_num_rows($tues_result);
	
if ($nb_tues > 0)
	{
	while ($tues_row = mysql_fetch_array($tues_result))
	{
	$BegShift = stripslashes($tues_row['BegShift']);
	$EndShift = stripslashes($tues_row['EndShift']);
	
	$X = strtotime($BegShift) ;
	$Y = strtotime($EndShift);
			
	if ($X > $Y)
		{
			$hours = strtotime("+1 day");
			$temp = dateDiff($X, $Y) ;
			$for =  dateDiff($hours, $temp) ;
		}
	else $for =  dateDiff($X, $Y) ;
	$cnt = $cnt + $for ;
	
?>
			  	<td style="border:thin dotted #666666; padding:5px;"><?php echo $BegShift." - ".$EndShift; ?></td>
<?php
	} // End while
	} // End if
elseif ($nb_tues == 0)
	{
	$BegShift = '';
	$EndShift = '';
	
	$for =  dateDiff($BegShift, $EndShift) ;
	?>
			  	<td style="border:thin dotted #666666; padding:5px;"><?php echo $BegShift." - ".$EndShift; ?></td>
<?php
} // end elseif

//Wednesday
	$wed_query = "SELECT * FROM schedules WHERE Day='".date('Y-m-d',$Wednesday)."' AND IdPers = '".$persID."' ";
	$wed_result = mysql_query($wed_query) or die('Erreur SQL :<br />'.$wed_query.'<br />'.mysql_error());
	$nb_wed = mysql_num_rows($wed_result);
	
if ($nb_wed > 0)
	{
	while ($wed_row = mysql_fetch_array($wed_result))
	{
	$BegShift = stripslashes($wed_row['BegShift']);
	$EndShift = stripslashes($wed_row['EndShift']);
	
	$X = strtotime($BegShift) ;
	$Y = strtotime($EndShift);
			
	if ($X > $Y)
		{
			$hours = strtotime("+1 day");
			$temp = dateDiff($X, $Y) ;
			$for =  dateDiff($hours, $temp) ;
		}
	else $for =  dateDiff($X, $Y) ;
	$cnt = $cnt + $for ;
	
?>
			  	<td style="border:thin dotted #666666; padding:5px;"><?php echo $BegShift." - ".$EndShift; ?></td>
<?php
	} // End while
	} // End if
elseif ($nb_wed == 0)
	{
	$BegShift = '';
	$EndShift = '';
	
	$for =  dateDiff($BegShift, $EndShift) ;
	?>
			  	<td style="border:thin dotted #666666; padding:5px;"><?php echo $BegShift." - ".$EndShift; ?></td>
<?php
} // end elseif

//Thursday
	$thurs_query = "SELECT * FROM schedules WHERE Day='".date('Y-m-d',$Thursday)."' AND IdPers = '".$persID."' ";
	$thurs_result = mysql_query($thurs_query) or die('Erreur SQL :<br />'.$thurs_query.'<br />'.mysql_error());
	$nb_thurs = mysql_num_rows($thurs_result);
	
if ($nb_thurs > 0)
	{
	while ($thurs_row = mysql_fetch_array($thurs_result))
	{
	$BegShift = stripslashes($thurs_row['BegShift']);
	$EndShift = stripslashes($thurs_row['EndShift']);
	
	$X = strtotime($BegShift) ;
	$Y = strtotime($EndShift);
			
	if ($X > $Y)
		{
			$hours = strtotime("+1 day");
			$temp = dateDiff($X, $Y) ;
			$for =  dateDiff($hours, $temp) ;
		}
	else $for =  dateDiff($X, $Y) ;
	$cnt = $cnt + $for ;
	
?>
			  	<td style="border:thin dotted #666666; padding:5px;"><?php echo $BegShift." - ".$EndShift; ?></td>
<?php
	} // End while
	} // End if
elseif ($nb_thurs == 0)
	{
	$BegShift = '';
	$EndShift = '';
	
	$for =  dateDiff($BegShift, $EndShift) ;
	?>
			  	<td style="border:thin dotted #666666; padding:5px;"><?php echo $BegShift." - ".$EndShift; ?></td>
<?php
} // end elseif


//Friday
	$fri_query = "SELECT * FROM schedules WHERE Day='".date('Y-m-d',$Friday)."' AND IdPers = '".$persID."' ";
	$fri_result = mysql_query($fri_query) or die('Erreur SQL :<br />'.$fri_query.'<br />'.mysql_error());
	$nb_fri = mysql_num_rows($fri_result);
	
if ($nb_fri > 0)
	{
	while ($fri_row = mysql_fetch_array($fri_result))
	{
	$BegShift = stripslashes($fri_row['BegShift']);
	$EndShift = stripslashes($fri_row['EndShift']);
	
	
	$X = strtotime($BegShift) ;
	$Y = strtotime($EndShift);
			
	if ($X > $Y)
		{
			$hours = strtotime("+1 day");
			$temp = dateDiff($X, $Y) ;
			$for =  dateDiff($hours, $temp) ;
		}
	else $for =  dateDiff($X, $Y) ;
	
	$cnt = $cnt + $for ;
	
?>
			  	<td style="border:thin dotted #666666; padding:5px;"><?php echo $BegShift." - ".$EndShift; ?></td>
<?php
	} // End while
	} // End if
elseif ($nb_fri == 0)
	{
	$BegShift = '';
	$EndShift = '';
	
	$for =  dateDiff($BegShift, $EndShift) ;
	?>
			  	<td style="border:thin dotted #666666; padding:5px;"><?php echo $BegShift." - ".$EndShift; ?></td>
<?php
} // end elseif

//saturday
	$sat_query = "SELECT * FROM schedules WHERE Day='".date('Y-m-d',$Saturday)."' AND IdPers = '".$persID."' ";
	$sat_result = mysql_query($sat_query) or die('Erreur SQL :<br />'.$sat_query.'<br />'.mysql_error());
	$nb_sat = mysql_num_rows($sat_result);
	
if ($nb_sat > 0)
	{
	while ($sat_row = mysql_fetch_array($sat_result))
	{
	$BegShift = stripslashes($sat_row['BegShift']);
	$EndShift = stripslashes($sat_row['EndShift']);
	
	$X = strtotime($BegShift) ;
	$Y = strtotime($EndShift);
			
	if ($X > $Y)
		{
			$hours = strtotime("+1 day");
			$temp = dateDiff($X, $Y) ;
			$for =  dateDiff($hours, $temp) ;
		}
	else $for =  dateDiff($X, $Y) ;
	$cnt = $cnt + $for ;
	
?>
			  	<td style="border:thin dotted #666666; padding:5px;"><?php echo $BegShift." - ".$EndShift; ?></td>
<?php
	} // End while
	} // End if
elseif ($nb_sat == 0)
	{
	$BegShift = '';
	$EndShift = '';
	
	$for =  dateDiff($BegShift, $EndShift) ;
	?>
			  	<td style="border:thin dotted #666666; padding:5px;"><?php echo $BegShift." - ".$EndShift; ?></td>
<?php
} // end elseif

?>
			
				<td style="border:thin dotted #666666; padding:5px;"><?php echo $cnt." / ".$WorkHrs; ?></td>
			</tr>
<?php
} // end while pers row
}// end if pers
else { // no person
?>
 	<tr><td colspan="9" style="border:thin dotted #666666; padding:5px;"><div align="center">No employee for now.</div></td></tr>
<?php
} // End else
} // end while post
?>			
</table>
			<br/>
<div style=" text-align:center;" align="center">
	<form method="post" name="formmodifier" action="print-schedules.php" target="_blank">
	<input type="hidden" name="day" value="<?php  echo $day; ?>" />
		<button name="btPrint" type="submit" title="Print event" class="medium button green">
		<img src="../Admin/icones/printer.png" alt="Print event" width="24" />Printable version</button>
	</form>
	</div>
<br/>
		</div> <!--End panel-->
	</div><!-- End 12 columns-->
</div><!--End row-->



<!-- lien retour -->
<div class="VALIDATION-FINALE">
<a href="../admin.php#nice2"><div class="large button red" ><img src="../Admin/icones/arrow_back.png" alt="" /> Go back</div></a>
</div>

</div>

<div id="footer"> <?php include("../footer.php");?></div>


	<!-- Included JS Files -->
	<!--<script src="../js/jquery.min.js"></script>-->
	<script src="../js/foundation.js"></script>
	<script src="../js/app.js"></script>


</body>
</html>