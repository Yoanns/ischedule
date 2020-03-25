<?php

include("../../Model/class.employee.php");
include("../../Model/class.person.php");
include("../../connexion.php");

if(isset($_POST["persID"]))
	{
	$persID = $_POST["persID"];
	// si le visiteur (administrateur ?) a valid� le formulaire
	// on recupere les donnees
	if (isset($_POST['login']) && $_POST['login']!='' && isset($_POST['password']) && $_POST['password']!='')
	{
    $Login = $_POST['login'];
	$pass = $_POST['password'];
    $Pwd = hash('sha512', $pass);
	$employee = new employee(null);
	
	if ($employee->Add($persID,$Login,$Pwd))
		{
			$person = new person($persID);
			$FirstName = $person->FirstName;
			$LastName = $person->LastName;
			
			// from the form
       		$name = $FirstName." ".$LastName;
      		$email = $person->Email;
       		$message = "Hello $name,<br/>
						Thank you for using our management of schedules system. Here are your parameters to log in into the system: <br/>
						Login: $Login <br/>
						Password: $pass<br/><br/>
						Make sure to keep this email. Remember that you can change your credentials anytime through the system.<br/>
						If you have any problem using the system, do not hesitate to contact the <a href=mailto:yoanns@gmail.com>webmaster</a> or your supervisor.";
			$message = htmlentities($message);

       		// set here
       		$subject = "Login information";
       		$from = 'yoanns@gmail.com';

       		$body = $message;

	//echo $name." has as email ".$email." and body =  ".$body ;
       		$headers = "From: $from\r\n";
       		$headers .= "Content-type: text/html\r\n";

       		/*// send the email
      		 if (mail($email, $subject, $body, $headers))
			 	{
       		// redirect afterwords, if needed
       		header('Location: login_emp.php');
			exit;
			} else {*/ ?>

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

	<title>iSchedule | Setting password</title>
  
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
<div id="containercentrer">
	<!--<div class='alert-box error' style="text-align:center;>
					Sorry, impossible to send an email!
					<a href='' class='close'>&times;</a>
				</div>-->
				
				<div class='alert-box centered success' style="text-align:center;">
					Your login and password have been correctly set. Your can now sign in into the system.
					<a href='' class='close'>&times;</a>
				</div>
			<br/><br/>
			
	<!-- retour au site -->
 <div class=" row">
	<div class="twelve columns centered" align="center">
<a href="../../" class="large button red">
		<img src="../icones/arrow_back.png" alt="Go back"  title="Go back"/>Go back
	</a>	
 </div>
 </div>

</div> 
<div id="footer"> <?php include("../../footer.php");?></div>
				
</script>

	<!-- Included JS Files -->
	<script src="../../js/jquery.min.js"></script>
	<script src="../../js/foundation.js"></script>
	<script src="../../js/app.js"></script>

</body>
</html>
<?php
			//}
						
		}
	}
}
	
?>