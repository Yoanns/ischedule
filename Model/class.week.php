<?php

error_reporting(E_ALL);

class week
{
   
    // --- ATTRIBUTES ---

     //* @var String

    public $IdWk = null;

	public $BegWk = null;
	
	public $EndWk = null;
	

    // --- OPERATIONS ---

   function week($IdWk)
	{
	$req="Select IdWk, BegWk, EndWk from week
			where IdWk='$IdWk' limit 0,1";
		$resultat=mysql_query($req) or die('Erreur SQL :<br />'.$req.'<br />'.mysql_error());
		if($ligne=mysql_fetch_array($resultat))
		{
		$this-> IdWk  = $ligne[0];
		$this-> BegWk = $ligne[1];
		$this-> EndWk = $ligne[2];
		
		}

	}
   
    public function AddWk($BegWk,$EndWk)
    {
        $returnValue = false;
		
		//$IdWk=addslashes($IdWk);
		$BegWk=addslashes($BegWk);
		$EndWk=addslashes($EndWk);
		
        $req="Insert into week(`BegWk`,`EndWk`) values ('$BegWk','$EndWk')";
			$returnValue=mysql_query($req) or die('Erreur SQL :<br />'.$req.'<br />'.mysql_error());

        return $returnValue;
    }


    public function EditWk($BegWk,$EndWk)
    {
        $returnValue = false;

		//$IdWk=addslashes($IdWk);
		$BegWk=addslashes($BegWk);
		$EndWk=addslashes($EndWk);
		
       $req="Update week set `IdWk`='$IdWk',`BegWk`='$BegWk', `EndWk`='$EndWk' where `IdWk`='".$this->IdWk."'";
			$returnValue=mysql_query($req) or die('Erreur SQL :<br />'.$req.'<br />'.mysql_error());
			
			$this->week('$IdWk');

        return $returnValue;
    }

    
	public function Delete()
    {
        $returnValue = false;

        $req="Delete from week where `$IdWk`='".$this->$IdWk."'";
			$returnValue=mysql_query($req) or die('Erreur SQL :<br />'.$req.'<br />'.mysql_error());

        return $returnValue;
    }

//Liste
	function Listing()
	{
		$returnValue = false;
		$req="Select * from week";
		$returnValue=mysql_query($req) or die('Erreur SQL :<br />'.$req.'<br />'.mysql_error());
		return $returnValue;
	}
		
	
} /* end of class week */

?>