<?php
error_reporting(E_ALL);

class schedules
{
   
    // --- ATTRIBUTES ---

     //* @var String
    
	public $IdPers=null;

	public $Day=null;
	
	public $BegShift=null;
	
	public $EndShift=null;
	
	

    // --- OPERATIONS ---

   function schedules($IdPers,$Day)
	{
	$req="Select IdPers, Day, BegShift, EndShift from schedules
			where IdPers='$IdPers' AND Day='".$Day."' limit 0,1";
		$resultat=mysql_query($req) or die('Erreur SQL :<br />'.$req.'<br />'.mysql_error());
		if($ligne=mysql_fetch_array($resultat))
		{
		$this->IdPers=$ligne[0];
		$this->Day=$ligne[1];
		$this->BegShift=$ligne[2];
		$this->EndShift=$ligne[3];
		}
	}
   
    public function AddSch($IdPers,$Day,$BegShift,$EndShift)
    {
        $returnValue = false;
		
		$IdPers=addslashes($IdPers);
		$Day=addslashes($Day);
		$BegShift=addslashes($BegShift);
		$EndShift=addslashes($EndShift);
		
        $req="Insert into schedules(`IdPers`,`Day`,`BegShift`,`EndShift`) 
			values ('$IdPers','$Day','$BegShift','$EndShift')";
			$returnValue=mysql_query($req) or die('Erreur SQL :<br />'.$req.'<br />'.mysql_error());

        return $returnValue;
    }


    public function EditSch($IdPers,$Day,$BegShift,$EndShift)
    {
        $returnValue = false;
		$IdPers=addslashes($IdPers);
		$Day=addslashes($Day);
		$BegShift=addslashes($BegShift);
		$EndShift=addslashes($EndShift);
		
		
        $req="UPDATE schedules SET  `Day`='$Day', `BegShift`='$BegShift', `EndShift`='$EndShift'
				WHERE IdPers='".$this->IdPers."' AND Day='".$Day."'";
		
		$returnValue=mysql_query($req) or die('Erreur SQL :<br />'.$req.'<br />'.mysql_error());
			
		$this->schedules($IdPers,$Day);

        return $returnValue;
    }
    
	public function Delete($IdPers,$Day)
    {
        $returnValue = false;

        $req="Delete from schedules where `IdPers`='$this->IdPers' AND Day='".$Day."'";
			$returnValue=mysql_query($req) or die('Erreur SQL :<br />'.$req.'<br />'.mysql_error());

        return $returnValue;
    }

//Liste
	function Listing()
	{
		$returnValue = false;
		$req="SELECT P.IdPers, S.Day, S.BegShift, S.EndShift
			FROM schedules S, person P
			WHERE S.IdPers = P.IdPers";
		$returnValue=mysql_query($req) or die('Erreur SQL :<br />'.$req.'<br />'.mysql_error());
		return $returnValue;
	}
	
	function EmployeeSch($IdPers)
	{
		$returnValue = false;
		$req="SELECT P.IdPers, S.Day, S.BegShift, S.EndShift
			FROM schedules S, person P
			WHERE S.IdPers = P.IdPers
			AND P.IdPers = '".$IdPers."'";
		$returnValue=mysql_query($req) or die('Erreur SQL :<br />'.$req.'<br />'.mysql_error());
		return $returnValue;
	}
	
	function EmployeeDaySch($IdPers,$Day)
	{
		$returnValue = false;
		$req="SELECT P.IdPers, S.Day, S.BegShift, S.EndShift
			FROM schedules S, person P
			WHERE S.IdPers = P.IdPers
			AND P.IdPers = '".$IdPers."'
			AND S.Day = '".$Day."'";
		$returnValue=mysql_query($req) or die('Erreur SQL :<br />'.$req.'<br />'.mysql_error());
		return $returnValue;
	}
	
} /* end of class schedules */

?>