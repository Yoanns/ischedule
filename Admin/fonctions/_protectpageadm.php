<?php session_start();
// ***************************************************************
// Protection des pages de la partie "administration"
// ***************************************************************
// si non identifie
if (!isset($_SESSION['adm_SESSION']) || @$_SESSION['adm_SESSION']!= true)
{
   // redirection vers le formulaire d identification
   header("Location: ./");
   exit;
}
// ------------------------------
// si identifie, on continue ...
// ------------------------------
?>