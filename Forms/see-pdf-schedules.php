<page backtop="10mm" backbottom="10mm" backleft="0mm" backright="0mm">
    
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
	
	?>
<link rel="stylesheet" media="screen" type="text/css" href="../css/print.css" />
	<link rel="shortcut icon" type="image/x-icon" href="../Admin/icones/ischedule_logo1.ico">

	<page_header>
        <table style="width: 100%; border: solid 1px black;">
            <tr>
                <td style="text-align: left;    width: 33%">Shift-Scheduler.com</td>
                <td style="text-align: center;    width: 34%">Schedule of the week</td>
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
				<td style="border:thin solid #666666; padding:5px;"></td>
				<th style="border:thin solid #666666; padding:5px;">Sunday<br/><?php echo date('M j',$Sunday);?></th>
				<th style="border:thin solid #666666; padding:5px;">Monday<br/><?php echo date('M j',$Monday);?></th>
				<th style="border:thin solid #666666; padding:5px;">Tuesday<br/><?php echo date('M j',$Tuesday);?></th>
				<th style="border:thin solid #666666; padding:5px;">Wednesday<br/><?php echo date('M j',$Wednesday);?></th>
				<th style="border:thin solid #666666; padding:5px;">Thursday<br/><?php echo date('M j',$Thursday);?></th>
				<th style="border:thin solid #666666; padding:5px;">Friday<br/><?php echo date('M j',$Friday);?></th>
				<th style="border:thin solid #666666; padding:5px;">Saturday<br/><?php echo date('M j',$Saturday);?></th>
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
			
			<tr style="border:thin solid #666666; text-align:center;"> <th colspan="8" style=" text-transform:uppercase;"><?php echo $postLab; ?></th></tr>
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

?>			
			<tr style="border:thin solid #666666; padding:5px;">
				<th style="border:thin solid #666666; padding:5px;"><?php echo $FirstName." ".$LastName; ?></th>
				
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
	
	
	
	
?>
			  	<td style="border:thin solid #666666; padding:5px;"><?php echo $BegShift." - ".$EndShift; ?></td>
<?php
	} // End while
	} // End if
elseif ($nb_sun == 0)
	{
	$BegShift = '';
	$EndShift = '';
	
	
	?>
			  	<td style="border:thin solid #666666; padding:5px;"><?php echo $BegShift." - ".$EndShift; ?></td>
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
	
	
	
	
?>
			  	<td style="border:thin solid #666666; padding:5px;"><?php echo $BegShift." - ".$EndShift; ?></td>
<?php
	} // End while
	} // End if
elseif ($nb_mon == 0)
	{
	$BegShift = '';
	$EndShift = '';
	
	
	?>
			  	<td style="border:thin solid #666666; padding:5px;"><?php echo $BegShift." - ".$EndShift; ?></td>
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
	
	
	
	
?>
			  	<td style="border:thin solid #666666; padding:5px;"><?php echo $BegShift." - ".$EndShift; ?></td>
<?php
	} // End while
	} // End if
elseif ($nb_tues == 0)
	{
	$BegShift = '';
	$EndShift = '';
	
	
	?>
			  	<td style="border:thin solid #666666; padding:5px;"><?php echo $BegShift." - ".$EndShift; ?></td>
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
	
	
	
	
?>
			  	<td style="border:thin solid #666666; padding:5px;"><?php echo $BegShift." - ".$EndShift; ?></td>
<?php
	} // End while
	} // End if
elseif ($nb_wed == 0)
	{
	$BegShift = '';
	$EndShift = '';
	
	
	?>
			  	<td style="border:thin solid #666666; padding:5px;"><?php echo $BegShift." - ".$EndShift; ?></td>
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
	
	
	
	
?>
			  	<td style="border:thin solid #666666; padding:5px;"><?php echo $BegShift." - ".$EndShift; ?></td>
<?php
	} // End while
	} // End if
elseif ($nb_thurs == 0)
	{
	$BegShift = '';
	$EndShift = '';
	
	
	?>
			  	<td style="border:thin solid #666666; padding:5px;"><?php echo $BegShift." - ".$EndShift; ?></td>
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
	
	
	
	
?>
			  	<td style="border:thin solid #666666; padding:5px;"><?php echo $BegShift." - ".$EndShift; ?></td>
<?php
	} // End while
	} // End if
elseif ($nb_fri == 0)
	{
	$BegShift = '';
	$EndShift = '';
	
	
	?>
			  	<td style="border:thin solid #666666; padding:5px;"><?php echo $BegShift." - ".$EndShift; ?></td>
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
	
	
?>
			  	<td style="border:thin solid #666666; padding:5px;"><?php echo $BegShift." - ".$EndShift; ?></td>
<?php
	} // End while
	} // End if
elseif ($nb_sat == 0)
	{
	$BegShift = '';
	$EndShift = '';
	
	?>
			  	<td style="border:thin solid #666666; padding:5px;"><?php echo $BegShift." - ".$EndShift; ?></td>
<?php
} // end elseif

?>
			
				
			</tr>
<?php
} // end while pers row
}// end if pers
else { // no person
?>
 	<tr><td colspan="8" style="border:thin solid #666666; padding:5px;">No employee for now.</td></tr>
<?php
} // End else
} // end while post
?>			
</table>
</page>