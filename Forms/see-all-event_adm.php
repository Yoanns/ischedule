<?php
// protection de page ADMIN
   include_once('../Admin/fonctions/_protectpageadm.php');
// **************************************
// Parametres de Connexion a la BD
	include_once('../connexion.php');
	
	include_once("../Model/class.event.php");	
	include_once('../Model/class.department.php');
	
	include_once('../Admin/fonctions/functions.php');
	
	$IdDept = $_SESSION["IdDept"];
	$Department = new department($IdDept);
	$IdLoc = $Department -> IdLoc;
	

// **************************************
// On recupere l URL de la page d'origine
	//$nomPageOrigine = $_SERVER["HTTP_REFERER"];


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
	<title>Shift-Scheduler.com | Seeing all the events</title>
	<link rel="shortcut icon" type="image/x-icon" href="../Admin/icones/ischedule_logo1.ico">
	
	<!-- Included CSS Files -->
	<link rel="stylesheet" href="../css/foundation.css">
	<link rel="stylesheet" href="../css/app.css">
	<link rel="stylesheet" media="screen" type="text/css" href="../Admin/css_adm/news_ADM_style.css" />
	<link rel="stylesheet" type="text/css" href="../css/jquery-ui-1.8.20.custom.css"/>
	
	<!--[if lt IE 9]>
		<link rel="stylesheet" href="../css/ie.css">
	<![endif]-->
	
	<script src="../js/modernizr.foundation.js"></script>
	<!-- IE Fix for HTML5 Tags -->
	<!--[if lt IE 9]>
		<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
	
<!--<link rel="stylesheet" media="screen" type="text/css" href="../Admin/css_adm/style.css" />-->
		<script type="text/javascript" src="../js/jquery-1.7.2.min.js"></script>
		<script type="text/javascript" src="../js/jquery-ui-1.8.20.custom.min.js"></script>
		<script>
	$(function() {
		$( "#Day" ).datepicker({
			changeMonth: true,
			changeYear: true,
			altField: "#alternate",
			minDate: "-1d",
			altFormat: "DD, d MM, yy",
			dateFormat: "yy-mm-dd"
		});
		
	});
	</script>
  
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
  document.location.replace("see-all-event_adm.php?Day="+x);
  }
</script>

</head>

<body>
<div id="containercentrer">

<h1>Seeing all the events</h1>

<br />
<div class="row">
			<div class="twelve columns">
			<div class="panel">
<form name="DayChoice" id="DayChoice" method="GET" >	
	<table>
		<tr>
		<td>
		<p style="text-align:center" align="center">
		<label class="centered" for="Subject">Day : 
		<input type="text" name="Day" id="Day" onChange="replaceDoc()" required="required"/>		
		</label>		
	</p>
         </td>
		</tr>
	</table>
</form>		
		<br/>
		</div>
	</div>
</div>
<?php	
	
if((isset($_GET["Day"]))&&($_GET["Day"]!=''))
{		
	$DayEvt = $_GET["Day"] ;
	
	
?>
<div class="row">
			<div class="twelve columns">
			<div class="panel">
	<table>
			<tr> 
				<th><strong>
<?php 
		$evt = new event(null);
		$EvtDay = $evt -> DayEventsAdm($DayEvt);
		$TodayEvt = mysql_fetch_array($EvtDay);
		
	  	if(!empty($EvtDay))
	  	{
	  		
			$day = strtotime($DayEvt);
			$theday = date("l F j, Y",$day);
			
			 echo $theday ;
			 
		}
		
			 ?> 
			 </strong>
			 </th>
			</tr>
		</table>
		
	<br/>
		<table>
			<thead>
			<tr style="border:1px dashed #CCCCCC">
				<td width="35%"></td>
				<th width="10%">Guests</th>
				<th width="25%">Time slot</th>
				<th>Duration</th>
				<td width="8%"></td>
				<td width="8%"></td>
			</tr>
			</thead>
			<?php 
	
		
			//Retrieve the position of each employee
			 $evt_query = "SELECT * FROM event  WHERE DayEvt = '$DayEvt' ORDER BY BegEvt ASC";
	 $evt_result = mysql_query($evt_query) or die('Erreur SQL :<br />'.$evt_query.'<br />'.mysql_error());
	 $evt_num = mysql_num_rows($evt_result);
	 
if ($evt_num > 0)
	{
	 
	 while ($evt_row = mysql_fetch_array($evt_result))
		{
			$evtID  = 	stripslashes($evt_row['IdEvt']);
			$evtName = 	stripslashes($evt_row['NameEvt']);
			$evtGuest = stripslashes($evt_row['GuestEvt']);
			$evtDesc = 	stripslashes($evt_row['DescEvt']);
			$evtDay = 	stripslashes($evt_row['DayEvt']);
			$evtBeg  = 	stripslashes($evt_row['BegEvt']);
			$evtEnd = 	stripslashes($evt_row['EndEvt']);
			
			$X = strtotime($evtBeg) ;
			$Y = strtotime($evtEnd);
			
	if ($X > $Y)
		{
			$hours = strtotime("+1 day");
			$temp = dateDiff($X, $Y) ;
			$duration =  dateDiff($hours, $temp) ;
		}
	elseif ($X <= $Y) $duration =  dateDiff($X, $Y) ;
			
	
	 	?>
			
			<tr style="border:1px dashed #CCCCCC">
				<th><a href="" data-reveal-id="myModal<?php  echo $evtID; ?>" data-animation="fadeAndPop" data-animationspeed="300" data-closeonbackgroundclick="true" data-dismissmodalclass="close-reveal-modal"><?php echo $evtName; ?></a></th>
				<td><?php echo $evtGuest; ?></td>
				<td><?php echo $evtBeg." - ".$evtEnd; ?></td>
				<td><?php echo $duration; ?></td>
				<td>
					<div style="float:left;">
						<form method="post" name="formmodifier" action="./events_adm.php">
								<input type="hidden" name="traiter" value="EDIT" />
								<input type="hidden" name="IdEvt" value="<?php  echo $evtID; ?>" />
								<button name="btMODIFIER" type="submit" title="Edit event" class="button">
									<img src="../Admin/icones/date_edit.png" alt="Edit event" width="24" /></button>
						</form>
					</div>				</td>
				<td>
					<div style="float:left;">
						<form method="post" name="formmodifier" action="./evt_treatment_adm.php">
						  <input type="hidden" name="traiter2" value="DELETE" />
						  <input type="hidden" name="IdEvt" value="<?php  echo $evtID; ?>" />
								<button name="btMODIFIER" type="submit" title="Delete event" class="button">
									<img src="../Admin/icones/date_delete.png" alt="Delete event" width="24" /></button>
						</form>
					</div>				</td>
			</tr>
			
			<div id="myModal<?php  echo $evtID; ?>" class="reveal-modal">
     <h2>Description of the event</h2>
     <p class="lead"><?php echo $evtName; ?></p>
      <?php if ($evtDesc !=  '') { ?>
	 <p><?php echo $evtDesc; ?></p>
	 <?php }
	 else { ?>
	  <p>No description for this event.</p>
	  <?php } ?>
     <a class="close-reveal-modal">&#215;</a></div>
				
		<?php 
			 } // End while for events
		} //End if  $evt_num
		 else
		 	{ ?>
			<tr style="border:1px dashed #CCCCCC">
				<td colspan="8"> <div align="center">No event scheduled for that day.</div></td>
			</tr>
			
			<?php
			}
		
			?>
			<tr style="border:1px dashed #CCCCCC">
				<td colspan="9" style="padding:5px;">
           <?php 	
		   if ($evt_num > 0)
			{
	 ?>     
	<div style="text-align:center;">
	<form method="post" name="formmodifier" action="./print-day-event_adm.php" target="_blank">
	<input type="hidden" name="day" value="<?php  echo $DayEvt; ?>" />
		<button name="btPrint" type="submit" title="Print event" class="medium button green">
		<img src="../Admin/icones/printer.png" alt="Print event" width="24" />Printable version</button>
	</form>
	</div>
			<?php
		}
		
		?>
			</td>
			</tr>
		</table>
		<br/>
		</div>
	</div>
</div>

</div>
<?php } // end if
?>
<!-- lien retour -->
<div class="VALIDATION-FINALE">
<a href="../admin_spr.php#nice1"><div class="large button red" ><img src="../Admin/icones/arrow_back.png" alt="" /> Go back</div></a>
</div>

</div>

<div id="footer"> <?php include("../footer.php");?></div>


	<!-- Included JS Files -->
	<!--<script src="../js/jquery.min.js"></script>-->
	<script src="../js/foundation.js"></script>
	<script src="../js/app.js"></script>


</body>
</html>
