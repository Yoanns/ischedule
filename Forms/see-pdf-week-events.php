<page backtop="10mm" backbottom="10mm" backleft="0mm" backright="0mm">
    
	<?php
// protection de page ADMIN
   include_once('../Admin/fonctions/_protectpage.php');
   include_once('../Admin/fonctions/functions.php');
// **************************************
// Parametres de Connexion a la BD
	include_once('../connexion.php');
	// **************************************
	include_once('../Model/class.event.php');
	include_once("../Model/class.post.php");	
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
	
	?>
<link rel="stylesheet" media="screen" type="text/css" href="../css/print.css" />
	<link rel="shortcut icon" type="image/x-icon" href="../Admin/icones/ischedule_logo1.ico">

	<page_header>
        <table style="width: 100%; border: solid 1px black;">
            <tr>
                <td style="text-align: left;    width: 33%">Shift-Scheduler.com</td>
                <td style="text-align: center;    width: 34%">Events of the week</td>
                <td style="text-align: right;    width: 33%"><?php echo date('M j, Y'); ?></td>
            </tr>
        </table>
    </page_header>
	
    <page_footer>
        <table style="width: 100%; border: solid 1px black;">
            <tr>
                <td style="text-align: left;    width: 50%">Shift-Scheduler.com</td>
                <td style="text-align: right;    width: 50%">page [[page_cu]]/[[page_nb]]</td>
            </tr>
        </table>
    </page_footer>
	

	
		<?php 
		$Sunday = strtotime(first_day_of_week ($day));
	$Monday = strtotime("+1 days",$Sunday);
	$Tuesday = strtotime("+2 days",$Sunday);
	$Wednesday = strtotime("+3 days",$Sunday);
	$Thursday = strtotime("+4 days",$Sunday);
	$Friday = strtotime("+5 days",$Sunday);
	$Saturday =  strtotime("+6 days",$Sunday);
	
		?>
 <table style="width:100%; border:solid 1px #666666" width="100%" align="center">
			<tr> 
			  <td>
			 	From <strong><?php echo date('l M j, Y',$Sunday);?></strong> to <strong><?php echo date('l M j, Y',$Saturday);?></strong>
			 </td>
			</tr>
		</table>
<br/>

	<table align="center" width="100%">
			<thead>
			<tr>
				<th style="border:thin solid #666666; padding:2px;">Sunday<br/><?php echo date('M j',$Sunday);?></th>
				<th style="border:thin solid #666666; padding:2px;">Monday<br/><?php echo date('M j',$Monday);?></th>
				<th style="border:thin solid #666666; padding:2px;">Tuesday<br/><?php echo date('M j',$Tuesday);?></th>
				<th style="border:thin solid #666666; padding:2px;">Wednesday<br/><?php echo date('M j',$Wednesday);?></th>
				<th style="border:thin solid #666666; padding:2px;">Thursday<br/><?php echo date('M j',$Thursday);?></th>
				<th style="border:thin solid #666666; padding:2px;">Friday<br/><?php echo date('M j',$Friday);?></th>
				<th style="border:thin solid #666666; padding:2px;">Saturday<br/><?php echo date('M j',$Saturday);?></th>
				
				
			</tr>
			</thead>

<tbody>
			<tr>
				<td>
<?php

	$evt = new event(null);
	
//Sunday
		$SundayEvt = $evt -> DayEvents(date("Y-m-d",$Sunday),$IdLoc);
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
		
	
?>
				<tr>
					<td style="border:none;"><?php echo $NameEvt; ?> <br />(<?php echo $GuestEvt; ?> guests)<br/><?php echo $BegEvt; ?> - <?php echo $EndEvt; ?></td>
				</tr>

	 
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
				
				<td>
<?php
//Monday
$MondayEvt = $evt -> DayEvents(date("Y-m-d",$Monday),$IdLoc);
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
		
	
?>
			  <tr>
				<td style="border:none;"><?php echo $NameEvt; ?> <br /> (<?php echo $GuestEvt; ?> guests)<br/><?php echo $BegEvt; ?> - <?php echo $EndEvt; ?></td>
			</tr>
			
	 
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
				
				<td>
<?php


//Tuesday
$TuesdayEvt = $evt -> DayEvents(date("Y-m-d",$Tuesday),$IdLoc);
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
		
	
?>
			  <tr>
				<td style="border:none;"><?php echo $NameEvt; ?> <br /> (<?php echo $GuestEvt; ?> guests)<br/><?php echo $BegEvt; ?> - <?php echo $EndEvt; ?></td>
			</tr>
				
	 
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
				
				<td>
<?php

//Wednesday
	$WednesdayEvt = $evt -> DayEvents(date("Y-m-d",$Wednesday),$IdLoc);
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
		
	
?>
			  <tr>
				<td style="border:none;"><?php echo $NameEvt; ?> <br /> (<?php echo $GuestEvt; ?> guests)<br/><?php echo $BegEvt; ?> - <?php echo $EndEvt; ?></td>
			</tr>
					 
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
				
				<td>
<?php

//Thursday
	$ThursdayEvt = $evt -> DayEvents(date("Y-m-d",$Thursday),$IdLoc);
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
		
	
?>
			  <tr>
				<td style="border:none;"><?php echo $NameEvt; ?> <br /> (<?php echo $GuestEvt; ?> guests)<br/><?php echo $BegEvt; ?> - <?php echo $EndEvt; ?></td>
			</tr>
				
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
				
				<td>
<?php


//Friday
	$FridayEvt = $evt -> DayEvents(date("Y-m-d",$Friday),$IdLoc);
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
		
	
?>
			  <tr>	
				<td style="border:none;"><?php echo $NameEvt; ?> <br /> (<?php echo $GuestEvt; ?> guests)<br/><?php echo $BegEvt; ?> - <?php echo $EndEvt; ?></td>
			</tr>
				
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
				
				<td>
<?php


//Saturday
	$SaturdayEvt = $evt -> DayEvents(date("Y-m-d",$Saturday),$IdLoc);
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
		
?>
			  <tr>	
				<td style="border:none;"><?php echo $NameEvt; ?> <br /> (<?php echo $GuestEvt; ?> guests)<br/><?php echo $BegEvt; ?> - <?php echo $EndEvt; ?></td>
			</tr>	 
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
</page>