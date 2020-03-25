<?php
require_once("class.person.php");
require_once("class.week.php");
error_reporting(E_ALL);

class schedule
{
   
    // --- ATTRIBUTES ---

     //* @var String
    
    public $IdSc = null;
	
	public $IdWK = null;

	public $IdPers=null;

	public $SunBegHr=null;
	
	public $SunEndHr=null;
	
	public $MonBegHr=null;
	
	public $MonEndHr=null;
	
	public $TuesBegHr=null;
	
	public $TuesEndHr=null;
	
	public $WedBegHr=null;
	
	public $WedEndHr=null;
	
	public $ThursBegHr=null;
	
	public $ThursEndHr=null;
	
	public $FriBegHr=null;
	
	public $FriEndHr=null;
	
	public $SatBegHr=null;
	
	public $SatEndHr=null;
	
	

    // --- OPERATIONS ---

   function schedule($IdSc)
	{
	$req="Select IdSc,IdWk,IdPers,SunBegHr,SunEndHr,MonBegHr,MonEndHr,TuesBegHr,TuesEndHr,WedBegHr,WedEndHr,ThursBegHr,ThursEndHr,FriBegHr,FriEndHr,SatBegHr,SatEndHr from schedule
			where IdSc='$IdSc' limit 0,1";
		$resultat=mysql_query($req) or die('Erreur SQL :<br />'.$req.'<br />'.mysql_error());
		if($ligne=mysql_fetch_array($resultat))
		{
		$this->IdSc=$ligne[0];
		$this->IdWK=$ligne[1];
		$this->IdPers=$ligne[2];
		$this->SunBegHr=$ligne[3];
		$this->SunEndHr=$ligne[4];
		$this->MonBegHr=$ligne[5];
		$this->MonEndHr=$ligne[6];
		$this->TuesBegHr=$ligne[7];
		$this->TuesEndHr=$ligne[8];
		$this->WedBegHr=$ligne[9];
		$this->WedEndHr=$ligne[10];
		$this->ThursBegHr=$ligne[11];
		$this->ThursEndHr=$ligne[12];
		$this->FriBegHr=$ligne[13];
		$this->FriEndHr=$ligne[14];
		$this->SatBegHr=$ligne[15];
		$this->SatEndHr=$ligne[16];

		}
	}
   
    public function AddSch($IdWk,$IdPers,$SunBegHr,$SunEndHr,$MonBegHr,$MonEndHr,$TuesBegHr,$TuesEndHr,$WedBegHr,$WedEndHr,$ThursBegHr,$ThursEndHr,$FriBegHr,$FriEndHr,$SatBegHr,$SatEndHr)
    {
        $returnValue = false;
		
		$IdWk=addslashes($IdWk);
		$IdPers=addslashes($IdPers);
		$SunBegHr=addslashes($SunBegHr);
		$SunEndHr=addslashes($SunEndHr);
		$MonBegHr=addslashes($MonBegHr);
		$MonEndHr=addslashes($MonEndHr);
		$TuesBegHr=addslashes($TuesBegHr);
		$TuesEndHr=addslashes($TuesEndHr);
		$WedBegHr=addslashes($WedBegHr);
		$WedEndHr=addslashes($WedEndHr);
		$ThursBegHr=addslashes($ThursBegHr);
		$ThursEndHr=addslashes($ThursEndHr);
		$FriBegHr=addslashes($FriBegHr);
		$FriEndHr=addslashes($FriEndHr);
		$SatBegHr=addslashes($SatBegHr);
		$SatEndHr=addslashes($SatEndHr);
		
		//$this->AddWk($BegWk,$EndWk);
		
        $req="Insert into schedule(`IdWk`,`IdPers`,`SunBegHr`,`SunEndHr`,`MonBegHr`,`MonEndHr`,`TuesBegHr`,`TuesEndHr`,`WedBegHr`,`WedEndHr`,`ThursBegHr`,`ThursEndHr`,`FriBegHr`,`FriEndHr`,`SatBegHr`,`SatEndHr`) 
			values ('$IdWk','$IdPers','$SunBegHr','$SunEndHr','$MonBegHr','$MonEndHr','$TuesBegHr','$TuesEndHr','$WedBegHr','$WedEndHr','$ThursBegHr','$ThursEndHr','$FriBegHr','$FriEndHr','$SatBegHr','$SatEndHr')";
			$returnValue=mysql_query($req) or die('Erreur SQL :<br />'.$req.'<br />'.mysql_error());

        return $returnValue;
    }


    public function EditSch($IdWk,$IdPers,$SunBegHr,$SunEndHr,$MonBegHr,$MonEndHr,$TuesBegHr,$TuesEndHr,$WedBegHr,$WedEndHr,$ThursBegHr,$ThursEndHr,$FriBegHr,$FriEndHr,$SatBegHr,$SatEndHr)
    {
        $returnValue = false;
		$IdWk=addslashes($IdWk);
		$IdPers=addslashes($IdPers);
		$SunBegHr=addslashes($SunBegHr);
		$SunEndHr=addslashes($SunEndHr);
		$MonBegHr=addslashes($MonBegHr);
		$MonEndHr=addslashes($MonEndHr);
		$TuesBegHr=addslashes($TuesBegHr);
		$TuesEndHr=addslashes($TuesEndHr);
		$WedBegHr=addslashes($WedBegHr);
		$WedEndHr=addslashes($WedEndHr);
		$ThursBegHr=addslashes($ThursBegHr);
		$ThursEndHr=addslashes($ThursEndHr);
		$FriBegHr=addslashes($FriBegHr);
		$FriEndHr=addslashes($FriEndHr);
		$SatBegHr=addslashes($SatBegHr);
		$SatEndHr=addslashes($SatEndHr); 
		
		//`IdWk`='$IdWk',`IdPers`='$IdPers',
		
        $req="UPDATE schedule SET  `SunBegHr`='$SunBegHr', `SunEndHr`='$SunEndHr', `MonBegHr`='$MonBegHr', `MonEndHr`='$MonEndHr', `TuesBegHr`='$TuesBegHr', `TuesEndHr`='$TuesEndHr', `WedBegHr`='$WedBegHr', `WedEndHr`='$WedEndHr', `ThursBegHr`='$ThursBegHr', `ThursEndHr`='$ThursEndHr', FriBegHr`='$FriBegHr `FriEndHr`='$FriEndHr', `SatBegHr`='$SatBegHr', `SatEndHr`='$SatEndHr'
				WHERE IdSc='".$this->IdSc."'";
			$returnValue=mysql_query($req) or die('Erreur SQL :<br />'.$req.'<br />'.mysql_error());
			
			$this->schedule('$IdSc');

        return $returnValue;
    }
    
	public function Delete()
    {
        $returnValue = false;

        $req="Delete from schedule where `$IdSc`='$this->$IdSc'";
			$returnValue=mysql_query($req) or die('Erreur SQL :<br />'.$req.'<br />'.mysql_error());

        return $returnValue;
    }

//Liste
	function Listing()
	{
		$returnValue = false;
		$req="SELECT schedule.IdSc, week.IdWk, person.IdPers, schedule.SunBegHr, schedule.SunEndHr, schedule.MonBegHr, schedule.MonEndHr, schedule.TuesBegHr, schedule.TuesEndHr, schedule.WedBegHr, schedule.WedEndHr, schedule.ThursBegHr, schedule.ThursEndHr, schedule.FriBegHr, schedule.FriEndHr, schedule.SatBegHr, schedule.SatEndHr 
			FROM schedule, week, person
			WHERE person.IdPers = schedule.IdPers
			AND schedule.IdWk = week.IdWk";
		$returnValue=mysql_query($req) or die('Erreur SQL :<br />'.$req.'<br />'.mysql_error());
		return $returnValue;
	}
	
	function EmployeeSch($IdPers)
	{
		$returnValue = false;
		$req="SELECT schedule.IdSc, week.IdWk, person.IdPers, schedule.SunBegHr, schedule.SunEndHr, schedule.MonBegHr, schedule.MonEndHr, schedule.TuesBegHr, schedule.TuesEndHr, schedule.WedBegHr, schedule.WedEndHr, schedule.ThursBegHr, schedule.ThursEndHr, schedule.FriBegHr, schedule.FriEndHr, schedule.SatBegHr, schedule.SatEndHr 
			FROM schedule, week, person
			WHERE person.IdPers = schedule.IdPers
			AND schedule.IdPers = '".$IdPers."'";
		$returnValue=mysql_query($req) or die('Erreur SQL :<br />'.$req.'<br />'.mysql_error());
		return $returnValue;
	}
	
} /* end of class schedule */

?>