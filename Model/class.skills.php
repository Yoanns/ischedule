<?php

error_reporting(E_ALL);

class skills
{
   
    // --- ATTRIBUTES ---

     //* @var String

    public $IdPers = 0;

	public $Skill=null;
	

    // --- OPERATIONS ---

   function skills($IdPers)
	{
	$req="Select IdPers, Skill from skills
			where IdPers='$IdPers' limit 0,1";
		$resultat=mysql_query($req) or die('Erreur SQL :<br />'.$req.'<br />'.mysql_error());
		if($ligne=mysql_fetch_array($resultat))
		{
		$this-> IdPers  = $ligne[0];
		$this-> Skill = $ligne[1];
		
		}

	}
   
    public function Add($IdPers,$Skill)
    {
        $returnValue = false;
		
		$Skill=addslashes($Skill);
		
        $req="Insert into skills(`IdPers`,`Skill`) values ('$IdPers','$Skill')";
			$returnValue=mysql_query($req) or die('Erreur SQL :<br />'.$req.'<br />'.mysql_error());

        return $returnValue;
    }


    public function Edit($IdPers,$Skill)
    {
        $returnValue = false;

		$Skill=addslashes($Skill);
		
       $req="Update skills set `Skill`='$Skill' where `IdPers`='".$this->IdPers."'";
			$returnValue=mysql_query($req) or die('Erreur SQL :<br />'.$req.'<br />'.mysql_error());
			
			$this->skills('$IdPers');

        return $returnValue;
    }

    
	public function Delete($IdPers)
    {
        $returnValue = false;

        $req="Delete from skills where `IdPers`='$this->IdPers'";
			$returnValue=mysql_query($req) or die('Erreur SQL :<br />'.$req.'<br />'.mysql_error());

        return $returnValue;
    }

//Liste
	function Listing()
	{
		$returnValue = false;
		$req="Select IdPers,Skill from skills ORDER BY Skill ASC";
		$returnValue=mysql_query($req) or die('Erreur SQL :<br />'.$req.'<br />'.mysql_error());
		return $returnValue;
	}
		
	function TheSkill($IdPers)
	{
		$returnValue = false;
		$req="Select Skill from skills where `IdPers`='$this->IdPers' ORDER BY Skill ASC";
		$returnValue=mysql_query($req) or die('Erreur SQL :<br />'.$req.'<br />'.mysql_error());
		return $returnValue;
	}
	
} /* end of class Post */

?>