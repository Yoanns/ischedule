<?php

error_reporting(E_ALL);
//require ('class.person.php');

class sunday
{
   
    // --- ATTRIBUTES ---

     //* @var String

    public $IdSun = 0;
	
	public $IdPers = 0;

	public $BegSun = null;
	
	public $EndSun = null;
	

    // --- OPERATIONS ---

   function sunday($IdPers)
	{
	$req="SELECT IdSun, IdPers, BegSun, EndSun FROM sunday
			WHERE IdPers='$IdPers' limit 0,1";
		$resultat=mysql_query($req) or die('Erreur SQL :<br />'.$req.'<br />'.mysql_error());
		if($ligne=mysql_fetch_array($resultat))
		{
		$this-> IdSun  = $ligne[0];
		$this-> IdPers  = $ligne[1];
		$this-> BegSun = $ligne[2];
		$this-> EndSun = $ligne[3];		
		}
	}
   
    public function Add($IdPers,$BegSun,$EndSun)
    {
        $returnValue = false;
		
		$IdPers=addslashes($IdPers);
		$BegSun=addslashes($BegSun);
		$EndSun=addslashes($EndSun);
		
        $req="INSERT INTO sunday(`IdPers`,`BegSun`,`EndSun`) VALUES ('$IdPers','$BegSun','$EndSun')";
			$returnValue=mysql_query($req) or die('Erreur SQL :<br />'.$req.'<br />'.mysql_error());

        return $returnValue;
    }

    public function Edit($IdPers,$BegSun,$EndSun)
    {
        $returnValue = false;

		$IdPers=addslashes($IdPers);
		$BegSun=addslashes($BegSun);
		$EndSun=addslashes($EndSun);
		
       $req="UPDATE sunday SET `IdPers`='$IdPers',`BegSun`='$BegSun', `EndSun`='$EndSun' WHERE `IdSun`='".$this->IdSun."'";
			$returnValue=mysql_query($req) or die('Erreur SQL :<br />'.$req.'<br />'.mysql_error());
			
			$this->sunday('$IdSun');

        return $returnValue;
    }
    
	public function Delete($IdSun)
    {
        $returnValue = false;

        $req="DELETE FROM sunday WHERE `IdSun`='".$this->IdSun."'";
			$returnValue=mysql_query($req) or die('Erreur SQL :<br />'.$req.'<br />'.mysql_error());

        return $returnValue;
    }

//List
	function Listing()
	{
		$returnValue = false;
		$req="SELECT S.IdSun, P.IdPers, S.BegSun, S.EndSun FROM sunday S, person P WHERE S.IdPers = P.IdPers";
		$returnValue=mysql_query($req) or die('Erreur SQL :<br />'.$req.'<br />'.mysql_error());
		return $returnValue;
	}


} /* end of class sunday */

?>