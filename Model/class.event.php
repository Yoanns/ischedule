<?php

error_reporting(E_ALL);

class event
{
   
    // --- ATTRIBUTES ---

     //* @var String
    
    public $IdEvt = null;
	
	public $NameEvt = null;

	public $GuestEvt=null;
	
	public $DescEvt=null;
	
	public $DayEvt=null;

	public $BegEvt=null;
	
	public $EndEvt=null;

	public $IdLoc = null;
	

    // --- OPERATIONS ---

   function event($IdEvt)
	{
	$req="Select IdEvt, NameEvt, GuestEvt, DescEvt, DayEvt, BegEvt, EndEvt, IdLoc from event
			where IdEvt='$IdEvt' order by BegEvt limit 0,1";
		$resultat=mysql_query($req) or die('Erreur SQL :<br />'.$req.'<br />'.mysql_error());
		if($ligne=mysql_fetch_array($resultat))
		{
		$this->IdEvt=$ligne[0];
		$this->NameEvt=$ligne[1];
		$this->GuestEvt=$ligne[2];
		$this->DescEvt=$ligne[3];
		$this->DayEvt=$ligne[4];
		$this->BegEvt=$ligne[5];
		$this->EndEvt=$ligne[6];
		$this->IdLoc=$ligne[7];
		}
	}
   
    public function AddEvt($NameEvt, $GuestEvt, $DescEvt, $DayEvt, $BegEvt, $EndEvt, $IdLoc)
    {
        $returnValue = false;
		$NameEvt	=	addslashes($NameEvt);
		$GuestEvt	=	addslashes($GuestEvt);
		$DescEvt	=	addslashes($DescEvt);
		$DayEvt	=	addslashes($DayEvt);
		$BegEvt	=	addslashes($BegEvt);
		$EndEvt	=	addslashes($EndEvt);
		$IdLoc	=	addslashes($IdLoc);
		
        $req="Insert into event(`NameEvt`,`GuestEvt`,`DescEvt`,`DayEvt`,`BegEvt`,`EndEvt`,`IdLoc`) 
			values ('$NameEvt','$GuestEvt','$DescEvt','$DayEvt','$BegEvt','$EndEvt','$IdLoc')";
			$returnValue=mysql_query($req) or die('Erreur SQL :<br />'.$req.'<br />'.mysql_error());

        return $returnValue;
    }


    public function EditEvt($NameEvt, $GuestEvt, $DescEvt, $DayEvt, $BegEvt, $EndEvt,$IdLoc)
    {
        $returnValue = false;
		$NameEvt	=	addslashes($NameEvt);
		$GuestEvt	=	addslashes($GuestEvt);
		$DescEvt	=	addslashes($DescEvt);
		$DayEvt	=	addslashes($DayEvt);
		$BegEvt	=	addslashes($BegEvt);
		$EndEvt	=	addslashes($EndEvt);
		$IdLoc	=	addslashes($IdLoc);
		
        $req = "UPDATE event SET `NameEvt`='$NameEvt', `GuestEvt`='$GuestEvt', `DescEvt`='$DescEvt', `DayEvt`='$DayEvt', `BegEvt`='$BegEvt', `EndEvt`='$EndEvt', `IdLoc`='$IdLoc'
				where `IdEvt`='".$this->IdEvt."'";
			$returnValue=mysql_query($req) or die('Erreur SQL :<br />'.$req.'<br />'.mysql_error());
			
			$this->event('$IdEvt');

        return $returnValue;
    }
    
	public function Delete($IdEvt)
    {
        $returnValue = false;

        $req="Delete from event where `IdEvt`='".$this->IdEvt."'";
			$returnValue=mysql_query($req) or die('Erreur SQL :<br />'.$req.'<br />'.mysql_error());

        return $returnValue;
    }

//List
	function Listing()
	{
		$returnValue = false;
		$req="SELECT * FROM event ";
				
		$returnValue=mysql_query($req) or die('Erreur SQL :<br />'.$req.'<br />'.mysql_error());
		return $returnValue;
	}
	
	function DayEvents($DayEvt,$IdLoc)
	{
		$returnValue = false;
		$req="SELECT * FROM event WHERE `DayEvt` = '$DayEvt' AND `IdLoc`='$IdLoc' ORDER BY BegEvt";
				
		$returnValue=mysql_query($req) or die('Erreur SQL :<br />'.$req.'<br />'.mysql_error());
		return $returnValue;
	}
	
	function DayEventsAdm($DayEvt)
	{
		$returnValue = false;
		$req="SELECT * FROM event WHERE `DayEvt` = '$DayEvt' GROUP BY IdLoc ORDER BY BegEvt";
				
		$returnValue=mysql_query($req) or die('Erreur SQL :<br />'.$req.'<br />'.mysql_error());
		return $returnValue;
	}
	
} /* end of class event */

?>