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

$traiter = 'SET';
/*if (isset($_POST['traiter']) && ($_POST['traiter']=='SET')){
	$traiter = $_POST['traiter'];
	//$persID = 	    mysql_real_escape_string($_POST['persID']);
} else {
	// sinon retour a la liste
	header('location: ../admin.php#nice2');
	exit;
}*/


	 
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
	<title>Shift-Scheduler.com | Setting schedules</title>
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
<script>
	$(function() {
		$( "#Day" ).datepicker({
			changeMonth: true,
			changeYear: true,
			minDate: "0",
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
	
  
 <script type="text/JavaScript">
<!--
function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0;
}
//-->
</script> 		

<script type="text/javascript">
function replaceDoc()
  {
  var x=document.getElementById("Day").value;
  document.location.replace("set-schedules.php?Day="+x);
  }
</script>
</head>

<body>
<div id="containercentrer">

<h1>Setting schedules</h1>

<div class="clearfix"></div>
<br />

<div class="row">
		<div class="twelve columns">
			<div class="panel">
<form name="DayChoice" id="DayChoice" method="GET" >		
	<p style="text-align:center" align="center">
		<label class="centered" for="Subject">Day : 
		<input type="text" name="Day" id="Day" onChange="replaceDoc()" required="required"/>		
		</label>		
	</p>
</form>		
		<br/>
		</div>
	</div>
</div>
<?php
//Info about the events of the selected day
if((isset($_GET["Day"])) && ($_GET["Day"]!=''))
	{
		$Day = $_GET["Day"];
		
		$evt = new event(null);
		$rslt = $evt -> DayEvents($Day,$IdLoc);
		
		$NbEvt = mysql_num_rows($rslt);
		$counter = 0;
		
		while ($DayEvt = mysql_fetch_array($rslt))
		{		
			$NbGuest = $DayEvt["GuestEvt"];
			$counter = $counter + $NbGuest;
		}		
	
		?>
		
<div class="clearfix"></div><br/>

	<div class="row">
		<div class="twelve centered columns">	
			<p style="text-align:center; padding:3px;">
				<?php 
				if ($NbEvt == 0)
					echo "No event for that day.";
				elseif ($NbEvt > 0)
					echo $NbEvt." planned events with about ".$counter." guests.";
				
				 ?>
			</p>
		</div>
	</div>
	
<div class="clearfix"></div>
<br/>

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
			
			$theweekday = date("l",$day);
			
			 echo "Setting the schedules for <strong>".$theday."</strong>" ;
			 
		}
		
		
			 ?> 
			 
			 </th>
			</tr>
		</table>
<div class="clearfix"></div>		
	<br/>
	
<div class="panel">
	<div class="row">
		<div class="two centered columns">	
		<p style="text-align:center; padding:3px;">

<form name="PostChoice" id="PostChoice" method="GET" >		
		<select name="IdPost" id="IdPost" onChange="MM_jumpMenu('document',this,0)">
				<option value="<?php echo "set-schedules.php?Day=$Day"; ?>"></option>
            <?php
if (isset($_GET["IdPost"]))
	$IdPost = $_GET["IdPost"];
else
	$IdPost = 0 ;
	
$post=new post(null);
	if(false!=$post->ListingAdm($IdDept))
		$listepost=$post->ListingAdm($IdDept);
		
	  	if(!empty($listepost))
	  	{
	  		while($lgne=mysql_fetch_array($listepost))
			{
	  	?>
            <option value="<?php echo "set-schedules.php?Day=$Day&&IdPost=".$lgne[0]; ?>" <?php if ($lgne[0] == $IdPost) echo  'selected="selected"' ;?> ><?php echo $lgne[1]; ?></option>
            
            <?php
  			}
		}
	   ?>
          </select>   <div class="clearfix"></div>
		  <span style="color:#808080; font-size:8pt; text-align:center;">Select a position</span>
		
		<br/></form>		
	</p>

		<br/>
		</div>
	</div>
</div>

<br />

<?php
if( (isset($_GET["Day"])) && ($_GET["Day"]!='') && (isset($_GET["IdPost"])) && ($_GET["IdPost"]!=0) )
{		
	$IdPost = $_GET["IdPost"] ;
//query: List of positions
	$post = new post($IdPost);
	$postLabel = $post ->LabPost;
	
	 $check_query = "SELECT * FROM person 
	 					WHERE IdPost = '$IdPost'
	 					AND IdPers IN (SELECT IdPers FROM schedules WHERE Day = '$Day') ";
	 $check_result =  mysql_query($check_query) or die('Erreur SQL :<br />'.$check_query.'<br />'.mysql_error());
	 $check_nb =  mysql_num_rows($check_result);
	 
if ($check_nb > 0)
	{ ?>
			
 <div id="container">
<div class="row">
<div class="alert-box centered warning">
	The schedules from the <strong style="text-transform:uppercase;"><?php echo $postLabel;?></strong> have already been set.
	<a href="" class="close">&times;</a>
</div>
</div>
</div><br/>
	
	<?php
	} 	// Endif ($check_nb > 0)
	
elseif ($check_nb == 0)
	{
	
?>	

<div class="panel">
	<div class="row">
		<div class="twelve centered columns">	
<h3><?php echo $postLabel; ?></h3>

<?php
if ($counter <= 100)
	{
		$query = "SELECT P.IdPers FROM ".$theweekday." D, skills S, person P
					WHERE S.skill = 'EXCELLENT'
					AND S.IdPers = P.IdPers
					AND P.IdPost = '".$IdPost."'
					AND P.IdPers = D.IdPers
					AND D.IdPers NOT IN (SELECT IdPers FROM request WHERE TypeReq = 'DAY-OFF' AND Status = 'APPROVED' AND DayReq = '$Day')
					UNION
					(SELECT IdPers FROM request WHERE TypeReq = 'DAY-ON' AND Status = 'APPROVED' AND DayReq = '$Day')";
					
		$result = mysql_query($query) or die('Erreur SQL :<br />'.$query.'<br />'.mysql_error());
		
		$emp = mysql_num_rows($result);
		
		if ($emp == 0) 
			{
			$query = "SELECT P.IdPers FROM ".$theweekday." D, person P
					WHERE P.IdPost = '".$IdPost."'
					AND P.IdPers = D.IdPers
					AND D.IdPers NOT IN (SELECT IdPers FROM request WHERE TypeReq = 'DAY-OFF' AND Status = 'APPROVED' AND DayReq = '$Day')
					UNION
					(SELECT IdPers FROM request WHERE TypeReq = 'DAY-ON' AND Status = 'APPROVED' AND DayReq = '$Day')";
					
		$result = mysql_query($query) or die('Erreur SQL :<br />'.$query.'<br />'.mysql_error());
			}
		
		$nb_emp = mysql_num_rows($result);
		?>

<h4><?php echo $nb_emp; ?> available employee<?php if($nb_emp > 1) { echo 's'; } ?></h4>


<form name="FormSet" method="post" action="../sched_treatment.php">
	<input type="hidden" name="traiter" value="<?php echo $traiter; ?>" />
	<input type="hidden" name="IdPost" value="<?php echo $IdPost; ?>" />
	<input type="hidden" name="Day" value="<?php echo $Day; ?>" />
		
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
		if ($nb_emp > 0)
			{
				while ($emp_row = mysql_fetch_array($result))
					{
						$persID = $emp_row['IdPers'];
						$employee = new person($persID);
						$persFirstName	= 	$employee -> FirstName;
						$persLastName	= 	$employee -> LastName;
						$persWorkHrs	= 	$employee -> WorkHrs;
						$IdDept			=	$_SESSION["IdDept"];
						$IdPost 		= 	$employee -> IdPost;
						
						$shift_query = "SELECT * FROM ".$theweekday." WHERE IdPers = '$persID'" ;
						$shift_result =  mysql_query($shift_query) or die('SQL Error :<br />'.$shift_query.'<br />'.mysql_error());
						
						while ($shift_row = mysql_fetch_array($shift_result))
							{						
								$from = $shift_row[2];
								$to = $shift_row[3];
							}

	
	?>		
			<tr style="border:thin dotted #666666; padding:5px;">
				<th><?php echo $persLastName.", ".$persFirstName; ?></th>
			    <td><input name="Start<?php echo $persID ;?>" type="text"  id="Start<?php echo $persID ;?>" style="width: 100px;" value="<?php echo $from ;?>" />       </td>
				<td><input name="End<?php echo $persID ;?>" type="text" id="End<?php echo $persID ;?>" style="width: 100px;" value="<?php echo $to ;?>" /></td>
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
<?php			
		//}// End while shift
	} // End while $emp_row
?>		
			
			<tr>
				<!--<td>				</td>-->
				<td colspan="6" style="padding:5px;">
                    <button name="setsc" type="submit" value="<?php echo $traiter; ?>" class="medium button blue" style="margin:5px; vertical-align:middle;"><img src="../Admin/icones/calendar_add.png" alt="" width="24" /><?php echo $traiter; ?> the schedules </button>	
					<a href="../admin.php#nice2" style="margin:5px; vertical-align:middle;"><div class="medium button red"><img src="../Admin/icones/ANNULER.png" alt="" /> Cancel</div> </a>
				</td>
			</tr>
			
<?php
	} // End if $nb_emp > 0
	elseif ($nb_emp == 0)
		{
		?>
		<tr>
				<td colspan="7">Sorry! No employee available at this position.</td>
		</tr>
		<!--<tr>
				<td colspan="7" style="padding:5px;">
                    
					<a href="../admin.php#nice2"><div class="medium button red"><img src="../Admin/icones/ANNULER.png" alt="" />Go back</div> </a>
				</td>
		</tr>-->
		
		<?php
		}
?>
		</table><br/>
	</form>
		</div><!--End div 12 cols-->
	</div><!--End div row-->
</div><!--End div panel-->

<?php
			} // End if ($counter <= 100)
			
elseif (($counter > 100) && ($counter <= 250))
	{
		$query = "SELECT P.IdPers FROM ".$theweekday." D, skills S, person P
					WHERE (S.skill = 'EXCELLENT' OR S.skill = 'GOOD')
					AND S.IdPers = P.IdPers
					AND P.IdPost = '".$IdPost."'
					AND P.IdPers = D.IdPers
					AND D.IdPers NOT IN (SELECT IdPers FROM request WHERE TypeReq = 'DAY-OFF' AND Status = 'APPROVED' AND DayReq = '$Day')
					UNION
					(SELECT IdPers FROM request WHERE TypeReq = 'DAY-ON' AND Status = 'APPROVED' AND DayReq = '$Day')";
		
		$result = mysql_query($query) or die('Erreur SQL :<br />'.$query.'<br />'.mysql_error());
		$nb_emp= mysql_num_rows($result);
		?>

<h4><?php echo $nb_emp; ?> available employee<?php if($nb_emp > 1) { echo 's'; } ?></h4>


	<form name="FormSet" method="post" action="../sched_treatment.php">
	<input type="hidden" name="traiter" value="<?php echo $traiter; ?>" />
	<input type="hidden" name="IdPost" value="<?php echo $IdPost; ?>" />
	<input type="hidden" name="Day" value="<?php echo $Day; ?>" />
		
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
		if ($nb_emp > 0)
			{
				while ($emp_row = mysql_fetch_array($result))
					{
						$persID = $emp_row['IdPers'];
						$employee = new person($persID);
						$persFirstName	= 	$employee -> FirstName;
						$persLastName	= 	$employee -> LastName;
						$persWorkHrs	= 	$employee -> WorkHrs;
						$IdDept			=	$employee -> IdDept;
						$IdPost 		= 	$employee -> IdPost;
						
						$shift_query = "SELECT * FROM ".$theweekday." WHERE IdPers = '$persID'" ;
						$shift_result =  mysql_query($shift_query) or die('SQL Error :<br />'.$shift_query.'<br />'.mysql_error());
						
						while ($shift_row = mysql_fetch_array($shift_result))
							{						
								$from = $shift_row[2];
								$to = $shift_row[3];
							}

	
	?>		
			<tr style="border:thin dotted #666666; padding:5px;">
				<th><?php echo $persLastName.", ".$persFirstName; ?></th>
			    <td><input name="Start<?php echo $persID ;?>" type="text"  id="Start<?php echo $persID ;?>" style="width: 100px;" value="<?php echo $from ;?>" />       </td>
				<td><input name="End<?php echo $persID ;?>" type="text" id="End<?php echo $persID ;?>" style="width: 100px;" value="<?php echo $to ;?>" /></td>
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
<?php			
		//}// End while shift
	} // End while $emp_row
?>		
			
			<tr>
				<!--<td>				</td>-->
				<td colspan="6" style="padding:5px;">
                    <button name="setsc" type="submit" value="<?php echo $traiter; ?>" class="medium button blue" style="margin:5px; vertical-align:middle;"><img src="../Admin/icones/calendar_add.png" alt="" width="24" /><?php echo $traiter; ?> the schedules </button>	
					<a href="../admin.php#nice2" style="margin:5px; vertical-align:middle;"><div class="medium button red"><img src="../Admin/icones/ANNULER.png" alt="" /> Cancel</div> </a>
				</td>
			</tr>
			
<?php
	} // End if $nb_emp
	elseif ($nb_emp == 0)
		{
		?>
		<tr>
				<td colspan="7">Sorry! No employee available at this position.</td>
		</tr>
		<!--<tr>
				<td colspan="7" style="padding:5px;">
                    
					<a href="../admin.php#nice2"><div class="medium button red"><img src="../Admin/icones/ANNULER.png" alt="" />Go back</div> </a>
				</td>
		</tr>-->
		
		<?php
		}
?>
		</table><br/>
	</form>
		</div><!--End div 12 cols-->
	</div><!--End div row-->
</div><!--End div panel-->

<?php
			} // End if ($counter > 100) & ($counter <= 250)

elseif ($counter > 250)
	{
		$query = "SELECT P.IdPers FROM ".$theweekday." D, person P
					WHERE P.IdPost = '".$IdPost."'
					AND P.IdPers = D.IdPers
					AND D.IdPers NOT IN (SELECT IdPers FROM request WHERE TypeReq = 'DAY-OFF' AND Status = 'APPROVED' AND DayReq = '$Day')
					UNION
					(SELECT IdPers FROM request WHERE TypeReq = 'DAY-ON' AND Status = 'APPROVED' AND DayReq = '$Day')";
		
		$result = mysql_query($query) or die('Erreur SQL :<br />'.$query.'<br />'.mysql_error());
		$nb_emp= mysql_num_rows($result);
		?>

<h4><?php echo $nb_emp; ?> available employee<?php if($nb_emp > 1) { echo 's'; } ?></h4>


	<form name="FormSet" method="post" action="../sched_treatment.php">
	<input type="hidden" name="traiter" value="<?php echo $traiter; ?>" />
	<input type="hidden" name="IdPost" value="<?php echo $IdPost; ?>" />
	<input type="hidden" name="Day" value="<?php echo $Day; ?>" />
		
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
		if ($nb_emp > 0)
			{
				while ($emp_row = mysql_fetch_array($result))
					{
						$persID = $emp_row['IdPers'];
						$employee = new person($persID);
						$persFirstName	= 	$employee -> FirstName;
						$persLastName	= 	$employee -> LastName;
						$persWorkHrs	= 	$employee -> WorkHrs;
						$IdDept			=	$employee -> IdDept;
						$IdPost 		= 	$employee -> IdPost;
						
						$shift_query = "SELECT * FROM ".$theweekday." WHERE IdPers = '$persID'" ;
						$shift_result =  mysql_query($shift_query) or die('SQL Error :<br />'.$shift_query.'<br />'.mysql_error());
						
						while ($shift_row = mysql_fetch_array($shift_result))
							{						
								$from = $shift_row[2];
								$to = $shift_row[3];
							}

	
	?>		
			<tr style="border:thin dotted #666666; padding:5px;">
				<th><?php echo $persLastName.", ".$persFirstName; ?></th>
			    <td><input name="Start<?php echo $persID ;?>" type="text"  id="Start<?php echo $persID ;?>" style="width: 100px;" value="<?php echo $from ;?>" />       </td>
				<td><input name="End<?php echo $persID ;?>" type="text" id="End<?php echo $persID ;?>" style="width: 100px;" value="<?php echo $to ;?>" /></td>
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
<?php			
		//}// End while shift
	} // End while $emp_row
?>		
			
			<tr>
				<!--<td>				</td>-->
				<td colspan="6" style="padding:5px;">
                    <button name="setsc" type="submit" value="<?php echo $traiter; ?>" class="medium button blue" style="margin:5px; vertical-align:middle;"><img src="../Admin/icones/calendar_add.png" alt="" width="24" /><?php echo $traiter; ?> the schedules </button>	
					<a href="../admin.php#nice2" style="margin:5px; vertical-align:middle;"><div class="medium button red"><img src="../Admin/icones/ANNULER.png" alt="" /> Cancel</div> </a>
				</td>
			</tr>
			
<?php
	} // End if $nb_emp
	elseif ($nb_emp == 0)
		{
		?>
		<tr>
				<td colspan="7">Sorry! No employee available at this position.</td>
		</tr>
		<!--<tr>
				<td colspan="7" style="padding:5px;">
                    
					<a href="../admin.php#nice2"><div class="medium button red"><img src="../Admin/icones/ANNULER.png" alt="" />Go back</div> </a>
				</td>
		</tr>-->
		
		<?php
		}
?>
		</table><br/>
	</form>
		</div><!--End div 12 cols-->
	</div><!--End div row-->
</div><!--End div panel-->

<?php
			} // End if ($counter > 250)
			
			} // End if ($check_nb == 0)
			
		}  // End if isset($_GET["IdPost"]) & isset($_GET["Day"])
	}  // End if isset($_GET["Day"])
		
?>

<!-- lien retour -->
<div class="VALIDATION-FINALE">
<a href="../admin.php#nice2"><div class="large button red" ><img src="../Admin/icones/arrow_back.png" alt="" /> Go back</div></a>
</div>

</div> <!--End div containercentrer-->

<div id="footer"> <?php include("../footer.php");?></div>


	<!-- Included JS Files -->
	<!--<script src="../js/jquery.min.js"></script>-->
	<script src="../js/foundation.js"></script>
	<script src="../js/app.js"></script>


</body>
</html>