<?php
// protection de page ADMIN
	include_once('../Admin/fonctions/_protectpageadm.php');
	include_once('../Admin/fonctions/functions.php');
// **************************************
// Parametres de Connexion a la BD
	include_once('../connexion.php');
// **************************************
	include_once('../Model/class.event.php');
	include_once("../Model/class.person.php");
	include_once("../Model/class.location.php");
	include_once("../Model/class.department.php");
	
	include_once('../Model/class.sunday.php');
	include_once('../Model/class.monday.php');
	include_once('../Model/class.tuesday.php');
	include_once('../Model/class.wednesday.php');
	include_once('../Model/class.thursday.php');
	include_once('../Model/class.friday.php');
	include_once('../Model/class.saturday.php');
	
	$IdDept = $_SESSION["IdDept"];
	$Department = new department($IdDept);
	$IdLoc = $Department -> IdLoc;
	
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

	<title>Shift-Scheduler.com | EVENTS OF THE WEEK</title>
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

<h1>EVENTS OF THE WEEK</h1>

<!--<br/>

<!-- lien retour->
<div class="VALIDATION-FINALE">
<a class="red button" href="../admin.php#nice1"><img src="../Admin/icones/arrow_back.png" alt="" /> Go Back</a>
</div>
-->
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
				<th style="border:thin dashed #666666; padding:5px;">Sunday<br/><?php echo date('M j',$Sunday);?></th>
				<th style="border:thin dashed #666666; padding:5px;">Monday<br/><?php echo date('M j',$Monday);?></th>
				<th style="border:thin dashed #666666; padding:5px;">Tuesday<br/><?php echo date('M j',$Tuesday);?></th>
				<th style="border:thin dashed #666666; padding:5px;">Wednesday<br/><?php echo date('M j',$Wednesday);?></th>
				<th style="border:thin dashed #666666; padding:5px;">Thursday<br/><?php echo date('M j',$Thursday);?></th>
				<th style="border:thin dashed #666666; padding:5px;">Friday<br/><?php echo date('M j',$Friday);?></th>
				<th style="border:thin dashed #666666; padding:5px;">Saturday<br/><?php echo date('M j',$Saturday);?></th>
			</tr>
		</thead>
		
		<tbody>
			<tr>
				<td style="border:thin dashed #666666; padding:5px;">
<?php

	$evt = new event(null);
	
//Sunday
		$SundayEvt = $evt -> DayEventsAdm(date("Y-m-d",$Sunday));
		$nb_Sun = mysql_num_rows($SundayEvt);
	
if ($nb_Sun > 0)
	{
		?>
		<table style="border:none;">
		
		<?php
	while ($Sun_row = mysql_fetch_array($SundayEvt))
	{
		$IdEvt = stripslashes($Sun_row['IdEvt']);
		$NameEvt	=	stripslashes($Sun_row['NameEvt']);
		$GuestEvt	=	stripslashes($Sun_row['GuestEvt']);
		$DescEvt	=	stripslashes($Sun_row['DescEvt']);
		$DayEvt	=	stripslashes($Sun_row['DayEvt']);
		$BegEvt	=	stripslashes($Sun_row['BegEvt']);
		$EndEvt	=	stripslashes($Sun_row['EndEvt']);
		$IdLoc = 	stripslashes($Sun_row['IdLoc']);
			
			$Loc = new location($IdLoc);
			$NameLoc = $Loc -> NameLoc;
		
		$X = strtotime($BegEvt) ;
			$Y = strtotime($EndEvt);
			
	if ($X > $Y)
		{
			$hours = strtotime("+1 day");
			$temp = dateDiff($X, $Y) ;
			$duration =  dateDiff($hours, $temp) ;
		}
	elseif ($X <= $Y) $duration =  dateDiff($X, $Y) ;
	
?>
			  <tr>
				<td><a href="" data-reveal-id="myModal<?php  echo $IdEvt; ?>" data-animation="fadeAndPop" data-animationspeed="300" data-closeonbackgroundclick="true" data-dismissmodalclass="close-reveal-modal"><?php echo $NameEvt; ?></a></td>
			</tr>

	<div id="myModal<?php  echo $IdEvt; ?>" class="xlarge reveal-modal">
     <h2>Description of the event "<?php echo $NameEvt; ?>"</h2>
<div class="row">
	<div class="twelve centered columns">
	 <p>The event will host about <strong><?php echo $GuestEvt; ?></strong> guest<?php if ($GuestEvt > 1) echo 's'; ?> at <?php echo $NameLoc; ?> from <strong><?php echo $BegEvt; ?></strong> to <strong><?php echo $EndEvt; ?></strong> (About <strong><?php echo $duration; ?></strong>)</p>
     <p><strong style=" color:#21409A;">Description:</strong> <br/><?php if ($DescEvt != '') echo $DescEvt; else echo "No description for this event."; ?></p>
	 </div>
</div>
     <a class="close-reveal-modal">&#215;</a></div>
	 
	 
<?php
	} // End while
	?>
	</table>
<?php
	} // End if
elseif ($nb_Sun == 0)
	{
		echo "No event this day.";
	} // end elseif
?>
				</td>
				
				<td style="border:thin dashed #666666; padding:5px;">
<?php
//Monday
$MondayEvt = $evt -> DayEventsAdm(date("Y-m-d",$Monday));
$nb_Mon = mysql_num_rows($MondayEvt);
	
if ($nb_Mon > 0)
	{
		?>
		<table style="border:none;">
		
		<?php

	while ($Mon_row = mysql_fetch_array($MondayEvt))
	{
		$IdEvt = stripslashes($Mon_row['IdEvt']);
		$NameEvt	=	stripslashes($Mon_row['NameEvt']);
		$GuestEvt	=	stripslashes($Mon_row['GuestEvt']);
		$DescEvt	=	stripslashes($Mon_row['DescEvt']);
		$DayEvt	=	stripslashes($Mon_row['DayEvt']);
		$BegEvt	=	stripslashes($Mon_row['BegEvt']);
		$EndEvt	=	stripslashes($Mon_row['EndEvt']);
		$IdLoc = 	stripslashes($Mon_row['IdLoc']);
			
			$Loc = new location($IdLoc);
			$NameLoc = $Loc -> NameLoc;
		
		
		$X = strtotime($BegEvt) ;
		$Y = strtotime($EndEvt);
			
	if ($X > $Y)
		{
			$hours = strtotime("+1 day");
			$temp = dateDiff($X, $Y) ;
			$duration =  dateDiff($hours, $temp) ;
		}
	elseif ($X <= $Y) $duration =  dateDiff($X, $Y) ;
	
?>
			  <tr>
				<td><a href="" data-reveal-id="myModal<?php  echo $IdEvt; ?>" data-animation="fadeAndPop" data-animationspeed="300" data-closeonbackgroundclick="true" data-dismissmodalclass="close-reveal-modal"><?php echo $NameEvt; ?></a></td>
			</tr>
			
	<div id="myModal<?php  echo $IdEvt; ?>" class="xlarge reveal-modal">
     <h2>Description of the event "<?php echo $NameEvt; ?>"</h2>
<div class="row">
	<div class="twelve centered columns">
	 <p>The event will host about <strong><?php echo $GuestEvt; ?></strong> guest<?php if ($GuestEvt > 1) echo 's'; ?> at <?php echo $NameLoc; ?> from <strong><?php echo $BegEvt; ?></strong> to <strong><?php echo $EndEvt; ?></strong> (About <strong><?php echo $duration; ?></strong>)</p>
     <p><strong style=" color:#21409A;">Description:</strong> <br/><?php if ($DescEvt != '') echo $DescEvt; else echo "No description for this event."; ?></p>
	 </div>
</div>
     <a class="close-reveal-modal">&#215;</a></div>
	 
	 
<?php
	} // End while
	?>
	</table>
<?php

	} // End if
elseif ($nb_Mon == 0)
	{
		echo "No event this day.";
	} // end elseif
?>
				</td>
				
				<td style="border:thin dashed #666666; padding:5px;">
<?php


//Tuesday
$TuesdayEvt = $evt -> DayEventsAdm(date("Y-m-d",$Tuesday));
$nb_Tues = mysql_num_rows($TuesdayEvt);
	
if ($nb_Tues > 0)
	{
		?>
		<table style="border:none;">
		
		<?php

	while ($Tues_row = mysql_fetch_array($TuesdayEvt))
	{
		$IdEvt = stripslashes($Tues_row['IdEvt']);
		$NameEvt	=	stripslashes($Tues_row['NameEvt']);
		$GuestEvt	=	stripslashes($Tues_row['GuestEvt']);
		$DescEvt	=	stripslashes($Tues_row['DescEvt']);
		$DayEvt	=	stripslashes($Tues_row['DayEvt']);
		$BegEvt	=	stripslashes($Tues_row['BegEvt']);
		$EndEvt	=	stripslashes($Tues_row['EndEvt']);
		$IdLoc = 	stripslashes($Tues_row['IdLoc']);
			
			$Loc = new location($IdLoc);
			$NameLoc = $Loc -> NameLoc;
		
		
		$X = strtotime($BegEvt) ;
			$Y = strtotime($EndEvt);
			
	if ($X > $Y)
		{
			$hours = strtotime("+1 day");
			$temp = dateDiff($X, $Y) ;
			$duration =  dateDiff($hours, $temp) ;
		}
	elseif ($X <= $Y) $duration =  dateDiff($X, $Y) ;
	
?>
			  <tr>
				<td><a href="" data-reveal-id="myModal<?php  echo $IdEvt; ?>" data-animation="fadeAndPop" data-animationspeed="300" data-closeonbackgroundclick="true" data-dismissmodalclass="close-reveal-modal"><?php echo $NameEvt; ?></a></td>
			</tr>
				
	<div id="myModal<?php  echo $IdEvt; ?>" class="xlarge reveal-modal">
     <h2>Description of the event "<?php echo $NameEvt; ?>"</h2>
<div class="row">
	<div class="twelve centered columns">
	 <p>The event will host about <strong><?php echo $GuestEvt; ?></strong> guest<?php if ($GuestEvt > 1) echo 's'; ?> at <?php echo $NameLoc; ?> from <strong><?php echo $BegEvt; ?></strong> to <strong><?php echo $EndEvt; ?></strong> (About <strong><?php echo $duration; ?></strong>)</p>
     <p><strong style=" color:#21409A;">Description:</strong> <br/><?php if ($DescEvt != '') echo $DescEvt; else echo "No description for this event."; ?></p>
	 </div>
</div>
     <a class="close-reveal-modal">&#215;</a></div>
	 
<?php
	} // End while
	?>
	</table>
<?php

	} // End if
elseif ($nb_Tues == 0)
	{
		echo "No event this day.";
	} // end elseif
?>
				</td>
				
				<td style="border:thin dashed #666666; padding:5px;">
<?php

//Wednesday
	$WednesdayEvt = $evt -> DayEventsAdm(date("Y-m-d",$Wednesday));
$nb_Wed = mysql_num_rows($WednesdayEvt);
	
if ($nb_Wed > 0)
	{
		?>
		<table style="border:none;">
		
		<?php

	while ($Wed_row = mysql_fetch_array($WednesdayEvt))
	{
		$IdEvt = stripslashes($Wed_row['IdEvt']);
		$NameEvt	=	stripslashes($Wed_row['NameEvt']);
		$GuestEvt	=	stripslashes($Wed_row['GuestEvt']);
		$DescEvt	=	stripslashes($Wed_row['DescEvt']);
		$DayEvt	=	stripslashes($Wed_row['DayEvt']);
		$BegEvt	=	stripslashes($Wed_row['BegEvt']);
		$EndEvt	=	stripslashes($Wed_row['EndEvt']);
		$IdLoc = 	stripslashes($Wed_row['IdLoc']);
			
			$Loc = new location($IdLoc);
			$NameLoc = $Loc -> NameLoc;
		
		
		$X = strtotime($BegEvt) ;
			$Y = strtotime($EndEvt);
			
	if ($X > $Y)
		{
			$hours = strtotime("+1 day");
			$temp = dateDiff($X, $Y) ;
			$duration =  dateDiff($hours, $temp) ;
		}
	elseif ($X <= $Y) $duration =  dateDiff($X, $Y) ;
	
?>
			  <tr>
				<td><a href="" data-reveal-id="myModal<?php  echo $IdEvt; ?>" data-animation="fadeAndPop" data-animationspeed="300" data-closeonbackgroundclick="true" data-dismissmodalclass="close-reveal-modal"><?php echo $NameEvt; ?></a></td>
			</tr>
				
		<div id="myModal<?php  echo $IdEvt; ?>" class="xlarge reveal-modal">
     <h2>Description of the event "<?php echo $NameEvt; ?>"</h2>
<div class="row">
	<div class="twelve centered columns">
	 <p>The event will host about <strong><?php echo $GuestEvt; ?></strong> guest<?php if ($GuestEvt > 1) echo 's'; ?> at <?php echo $NameLoc; ?> from <strong><?php echo $BegEvt; ?></strong> to <strong><?php echo $EndEvt; ?></strong> (About <strong><?php echo $duration; ?></strong>)</p>
     <p><strong style=" color:#21409A;">Description:</strong> <br/><?php if ($DescEvt != '') echo $DescEvt; else echo "No description for this event."; ?></p>
	 </div>
</div>
     <a class="close-reveal-modal">&#215;</a></div>
	 
<?php
	} // End while
	?>
	</table>
<?php

	} // End if
elseif ($nb_Wed == 0)
	{
		echo "No event this day.";
	} // end elseif
?>
				</td>
				
				<td style="border:thin dashed #666666; padding:5px;">
<?php

//Thursday
	$ThursdayEvt = $evt -> DayEventsAdm(date("Y-m-d",$Thursday));
$nb_Thurs = mysql_num_rows($ThursdayEvt);
	
if ($nb_Thurs > 0)
	{
		?>
		<table style="border:none;">
		
		<?php

	while ($Thurs_row = mysql_fetch_array($ThursdayEvt))
	{
		$IdEvt = stripslashes($Thurs_row['IdEvt']);
		$NameEvt	=	stripslashes($Thurs_row['NameEvt']);
		$GuestEvt	=	stripslashes($Thurs_row['GuestEvt']);
		$DescEvt	=	stripslashes($Thurs_row['DescEvt']);
		$DayEvt	=	stripslashes($Thurs_row['DayEvt']);
		$BegEvt	=	stripslashes($Thurs_row['BegEvt']);
		$EndEvt	=	stripslashes($Thurs_row['EndEvt']);
		$IdLoc = 	stripslashes($Thurs_row['IdLoc']);
			
			$Loc = new location($IdLoc);
			$NameLoc = $Loc -> NameLoc;
		
		
		$X = strtotime($BegEvt) ;
			$Y = strtotime($EndEvt);
			
	if ($X > $Y)
		{
			$hours = strtotime("+1 day");
			$temp = dateDiff($X, $Y) ;
			$duration =  dateDiff($hours, $temp) ;
		}
	elseif ($X <= $Y) $duration =  dateDiff($X, $Y) ;
	
?>
			  <tr>
				<td><a href="" data-reveal-id="myModal<?php  echo $IdEvt; ?>" data-animation="fadeAndPop" data-animationspeed="300" data-closeonbackgroundclick="true" data-dismissmodalclass="close-reveal-modal"><?php echo $NameEvt; ?></a></td>
			</tr>
				
		<div id="myModal<?php  echo $IdEvt; ?>" class="xlarge reveal-modal">
     <h2>Description of the event "<?php echo $NameEvt; ?>"</h2>
<div class="row">
	<div class="twelve centered columns">
	 <p>The event will host about <strong><?php echo $GuestEvt; ?></strong> guest<?php if ($GuestEvt > 1) echo 's'; ?> at <?php echo $NameLoc; ?> from <strong><?php echo $BegEvt; ?></strong> to <strong><?php echo $EndEvt; ?></strong> (About <strong><?php echo $duration; ?></strong>)</p>
     <p><strong style=" color:#21409A;">Description:</strong> <br/><?php if ($DescEvt != '') echo $DescEvt; else echo "No description for this event."; ?></p>
	 </div>
</div>
     <a class="close-reveal-modal">&#215;</a></div>
	 
	 
<?php
	} // End while
	?>
	</table>
<?php

	} // End if
elseif ($nb_Thurs == 0)
	{
		echo "No event this day.";
	} // end elseif
?>
				</td>
				
				<td style="border:thin dashed #666666; padding:5px;">
<?php


//Friday
	$FridayEvt = $evt -> DayEventsAdm(date("Y-m-d",$Friday));
$nb_Fri = mysql_num_rows($FridayEvt);
	
if ($nb_Fri > 0)
	{
		?>
		<table style="border:none;">
		
		<?php

	while ($Fri_row = mysql_fetch_array($FridayEvt))
	{
		$IdEvt = stripslashes($Fri_row['IdEvt']);
		$NameEvt	=	stripslashes($Fri_row['NameEvt']);
		$GuestEvt	=	stripslashes($Fri_row['GuestEvt']);
		$DescEvt	=	stripslashes($Fri_row['DescEvt']);
		$DayEvt	=	stripslashes($Fri_row['DayEvt']);
		$BegEvt	=	stripslashes($Fri_row['BegEvt']);
		$EndEvt	=	stripslashes($Fri_row['EndEvt']);
		$IdLoc = 	stripslashes($Fri_row['IdLoc']);
			
			$Loc = new location($IdLoc);
			$NameLoc = $Loc -> NameLoc;
		
		
		$X = strtotime($BegEvt) ;
			$Y = strtotime($EndEvt);
			
	if ($X > $Y)
		{
			$hours = strtotime("+1 day");
			$temp = dateDiff($X, $Y) ;
			$duration =  dateDiff($hours, $temp) ;
		}
	elseif ($X <= $Y) $duration =  dateDiff($X, $Y) ;
	
?>
			  <tr>	
				<td><a href="" data-reveal-id="myModal<?php  echo $IdEvt; ?>" data-animation="fadeAndPop" data-animationspeed="300" data-closeonbackgroundclick="true" data-dismissmodalclass="close-reveal-modal"><?php echo $NameEvt; ?></a></td>
			</tr>
				
	<div id="myModal<?php  echo $IdEvt; ?>" class="xlarge reveal-modal">
     <h2>Description of the event "<?php echo $NameEvt; ?>"</h2>
<div class="row">
	<div class="twelve centered columns">
	 <p>The event will host about <strong><?php echo $GuestEvt; ?></strong> guest<?php if ($GuestEvt > 1) echo 's'; ?> at <?php echo $NameLoc; ?> from <strong><?php echo $BegEvt; ?></strong> to <strong><?php echo $EndEvt; ?></strong> (About <strong><?php echo $duration; ?></strong>)</p>
     <p><strong style=" color:#21409A;">Description:</strong> <br/><?php if ($DescEvt != '') echo $DescEvt; else echo "No description for this event."; ?></p>
	 </div>
</div>
     <a class="close-reveal-modal">&#215;</a></div>
	 
	 
<?php
	} // End while
	?>
	</table>
<?php

	} // End if
elseif ($nb_Fri == 0)
	{
		echo "No event this day.";
	} // end elseif
?>
				</td>
				
				<td style="border:thin dashed #666666; padding:5px;">
<?php


//Saturday
	$SaturdayEvt = $evt -> DayEventsAdm(date("Y-m-d",$Saturday));
$nb_Sat = mysql_num_rows($SaturdayEvt);
	
if ($nb_Sat > 0)
	{
		?>
		<table style="border:none;">
		
		<?php

	while ($Sat_row = mysql_fetch_array($SaturdayEvt))
	{
		$IdEvt = stripslashes($Sat_row['IdEvt']);
		$NameEvt	=	stripslashes($Sat_row['NameEvt']);
		$GuestEvt	=	stripslashes($Sat_row['GuestEvt']);
		$DescEvt	=	stripslashes($Sat_row['DescEvt']);
		$DayEvt	=	stripslashes($Sat_row['DayEvt']);
		$BegEvt	=	stripslashes($Sat_row['BegEvt']);
		$EndEvt	=	stripslashes($Sat_row['EndEvt']);
		$IdLoc = 	stripslashes($Sat_row['IdLoc']);
			
		$Loc = new location($IdLoc);
		$NameLoc = $Loc -> NameLoc;
		
		
		$X = strtotime($BegEvt) ;
		$Y = strtotime($EndEvt);
			
	if ($X > $Y)
		{
			$hours = strtotime("+1 day");
			$temp = dateDiff($X, $Y) ;
			$duration =  dateDiff($hours, $temp) ;
		}
	elseif ($X <= $Y) $duration =  dateDiff($X, $Y) ;
	
?>
			  <tr>	
				<td><a href="" data-reveal-id="myModal<?php  echo $IdEvt; ?>" data-animation="fadeAndPop" data-animationspeed="300" data-closeonbackgroundclick="true" data-dismissmodalclass="close-reveal-modal"><?php echo $NameEvt; ?></a></td>
			</tr>
				
	<div id="myModal<?php  echo $IdEvt; ?>" class="xlarge reveal-modal">
     <h2>Description of the event "<?php echo $NameEvt; ?>"</h2>
<div class="row">
	<div class="twelve centered columns">
	 <p>The event will host about <strong><?php echo $GuestEvt; ?></strong> guest<?php if ($GuestEvt > 1) echo 's'; ?> at <?php echo $NameLoc; ?> from <strong><?php echo $BegEvt; ?></strong> to <strong><?php echo $EndEvt; ?></strong> (About <strong><?php echo $duration; ?></strong>)</p>
     <p><strong style=" color:#21409A;">Description:</strong> <br/><?php if ($DescEvt != '') echo $DescEvt; else echo "No description for this event."; ?></p>
	 </div>
</div>
     <a class="close-reveal-modal">&#215;</a></div>
	 
	 
<?php
	} // End while
	?>
	</table>
<?php

	} // End if
elseif ($nb_Sat == 0)
	{
		echo "No event this day.";
	} // end elseif
?>
			
			</td>	
		</tr>	
	</tbody>
</table>
			<br/>
<div style=" text-align:center;" align="center">
	<form method="post" name="formmodifier" action="print-week-events_adm.php" target="_blank">
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
<a href="../admin_spr.php#nice1"><div class="large button red" ><img src="../Admin/icones/arrow_back.png" alt="" /> Go back</div></a>
</div>

</div>

<div id="footer"> <?php include("../footer.php");?></div>


	<!-- Included JS Files -->
	<script src="../js/jquery.min.js"></script>
	<script src="../js/foundation.js"></script>
	<script src="../js/app.js"></script>


</body>
</html>