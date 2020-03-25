<?php

error_reporting(E_ALL);
//require ('class.person.php');

class monday
{
   
    // --- ATTRIBUTES ---

     //* @var String

    public $IdMon = 0;
	
	public $IdPers = 0;

	public $BegMon = null;
	
	public $EndMon = null;
	

    // --- OPERATIONS ---

   function monday($IdPers)
	{
	$req="SELECT IdMon, IdPers, BegMon, EndMon FROM monday
			WHERE IdPers='$IdPers' limit 0,1";
		$resultat=mysql_query($req) or die('Erreur SQL :<br />'.$req.'<br />'.mysql_error());
		if($ligne=mysql_fetch_array($resultat))
		{
		$this-> IdMon  = $ligne[0];
		$this-> IdPers  = $ligne[1];
		$this-> BegMon = $ligne[2];
		$this-> EndMon = $ligne[3];		
		}
	}
   
    public function Add($IdPers,$BegMon,$EndMon)
    {
        $returnValue = false;
		
		$IdPers=addslashes($IdPers);
		$BegMon=addslashes($BegMon);
		$EndMon=addslashes($EndMon);
		
        $req="INSERT INTO monday(`IdPers`,`BegMon`,`EndMon`) VALUES ('$IdPers','$BegMon','$EndMon')";
			$returnValue=mysql_query($req) or die('Erreur SQL :<br />'.$req.'<br />'.mysql_error());

        return $returnValue;
    }

    public function Edit($IdPers,$BegMon,$EndMon)
    {
        $returnValue = false;

		$IdPers=addslashes($IdPers);
		$BegMon=addslashes($BegMon);
		$EndMon=addslashes($EndMon);
		
       $req="UPDATE monday SET `IdPers`='$IdPers',`BegMon`='$BegMon', `EndMon`='$EndMon' WHERE `IdMon`='".$this->IdMon."'";
			$returnValue=mysql_query($req) or die('Erreur SQL :<br />'.$req.'<br />'.mysql_error());
			
			$this->monday('$IdMon');

        return $returnValue;
    }
    
	public function Delete($IdMon)
    {
        $returnValue = false;

        $req="DELETE FROM monday WHERE `IdMon`='".$this->IdMon."'";
			$returnValue=mysql_query($req) or die('Erreur SQL :<br />'.$req.'<br />'.mysql_error());

        return $returnValue;
    }

//List
	function Listing()
	{
		$returnValue = false;
		$req="SELECT S.IdMon, P.IdPers, S.BegMon, S.EndMon FROM monday S, person P WHERE S.IdPers = P.IdPers";
		$returnValue=mysql_query($req) or die('Erreur SQL :<br />'.$req.'<br />'.mysql_error());
		return $returnValue;
	}


} /* end of class monday */

?>