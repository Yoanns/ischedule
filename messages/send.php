<?php
// protection de page 
    include_once('../Admin/fonctions/_protectpage.php');
	require_once('sendMsg.php');	

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

	<title>Shift-Scheduler.com | Compose</title>
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
	
	<!-- Editeur WYSIWYG : ckeditor -->
<script type="text/javascript" src="../utilities/ckeditor/ckeditor.js"></script>
<!--<script type="text/javascript" src="../utilities/ckeditor/plugins/dialog/dialogDefinition.js"></script>-->
	
	<link rel="stylesheet" href="../css/autosuggest.css">
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.js"></script>
	<script src="../js/jquery.autoSuggest.minified.js"></script>
	
<script type="text/javascript">
 $(document).ready(function() {
	$("#ToEmp").autoSuggest("autosuggest.php", {selectedItemProp: "name", searchObjProps: "name", asHtmlID:"emp"});
	});

</script>

</head>

<body>
<div id="containercentrer">
<h4 style="text-align:center;">Compose a message</h4>
<div class="row">
	<div class="twelve centered columns">
		<div class="panel">
			<form  method="POST" name="sendmsg" action="send.php">
			<fieldset>
				
	<p id="suggest" >
	<label class="label10" for="ToEmp" >To  </label>
      <input type="text" value="" id="ToEmp" name="ToEmp" class="eleven" />
   </p>
   <div class="clearfix"></div>
	<p id="suggest" >
		<label class="label10" for="Subject">Subject  </label>
		<input type="text" placeholder="Subject" id="Subject" name="Subject" size="25" required="required" class="eleven"/>
	</p>
	<div class="clearfix"></div>
	
	<p>
		<label for="message" style="text-align:right;">Message  </label><br/>
		<textarea id="message" name="message" ></textarea>
		<script type="text/javascript">
				CKEDITOR.replace( 'message');
			</script>
	</p>
	<p style="text-align:center;">
		<button name="msgsubmit" type="submit" title="Send the message" class="large blue button">
		<!--<img src="../Admin/icones/email_go.png" width="24" style="vertical-align:middle;" alt="" />-->Send</button>
	</p>
				</fieldset>
			</form>
 		</div> <!--End Panel-->
	</div> <!--End 12 cols-->
</div> <!--End row-->

 <div class="row" align="center">
	<div class="twelve columns centered">
<a href="../empl_site.php#simpleContained3" title="Go back"><div class="large button red"><img src="../Admin/icones/arrow_back.png" alt="Go back" />Go back</div></a>	
 </div>
 </div>
 
 </div>
 
<div id="footer"> <?php include("../footer.php");?></div>

 
 
	<!-- Included JS Files -->
	<!--<script src="../js/jquery.min.js"></script>-->
	<script src="../js/foundation.js"></script>
	<script src="../js/app.js"></script>

</body>
</html>
