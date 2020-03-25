<?php

error_reporting(E_ALL);
//require ('class.person.php');

class friday
{
   
    // --- ATTRIBUTES ---

     //* @var String

    public $IdFri = 0;
	
	public $IdPers = 0;

	public $BegFri = null;
	
	public $EndFri = null;
	

    // --- OPERATIONS ---

   function friday($IdPers)
	{
	$req="SELECT IdFri, IdPers, BegFri, EndFri FROM friday
			WHERE IdPers='$IdPers' limit 0,1";
		$resultat=mysql_query($req) or die('Erreur SQL :<br />'.$req.'<br />'.mysql_error());
		if($ligne=mysql_fetch_array($resultat))
		{
		$this-> IdFri  = $ligne[0];
		$this-> IdPers  = $ligne[1];
		$this-> BegFri = $ligne[2];
		$this-> EndFri = $ligne[3];		
		}
	}
   
    public function Add($IdPers,$BegFri,$EndFri)
    {
        $returnValue = false;
		
		$IdPers=addslashes($IdPers);
		$BegFri=addslashes($BegFri);
		$EndFri=addslashes($EndFri);
		
        $req="INSERT INTO friday(`IdPers`,`BegFri`,`EndFri`) VALUES ('$IdPers','$BegFri','$EndFri')";
			$returnValue=mysql_query($req) or die('Erreur SQL :<br />'.$req.'<br />'.mysql_error());

        return $returnValue;
    }

    public function Edit($IdPers,$BegFri,$EndFri)
    {
        $returnValue = false;

		$IdPers=addslashes($IdPers);
		$BegFri=addslashes($BegFri);
		$EndFri=addslashes($EndFri);
		
       $req="UPDATE friday SET `IdPers`='$IdPers',`BegFri`='$BegFri', `EndFri`='$EndFri' WHERE `IdFri`='".$this->IdFri."'";
			$returnValue=mysql_query($req) or die('Erreur SQL :<br />'.$req.'<br />'.mysql_error());
			
			$this->friday('$IdFri');

        return $returnValue;
    }
    
	public function Delete($IdFri)
    {
        $returnValue = false;

        $req="DELETE FROM friday WHERE `IdFri`='".$this->IdFri."'";
			$returnValue=mysql_query($req) or die('Erreur SQL :<br />'.$req.'<br />'.mysql_error());
        return $returnValue;
    }

//List
	function Listing()
	{
		$returnValue = false;
		$req="SELECT S.IdFri, P.IdPers, S.BegFri, S.EndFri FROM friday S, person P WHERE S.IdPers = P.IdPers";
		$returnValue=mysql_query($req) or die('Erreur SQL :<br />'.$req.'<br />'.mysql_error());
		return $returnValue;
	}


} /* end of class friday */

?>