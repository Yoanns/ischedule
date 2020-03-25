<?php
	include("./connexion.php");
	$persID = $_POST["persID"];
	
	
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

	<title>Shift-Scheduler.com | Setting of login &amp; password</title>
	<link rel="shortcut icon" type="image/x-icon" href="./Admin/icones/ischedule_logo1.ico">
	
<!-- Included CSS Files -->
	<link rel="stylesheet" href="css/foundation.css">
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
				<div class="row">
					<div class="twelve columns centered">
						<div class="panel">
						<!-- identification - connexion -->
<div style="width:500px; text-align:center; margin:0 auto; padding:10px; border: 2px dashed #CCCCCC; background-color: #FFFFFF;">
<form id="identification" method="post" action="Admin/fonctions/_setadm.php">
<input type="hidden" name="persID" value="<?php echo $persID; ?>" />
<!--<fieldset>-->
	<h3><img src="Admin/icones/verrouiller.png" alt="" />Registration</h3>
	<p>
		<label class="label14" for="login" style="text-align:right;">Login : </label>
		<input class="champobligatoire" id="login" name="login" size="20" required="required"/>
	</p>
	<p>
		<label class="label14" for="password" style="text-align:right;">Password : </label>
		<input class="champobligatoire" id="password" name="password" type="password" size="20" required="required"/>
	</p>
	<p>
		<label class="label14" for="check" style="text-align:right;">Password check: </label>
		<input class="champobligatoire" id="check" name="check" type="password" size="20" data-equals="password" required="required" />
	</p>
	<p style="text-align:center;">
		<button name="admsubmit" type="submit" title="Connexion" class="large blue button">
		<img src="Admin/icones/save.jpg" alt="" />Save</button>
	</p>
	<h4>&nbsp;</h4>
	<!--</fieldset>-->
</form>
</div><br/>
</div> <!--End panel-->
</div><!-- End six columns-->
</div><!-- End row-->


<!-- lien retour -->
<div class="VALIDATION-FINALE">
<a href="./admin.php#nice4"><div class="large button red" ><img src="./Admin/icones/arrow_back.png" alt="" /> Go back</div></a>

</div>

<br />
</div>

<div id="footer"> <?php include("footer.php");?></div>


<!-- Included JS Files -->
	<script src="js/jquery.min.js"></script>
	<script src="js/foundation.js"></script>
	<script src="js/app.js"></script>

</body>
</html>
