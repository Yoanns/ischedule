<?php
// protection de page ADMIN
   include_once('../Admin/fonctions/_protectpage.php');
// **************************************
// Parametres de Connexion a la BD
	include_once('../connexion.php');
	
	include("../Model/class.schedule.php");	

// **************************************
// On recupere l URL de la page d'origine
	$nomPageOrigine = $_SERVER["HTTP_REFERER"];

if (isset($_POST['persID']) && ($_POST['persID']!='')){
	$persID = 	    mysql_real_escape_string($_POST['persID']);
} 
elseif (isset($_GET['persID']) && ($_GET['persID']!='')){
	$persID = 	    mysql_real_escape_string($_GET['persID']);
}
else {
	// sinon retour a la liste
	header('location: ../admin.php#nice4');
	exit;
}

	 // Select the person's name whose schedule is being seen
	$pers_query = "SELECT FirstName, LastName FROM person WHERE IdPers = '".$persID."'";
	$pers_result = mysql_query($pers_query) or die('Erreur SQL :<br />'.$pers_query.'<br />'.mysql_error());
	$person = mysql_fetch_array($pers_result);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name="robots" content="noindex,nofollow" />
<title>Shift-Scheduler.com | Seeing <?php echo $person[0]." ".$person[1]."'s"; ?> schedule</title>
	<link rel="shortcut icon" type="image/x-icon" href="../Admin/icones/ischedule_logo1.ico">
<link rel="stylesheet" media="screen" type="text/css" href="../Admin/css_adm/news_ADM_style.css" />

<!-- <link href="../css/main.css" rel="stylesheet" media="screen" type="text/css" />-->
 <style>
 	select {}
 </style>
 
 <script type="text/JavaScript">
<!--
function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0;
}
//-->
</script> 		
	
</head>

<body>
<div id="containercentrer">

<h1>Seeing <?php echo $person[0]." ".$person[1]."'s"; ?> schedule</h1>

<div style="clear:both;"></div>
<br />
<form name="WkChoice" id="WkChoice" method="get" >	
		<table>
			<tr>
				<td width="42%" style="padding-right:5px;color:#000;">Week:<br/><span style="color:#808080; font-size:8pt;">Select a week to see a schedule</span>
                                 </td> 
				<td>
				<select name="week" id="week" onchange="MM_jumpMenu('document',this,0)">
								 <option value="" selected="selected">Select a week</option>
            <?php
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
	 
$week=new week(null);
	if(false!=$week->Listing())
		$listeweek=$week->Listing();
		
	  	if(!empty($listeweek))
	  	{
	  		while($line=mysql_fetch_array($listeweek))
			{
			$start = date("M j, Y",strtotime($line[1]));
			$end = date("M j, Y",strtotime($line[2]));
			$IdWk = $line[0];
	  	?>
            <option value="<?php echo "see-schedule.php?week=$IdWk&&persID=$persID"; ?>"><?php echo "From   <b>".$start."</b>  to  <b>".$end."</b>" ; ?></option>
            
            <?php
  			}
		}
	   ?>
          </select>
		  
		  </td>
				
			</tr>
		</table> 
</form>		
		<br/>
<?php		
if((isset($_GET["week"]))&&($_GET["week"]!=0))
{		
	$IdWk = $_GET["week"] ;
	
	$sched_query = "SELECT * FROM schedule WHERE IdPers='".$persID."' AND IdWk = '".$IdWk."'";
	$sched_result = mysql_query($sched_query) or die('Erreur SQL :<br />'.$sched_query.'<br />'.mysql_error());
	while ($sched_row = mysql_fetch_array($sched_result))
	{
	$persID = 	stripslashes($sched_row['IdPers']);
	$schedID = stripslashes($sched_row['IdSc']);

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
		} // Fin de la boucle	
?>
<div id="week_schedule" >	
	<table>
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
			// echo "<br/>IdWk = ".$theweek[0];
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
		<table>
			<thead>
			<tr style="border:1px dashed #CCCCCC">
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
			
			<tr style="border:1px dashed #CCCCCC">
				<th>Shift</th>
			  	<td><?php echo $SunBegHr." - ".$SunEndHr; ?></td>
				<td><?php echo $MonBegHr." - ".$MonEndHr; ?></td>
				<td><?php echo $TuesBegHr." - ".$TuesEndHr; ?></td>
				<td><?php echo $WedBegHr." - ".$WedEndHr; ?></td>
				<td><?php echo $ThursBegHr." - ".$ThursEndHr; ?></td>
				<td><?php echo $FriBegHr." - ".$FriEndHr; ?></td>
			 	<td><?php echo $SatBegHr." - ".$SatEndHr; ?></td>
			</tr>
			
			<tr>
				<td>				</td>
				<td colspan="7" style="padding:5px;">
				<div style="float:left;">
				<form method="post" name="formmodifier" action="./edit-schedule.php">
	<fieldset>
	<input type="hidden" name="traiter" value="EDIT" />
	<input type="hidden" name="persID" value="<?php  echo $persID; ?>" />
	<input type="hidden" name="weekID" value="<?php  echo $IdWk; ?>" />
	<input type="hidden" name="schedID" value="<?php  echo $schedID; ?>" />	
		<button name="btMODIFIER" type="submit" title="Edit schedule" class="medium button blue">
		<img src="../Admin/icones/calendar_edit.png" alt="Set schedule" width="24" />Edit schedule</button>
	</fieldset>
	</form>
	</div>
	
	<div style="float:left ;">
<form method="post" name="formvoirFiche" action="../admin.php#nice4">
	<fieldset>
		<button name="btMODIFIER" class="medium button red" type="submit" title="Cancel">
		<img src="../Admin/icones/ANNULER.png" alt="Cancel" />Cancel</button>
	</fieldset>
	</form>
</div>
                    <!--<button name="setsc" type="submit" value="<?php //echo $traiter; ?>" ><img src="../Admin/icones/schedule.jpg" alt="" width="24" />Edit Schedule </button>	
					<a href="../empl_admin.php?page=1"><div class="medium button red"><img src="../Admin/icones/ANNULER.png" alt="" /> Cancel</div> </a>	-->				</td>
			</tr>
		</table>
	</div> <!--End <div id="week_schedule" >-->
</div>
<?php } // end if
?>
</div>

<!-- lien retour -->
<div class="VALIDATION-FINALE">
<a href="../admin.php#nice4"><div class="large button red" ><img src="../Admin/icones/arrow_back.png" alt="" /> Go back</div></a>
</div>

</body>
</html>
