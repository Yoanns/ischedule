<?php 
// protection de page ADMIN
    include_once('./Admin/fonctions/_protectpageadm.php');
// Parametres de Connexion a la BD
	include_once('connexion.php');   
// DOSSIER des ICONES (administration)
	$DossierIcones = './Admin/icones/';
		
	include_once("./Model/class.post.php");	
	include_once("./Model/class.person.php");
	include_once("./Model/class.skills.php");
	include_once("./Model/class.location.php");
	include_once("./Model/class.department.php");
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
	$LocID = $Department -> IdLoc;
	$NameDept = $Department -> NameDept;
	
	$Location = new location($LocID);
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
			$update_query = "UPDATE admin_spr SET `Pwd`='$Pwd' WHERE `IdPers`='".$persID."'";
			$update_result = mysql_query($update_query) or die('Erreur SQL :<br />'.$update_query.'<br />'.mysql_error());
			$_SESSION['Pwd'] = $Pwd;
			echo"<div class='container'><div class='alert-box success' align='center'>
						Your password has been successfully changed.
						<a href='' class='close'>&times;</a>
					</div></div>";
		}

    else

        echo "<div class='container'><div class='alert-box error'  align='center'>
					The new passwords you entered do not match.
					<a href='' class='close'>&times;</a>
				</div></div>";
	}
	else echo "<div class='container'><div class='alert-box error'  align='center'>
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
			$update_query = "UPDATE admin_spr SET `Login`='$Login' WHERE `IdPers`='".$persID."'";
			$update_result = mysql_query($update_query) or die('Erreur SQL :<br />'.$update_query.'<br />'.mysql_error());
			$_SESSION['Login'] = $Login;
			echo"<div class='container'><div class='alert-box success' style='text-align:center;' >
						Your Login has been successfully changed.
						<a href='' class='close'>&times;</a>
					</div></div>";
		}

	}
	else echo "<div class='container'><div class='alert-box error' style='text-align:center;' >
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

	<title>Shift-Scheduler.com | Master administration interface</title>
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
			<div style="text-align:center; margin:0 auto; padding:10px; border: 2px dashed #CCCCCC; background-color: #FFFFFF;">
				<?php echo date('l F j, Y');?>
			</div>
			<br/>
		</div>
	</div>
</div>

<h1>MASTER ADMINISTRATION INTERFACE</h1>
<br/>
<div class="row">
<div style="float:left;">
<!-- deconnection -->
<form name="deconnexion" method="post" action="./Admin/fonctions/_deconnexion.php">
<!--<fieldset>-->
	<button name="btdeconnexion" class="nice red radius button" type="submit" title="Log out from Administration">
	<img src="<?php echo $DossierIcones; ?>DELETE.png" alt="" /><span> Sign out</span></button>
<!--</fieldset>-->
</form>
</div>
</div> <!--end row-->

<br/>

<?php //echo hash('sha512', 'dave'); ?>
<div class="row">
	<div class="twelve columns centered">
		<div class="panel">

<dl class="nice contained tabs">
  <dd><a href="#nice1" class="active">Events</a></dd>
  <dd><a href="#nice2">Employees</a></dd>
  <dd><a href="#nice5">Departments</a></dd>
  <dd><a href="#nice3">Managers</a></dd>
  <dd><a href="#nice4">Password</a></dd>
</dl>

<ul class="nice tabs-content contained">
 	 <li class="active" id="nice1Tab">

 <div style="float:left;">
<form method="post" name="formvoirEvt" action="./Forms/week-events_adm.php">
		<button name="btSeeWkEvt" class="nice medium radius blue button" type="submit" title="Events occuring this week">
		<img src="<?php echo $DossierIcones; ?>date.png" alt="Week display" width="24"/>Events of the week</button>
	</form>
</div> 
    
<div style="float:right;">
<form method="post" name="formvoirFiche" action="./Forms/see-all-event_adm.php">
		<button name="btSeeEvt" class="nice medium radius blue button" type="submit" title="See all the schedules">
		<img src="<?php echo $DossierIcones; ?>VOIRfiche.png" alt="See all the events" />See all the events</button>
	</form>
</div>

<div style="float:right;">
<form method="post" name="formvoirFiche" action="./Forms/events_adm.php">
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
				<th>Location</th>
				<td width="8%"></td>
				<td width="8%"></td>
			</tr>
			</thead>
			<?php 
	$DayEvt = date("Y-m-d");
		
			//Retrieve the position of each employee
			 $evt_query = "SELECT * FROM event  WHERE DayEvt = '$DayEvt' GROUP BY `IdLoc` ORDER BY BegEvt ASC";
	 $evt_result = mysql_query($evt_query) or die('Erreur SQL :<br />'.$evt_query.'<br />'.mysql_error());
	 $evt_num = mysql_num_rows($evt_result);
	 
if ($evt_num > 0)
	{
	 
	 while ($evt_row = mysql_fetch_array($evt_result))
		{
			$evtID  = 	stripslashes($evt_row['IdEvt']);
			$evtName = 	stripslashes($evt_row['NameEvt']);
			$evtGuest  = 	stripslashes($evt_row['GuestEvt']);
			$evtDesc = 	stripslashes($evt_row['DescEvt']);
			$evtDay = 	stripslashes($evt_row['DayEvt']);
			$evtBeg  = 	stripslashes($evt_row['BegEvt']);
			$evtEnd = 	stripslashes($evt_row['EndEvt']);
			$IdLoc = 	stripslashes($evt_row['IdLoc']);
			
			$Loc = new location($IdLoc);
			$NameLoc = $Loc -> NameLoc;
			
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
				<td><?php echo $NameLoc; ?></td>
				<td>
					<div style="float:left;">
						<form method="post" name="formmodifier" action="./Forms/events_adm.php">
								<input type="hidden" name="traiter" value="EDIT" />
								<input type="hidden" name="IdEvt" value="<?php  echo $evtID; ?>" />
								<button name="btMODIFIER" type="submit" title="Edit event" class="button">
									<img src="./Admin/icones/date_edit.png" alt="Edit event" width="24" /></button>
						</form>
					</div>
				</td>
				<td>
					<div style="float:left;">
						<form method="post" name="formmodifier" action="./evt_treatment_adm.php" onClick="return confirm('Do you really want to delete this event?')">
								<input type="hidden" name="traiter" value="DELETE" />
								<input type="hidden" name="IdEvt" value="<?php  echo $evtID; ?>" />
								<button name="btMODIFIER" type="submit" title="Delete event" class="button">
									<img src="./Admin/icones/date_delete.png" alt="Delete event" width="24" /></button>
						</form>
					</div>
				</td>
			</tr>
			
			<div id="myModal<?php  echo $evtID; ?>" class="reveal-modal">
     <h2>Description of the event: <?php echo $evtName; ?></h2>
     <p class="lead"> @ <?php echo $NameLoc; ?></p>
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
	<form method="post" name="formmodifier" action="./Forms/print-day-event_adm.php" target="_blank">
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
    
  <!--Employees-->
  <li id="nice2Tab">
  	

<div style="float:right;">
<!-- ajouter -->
<form method="post" name="formajouter" action="./Forms/employees_adm.php">
	<input type="hidden" name="traiter" value="ADD" />
	<button name="btAjouter" class="nice medium radius green button" type="submit" title="Add a new employee " style="vertical-align:middle;">
	<img src="<?php echo $DossierIcones; ?>user_add.png" width="24" alt="" /><span> Add an Employee</span></button>
</form>
</div>

<div style="float:right;">
<!-- ajouter -->
<form method="post" name="formajouter" action="./Forms/post_adm.php">
	<input type="hidden" name="traiter" value="ADD" />
	<button name="btAjouter_pst" class="nice medium radius green button" type="submit" title="Add a new position ">
	<img src="<?php echo $DossierIcones; ?>role.png" width="24" alt="" /><span> Add a position</span></button>
</form>
</div>

<br/>  
<div class="clearfix"></div><br/>

<!--<div class="panel">
	<div class="row">-->
		<div class="three centered columns">	
		<p style="text-align:center; padding:3px;">

<form name="PostChoice" id="PostChoice" method="GET" >		
		<select name="IdPost" id="IdPost" onChange="MM_jumpMenu('document',this,0)">
				<option value="<?php echo "admin_spr.php#nice2"; ?>">Select a position</option>
            <?php
if (isset($_GET["IdPost"]))
	$IdPost = $_GET["IdPost"];
else
	$IdPost = 0 ;
	
$post=new post(null);
	if(false!=$post->Listing())
		$listepost=$post->Listing();
		
	  	if(!empty($listepost))
	  	{
	  		while($lgne=mysql_fetch_array($listepost))
			{
				$IdDept = $lgne[2];
				$Dept = new department($IdDept);
				$IdLoc = $Dept -> IdLoc;
				$Loc = new location($IdLoc);
				$NameLoc = $Loc -> NameLoc;
	  	?>
<option value="<?php echo "admin_spr.php?IdPost=".$lgne[0]."#nice2"; ?>" <?php if ($lgne[0] == $IdPost) echo  'selected="selected"' ;?> ><?php echo $lgne[1].", ".$NameLoc; ?></option>
            
            <?php
  			}
		}
	   ?>
          </select>   		
		</form>		
	</p>

		<br/>
		</div>
	<!--</div>
</div>-->

<br />

<?php
if((isset($_GET["IdPost"]))&&($_GET["IdPost"]!=0))
{		
	$IdPost = $_GET["IdPost"] ;
//query: List of positions
$post_query = "SELECT * FROM post WHERE IdPost = '$IdPost'";
$post_result = mysql_query($post_query) or die('Erreur SQL :<br />'.$post_query.'<br />'.mysql_error());

// loop for listing
while ($post_row = mysql_fetch_array($post_result))
{
	$postID    = 	$post_row['IdPost'];
	$postLabel = 	stripslashes($post_row['LabPost']);
	$IdDept = stripslashes($post_row['IdDept']);
	
	$Dept = new department($IdDept);
	$IdLoc = $Dept -> IdLoc;
	$Loc = new location($IdLoc);
	$NameLoc = $Loc -> NameLoc;
	
?>	
<div class="panel">
<h3><?php echo $postLabel.", ".$NameLoc; ?></h3>

<?php 
// pagination
	$cible = "admin_spr.php"; 	
	$end = 15; 
	
	$query = "SELECT COUNT(*) AS num 
				FROM person
               WHERE IdPost = '".$postID."'";
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
			$pagination.= "<li><a href='$cible?pg=$prec&&IdPost=$postID#nice2'>previous</a></Li>";
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
					$pagination.= "<li><a href='$cible?pg=$counter&&IdPost=$postID#nice2'>$counter</a></li>";}					
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
						$pagination.= "<li><a href='$cible?pg=$counter&&IdPost=$postID#nice2'>$counter</a></li>";}					
				}
				$pagination.= "...";
				$pagination.= "<a href='$cible?pg=$LastPgm1&&IdPost=$postID#nice2'>$LastPgm1</a>";
				$pagination.= "<a href='$cible?pg=$lastpg&&IdPost=$postID#nice2'>$lastpg</a>";		
			}
			// Middle hide some front and some back
			elseif($lastpg - ($stages * 2) > $pg && $pg > ($stages * 2))
			{
				$pagination.= "<li><a href='$cible?pg=1&&IdPost=$postID#nice2'>1</a></li>";
				$pagination.= "<li><a href='$cible?pg=2&&IdPost=$postID#nice2'>2</a></li>";
				$pagination.= "...";
				for ($counter = $pg - $stages; $counter <= $pg + $stages; $counter++)
				{
					if ($counter == $pg){
						$pagination.= "<li class='current'>$counter</li>";
					}else{
						$pagination.= "<li><a href='$cible?pg=$counter&&IdPost=$postID#nice2'>$counter</a></li>";}					
				}
				$pagination.= "...";
				$pagination.= "<li><a href='$cible?pg=$LastPgm1&&IdPost=$postID#nice2'>$LastPgm1</a></li>";
				$pagination.= "<li><a href='$cible?pg=$lastpg&&IdPost=$postID#nice2'>$lastpg</a></li>";		
			}
			// End only hide early pages
			else
			{
				$pagination.= "<li><a href='$cible?pg=1&&IdPost=$postID#nice2'>1</a></li>";
				$pagination.= "<li><a href='$cible?pg=2&&IdPost=$postID#nice2'>2</a></li>";
				$pagination.= "...";
				for ($counter = $lastpg - (2 + ($stages * 2)); $counter <= $lastpg; $counter++)
				{
					if ($counter == $pg){
						$pagination.= "<li class='current'>$counter</li>";
					}else{
						$pagination.= "<li><a href='$cible?pg=$counter&&IdPost=$postID#nice2'>$counter</a></li>";}					
				}
			}
		}
					
				// Next
		if ($pg < $counter - 1){ 
			$pagination.= "<li><a href='$cible?pg=$suiv&&IdPost=$postID#nice2'>next</a></li>";
		}else{
			$pagination.= "<li class='unavailable'>next</li>";
			}
			
		$pagination.= "</ul>";		
	
}	


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
	$IdDept	=	$post ->IdDept;
	
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
	<form method="post" name="formsupprimer" action="treatment_admin.php" onClick="return confirm('Do you really want to delete?')">
		<input type="hidden" name="traiter" value="DELETE" />
		<input type="hidden" name="persID" value="<?php echo $persID; ?>" />
		<button name="btSUPPRIMER" type="submit" title="Delete employee" class="button">
		<img src="<?php echo $DossierIcones; ?>user_delete.png" width="24" alt="Delete employee" /></button> 
	</form>
	</td>
	
	<!-- edit employee -->
	<td style="width:8%;">
	<form method="post" name="formmodifier" action="./Forms/employees_adm.php">
		<input type="hidden" name="traiter" value="EDIT" />
		<input type="hidden" name="persID" value="<?php echo $persID; ?>" />
		<button name="btMODIFIER" type="submit" title="Edit employee" class="button">
		<img src="<?php echo $DossierIcones; ?>user_edit.png" width="24" alt="Edit employee" /></button>
	</form>
	</td>
	
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
mysql_free_result($pers_result);

?>
<br/>
<p align="center"><?php echo $pagination;?></p>
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
	}  //End while post
	mysql_free_result($post_result);
}  // End if isset idpost
?>

  </li>
  
   <!--Departments-->
  <li id="nice5Tab">
		<div style="float:left;">
		<!-- ajouter -->
		<form method="post" name="formlist" action="./Forms/location_list.php">
			<!--<input type="hidden" name="traiter" value="ADD" />-->
			<button name="btListLoc" class="nice medium radius blue button" type="submit" title="Locations listing " style="vertical-align:middle;">
			<img src="<?php echo $DossierIcones; ?>building.png" width="24" alt="" /><span>List of locations</span></button>
		</form>
		</div>
		
  	
		<div style="float:right;">
		<!-- ajouter -->
		<form method="post" name="formajouter" action="./Forms/location.php">
			<input type="hidden" name="traiter" value="ADD" />
			<button name="btAjouterLoc" class="nice medium radius green button" type="submit" title="Add a new location " style="vertical-align:middle;">
			<img src="<?php echo $DossierIcones; ?>building_add.png" width="24" alt="" /><span> Add a location</span></button>
		</form>
		</div>
		
		<div style="float:right;">
		<!-- ajouter -->
		<form method="post" name="formajouter" action="./Forms/department.php">
			<input type="hidden" name="traiter" value="ADD" />
			<button name="btAjouter_dept" class="nice medium radius green button" type="submit" title="Add a new department">
			<img src="<?php echo $DossierIcones; ?>group_add.png" width="24" alt="" /><span> Add a department</span></button>
		</form>
		</div>
		
		<br/>  
	<?php
// pagination
$targetpage = "admin_spr.php"; 	
	$limit = 10; 
	
	$query = "SELECT COUNT(*) AS num FROM department";
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

//query: List of locations
$dept_query = "SELECT * FROM department ORDER BY IdLoc LIMIT $start, $limit";
$dept_result = mysql_query($dept_query) or die('Erreur SQL :<br />'.$dept_query.'<br />'.mysql_error());
$dept_nombre = mysql_num_rows($dept_result);

if($dept_nombre > 0) {
?>
<h4><?php echo $dept_nombre; ?> department<?php if($dept_nombre > 1) { echo 's'; } ?></h4>
<?php
// loop for listing
while ($dept_row = mysql_fetch_array($dept_result))
{
	$IdDept		= 	$dept_row['IdDept'];
	$NameDept	= 	$dept_row['NameDept'];	
	$IdLoc		=	$dept_row['IdLoc'];

    $location = new location($IdLoc);
	$NameLoc = $location -> NameLoc;
	
?>
	<table style="border:1px dashed #CCCCCC">
	<tbody>
		<tr>
		<td width="75%"><h4><?php echo $NameDept.", ".$NameLoc; ?></h4></td>
		<!-- supprimer -->
	<td style="width:8%;">
	<form method="post" name="formsupprimer" action="dept_treatment.php" onClick="return confirm('Do you really want to delete this department?')">
	<!--<fieldset>-->
		<input type="hidden" name="traiter" value="DELETE" />
		<input type="hidden" name="IdDept" value="<?php echo $IdDept; ?>" />
		<button name="btSUPPRIMER" type="submit" title="Delete department" class="button">
		<img src="<?php echo $DossierIcones; ?>group_delete.png" width="24" alt="Delete" /></button> 
	<!--</fieldset>-->
	</form>
	</td>
	
	<!-- edit employee -->
	<td style="width:8%;">
	<form method="post" name="formmodifier" action="./Forms/department.php">
	<!--<fieldset>-->
		<input type="hidden" name="traiter" value="EDIT" />
		<input type="hidden" name="IdDept" value="<?php echo $IdDept; ?>" />
		<button name="btMODIFIER" type="submit" title="Edit department" class="button">
		<img src="<?php echo $DossierIcones; ?>group_edit.png" width="24" alt="Edit department" /></button>
	<!--</fieldset>-->
	</form>
	</td>
	
			</tr>
		</tbody>
	</table>
<?php
	}
	} // end if
	else { // no department
?>
 <div id="light" align="center">No department for now.</div><br/>
<?php
		} //End else
	

?><br/>
<p align="center"><?php echo $paginate;?></p>
<br/>

	</div><!--End panel--> 
</div> <!--End row-->
<br/>
		
  </li>
  
 <!-- managers-->
  <li id="nice3Tab">
  <div style="float:right;">
<!-- ajouter -->
<form method="post" name="formAddManager" action="./Forms/manager_adm.php">
<!--<fieldset>-->
	<input type="hidden" name="traiter" value="ADD" />
	<button name="btAjouter" class="nice medium radius green button" type="submit" title="Add a new manager " style="vertical-align:middle;">
	<img src="<?php echo $DossierIcones; ?>user_add.png" width="24" alt="" /><span> Add a manager</span></button>
<!--</fieldset>-->
</form>
</div>
<?php
// pagination
$targetpage = "admin_spr.php"; 	
	$limit = 60; 
	
	$query = "SELECT COUNT(*) AS num 
				FROM admin
				WHERE IdPers IN (SELECT IdPers FROM person)";
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
			$paginate.= "<li><a href='$targetpage?page=$prev#nice3'>previous</a></Li>";
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
					$paginate.= "<li><a href='$targetpage?page=$counter#nice3'>$counter</a></li>";}					
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
						$paginate.= "<li><a href='$targetpage?page=$counter#nice3'>$counter</a></li>";}					
				}
				$paginate.= "...";
				$paginate.= "<a href='$targetpage?page=$LastPagem1#nice3'>$LastPagem1</a>";
				$paginate.= "<a href='$targetpage?page=$lastpage#nice3'>$lastpage</a>";		
			}
			// Middle hide some front and some back
			elseif($lastpage - ($stages * 2) > $page && $page > ($stages * 2))
			{
				$paginate.= "<li><a href='$targetpage?page=1#nice3'>1</a></li>";
				$paginate.= "<li><a href='$targetpage?page=2#nice3'>2</a></li>";
				$paginate.= "...";
				for ($counter = $page - $stages; $counter <= $page + $stages; $counter++)
				{
					if ($counter == $page){
						$paginate.= "<li class='current'>$counter</li>";
					}else{
						$paginate.= "<li><a href='$targetpage?page=$counter#nice3'>$counter</a></li>";}					
				}
				$paginate.= "...";
				$paginate.= "<li><a href='$targetpage?page=$LastPagem1#nice3'>$LastPagem1</a></li>";
				$paginate.= "<li><a href='$targetpage?page=$lastpage#nice3'>$lastpage</a></li>";		
			}
			// End only hide early pages
			else
			{
				$paginate.= "<li><a href='$targetpage?page=1#nice3'>1</a></li>";
				$paginate.= "<li><a href='$targetpage?page=2#nice3'>2</a></li>";
				$paginate.= "...";
				for ($counter = $lastpage - (2 + ($stages * 2)); $counter <= $lastpage; $counter++)
				{
					if ($counter == $page){
						$paginate.= "<li class='current'>$counter</li>";
					}else{
						$paginate.= "<li><a href='$targetpage?page=$counter#nice3'>$counter</a></li>";}					
				}
			}
		}
					
				// Next
		if ($page < $counter - 1){ 
			$paginate.= "<li><a href='$targetpage?page=$next#nice3'>next</a></li>";
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
$admin_query = "SELECT * FROM admin WHERE IdPers IN (SELECT IdPers FROM person ) LIMIT $start, $limit";
$admin_result = mysql_query($admin_query) or die('Erreur SQL :<br />'.$admin_query.'<br />'.mysql_error());
$admin_nombre = mysql_num_rows($admin_result);

if($admin_nombre > 0) {
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

$pers_nombre = mysql_num_rows($pers_result);

if($pers_nombre>0) 
	{
		//$pers_row = mysql_fetch_array($pers_result);
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
 <div id="light" align="center">No manager for now.</div><br/>
<?php
		} //End else
	} //End while $admin_row
} // End if $admin_nombre

echo $paginate;
?><br/>

	</div><!--End panel--> 
</div> <!--End row-->
<br/>
  </li>
  
  <!--Password-->
  <li id="nice4Tab">
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