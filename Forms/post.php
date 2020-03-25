<?php
// protection de page ADMIN
   include_once('../Admin/fonctions/_protectpage.php');
// **************************************
// Parametres de Connexion a la BD
	include_once('../connexion.php');
	
	include("../Model/class.post.php");		

$traiter = '';
if (isset($_POST['traiter']) && ($_POST['traiter']=='ADD' || $_POST['traiter']=='EDIT')){
	$traiter = $_POST['traiter'];
} else {
	// sinon retour a la liste
	header('location: ../admin.php#nice3');
	exit;
}
// -------------------------
// ADD an employee
// -------------------------
if ($traiter == 'ADD')
{
	$postID		= '';
	$postName	= '';
	$IdDept		= $_SESSION["IdDept"];
}
// -------------------------
// EDIT an employee
// -------------------------
elseif ($traiter == 'EDIT')
{
	$postID = 	    mysql_real_escape_string($_POST['postID']);
	// recuperation des infos correspondantes
	$query_modif = 		"SELECT * FROM POST WHERE IdPost='".$postID."'";
	$result_modif = 	mysql_query($query_modif) or die('Erreur SQL :<br />'.$query_modif.'<br />'.mysql_error());
    $row_modif = 		mysql_fetch_array($result_modif);
	
    $postName = 		stripslashes($row_modif['LabPost']);
	$IdDept   = 		stripslashes($row_modif['IdDept']);
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

	<title>Shift-Scheduler.com | <?php echo $traiter; ?> A POSITION</title>
	<link rel="shortcut icon" type="image/x-icon" href="../Admin/icones/ischedule_logo1.ico">
	
	<!-- Included CSS Files -->
	<link rel="stylesheet" href="../css/foundation_style.css">
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
	

    <link href="../css/main.css" rel="stylesheet" media="screen" type="text/css" />
    
	
</head>

<body>
<div id="containercentrer">
<br/>
<h1><?php echo $traiter; ?> A POSITION</h1><br/>
	<div class="row">
		<div class="nine centered columns">
			<div class="panel">
				<div class="ten centered">
						<!-- formulaire -->
<form id="PostForm" method="post" enctype="multipart/form-data" action="../post_treatment.php">
		<fieldset>
<input type="hidden" name="traiter" value="<?php echo $traiter; ?>" />
<input type="hidden" name="postID" value="<?php echo $postID; ?>" />
<input type="hidden" name="IdDept" value="<?php echo $IdDept; ?>" />
       <label>  Position title  </label>
            <input id="Name" name="Name" type="text" size="40" value="<?php echo $postName; ?>" required="required"/>
			
                               <div class="row">
	<div class="six centered columns">
		<p style="text-align:center;">            
         		<button name="addpers" type="submit" value="<?php echo $traiter; ?>" class="large button green"><img src="../Admin/icones/<?php echo $traiter; ?>.png" alt="" /><?php echo $traiter; ?> position </button>	
		</p>
	</div> <!--End 6 cols-->
</div>	<!--End row-->
<br/>
</fieldset>
</form>
				</div>
			</div> <!--End panel-->
		</div><!-- End six columns-->
	</div>	<!--End row-->	
	
	<div class="row">	
		<div class="twelve columns centered">
					<a href="../admin.php#nice4"><div class="large button red" ><img src="../Admin/icones/arrow_back.png" alt="" /> Go back</div></a>
		</div> <!--End 6 cols-->
	</div>
	
</div>	

<div id="footer"> <?php include("../footer.php");?></div>


	<!-- Included JS Files -->
	<script src="../js/jquery.min.js"></script>
	<script src="../js/foundation.js"></script>
	<script src="../js/app.js"></script>

</body>
</html>
