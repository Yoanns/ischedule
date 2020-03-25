<?php
// ***************************************************************
// NEWS - FICHE DETAILLEE
// ***************************************************************
// protection de page ADMIN
    include_once('../Admin/fonctions/_protectpage.php');
// Parametres de Connexion a la BD
	include_once('../connexion.php');   
// DOSSIER des ICONES (administration)
	$DossierIcones = '../Admin/icones/';
	
	include_once("../Model/class.address.php");
	include_once("../Model/class.post.php");
	include_once("../Model/class.department.php");
	include_once("../Model/class.skills.php");
	include_once('../Model/class.sunday.php');
	include_once('../Model/class.monday.php');
	include_once('../Model/class.tuesday.php');
	include_once('../Model/class.wednesday.php');
	include_once('../Model/class.thursday.php');
	include_once('../Model/class.friday.php');
	include_once('../Model/class.saturday.php');



function phone_number($sPhone){
    $sPhone = preg_replace("[^0-9]",'',$sPhone);
    if(strlen($sPhone) != 10) return(False);
    $sArea = substr($sPhone,0,3);
    $sPrefix = substr($sPhone,3,3);
    $sNumber = substr($sPhone,6,4);
    $sPhone = "(".$sArea.") ".$sPrefix." - ".$sNumber;
    return($sPhone);
} 

function psu_id($sPSU){
    $sPSU = preg_replace("[^0-9]",'',$sPSU);
    if(strlen($sPSU) != 9) return(False);
    $sArea = substr($sPSU,0,1);
    $sPrefix = substr($sPSU,1,4);
    $sNumber = substr($sPSU,5,4);
    $sPSU = $sArea." ".$sPrefix." ".$sNumber;
    return($sPSU);
} 

// -------------------------
if (isset($_GET['id']) && $_GET['id']!='')
{
	// On recupere l id dans l'URL
	$persID = 		mysql_real_escape_string($_GET['id']);
} /*else {
	// sinon recuperation de id de LA DERNIERE fiche cree
	$result_maxid = mysql_query("SELECT MAX(IdNews) AS idmax FROM ".$table_pers);
	$val_maxid = 	mysql_fetch_array($result_maxid);
	$persID = 		$val_maxid['idmax'];
}*/
// -------------------------
?>
<?php
// -------------------------
// Affichage des personnes
// -------------------------
// On recupere les infos dans la BD
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
    $IdDept			=	$pers_row['IdDept'];
	$IdPost 		= 	$pers_row['IdPost'];
	
	
	$dept = new department ($IdDept);
	$NameDept = $dept -> NameDept;
	$LocDept = $dept -> LocDept;
	
	$post = new post($IdPost);
	$LabPost = $post ->LabPost;
	
	$skills = new skills($persID);
	$persSkill = $skills ->Skill;

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

	<title>Shift-Scheduler.com | <?php echo $persFirstName." ".$persLastName; ?>' file</title>
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
</head>
<body>
<div id="containercentrer">
<br />


	<div class="panel">
<div class="row">

<div class="five columns">
<form>
<fieldset>
	<h4  style="text-align:center;">Personal information</h4>
			<p class="space">
				<label class="label14"  style="text-align:right;">PSU ID: </label><?php echo $IdPers; ?>
			</p>	    
			<div class="clearfix"></div>
			<p class="space">
				<label class="label14"  style="text-align:right;">Name: </label><?php echo $persFirstName." ".$persLastName; ?>
			</p>
			<div class="clearfix"></div>
		<p class="space">
				<label class="label14" style="text-align:right;">Date of birth: </label><?php echo $persDOB; ?>
			</p>
			<div class="clearfix"></div>
		<p class="space">
				<label class="label14" style="text-align:right;">Email: </label><?php echo $persEmail; ?>
			</p>
			<div class="clearfix"></div>
		<p class="space">
				<label class="label14"  style="text-align:right;">Phone: </label><?php echo $persPhone; ?>
			</p>
			<div class="clearfix"></div>
		<p class="space">
				<label class="label14" style="text-align:right;">Hours of work: </label><?php echo $persWorkHrs; ?>
			</p>
			<div class="clearfix"></div>
		<p class="space">
				<label class="label14" style="text-align:right;">Position: </label><?php echo $LabPost; ?>
			</p>
			<div class="clearfix"></div>
		<p class="space">
				<label class="label14" style="text-align:right;">Department: </label><?php echo $NameDept.",".$LocDept ;?>
			</p>
			<div class="clearfix"></div>
			
			<p class="space">
				<label class="label14" style="text-align:right;">Skill: </label><?php echo $persSkill; ?>
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
			
			if (isset($Sunday->BegSun))
				{ ?>
			<p class="space">
			<label>Sunday from <strong><?php echo $Sunday ->BegSun; ?></strong> to <strong><?php echo $Sunday ->EndSun; ?></strong></label>
			</p>
			<div class="clearfix"></div>
			<?php }
			
			$Monday = new monday($persID);
			if (isset($Monday ->BegMon))
				{ ?>
			<p class="space">
			<label>Monday from <strong><?php echo $Monday ->BegMon; ?></strong> to <strong><?php echo $Monday ->EndMon; ?></strong></label>
			</p>
			<div class="clearfix"></div>
			<?php }
			
			$Tuesday = new tuesday($persID);
			if (isset($Tuesday->BegTues))
				{ ?>
			<p class="space">
			<label>Tuesday from <strong><?php echo $Tuesday ->BegTues; ?></strong> to <strong><?php echo $Tuesday ->EndTues; ?></strong></label>
			</p>
			<div class="clearfix"></div>
			<?php }
			
			$Wednesday = new wednesday($persID);
			if (isset($Wednesday ->BegWed))
				{ ?>
			<p class="space">
			<label>Wednesday from <strong><?php echo $Wednesday ->BegWed; ?></strong> to <strong><?php echo $Wednesday ->EndWed; ?></strong></label>
			</p>
			<div class="clearfix"></div>
			<?php }
			
			$Thursday = new thursday($persID);
			if (isset($Thursday ->BegThurs))
				{ ?>
			<p class="space">
			<label>Thursday from <strong><?php echo $Thursday ->BegThurs; ?></strong> to <strong><?php echo $Thursday ->EndThurs; ?></strong></label>
			</p>
			<div class="clearfix"></div>
			<?php }
			
			$Friday = new friday($persID);
			if (isset($Friday ->BegFri))
				{ ?>
			<p class="space">
			<label>Friday from <strong><?php echo $Friday ->BegFri; ?></strong> to <strong><?php echo $Friday ->EndFri; ?></strong></label>
			</p>
			<div class="clearfix"></div>
			<?php }
			
			$Saturday = new saturday($persID);
			if (isset($Saturday ->BegSat))
				{ ?>
			<p class="space">
			<label>Saturday from <strong><?php echo $Saturday ->BegSat; ?></strong> to <strong><?php echo $Saturday ->EndSat; ?></strong></label>
			</p>
			<div class="clearfix"></div>
			<?php }
			
			if ( (!isset($Sunday->BegSun)) && (!isset($Monday ->BegMon)) && (!isset($Tuesday ->BegTues)) && (!isset($Wednesday ->BegWed)) && (!isset($Thursday ->BegThurs)) && (!isset($Friday ->BegFri)) && (!isset($Saturday ->BegSat)) )
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
			<img src="../Avatars/<?php echo $persAvatar;?>" style="/*max-height:250px;*/ max-width:200px; float:left; margin:3px;"/>
		</fieldset>
	</div>
	
	</div> <!--End rows-->
</div> <!--End panel-->
</div>
<?php
	} // Fin de la boucle
	
	mysql_free_result($pers_result);
?>
<div class="clearfix"></div>
<!-- retour au site -->
<div style="margin:30px auto; text-align:center;">
	<button class="red button" name="btretour" type="submit" title="Go back" onClick="window.close();">Close this window</button>
</div>

<div id="footer"> <?php include("../footer.php");?></div>


	<!-- Included JS Files -->
	<script src="../js/jquery.min.js"></script>
	<script src="../js/foundation.js"></script>
	<script src="../js/app.js"></script>


</body>
</html>