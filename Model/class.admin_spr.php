<?php

error_reporting(E_ALL);
//require ('class.person.php');

class admin_spr
{
   
    // --- ATTRIBUTES ---

     //* @var String

  //  public $IdAdmin = 0;
	
	public $IdPers = 0;

	public $Login = null;
	
	public $Pwd = null;
	

    // --- OPERATIONS ---

   function admin_spr($IdPers)
	{
	$req="Select  IdPers, Login, Pwd from admin_spr
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
		
        $req="Insert into admin_spr(`IdPers`,`Login`,`Pwd`) values ('$IdPers','$Login','$Pwd')";
			$returnValue=mysql_query($req) or die('Erreur SQL :<br />'.$req.'<br />'.mysql_error());

        return $returnValue;
    }

    public function Edit($IdPers,$Login,$Pwd)
    {
        $returnValue = false;

		$IdPers=addslashes($IdPers);
		$Login=addslashes($Login);
		$Pwd=addslashes($Pwd);
		
       $req="Update admin_spr set `Login`='$Login', `Pwd`='$Pwd' where `IdPers`='".$this->IdPers."'";
			$returnValue=mysql_query($req) or die('Erreur SQL :<br />'.$req.'<br />'.mysql_error());
			
			$this->admin_spr('$IdPers');

        return $returnValue;
    }
    
	public function Delete($IdPers)
    {
        $returnValue = false;

        $req="Delete from admin_spr where `IdPers`='".$this->IdPers."'";
			$returnValue=mysql_query($req) or die('Erreur SQL :<br />'.$req.'<br />'.mysql_error());

        return $returnValue;
    }

//List
	function Listing()
	{
		$returnValue = false;
		$req="Select admin_spr.Login, admin_spr.Pwd, person.Idpers, person.Name from admin_spr, person WHERE admin_spr.IdPers = person.IdPers";
		$returnValue=mysql_query($req) or die('Erreur SQL :<br />'.$req.'<br />'.mysql_error());
		return $returnValue;
	}
	
function AuthAdminSpr($Login,$Pwd)
	{
	$returnValue = false;
		$Login=addslashes($Login);
		$Pwd=addslashes($Pwd);
		$req="Select * from admin_spr
			where Login='$Login' 
			and Pwd='$Pwd' limit 0,1";
		$resultat=mysql_query($req) or die('Erreur SQL :<br />'.$req.'<br />'.mysql_error());
		if($ligne=mysql_fetch_array($resultat))
		{
		$this->IdPers=$ligne[0];
		$this->admin_spr($this->IdPers);
		$returnValue=true;
		}
	return $returnValue;
	}	
	
} /* end of class admin_spr */

?>