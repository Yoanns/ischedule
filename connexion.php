<?php
// **************************************
//       PARAMETRES de CONNEXION 
//         a la BASE de DONNEES
// **************************************
// Parametres persos
$host = '127.0.0.1'; // voir hebergeur ou "localhost" en local
$user = 'root'; // vide ou "root" en local
$pass = 't6qqfusr'; // vide en local
$dbase = 'shiftscheduler'; // nom de la BD
// -------------------------
// Connexion au serveur
$connexion_db = mysql_connect($host,$user,$pass) or die ('Error connection parameters to the DB');
mysql_select_db($dbase,$connexion_db)or die ('Could not connect to the DB');
// -------------------------
?>