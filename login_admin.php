<?php
/*Copyright (c)2010 Yoann SENIN - yoanns[at]afrinalwebhost.com */
// ***************************************************************
// ADMIN NEWS : IDENTIFICATION
// ***************************************************************
// Protection de page index ADMIN
   include_once('./Admin/fonctions/_protect.php');
// **************************************
// CONFIGURATION de la NEWS
	//include_once('./fonctions/news_config.php');
// **************************************
// Acc�s autoris� si identifi�
if (isset($_SESSION['sched_SESSION']) && $_SESSION['sched_SESSION']==true)
{  
   // Redirection vers la page d administration
   header("location: ./admin.php");
   exit;
}
elseif (isset($_SESSION['adm_SESSION']) && $_SESSION['adm_SESSION']==true)
{  
   // Redirection vers la page d administration
   header("location: ./admin_spr.php");
   exit;
}
// ------------------------------------------------------
// sinon affichage du formulaire d'identification
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

	<title>Shift-Scheduler.com | Setting of schedules</title>
	<link rel="shortcut icon" type="image/x-icon" href="./Admin/icones/ischedule_logo1.ico">
	
<!-- Included CSS Files -->
	<link rel="stylesheet" href="css/foundation_style.css">
	<link rel="stylesheet" href="css/app.css">
	<link rel="stylesheet" media="screen" type="text/css" href="Admin/css_adm/news_ADM_style.css" />

	<!--[if lt IE 9]>
		<link rel="stylesheet" href="css/ie.css">
	<![endif]-->
	
	<script src="js/modernizr.foundation.js"></script>

	<!-- IE Fix for HTML5 Tags -->
	<!--[if lt IE 9]>
		<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
</head>

<body>
<div id="containercentrer">

<h1>Setting of schedules</h1>
<br />
<div class="row">
	<div class="seven centered columns">
		<div class="panel">
<!-- identification - connexion -->
<div style="width:380px; text-align:center; margin:0 auto; padding:10px; border: 2px dashed #CCCCCC; background-color: #FFFFFF;">
<form id="identification" method="post" action="login_admin.php">
<!--<fieldset>-->
	<h3><img src="Admin/icones/verrouiller.png" alt="" /> Identify yourself :</h3>
	<p>
		<label class="label15" for="idlogin" style="text-align:right;">Login : </label>
		<input class="eight columns" type="text" id="login" name="login" size="20" />
	</p>
	<p>
		<label class="label15" for="idpass" style="text-align:right;">Password : </label>
		<input class="eight columns" id="pass" name="pass" type="password" size="20" />
	</p>
	<p style="text-align:center;">
		<button name="btsubmit" type="submit" title="Connection" class="large radius green button">
		<img src="Admin/icones/arrow_next.png" alt="" /> Log in</button>
	</p>
	<h4>&nbsp;</h4>
	<!--</fieldset>-->
</form>
</div>

<div style="text-align:center; margin:0 auto; padding:10px;">
<span class="important"><?php echo @$msgerreur; ?></span>
</div>

<!-- retour au site -->
	<div class="twelve columns centered" align="center">
<a href="./" ><div class="large radius button red" ><img src="./Admin/icones/arrow_back.png" alt="" /> Go back</div></a>
 </div>
 
<br />
</div>
</div>
</div>		

</div>

<div id="footer"> <?php include("footer.php");?></div>

	<!-- Included JS Files -->
	<script src="js/jquery.min.js"></script>
	<script src="js/foundation.js"></script>
	<script src="js/app.js"></script>

</body>
</html>