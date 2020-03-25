<?php

error_reporting(E_ALL);

class request
{
   
    // --- ATTRIBUTES ---

     //* @var String
    
    //public $IdReq = null;
	
	public $IdPers = null;

	public $TypeReq=null;
	
	public $DayReq=null;
	
	public $BegReq=null;

	public $EndReq=null;
	
	public $Reason=null;
	
	public $TimeReqSub=null;
	
	public $Status=null;
	

    // --- OPERATIONS ---

   function request($DayReq)
	{
	$req="Select IdPers, TypeReq, DayReq, BegReq, EndReq, Reason, TimeReqSub, Status from request
			where  DayReq='$DayReq' limit 0,1";
		$resultat=mysql_query($req) or die('Erreur SQL :<br />'.$req.'<br />'.mysql_error());
		if($ligne=mysql_fetch_array($resultat))
		{
		//$this->IdReq=$ligne[0];
		$this->IdPers=$ligne[0];
		$this->TypeReq=$ligne[1];
		$this->DayReq=$ligne[2];
		$this->BegReq=$ligne[3];
		$this->EndReq=$ligne[4];
		$this->Reason=$ligne[5];
		$this->TimeReqSub=$ligne[6];
		$this->Status=$ligne[7];
		}
	}
   
    public function AddReq($IdPers, $TypeReq, $DayReq, $BegReq, $EndReq, $Reason, $TimeReqSub, $Status)
    {
        $returnValue = false;
		$IdPers	=	addslashes($IdPers);
		$TypeReq	=	addslashes($TypeReq);
		$DayReq	=	addslashes($DayReq);
		$BegReq	=	addslashes($BegReq);
		$EndReq	=	addslashes($EndReq);
		$Reason	=	addslashes($Reason);
		//$TimeReqSub	=	addslashes($TimeReqSub);
		//$Status	=	addslashes($Status);
		
        $req="Insert into request(`IdPers`,`TypeReq`,`DayReq`,`BegReq`,`EndReq`,`Reason`,`TimeReqSub`,`Status`) 
			values ('$IdPers','$TypeReq','$DayReq','$BegReq','$EndReq','$Reason',NOW(),'$Status')";
			$returnValue=mysql_query($req) or die('Erreur SQL :<br />'.$req.'<br />'.mysql_error());

        return $returnValue;
    }


    public function EditReq($IdPers, $TypeReq, $DayReq, $BegReq, $EndReq, $Reason, $TimeReqSub, $Status)
    {
        $returnValue = false;
		$IdPers	=	addslashes($IdPers);
		$TypeReq	=	addslashes($TypeReq);
		$DayReq	=	addslashes($DayReq);
		$BegReq	=	addslashes($BegReq);
		$EndReq	=	addslashes($EndReq);
		$Reason	=	addslashes($Reason);
		//$TimeReqSub	=	addslashes($TimeReqSub);
		$Status	=	addslashes($Status);
		
        $req = "UPDATE request SET  `TypeReq`='$TypeReq', `DayReq`='$DayReq', `BegReq`='$BegReq', `EndReq`='$EndReq', `Reason`='$Reason', `TimeReqSub`=NOW(), `Status`='$Status' where `$DayReq`='".$this->DayReq."'";
			$returnValue=mysql_query($req) or die('Erreur SQL :<br />'.$req.'<br />'.mysql_error());
			
			$this->request('$IdReq');

        return $returnValue;
    }
    
	public function Delete($DayReq)
    {
        $returnValue = false;

        $req="Delete from request where `DayReq`='".$this->DayReq."'";
			$returnValue=mysql_query($req) or die('Erreur SQL :<br />'.$req.'<br />'.mysql_error());

        return $returnValue;
    }
	
	public function DeletePersReq($IdPers)
    {
        $returnValue = false;

        $req="Delete from request where `IdPers`='".$this->IdPers."'";
			$returnValue=mysql_query($req) or die('Erreur SQL :<br />'.$req.'<br />'.mysql_error());

        return $returnValue;
    }


//List
	function Listing()
	{
		$returnValue = false;
		$req="SELECT P.IdPers, R.TypeReq, R.DayReq, R.BegReq, R.EndReq, R.Reason, R.TimeReqSub, R.Status
				FROM request R, person P
				WHERE R.IdPers = P.IdPers";
				
		$returnValue=mysql_query($req) or die('Erreur SQL :<br />'.$req.'<br />'.mysql_error());
		return $returnValue;
	}
	
	function MyDaysOff($IdPers)
	{
		$returnValue = false;
		$req="SELECT P.IdPers, R.TypeReq, R.DayReq, R.BegReq, R.EndReq, R.Reason, R.TimeReqSub, R.Status
				FROM request R, person P
				WHERE R.TypeReq = 'DAY-OFF'
				AND R.IdPers = P.IdPers
				AND P.IdPers ='$IdPers'
				ORDER BY TimeReqSub DESC
				LIMIT 0,3";
				
		$returnValue=mysql_query($req) or die('Erreur SQL :<br />'.$req.'<br />'.mysql_error());
		return $returnValue;
	}
	
	function MyDaysOn($IdPers)
	{
		$returnValue = false;
		$req="SELECT  P.IdPers, R.TypeReq, R.DayReq, R.BegReq, R.EndReq, R.Reason, R.TimeReqSub, R.Status
				FROM request R, person P
				WHERE R.TypeReq = 'DAY-ON'
				AND R.IdPers = P.IdPers
				AND P.IdPers ='$IdPers'
				ORDER BY TimeReqSub DESC
				LIMIT 0,3";
				
		$returnValue=mysql_query($req) or die('Erreur SQL :<br />'.$req.'<br />'.mysql_error());
		return $returnValue;
	}
	
	
	function TheDaysOff($IdDept)
	{
		$returnValue = false;
		$req="SELECT P.IdPers, R.TypeReq, R.DayReq, R.BegReq, R.EndReq, R.Reason, R.TimeReqSub, R.Status
				FROM request R, person P, post Ps
				WHERE R.TypeReq = 'DAY-OFF'
				AND R.IdPers = P.IdPers
				AND P.IdPost = Ps.IdPost
				AND Ps.IdDept = '".$IdDept."'
				ORDER BY TimeReqSub DESC
				LIMIT 0,5";
				
		$returnValue=mysql_query($req) or die('Erreur SQL :<br />'.$req.'<br />'.mysql_error());
		return $returnValue;
	}
	
	function TheDaysOn($IdDept)
	{
		$returnValue = false;
		$req="SELECT  P.IdPers, R.TypeReq, R.DayReq, R.BegReq, R.EndReq, R.Reason, R.TimeReqSub, R.Status
				FROM request R, person P, post Ps
				WHERE R.TypeReq = 'DAY-ON'
				AND R.IdPers = P.IdPers
				AND P.IdPost = Ps.IdPost
				AND Ps.IdDept = '".$IdDept."'
				ORDER BY TimeReqSub DESC
				LIMIT 0,5";
				
		$returnValue=mysql_query($req) or die('Erreur SQL :<br />'.$req.'<br />'.mysql_error());
		return $returnValue;
	}
} /* end of class request */

?>