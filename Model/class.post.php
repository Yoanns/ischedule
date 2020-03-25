<?php

error_reporting(E_ALL);

class post
{
   
    // --- ATTRIBUTES ---

     //* @var String

    public $IdPost = 0;

	public $LabPost=null;
	
	public $IdDept=null;
	

    // --- OPERATIONS ---

   function post($IdPost)
	{
	$req="Select IdPost, LabPost, IdDept from post
			where IdPost='$IdPost' limit 0,1";
		$resultat=mysql_query($req) or die('Erreur SQL :<br />'.$req.'<br />'.mysql_error());
		if($ligne=mysql_fetch_array($resultat))
		{
		$this-> IdPost  = $ligne[0];
		$this-> LabPost = $ligne[1];
		$this-> IdDept	= $ligne[2];
		
		}

	}
   
    public function Add($LabPost,$IdDept)
    {
        $returnValue = false;
		
		$LabPost=addslashes($LabPost);
		
        $req="Insert into post(`LabPost`,`IdDept`) values ('$LabPost','$IdDept')";
			$returnValue=mysql_query($req) or die('Erreur SQL :<br />'.$req.'<br />'.mysql_error());

        return $returnValue;
    }


    public function Edit($LabPost,$IdDept)
    {
        $returnValue = false;

		$LabPost=addslashes($LabPost);
		
       $req="Update post set `LabPost`='$LabPost', `IdDept`='$IdDept' where `IdPost`='".$this->IdPost."'";
			$returnValue=mysql_query($req) or die('Erreur SQL :<br />'.$req.'<br />'.mysql_error());
			
			$this->post('$IdPost');

        return $returnValue;
    }

    
	public function Delete($IdPost)
    {
        $returnValue = false;

        $req="Delete from post where `IdPost`='$this->IdPost'";
			$returnValue=mysql_query($req) or die('Erreur SQL :<br />'.$req.'<br />'.mysql_error());

        return $returnValue;
    }

//Liste
	function Listing()
	{
		$returnValue = false;
		$req="Select * from post ORDER BY LabPost ASC";
		$returnValue=mysql_query($req) or die('Erreur SQL :<br />'.$req.'<br />'.mysql_error());
		return $returnValue;
	}
	
	function ListingAdm($IdDept)
	{
		$returnValue = false;
		$req="Select * from post WHERE IdDept = '$IdDept' ORDER BY LabPost ASC";
		$returnValue=mysql_query($req) or die('Erreur SQL :<br />'.$req.'<br />'.mysql_error());
		return $returnValue;
	}
		
	
} /* end of class Post */

?>