<?php

error_reporting(E_ALL);

class availability
{
   
    // --- ATTRIBUTES ---

     //* @var String
    
    public $IdAvb = null;
	
	public $IdPers = null;

	public $Sun=null;
	
	public $Mon=null;
	
	public $Tues=null;

	public $Wed=null;
	
	public $Thurs=null;
	
	public $Fri=null;
	
	public $Sat=null;
	

    // --- OPERATIONS ---

   function availability($IdAvb)
	{
	$req="Select IdAvb, IdPers, Sun, Mon, Tues, Wed, Thurs, Fri, Sat from availability
			where IdAvb='$IdAvb' limit 0,1";
		$resultat=mysql_query($req) or die('Erreur SQL :<br />'.$req.'<br />'.mysql_error());
		if($ligne=mysql_fetch_array($resultat))
		{
		$this->IdAvb=$ligne[0];
		$this->IdPers=$ligne[1];
		$this->Sun=$ligne[2];
		$this->Mon=$ligne[3];
		$this->Tues=$ligne[4];
		$this->Wed=$ligne[5];
		$this->Thurs=$ligne[6];
		$this->Fri=$ligne[7];
		$this->Sat=$ligne[8];
		}
	}
   
    public function Add($IdAvb, $IdPers, $Sun, $Mon, $Tues, $Wed, $Thurs, $Fri, $Sat)
    {
        $returnValue = false;
		$IdPers	=	addslashes($IdPers);
		$Sun	=	addslashes($Sun);
		$Mon	=	addslashes($Mon);
		$Tues	=	addslashes($Tues);
		$Wed	=	addslashes($Wed);
		$Thurs	=	addslashes($Thurs);
		$Fri	=	addslashes($Fri);
		$Sat	=	addslashes($Sat);
		
        $req="Insert into availability(`IdAvb`,`IdPers`,`Sun`,`Mon`,`Tues`,`Wed`,`Thurs`,`Fri`,`Sat`) 
			values ('IdAvb','$IdPers','$Sun','$Mon','$Tues','$Wed','$Thurs','$Fri','$Sat')";
			$returnValue=mysql_query($req) or die('Erreur SQL :<br />'.$req.'<br />'.mysql_error());

        return $returnValue;
    }


    public function Edit($IdAvb, $IdPers, $Sun, $Mon, $Tues, $Wed, $Thurs, $Fri, $Sat)
    {
        $returnValue = false;
		$IdPers	=	addslashes($IdPers);
		$Sun	=	addslashes($Sun);
		$Mon	=	addslashes($Mon);
		$Tues	=	addslashes($Tues);
		$Wed	=	addslashes($Wed);
		$Thurs	=	addslashes($Thurs);
		$Fri	=	addslashes($Fri);
		$Sat	=	addslashes($Sat);
		
        $req = "UPDATE availability SET `IdAvb`='$IdAvb',`IdPers`='$IdPers', `Sun`='$Sun', `Mon`='$Mon', `Tues`='$Tues', Wed`='$Wed', `Thurs`='$Thurs', `Fri`='$Fri', `Sat`='$Sat' where `IdAvb`='".$this->IdAvb."'";
			$returnValue=mysql_query($req) or die('Erreur SQL :<br />'.$req.'<br />'.mysql_error());
			
			$this->availability('$IdAvb');

        return $returnValue;
    }
    
	public function Delete()
    {
        $returnValue = false;

        $req="Delete from availability where `$IdAvb`='".$this->$IdAvb."'";
			$returnValue=mysql_query($req) or die('Erreur SQL :<br />'.$req.'<br />'.mysql_error());

        return $returnValue;
    }

//List
	function Listing()
	{
		$returnValue = false;
		$req="SELECT A.IdAvb, P.IdPers, A.Sun, A.Mon, A.Tues, A.Wed, A.Thurs, A.Fri, A.Sat
				FROM availability A, person P
				WHERE A.IdPers = P.IdPers";
				
		$returnValue=mysql_query($req) or die('Erreur SQL :<br />'.$req.'<br />'.mysql_error());
		return $returnValue;
	}
	
} /* end of class availability */

?>