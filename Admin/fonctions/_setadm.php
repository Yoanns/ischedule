<?php

include("../../Model/class.admin.php");
include("../../connexion.php");


			// Are both passwords set and are they identical?

    	if ( !empty( $_POST['password'] ) && $_POST['password'] != $_POST['check'] )

        	{?>
				<!-- Included CSS Files -->
	<link rel="stylesheet" href="../../css/foundation.css">
	<link rel="stylesheet" href="../../css/app.css">
	<link rel="stylesheet" media="screen" type="text/css" href="../css_adm/news_ADM_style.css" />

	<!--[if lt IE 9]>
		<link rel="stylesheet" href="../../css/ie.css">
	<![endif]-->
	
	<script src="../../js/modernizr.foundation.js"></script>

	<!-- IE Fix for HTML5 Tags -->
	<!--[if lt IE 9]>
		<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
			<div class="container">
				<div class='alert-box error' style='text-align:center'>
					The passwords you entered do not match.
					<a href='' class='close'>&times;</a>
				</div>
			</div>
				
<!-- retour au site -->
<div style="margin:30px auto; text-align:center;">
<form id="formretour" method="post" action="../../pwd_adm.php">
	<button name="btretour" type="submit" title="go back" class=" large red button"><img src="../icones/arrow_back.png" alt="" /> Go back</button>
</form>
</div>
<?php
			exit;
			}
		
if(isset($_POST["persID"]))
	{
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

	<title>iSchedule | Setting login & password</title>
  
	<!-- Included CSS Files -->
	<link rel="stylesheet" href="../../css/foundation.css">
	<link rel="stylesheet" href="../../css/app.css">
	<link rel="stylesheet" media="screen" type="text/css" href="../css_adm/news_ADM_style.css" />

	<!--[if lt IE 9]>
		<link rel="stylesheet" href="../../css/ie.css">
	<![endif]-->
	
	<script src="../../js/modernizr.foundation.js"></script>

	<!-- IE Fix for HTML5 Tags -->
	<!--[if lt IE 9]>
		<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
	</head>
	<body>
	<?php	
	// si le visiteur (administrateur ?) a valid� le formulaire
	// on recupere les donnees
	if (isset($_POST['login']) && $_POST['login']!='' && isset($_POST['password']) && $_POST['password']!='')
	{
    $Login = $_POST['login'];
    $pass = $_POST['password'];
    $Pwd = hash('sha512', $pass);
	$admin = new admin($persID);
	
	
			
			if ($admin->Edit($persID,$Login,$Pwd))
		{	?>	
			<div class="container">
				<div class='alert-box success' style='text-align:center'>
					Login & password successfully set.
					<a href='' class='close'>&times;</a>
				</div>
			</div>
				
				
<!-- retour au site -->
<div style="margin:30px auto; text-align:center;">
<form id="formretour" method="post" action="../../admin.php#nice4">
	<button name="btretour" type="submit" title="go back" class=" large red button"><img src="../icones/arrow_back.png" alt="" /> Go back</button>
</form>
</div>
<?php
						
		} else {
		echo "<div class='alert-box error' style='text-align:center'>
					Oops! An error has occured. Please try again or contact the system administrator.
					<a href='' class='close'>&times;</a>
				</div>";
				?>
				
<!-- retour au site -->
<div style="margin:30px auto; text-align:center;">
<form id="formretour" method="post" action="../../admin.php#nice4">
	<button name="btretour" type="submit" title="go back" class=" large red button"><img src="../icones/arrow_back.png" alt="" /> Go back</button>
</form>
</div>
<?php
			}		
	} else {
		echo "<div class='alert-box error' style='text-align:center'>
					Oops! Cannot read the Login and the Password. Please try again or contact the system administrator.
					<a href='' class='close'>&times;</a>
				</div>";
				?>
				
<!-- retour au site -->
 <div class=" twelve row">
	<div class="twelve columns centered" align="center">
<a href="../../admin.php#nice4" class="large button red">
		<img src="../Admin/icones/arrow_back.png" alt="Go back"  title="Go back"/>Go back
	</a>	
 </div>
 </div>

<?php
			}	
}
?>

	<!-- Included JS Files -->
	<script src="../../js/jquery.min.js"></script>
	<script src="../../js/foundation.js"></script>
	<script src="../../js/app.js"></script>

</body>
</html>