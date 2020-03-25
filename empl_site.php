<?php 
// protection de page ADMIN
    include_once('./Admin/fonctions/_protectpage.php');
// Parametres de Connexion a la BD
	include_once('connexion.php');   
// Classes
	include_once("./Model/class.person.php");	
	include_once("./Model/class.employee.php");	
	include_once("./Model/class.request.php");	
	include_once("./Model/class.department.php");
	include_once("./Model/class.location.php");
	include_once('Admin/fonctions/functions.php');	
	
// DOSSIER des ICONES (administration)
	$DossierIcones = './Admin/icones/';
	
	$IdDept = $_SESSION["IdDept"];
	$Department = new department($IdDept);
	$LocID = $Department -> IdLoc;
	$NameDept = $Department -> NameDept;
	
	$Location = new location($LocID);
	$NameLoc = $Location -> NameLoc;
	
	if(isset($_SESSION["IdEmp"]))
		$persID = $_SESSION["IdEmp"];
	else
		$persID = $_SESSION["IdAdmin"];
		
	$person = new person($persID);
	$FirstName = $person -> FirstName;
	$LastName =  $person -> LastName;
	$Name = $person -> FirstName." ".$person -> LastName;

 
 //saving a request of days-on/off
if (isset($_POST['btRequest']))
	{
		$TypeReq	= mysql_real_escape_string($_POST['TypeReq']);
		$DayReq		= mysql_real_escape_string($_POST['DayReq']);
		$BegReq		= mysql_real_escape_string($_POST['BegReq']);
		$EndReq		= mysql_real_escape_string($_POST['EndReq']);
		$Reason		= mysql_real_escape_string($_POST['Reason']);
		$Status		= "PENDING";
		$TimeReqSub = '';
		
$ReqDay = new request($DayReq);
$theday = $ReqDay -> DayReq;

if ( $theday == $DayReq )
	{	
		echo"<div class='container'><div class='alert-box error'  style='text-align:center;'>
						Sorry! You can make only one request a day and you have already made one for ".$DayReq."
						<a href='' class='close'>&times;</a>
					</div></div>";
	}
	else {
		
		$request = new request(null);
		if ($request -> AddReq($persID, $TypeReq, $DayReq, $BegReq, $EndReq, $Reason, $TimeReqSub, $Status))
				{
					echo"<div class='container'><div class='alert-box success'  style='text-align:center;'>
							Your request has been submitted.
						<a href='' class='close'>&times;</a>
						</div></div>";
				}
			}
	
	}
 
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
			$update_query = "UPDATE employee SET `Pwd`='$Pwd' WHERE `IdPers`='".$persID."'";
			$update_result = mysql_query($update_query) or die('Erreur SQL :<br />'.$update_query.'<br />'.mysql_error());
			$_SESSION['Pwd'] = $Pwd;
			echo"<div class='container'><div class='alert-box success'  style='text-align:center;'>
						Your password has been successfully changed.
						<a href='' class='close'>&times;</a>
					</div></div>";
		}

    else

        echo "<div class='container'><div class='alert-box error' style='text-align:center;'>
					The new passwords you entered do not match.
					<a href='' class='close'>&times;</a>
				</div></div>";
	}
	else echo "<div class='container'><div class='alert-box error' style='text-align:center;'>
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
			$update_query = "UPDATE employee SET `Login`='$Login' WHERE `IdPers`='".$persID."'";
			$update_result = mysql_query($update_query) or die('Erreur SQL :<br />'.$update_query.'<br />'.mysql_error());
			$_SESSION['Login'] = $Login;
			echo"<div class='container'><div class='alert-box success'  style='text-align:center;'>
						Your Login has been successfully changed.
						<a href='' class='close'>&times;</a>
					</div></div>";
		}

	}
	else echo "<div class='container'><div class='alert-box error' style='text-align:center;'>
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

	<title>Shift-Scheduler.com | Employees' schedule</title>
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
	
	<!-- jQuery Library + ALL jQuery Tools -->
<script src="http://cdn.jquerytools.org/1.2.7/full/jquery.tools.min.js"></script>
<!-- dateinput styling -->
<link rel="stylesheet" type="text/css" href="css/dateinput.css"/>

<!--Timepicker-->	
    <script type="text/javascript" src="./js/jquery.ui.core.min.js"></script>	
    <script type="text/javascript" src="./js/jquery.ui.timepicker.js?v=0.3.0"></script>
	<script type="text/javascript" src="./js/jquery.ui.widget.min.js"></script>
    <script type="text/javascript" src="./js/jquery.ui.tabs.min.js"></script>
    <script type="text/javascript" src="./js/jquery.ui.position.min.js"></script>
 <!--timepicker styling-->
	<link rel="stylesheet" href="./css/jquery-ui-1.8.21.custom.css" type="text/css" />
    <link rel="stylesheet" href="./css/jquery.ui.timepicker.css?v=0.3.0" type="text/css" />


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
			<br />
		</div>
	</div>

	<div class="four columns ">
		<div class="panel">
			<div style="width:230px; text-align:center; margin:0 auto; padding:10px; border: 2px dashed #CCCCCC; background-color: #FFFFFF;">
				<?php echo date('l, F j, Y');?>
			</div>
			<br/>
		</div>
	</div>
</div>


<h1>USER INTERFACE</h1>
<br/>
<div class="row">
<div style="float:left;">
<!-- deconnection -->
<form name="deconnexion" method="post" action="./Admin/fonctions/_deconnexion.php">
	<button name="btdeconnexion" class="medium radius button red" type="submit" title="Log out">
	<img src="<?php echo $DossierIcones; ?>DELETE.png" alt="" /><span>Sign out</span></button>
</form>
</div>
</div>
<br/><br/>
<div class="row">
			<div class="twelve columns">
			<div class="panel">


<dl class="nice tabs contained">
  <dd><a href="#simpleContained1" class="active">Schedules</a></dd>
  <dd><a href="#simpleContained2">Requests </a></dd>
  <dd><a href="#simpleContained3">Messages </a></dd>
  <dd><a href="#simpleContained4">Birthdays</a></dd>
  <dd><a href="#simpleContained5">Password </a></dd>
</dl>

<ul class="nice tabs-content contained">
  <li class="active" id="simpleContained1Tab">
  
   <div style="float:left;">
<form method="post" name="formvoirSched" action="./Forms/emp-week-schedules.php">
		<button name="btSeeSched" class="nice medium radius blue button" type="submit" title="Week display">
		<img src="<?php echo $DossierIcones; ?>calendar.png" alt="Week display" width="24"/>All schedules for this week</button>
	</form>
</div> 

 <div style="float:right;">
<form method="post" name="formvoirSched" action="./Forms/my-week-schedule.php">
		<button name="btSeeSched" class="nice medium radius blue button" type="submit" title="Week display">
		<img src="<?php echo $DossierIcones; ?>calendar.png" alt="Week display" width="24"/>My schedule for this week</button>
	</form>
</div> 
<br/>
<div class="clearfix"></div>
<br/>

<h2>Today's schedules</h2>
  	<table style="width:80%">
			<thead>
			<tr style="border:1px dashed #CCCCCC">
				<td></td>
				<th width="20%">Start of Shift</th>
				<th width="20%">End of Shift</th>
				<th>Duration</th>
			</tr>
			</thead>

  <?php
  	$today = date('Y-m-d');
	$sched_query = "SELECT * FROM schedules WHERE Day='".$today."' AND IdPers = '".$persID."' ";
	$sched_result = mysql_query($sched_query) or die('Erreur SQL :<br />'.$sched_query.'<br />'.mysql_error());
	$nb_sched = mysql_num_rows($sched_result);
	
if ($nb_sched > 0)
	{
	?>
  
<!-- <div class="row"> 
<div style="float:right;">
<form method="post" name="formvoirFiche" action="./Forms/see-all-schedule-emp.php">
		<button name="btMODIFIER" class="medium button blue" type="submit" title="See all the schedules">
		<img src="<?php// echo $DossierIcones; ?>VOIRfiche.png" alt="See all the schedules" />See all schedules</button>
	</form>
</div>
</div>-->
<br/>
<div class="clearfix"></div>

<?php 
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
				
			</tr>
			<?php
			
		} // Fin de la boucle	
		
	}// end if $nb_sched > 0
	
	elseif ($nb_sched == 0) 
		{ ?>
			<tr style="border:1px dashed #CCCCCC">
				<th><?php echo $FirstName." ".$LastName; ?></th>
				<td colspan="3"> <div align="center">You have not been scheduled for today.</div></td>
			</tr>
			
			<?php
			}		
?>
 </table>
  </li>
  
   <!--Requests for days off/on-->
  <li id="simpleContained2Tab"> 

<div class="row">
	<div class="six columns">
	<div style="margin:0 auto; padding:10px; border: 2px dashed #CCCCCC; background-color: #FFFFFF;">
	<form id="ReqForm" method="post" enctype="multipart/form-data" action="">
	<!--<fieldset>-->
	<input type="hidden" name="persID" value="<?php echo $persID; ?>" />
		<p style="display:inline;"><label class="label15" style="text-align:right;" for="typeReq">Type of request </label>
				<select id="TypeReq" name="TypeReq" class="right"required="required" style="float:left;">
					<option value="" selected="selected">Please select one type</option>
					<option value="DAY-OFF">Day-off (NOT to work)</option>
					<option value="DAY-ON">Day-on (to work)</option>
				</select>	</p>	
				<div class="clearfix"></div><br/>	
				
		<p><label for="DayReq">Day requested </label>
		<input type="date" id="DayReq" name="DayReq" min="5" required placeholder="Pick one day"/>
		</p>
		<p><label for="BegReq">Start of request </label>
		<input type="text" id="BegReq" name="BegReq" required placeholder="Start of time - on/off"/>
		</p>
		<p><label for="EndReq">End of request </label>
		<input type="text" id="EndReq" name="EndReq" required placeholder="End of time - on/off"/>
		</p>
		<p><label for="Reason">Reason </label>	<br/>
		<textarea id="Reason" name="Reason" placeholder="Enter the reason why you are requesting that day ..." required></textarea>
		</p>
		<div class="clearfix"></div>
		<button name="btRequest" class="medium radius button blue" type="submit" title="Submit my request">
		<img src="<?php echo $DossierIcones; ?>date_next.png" alt="Send request" width="24" />Send request</button>
		
		<button name="btReset" class="medium radius button blue" type="reset" title="Reset the form">
		<img src="<?php echo $DossierIcones; ?>update.png" alt="Reset form" width="24"/>Reset</button>
		<div class="clearfix"></div><br/>
		<!--</fieldset>-->
</form>
</div>
	</div> <!--End six columns-->
	
	<div class="six columns">
			<div style="margin:0 auto; padding:10px; border: 2px dashed #CCCCCC; background-color: #FFFFFF;">
				<h4 style="text-align:center">DAYS-OFF</h4>
							<table style="border:none;">
				<?php
					$reqt = new request(null);
					$MDOff = $reqt->MyDaysOff($persID) ;
					$nbReq = mysql_num_rows($MDOff);
					//echo $nbReq;
					if ($nbReq != 0)
						{
						?>
<div style="float:right;">
	<a href="Forms/request_off.php"> View All</a>
</div>
						<?php							
							while ( $row = mysql_fetch_array($MDOff))
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
			<br/>
			
			<div style=" margin:0 auto; padding:10px; border: 2px dashed #CCCCCC; background-color: #FFFFFF;">
				<h4 style="text-align:center">DAYS-ON</h4>
							<table style="border:none;">
				<?php
					$reqt = new request(null);
					$MDOn = $reqt->MyDaysOn($persID) ;
					$nbReqt = mysql_num_rows($MDOn);
					//echo $nbReq;
					if ($nbReqt != 0)
						{
						?>
<div style="float:right;">
	<a href="Forms/request_on.php"> View All</a>
</div>
						<?php							
							while ( $row = mysql_fetch_array($MDOn))
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

<br clear="all"/>
</li>

<!--Messages-->
 <li id="simpleContained3Tab">
 <!-- Menu-->
  <div class="row">
	<div class="three columns">
	<?php
	$Name = $person -> FirstName." ".$person -> LastName;
	$msg_query = "SELECT * FROM messages WHERE `ToEmp` = '".$Name."' AND `Read` = '0' AND `Deleted` = '0' ";
	$msg_result = mysql_query($msg_query) or die('Erreur SQL :<br />'.$msg_query.'<br />'.mysql_error());
	$nb_msg = mysql_num_rows($msg_result);
	?>
			<div style="text-align:left; margin:0px 10px 5px 3px; padding:10px; border: 2px dashed #CCCCCC; background-color: #FFFFFF;">
				<h4 style="text-align:center">Menu</h4>
				<p><a href="messages/send.php">Compose</a></p>
				<p><a href="messages/inbox.php">Inbox <?php if ($nb_msg > 0) echo "<strong>(".$nb_msg.")</strong>"; ?></a></p>
				<p><a href="messages/outbox.php">Outbox</a></p>
				<p><a href="messages/trash.php">Trash</a></p>
			</div><br/>
	</div> <!--End 3 cols-->
</div> <!--End row--!-->
		
		
  </li>
  
  <!--Birthdays-->
  <li id="simpleContained4Tab">
  	<div class="row">
<div class="six columns">
			<!--<div class="panel">-->
				<div style="text-align:center; margin:0 auto; padding:10px; border: 2px dashed #CCCCCC; background-color: #FFFFFF;">
					<h4 style="text-align:center">Birthday</h4>
					<?php
					$today = date('m-d');
					$birth_query = "SELECT * FROM person ";
					$birth_result = mysql_query($birth_query) or die('Erreur SQL :<br />'.$birth_query.'<br />'.mysql_error());
					$birth_nombre = 0 ;
				
				
					while ($row = mysql_fetch_array($birth_result))
						{
						$persID = $row['IdPers'];
						$FirstName = stripslashes($row['FirstName']);
						$LastName = stripslashes($row['LastName']);
						$IdPost = $row['IdPost'];
						
						$DOB = $row['DOB'];
						$jour = strtotime($DOB) ;
						$Day = date('m-d',$jour);
						
						$post_query = "SELECT * FROM post WHERE IdPost = '".$IdPost."'";
						$post_result = mysql_query($post_query) or die('Erreur SQL :<br />'.$post_query.'<br />'.mysql_error());
						while ($post_row = mysql_fetch_array($post_result))
							{
								$postID    = 	$post_row['IdPost'];
								$postLabel = 	stripslashes($post_row['LabPost']);
								$IdDept    = 	stripslashes($post_row['IdDept']);
							}						
						
						$dept_query = "SELECT * FROM department WHERE IdDept = '".$IdDept."'";
						$dept_result = mysql_query($dept_query) or die('Erreur SQL :<br />'.$dept_query.'<br />'.mysql_error());
						while ($dept_row = mysql_fetch_array($dept_result))
							{
								$deptID    = 	$dept_row['IdDept'];
								$deptName = 	stripslashes($dept_row['NameDept']);
								$LocID = 	stripslashes($dept_row['IdLoc']);
								
								$Location = new location($LocID);
								$NameLoc = $Location -> NameLoc;
							}						
						
						if ($Day == $today)
						{
						?>
						<p style="text-align:center;"><?php echo $FirstName." ".$LastName." (".$postLabel.", ".$NameLoc.")" ;?></p>
						<?php
						$birth_nombre = $birth_nombre + 1;	
							} //End if
							
						}//End while
								
					if ($birth_nombre == 0 )
						{ 
							echo "<p style='text-align:center;'>No birthday today.</p>";
								}
				
							?>
				</div>
			<br />
					
			<!--</div>--> <!--End panel-->
</div><!-- End 6 columns-->

<div class="six columns">
			<!--<div class="panel">		-->
				<div style="text-align:center; margin:0 auto; padding:10px; border: 2px dashed #CCCCCC; background-color: #FFFFFF;">
					<h4 style="text-align:center">Anniversary</h4>
					<?php
					
					$start_query = "SELECT * FROM person ";
					$start_result = mysql_query($start_query) or die('Erreur SQL :<br />'.$start_query.'<br />'.mysql_error());
					$start_nombre = 0 ;
					
						
					while ($row = mysql_fetch_array($start_result))
						{
						$persID = $row['IdPers'];
						$FirstName = stripslashes($row['FirstName']);
						$LastName = stripslashes($row['LastName']);
						$IdPost = $row['IdPost'];
						
						$FirstDay = $row['FirstDay'];
						$jr = strtotime($FirstDay);
						$start = date('m-d',$jr);
						
						$post_query = "SELECT * FROM post WHERE IdPost = '".$IdPost."'";
						$post_result = mysql_query($post_query) or die('Erreur SQL :<br />'.$post_query.'<br />'.mysql_error());
						while ($post_row = mysql_fetch_array($post_result))
							{
								$postID    = 	$post_row['IdPost'];
								$postLabel = 	stripslashes($post_row['LabPost']);
								$IdDept    = 	stripslashes($post_row['IdDept']);
							}	
						
						
						$dept_query = "SELECT * FROM department WHERE IdDept = '".$IdDept."'";
						$dept_result = mysql_query($dept_query) or die('Erreur SQL :<br />'.$dept_query.'<br />'.mysql_error());
						while ($dept_row = mysql_fetch_array($dept_result))
							{
								$deptID    = 	$dept_row['IdDept'];
								$deptName = 	stripslashes($dept_row['NameDept']);
								$LocID = 	stripslashes($dept_row['IdLoc']);
								
								$Location = new location($LocID);
								$NameLoc = $Location -> NameLoc;
							}						
						
						
							
						$tday = date('Y-m-d');
						$diff = dateDiff($tday, $jr);
						
					if ($start == $today)
						{
						?>
						<p style="text-align:center;"><?php echo $FirstName." ".$LastName." (".$postLabel.", ".$NameLoc.": ".$diff.")" ;?></p><!-- ".$deptName." --->
						<?php
							$start_nombre = $start_nombre + 1;
							} //End if
						
						}//End while
						
						
					if ($start_nombre == 0 )
							{ 
							echo "<p style='text-align:center;'>No anniversary today.</p>";
								}
				
							?>
				</div>
				<br />
				
			<!--</div>--> <!--End panel-->
</div><!-- End 6 columns-->

</div>	<!--End row-->

  </li>
  
  <li id="simpleContained5Tab">
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
</div><!-- End eight columns-->
</div><!--End row-->

</div> <!--end containercentrer-->

<div id="footer"> <?php include("footer.php");?></div>

<!-- make it happen -->
<script>
  $(":date").dateinput({
  		format:'mmm dd, yyyy',
		selectors: true,
		max: 600,
		yearRange:[0,3]
  });
</script>

	<!-- Included JS Files -->
	<script src="js/jquery.min.js"></script>
	<script src="js/foundation.js"></script>
	<script src="js/app.js"></script>

</body>
</html>

<script type="text/javascript">
$(document).ready(function() {
    $('#BegReq').timepicker({
        showLeadingZero: false,
		showPeriod: true,
		minutes: {
        starts: 0,                // First displayed minute
        ends: 45,                 // Last displayed minute
        interval: 15               // Interval of displayed minutes
    }
      
    });
    $('#EndReq').timepicker({
        showLeadingZero: false,
		showPeriod: true,
		minutes: {
        starts: 0,                // First displayed minute
        ends: 45,                 // Last displayed minute
        interval: 15               // Interval of displayed minutes
    }
    });
});

</script>