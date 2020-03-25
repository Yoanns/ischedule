<?php 
// protection de page ADMIN
    include_once('./Admin/fonctions/_protectpage.php');
// Parametres de Connexion a la BD
	include_once('connexion.php');   
// DOSSIER des ICONES (administration)
	$DossierIcones = './Admin/icones/';
	
	//include_once('Admin/fonctions/config.php');
	
	include_once("./Model/class.request.php");		
	include_once("./Model/class.post.php");	
	include_once("./Model/class.person.php");
	include_once("./Model/class.department.php");
	include_once("./Model/class.location.php");
	include_once("./Model/class.skills.php");
	include_once('./Model/class.sunday.php');
	include_once('./Model/class.monday.php');
	include_once('./Model/class.tuesday.php');
	include_once('./Model/class.wednesday.php');
	include_once('./Model/class.thursday.php');
	include_once('./Model/class.friday.php');
	include_once('./Model/class.saturday.php');
	
	include_once('Admin/fonctions/functions.php');
	
	$IdDept = $_SESSION["IdDept"];
	$Department = new department($IdDept);
	$IdLoc = $Department -> IdLoc;
	$NameDept = $Department -> NameDept;
	
	$Location = new location($IdLoc);
	$NameLoc = $Location -> NameLoc;
	
	$persID = $_SESSION["IdAdmin"];
		
	$person = new person($persID);
	$FirstName = $person -> FirstName;
	$LastName =  $person -> LastName;
	$Name = $person -> FirstName." ".$person -> LastName;

	 
 //Changing password
 // Form was submitted

if ( isset( $_POST['pwdsubmit'] ) )

{
	$HashCurrent = hash('sha512', $_POST['current']);
	if ( isset( $_POST['current'] ) && ( $HashCurrent == $_SESSION['Pwd']) )
	{
    // Are both passwords set and are they identical?

    if ( !empty( $_POST['password'] ) && $_POST['password'] == $_POST['check'] )

        {
			$pass = $_POST['password'];
    		$Pwd = hash('sha512', $pass);
			$update_query = "UPDATE admin SET `Pwd`='$Pwd' WHERE `IdPers`='".$persID."'";
			$update_result = mysql_query($update_query) or die('Erreur SQL :<br />'.$update_query.'<br />'.mysql_error());
			$_SESSION['Pwd'] = $Pwd;
			echo"<div class='container'><div class='alert-box centered success' >
						Your password has been successfully changed.
						<a href='' class='close'>&times;</a>
					</div></div>";
		}

    else

        echo "<div class='container'><div class='alert-box centered  error' >
					The new passwords you entered do not match.
					<a href='' class='close'>&times;</a>
				</div></div>";
	}
	else echo "<div class='container'><div class='alert-box centered  error' >
						The <b>Current password</b> you entered wrong. Please try again.
						<a href='' class='close'>&times;</a>
					</div></div>";
}


 //Changing login
 // Form was submitted

if ( isset( $_POST['logsubmit'] ) )

{
	
	if ( isset( $_POST['currentLog'] ) && ( $_POST['currentLog'] == $_SESSION['Login']) )
	{

    if ( !empty( $_POST['newLog'] ) )

        {
			$Login = $_POST['newLog'];
			$update_query = "UPDATE admin SET `Login`='$Login' WHERE `IdPers`='".$persID."'";
			$update_result = mysql_query($update_query) or die('Erreur SQL :<br />'.$update_query.'<br />'.mysql_error());
			$_SESSION['Login'] = $Login;
			echo"<div class='container'><div class='alert-box  centered success' style='text-align:center;' >
						Your Login has been successfully changed.
						<a href='' class='close'>&times;</a>
					</div></div>";
		}

	}
	else echo "<div class='container'><div class='alert-box  centered error' style='text-align:center;' >
						The <b>Current login</b> you entered wrong. Please try again.
						<a href='' class='close'>&times;</a>
					</div></div>";
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

	<title>Shift-Scheduler.com | Administration interface</title>
	<link rel="shortcut icon" type="image/x-icon" href="<?php echo $DossierIcones; ?>ischedule_logo1.ico">
  
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
<div class="row">
	<div class="five columns">
		<div class="panel">
			<div style=" text-align:center; margin:0 auto; padding:10px; border: 2px dashed #CCCCCC; background-color: #FFFFFF;">
				<?php 					
					echo "Welcome ".$Name."<br/>(".$NameDept.", ".$NameLoc.")";
				?>
			</div>
			<br/>
		</div>
	</div>

	<div class="five columns">
		<div class="panel">
			<div style=" text-align:center; margin:0 auto; padding:10px; border: 2px dashed #CCCCCC; background-color: #FFFFFF;">
				<?php echo date('l F j, Y');?>
			</div>
			<br/>
		</div>
	</div>
</div>

<h1>ADMINISTRATION INTERFACE</h1>
<br/>
<div class="row">
<div style="float:left;">
<!-- deconnection -->
<form name="deconnexion" method="post" action="./Admin/fonctions/_deconnexion.php">
<!--<fieldset>-->
	<button name="btdeconnexion" class="nice radius red button" type="submit" title="Log out from Administration">
	<img src="<?php echo $DossierIcones; ?>DELETE.png" alt="" /><span> Sign out</span></button>
<!--</fieldset>-->
</form>
</div>
</div> <!--end row-->

<br/>

<div class="row">
	<div class="twelve columns centered">
		<div class="panel">

<dl class="nice contained tabs">
  <dd><a href="#nice1" class="active">Events</a></dd>
  <dd><a href="#nice2">Schedules</a></dd>
   <dd><a href="#nice3">Requests</a></dd>
  <dd><a href="#nice4">Employees</a></dd>
  <dd><a href="#nice5">Managers</a></dd>
  <dd><a href="#nice7">Dashboard</a></dd>
  <dd><a href="#nice6">Password</a></dd>
</dl>

<ul class="nice tabs-content contained">
  <li class="active" id="nice1Tab">

 <div style="float:left;">
<form method="post" name="formvoirEvt" action="./Forms/week-events.php">
		<button name="btSeeWkEvt" class="nice medium radius blue button" type="submit" title="Events occuring this week">
		<img src="<?php echo $DossierIcones; ?>date.png" alt="Week display" width="24"/>Events of the week</button>
	</form>
</div> 
    
<div style="float:right;">
<form method="post" name="formvoirFiche" action="./Forms/see-all-event.php">
		<button name="btSeeEvt" class="nice medium radius blue button" type="submit" title="See all the schedules">
		<img src="<?php echo $DossierIcones; ?>VOIRfiche.png" alt="See all the events" />See all the events</button>
	</form>
</div>

<div style="float:right;">
<form method="post" name="formvoirFiche" action="./Forms/events.php">
		<input type="hidden" name="traiter" value="ADD" />
		<button name="btAddEvt" class="nice medium radius green button" type="submit" title="Add a new event">
		<img src="<?php echo $DossierIcones; ?>date_add.png" alt="Add an event" width="24"/>Add an event</button>
	</form>
</div>
<div class="clearfix"></div>
<br/>
<h2>Today's events</h2>
 <table>
			<thead>
			<tr style="border:1px dashed #CCCCCC">
				<td width="25%"></td>
				<th width="10%">Guests</th>
				<th width="25%">Time slot</th>
				<th>Duration</th>
				<td width="8%"></td>
				<td width="8%"></td>
			</tr>
			</thead>
			<?php 
	$DayEvt = date("Y-m-d");
		
			//Retrieve the position of each employee
			 $evt_query = "SELECT * FROM event  WHERE DayEvt = '$DayEvt' AND IdLoc = '".$IdLoc."' ORDER BY BegEvt ASC";
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
						<form method="post" name="formmodifier" action="./Forms/events.php">
								<input type="hidden" name="traiter" value="EDIT" />
								<input type="hidden" name="IdEvt" value="<?php  echo $evtID; ?>" />
								<button name="btMODIFIER" type="submit" title="Edit event" class="button">
									<img src="./Admin/icones/date_edit.png" alt="Edit event" width="24" /></button>
						</form>
					</div>
				</td>
				<td>
					<div style="float:left;">
						<form method="post" name="formmodifier" action="./evt_treatment.php" onClick="return confirm('Do you really want to delete this event?')">
								<input type="hidden" name="traiter" value="DELETE" />
								<input type="hidden" name="IdEvt" value="<?php  echo $evtID; ?>" />
								<button name="btMODIFIER" type="submit" title="Delete event" class="button">
									<img src="./Admin/icones/date_delete.png" alt="Delete event" width="24" /></button>
						</form>
					</div>
				</td>
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
     <a class="close-reveal-modal">&#215;</a>
</div>
				
		<?php 
			 } // End while for events
		} //End if  $evt_num
		 else
		 	{ ?>
			<tr style="border:1px dashed #CCCCCC">
				<td colspan="8"> <div align="center">No event scheduled for today.</div></td>
			</tr>
			
			<?php
			}
			
			if ($evt_num > 0)
		{
	 
			?>
			<tr style="border:1px dashed #CCCCCC">
				<td colspan="8" style="padding:5px;">
                
	<div style=" text-align:center;">
	<form method="post" name="formmodifier" action="./Forms/print-day-event.php" target="_blank">
	<!--<input type="hidden" name="traiter" value="MAIL" />-->
	<input type="hidden" name="day" value="<?php  echo $DayEvt; ?>" />
		<button name="btPrint" type="submit" title="Print event" class="medium radius button green">
		<img src="./Admin/icones/printer.png" alt="Print event" width="24" />Printable version</button>
	</form>
	</div>

				</td>
			</tr>
			<?php
		}
		
		?>
		</table>
  
  </li>
  
  <!--Schedules-->
  <li id="nice2Tab">

 <div style="float:left;">
<form method="post" name="formvoirSched" action="./Forms/week-schedules.php">
		<button name="btSeeSched" class="nice medium radius blue button" type="submit" title="Schedules of the week">
		<img src="<?php echo $DossierIcones; ?>calendar.png" alt="Week display" width="24"/>Schedules of the week</button>
	</form>
</div> 

 <div style="float:right;">
<form method="post" name="formvoirSched" action="./Forms/see-all-schedules.php">
		<button name="btSeeSched" class="nice medium radius blue button" type="submit" title="See all the schedules">
		<img src="<?php echo $DossierIcones; ?>VOIRfiche.png" alt="See all the schedules" />See all schedules</button>
	</form>
</div> 

<div style="float:right;">
<form method="post" name="formvoirFiche" action="./Forms/set-schedules.php">
		<input type="hidden" name="traiter" value="SET" />
		<button name="btAddSch" class="nice medium radius green button" type="submit" title="Set the schedules">
		<img src="<?php echo $DossierIcones; ?>calendar_add.png" alt="Set the schedules" width="24"/>Set the schedules</button>
	</form>
</div>

<br/>
<div class="clearfix"></div>
 <br/>
<h2>Today's schedules</h2>
 <table style="width:90%">
			<thead>
			<tr style="border:1px dashed #CCCCCC">
				<td></td>
				<th width="20%">Start of Shift</th>
				<th width="20%">End of Shift</th>
				<th>Duration</th>
				<td width="10%"></td>
			</tr>
			</thead>
<?php
	
	$Today = date("Y-m-d");
	
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
			   AND IdPers IN (SELECT IdPers FROM schedules WHERE Day='".$Today."')
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
	
	$sched_query = "SELECT * FROM schedules WHERE Day='".$Today."' AND IdPers = '".$persID."' ";
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
	elseif ($X <= $Y) $for = dateDiff($X, $Y) ;
		
		?>		
	
			<tr style="border:1px dashed #CCCCCC">
				<th><?php echo $FirstName." ".$LastName; ?></th>
			  	<td><?php echo $BegShift; ?></td>
				<td><?php echo $EndShift; ?></td>
				<td><?php echo $for; ?></td>
				<td ><div style="float:left;">
						<form method="POST" name="formEdit" action="Forms/edit-schedules.php">
								<input type="hidden" name="traiter" value="EDIT" />
								<input type="hidden" name="persID" value="<?php  echo $persID; ?>" />
								<input type="hidden" name="Day" value="<?php  echo $Today; ?>" />
								<input type="hidden" name="IdPost" value="<?php echo $postID; ?>" />
								<button name="btEditSched" type="submit" title="Edit schedule" class="blue button">
									<img src="./Admin/icones/calendar_edit.png" alt="Edit schedule" width="24" /></button>
						</form>
					</div>	</td>
			</tr>
			<?php
			
		} // Fin de la boucle	
		
	}// end if $nb_sched > 0
	
	elseif ($nb_sched == 0) 
		{ ?>
			<tr style="border:1px dashed #CCCCCC">
				<td colspan="8"> <div align="center">No schedule for today.</div></td>
			</tr>
			
			<?php
			}		
		} //End While $pers_row
	}// end if $pers_num> 0
	
	elseif ($pers_num == 0) 
		{ ?>
			<tr style="border:1px dashed #CCCCCC">
				<td colspan="8"> <div align="center">Nobody from this position has been scheduled for today.</div></td>
			</tr>
			
			<?php
			}		
	}// End while $post	
			?>			
			</table>
  </li>
  
  <!--Requests-->
    <li id="nice3Tab">
  
<div style="float:left;">
<form method="post" name="formvoirReq" action="./Forms/adm_request_off.php">
		<button name="btSeeReqOff" class="nice medium radius blue button" type="submit" title="See all the requests-off">
		<img src="<?php echo $DossierIcones; ?>VOIRfiche.png" alt="See all the pending requests-off" />See all the pending requests-off</button>
	</form>
</div>

  
<div style="float:right;">
<form method="post" name="formvoirReq" action="./Forms/adm_request_on.php">
		<button name="btSeeReqOn" class="nice medium radius green button" type="submit" title="See all the requests-on">
		<img src="<?php echo $DossierIcones; ?>VOIRfiche.png" alt="See all the pending requests-on" />See all the pending requests-on</button>
	</form>
</div>

<div class="clearfix"></div>
<br/>
  	<div class="row">
	<div class="six columns">
			<div style="margin:0 auto; padding:10px; border: 2px dashed #CCCCCC; background-color: #FFFFFF;">
				<h4 style="text-align:center">DAYS-OFF</h4>
							<table style="border:none;">
				<?php
					$reqt = new request(null);
					$TDOff = $reqt->TheDaysOff($IdDept) ;
					$nbReq = mysql_num_rows($TDOff);
					//echo $nbReq;
					if ($nbReq != 0)
						{
						?>
<div style="float:right;">
	<a href="Forms/see_request_off.php"> View All</a>
</div>
						<?php							
							while ( $row = mysql_fetch_array($TDOff))
							{
								$DayReq = stripslashes($row[2]);
								$BegReq = stripslashes($row[3]);
								$EndReq = stripslashes($row[4]);
								$Status = stripslashes($row[7]);
								$SubtOn = stripslashes($row[6]);
							
							?>
								<tr>
									<td><?php echo $DayReq." from ".$BegReq." to ".$EndReq." | ".$Status ; ?></td>
								</tr>
						<?php
							}
						}
						else {
						?>
								<tr>
									<td>No request saved.</td>
								</tr>
						<?php
						}
						?>
							</table>
			</div>
			</div> <!--End 6 cols-->
			
			
			<div class="six columns">
			<div style=" margin:0 auto; padding:10px; border: 2px dashed #CCCCCC; background-color: #FFFFFF;">
				<h4 style="text-align:center">DAYS-ON</h4>
							<table style="border:none;">
				<?php
					$reqt = new request(null);
					$TDOn = $reqt->TheDaysOn($IdDept) ;
					$nbReqt = mysql_num_rows($TDOn);
					//echo $nbReq;
					if ($nbReqt != 0)
						{
						?>
<div style="float:right;">
	<a href="Forms/see_request_on.php"> View All</a>
</div>
						<?php							
							while ( $row = mysql_fetch_array($TDOn))
							{
								$DayReq = stripslashes($row[2]);
								$BegReq = stripslashes($row[3]);
								$EndReq = stripslashes($row[4]);
								$Status = stripslashes($row[7]);
								$SubtOn = stripslashes($row[6]);
							
							?>
								<tr>
									<td><?php echo $DayReq." from ".$BegReq." to ".$EndReq." | ".$Status ; ?></td>
								</tr>
						<?php
							}
						}
						else {
						?>
								<tr>
									<td>No request saved.</td>
								</tr>
						<?php
						}
						?>
							</table>
			</div>
	</div><!--End six columns-->
	
</div> <!--End row-->
  </li>
  
  <!--Employees-->
  <li id="nice4Tab">
  	

<div style="float:right;">
<!-- ajouter -->
<form method="post" name="formajouter" action="./Forms/employees.php">
<!--<fieldset>-->
	<input type="hidden" name="traiter" value="ADD" />
	<button name="btAjouter" class="nice medium radius green button" type="submit" title="Add a new employee " style="vertical-align:middle;">
	<img src="<?php echo $DossierIcones; ?>user_add.png" width="24" alt="" /><span> Add an Employee</span></button>
<!--</fieldset>-->
</form>
</div>
<div style="float:right;">
<!-- ajouter -->
<form method="post" name="formajouter" action="./Forms/post.php">
<!--<fieldset>-->
	<input type="hidden" name="traiter" value="ADD" />
	<button name="btAjouter_pst" class="nice medium radius green button" type="submit" title="Add a new position ">
	<img src="<?php echo $DossierIcones; ?>role.png" width="24" alt="" /><span> Add a position</span></button>
<!--</fieldset>-->
</form>
</div>

<br/>  
<div class="clearfix"></div><br/>

<div class="panel">
	<div class="row">
		<div class="three centered columns">	
		<p style="text-align:center; padding:3px;">

<form name="PostChoice" id="PostChoice" method="GET" >		
		<select name="IdPost" id="IdPost" onChange="MM_jumpMenu('document',this,0)">
				<option value="<?php echo "admin.php#nice4"; ?>">Select a position</option>
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
            <option value="<?php echo "admin.php?IdPost=".$lgne[0]."#nice4"; ?>" <?php if ($lgne[0] == $IdPost) echo  'selected="selected"' ;?> ><?php echo $lgne[1]; ?></option>
            
            <?php
  			}
		}
	   ?>
          </select>
		 </form>		
	</p>

		<br/>
		</div>
	</div>
</div>

<br />

<?php
if((isset($_GET["IdPost"]))&&($_GET["IdPost"]!=0))
{		
	$IdPost = $_GET["IdPost"] ;
//query: List of positions
$post_query = "SELECT * FROM post WHERE IdPost = '".$IdPost."' AND IdDept = '".$_SESSION["IdDept"]."'";
$post_result = mysql_query($post_query) or die('Erreur SQL :<br />'.$post_query.'<br />'.mysql_error());

// loop for listing
while ($post_row = mysql_fetch_array($post_result))
{
	$postID    = 	$post_row['IdPost'];
	$postLabel = 	stripslashes($post_row['LabPost']);
?>	
<div class="panel">
<h3><?php echo $postLabel; ?></h3>

<?php 
// pagination
	$cible = "admin.php"; 	
	$end = 10; 
	
	$query = "SELECT COUNT(*) AS num 
				FROM person
               WHERE IdPost = '".$postID."' 
				";
	$nb_pages = mysql_fetch_array(mysql_query($query));
	$nb_pages = $nb_pages["num"];
	
	$stages = 3;
	
if (isset($_GET['pg'])) {
	$pg = $_GET['pg']; // On recupere le numero de la page dans l'URL
} else { // si c'est la premiere fois qu'on charge la page
	$pg = 1; // On se met sur la page 1 (par defaut)
}

	if($pg){
		$beg = ($pg - 1) * $end; 
	}else{
		$beg = 0;	
		}	
	
	// Initial page num setup
	if ($pg == 0){$pg = 1;}
	$prec = $pg - 1;	
	$suiv = $pg + 1;							
	$lastpg = ceil($nb_pages/$end);		
	$LastPgm1 = $lastpg - 1;					
	
	
	$pagination = '';
	if($lastpg > 1)
	{	
	

	
	
		$pagination .= "<ul class='pagination centered'>";
		// Previous
		if ($pg > 1){
			$pagination.= "<li><a href='$cible?pg=$prec&&IdPost=$postID#nice4'>previous</a></Li>";
		}else{
			$pagination.= "<li class='unavailable'>previous</li>";	}
			

		
		// Pages	
		if ($lastpg < 7 + ($stages * 2))	// Not enough pages to breaking it up
		{	
			for ($counter = 1; $counter <= $lastpg; $counter++)
			{
				if ($counter == $pg){
					$pagination.= "<li class='current'>$counter</li>";
				}else{
					$pagination.= "<li><a href='$cible?pg=$counter&&IdPost=$postID#nice4'>$counter</a></li>";}					
			}
		}
		elseif($lastpg > 5 + ($stages * 2))	// Enough pages to hide a few?
		{
			// Beginning only hide later pages
			if($pg < 1 + ($stages * 2))		
			{
				for ($counter = 1; $counter < 4 + ($stages * 2); $counter++)
				{
					if ($counter == $pg){
						$pagination.= "<li class='current'>$counter</li>";
					}else{
						$pagination.= "<li><a href='$cible?pg=$counter&&IdPost=$postID#nice4'>$counter</a></li>";}					
				}
				$pagination.= "...";
				$pagination.= "<a href='$cible?pg=$LastPgm1&&IdPost=$postID#nice4'>$LastPgm1</a>";
				$pagination.= "<a href='$cible?pg=$lastpg&&IdPost=$postID#nice4'>$lastpg</a>";		
			}
			// Middle hide some front and some back
			elseif($lastpg - ($stages * 2) > $pg && $pg > ($stages * 2))
			{
				$pagination.= "<li><a href='$cible?pg=1&&IdPost=$postID#nice4'>1</a></li>";
				$pagination.= "<li><a href='$cible?pg=2&&IdPost=$postID#nice4'>2</a></li>";
				$pagination.= "...";
				for ($counter = $pg - $stages; $counter <= $pg + $stages; $counter++)
				{
					if ($counter == $pg){
						$pagination.= "<li class='current'>$counter</li>";
					}else{
						$pagination.= "<li><a href='$cible?pg=$counter&&IdPost=$postID#nice4'>$counter</a></li>";}					
				}
				$pagination.= "...";
				$pagination.= "<li><a href='$cible?pg=$LastPgm1&&IdPost=$postID#nice4'>$LastPgm1</a></li>";
				$pagination.= "<li><a href='$cible?pg=$lastpg&&IdPost=$postID#nice4'>$lastpg</a></li>";		
			}
			// End only hide early pages
			else
			{
				$pagination.= "<li><a href='$cible?pg=1&&IdPost=$postID#nice4'>1</a></li>";
				$pagination.= "<li><a href='$cible?pg=2&&IdPost=$postID#nice4'>2</a></li>";
				$pagination.= "...";
				for ($counter = $lastpg - (2 + ($stages * 2)); $counter <= $lastpg; $counter++)
				{
					if ($counter == $pg){
						$pagination.= "<li class='current'>$counter</li>";
					}else{
						$pagination.= "<li><a href='$cible?pg=$counter&&IdPost=$postID#nice4'>$counter</a></li>";}					
				}
			}
		}
					
				// Next
		if ($pg < $counter - 1){ 
			$pagination.= "<li><a href='$cible?pg=$suiv&&IdPost=$postID#nice4'>next</a></li>";
		}else{
			$pagination.= "<li class='unavailable'>next</li>";
			}
			
		$pagination.= "</ul>";		
	
}	

//AND IdDept = '".$IdDept."'
// query: select all the employees
$pers_query = "SELECT * FROM person
               WHERE IdPost = '".$postID."'
				
			   ORDER BY LastName ASC
			   LIMIT $beg, $end";
$pers_result = mysql_query($pers_query) or die('Erreur SQL :<br />'.$pers_query.'<br />'.mysql_error());
$pers_nombre = mysql_num_rows($pers_result);
?>

<h4><?php echo $nb_pages; ?> Employee<?php if($nb_pages>1) { echo 's'; } ?></h4>
<!--<table id="dark"><tr style="border:1px dashed #CCCCCC"><td colspan="4">-->
<?php
if($pers_nombre>0) {
// loop for listing
while ($pers_row = mysql_fetch_array($pers_result))
{
	$persID    		= 	stripslashes($pers_row['IdPers']);
	$IdPers 		= 	psu_id($pers_row['IdPers']);
	$persFirstName	= 	stripslashes($pers_row['FirstName']);
	$persLastName	= 	stripslashes($pers_row['LastName']);
	$persEmail		= 	stripslashes($pers_row['Email']);
	$persPhone 		= 	phone_number(stripslashes($pers_row['Phone']));
	
	$persDOB		= 	stripslashes($pers_row['DOB']);
	$persDOB = date("F j, Y",strtotime($persDOB));
	
	$persWorkHrs	= 	stripslashes($pers_row['WorkHrs']);
    $persFirstDay	= 	stripslashes($pers_row['FirstDay']);
    $persAvatar		= 	stripslashes($pers_row['Avatar']);
	$IdPost 		= 	$pers_row['IdPost'];
	
	$post = new post($IdPost);
	$LabPost = $post ->LabPost;	
    $IdDept	= $post -> IdDept;
	
	$dept = new department ($IdDept);
	$NameDept = $dept -> NameDept;
	$IdLoc = $dept -> IdLoc;	
	
	$Location = new location($IdLoc);
	$NameLoc = $Location -> NameLoc;
	
	$skills = new skills($persID);
	$persSkill = $skills ->Skill;

?>

<table style="border:1px dashed #CCCCCC">
	<tbody>
		<tr>
		<td width="75%"><a href="" data-reveal-id="myModal<?php  echo $persID; ?>" data-animation="fadeAndPop" data-animationspeed="300" data-closeonbackgroundclick="true" data-dismissmodalclass="close-reveal-modal"><h4><?php echo $persLastName.", ".$persFirstName; ?></h4></a></td>
		<!-- supprimer -->
	<td style="width:8%;">
	<form method="post" name="formsupprimer" action="treatment.php" onClick="return confirm('Do you really want to delete?')">
	<!--<fieldset>-->
		<input type="hidden" name="traiter" value="DELETE" />
		<input type="hidden" name="persID" value="<?php echo $persID; ?>" />
		<button name="btSUPPRIMER" type="submit" title="Delete employee" class="button">
		<img src="<?php echo $DossierIcones; ?>user_delete.png" width="24" alt="Delete employee" /></button> 
	<!--</fieldset>-->
	</form>
	</td>
	
	<!-- edit employee -->
	<td style="width:8%;">
	<form method="post" name="formmodifier" action="./Forms/employees.php">
	<!--<fieldset>-->
		<input type="hidden" name="traiter" value="EDIT" />
		<input type="hidden" name="persID" value="<?php echo $persID; ?>" />
		<button name="btMODIFIER" type="submit" title="Edit employee" class="button">
		<img src="<?php echo $DossierIcones; ?>user_edit.png" width="24" alt="Edit employee" /></button>
	<!--</fieldset>-->
	</form>
	</td>
	
			<!-- See schedule -->
	<!--<td>
	<form method="post" name="formvoirFiche" action="./Forms/see-schedule.php">
		<input type="hidden" name="persID" value="<?php// echo $persID; ?>" />
		<button name="btMODIFIER" type="submit" title="See schedule" class="button">
		<img src="<?php //echo $DossierIcones; ?>VOIRfiche.png" alt="See schedule" /></button>
	</form>
	</td>	-->
	
	<!-- set schedule -->
<!--	<td>
	<form method="post" name="formmodifier" action="./Forms/set-schedule.php">
		<input type="hidden" name="traiter" value="SET" />
		<input type="hidden" name="persID" value="<?php// echo $persID; ?>" />
		<button name="btMODIFIER" type="submit" title="Set schedule" class="button">
		<img src="<?php //echo $DossierIcones;?>calendar_add.png" width="24" alt="Set schedule" width="24" /></button>
	</form>
	</td>-->

		</tr>
		</tbody>
	</table>
	
<div id="myModal<?php  echo $persID; ?>" class="reveal-modal xlarge">
     <h2>PROFILES</h2>
     <p class="lead"><?php echo $persLastName.", ".$persFirstName; ?>'s profile</p>
 <div class="row">

<div class="five columns">
<form>
<fieldset>
	<h4  style="text-align:center;">Personal information</h4>
			<p class="space">
				<label class="label15"  style="text-align:right; color:#21409A;">PSU ID: </label><?php echo $IdPers; ?>
			</p>	    
			<div class="clearfix"></div>
			<p class="space">
				<label class="label15"  style="text-align:right; color:#21409A;">Name: </label><?php echo $persFirstName." ".$persLastName; ?>
			</p>
			<div class="clearfix"></div>
		<p class="space">
				<label class="label15" style="text-align:right; color:#21409A;">Date of birth: </label><?php echo $persDOB; ?>
			</p>
			<div class="clearfix"></div>
		<p class="space">
				<label class="label15" style="text-align:right; color:#21409A;">Email: </label><?php echo $persEmail; ?>
			</p>
			<div class="clearfix"></div>
		<p class="space">
				<label class="label15"  style="text-align:right; color:#21409A;">Phone: </label><?php echo $persPhone; ?>
			</p>
			<div class="clearfix"></div>
		<p class="space">
				<label class="label15" style="text-align:right; color:#21409A;">Hours of work: </label><?php echo $persWorkHrs; ?>
			</p>
			<div class="clearfix"></div>
		<p class="space">
				<label class="label15" style="text-align:right; color:#21409A;">Position: </label><?php echo $LabPost; ?>
			</p>
			<div class="clearfix"></div>
		<p class="space">
				<label class="label15" style="text-align:right; color:#21409A;">Department: </label><?php echo $NameDept." - ".$NameLoc ;?>
			</p>
			<div class="clearfix"></div>
			
			<p class="space">
				<label class="label15" style="text-align:right; color:#21409A;">Skill: </label><?php echo $persSkill; ?>
			</p>
			<div class="clearfix"></div>
			
	</fieldset></form>
		</div> <!--End 5 cols-->
	
	<div class="four columns">
	<form>
		<fieldset>		
			<h4  style="text-align:center;">Availability</h4>
			<div class="clearfix"></div>
		<?php
			$Sunday = new sunday($persID);
			
			if ((isset($Sunday->BegSun)) && ($Sunday->BegSun != ''))
				{ ?>
			<p class="space">
			<label><img src="css/next.gif"/>Sunday <br/> &nbsp;&nbsp;from <strong><?php echo $Sunday ->BegSun; ?></strong> to <strong><?php echo $Sunday ->EndSun; ?></strong></label>
			</p>
			<div class="clearfix"></div>
			<?php }
			
			$Monday = new monday($persID);
			if ((isset($Monday ->BegMon)) && ($Monday ->BegMon != ''))
				{ ?>
			<p class="space">
			<label><img src="css/next.gif"/> Monday <br/> &nbsp;&nbsp;&nbsp;&nbsp;From <strong><?php echo $Monday ->BegMon; ?></strong> to <strong><?php echo $Monday ->EndMon; ?></strong></label>
			</p>
			<div class="clearfix"></div>
			<?php }
			
			$Tuesday = new tuesday($persID);
			if ((isset($Tuesday->BegTues)) && ($Tuesday->BegTues != ''))
				{ ?>
			<p class="space">
			<label><img src="css/next.gif"/> Tuesday <br/> &nbsp;&nbsp;&nbsp;&nbsp;From <strong><?php echo $Tuesday ->BegTues; ?></strong> to <strong><?php echo $Tuesday ->EndTues; ?></strong></label>
			</p>
			<div class="clearfix"></div>
			<?php }
			
			$Wednesday = new wednesday($persID);
			if ((isset($Wednesday ->BegWed)) && ($Wednesday ->BegWed != ''))
				{ ?>
			<p class="space">
			<label><img src="css/next.gif"/> Wednesday <br/> &nbsp;&nbsp;&nbsp;&nbsp;From <strong><?php echo $Wednesday ->BegWed; ?></strong> to <strong><?php echo $Wednesday ->EndWed; ?></strong></label>
			</p>
			<div class="clearfix"></div>
			<?php }
			
			$Thursday = new thursday($persID);
			if ((isset($Thursday ->BegThurs)) && ($Thursday ->BegThurs != ''))
				{ ?>
			<p class="space">
			<label><img src="css/next.gif"/> Thursday <br/> &nbsp;&nbsp;&nbsp;&nbsp;From <strong><?php echo $Thursday ->BegThurs; ?></strong> to <strong><?php echo $Thursday ->EndThurs; ?></strong></label>
			</p>
			<div class="clearfix"></div>
			<?php }
			
			$Friday = new friday($persID);
			if ((isset($Friday ->BegFri)) && ($Friday ->BegFri != ''))
				{ ?>
			<p class="space">
			<label><img src="css/next.gif"/> Friday <br/> &nbsp;&nbsp;&nbsp;&nbsp;From <strong><?php echo $Friday ->BegFri; ?></strong> to <strong><?php echo $Friday ->EndFri; ?></strong></label>
			</p>
			<div class="clearfix"></div>
			<?php }
			
			$Saturday = new saturday($persID);
			if ((isset($Saturday ->BegSat)) && ($Saturday ->BegSat != ''))
				{ ?>
			<p class="space">
			<label><img src="css/next.gif"/> Saturday <br/> &nbsp;&nbsp;&nbsp;&nbsp;From <strong><?php echo $Saturday ->BegSat; ?></strong> to <strong><?php echo $Saturday ->EndSat; ?></strong></label>
			</p>
			<div class="clearfix"></div>
			<?php }
			
			if ( (!isset($Sunday) || $Sunday->BegSun == '') && (!isset($Monday) || $Monday ->BegMon == '') && (!isset($Tuesday) || $Tuesday->BegTues == '') && (!isset($Wednesday) || $Wednesday ->BegWed == '') && (!isset($Thursday ) || $Thursday ->BegThurs == '') && (!isset($Friday ) || $Friday ->BegFri == '') && (!isset($Saturday ) || $Saturday ->BegSat == '') )
				{ ?>
			<p class="space">
			<label><?php echo $persFirstName." ".$persLastName; ?> is not or no longer available.</label>
			</p>
			<div class="clearfix"></div>
			<?php }
			?>
			
		</fieldset></form>
	</div><!--End 4 cols-->
			
	<div class="three columns">
			<img src="./Avatars/<?php echo $persAvatar;?>" style=" max-width:200px; float:left; margin:3px;"/>
	</div>
	
	</div> <!--End rows-->
 
     <a class="close-reveal-modal">&#215;</a>
</div>
				
<?php
} // Fin de la boucle
echo $pagination;
?>
<br/>
<?php
} // end if pers
	else { // no person
?>
 <div id="light" align="center">No employee for now.</div><br/>
<?php
} ?>
	</div> <!--End panel-->
	<br/>
	<?php
	
	}
}  // End if isset idpost
?>

  </li>
  
 <!-- managers-->
  <li id="nice5Tab">
  <div style="float:right;">
<!-- ajouter -->
<form method="post" name="formAddManager" action="./Forms/manager.php">
<!--<fieldset>-->
	<input type="hidden" name="traiter" value="ADD" />
	<button name="btAjouter" class="nice medium radius green button" type="submit" title="Add a new manager " style="vertical-align:middle;">
	<img src="<?php echo $DossierIcones; ?>user_add.png" width="24" alt="" /><span> Add a manager</span></button>
<!--</fieldset>-->
</form>
</div>
<?php
// pagination
$targetpage = "admin.php"; 	
	$limit = 60; 
	
	$query = "SELECT COUNT(*) AS num 
				FROM admin 
				WHERE IdPers IN (SELECT P.IdPers FROM person P, post Ps WHERE P.IdPost = Ps.IdPost AND Ps.IdDept = '".$_SESSION["IdDept"]."')";
	$total_pages = mysql_fetch_array(mysql_query($query));
	$total_pages = $total_pages["num"];
	
	$stages = 3;
	
if (isset($_GET['page'])) {
	$page = $_GET['page']; // On recupere le numero de la page dans l'URL
} else { // si c'est la premiere fois qu'on charge la page
	$page = 1; // On se met sur la page 1 (par defaut)
}

	if($page){
		$start = ($page - 1) * $limit; 
	}else{
		$start = 0;	
		}	
	
	// Initial page num setup
	if ($page == 0){$page = 1;}
	$prev = $page - 1;	
	$next = $page + 1;							
	$lastpage = ceil($total_pages/$limit);		
	$LastPagem1 = $lastpage - 1;					
	
	
	$paginate = '';
	if($lastpage > 1)
	{	
	

	
	
		$paginate .= "<ul class='pagination centered'>";
		// Previous
		if ($page > 1){
			$paginate.= "<li><a href='$targetpage?page=$prev#nice5'>previous</a></Li>";
		}else{
			$paginate.= "<li class='unavailable'>previous</li>";	}
			

		
		// Pages	
		if ($lastpage < 7 + ($stages * 2))	// Not enough pages to breaking it up
		{	
			for ($counter = 1; $counter <= $lastpage; $counter++)
			{
				if ($counter == $page){
					$paginate.= "<li class='current'>$counter</li>";
				}else{
					$paginate.= "<li><a href='$targetpage?page=$counter#nice5'>$counter</a></li>";}					
			}
		}
		elseif($lastpage > 5 + ($stages * 2))	// Enough pages to hide a few?
		{
			// Beginning only hide later pages
			if($page < 1 + ($stages * 2))		
			{
				for ($counter = 1; $counter < 4 + ($stages * 2); $counter++)
				{
					if ($counter == $page){
						$paginate.= "<li class='current'>$counter</li>";
					}else{
						$paginate.= "<li><a href='$targetpage?page=$counter#nice5'>$counter</a></li>";}					
				}
				$paginate.= "...";
				$paginate.= "<a href='$targetpage?page=$LastPagem1#nice5'>$LastPagem1</a>";
				$paginate.= "<a href='$targetpage?page=$lastpage#nice5'>$lastpage</a>";		
			}
			// Middle hide some front and some back
			elseif($lastpage - ($stages * 2) > $page && $page > ($stages * 2))
			{
				$paginate.= "<li><a href='$targetpage?page=1#nice5'>1</a></li>";
				$paginate.= "<li><a href='$targetpage?page=2#nice5'>2</a></li>";
				$paginate.= "...";
				for ($counter = $page - $stages; $counter <= $page + $stages; $counter++)
				{
					if ($counter == $page){
						$paginate.= "<li class='current'>$counter</li>";
					}else{
						$paginate.= "<li><a href='$targetpage?page=$counter#nice5'>$counter</a></li>";}					
				}
				$paginate.= "...";
				$paginate.= "<li><a href='$targetpage?page=$LastPagem1#nice5'>$LastPagem1</a></li>";
				$paginate.= "<li><a href='$targetpage?page=$lastpage#nice5'>$lastpage</a></li>";		
			}
			// End only hide early pages
			else
			{
				$paginate.= "<li><a href='$targetpage?page=1#nice5'>1</a></li>";
				$paginate.= "<li><a href='$targetpage?page=2#nice5'>2</a></li>";
				$paginate.= "...";
				for ($counter = $lastpage - (2 + ($stages * 2)); $counter <= $lastpage; $counter++)
				{
					if ($counter == $page){
						$paginate.= "<li class='current'>$counter</li>";
					}else{
						$paginate.= "<li><a href='$targetpage?page=$counter#nice5'>$counter</a></li>";}					
				}
			}
		}
					
				// Next
		if ($page < $counter - 1){ 
			$paginate.= "<li><a href='$targetpage?page=$next#nice5'>next</a></li>";
		}else{
			$paginate.= "<li class='unavailable'>next</li>";
			}
			
		$paginate.= "</ul>";		
	
	
}

?>	

  	<div class="clearfix"></div>
<br />
<div class="row">
<div class="panel">
<?php

//query: List of managers
$admin_query = "SELECT * FROM admin WHERE IdPers IN (SELECT IdPers FROM person P, post Ps WHERE P.IdPost = Ps.IdPost AND Ps.IdDept = '".$_SESSION["IdDept"]."') LIMIT $start, $limit";
$admin_result = mysql_query($admin_query) or die('Erreur SQL :<br />'.$admin_query.'<br />'.mysql_error());
$admin_nombre = mysql_num_rows($admin_result);

if($admin_nombre>0) {
?>
<h4><?php echo $admin_nombre; ?> Manager<?php if($admin_nombre>1) { echo 's'; } ?></h4>
<?php
// loop for listing
while ($admin_row = mysql_fetch_array($admin_result))
{
	$adminID    = 	$admin_row['IdPers'];
	$Login    = 	$admin_row['Login'];
	

    // Get page data
	$pers_query = "SELECT * FROM person
               WHERE IdPers = '".$adminID."'
			   ORDER BY LastName ASC";
$pers_result = mysql_query($pers_query) or die('Erreur SQL :<br />'.$pers_query.'<br />'.mysql_error());
		
// query: select all the employees
/*$pers_query = "SELECT * FROM person
               WHERE IdPers = '".$adminID."'
			   ORDER BY LastName ASC";
$pers_result = mysql_query($pers_query) or die('Erreur SQL :<br />'.$pers_query.'<br />'.mysql_error());*/
$pers_nombre = mysql_num_rows($pers_result);
if($pers_nombre>0) {

// loop for listing
while ($pers_row = mysql_fetch_array($pers_result))
{
	$persID    		= 	stripslashes($pers_row['IdPers']);
	$IdPers 		= 	psu_id($pers_row['IdPers']);
	$persFirstName	= 	stripslashes($pers_row['FirstName']);
	$persLastName	= 	stripslashes($pers_row['LastName']);
	$persEmail		= 	stripslashes($pers_row['Email']);
	$persPhone 		= 	phone_number(stripslashes($pers_row['Phone']));
	
	$persDOB		= 	stripslashes($pers_row['DOB']);
	$persDOB = date("F j, Y",strtotime($persDOB));
	
	$persWorkHrs	= 	stripslashes($pers_row['WorkHrs']);
    $persFirstDay	= 	stripslashes($pers_row['FirstDay']);
    $persAvatar		= 	stripslashes($pers_row['Avatar']);
    //$IdDept			=	$pers_row['IdDept'];
	$IdPost 		= 	$pers_row['IdPost'];
	
	$post = new post($IdPost);
	$LabPost = $post ->LabPost;	
    $IdDept	= $post -> IdDept;
	
	$dept = new department ($IdDept);
	$NameDept = $dept -> NameDept;
	$IdLoc = $dept -> IdLoc;	
	
	$Location = new location($IdLoc);
	$NameLoc = $Location -> NameLoc;
	
	
	$skills = new skills($persID);
	$persSkill = $skills ->Skill;

	
?>

<table style="border:1px dashed #CCCCCC">
	<tbody>
		<tr>
		<td width="80%"><a href="" data-reveal-id="Modal<?php echo $persID; ?>" data-animation="fadeAndPop" data-animationspeed="300" data-closeonbackgroundclick="true" data-dismissmodalclass="close-reveal-modal">
							<h4><?php echo $persFirstName." ".$persLastName; ?></h4></a></td>
	<?php
		if (!isset($Login))
			{ ?>
			
			<!-- Login & password -->
	<td style="width:8%;">
	<form method="post" name="formPwd" action="pwd_adm.php" >
		<input type="hidden" name="persID" value="<?php echo $persID; ?>" />
		<button name="btPwd" type="submit" title="Set Login & Password" class="white button">
		<img src="<?php echo $DossierIcones; ?>verrouiller.png" width="24" alt="Set Login & Password" /></button> 
	</form>
	</td>
	
		<?php	}
	?>
		<!-- Delete -->
	<td style="width:8%;">
	<form method="post" name="formsupprimer" action="adm_treatment.php" onClick="return confirm('Do you really want to delete?')">
		<input type="hidden" name="traiter" value="DELETE" />
		<input type="hidden" name="persID" value="<?php echo $persID; ?>" />
		<button name="btSUPPRIMER" type="submit" title="Delete manager" class="button">
		<img src="<?php echo $DossierIcones; ?>user_delete.png" width="24" alt="Delete manager" /></button> 
	</form>
	</td>
			<!-- See schedule -->
	<!--<td style="width:5%;">
	<form method="post" name="formvoirFiche" action="./Forms/see-schedule.php">
		<input type="hidden" name="persID" value="<?php// echo $persID; ?>" />
		<button name="btMODIFIER" type="submit" title="See schedule" class="button">
		<img src="<?php// echo $DossierIcones; ?>VOIRfiche.png" alt="See schedule" /></button>
	</form>
	</td>	-->
		</tr>
		</tbody>
	</table>

<div id="Modal<?php  echo $persID; ?>" class="reveal-modal xlarge">
     <h2>PROFILES</h2>
     <p class="lead"><?php echo $persLastName.", ".$persFirstName; ?>'s profile</p>
 <div class="row">

<div class="five columns">
<form>
<fieldset>
	<h4  style="text-align:center;">Personal information</h4>
			<p class="space">
				<label class="label15"  style="text-align:right; color:#21409A;">PSU ID: </label><?php echo $IdPers; ?>
			</p>	    
			<div class="clearfix"></div>
			<p class="space">
				<label class="label15"  style="text-align:right; color:#21409A;">Name: </label><?php echo $persFirstName." ".$persLastName; ?>
			</p>
			<div class="clearfix"></div>
		<p class="space">
				<label class="label15" style="text-align:right; color:#21409A;">Date of birth: </label><?php echo $persDOB; ?>
			</p>
			<div class="clearfix"></div>
		<p class="space">
				<label class="label15" style="text-align:right; color:#21409A;">Email: </label><?php echo $persEmail; ?>
			</p>
			<div class="clearfix"></div>
		<p class="space">
				<label class="label15"  style="text-align:right; color:#21409A;">Phone: </label><?php echo $persPhone; ?>
			</p>
			<div class="clearfix"></div>
		<p class="space">
				<label class="label15" style="text-align:right; color:#21409A;">Hours of work: </label><?php echo $persWorkHrs; ?>
			</p>
			<div class="clearfix"></div>
		<p class="space">
				<label class="label15" style="text-align:right; color:#21409A;">Position: </label><?php echo $LabPost; ?>
			</p>
			<div class="clearfix"></div>
		<p class="space">
				<label class="label15" style="text-align:right; color:#21409A;">Department: </label><?php echo $NameDept." - ".$NameLoc ;?>
			</p>
			<div class="clearfix"></div>
			
			<p class="space">
				<label class="label15" style="text-align:right; color:#21409A;">Skill: </label><?php echo $persSkill; ?>
			</p>
			<div class="clearfix"></div>
			
	</fieldset></form>
		</div> <!--End 6 cols/-->
	
	<div class="four columns">
	<form>
		<fieldset>		
			<h4  style="text-align:center;">Availability</h4>
			<div class="clearfix"></div>
		<?php
			$Sunday = new sunday($persID);
			
			if ((isset($Sunday->BegSun)) && ($Sunday->BegSun != ''))
				{ ?>
			<p class="space">
			<label><img src="css/next.gif"/>Sunday <br/> &nbsp;&nbsp;from <strong><?php echo $Sunday ->BegSun; ?></strong> to <strong><?php echo $Sunday ->EndSun; ?></strong></label>
			</p>
			<div class="clearfix"></div>
			<?php }
			
			$Monday = new monday($persID);
			if ((isset($Monday ->BegMon)) && ($Monday ->BegMon != ''))
				{ ?>
			<p class="space">
			<label><img src="css/next.gif"/> Monday <br/> &nbsp;&nbsp;&nbsp;&nbsp;From <strong><?php echo $Monday ->BegMon; ?></strong> to <strong><?php echo $Monday ->EndMon; ?></strong></label>
			</p>
			<div class="clearfix"></div>
			<?php }
			
			$Tuesday = new tuesday($persID);
			if ((isset($Tuesday->BegTues)) && ($Tuesday->BegTues != ''))
				{ ?>
			<p class="space">
			<label><img src="css/next.gif"/> Tuesday <br/> &nbsp;&nbsp;&nbsp;&nbsp;From <strong><?php echo $Tuesday ->BegTues; ?></strong> to <strong><?php echo $Tuesday ->EndTues; ?></strong></label>
			</p>
			<div class="clearfix"></div>
			<?php }
			
			$Wednesday = new wednesday($persID);
			if ((isset($Wednesday ->BegWed)) && ($Wednesday ->BegWed != ''))
				{ ?>
			<p class="space">
			<label><img src="css/next.gif"/> Wednesday <br/> &nbsp;&nbsp;&nbsp;&nbsp;From <strong><?php echo $Wednesday ->BegWed; ?></strong> to <strong><?php echo $Wednesday ->EndWed; ?></strong></label>
			</p>
			<div class="clearfix"></div>
			<?php }
			
			$Thursday = new thursday($persID);
			if ((isset($Thursday ->BegThurs)) && ($Thursday ->BegThurs != ''))
				{ ?>
			<p class="space">
			<label><img src="css/next.gif"/> Thursday <br/> &nbsp;&nbsp;&nbsp;&nbsp;From <strong><?php echo $Thursday ->BegThurs; ?></strong> to <strong><?php echo $Thursday ->EndThurs; ?></strong></label>
			</p>
			<div class="clearfix"></div>
			<?php }
			
			$Friday = new friday($persID);
			if ((isset($Friday ->BegFri)) && ($Friday ->BegFri != ''))
				{ ?>
			<p class="space">
			<label><img src="css/next.gif"/> Friday <br/> &nbsp;&nbsp;&nbsp;&nbsp;From <strong><?php echo $Friday ->BegFri; ?></strong> to <strong><?php echo $Friday ->EndFri; ?></strong></label>
			</p>
			<div class="clearfix"></div>
			<?php }
			
			$Saturday = new saturday($persID);
			if ((isset($Saturday ->BegSat)) && ($Saturday ->BegSat != ''))
				{ ?>
			<p class="space">
			<label><img src="css/next.gif"/> Saturday <br/> &nbsp;&nbsp;&nbsp;&nbsp;From <strong><?php echo $Saturday ->BegSat; ?></strong> to <strong><?php echo $Saturday ->EndSat; ?></strong></label>
			</p>
			<div class="clearfix"></div>
			<?php }
			
			if ( (!isset($Sunday) || $Sunday->BegSun == '') && (!isset($Monday) || $Monday ->BegMon == '') && (!isset($Tuesday) || $Tuesday->BegTues == '') && (!isset($Wednesday) || $Wednesday ->BegWed == '') && (!isset($Thursday ) || $Thursday ->BegThurs == '') && (!isset($Friday ) || $Friday ->BegFri == '') && (!isset($Saturday ) || $Saturday ->BegSat == '') )
				{ ?>
			<p class="space">
			<label><?php echo $persFirstName." ".$persLastName; ?> is not or no longer available.</label>
			</p>
			<div class="clearfix"></div>
			<?php }
			?>
			
		</fieldset></form>
	</div><!--End 3 cols-->
			
	<div class="three columns">
			<img src="./Avatars/<?php echo $persAvatar;?>" style=" max-width:200px; float:left; margin:3px;"/>
	</div>
	
	</div> <!--End rows-->
 
     <a class="close-reveal-modal">&#215;</a>
</div>	
<?php
} // Fin de la boucle
} // end if
	else { // no manager
?>
 <div id="light" align="center">No manager for now.</div>
<?php
}
	?>
<!--</td></tr></table>	-->
	<?php
}
} 

echo $paginate;
?><br/>

	</div><!--End panel--> 
</div> <!--End row-->
<br/>
  </li>
  
   <!--Dashbord-->
  <li id="nice7Tab">
  
	  
 <div style="float:left;">
<form method="post" name="formvoirNt" action="./Forms/notes_full_list.php">
		<button name="btSeeNt" class="nice large radius blue button" type="submit" title="List of notes">
		<img src="<?php echo $DossierIcones; ?>note.png" alt="" width="24"/>List of notes</button>
	</form>
</div> 

<div style="float:right;">
	<!-- ajouter -->
	<form method="post" name="formAddNote" action="./Forms/notes.php">
	<!--<fieldset>-->
		<input type="hidden" name="traiter" value="ADD" />
		<button name="btAjouter" class="nice medium radius green button" type="submit" title="Add a new note " style="vertical-align:middle;">
		<img src="Admin/icones/note_add.png" width="24" alt="" /><span> Add a note</span></button>
	<!--</fieldset>-->
	</form>
	</div>
<div class="clearfix"></div>
<br/>
<?php
// pagination
$targetpage = "admin.php"; 	
	$limit = 10; 
	
	$query = "SELECT COUNT(*) AS num 
				FROM notes 
				WHERE IdDept = '".$_SESSION["IdDept"]."'";
	$total_pages = mysql_fetch_array(mysql_query($query));
	$total_pages = $total_pages["num"];
	
	$stages = 3;
	
if (isset($_GET['page'])) {
	$pge = $_GET['page']; // On recupere le numero de la page dans l'URL
} else { // si c'est la premiere fois qu'on charge la page
	$pge = 1; // On se met sur la page 1 (par defaut)
}

	if($pge){
		$start = ($pge - 1) * $limit; 
	}else{
		$start = 0;	
		}	
	
	// Initial page num setup
	if ($pge == 0){$pge = 1;}
	$prev = $pge - 1;	
	$next = $pge + 1;							
	$lastpage = ceil($total_pages/$limit);		
	$LastPagem1 = $lastpage - 1;					
	
	
	$paginate = '';
	if($lastpage > 1)
	{	
		$paginate .= "<ul class='pagination centered'>";
		// Previous
		if ($pge > 1){
			$paginate.= "<li><a href='$targetpage?page=$prev#nice7'>previous</a></Li>";
		}else{
			$paginate.= "<li class='unavailable'>previous</li>";	}
			

		
		// Pages	
		if ($lastpage < 7 + ($stages * 2))	// Not enough pages to breaking it up
		{	
			for ($counter = 1; $counter <= $lastpage; $counter++)
			{
				if ($counter == $pge){
					$paginate.= "<li class='current'>$counter</li>";
				}else{
					$paginate.= "<li><a href='$targetpage?page=$counter#nice7'>$counter</a></li>";}					
			}
		}
		elseif($lastpage > 5 + ($stages * 2))	// Enough pages to hide a few?
		{
			// Beginning only hide later pages
			if($pge < 1 + ($stages * 2))		
			{
				for ($counter = 1; $counter < 4 + ($stages * 2); $counter++)
				{
					if ($counter == $pge){
						$paginate.= "<li class='current'>$counter</li>";
					}else{
						$paginate.= "<li><a href='$targetpage?page=$counter#nice7'>$counter</a></li>";}					
				}
				$paginate.= "...";
				$paginate.= "<a href='$targetpage?page=$LastPagem1#nice7'>$LastPagem1</a>";
				$paginate.= "<a href='$targetpage?page=$lastpage#nice7'>$lastpage</a>";		
			}
			// Middle hide some front and some back
			elseif($lastpage - ($stages * 2) > $pge && $pge > ($stages * 2))
			{
				$paginate.= "<li><a href='$targetpage?page=1#nice7'>1</a></li>";
				$paginate.= "<li><a href='$targetpage?page=2#nice7'>2</a></li>";
				$paginate.= "...";
				for ($counter = $pge - $stages; $counter <= $pge + $stages; $counter++)
				{
					if ($counter == $pge){
						$paginate.= "<li class='current'>$counter</li>";
					}else{
						$paginate.= "<li><a href='$targetpage?page=$counter#nice7'>$counter</a></li>";}					
				}
				$paginate.= "...";
				$paginate.= "<li><a href='$targetpage?page=$LastPagem1#nice7'>$LastPagem1</a></li>";
				$paginate.= "<li><a href='$targetpage?page=$lastpage#nice7'>$lastpage</a></li>";		
			}
			// End only hide early pages
			else
			{
				$paginate.= "<li><a href='$targetpage?page=1#nice7'>1</a></li>";
				$paginate.= "<li><a href='$targetpage?page=2#nice7'>2</a></li>";
				$paginate.= "...";
				for ($counter = $lastpage - (2 + ($stages * 2)); $counter <= $lastpage; $counter++)
				{
					if ($counter == $pge){
						$paginate.= "<li class='current'>$counter</li>";
					}else{
						$paginate.= "<li><a href='$targetpage?page=$counter#nice7'>$counter</a></li>";}					
				}
			}
		}
					
				// Next
		if ($pge < $counter - 1){ 
			$paginate.= "<li><a href='$targetpage?page=$next#nice7'>next</a></li>";
		}else{
			$paginate.= "<li class='unavailable'>next</li>";
			}
			
		$paginate.= "</ul>";		
	
	
}

?>	

  	<div class="row">
		<div class="twelve columns">
			<div class="panel">
<?php

//query: List of managers
$notes_query = "SELECT * FROM notes WHERE IdDept = '".$_SESSION["IdDept"]."' ORDER BY DateNt Desc LIMIT $start, $limit";
$notes_result = mysql_query($notes_query) or die('Erreur SQL :<br />'.$notes_query.'<br />'.mysql_error());
$notes_nombre = mysql_num_rows($notes_result);

if($notes_nombre > 0) {
?>
<h4><?php echo $notes_nombre; ?> note<?php if($notes_nombre>1) { echo 's'; } ?></h4>
<table style="border:1px dashed #CCCCCC">
	<tbody>
<?php
// loop for listing
while ($notes_row = mysql_fetch_array($notes_result))
{
	$notesID = 		$notes_row['IdNt'];
	$notesTitle = 	stripslashes($notes_row['TitleNt']);
	$notesContent = 	stripslashes($notes_row['ContentNt']);
	$notesDate = 	$notes_row['DateNt'];
	$notesPhoto = 	$notes_row['PhotoNt'];
	$notesFiche = 	$notes_row['FileNt'];
	
?>
		<tr style="border:1px dashed #CCCCCC">
			<td width="25%"><?php echo date('M d, Y @ h:i A', $notesDate); ?></td>
			
			<td><h2 style="text-align:left;"><?php echo $notesTitle; ?></h2></td>
			<!-- see -->
	<td width="8%">
	<form method="post" name="formvoirFiche" action="./Forms/thenote.php">
		<input type="hidden" name="notesID" value="<?php echo $notesID; ?>" />
		<button name="btSee" type="submit" title="See note" class="button">
		<img src="Admin/icones/VOIRfiche.png" alt="" width="24" /></button>
	</form>
	</td>
	<!-- edit -->
	<td width="8%">
	<form method="post" name="formmodifier" action="./Forms/notes.php">		
		<input type="hidden" name="traiter" value="EDIT" />
		<input type="hidden" name="notesID" value="<?php echo $notesID; ?>" />
		<button name="btMODIFIER" type="submit" title="Edit note" class="button">
		<img src="Admin/icones/note_edit.png" width="24" alt="" /></button>
	</form>
	</td>
	<!-- delete -->
	<td width="8%">
	<form method="post" name="formdelete" action="./notes_treatment.php">
		<input type="hidden" name="traiter" value="DELETE" />
		<input type="hidden" name="notesID" value="<?php echo $notesID; ?>" />
		<button name="btMODIFIER" type="submit" title="Edit note" class="button">
		<img src="Admin/icones/note_delete.png" width="24" alt="" /></button>
	</form>
	</td>
		</tr>
<?php
	} //End While
?>
	</tbody>
</table>
<br/>
<?php
} //End if
elseif ($notes_nombre == 0) {
	?>
	 <div align="center">There is no note for now.</div><br/>
	
	<?php
	}

?><br/>
<p align="center"><?php echo $paginate;?></p>
<br/>

	</div> <!--End panel-->
		</div> <!--End 12 columns-->   
   </div> <!--End row-->
  </li>
  
  <!--Password-->
  <li id="nice6Tab">
  	<div class="row">
                                        <div class="six columns">
                                            <form class="nice" id="ChPass" name="ChPass" method="post" enctype="multipart/form-data" action="">
                                                <fieldset>
                                                    <legend><h4>Change password</h4></legend>
                                                    <p>
                                                        <label>Current password  </label>
                                                        <input id="current" name="current" size="20" type="password" placeholder="Enter your current password" required/>
                                                    </p>
                                                    <p>
                                                        <label>New password </label>
                                                        <input id="password" name="password" type="password" placeholder="Enter your new password" required/>
                                                    </p>
                                                    <p>
                                                        <label>New password check  </label>
                                                        <input id="check" name="check" type="password" placeholder="Enter your new password again" data-equals="password" required />
                                                    </p>
                                                    <p style="text-align:center;">
                                                        <button name="pwdsubmit" type="submit" title="Change password" class="large radius green button">
                                                            <img src="icons/OK.png" alt="" />Change password</button>
                                                    </p>
                                                </fieldset>
                                            </form>
                                        </div> <!--End 6 columns-->

                                        <div class="six columns">
                                            <form class="nice" id="ChLogin" name="ChLogin" method="post" enctype="multipart/form-data" action="">
                                                <fieldset>
                                                    <legend><h4>Change login</h4></legend>
                                                    <p>
                                                        <label>Current login </label>
                                                        <input id="currentLog" type="text" name="currentLog" placeholder="Enter your current login" required/>
                                                    </p>
                                                    <p>
                                                        <label>New Login  </label>
                                                        <input id="newLog" type="text" name="newLog" placeholder="Enter your new login" required/>
                                                    </p>

                                                    <p style="text-align:center;">
                                                        <button name="logsubmit" type="submit" title="Change login" class="large radius green button">
                                                            <img src="icons/OK.png" alt="" />Change login</button>
                                                    </p>
                                                </fieldset>
                                            </form>
                                        </div> <!--End 6 columns-->

                                    </div> <!--End row-->
  </li>
</ul>

<br/>
</div> <!--End panel-->
</div><!-- End 12 columns-->
</div><!--End row-->

<br/>
</div>

<div id="footer"> <?php include("footer.php");?></div>

	<!-- Included JS Files -->
	<script src="js/jquery.min.js"></script>
	<script src="js/foundation.js"></script>
	<script src="js/app.js"></script>


</body>
</html>