<page backtop="10mm" backbottom="10mm" backleft="0mm" backright="0mm">
    
	<?php
// protection de page ADMIN
   include_once('../Admin/fonctions/_protectpage.php');
// **************************************
// Parametres de Connexion a la BD
	include_once('../connexion.php');
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
	

	<table style="width:100%; border:solid 1px #666666" width="100%" align="center">
			<tr> 
			  <th>
<?php 
	$req="Select IdWk, BegWk, EndWk from week
			where IdWk='".$IdWk."'";
		$resultat = mysql_query($req) or die('Erreur SQL :<br />'.$req.'<br />'.mysql_error());
		$theweek = mysql_fetch_array($resultat) ;
		//echo "<br/>IdWk = ".$theweek[0];
		
	  	if(!empty($theweek))
	  	{
	  		
			$debut = date("M j, Y",strtotime($theweek[1]));
			$fin = date("M j, Y",strtotime($theweek[2]));
			
			 echo "From <b>Sunday ".$debut."</b> to <b>Saturday ".$fin."</b>" ;
		}
		
			 ?> 
			 
			 </th>
			</tr>
		</table>
		<?php 
		$BegWk = $theweek[1];
		$BegWk =  strtotime($BegWk);
		
	$Sunday = date('M j',$BegWk);
	$Monday = date('M j',strtotime("+1 days",$BegWk));
	$Tuesday = date('M j',strtotime("+2 days",$BegWk));
	$Wednesday = date('M j',strtotime("+3 days",$BegWk));
	$Thursday = date('M j',strtotime("+4 days",$BegWk));
	$Friday = date('M j',strtotime("+5 days",$BegWk));
	$Saturday = date('M j',strtotime("+6 days",$BegWk));
		?>
	<br/>
		<table width="100%" align="center" style="margin-left:5px;">
			<thead>
			<tr>
				<td width="9%"></td>
				<th width="13%">Sunday<br/><?php echo $Sunday;?></th>
				<th width="13%">Monday<br/><?php echo $Monday;?></th>
				<th width="13%">Tuesday<br/><?php echo $Tuesday;?></th>
				<th width="13%">Wednesday<br/><?php echo $Wednesday;?></th>
				<th width="13%">Thursday<br/><?php echo $Thursday;?></th>
				<th width="13%">Friday<br/><?php echo $Friday;?></th>
				<th width="13%">Saturday<br/><?php echo $Saturday;?></th>
				
			</tr>
			</thead>
			<?php 
	
		
			//Retrieve the position of each employee
			 $post_query = "SELECT * FROM post ORDER BY LabPost ASC";
	 $post_result = mysql_query($post_query) or die('Erreur SQL :<br />'.$post_query.'<br />'.mysql_error());
	 while ($post_row = mysql_fetch_array($post_result))
		{
			$postID    = 	stripslashes($post_row['IdPost']);
			$postLab = 	stripslashes($post_row['LabPost']);
			
			
			
	 // Retrieve the name of the employees
	 $pers_query = "SELECT * FROM person
               WHERE IdPost = '".$postID."'
			   ORDER BY LastName";
	 $pers_result = mysql_query($pers_query) or die('Erreur SQL :<br />'.$pers_query.'<br />'.mysql_error());
	 $pers_num = mysql_num_rows($pers_result);
	 
	 if ($pers_num > 0)
	 {
	 	?>
			<tr> <th colspan="8"><b><?php echo $postLab; ?></b></th></tr>
			<?php
	 while ($pers_row = mysql_fetch_array($pers_result))
		{
			$persID    = 	stripslashes($pers_row['IdPers']);
			$persEmail = 	stripslashes($pers_row['Email']);
			$persFirstName = 	stripslashes($pers_row['FirstName']);
			$persLastName = 	stripslashes($pers_row['LastName']);
			$persPhone = 	stripslashes($pers_row['Phone']);
			$persPost = 	stripslashes($pers_row['IdPost']);
			
			?>
			
			<tr class="list">
				<th style="max-width:20px;"><?php echo $persFirstName." ".$persLastName ; ?></th>
				
			<?php
		
	$sched_query = "SELECT * FROM schedule WHERE IdPers = '".$persID."' AND IdWk = '".$IdWk."'";
	$sched_result = mysql_query($sched_query) or die('Erreur SQL :<br />'.$sched_query.'<br />'.mysql_error());
	$sched_num = mysql_num_rows($sched_result);
	 
	 if ($sched_num > 0)
	 {
	 
	while ($sched_row = mysql_fetch_array($sched_result))
	{ // Retrieve schedules
	//$persID = 	stripslashes($sched_row['IdPers']);

	 $schedID	=	stripslashes($sched_row['IdSc']);
	/* $IdWk		=	stripslashes($sched_row['IdWk']);*/
	 
	 $SunBegHr   =	stripslashes($sched_row['SunBegHr']);	
	 $SunEndHr   =	stripslashes($sched_row['SunEndHr']);	
	 $MonBegHr   =	stripslashes($sched_row['MonBegHr']);	
	 $MonEndHr   =	stripslashes($sched_row['MonEndHr']);	
	 $TuesBegHr  =	stripslashes($sched_row['TuesBegHr']);	
	 $TuesEndHr  =	stripslashes($sched_row['TuesEndHr']);	
	 $WedBegHr   =	stripslashes($sched_row['WedBegHr']);	
	 $WedEndHr   =	stripslashes($sched_row['WedEndHr']);	
	 $ThursBegHr =	stripslashes($sched_row['ThursBegHr']);	
	 $ThursEndHr =	stripslashes($sched_row['ThursEndHr']);	
	 $FriBegHr   =	stripslashes($sched_row['FriBegHr']);	
	 $FriEndHr   =	stripslashes($sched_row['FriEndHr']);	
	 $SatBegHr   =	stripslashes($sched_row['SatBegHr']);	
	 $SatEndHr   =	stripslashes($sched_row['SatEndHr']);
	
		?>
			
			  	<td><?php echo $SunBegHr." - ".$SunEndHr; ?></td>
				<td><?php echo $MonBegHr." - ".$MonEndHr; ?></td>
				<td><?php echo $TuesBegHr." - ".$TuesEndHr; ?></td>
				<td><?php echo $WedBegHr." - ".$WedEndHr; ?></td>
				<td><?php echo $ThursBegHr." - ".$ThursEndHr; ?></td>
				<td><?php echo $FriBegHr." - ".$FriEndHr; ?></td>
			 	<td><?php echo $SatBegHr." - ".$SatEndHr; ?></td>
				
			</tr>
		<?php 
			 } // End while for schedules
		}// end if $sched_num
		else {
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
		
		?>
			  	
				<td><?php echo $SunBegHr." - ".$SunEndHr; ?></td>
				<td><?php echo $MonBegHr." - ".$MonEndHr; ?></td>
				<td><?php echo $TuesBegHr." - ".$TuesEndHr; ?></td>
				<td><?php echo $WedBegHr." - ".$WedEndHr; ?></td>
				<td><?php echo $ThursBegHr." - ".$ThursEndHr; ?></td>
				<td><?php echo $FriBegHr." - ".$FriEndHr; ?></td>
			 	<td><?php echo $SatBegHr." - ".$SatEndHr; ?></td>
				
			</tr>
			<?php
		} // End else
			} // End while for employees
		} // End if $pers_num
		}	// End while for post
		
			?>
		</table>
</page>