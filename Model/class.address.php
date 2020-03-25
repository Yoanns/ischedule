<?php

error_reporting(E_ALL);

class address
{
   
    // --- ATTRIBUTES ---

     //* @var String

    public $IdAddr = null;
	
	public $Street = null;

	public $City = null;
	
	public $State = null;
	
	public $ZipCode = null;
	

    // --- OPERATIONS ---

   function address($IdAddr)
	{
	$req="Select IdAddr, Street, City, State, ZipCode from address
			where IdAddr='$IdAddr' limit 0,1";
		$resultat=mysql_query($req) or die(mysql_error());
		if($ligne=mysql_fetch_array($resultat))
		{
		$this-> IdAddr  = $ligne[0];
		$this-> Street  = $ligne[1];
		$this-> City = $ligne[2];
		$this-> State = $ligne[3];	
		$this-> ZipCode = $ligne[4];		
		}
	}
   
    public function Add($Street,$City,$State,$ZipCode)
    {
        $returnValue = false;
		
		$Street=addslashes($Street);
		$City=addslashes($City);
		$State=addslashes($State);
		$ZipCode=addslashes($ZipCode);
		
        $req="Insert into address(`Street`,`City`,`State`,`ZipCode`) values ('$Street','$City','$State','$ZipCode')";
			$returnValue=mysql_query($req) or die(mysql_error());

        return $returnValue;
    }

    public function Edit($Street,$City,$State,$ZipCode)
    {
        $returnValue = false;

		$Street=addslashes($Street);
		$City=addslashes($City);
		$State=addslashes($State);
		$ZipCode=addslashes($ZipCode);
		
       $req="Update address set `Street`='$Street',`City`='$City', `State`='$State', `ZipCode`='$ZipCode' where `IdAddr`='".$this->IdAddr."'";
			$returnValue=mysql_query($req) or die(mysql_error());
			
			$this->address('$IdAddr');

        return $returnValue;
    }
    
	public function Delete($IdAddr)
    {
        $returnValue = false;

        $req="Delete from address where `IdAddr`='".$this->IdAddr."'";
			$returnValue=mysql_query($req) or die(mysql_error());

        return $returnValue;
    }

//List
	function Listing()
	{
		$returnValue = false;
		$req="Select * from address";
		$returnValue=mysql_query($req) or die(mysql_error());
		return $returnValue;
	}
	
	
} /* end of class address */

?>