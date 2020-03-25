<?php
// protection de page ADMIN
   include_once('../Admin/fonctions/_protectpageadm.php');
// **************************************
// Parametres de Connexion a la BD
	include_once('../connexion.php');
// Parametres de CONFIGURATION de Employees
	include_once('../Admin/fonctions/config.php');
// **************************************
// Fonctions de traitement d image
	include_once('../Admin/fonctions/fct_traitement_image.php');
// **************************************	
	include_once('../Model/class.address.php'); 
	include_once('../Model/class.location.php'); 

$traiter = '';
if (isset($_POST['traiter']) && ($_POST['traiter']=='ADD' || $_POST['traiter']=='EDIT')){
	$traiter = $_POST['traiter'];
} else {
	// sinon retour a la liste
	header('location: ../admin_spr.php#nice5');
	exit;
}



$state_values=array(
                'AL'=>"Alabama",
                'AK'=>"Alaska",  
                'AZ'=>"Arizona",  
                'AR'=>"Arkansas",  
                'CA'=>"California",  
                'CO'=>"Colorado",  
                'CT'=>"Connecticut",  
                'DE'=>"Delaware",  
                'DC'=>"District Of Columbia",  
                'FL'=>"Florida",  
                'GA'=>"Georgia",  
                'HI'=>"Hawaii",  
                'ID'=>"Idaho",  
                'IL'=>"Illinois",  
                'IN'=>"Indiana",  
                'IA'=>"Iowa",  
                'KS'=>"Kansas",  
                'KY'=>"Kentucky",  
                'LA'=>"Louisiana",  
                'ME'=>"Maine",  
                'MD'=>"Maryland",  
                'MA'=>"Massachusetts",  
                'MI'=>"Michigan",  
                'MN'=>"Minnesota",  
                'MS'=>"Mississippi",  
                'MO'=>"Missouri",  
                'MT'=>"Montana",
                'NE'=>"Nebraska",
                'NV'=>"Nevada",
                'NH'=>"New Hampshire",
                'NJ'=>"New Jersey",
                'NM'=>"New Mexico",
                'NY'=>"New York",
                'NC'=>"North Carolina",
                'ND'=>"North Dakota",
                'OH'=>"Ohio",  
                'OK'=>"Oklahoma",  
                'OR'=>"Oregon",  
                'PA'=>"Pennsylvania",  
                'RI'=>"Rhode Island",  
                'SC'=>"South Carolina",  
                'SD'=>"South Dakota",
                'TN'=>"Tennessee",  
                'TX'=>"Texas",  
                'UT'=>"Utah",  
                'VT'=>"Vermont",  
                'VA'=>"Virginia",  
                'WA'=>"Washington",  
                'WV'=>"West Virginia",  
                'WI'=>"Wisconsin",  
                'WY'=>"Wyoming"
    );
	
function listUSStates($state_values,$dropdown_name,$key_selected) { 

    $string="<select name=\"".$dropdown_name."\" required=\"required\">\n"; 
    if (!empty($state_values)) { 
        if ($key_selected=="" || !isset($key_selected)) { 
            $string.="<option value=\"\">Please select</option>\n"; 
        } 
        foreach($state_values as $state_short=>$state_full) { 
            if ($key_selected!="" && $key_selected==$state_short) { 
                $additional=" SELECTED"; 
            } 
            else { 
                $additional=""; 
            } 
                $string.="<option value=\"".$state_short."\"".$additional.">".$state_full."</option>\n"; 
        } 
    } 
    $string.="</select>\n"; 
    return $string; 
}

// -------------------------
// ADD a location
// -------------------------
if ($traiter == 'ADD')
{
	$IdLoc		=	"";
	$NameLoc	=	"";
	
	$Street		=	"";
	$City		=	"";
	$State		=	"";
	$ZipCode	=	"";
}

// -------------------------
// EDIT a location
// -------------------------
elseif ($traiter == 'EDIT')
{
	$IdLoc	=	mysql_real_escape_string($_POST['IdLoc']);
	$location = new location($IdLoc);
	$IdLoc		=	$location -> IdLoc;
	$NameLoc	=	$location -> NameLoc;
	$IdAddr		=	$location -> IdAddr;
	
	$address = new address($IdAddr);
	$Street = $address -> Street;
	$City = $address -> City;
	$State = $address -> State;
	$ZipCode = $address -> ZipCode;
	
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

	<title>Shift-Scheduler.com | <?php echo $traiter; ?> A LOCATION</title>
	<link rel="shortcut icon" type="image/x-icon" href="../Admin/icones/ischedule_logo1.ico">
	
	<!-- Included CSS Files -->
	<link rel="stylesheet" href="../css/foundation_style.css">
	<link rel="stylesheet" href="../css/app.css">
	<link rel="stylesheet" media="screen" type="text/css" href="../Admin/css_adm/news_ADM_style.css" />

	<!--[if lt IE 9]>
		<link rel="stylesheet" href="../css/ie.css">
	<![endif]-->
	
	<script src="../js/jquery.min.js"></script>	
	<script src="../js/modernizr.foundation.js"></script>

	<!-- IE Fix for HTML5 Tags -->
	<!--[if lt IE 9]>
		<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
	

<script type="text/javascript">
$(document).ready(function() {  	
	$("#Zip").keydown(function(event) {
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
	$("#Zip").bind("contextmenu",function(e){
	        return false;
	    });
});

</script>
    
	
</head>

<body>
<div id="containercentrer">
<br/>
<h1><?php echo $traiter; ?> A LOCATION</h1><br/>
	<div class="row">
		<div class="nine centered columns">
			<div class="panel">
	
						<div id="signup" class="ten centered">
								<form id="myForm" method="post" enctype="multipart/form-data" action="../loc_treatment.php">
								<fieldset>
									<input type='hidden' name="traiter" value="<?php echo $traiter;?>" />
									<input type='hidden' name="IdLoc" value="<?php echo $IdLoc;?>" />
									<label>Name</label>
									<input type="text" id="NameLoc" name="NameLoc" value="<?php echo $NameLoc;?>" placeholder="Location name" required="required"/>
									
									
		
									<label>Address</label>
  									<input type="text" id="Street" name="Street" value="<?php echo $Street;?>" placeholder="Street (e.g. 123 Terrific St.)" required="required" />
  									
									<div class="row">
    									
										<div class="six columns">
      										<input type="text" id="City" name="City" value="<?php echo $City;?>" placeholder="City" required="required" />
										</div>
    									
										<div class="three columns">
      										<?php
											$select_box_name = "State";
											$key_selected = $State;
											
											if (isset($_POST['addCust']))
												$key_selected = $_POST[$select_box_name];
											echo listUSStates($state_values,$select_box_name,$key_selected);
											?>
											
											<!--<input type="text" placeholder="State" />-->
   				 						</div>
   										
										<div class="three columns">
      										<input type="text" id="Zip" name="Zip" value="<?php echo $ZipCode;?>" placeholder="ZIP" maxlength="5"  required="required" />
    									</div>
  									</div> 
									
									
									<br/>
									<div class="row">
	<div class="six centered columns">
		<p style="text-align:center;">            
         		<button name="addloc" type="submit" value="<?php echo $traiter; ?>" class="large button green"><!--<img src="../Admin/icones/<?php echo $traiter; ?>.png" alt="" />--><?php echo $traiter; ?> location </button>	
		</p>
	</div> <!--End 6 cols-->
	
</div>	<!--End row-->							
									<br/><br/>
									</fieldset>
								</form>
							</div>
				</div> <!--End panel-->
		</div><!-- End 9 columns-->
	</div>	<!--End row-->	


 <div class="row">
	<div class="twelve columns centered" align="center">
		<a href="../admin_spr.php#nice5" title="Go back"><div class="large button red" ><img src="../Admin/icones/arrow_back.png" alt="" /> Go back</div></a>	
 	</div>
 </div>

<br/>
</div> <!--End containercentrer-->


<div id="footer"> <?php include("../footer.php");?></div>


	<!-- Included JS Files -->
	<script src="../js/foundation.js"></script>
	<script src="../js/app.js"></script>

</body>
</html>
