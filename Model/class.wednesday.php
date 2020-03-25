<?php

error_reporting(E_ALL);
//require ('class.person.php');

class wednesday
{
   
    // --- ATTRIBUTES ---

     //* @var String

    public $IdWed = 0;
	
	public $IdPers = 0;

	public $BegWed = null;
	
	public $EndWed = null;
	

    // --- OPERATIONS ---

   function wednesday($IdPers)
	{
	$req="SELECT IdWed, IdPers, BegWed, EndWed FROM wednesday
			WHERE IdPers='$IdPers' limit 0,1";
		$resultat=mysql_query($req) or die('Erreur SQL :<br />'.$req.'<br />'.mysql_error());
		if($ligne=mysql_fetch_array($resultat))
		{
		$this-> IdWed  = $ligne[0];
		$this-> IdPers  = $ligne[1];
		$this-> BegWed = $ligne[2];
		$this-> EndWed = $ligne[3];		
		}
	}
   
    public function Add($IdPers,$BegWed,$EndWed)
    {
        $returnValue = false;
		
		$IdPers=addslashes($IdPers);
		$BegWed=addslashes($BegWed);
		$EndWed=addslashes($EndWed);
		
        $req="INSERT INTO wednesday(`IdPers`,`BegWed`,`EndWed`) VALUES ('$IdPers','$BegWed','$EndWed')";
			$returnValue=mysql_query($req) or die('Erreur SQL :<br />'.$req.'<br />'.mysql_error());

        return $returnValue;
    }

    public function Edit($IdPers,$BegWed,$EndWed)
    {
        $returnValue = false;

		$IdPers=addslashes($IdPers);
		$BegWed=addslashes($BegWed);
		$EndWed=addslashes($EndWed);
		
       $req="UPDATE wednesday SET `IdPers`='$IdPers',`BegWed`='$BegWed', `EndWed`='$EndWed' WHERE `IdWed`='".$this->IdWed."'";
			$returnValue=mysql_query($req) or die('Erreur SQL :<br />'.$req.'<br />'.mysql_error());
			
			$this->wednesday('$IdWed');

        return $returnValue;
    }
    
	public function Delete($IdWed)
    {
        $returnValue = false;

        $req="DELETE FROM wednesday WHERE `IdWed`='".$this->IdWed."'";
			$returnValue=mysql_query($req) or die('Erreur SQL :<br />'.$req.'<br />'.mysql_error());

        return $returnValue;
    }

//List
	function Listing()
	{
		$returnValue = false;
		$req="SELECT S.IdWed, A.IdPers, S.BegWed, S.EndWed FROM wednesday S, person P WHERE S.IdPers = A.IdPers";
		$returnValue=mysql_query($req) or die('Erreur SQL :<br />'.$req.'<br />'.mysql_error());
		return $returnValue;
	}


} /* end of class wednesday */

?>