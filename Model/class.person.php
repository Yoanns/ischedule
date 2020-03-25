<?php

error_reporting(E_ALL);

class person
{
   
    // --- ATTRIBUTES ---

     //* @var String
    
    public $IdPers = null;
	
	public $Email = null;

	public $FirstName=null;
	
	public $LastName=null;
	
	public $DOB=null;

	public $Phone=null;
	
	public $FirstDay=null;
	
	public $Avatar=null;
	
	public $WorkHrs=null;
	
	public $IdPost=null;
	

    // --- OPERATIONS ---

   function person($IdPers)
	{
	$req="Select IdPers, Email, FirstName, LastName, DOB, Phone, FirstDay, Avatar, WorkHrs, IdPost from person
			where IdPers='$IdPers' ORDER BY LastName ASC limit 0,1";
		$resultat=mysql_query($req) or die('Erreur SQL :<br />'.$req.'<br />'.mysql_error());
		if($ligne=mysql_fetch_array($resultat))
		{
		$this->IdPers=$ligne[0];
		$this->Email=$ligne[1];
		$this->FirstName=$ligne[2];
		$this->LastName=$ligne[3];
		$this->DOB=$ligne[4];
		$this->Phone=$ligne[5];
		$this->FirstDay=$ligne[6];
		$this->Avatar=$ligne[7];
		$this->WorkHrs=$ligne[8];
		$this->IdPost=$ligne[9];
		}
	}
   
    public function AddPers($IdPers, $Email, $FirstName, $LastName, $DOB, $Phone, $FirstDay, $Avatar, $WorkHrs, $IdPost)
    {
        $returnValue = false;
		$Email		=	addslashes($Email);
		$FirstName	=	addslashes($FirstName);
		$LastName	=	addslashes($LastName);
		$WorkHrs	=	addslashes($WorkHrs);
		$DOB		=	addslashes($DOB);
		$Phone		=	addslashes($Phone);
		$FirstDay	=	addslashes($FirstDay);
		$Avatar		=	addslashes($Avatar);
		$IdPost		=	addslashes($IdPost);
		
        $req="Insert into person(`IdPers`,`Email`,`FirstName`,`LastName`,`DOB`,`Phone`,`FirstDay`,`Avatar`,`WorkHrs`,`IdPost`) 
			values ('$IdPers','$Email','$FirstName','$LastName','$DOB','$Phone','$FirstDay','$Avatar','$WorkHrs','$IdPost')";
			$returnValue=mysql_query($req) or die('Erreur SQL :<br />'.$req.'<br />'.mysql_error());

        return $returnValue;
    }


    public function EditPers($IdPers, $Email, $FirstName, $LastName, $DOB, $Phone, $FirstDay, $Avatar, $WorkHrs, $IdPost)
    {
        $returnValue = false;
		$Email		=	addslashes($Email);
		$FirstName	=	addslashes($FirstName);
		$LastName	=	addslashes($LastName);
		$WorkHrs	=	addslashes($WorkHrs);
		$DOB		=	addslashes($DOB);
		$Phone		=	addslashes($Phone);
		$FirstDay	=	addslashes($FirstDay);
		$Avatar		=	addslashes($Avatar);
		$IdPost		=	addslashes($IdPost);
		
        $req = "UPDATE person SET `IdPers`='$IdPers',`Email`='$Email', `FirstName`='$FirstName', `LastName`='$LastName', `DOB`='$DOB', `Phone`='$Phone', `FirstDay`='$FirstDay', `Avatar`='$Avatar', `WorkHrs`='$WorkHrs', `IdPost`='$IdPost' where `IdPers`='".$this->IdPers."'";
			$returnValue=mysql_query($req) or die('Erreur SQL :<br />'.$req.'<br />'.mysql_error());
			
			$this->person('$IdPers');

        return $returnValue;
    }
    
	public function Delete($IdPers)
    {
        $returnValue = false;

        $req="Delete from person where `IdPers`='".$this->IdPers."'";
			$returnValue=mysql_query($req) or die('Erreur SQL :<br />'.$req.'<br />'.mysql_error());

        return $returnValue;
    }

//Liste
	function ListingAdm()
	{
		$returnValue = false;
		$req="SELECT P.IdPers, P.Email, P.FirstName, P.LastName, P.DOB, P.Phone, P.FirstDay, P.Avatar, P.WorkHrs, D.IdDept, D.NameDept, D.LocDept, Pt.IdPost, Pt.LabPost
				FROM person P, post Pt, department D
				WHERE P.IdPost = Pt.IdPost
				AND Pt.IdDept = D.IdDept";
				
		$returnValue=mysql_query($req) or die('Erreur SQL :<br />'.$req.'<br />'.mysql_error());
		return $returnValue;
	}
	
	function Listing($IdDept)
	{
		$returnValue = false;
		$req="SELECT P.IdPers, P.Email, P.FirstName, P.LastName, P.DOB, P.Phone, P.FirstDay, P.Avatar, P.WorkHrs, D.IdDept, D.NameDept, D.LocDept, Pt.IdPost, Pt.LabPost
				FROM person P, post Pt, department D
				WHERE P.IdPost = Pt.IdPost
				AND Pt.IdDept = D.IdDept
				AND D.IdDept = '$IdDept'";
				
		$returnValue=mysql_query($req) or die('Erreur SQL :<br />'.$req.'<br />'.mysql_error());
		return $returnValue;
	}
	
} /* end of class person */

?>