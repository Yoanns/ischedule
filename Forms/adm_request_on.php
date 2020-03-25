<?php
// protection de page ADMIN
    include_once('../Admin/fonctions/_protectpage.php');
// ***************************************************************
// LISTING des NEWS (avec r�sum� du contenu)
// ***************************************************************
// Parametres de Connexion a la BD
	include_once('../connexion.php');
	
	include_once('../Model/class.person.php');
// -------------------------
// ***************************************************************
// CONFIGURATION des PARAMETRES du LISTING des NEWS avec RESUME
// ***************************************************************

// Accept a request
if (isset($_POST['btAccept']))
	{
		$DayReq = mysql_real_escape_string($_POST['DayReq']);
		$persReq = mysql_real_escape_string($_POST['persReq']);
		
		$query_update = "UPDATE request SET `Status`='APPROVED' WHERE DayReq = '$DayReq' AND IdPers = '$persReq'";
		$result_query = mysql_query($query_update) or die('Erreur SQL :<br />'.$query_update.'<br />'.mysql_error());
		if ($result_query)
			{ ?>
				<div class="container">
					<div class="alert-box success centered" style="text-align:center;">
						The request has been approved.
						<a href="" class="close">&times;</a>
					</div>
				</div>
		<?php }
		else { ?>
				<div class="container">
					<div class="alert-box error centered" style="text-align:center;">
						Sorry! Impossible to changed the status of this request. Please contact the system administrator.
						<a href="" class="close">&times;</a>
					</div>
				</div>
		<?php }
		
	}	
	 

// Decline a request
if (isset($_POST['btDeny']))
	{
		$DayReq = mysql_real_escape_string($_POST['DayReq']);
		$persReq = mysql_real_escape_string($_POST['persReq']);
		
		$query_update = "UPDATE request SET `Status`='DECLINED' WHERE DayReq = '$DayReq' AND IdPers = '$persReq'";
		$result_query = mysql_query($query_update) or die('Erreur SQL :<br />'.$query_update.'<br />'.mysql_error());
		if ($result_query)
			{ ?>
				<div class="containercentrer">
					<div class="alert-box success centered" style="text-align:center;">
						The request has been declined.
						<a href="" class="close">&times;</a>
					</div>
				</div>
		<?php }
		else { ?>
				<div class="containercentrer">
					<div class="alert-box error centered" style="text-align:center;">
						Sorry! Impossible to changed the status of this request. Please contact the system administrator.
						<a href="" class="close">&times;</a>
					</div>
				</div>
		<?php }
		
	}	
		 
//Pagination
$targetpage = $_SERVER["PHP_SELF"]; 	
	$limit = 15; 
	
	$query = "SELECT COUNT(*) AS num 
				FROM request 
				WHERE TypeReq = 'DAY-ON'
				 AND Status = 'PENDING' ";
	$total_pages = mysql_fetch_array(mysql_query($query));
	$total_pages = $total_pages['num'];
	
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
	$req_query = "SELECT P.IdPers, R.TypeReq, R.DayReq, R.BegReq, R.EndReq, R.Reason, R.TimeReqSub, R.Status
					 FROM request R, person P 
					 WHERE R.TypeReq = 'DAY-ON'
					 AND R.Status = 'PENDING'
					AND R.IdPers = P.IdPers
					ORDER BY TimeReqSub ASC LIMIT $start, $limit";
					
	$req_result = mysql_query($req_query) or die('Erreur SQL :<br />'.$req_query.'<br />'.mysql_error());
	
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

	<title>Shift-Scheduler.com | Requests-on</title>
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
<div id="containercentrer" align="center">
<div class="row">
	<div class="twelve columns centered">
		<div class="panel">
<h4 style="text-align:center">List of requests for time-on</h4>
<br />

<div class="centered" align="center">

<?php 
	 echo $total_pages.' Request'; 
	 if($total_pages>1) { echo 's'; }
	 
	  // pagination
 echo $paginate;

?>
	</div>
<br />

<table style="border:thin #999999 solid; " width="90%">
	<tr style="width:90%">
		<th style="border:thin dotted #666666; padding:5px;">Day(s) requested</th>
		<th style="border:thin dotted #666666; padding:5px;">Requested by</th>
		<th style="border:thin dotted #666666; padding:5px;">Start of request</th>
		<th style="border:thin dotted #666666; padding:5px;">End of request</th>
		<th style="border:thin dotted #666666; padding:5px;">Request submitted on</th>
		<th style="border:thin dotted #666666; padding:5px;">Status</th>
		<td style="border:none; padding:5px;"></td>
		<td style="border:none; padding:5px;"></td>
	</tr>
<?php
	$nbReq = mysql_num_rows($req_result);
if ($nbReq > 0)
	{	
	while ($req_row = mysql_fetch_array($req_result))
		{
				$DayReq = stripslashes($req_row['DayReq']);
				$persReq = stripslashes($req_row['IdPers']);
				$BegReq = stripslashes($req_row['BegReq']);
				$EndReq = stripslashes($req_row['EndReq']);
				$SubtOn = stripslashes($req_row['TimeReqSub']);
				$Status = stripslashes($req_row['Status']);
				$Reason = stripslashes($req_row['Reason']);
				
				$time = strtotime($SubtOn);
				$Subt = date('M d, Y @ h:i:s A',$time);
				
				$modalID = date('M_d_Y_h_i_s_A',$time);
				
				$person = new person($persReq);
				$persName = $person -> FirstName." ".$person -> LastName;
		
?>
	<tr>
		<td style="border:thin dotted #666666; padding:5px;"><a href="" data-reveal-id="myModal<?php  echo $modalID; ?>" data-animation="fadeAndPop" data-animationspeed="300" data-closeonbackgroundclick="true" data-dismissmodalclass="close-reveal-modal"><?php echo $DayReq;?></a> </td>
		<td style="border:thin dotted #666666; padding:5px;"><?php echo $persName;?></td>
		<td style="border:thin dotted #666666; padding:5px;"><?php echo $BegReq;?></td>
		<td style="border:thin dotted #666666; padding:5px;"><?php echo $EndReq;?></td>
		<td style="border:thin dotted #666666; padding:5px;"><?php echo $Subt;?></td>
		<td style="border:thin dotted #666666; padding:5px;"><b><?php echo $Status ; ?></b></td>
	<?php
if ($Status  == 'PENDING')
	{ ?>
		<td style=" border:none; padding:5px;" width="6%">
			<div>
						<form method="post" name="formedit" action="adm_request_on.php">
								<input type="hidden" name="DayReq" value="<?php  echo $DayReq; ?>" />
								<input type="hidden" name="persReq" value="<?php  echo $persReq; ?>" />
								<button name="btAccept" type="submit" title="Accept request" class="green button">
									<img src="../Admin/icones/accept.png" alt="Accept request" width="24" /></button>
						</form>
				</div>
		</td>
		<td style=" border:none; padding:5px;" width="6%">
			<div>
						<form method="post" name="formedit" action="adm_request_on.php">
								<input type="hidden" name="DayReq" value="<?php  echo $DayReq; ?>" />
								<input type="hidden" name="persReq" value="<?php  echo $persReq; ?>" />
								<button name="btDeny" type="submit" title="Decline request" class="red button">
									<img src="../Admin/icones/deny.png" alt="Decline request" width="24" /></button>
						</form>
				</div>
		</td>
	<?php
	}	
	?>
	</tr>
	
	<div id="myModal<?php  echo $modalID; ?>" class="reveal-modal">
     <h2>Reason of the request</h2>
     <p class="lead">Requested by <?php echo $persName; ?></p>
 <?php if ($Reason !=  '') { ?>
	 <p><?php echo $Reason; ?></p>
	 <?php }
	 else { ?>
	  <p>No description for this request.</p>
	  <?php } ?>
     <a class="close-reveal-modal">&#215;</a>
</div>
				
	<br />
<?php
		} // (fin du while)
	} // End if
	else {
						?>
								<tr>
									<td colspan="8"> <div align="center">No request saved.</div></td>
								</tr>
						<?php
						}
mysql_free_result($req_result);
?>
</table>
<br />

	<div class="centered" align="center">
<?php
 // pagination
 echo $paginate;
 ?>
 </div>
 
 <div class="clearfix"></div>
 
  <div class="row">
	<div class="twelve columns centered">
		<a href="../admin.php#nice3" title="Go back"><div class="large button red" ><img src="../Admin/icones/arrow_back.png" alt="" /> Go back</div></a>	
 	</div>
 </div>

<br/>
</div> <!--End panel-->
</div> <!--End 12 cols-->
</div> <!--End row-->
</div>
	
<div id="footer"> <?php include("../footer.php");?></div>

	
<!-- Included JS Files -->
	<script src="../js/jquery.min.js"></script>
	<script src="../js/foundation.js"></script>
	<script src="../js/app.js"></script>

</body>
</html>