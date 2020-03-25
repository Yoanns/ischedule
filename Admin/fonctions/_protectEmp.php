<?php if (!isset($_SESSION)) {
  		session_start();
		}
	include_once("./connexion.php");
	include_once("Model/class.admin.php");
	include_once("Model/class.admin_spr.php");
	include_once("Model/class.employee.php");
	include_once("Model/class.person.php");
	include_once("Model/class.post.php");
// ***************************************************************
// Connection a la partie "administration"
// ***************************************************************
// ==> CONFIGURATION de VOS parametres PERSO
// login et mot de passe de l'ADMINISTRATEUR :
   //$AdminIdentifiant = 'demo';
   //$AdminMotDePasse = 'test';
// ***************************************************************
$login = '';
$pass = '';
$msgerreur = '';
// ------------------------------

// ------------------------------

if(!isset($_SESSION["Login"]))
{
	
	$admin = new admin(null);
	$employee = new employee(null);
	$adminspr = new admin_spr(null);
	
	if(isset($_POST["btsubmit"]))
	{
	// si le visiteur (administrateur ?) a validé le formulaire
// on recupere les donnees
	if (isset($_POST['login']) && $_POST['login']!='' && isset($_POST['pass']) && $_POST['pass']!='')
{
    $login = $_POST['login'];
    $pass = $_POST['pass'];
	$hash_pwd =  hash('sha512', $pass);
	
	  if($employee -> AuthEmp($login,$hash_pwd))
		{
			$_SESSION["Login"] = $employee -> Login;
			$_SESSION["Pwd"] = $employee -> Pwd;
			$_SESSION["IdEmp"] = $employee -> IdPers;
			$persID = $employee -> IdPers;
			$person = new person($persID);
			
			$postID = $person -> IdPost;
			$post = new post($postID);
			$_SESSION["IdDept"] = $post  ->  IdDept;
		// Si le login et le mot de passe sont corrects
		// on met true dans une variable de session
		$_SESSION["sched_SESSION"] = true;   
	// --------------------
	    } 
		elseif($admin -> AuthAdmin($login,$hash_pwd))
		{
			$_SESSION["Login"] = $admin -> Login;
			$_SESSION["Pwd"] = $admin -> Pwd;
			$_SESSION["IdAdmin"] = $admin -> IdPers;
			$persID = $admin -> IdPers;
			$person = new person($persID);
			
			$postID = $person -> IdPost;
			$post = new post($postID);
			$_SESSION["IdDept"] = $post  ->  IdDept;
		
		// Si le login et le mot de passe sont corrects
		// on met true dans une variable de session
		$_SESSION["sched_SESSION"] = true;   
	// --------------------
	    }
		 elseif($adminspr -> AuthAdminSpr($login,$hash_pwd))
		{
			$_SESSION["Login"] = $adminspr -> Login;
			$_SESSION["Pwd"] = $adminspr -> Pwd;
			$_SESSION["IdAdmin"] = $adminspr -> IdPers;
			$persID = $adminspr -> IdPers;
			$person = new person($persID);			
			$postID = $person -> IdPost;
			$post = new post($postID);
			$_SESSION["IdDept"] = $post  ->  IdDept;
		
		// Si le login et le mot de passe sont corrects
		// on met true dans une variable de session
		$_SESSION["sched_SESSION"] = true;   
	// --------------------
	    } else {
			$_SESSION["sched_SESSION"] = false;
			$msgerreur = 'Incorrect login and/or password';
	         }
	}
}
}
?>