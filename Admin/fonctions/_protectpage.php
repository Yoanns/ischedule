<?php session_start();
// ***************************************************************
// Protection des pages de la partie "administration"
// ***************************************************************
// si non identifie
if (!isset($_SESSION['sched_SESSION']) || @$_SESSION['sched_SESSION']!= true)
{
   // redirection vers le formulaire d identification
   header("Location: ./");
   exit;
}
// ------------------------------
// si identifie, on continue ...
// ------------------------------
?>