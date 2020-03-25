<?php

error_reporting(E_ALL);

class department
{
   
    // --- ATTRIBUTES ---

     //* @var String

    public $IdDept = 0;
	
	public $NameDept = null;

	public $IdLoc = null;
	

    // --- OPERATIONS ---

   function department($IdDept)
	{
	$req="Select IdDept, NameDept, IdLoc from department
			where IdDept='$IdDept' limit 0,1";
		$resultat=mysql_query($req) or die('Erreur SQL :<br />'.$req.'<br />'.mysql_error());
		if($ligne=mysql_fetch_array($resultat))
		{
		$this-> IdDept  = $ligne[0];
		$this-> NameDept  = $ligne[1];
		$this-> IdLoc = $ligne[2];
		}
	}
   
    public function AddDept($NameDept,$IdLoc)
    {
        $returnValue = false;
		
		$NameDept=addslashes($NameDept);
		$IdLoc=addslashes($IdLoc);
		
        $req="Insert into department(`NameDept`,`IdLoc`) values ('$NameDept','$IdLoc')";
			$returnValue=mysql_query($req) or die('Erreur SQL :<br />'.$req.'<br />'.mysql_error());

        return $returnValue;
    }

    public function EditDept($NameDept,$IdLoc)
    {
        $returnValue = false;

		$NameDept=addslashes($NameDept);
		$IdLoc=addslashes($IdLoc);
		
       $req="Update department set `NameDept`='$NameDept',`IdLoc`='$IdLoc'where `IdDept`='".$this->IdDept."'";
			$returnValue=mysql_query($req) or die('Erreur SQL :<br />'.$req.'<br />'.mysql_error());
			
			$this->department('$IdDept');

        return $returnValue;
    }
    
	public function DeleteDept($IdDept)
    {
        $returnValue = false;

        $req="Delete from department where `IdDept`='".$this->IdDept."'";
			$returnValue=mysql_query($req) or die('Erreur SQL :<br />'.$req.'<br />'.mysql_error());

        return $returnValue;
    }

//List
	function Listing()
	{
		$returnValue = false;
		$req="Select IdDept, NameDept, IdLoc from department ";
		$returnValue=mysql_query($req) or die('Erreur SQL :<br />'.$req.'<br />'.mysql_error());
		return $returnValue;
	}
	

	
} /* end of class department */

?>