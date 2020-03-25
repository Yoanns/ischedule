<?php

error_reporting(E_ALL);
//require ('class.person.php');

class employee
{
   
    // --- ATTRIBUTES ---

     //* @var String

   // public $IdEmp = 0;
	
	public $IdPers = 0;

	public $Login = null;
	
	public $Pwd = null;
	

    // --- OPERATIONS ---

   function employee($IdPers)
	{
	$req="Select IdPers, Login, Pwd from `employee`
			where IdPers='$IdPers' limit 0,1";
		$resultat=mysql_query($req) or die('Erreur SQL :<br />'.$req.'<br />'.mysql_error());
		if($ligne=mysql_fetch_array($resultat))
		{
		//$this-> IdEmp  = $ligne[0];
		$this-> IdPers  = $ligne[0];
		$this-> Login = $ligne[1];
		$this-> Pwd = $ligne[2];		
		}
	}
   
    public function Add($IdPers,$Login,$Pwd)
    {
        $returnValue = false;
		
		$IdPers=addslashes($IdPers);
		$Login=addslashes($Login);
		$Pwd=addslashes($Pwd);
		
        $req="Insert into `employee` (`IdPers`,`Login`,`Pwd`) values ('$IdPers','$Login','$Pwd')";
			$returnValue=mysql_query($req) or die('Erreur SQL :<br />'.$req.'<br />'.mysql_error());

        return $returnValue;
    }

    public function Edit($IdPers,$Login,$Pwd)
    {
        $returnValue = false;

		$IdPers=addslashes($IdPers);
		$Login=addslashes($Login);
		$Pwd=addslashes($Pwd);
		
       $req="Update `employee` set `Login`='$Login', `Pwd`='$Pwd' where `IdPers`='".$this->IdPers."'";
			$returnValue=mysql_query($req) or die('Erreur SQL :<br />'.$req.'<br />'.mysql_error());
			
			$this->employee('$IdPers');

        return $returnValue;
    }
    
	public function Delete($IdPers)
    {
        $returnValue = false;

        $req="Delete from `employee` where `IdPers`='".$this->IdPers."'";
			$returnValue=mysql_query($req) or die('Erreur SQL :<br />'.$req.'<br />'.mysql_error());

        return $returnValue;
    }

//List
	function Listing()
	{
		$returnValue = false;
		$req="Select employee.Login, employee.Pwd, person.Idpers, person.Name from `employee`, `person` WHERE employee.IdPers = person.IdPers";
		$returnValue=mysql_query($req) or die('Erreur SQL :<br />'.$req.'<br />'.mysql_error());
		return $returnValue;
	}
	
function AuthEmp($Login,$Pwd)
	{
	$returnValue = false;
		$Login=addslashes($Login);
		$Pwd=addslashes($Pwd);
		$req="Select * from employee
			where Login='$Login' 
			and Pwd='$Pwd' limit 0,1";
		$resultat=mysql_query($req) or die('Erreur SQL :<br />'.$req.'<br />'.mysql_error());
		if($ligne=mysql_fetch_array($resultat))
		{
		$this->IdPers=$ligne[0];
		$this->employee($this->IdPers);
		$returnValue=true;
		}
	return $returnValue;
	}	
	
} /* end of class employee */

?>