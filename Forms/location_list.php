<?php 
// protection de page ADMIN
    include_once('../Admin/fonctions/_protectpageadm.php');
// Parametres de Connexion a la BD
	include_once('../connexion.php');   
		
	include_once("../Model/class.address.php");
	include_once("../Model/class.location.php");
	
	// pagination
$targetpage = "location_list.php"; 	
	$limit = 5; 
	
	$query = "SELECT COUNT(*) AS num FROM location";
	$total_pages = mysql_fetch_array(mysql_query($query));
	$total_pages = $total_pages["num"];
	
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

	<title>Shift-Scheduler.com | List of locations</title>
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
	<h1>LOCATIONS LISTING</h1>
<br/>
<div class="row">
	<div class="twelve columns">
		<div class="panel">
			<?php

//query: List of locations
$loc_query = "SELECT * FROM location LIMIT $start, $limit";
$loc_result = mysql_query($loc_query) or die('Erreur SQL :<br />'.$loc_query.'<br />'.mysql_error());
$loc_nombre = mysql_num_rows($loc_result);

if($loc_nombre > 0) {
?>
<h4><?php echo $loc_nombre; ?> location<?php if($loc_nombre > 1) { echo 's'; } ?></h4>
<?php
// loop for listing
while ($loc_row = mysql_fetch_array($loc_result))
{	
	$IdLoc		=	$loc_row['IdLoc'];
	$NameLoc	= 	$loc_row['NameLoc'];
	$IdAddr		= 	$loc_row['IdAddr'];

   $address = new address($IdAddr);
	$Street = $address -> Street;
	$City = $address -> City;
	$State = $address -> State;
	$ZipCode = $address -> ZipCode;
	
	
?>
	<table style="border:1px dashed #CCCCCC">
	<tbody>
		<tr>
		<td width="75%">
			<h4><?php echo $NameLoc; ?></h4>
			<p style="margin-left:50px;"><?php echo $Street; ?><br/><?php echo $City.", ".$State." ".$ZipCode; ?></p>
		</td>
		<!-- supprimer -->
	<td style="width:8%;">
	<form method="post" name="formsupprimer" action="../loc_treatment.php" onClick="return confirm('Do you really want to delete this location and all its departments?')">
	<!--<fieldset>-->
		<input type="hidden" name="traiter" value="DELETE" />
		<input type="hidden" name="IdLoc" value="<?php echo $IdLoc; ?>" />
		<button name="btSUPPRIMER" type="submit" title="Delete location" class="button">
		<img src="../Admin/icones/building_delete.png" width="24" alt="Delete" /></button> 
	<!--</fieldset>-->
	</form>
	</td>
	
	<!-- edit employee -->
	<td style="width:8%;">
	<form method="post" name="formmodifier" action="./location.php">
	<!--<fieldset>-->
		<input type="hidden" name="traiter" value="EDIT" />
		<input type="hidden" name="IdLoc" value="<?php echo $IdLoc; ?>" />
		<button name="btMODIFIER" type="submit" title="Edit location" class="button">
		<img src="../Admin/icones/building_edit.png" width="24" alt="Edit location" /></button>
	<!--</fieldset>-->
	</form>
	</td>
	
			</tr>
		</tbody>
	</table>
<?php
	}
	} // end if
	else { // no location
?>
 <div id="light" align="center">No location for now.</div><br/>
<?php
		} //End else
	

?><br/>
<p align="center"><?php echo $paginate;?></p>
<br/>
		</div> <!--End panel-->
	</div><!-- End 12 columns-->
</div><!--End row-->

		<br/>
<!-- lien retour -->
<div style="text-align:center;">
<a href="../admin_spr.php#nice5"><div class="large button red" ><img src="../Admin/icones/arrow_back.png" alt="" /> Go back</div></a>	
</div>
<br/>

</div><!-- End containercentrer-->

<div id="footer"> <?php include("../footer.php");?></div>

	<!-- Included JS Files -->
	<script src="../js/jquery.min.js"></script>
	<script src="../js/foundation.js"></script>
	<script src="../js/app.js"></script>


</body>
</html>