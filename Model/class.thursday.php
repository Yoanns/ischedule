<?php

error_reporting(E_ALL);
//require ('class.person.php');

class thursday
{
   
    // --- ATTRIBUTES ---

     //* @var String

    public $IdThurs = 0;
	
	public $IdPers = 0;

	public $BegThurs = null;
	
	public $EndThurs = null;
	

    // --- OPERATIONS ---

   function thursday($IdPers)
	{
	$req="SELECT IdThurs, IdPers, BegThurs, EndThurs FROM thursday
			WHERE IdPers='$IdPers' limit 0,1";
		$resultat=mysql_query($req) or die('Erreur SQL :<br />'.$req.'<br />'.mysql_error());
		if($ligne=mysql_fetch_array($resultat))
		{
		$this-> IdThurs  = $ligne[0];
		$this-> IdPers  = $ligne[1];
		$this-> BegThurs = $ligne[2];
		$this-> EndThurs = $ligne[3];		
		}
	}
   
    public function Add($IdPers,$BegThurs,$EndThurs)
    {
        $returnValue = false;
		
		$IdPers=addslashes($IdPers);
		$BegThurs=addslashes($BegThurs);
		$EndThurs=addslashes($EndThurs);
		
        $req="INSERT INTO thursday(`IdPers`,`BegThurs`,`EndThurs`) VALUES ('$IdPers','$BegThurs','$EndThurs')";
			$returnValue=mysql_query($req) or die('Erreur SQL :<br />'.$req.'<br />'.mysql_error());

        return $returnValue;
    }

    public function Edit($IdPers,$BegThurs,$EndThurs)
    {
        $returnValue = false;

		$IdPers=addslashes($IdPers);
		$BegThurs=addslashes($BegThurs);
		$EndThurs=addslashes($EndThurs);
		
       $req="UPDATE thursday SET `IdPers`='$IdPers',`BegThurs`='$BegThurs', `EndThurs`='$EndThurs' WHERE `IdThurs`='".$this->IdThurs."'";
			$returnValue=mysql_query($req) or die('Erreur SQL :<br />'.$req.'<br />'.mysql_error());
			
			$this->thursday('$IdThurs');

        return $returnValue;
    }
    
	public function Delete($IdThurs)
    {
        $returnValue = false;

        $req="DELETE FROM thursday WHERE `IdThurs`='".$this->IdThurs."'";
			$returnValue=mysql_query($req) or die('Erreur SQL :<br />'.$req.'<br />'.mysql_error());

        return $returnValue;
    }

//List
	function Listing()
	{
		$returnValue = false;
		$req="SELECT S.IdThurs, P.IdPers, S.BegThurs, S.EndThurs FROM thursday S, person P WHERE S.IdPers = P.IdPers";
		$returnValue=mysql_query($req) or die('Erreur SQL :<br />'.$req.'<br />'.mysql_error());
		return $returnValue;
	}


} /* end of class admin */

?>