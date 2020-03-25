<?php
	include("./connexion.php");
	include("Model/class.person.php");
	
if(isset($_GET["persID"]))
	{

		$persID = $_GET['persID'];
		$person = new person($persID);
		$thefirstname = $person->FirstName;
		
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

	<title>Shift-Scheduler.com | Setting of credentials</title>
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
				<div class="row">
					<div class="seven columns centered">
						<div class="panel">
						<!-- identification - connexion -->
<div style="text-align:center; margin:0 auto; padding:10px; border: 2px dashed #CCCCCC; background-color: #FFFFFF;">
<form id="identification" method="post" action="Admin/fonctions/_setuser.php">
<input type="hidden" name="persID" value="<?php echo $persID; ?>" />
<!--<fieldset>-->
	<h3><img src="Admin/icones/verrouiller.png" alt="" />Registration</h3>
	<p>Hello <?php echo $thefirstname;?>, please set your login and password</p>
	<p>
		<label class="label14" for="login" style="text-align:right; display:inline;">Login : </label>
		<input class="eight columns"  id="login" name="login" type="text" size="20" required="required"/>
	</p>
	<div class="clearfix"></div>
	<p>
		<label class="label14" for="password" style="text-align:right;">Password : </label>
		<input class="eight columns" id="password" name="password" type="password" size="20" required="required"/>
	</p>
	<div class="clearfix"></div>
	<p>
		<label class="label14" for="check" style="text-align:right;">Password check: </label>
		<input class="eight columns" id="check" name="check" type="password" size="20" data-equals="password" required="required" />
	</p>
	<div class="clearfix"></div>
	<p style="text-align:center;">
		<button name="usrsubmit" type="submit" title="Connexion" class="large green button">
		<img src="Admin/icones/OK.png" alt="" />Register</button>
	</p>
	<h4>&nbsp;</h4>
	<!--</fieldset>-->
</form>
</div><br/>
</div> <!--End panel-->
</div><!-- End six columns-->
</div><!-- End row-->


<!-- retour au site -->
	<div class="twelve columns centered" align="center">
<a href="./" ><div class="large button red" ><img src="./Admin/icones/arrow_back.png" alt="" /> Go back</div></a>
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
<?php 
} // end if $_GET["persID"]

?>
