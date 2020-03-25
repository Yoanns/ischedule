<?php

error_reporting(E_ALL);

class location
{
   
    // --- ATTRIBUTES ---

     //* @var String

    public $IdLoc = 0;
	
	public $NameLoc = null;

	public $IdAddr = null;
	

    // --- OPERATIONS ---

   function location($IdLoc)
	{
	$req="Select IdLoc, NameLoc, IdAddr from location
			where IdLoc='$IdLoc' limit 0,1";
		$resultat=mysql_query($req) or die('Erreur SQL :<br />'.$req.'<br />'.mysql_error());
		if($ligne=mysql_fetch_array($resultat))
		{
		$this-> IdLoc  = $ligne[0];
		$this-> NameLoc  = $ligne[1];
		$this-> IdAddr = $ligne[2];
		}
	}
   
    public function AddLoc($NameLoc,$IdAddr)
    {
        $returnValue = false;
		
		$NameLoc=addslashes($NameLoc);
		$IdAddr=addslashes($IdAddr);
		
        $req="Insert into location(`NameLoc`,`IdAddr`) values ('$NameLoc','$IdAddr')";
			$returnValue=mysql_query($req) or die('Erreur SQL :<br />'.$req.'<br />'.mysql_error());

        return $returnValue;
    }

    public function EditLoc($NameLoc,$IdAddr)
    {
        $returnValue = false;

		$NameLoc=addslashes($NameLoc);
		$IdAddr=addslashes($IdAddr);
		
       $req="Update location set `NameLoc`='$NameLoc',`IdAddr`='$IdAddr' where `IdLoc`='".$this->IdLoc."'";
			$returnValue=mysql_query($req) or die('Erreur SQL :<br />'.$req.'<br />'.mysql_error());
			
			$this->location('$IdLoc');

        return $returnValue;
    }
    
	public function DeleteLoc($IdLoc)
    {
        $returnValue = false;

        $req="Delete from location where `IdLoc`='".$this->IdLoc."'";
			$returnValue=mysql_query($req) or die('Erreur SQL :<br />'.$req.'<br />'.mysql_error());

        return $returnValue;
    }

//List
	function Listing()
	{
		$returnValue = false;
		$req="Select IdLoc, NameLoc, IdAddr from location ";
		$returnValue=mysql_query($req) or die('Erreur SQL :<br />'.$req.'<br />'.mysql_error());
		return $returnValue;
	}
	

	
} /* end of class location */

?>