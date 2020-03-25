<?php session_start();
// ***************************************************************
// Deconnection de la partie "administration"
// + retour a la page d identification
// ***************************************************************
// on vide/detruit les variables de session
   $_SESSION = array();
   $session_name = session_name();
   session_destroy();
// ------------------------------
// Redirection vers la page d identification
   header("Location: ../../");
   exit;
// ------------------------------
?>
