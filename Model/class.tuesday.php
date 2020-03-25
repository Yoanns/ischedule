<?php

error_reporting(E_ALL);
//require ('class.person.php');

class tuesday
{
   
    // --- ATTRIBUTES ---

     //* @var String

    public $IdTues = 0;
	
	public $IdPers = 0;

	public $BegTues = null;
	
	public $EndTues = null;
	

    // --- OPERATIONS ---

   function tuesday($IdPers)
	{
	$req="SELECT IdTues, IdPers, BegTues, EndTues FROM tuesday
			WHERE IdPers='$IdPers' limit 0,1";
		$resultat=mysql_query($req) or die('Erreur SQL :<br />'.$req.'<br />'.mysql_error());
		if($ligne=mysql_fetch_array($resultat))
		{
		$this-> IdTues  = $ligne[0];
		$this-> IdPers  = $ligne[1];
		$this-> BegTues = $ligne[2];
		$this-> EndTues = $ligne[3];		
		}
	}
   
    public function Add($IdPers,$BegTues,$EndTues)
    {
        $returnValue = false;
		
		$IdPers=addslashes($IdPers);
		$BegTues=addslashes($BegTues);
		$EndTues=addslashes($EndTues);
		
        $req="INSERT INTO tuesday(`IdPers`,`BegTues`,`EndTues`) VALUES ('$IdPers','$BegTues','$EndTues')";
			$returnValue=mysql_query($req) or die('Erreur SQL :<br />'.$req.'<br />'.mysql_error());

        return $returnValue;
    }

    public function Edit($IdPers,$BegTues,$EndTues)
    {
        $returnValue = false;

		$IdPers=addslashes($IdPers);
		$BegTues=addslashes($BegTues);
		$EndTues=addslashes($EndTues);
		
       $req="UPDATE tuesday SET `IdPers`='$IdPers',`BegTues`='$BegTues', `EndTues`='$EndTues' WHERE `IdTues`='".$this->IdTues."'";
			$returnValue=mysql_query($req) or die('Erreur SQL :<br />'.$req.'<br />'.mysql_error());
			
			$this->tuesday('$IdTues');

        return $returnValue;
    }
    
	public function Delete($IdTues)
    {
        $returnValue = false;

        $req="DELETE FROM tuesday WHERE `IdTues`='".$this->IdTues."'";
			$returnValue=mysql_query($req) or die('Erreur SQL :<br />'.$req.'<br />'.mysql_error());

        return $returnValue;
    }

//List
	function Listing()
	{
		$returnValue = false;
		$req="SELECT S.IdTues, A.IdPers, S.BegTues, S.EndTues FROM tuesday S, person P WHERE S.IdPers = P.IdPers";
		$returnValue=mysql_query($req) or die('Erreur SQL :<br />'.$req.'<br />'.mysql_error());
		return $returnValue;
	}


} /* end of class admin */

?>