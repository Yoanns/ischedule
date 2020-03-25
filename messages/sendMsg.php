<?php
// protection de page 
  //  include_once('../Admin/fonctions/_protectpage.php');
// Parametres de Connexion a la BD
	include_once('../connexion.php');   	

if (isset($_POST["msgsubmit"]))
  {
	//$ToEmp = mysql_real_escape_string($_POST["ToEmp"]);
	$emp = $_POST["as_values_emp"];
	$array = preg_split("/[\s]*[,][\s]*/", $emp);
	//$ToEmp = array($array);
	$Subject = mysql_real_escape_string($_POST["Subject"]);
if($_POST["message"] == '')
	{
		echo"<div class='alert-box error centered' style='text-align:center;' >
							Please enter the content of the message.
						<a href='' class='close'>&times;</a>
						</div>";
	} else 
	$Message = mysql_real_escape_string($_POST["message"]);
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
	
	$array_size = count($array);
	for($i = 0; $i < $array_size-1; $i++)
		{
			 $msg_query ="INSERT INTO messages(`ToEmp`,`FromEmp`,`Subject`,`Message`,`Read`,`Deleted`,`DateSent`) VALUES ('$array[$i]','$FromEmp', '$Subject', '$Message', 0, 0,NOW())";
			 $msg_result = mysql_query($msg_query) or die('Erreur SQL :<br />'.$msg_query.'<br />'.mysql_error());
			  
	}//End for
		
 
	 if ($msg_result)
	 	{
			echo"<div class='alert-box success centered' style='text-align:center;' >
							Your message has been successfully sent.
						<a href='' class='close'>&times;</a>
						</div>";
		/*	sleep(5);
			header("location:../empl_site.php?page=1#simpleContained3");*/
		}
	else {
			echo"<div class='alert-box error centered' style='text-align:center;' >
							Oops! An error has ocurred. Please try again or contact your supervisor.
						<a href='' class='close'>&times;</a>
						</div>";
			/*sleep(5);
			header("location:../empl_site.php?page=1#simpleContained3");*/
			}
	
}
	
?>