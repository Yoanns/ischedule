<?php
// ***************************************************************
// protection de page ADMIN
   include_once('./Admin/fonctions/_protectpage.php');
// **************************************
// Parametres de Connexion a la BD
	include_once('connexion.php');
// **************************************
	include_once('Model/class.schedules.php');
	include_once('Model/class.department.php');
	include_once('Model/class.post.php');
	include_once('Model/class.employee.php');
	include_once('Model/class.request.php');
	include_once('Model/class.skills.php');
	include_once('Model/class.sunday.php');
	include_once('Model/class.monday.php');
	include_once('Model/class.tuesday.php');
	include_once('Model/class.wednesday.php');
	include_once('Model/class.thursday.php');
	include_once('Model/class.friday.php');
	include_once('Model/class.saturday.php');

include_once('./Admin/fonctions/functions.php');
	
/*-------------------------------------------------*/

$traiter = '';
if (isset($_POST['traiter']) && ($_POST['traiter']=='ADD' || $_POST['traiter']=='EDIT' || $_POST['traiter']=='DELETE')){
	$traiter = $_POST['traiter'];
	$folder = "./Avatars/" ;
} else {
	// sinon retour a la liste
	header('location: ./admin.php#nice4');
	exit;
}
		
// -------------------------
// Treatment : ADD
// -------------------------
if ($traiter == 'ADD')
{
		
	// Get information from form employee			
	$persID   = 		mysql_real_escape_string($_POST['persID']);
	$persFirstName	= 	mysql_real_escape_string($_POST['FirstName']);
	$persLastName	= 	mysql_real_escape_string($_POST['LastName']);
	$persEmail  	=	mysql_real_escape_string($_POST['Email']);
	$persPhone  	=	mysql_real_escape_string($_POST['Phone']);
	$persDOB		= 	mysql_real_escape_string($_POST['DOB']);
	$persWorkHrs	= 	mysql_real_escape_string($_POST['WorkHrs']);
    $persFirstDay	= 	mysql_real_escape_string($_POST['FirstDay']);
    //$IdDept			=	mysql_real_escape_string($_POST['IdDept']);
	//$IdDept			=	$_SESSION['IdDept'];
	$IdPost    		=  	mysql_real_escape_string($_POST['IdPost']);
	$PhotoAvant 	= 	mysql_real_escape_string($_POST['PhotoAvant']);
	
	
	// on cree une nouvelle entree dans la table
	$query_insert = "INSERT INTO PERSON (IdPers, Email, FirstName, LastName, WorkHrs, DOB, Phone, FirstDay, IdPost) 
					 VALUES('".$persID."','".$persEmail."','".$persFirstName."','".$persLastName."','".$persWorkHrs."','".$persDOB."','".$persPhone."','".$persFirstDay."','".$IdPost."')";
	mysql_query($query_insert) or die('Erreur SQL :<br />'.$query_insert.'<br />'.mysql_error());
	// ----------------------
	// traitement photo ?
	// recuperation de d id en selectionnant LA DERNIERE fiche cree
	/*$result_maxid = 	mysql_query("SELECT MAX(IdPers) AS idmax FROM person;");
	$val_maxid = 		mysql_fetch_array($result_maxid);
	$persID = 			$val_maxid['idmax'];*/
	include('./Admin/fonctions/photo.php');
	// ----------------------			
	
	// Skills
	$Skill = mysql_real_escape_string($_POST['skill']);		
	$skills = new skills(null);
	$skills -> Add($persID,$Skill) ;
	
	// Availability
	 $SunBeg   =	mysql_real_escape_string($_POST['SunBeg']);	
	 $SunEnd   =	mysql_real_escape_string($_POST['SunEnd']);	
	 $MonBeg   =	mysql_real_escape_string($_POST['MonBeg']);	
	 $MonEnd   =	mysql_real_escape_string($_POST['MonEnd']);	
	 $TuesBeg  =	mysql_real_escape_string($_POST['TuesBeg']);	
	 $TuesEnd  =	mysql_real_escape_string($_POST['TuesEnd']);	
	 $WedBeg   =	mysql_real_escape_string($_POST['WedBeg']);	
	 $WedEnd   =	mysql_real_escape_string($_POST['WedEnd']);	
	 $ThursBeg =	mysql_real_escape_string($_POST['ThursBeg']);	
	 $ThursEnd =	mysql_real_escape_string($_POST['ThursEnd']);	
	 $FriBeg   =	mysql_real_escape_string($_POST['FriBeg']);	
	 $FriEnd   =	mysql_real_escape_string($_POST['FriEnd']);	
	 $SatBeg   =	mysql_real_escape_string($_POST['SatBeg']);	
	 $SatEnd   =	mysql_real_escape_string($_POST['SatEnd']);
	 
	 if (($SunBeg != '') && ($SunEnd != ''))
	 	{
			$Sunday = new sunday(null);
			$Sunday -> Add($persID,$SunBeg,$SunEnd) ;
		}
		
		 if (($MonBeg != '') && ($MonEnd != ''))
	 	{
			$Monday = new monday(null);
			$Monday -> Add($persID,$MonBeg,$MonEnd) ;
		}
		
		 if (($TuesBeg != '') && ($TuesEnd != ''))
	 	{
			$Tuesday = new tuesday(null);
			$Tuesday -> Add($persID,$TuesBeg,$TuesEnd) ;
		}
		
		 if (($WedBeg != '') && ($WedEnd != ''))
	 	{
			$Wednesday = new wednesday(null);
			$Wednesday -> Add($persID,$WedBeg,$WedEnd) ;
		}
		
		 if (($ThursBeg != '') && ($ThursEnd != ''))
	 	{
			$Thursday = new thursday(null);
			$Thursday -> Add($persID,$ThursBeg,$ThursEnd) ;
		}
		
		 if (($FriBeg != '') && ($FriEnd != ''))
	 	{
			$Friday = new friday(null);
			$Friday -> Add($persID,$FriBeg,$FriEnd) ;
		}
		
		 if (($SatBeg != '') && ($SatEnd != ''))
	 	{
			$Saturday = new saturday(null);
			$Saturday -> Add($persID,$SatBeg,$SatEnd) ;
		}
		
}
// -------------------------
// Traitement : EDIT
// -------------------------
elseif ($traiter == 'EDIT')
{
	$persID   = 		mysql_real_escape_string($_POST['persID']);
	$persFirstName	= 	mysql_real_escape_string($_POST['FirstName']);
	$persLastName	= 	mysql_real_escape_string($_POST['LastName']);
	$persEmail  	=	mysql_real_escape_string($_POST['Email']);
	$persPhone  	=	mysql_real_escape_string($_POST['Phone']);
	$persDOB		= 	mysql_real_escape_string($_POST['DOB']);
	$persWorkHrs	= 	mysql_real_escape_string($_POST['WorkHrs']);
    $persFirstDay	= 	mysql_real_escape_string($_POST['FirstDay']);
    //$IdDept			=	mysql_real_escape_string($_POST['IdDept']);
	//$IdDept			=	$_SESSION['IdDept'];
	$IdPost    		= 	mysql_real_escape_string($_POST['IdPost']);
	$PhotoAvant 	= 	mysql_real_escape_string($_POST['PhotoAvant']);
	
	/*// modification : on met a jour l'address
	$query = "SELECT IdAddr FROM person WHERE IdPers = '".$persID."'";
	$result = mysql_query($query) or die('Erreur SQL :<br />'.$query.'<br />'.mysql_error());
	$IdAddr = $result[0];
	
	$address = new address($IdAddr);
	$address ->  Edit($Street,$City,$State,$ZipCode);*/
	
	// modification : on met a jour la personne
	$query_update = 	"UPDATE PERSON SET ".
						" IdPers='".$persID."',Email='".$persEmail."', FirstName='".$persFirstName."', LastName='".$persLastName."',".
						" WorkHrs='".$persWorkHrs."', DOB='".$persDOB."', Phone='".$persPhone."', FirstDay='".$persFirstDay."', IdPost='".$IdPost."' ".
						" WHERE IdPers='".$persID."';";
	mysql_query($query_update) or die('Erreur SQL :<br />'.$query_update.'<br />'.mysql_error());
	// ----------------------
	// traitement photo ?
	include('./Admin/fonctions/photo.php');
	
	// Skills
	$Skill = mysql_real_escape_string($_POST['skill']);		
	$skills = new skills($persID);
	if ($skills ->Skill != '')
		$skills -> Edit($persID,$Skill) ;
	else $skills -> Add($persID,$Skill) ;
	
	// Availability
	 $SunBeg   =	mysql_real_escape_string($_POST['SunBeg']);	
	 $SunEnd   =	mysql_real_escape_string($_POST['SunEnd']);	
	 $MonBeg   =	mysql_real_escape_string($_POST['MonBeg']);	
	 $MonEnd   =	mysql_real_escape_string($_POST['MonEnd']);	
	 $TuesBeg  =	mysql_real_escape_string($_POST['TuesBeg']);	
	 $TuesEnd  =	mysql_real_escape_string($_POST['TuesEnd']);	
	 $WedBeg   =	mysql_real_escape_string($_POST['WedBeg']);	
	 $WedEnd   =	mysql_real_escape_string($_POST['WedEnd']);	
	 $ThursBeg =	mysql_real_escape_string($_POST['ThursBeg']);	
	 $ThursEnd =	mysql_real_escape_string($_POST['ThursEnd']);	
	 $FriBeg   =	mysql_real_escape_string($_POST['FriBeg']);	
	 $FriEnd   =	mysql_real_escape_string($_POST['FriEnd']);	
	 $SatBeg   =	mysql_real_escape_string($_POST['SatBeg']);	
	 $SatEnd   =	mysql_real_escape_string($_POST['SatEnd']);
	 
	
	//Sunday
	$Sunday ="SELECT IdSun, IdPers, BegSun, EndSun FROM sunday
			WHERE IdPers='$persID' limit 0,1";
	$result_Sunday=mysql_query($Sunday) or die('Erreur SQL :<br />'.$Sunday.'<br />'.mysql_error());
	$nbSunday = mysql_num_rows($result_Sunday);
	 
	if (($nbSunday > 0) && ($SunBeg != '') && ($SunEnd != ''))
	 	{
			$Sunday = new sunday($persID);
			$Sunday -> Edit($persID,$SunBeg,$SunEnd) ;
		}
	elseif (($nbSunday > 0) && ($SunBeg == '') && ($SunEnd == ''))
	 	{
			$Sunday = new sunday($persID);
			$Sunday -> Delete($persID) ;
		}
	elseif (($nbSunday == 0) && ($SunBeg != '') && ($SunEnd != '') )
		{
			$Sunday = new sunday(null);
			$Sunday -> Add($persID,$SunBeg,$SunEnd) ;
		}

	//Monday
	$Monday ="SELECT IdMon, IdPers, BegMon, EndMon FROM monday
			WHERE IdPers='$persID' limit 0,1";
	$result_Monday=mysql_query($Monday) or die('Erreur SQL :<br />'.$Monday.'<br />'.mysql_error());
	$nbMonday = mysql_num_rows($result_Monday);
	
	if (($nbMonday > 0) && ($MonBeg != '') && ($MonEnd != ''))
	 	{
			$Monday = new monday($persID);
			$Monday -> Edit($persID,$MonBeg,$MonEnd) ;
		}
	elseif (($nbMonday > 0) && ($MonBeg == '') && ($MonEnd == ''))
	 	{
			$Monday = new monday($persID);
			$Monday -> Delete($persID) ;
		}
	elseif (($nbMonday == 0) && ($MonBeg != '') && ($MonEnd != '') )
		{
			$Monday = new monday(null);
			$Monday -> Add($persID,$MonBeg,$MonEnd) ;
		}
	
	//Tuesday
	$Tuesday ="SELECT IdTues, IdPers, BegTues, EndTues FROM tuesday
			WHERE IdPers='$persID' limit 0,1";
	$result_Tuesday=mysql_query($Tuesday) or die('Erreur SQL :<br />'.$Tuesday.'<br />'.mysql_error());
	$nbTuesday = mysql_num_rows($result_Tuesday);
		
	if (($nbTuesday > 0) && ($TuesBeg != '') && ($TuesEnd != ''))
	 	{
			$Tuesday = new tuesday($persID);
			$Tuesday -> Edit($persID,$TuesBeg,$TuesEnd) ;
		}
	elseif (($nbTuesday > 0) && ($TuesBeg == '') && ($TuesEnd == ''))
	 	{
			$Tuesday = new tuesday($persID);
			$Tuesday -> Delete($persID) ;
		}
	elseif (($nbTuesday == 0) && ($TuesBeg != '') && ($TuesEnd != '') )
		{
			$Tuesday = new tuesday(null);
			$Tuesday -> Add($persID,$TuesBeg,$TuesEnd) ;
		}
	
	
	//Wednesday
	$Wedday ="SELECT IdWed, IdPers, BegWed, EndWed FROM wednesday
			WHERE IdPers='$persID' limit 0,1";
	$result_Wedday=mysql_query($Wedday) or die('Erreur SQL :<br />'.$Wedday.'<br />'.mysql_error());
	$nbWedday = mysql_num_rows($result_Wedday);
		
	if (($nbWedday > 0) && ($WedBeg != '') && ($WedEnd != ''))
	 	{
			$Wedday = new wednesday($persID);	
			$Wedday -> Edit($persID,$WedBeg,$WedEnd) ;
		}
	elseif (($nbWedday > 0) && ($WedBeg == '') && ($WedEnd == ''))
	 	{
			$Wedday = new wednesday($persID);	
			$Wedday -> Delete($persID) ;
		}
	elseif (($nbWedday == 0) && ($WedBeg != '') && ($WedEnd != '') )
		{
			$Wedday = new wednesday(null);
			$Wedday -> Add($persID,$WedBeg,$WedEnd) ;
		}
	
	
	//Thursday
	$Thursday ="SELECT IdThurs, IdPers, BegThurs, EndThurs FROM thursday
			WHERE IdPers='$persID' limit 0,1";
	$result_Thursday=mysql_query($Thursday) or die('Erreur SQL :<br />'.$Thursday.'<br />'.mysql_error());
	$nbThursday = mysql_num_rows($result_Thursday);
		
	if (($nbThursday > 0) && ($ThursBeg != '') && ($ThursEnd != ''))
	 	{
			$Thursday = new thursday($persID);	
			$Thursday -> Edit($persID,$ThursBeg,$ThursEnd) ;
		}
	elseif (($nbThursday > 0) && ($ThursBeg == '') && ($ThursEnd == ''))
	 	{
			$Thursday = new thursday($persID);	
			$Thursday -> Delete($persID) ;
		}
	elseif (($nbThursday == 0) && ($ThursBeg != '') && ($ThursEnd != '') )
		{
			$Thursday = new thursday(null);
			$Thursday -> Add($persID,$ThursBeg,$ThursEnd) ;
		}
	
	
	//Friday
	$Friday ="SELECT IdFri, IdPers, BegFri, EndFri FROM friday
			WHERE IdPers='$persID' limit 0,1";
	$result_Friday=mysql_query($Friday) or die('Erreur SQL :<br />'.$Friday.'<br />'.mysql_error());
	$nbFriday = mysql_num_rows($result_Friday);
		
	if (($nbFriday > 0) && ($FriBeg != '') && ($FriEnd != ''))
	 	{
			$Friday = new friday($persID);	
			$Friday -> Edit($persID,$FriBeg,$FriEnd) ;
		}
	elseif (($nbFriday > 0) && ($FriBeg == '') && ($FriEnd == ''))
	 	{
			$Friday = new friday($persID);	
			$Friday -> Delete($persID) ;
		}
	elseif (($nbFriday == 0) && ($FriBeg != '') && ($FriEnd != '') )
		{
			$Friday = new friday(null);
			$Friday -> Add($persID,$FriBeg,$FriEnd) ;
		}
	
		
	//Saturday
	$Satday ="SELECT IdSat, IdPers, BegSat, EndSat FROM saturday
			WHERE IdPers='$persID' limit 0,1";
	$result_Satday=mysql_query($Satday) or die('Erreur SQL :<br />'.$Satday.'<br />'.mysql_error());
	$nbSatday = mysql_num_rows($result_Satday);
		
	if (($nbSatday > 0) && ($SatBeg != '') && ($SatEnd != ''))
	 	{
			$Satday = new saturday($persID);
			$Satday -> Edit($persID,$SatBeg,$SatEnd) ;
		}
	elseif (($nbSatday > 0) && ($SatBeg == '') && ($SatEnd == ''))
	 	{
			$Satday = new saturday($persID);
			$Satday -> Delete($persID) ;
		}
	elseif (($nbSatday == 0) && ($SatBeg != '') && ($SatEnd != '') )
		{
			$Satday = new saturday(null);
			$Satday -> Add($persID,$SatBeg,$SatEnd) ;
		}
	
}
// -------------------------
// Traitement : DELETE
// -------------------------
elseif ($traiter == 'DELETE')
{
	$persID = 			mysql_real_escape_string($_POST['persID']);
	
	$Skills = new skills($persID);
	$Skills -> Delete($persID);
	
	$Sunday = new sunday($persID);
	$Sunday -> Delete($persID);
	
	$Monday = new monday($persID);
	$Monday -> Delete($persID);
	
	$Tuesday = new tuesday($persID);
	$Tuesday -> Delete($persID);
	
	$Wednesday = new wednesday($persID);
	$Wednesday -> Delete($persID);
	
	$Thursday = new thursday($persID);
	$Thursday -> Delete($persID);
	
	$Friday = new friday($persID);
	$Friday -> Delete($persID);
	
	$Saturday = new saturday($persID);
	$Saturday -> Delete($persID);
	
	$emp = new employee($persID);
	$emp -> Delete($persID);
	
	$req = new request(null);
	$req -> DeletePersReq($persID);
	
	// suppression dans la BD
	$query_delete = 	"DELETE FROM PERSON WHERE IdPers='".$persID."';";
    mysql_query($query_delete) or die('Erreur SQL :<br />'.$query_delete.'<br />'.mysql_error());
	
}
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
<title>Shift-Scheduler.com | <?php echo $traiter; ?> an Employee</title>
	<link rel="shortcut icon" type="image/x-icon" href="./Admin/icones/ischedule_logo1.ico">
<!-- Included CSS Files -->
	<link rel="stylesheet" href="./css/foundation.css">
	<link rel="stylesheet" href="./css/app.css">
	<link rel="stylesheet" media="screen" type="text/css" href="./Admin/css_adm/news_ADM_style.css" />

	<!--[if lt IE 9]>
		<link rel="stylesheet" href="./css/ie.css">
	<![endif]-->
	
	<script src="./js/modernizr.foundation.js"></script>

	<!-- IE Fix for HTML5 Tags -->
	<!--[if lt IE 9]>
		<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
</head>

<body>
<div id="containercentrer">

<h1>ADMINISTRATION OF EMPLOYEES</h1>
<h2><?php echo $traiter; ?> AN EMPLOYEE</h2>


<?php
// -------------------------

// re-affichage
if ($traiter == 'ADD' )
{
	$persID   = 	mysql_real_escape_string($_POST['persID']);
	
	$pers_query = "SELECT * FROM PERSON WHERE IdPers='".$persID."'";
	$pers_result = mysql_query($pers_query) or die('Erreur SQL :<br />'.$pers_query.'<br />'.mysql_error());
	while ($pers_row = mysql_fetch_array($pers_result))
	{
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
	
	
	/*$dept = new department ($IdDept);
	$NameDept = $dept -> NameDept;
	$LocDept = $dept -> LocDept;*/
	
	$post = new post($IdPost);
	$LabPost = $post ->LabPost;
	
	$skills = new skills($persID);
	$persSkill = $skills ->Skill;
	
?>
<div class="container">
	<div class="alert-box centered success">
		Addition successful.
		<a href="" class="close">&times;</a>
	</div>
</div>

<br />

	<div class="panel">
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
		<?php /*?><p class="space">
				<label class="label15" style="text-align:right; color:#21409A;">Department: </label><?php echo $NameDept." - ".$LocDept ;?>
			</p>
			<div class="clearfix"></div><?php */?>
			
			<p class="space">
				<label class="label15" style="text-align:right; color:#21409A;">Skill: </label><?php echo $persSkill; ?>
			</p>
			<div class="clearfix"></div>
			
	</fieldset></form>
		</div> <!--End 6 cols-->
	
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
			<label><img src="css/next.gif"/> Sunday <br/> &nbsp;&nbsp;&nbsp;&nbsp; from <strong><?php echo $Sunday ->BegSun; ?></strong> to <strong><?php echo $Sunday ->EndSun; ?></strong></label>
			</p>
			<div class="clearfix"></div>
			<?php }
			
			$Monday = new monday($persID);
			if ((isset($Monday ->BegMon)) && ($Monday ->BegMon != ''))
				{ ?>
			<p class="space">
			<label><img src="css/next.gif"/> Monday <br/> &nbsp;&nbsp;&nbsp;&nbsp; from <strong><?php echo $Monday ->BegMon; ?></strong> to <strong><?php echo $Monday ->EndMon; ?></strong></label>
			</p>
			<div class="clearfix"></div>
			<?php }
			
			$Tuesday = new tuesday($persID);
			if ((isset($Tuesday->BegTues)) && ($Tuesday->BegTues != ''))
				{ ?>
			<p class="space">
			<label><img src="css/next.gif"/> Tuesday <br/> &nbsp;&nbsp;&nbsp;&nbsp; from <strong><?php echo $Tuesday ->BegTues; ?></strong> to <strong><?php echo $Tuesday ->EndTues; ?></strong></label>
			</p>
			<div class="clearfix"></div>
			<?php }
			
			$Wednesday = new wednesday($persID);
			if ((isset($Wednesday ->BegWed)) && ($Wednesday ->BegWed != ''))
				{ ?>
			<p class="space">
			<label><img src="css/next.gif"/> Wednesday <br/> &nbsp;&nbsp;&nbsp;&nbsp; from <strong><?php echo $Wednesday ->BegWed; ?></strong> to <strong><?php echo $Wednesday ->EndWed; ?></strong></label>
			</p>
			<div class="clearfix"></div>
			<?php }
			
			$Thursday = new thursday($persID);
			if ((isset($Thursday ->BegThurs)) && ($Thursday ->BegThurs != ''))
				{ ?>
			<p class="space">
			<label><img src="css/next.gif"/> Thursday <br/> &nbsp;&nbsp;&nbsp;&nbsp; from <strong><?php echo $Thursday ->BegThurs; ?></strong> to <strong><?php echo $Thursday ->EndThurs; ?></strong></label>
			</p>
			<div class="clearfix"></div>
			<?php }
			
			$Friday = new friday($persID);
			if ((isset($Friday ->BegFri)) && ($Friday ->BegFri != ''))
				{ ?>
			<p class="space">
			<label><img src="css/next.gif"/> Friday <br/> &nbsp;&nbsp;&nbsp;&nbsp; from <strong><?php echo $Friday ->BegFri; ?></strong> to <strong><?php echo $Friday ->EndFri; ?></strong></label>
			</p>
			<div class="clearfix"></div>
			<?php }
			
			$Saturday = new saturday($persID);
			if ((isset($Saturday ->BegSat)) && ($Saturday ->BegSat != ''))
				{ ?>
			<p class="space">
			<label><img src="css/next.gif"/> Saturday <br/> &nbsp;&nbsp;&nbsp;&nbsp; from <strong><?php echo $Saturday ->BegSat; ?></strong> to <strong><?php echo $Saturday ->EndSat; ?></strong></label>
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
		<fieldset>
			<img src="./Avatars/<?php echo $persAvatar;?>" style=" max-width:200px;  float:left; margin:3px;"/>
		</fieldset>
	</div>
	
	</div> <!--End rows-->
</div> <!--End panel-->

<div align="center">
<!-- ajouter -->
<form method="post" name="formajouter" action="./Forms/employees.php">
	<input type="hidden" name="traiter" value="ADD" />
	<button name="btAjouter" class="nice large green button" type="submit" title="Add a new employee " style="vertical-align:middle;">
	<img src="Admin/icones/user_add.png" width="24" alt="" /><span> Add another employee</span></button>
</form>
</div>

<?php
	} // Fin de la boucle
}
if ($traiter == 'EDIT')
{
	$persID   = 	mysql_real_escape_string($_POST['persID']);
	
	$pers_query = "SELECT * FROM PERSON WHERE IdPers='".$persID."'";
	$pers_result = mysql_query($pers_query) or die('Erreur SQL :<br />'.$pers_query.'<br />'.mysql_error());
	while ($pers_row = mysql_fetch_array($pers_result))
	{
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
	
	
	/*$dept = new department ($IdDept);
	$NameDept = $dept -> NameDept;
	$LocDept = $dept -> LocDept;*/
	
	$post = new post($IdPost);
	$LabPost = $post ->LabPost;
	
	$skills = new skills($persID);
	$persSkill = $skills ->Skill;
	
?>
<div class="container">
	<div class="alert-box centered success">
		Edition successful.
		<a href="" class="close">&times;</a>
	</div>
</div>

<br />

	<div class="panel">
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
		<?php /*?><p class="space">
				<label class="label15" style="text-align:right; color:#21409A;">Department: </label><?php echo $NameDept." - ".$LocDept ;?>
			</p>
			<div class="clearfix"></div><?php */?>
			
			<p class="space">
				<label class="label15" style="text-align:right; color:#21409A;">Skill: </label><?php echo $persSkill; ?>
			</p>
			<div class="clearfix"></div>
			
	</fieldset></form>
		</div> <!--End 6 cols-->
	
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
			<label><img src="css/next.gif"/> Sunday <br/> &nbsp;&nbsp;&nbsp;&nbsp; from <strong><?php echo $Sunday ->BegSun; ?></strong> to <strong><?php echo $Sunday ->EndSun; ?></strong></label>
			</p>
			<div class="clearfix"></div>
			<?php }
			
			$Monday = new monday($persID);
			if ((isset($Monday ->BegMon)) && ($Monday ->BegMon != ''))
				{ ?>
			<p class="space">
			<label><img src="css/next.gif"/> Monday <br/> &nbsp;&nbsp;&nbsp;&nbsp; from <strong><?php echo $Monday ->BegMon; ?></strong> to <strong><?php echo $Monday ->EndMon; ?></strong></label>
			</p>
			<div class="clearfix"></div>
			<?php }
			
			$Tuesday = new tuesday($persID);
			if ((isset($Tuesday->BegTues)) && ($Tuesday->BegTues != ''))
				{ ?>
			<p class="space">
			<label><img src="css/next.gif"/> Tuesday <br/> &nbsp;&nbsp;&nbsp;&nbsp; from <strong><?php echo $Tuesday ->BegTues; ?></strong> to <strong><?php echo $Tuesday ->EndTues; ?></strong></label>
			</p>
			<div class="clearfix"></div>
			<?php }
			
			$Wednesday = new wednesday($persID);
			if ((isset($Wednesday ->BegWed)) && ($Wednesday ->BegWed != ''))
				{ ?>
			<p class="space">
			<label><img src="css/next.gif"/> Wednesday <br/> &nbsp;&nbsp;&nbsp;&nbsp; from <strong><?php echo $Wednesday ->BegWed; ?></strong> to <strong><?php echo $Wednesday ->EndWed; ?></strong></label>
			</p>
			<div class="clearfix"></div>
			<?php }
			
			$Thursday = new thursday($persID);
			if ((isset($Thursday ->BegThurs)) && ($Thursday ->BegThurs != ''))
				{ ?>
			<p class="space">
			<label><img src="css/next.gif"/> Thursday <br/> &nbsp;&nbsp;&nbsp;&nbsp; from <strong><?php echo $Thursday ->BegThurs; ?></strong> to <strong><?php echo $Thursday ->EndThurs; ?></strong></label>
			</p>
			<div class="clearfix"></div>
			<?php }
			
			$Friday = new friday($persID);
			if ((isset($Friday ->BegFri)) && ($Friday ->BegFri != ''))
				{ ?>
			<p class="space">
			<label><img src="css/next.gif"/> Friday <br/> &nbsp;&nbsp;&nbsp;&nbsp; from <strong><?php echo $Friday ->BegFri; ?></strong> to <strong><?php echo $Friday ->EndFri; ?></strong></label>
			</p>
			<div class="clearfix"></div>
			<?php }
			
			$Saturday = new saturday($persID);
			if ((isset($Saturday ->BegSat)) && ($Saturday ->BegSat != ''))
				{ ?>
			<p class="space">
			<label><img src="css/next.gif"/> Saturday <br/> &nbsp;&nbsp;&nbsp;&nbsp; from <strong><?php echo $Saturday ->BegSat; ?></strong> to <strong><?php echo $Saturday ->EndSat; ?></strong></label>
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
		<fieldset>
			<img src="./Avatars/<?php echo $persAvatar;?>" style=" max-width:200px;  float:left; margin:3px;"/>
		</fieldset>
	</div>
	
	</div> <!--End rows-->
</div> <!--End panel-->
<?php
	} // Fin de la boucle
}
		
// -------------------------
if ($traiter == 'DELETE') { ?>
	<div id="container">	
		<div class="alert-box centered success ">
	The Employee has been deleted.
	<a href="" class="close">&times;</a>
		</div>
	</div>
<?php } ?>

</div><!-- End containercentrer-->
<!-- lien retour -->
<div style="text-align:center;">
<a href="./admin.php#nice4"><div class="large button red" ><img src="./Admin/icones/arrow_back.png" alt="" /> Go back</div></a>
</div>
<br/>

<div id="footer"> <?php include("footer.php");?></div>


	<!-- Included JS Files -->
	<script src="js/jquery.min.js"></script>
	<script src="js/foundation.js"></script>
	<script src="js/app.js"></script>

</body>
</html>