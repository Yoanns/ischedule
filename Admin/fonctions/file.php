<?php
// ***************************************************************
// ADMIN : ARTICLES : TRAITEMENT du FICHIER
// ***************************************************************
// protection de page ADMIN
   include_once('Admin/fonctions/_protectpage.php');
// **************************************
// Parametres de Connexion a la BD
	include_once('./connexion.php');
// **************************************
// Parametres de CONFIGURATION de la NEWS
	include_once('Admin/fonctions/config.php');
// **************************************
// Fonctions de traitement d image
	include_once('Admin/fonctions/fct_traitement_image.php');
// **************************************
// recuperation des donnees
	$FicheAvant = 		mysql_real_escape_string($_POST['FicheAvant']);
	@$FicheDelete = 	mysql_real_escape_string(@$_POST['FicheDelete']);
// ----------------------------------
// Gestion des fichiers supprimes
// ----------------------------------
if ($FicheAvant != '' && @$FicheDelete == 'ON')
{
	// Suppression de l ancienne fiche
	@unlink($DossierNewsFichier.$FicheAvant);
	// Suppression dans la base de donnees par UPDATE
	mysql_query("UPDATE notes SET FileNt='' WHERE IdNt= ".$notesID);
}
// ----------------------------------
// Traitement du FICHIER si upload
// ----------------------------------
$msgErreurFiche = ''; // message d erreur
// --------------------------
if(isset($_FILES['fiche']) && $_FILES['fiche']['size']>0)
 {
	// --------------------------
	// GESTION DES ERREURS
	// --------------------------
	$traiterFicheOK = 'OK'; // par defaut
	// --------------------------
	// on verifie les restrictions sur les fichiers
	if (UPLOAD_ERR_OK<>0 && UPLOAD_ERR_FORM_SIZE==2) {
		$msgErreurFiche .= 'Error (file) : Size of the file too important ('.$FichierSizeMax.' bytes)<br />';
		$traiterFicheOK = 'NO';
	}
	// --------------------------
	// on verifie la taille maxi
	if (@$_FILES['fiche']['size'] > $FichierSizeMax) {
		$msgErreurFiche .= 'Error (file) : Size of the file greater than the authorized maximum size ('.$FichierSizeMax.' octets)<br />';
		$traiterFicheOK = 'NO';
	}
	// --------------------------
	// on verifie l extension
	if (@$_FILES['fiche']['size']>0 && @strtolower(substr($_FILES['fiche']['name'], -3))!='pdf' && @strtolower(substr($_FILES['fiche']['name'], -3))!='doc' && @strtolower(substr($_FILES['fiche']['name'], -3))!='xls') {
		$msgErreurFiche .= 'Error (file) : This is not an authorized file ('.$FichierExtOK.')<br />';
		$traiterFicheOK = 'NO';
	}
	// --------------------------
	if ($traiterFicheOK == 'NO') {
		$msgErreurFiche .= 'Error : Impossible to save the file.<br />';
	}
	// -------------------------------------
	// si pas d'erreur : TRAITEMENT
	// -------------------------------------
	if ($traiterFicheOK == 'OK')
	{
		if($_FILES['fiche']['size']>0)
		{
			// --------------------
			$FicheUpload = '';
			// enregistement du fichier sous forme id_nom-fichier.pdf
			// NB : id etant unique (auto-increment), cela rend le nom du fichier unique
			$FicheUpload = $_FILES['fiche']['name'];
			// remplacement des caracteres accentues par non-accentues
			// remplacement des espaces par _
			// tout en minuscules
			$FicheUpload = nomsansaccent($FicheUpload);
			// --------------------
			// enregistrement du fichier dans le dossier
			$temp = $_FILES['fiche']['tmp_name'];
			move_uploaded_file($temp, $DossierNewsFichier.$FicheUpload);
			// --------------------
			// SUPPRESSION de l ANCIENNE fiche PDF (si necessaire)
			if ($FicheAvant != '' && $FicheAvant != $FicheUpload)
			{
				@unlink($DossierNewsFichier.$FicheAvant);
			}
			// --------------------
			// enregistrement du NOM du fichier dans la base de donnees par UPDATE
			mysql_query("UPDATE notes SET FileNt='".$FicheUpload."' WHERE IdNt= '".$notesID."'");
		} 
	}
 }	// fin if (traitement)
// --------------------------------------
?>