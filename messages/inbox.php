<?php
// protection de page 
    include_once('../Admin/fonctions/_protectpage.php');
// Parametres de Connexion a la BD
	include_once('../connexion.php');   
	
	if (isset($_POST["btDEL"]))
{
	$IdMsg = 	mysql_real_escape_string($_POST['IdMsg']);
	// suppression dans la BD
	$query_delete = 	"UPDATE messages SET `Deleted` = '1' WHERE IdMsg='".$IdMsg."';";
    $result_delete = mysql_query($query_delete) or die('Erreur SQL :<br />'.$query_delete.'<br />'.mysql_error());
	if ($result_delete)
		{
			echo"<div id='container'><div class='alert-box centered success' style='text-align:center;' >
							Your message has been moved to the trash.
						<a href='' class='close'>&times;</a>
						</div></div>";
		}
	else {
		echo"<div id='container'><div class='alert-box centered error' style='text-align:center;' >
							A problem has occured. Please try again or contact your supervisor.
						<a href='' class='close'>&times;</a>
						</div></div>";
		}
}
	
	
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

	 $ToEmp = $persFirstName." ".$persLastName;
	

//pagination
$targetpage = $_SERVER["PHP_SELF"]; 	
	$limit = 15; 
	
	$query = "SELECT COUNT(*) AS num 
				FROM messages 
				WHERE  `ToEmp` = '$ToEmp' AND `Deleted` = '0' ";
	$total_pages = mysql_fetch_array(mysql_query($query));
	$total_pages = $total_pages[num];
	
	$stages = 3;
	
	if (isset($_GET['page'])) {
	$page = $_GET['page']; // On recupere le numero de la page dans l'URL
} else { // si c'est la premiere fois qu'on charge la page
	$page = 1; // On se met sur la page 1 (par defaut)
}

	if($page){
		$start = ($page - 1) * $limit; 
	}else{
		$start = 0;	
		}	
	
   // Get page data
  	 
$msg_query = "SELECT * FROM messages WHERE `ToEmp` = '$ToEmp' AND `Deleted` = '0' ORDER BY `DateSent` DESC LIMIT $start, $limit";
$msg_result = mysql_query($msg_query) or die('Erreur SQL :<br />'.$msg_query.'<br />'.mysql_error());
$nb_msg = mysql_num_rows($msg_result);
	
	// Initial page num setup
	if ($page == 0){$page = 1;}
	$prev = $page - 1;	
	$next = $page + 1;							
	$lastpage = ceil($total_pages/$limit);		
	$LastPagem1 = $lastpage - 1;					
	
	
	$paginate = '';
	if($lastpage > 1)
	{	
	
		$paginate .= "<ul class='pagination centered'>";
		// Previous
		if ($page > 1){
			$paginate.= "<li><a href='$targetpage?page=$prev'>previous</a></Li>";
		}else{
			$paginate.= "<li class='unavailable'>previous</li>";	}
			

		
		// Pages	
		if ($lastpage < 7 + ($stages * 2))	// Not enough pages to breaking it up
		{	
			for ($counter = 1; $counter <= $lastpage; $counter++)
			{
				if ($counter == $page){
					$paginate.= "<li class='current'>$counter</li>";
				}else{
					$paginate.= "<li><a href='$targetpage?page=$counter'>$counter</a></li>";}					
			}
		}
		elseif($lastpage > 5 + ($stages * 2))	// Enough pages to hide a few?
		{
			// Beginning only hide later pages
			if($page < 1 + ($stages * 2))		
			{
				for ($counter = 1; $counter < 4 + ($stages * 2); $counter++)
				{
					if ($counter == $page){
						$paginate.= "<li class='current'>$counter</li>";
					}else{
						$paginate.= "<li><a href='$targetpage?page=$counter'>$counter</a></li>";}					
				}
				$paginate.= "...";
				$paginate.= "<a href='$targetpage?page=$LastPagem1'>$LastPagem1</a>";
				$paginate.= "<a href='$targetpage?page=$lastpage'>$lastpage</a>";		
			}
			// Middle hide some front and some back
			elseif($lastpage - ($stages * 2) > $page && $page > ($stages * 2))
			{
				$paginate.= "<li><a href='$targetpage?page=1'>1</a></li>";
				$paginate.= "<li><a href='$targetpage?page=2'>2</a></li>";
				$paginate.= "...";
				for ($counter = $page - $stages; $counter <= $page + $stages; $counter++)
				{
					if ($counter == $page){
						$paginate.= "<li class='current'>$counter</li>";
					}else{
						$paginate.= "<li><a href='$targetpage?page=$counter'>$counter</a></li>";}					
				}
				$paginate.= "...";
				$paginate.= "<li><a href='$targetpage?page=$LastPagem1'>$LastPagem1</a></li>";
				$paginate.= "<li><a href='$targetpage?page=$lastpage'>$lastpage</a></li>";		
			}
			// End only hide early pages
			else
			{
				$paginate.= "<li><a href='$targetpage?page=1'>1</a></li>";
				$paginate.= "<li><a href='$targetpage?page=2'>2</a></li>";
				$paginate.= "...";
				for ($counter = $lastpage - (2 + ($stages * 2)); $counter <= $lastpage; $counter++)
				{
					if ($counter == $page){
						$paginate.= "<li class='current'>$counter</li>";
					}else{
						$paginate.= "<li><a href='$targetpage?page=$counter'>$counter</a></li>";}					
				}
			}
		}
					
				// Next
		if ($page < $counter - 1){ 
			$paginate.= "<li><a href='$targetpage?page=$next'>next</a></li>";
		}else{
			$paginate.= "<li class='unavailable'>next</li>";
			}
			
		$paginate.= "</ul>";		
	
	
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

	<title>Shift-Scheduler.com | Inbox</title>
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
<h4 style="text-align:center;">Inbox</h4>
<div style="text-align:center;">

<?php 
	 echo $total_pages.' message'; 
	 if($total_pages>1) { echo 's'; }
	 
	  // pagination
 echo $paginate;

?>
	</div>
<br />
<div class="row">
	<div class="twelve centered columns">
		<div class="panel">
			<table>
				<tr>
					<td></td>
					<td></td>
					<th>From</th>
					<th width="50%" style="text-align:left;">Subject</th>
					<th>Date</th>
				</tr>
				
				<?php
 		if ($nb_msg !=0)
			{
				while($msg_row = mysql_fetch_array($msg_result)) 
					{
						$IdMsg = $msg_row["IdMsg"];
						$FromEmp = stripslashes($msg_row["FromEmp"]);
        				$Subject = stripslashes($msg_row["Subject"]);
						$Read = stripslashes($msg_row["Read"]);
        				$SentDate = stripslashes($msg_row["DateSent"]);
						$Date = strtotime($SentDate);
						$DateSent = date("M d, Y @ g:i A",$Date);
						
						if($Read == 0) 
							{
    						 	$status = "../Admin/icones/email.png";    
							}
						else 
							{
								$status = "../Admin/icones/email_open.png";
							}
							?>

        				<tr>
							<td><form method="post" name="formsupprimer" action="inbox.php" onClick="return confirm('Do you really want to put this message in the trash?')">
		<input type="hidden" name="IdMsg" value="<?php echo $IdMsg; ?>" />		
		<button name="btDEL" type="submit" title="Put message in trash" class="button"><img src="../Admin/icones/mail-trash.png" width="24" alt="Trash message" /></button>
	</form></td>
							<td><img src="<?php echo $status;?>" /></td>							
							<td><?php echo $FromEmp;?></td>
							<td style="text-align:left;"><a href="view.php?IdMsg=<?php echo $IdMsg;?>"><?php echo $Subject;?></a></td>
							<td><?php echo $DateSent;?></td>
							
						</tr>
					<?php
					} //End while
			} else 
				{ ?>
					<tr>
						<td colspan="5" style="text-align:center;"> You do not have any message.</td>
					</tr>					
					<?php 
				}
				?>
					
			</table>	<br/>	
		</div> <!--End Panel-->
	</div> <!--End 12 cols-->
</div> <!--End row-->
<br/>
<?php echo $paginate;?>
<br/>

<div class="row" align="center">
	<div class="twelve columns centered">
<a href="../empl_site.php#simpleContained3" title="Go back"><div class="large button red"><img src="../Admin/icones/arrow_back.png" alt="Go back" />Go back</div></a>	
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