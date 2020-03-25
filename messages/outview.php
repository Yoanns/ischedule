<?php
// protection de page 
    include_once('../Admin/fonctions/_protectpage.php');
// Parametres de Connexion a la BD
	include_once('../connexion.php');   
	
	if(isset($_SESSION["IdEmp"]))
		$persID = $_SESSION["IdEmp"];
	else
		$persID = $_SESSION["IdAdmin"];
	$pers_query = 	"SELECT * FROM person WHERE IdPers = '".$persID."'; ";
	$pers_result = 	mysql_query($pers_query);
while ($pers_row = mysql_fetch_array($pers_result))
{
	//$persID 		= 	psu_id($pers_row['IdPers']);
	$persFirstName	= 	stripslashes($pers_row['FirstName']);
	$persLastName	= 	stripslashes($pers_row['LastName']);
       }
	 $FromEmp = $persFirstName." ".$persLastName;
	   
	$IdMsg = @$_GET['IdMsg'];
        if(!isset($IdMsg)) {
           header('location: outbox.php');
        }
        elseif(isset($IdMsg)) {
 
                $msg_query ="SELECT * FROM messages WHERE FromEmp = '$FromEmp' AND `IdMsg` = '$IdMsg'";
				$msg_result = mysql_query($msg_query) or die('Erreur SQL :<br />'.$msg_query.'<br />'.mysql_error());
				

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

	<title>Shift-Scheduler.com | Outbox</title>
	<link rel="shortcut icon" type="image/x-icon" href="../Admin/icones/ischedule_logo1.ico">
  
	<!-- Included CSS Files -->
	<link rel="stylesheet" href="../css/foundation.css">
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
</head>

<body>
<div id="containercentrer">
<h4 style="text-align:center;">Outbox</h4>
<div class="row">
	<div class="twelve centered columns">
		<div class="panel">
<?php
 
            while($msg_row= mysql_fetch_array($msg_result)) 
				{               
                        if($msg_row["Read"] == 0) 
							{ 
								$update = "UPDATE messages SET `Read` ='1' WHERE `IdMsg` ='$IdMsg' LIMIT 1";
								$result = mysql_query($update) or die('Erreur SQL :<br />'.$update.'<br />'.mysql_error());
							}
						
						$Subject = stripslashes($msg_row["Subject"]);
                        $Message = stripslashes($msg_row["Message"]);
                        $Message = nl2br($Message);
						$FromEmp = stripslashes($msg_row["FromEmp"]);
        				$SentDate = stripslashes($msg_row["DateSent"]);
						$Date = strtotime($SentDate);
						$DateSent = date("M d, Y @ g:i A",$Date);
                    ?>   
                                      
                   <h4><?php echo $Subject;?></h4>
                  <p><strong>From: </strong><?php echo $FromEmp ;?> </p>
				  <p><strong>Sent on:</strong> <?php echo $DateSent ;?></p>
                  <div style="text-align:left; margin:0px 10px 5px 3px; padding:10px; border: 2px dashed #CCCCCC; background-color: #FFFFFF;">
				  	<p><?php echo $Message;?></p>
				  </div>
               
             <?php   
                }
 ?><br/>
 		</div> <!--End Panel-->
	</div> <!--End 12 cols-->
</div> <!--End row-->
<br/>
 <div class="row" align="center">
	<div class="twelve columns centered">
<a href="outbox.php" title="Go back"><div class="large button red"><img src="../Admin/icones/arrow_back.png" alt="Go back" />Go back</div></a>	
 </div>
 </div>
 
 </div>
 
<div id="footer"> <?php include("../footer.php");?></div>


	<!-- Included JS Files -->
	<script src="../js/jquery.min.js"></script>
	<script src="../js/foundation.js"></script>
	<script src="../js/app.js"></script>

</body>
</html>
 
 <?php
        }
		?>