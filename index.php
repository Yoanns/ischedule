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

	<title>Shift-Scheduler.com | Management of schedules system</title>
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

<br />
	<div class="row">
		<div class="twelve columns">
			<div class="panel">
<h1>Welcome to the Nittany Lion Inn <br/>Management of schedules system</h1>

<br /><br /><br />
		<div class="row">
		
		  <a href="login_emp.php" class="nice radius large blue button" style="margin-right:20px;">
		  	<div class="twelve columns" style="height:80px; width:150px; top:20px; display:block;">
					<img src="./Admin/icones/user.png" alt=""/>Sign in as an <br/><br/>Employee
		  	</div>
		</a>	
		  
			<a href="login_admin.php" class="nice radius large blue button">
				<div class="twelve columns" style="height:80px; width:150px; top:20px; display:block;">
					<img src="./Admin/icones/administrator.png" alt="" />Sign in as an <br/><br/>Administrator
				</div>
			</a>	
						
		</div>
		<br /><br /><br />
			</div>
		</div>
	</div>		
<?php //echo hash('sha512', 'test'); ?>
</div>

<div id="footer"> <?php include("footer.php");?></div>

	<!-- Included JS Files -->
	<script src="js/jquery.min.js"></script>
	<script src="js/foundation.js"></script>
	<script src="js/app.js"></script>

</body>
</html>