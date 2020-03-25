<?php
// protection de page ADMIN
   include_once('../Admin/fonctions/_protectpageadm.php');
// **************************************
// Parametres de Connexion a la BD
	include_once('../connexion.php');
// Parametres de CONFIGURATION de Employees
	include_once('../Admin/fonctions/config.php');
// **************************************
// Fonctions de traitement d image
	include_once('../Admin/fonctions/fct_traitement_image.php');
// **************************************	
	include_once('../Model/class.department.php');
	include_once('../Model/class.location.php'); 

$traiter = '';
if (isset($_POST['traiter']) && ($_POST['traiter']=='ADD' || $_POST['traiter']=='EDIT')){
	$traiter = $_POST['traiter'];
} else {
	// sinon retour a la liste
	header('location: ../admin_spr.php#nice5');
	exit;
}



// -------------------------
// ADD a location
// -------------------------
if ($traiter == 'ADD')
{
	$IdDept		=	"";
	$NameDept	=	"";
	$IdLoc		=	"";
}

// -------------------------
// EDIT a location
// -------------------------
elseif ($traiter == 'EDIT')
{
	$IdDept		=	mysql_real_escape_string($_POST['IdDept']);
	$Dept = new department($IdDept);
	$NameDept = $Dept -> NameDept;
	$IdLoc		=	$Dept -> IdLoc;
		
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

	<title>Shift-Scheduler.com | <?php echo $traiter; ?> A DEPARTMENT</title>
	<link rel="shortcut icon" type="image/x-icon" href="../Admin/icones/ischedule_logo1.ico">
	
	<!-- Included CSS Files -->
	<link rel="stylesheet" href="../css/foundation_style.css">
	<link rel="stylesheet" href="../css/app.css">
	<link rel="stylesheet" media="screen" type="text/css" href="../Admin/css_adm/news_ADM_style.css" />

	<!--[if lt IE 9]>
		<link rel="stylesheet" href="../css/ie.css">
	<![endif]-->
	
	<script src="../js/jquery.min.js"></script>	
	<script src="../js/modernizr.foundation.js"></script>

	<!-- IE Fix for HTML5 Tags -->
	<!--[if lt IE 9]>
		<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
	   
	
</head>

<body>
<div id="containercentrer">
<br/>
<h1><?php echo $traiter; ?> A DEPARTMENT</h1><br/>
	<div class="row">
		<div class="nine centered columns">
			<div class="panel">
	
						<div id="signup" class="ten centered">
								<form id="myForm" method="post" enctype="multipart/form-data" action="../dept_treatment.php">
								<fieldset>
									<input type='hidden' name="traiter" value="<?php echo $traiter;?>" />
									<input type='hidden' name="IdDept" value="<?php echo $IdDept;?>" />
									<label>Name</label>
									<input type="text" id="NameDept" name="NameDept" value="<?php echo $NameDept;?>" placeholder="Department name" required="required"/>
									
									
		
									<label>Location</label>
  									<div class="row">
    									
										<div class="four columns">
      							<select name="IdLoc" id="IdLoc" required="required" >
								 <option value="">Please select</option>
									<?php
						
							$Loc = new location(null);
							if (false!=$Loc->Listing())
								$listLoc=$Loc->Listing();
								
								if (!empty($listLoc))
								{
									while ($row=mysql_fetch_array($listLoc))
									{
										$NameLoc = $row["NameLoc"];
										$LocID = $row["IdLoc"];
										
								?>
									<option value="<?php echo $LocID; ?>" <?php if ($LocID == $IdLoc) echo  'selected="selected"' ;?> ><?php echo $NameLoc; ?></option>
									
									<?php
									}
								}
							   ?>
								  </select>
										</div>
    									
  									</div> 
									
									
									<br/>
									<div class="row">
	<div class="six centered columns">
		<p style="text-align:center;">            
         		<button name="addloc" type="submit" value="<?php echo $traiter; ?>" class="large button green"><!--<img src="../Admin/icones/<?php echo $traiter; ?>.png" alt="" />--><?php echo $traiter; ?> department </button>	
		</p>
	</div> <!--End 6 cols-->
	
</div>	<!--End row-->							
									<br/><br/>
									</fieldset>
								</form>
							</div>
				</div> <!--End panel-->
		</div><!-- End 9 columns-->
	</div>	<!--End row-->	


 <div class="row">
	<div class="twelve columns centered" align="center">
		<a href="../admin_spr.php#nice5" title="Go back"><div class="large button red" ><img src="../Admin/icones/arrow_back.png" alt="" /> Go back</div></a>	
 	</div>
 </div>

<br/>
</div> <!--End containercentrer-->


<div id="footer"> <?php include("../footer.php");?></div>


	<!-- Included JS Files -->
	<script src="../js/foundation.js"></script>
	<script src="../js/app.js"></script>

</body>
</html>
