<?php

error_reporting(E_ALL);
//require ('class.person.php');

class admin
{
   
    // --- ATTRIBUTES ---

     //* @var String

  //  public $IdAdmin = 0;
	
	public $IdPers = 0;

	public $Login = null;
	
	public $Pwd = null;
	

    // --- OPERATIONS ---

   function admin($IdPers)
	{
	$req="Select  IdPers, Login, Pwd from admin
			where IdPers='$IdPers' limit 0,1";
		$resultat=mysql_query($req) or die('Erreur SQL :<br />'.$req.'<br />'.mysql_error());
		if($ligne=mysql_fetch_array($resultat))
		{
		//$this-> IdAdmin  = $ligne[0];
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
		
        $req="Insert into admin(`IdPers`,`Login`,`Pwd`) values ('$IdPers','$Login','$Pwd')";
			$returnValue=mysql_query($req) or die('Erreur SQL :<br />'.$req.'<br />'.mysql_error());

        return $returnValue;
    }

    public function Edit($IdPers,$Login,$Pwd)
    {
        $returnValue = false;

		$IdPers=addslashes($IdPers);
		$Login=addslashes($Login);
		$Pwd=addslashes($Pwd);
		
       $req="Update admin set `Login`='$Login', `Pwd`='$Pwd' where `IdPers`='".$this->IdPers."'";
			$returnValue=mysql_query($req) or die('Erreur SQL :<br />'.$req.'<br />'.mysql_error());
			
			$this->admin('$IdPers');

        return $returnValue;
    }
    
	public function Delete($IdPers)
    {
        $returnValue = false;

        $req="Delete from admin where `IdPers`='".$this->IdPers."'";
			$returnValue=mysql_query($req) or die('Erreur SQL :<br />'.$req.'<br />'.mysql_error());

        return $returnValue;
    }

//List
	function Listing()
	{
		$returnValue = false;
		$req="Select admin.Login, admin.Pwd, person.Idpers, person.Name from admin, person WHERE admin.IdPers = person.IdPers";
		$returnValue=mysql_query($req) or die('Erreur SQL :<br />'.$req.'<br />'.mysql_error());
		return $returnValue;
	}
	
function AuthAdmin($Login,$Pwd)
	{
	$returnValue = false;
		$Login=addslashes($Login);
		$Pwd=addslashes($Pwd);
		$req="Select * from admin
			where Login='$Login' 
			and Pwd='$Pwd' limit 0,1";
		$resultat=mysql_query($req) or die('Erreur SQL :<br />'.$req.'<br />'.mysql_error());
		if($ligne=mysql_fetch_array($resultat))
		{
		$this->IdPers=$ligne[0];
		$this->admin($this->IdPers);
		$returnValue=true;
		}
	return $returnValue;
	}	
	
} /* end of class admin */

?>