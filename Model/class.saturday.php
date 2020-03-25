<?php

error_reporting(E_ALL);
//require ('class.person.php');

class saturday
{
   
    // --- ATTRIBUTES ---

     //* @var String

    public $IdSat = 0;
	
	public $IdPers = 0;

	public $BegSat = null;
	
	public $EndSat = null;
	

    // --- OPERATIONS ---

   function saturday($IdPers)
	{
	$req="SELECT IdSat, IdPers, BegSat, EndSat FROM saturday
			WHERE IdPers='$IdPers' limit 0,1";
		$resultat=mysql_query($req) or die('Erreur SQL :<br />'.$req.'<br />'.mysql_error());
		if($ligne=mysql_fetch_array($resultat))
		{
		$this-> IdSat  = $ligne[0];
		$this-> IdPers  = $ligne[1];
		$this-> BegSat = $ligne[2];
		$this-> EndSat = $ligne[3];		
		}
	}
   
    public function Add($IdPers,$BegSat,$EndSat)
    {
        $returnValue = false;
		
		$IdPers=addslashes($IdPers);
		$BegSat=addslashes($BegSat);
		$EndSat=addslashes($EndSat);
		
        $req="INSERT INTO saturday(`IdPers`,`BegSat`,`EndSat`) VALUES ('$IdPers','$BegSat','$EndSat')";
			$returnValue=mysql_query($req) or die('Erreur SQL :<br />'.$req.'<br />'.mysql_error());

        return $returnValue;
    }

    public function Edit($IdPers,$BegSat,$EndSat)
    {
        $returnValue = false;

		$IdPers=addslashes($IdPers);
		$BegSat=addslashes($BegSat);
		$EndSat=addslashes($EndSat);
		
       $req="UPDATE saturday SET `IdPers`='$IdPers',`BegSat`='$BegSat', `EndSat`='$EndSat' WHERE `IdSat`='".$this->IdSat."'";
			$returnValue=mysql_query($req) or die('Erreur SQL :<br />'.$req.'<br />'.mysql_error());
			
			$this->saturday('$IdSat');

        return $returnValue;
    }
    
	public function Delete($IdSat)
    {
        $returnValue = false;

        $req="DELETE FROM saturday WHERE `IdSat`='".$this->IdSat."'";
			$returnValue=mysql_query($req) or die('Erreur SQL :<br />'.$req.'<br />'.mysql_error());

        return $returnValue;
    }

//List
	function Listing()
	{
		$returnValue = false;
		$req="SELECT S.IdSat, P.IdPers, S.BegSat, S.EndSat FROM saturday S, person P WHERE S.IdPers = P.IdPers";
		$returnValue=mysql_query($req) or die('Erreur SQL :<br />'.$req.'<br />'.mysql_error());
		return $returnValue;
	}


} /* end of class saturday */

?>