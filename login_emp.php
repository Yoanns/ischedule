<?php
/*Copyright (c)2012 Yoann SENIN - yoanns[at]gmail.com */
// ***************************************************************
// ADMIN NEWS : IDENTIFICATION
// ***************************************************************
// Protection de page index ADMIN
   include_once('./Admin/fonctions/_protectEmp.php');
// **************************************
	/*include("./Model/class.employee.php");
	include("./Model/class.person.php");*/
// CONFIGURATION de la NEWS
	//include_once('./fonctions/news_config.php');
// **************************************
/*if (isset($_POST['login']) && ($_POST['login'] !=''))
	{
		$query = "SELECT IdPers FROM employee WHERE Login = '".$_POST['login']."' ";
		$result = mysql_query($query) or die('Erreur SQL :<br />'.$query.'<br />'.mysql_error());
		while ($row = mysql_fetch_array($result))
			{
				$persID    = 	stripslashes($row['IdPers']);
			}
	}*/

// Acc�s autoris� si identifi�
if (isset($_SESSION['sched_SESSION']) && $_SESSION['sched_SESSION']==true)
{  
   // Redirection vers la page d administration
   header("location: ./empl_site.php");
   exit;
}
// ------------------------------------------------------
//include("Model/class.person.php");
	
if(isset($_POST["psusubmit"]))
	{
if (isset($_POST['idpsu']) && ($_POST['idpsu'] !=''))
	{
		$persID = $_POST['idpsu'];
		$employee = new employee($persID);
		if ($employee->IdPers == $persID)
			{?>
			<div id="container">
				<div class="alert-box centered error" style="text-align:center;">
					Your login and password have already been set. Please try again or contact your supervisor.
					<a href="" class="close">&times;</a>			</div>	
			</div>
			<?php
			} 
		else
			{
		
		
		$person = new person($persID);
		if (!isset($person->IdPers))
			{ ?>
			<div id="container" align="center">
				<div class="alert-box centered error" style="text-align:center;">
					Sorry, your PSU ID has not been recognized. Please try again or contact your supervisor.
					<a href="" class="close">&times;</a>			</div>	
			</div>
			<?php
			} else {
					header("location: new_user.php?persID=$persID");
					exit;
				 	} //end else
				 
				 
				}//end else
} // end if $_POST['idpsu']
} // end if $_POST["psusubmit"]


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
	<script src="js/jquery.min.js"></script>

	<!-- IE Fix for HTML5 Tags -->
	<!--[if lt IE 9]>
		<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
	
<!--Validation-->
<script type="text/javascript">
$(document).ready(function() {
    $("#idpsu").keydown(function(event) {
        // Allow: backspace, delete, tab, escape, and enter
        if ( event.keyCode == 46 || event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 27 || event.keyCode == 13 || 
             // Allow: Ctrl+A
            (event.keyCode == 65 && event.ctrlKey === true) || 
             // Allow: home, end, left, right
            (event.keyCode >= 35 && event.keyCode <= 39)) {
                 // let it happen, don't do anything
                 return;
        }
        else {
            // Ensure that it is a number and stop the keypress
            if (event.shiftKey || (event.keyCode < 48 || event.keyCode > 57) && (event.keyCode < 96 || event.keyCode > 105 )) {
                event.preventDefault(); 
            }   
        }
    });
	
	// Disable right click
	$("#idpsu").bind("contextmenu",function(e){
	        return false;
	    });
	
});


</script>

</head>

<body>
<div id="containercentrer">

<h1>Checking of schedules</h1>
<br /><?php //echo hash('sha512', 'kano');?>
<div class="row">
			<div class="six columns">
			<div class="panel">
<!-- identification - connexion -->
<div style="width:380px; text-align:center; margin:0 auto; padding:10px; border: 2px dashed #CCCCCC; background-color: #FFFFFF;">
<form id="identification" method="post" action="login_emp.php">
	<h3><img src="Admin/icones/verrouiller.png" alt="" /> Identify yourself :</h3>
	<br/>
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
</form>
</div>

<div style="text-align:center; margin:0 auto; padding:10px;">
<span class="important"><?php echo @$msgerreur; ?></span>
</div>

<br />
<!--<a href="">Oops! I forgot my password!</a><br />-->
</div> <!--End panel-->
</div><!-- End six columns-->

	<div class="six columns">
			<div class="panel">
<!-- identification - connexion -->
<div style="width:380px; text-align:center; margin:0 auto; padding:10px; border: 2px dashed #CCCCCC; background-color: #FFFFFF;">
<form id="identification" method="post" action="login_emp.php">
<!--<fieldset>-->
	<h3><img src="Admin/icones/verrouiller.png" alt="" /> First visit?</h3>
	
	<p> Please enter your PSU ID in order to set your login and password.</p>
	<p>
		<label  class="label15" for="idpsu" style="text-align:right;">PSU ID : </label>
		<input class="eight columns" type="text" id="idpsu" name="idpsu" maxlength="9" size="20" />
	</p>
	<p style="text-align:center;">
		<button name="psusubmit" type="submit" title="Connexion" class="large radius green button">
		<img src="Admin/icones/arrow_next.png" alt="" /> Submit</button>
	</p>
	<h4>&nbsp;</h4>
	<!--</fieldset>-->
</form>
</div>

<div style="text-align:center; margin:0 auto; padding:10px;">
</div>

<br />
</div> <!--End panel-->
</div><!-- End six columns-->

</div>	<!--End row-->	

<!-- retour au site -->
 <div class="row">
	<div class="twelve columns centered" align="center">
<a href="./"><div class="large radius button red" ><img src="./Admin/icones/arrow_back.png" alt="" /> Go back</div></a>
 </div>
 </div>
 

</div>

<div id="footer"> <?php include("footer.php");?></div>

	<!-- Included JS Files -->
	<!--<script src="js/jquery.min.js"></script>-->
	<script src="js/foundation.js"></script>
	<script src="js/app.js"></script>

</body>
</html>