<?php
// ***************************************************************
// protection de page ADMIN
   include_once('./Admin/fonctions/_protectpage.php');
// **************************************
// Parametres de Connexion a la BD
	include_once('connexion.php');
// **************************************
	include_once('Model/class.post.php');
	include_once('Model/class.department.php');
	include_once('Model/class.location.php');
	
$traiter = '';
if (isset($_POST['traiter']) && ($_POST['traiter']=='ADD' || $_POST['traiter']=='EDIT' || $_POST['traiter']=='DELETE')) {
	$traiter = $_POST['traiter'];
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
	$postName  = 		mysql_real_escape_string($_POST['Name']);
	$IdDept  = 		mysql_real_escape_string($_POST['IdDept']);
	
	$check_query = "SELECT * FROM post WHERE LabPost = '$postName' ";
	 $check_result =  mysql_query($check_query) or die('Erreur SQL :<br />'.$check_query.'<br />'.mysql_error());
	 $check_nb =  mysql_num_rows($check_result);
	 
if ($check_nb > 0)
	{ ?>
	
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
 <div id="container">
		<div class="alert-box centered warning" style="text-align:center">
			The position <strong style="text-transform:uppercase;"><?php echo $postName;?></strong> has already been created.
			<a href="" class="close">&times;</a>
		</div>
</div><br/>
	<!-- lien retour -->
<div class="VALIDATION-FINALE">
<a class="large red button" href="./admin.php#nice4"><img src="./Admin/icones/arrow_back.png" alt="" /> Go back</a>
</div>

</div>

<div align="center"><img src="Admin/images/Horizontal Dividor.png" /></div>
<div id="footer"> <?php include("footer.php");?></div>


	<!-- Included JS Files -->
	<script src="js/jquery.min.js"></script>
	<script src="js/foundation.js"></script>
	<script src="js/app.js"></script>

</body>
</html>
	<?php
	exit;
	} 	// Endif ($check_nb > 0)
	
	elseif ($check_nb == 0)
		{
			// on cree une nouvelle entree dans la table
			$post = new post(null);
			$post -> Add($postName,$IdDept);
		}
	/*$query_insert = 	"INSERT INTO POST
						 (LabPost) 
						 VALUES('".$postName."')";
	mysql_query($query_insert) or die('Erreur SQL :<br />'.$query_insert.'<br />'.mysql_error());*/
	// ----------------------
}
// -------------------------
// Traitement : EDIT
// -------------------------
elseif ($traiter == 'EDIT')
{
	$postID   = 		mysql_real_escape_string($_POST['postID']);
	$postName = 		mysql_real_escape_string($_POST['Name']);
	$IdDept   = 		mysql_real_escape_string($_POST['IdDept']);
	
	$check_query = "SELECT * FROM post WHERE LabPost = '$postName' ";
	 $check_result =  mysql_query($check_query) or die('Erreur SQL :<br />'.$check_query.'<br />'.mysql_error());
	 $check_nb =  mysql_num_rows($check_result);
	 
if ($check_nb > 0)
	{ ?>

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
 <div id="container">
		<div class="alert-box centered warning" style="text-align:center">
			The position <strong style="text-transform:uppercase;"><?php echo $postName;?></strong> has already been created.
			<a href="" class="close">&times;</a>
		</div>
</div><br/>
	<!-- lien retour -->
<div class="VALIDATION-FINALE">
<a class="large red button" href="./admin.php#nice4"><img src="./Admin/icones/arrow_back.png" alt="" /> Go back</a>
</div>

</div>

<div align="center"><img src="Admin/images/Horizontal Dividor.png" /></div>
<div id="footer"> <?php include("footer.php");?></div>


	<!-- Included JS Files -->
	<script src="js/jquery.min.js"></script>
	<script src="js/foundation.js"></script>
	<script src="js/app.js"></script>

</body>
</html>
	<?php
	exit;
	} 	// Endif ($check_nb > 0)
	
	elseif ($check_nb == 0)
		{
			// modification : on met a jour le post
			$post = new post($postID);
			$post -> Edit($postName,$IdDept);
		}
	
	/*$query_update = 	"UPDATE POST SET ".
						" LabPost='".$postName."' WHERE IdPost='".$postID."';";
	mysql_query($query_update) or die('Erreur SQL :<br />'.$query_update.'<br />'.mysql_error());*/
	// ----------------------
}
// -------------------------
// Traitement : DELETE
// -------------------------
elseif ($traiter == 'DELETE')
{
	$postID = mysql_real_escape_string($_POST['postID']);
	// suppression dans la BD
	$query_delete = 	"DELETE FROM POST WHERE IdPost='".$postID."';";
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
	<title>Shift-Scheduler.com | <?php echo $traiter; ?> A POSITION</title>
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

<h1>ADMINISTRATION OF POSITIONS</h1>
<h2><?php echo $traiter; ?> a Position</h2>

<?php
// -------------------------
/*
	//  recuperation de id de LA DERNIERE fiche cree
	$result_maxid = mysql_query("SELECT MAX(IdPers) AS idmax FROM PERSON");
	$val_maxid = 	mysql_fetch_array($result_maxid);
	$persID = 		$val_maxid['idmax'];
*/
// re-affichage
if ($traiter == 'ADD' )
{
//  recuperation de id de LA DERNIERE fiche cree
	$result_maxid = mysql_query("SELECT MAX(IdPost) AS idmax FROM POST");
	$val_maxid = 	mysql_fetch_array($result_maxid);
	$postID = 		$val_maxid['idmax'];
	
	$post = new post($postID);
	$postName = $post -> LabPost;
	$IdDept = $post -> IdDept;
	
	$Dept = new department($IdDept);
	$NameDept = $Dept -> NameDept;
	$IdLoc = $Dept -> IdLoc;
	
	$loc = new location($IdLoc);
	$NameLoc = $loc -> NameLoc;
	
?>
	 <div id="container">	
		<div class="alert-box centered success ">
	The position has been successfully saved.
	<a href="" class="close">&times;</a>
		</div>
		
		<br />
	<div class="row">
		<div class="nine centered columns">
			<div class="panel">
				<p class="space">
				<label class="label14"  style="text-align:right; color:#21409A;">Position name: </label><?php echo $postName; ?>
			</p>	    
			<div class="clearfix"></div>
			<p class="space">
				<label class="label14"  style="text-align:right; color:#21409A;">Position location: </label><?php echo $NameDept.", ".$NameLoc; ?>
			</p>
			<div class="clearfix"></div>
			
			</div>
		</div>
	</div>
			
			
	</div>
		
		
<?php
}

if ($traiter == 'EDIT')
{
	$post = new post($postID);
	$postName = $post -> LabPost;
	$IdDept = $post -> IdDept;
	
	$Dept = new department($IdDept);
	$NameDept = $Dept -> NameDept;
	$IdLoc = $Dept -> IdLoc;
	
	$loc = new location($IdLoc);
	$NameLoc = $loc -> NameLoc;
	
	?>
	<div id="container">	
		<div class="alert-box centered success ">
	The position has been successfully edited.
	<a href="" class="close">&times;</a>
		</div>
	</div>
	 	<br />
	<div class="row">
		<div class="nine centered columns">
			<div class="panel">
				<p class="space">
				<label class="label14"  style="text-align:right; color:#21409A;">Position name: </label><?php echo $postName; ?>
			</p>	    
			<div class="clearfix"></div>
			<p class="space">
				<label class="label14"  style="text-align:right; color:#21409A;">Position location: </label><?php echo $NameDept.", ".$NameLoc; ?>
			</p>
			<div class="clearfix"></div>
			
			</div>
		</div>
	</div>
			
<?php
}
		
// -------------------------
if ($traiter == 'DELETE') { ?>
	<div id="container">	
		<div class="alert-box centered success ">
	The position has been deleted.
	<a href="" class="close">&times;</a>
		</div>
	</div>
<?php } ?>

<!-- lien retour -->
<div class="VALIDATION-FINALE">
<a href="./admin.php#nice4"><div class="large button red" ><img src="./Admin/icones/arrow_back.png" alt="" /> Go back</div></a>
</div>

</div>

<div id="footer"> <?php include("footer.php");?></div>


	<!-- Included JS Files -->
	<script src="js/jquery.min.js"></script>
	<script src="js/foundation.js"></script>
	<script src="js/app.js"></script>

</body>
</html>