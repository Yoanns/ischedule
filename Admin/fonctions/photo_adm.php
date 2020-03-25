<?php
// ***************************************************************
// ADMIN NEWS : TRAITEMENT des photos
// ***************************************************************
// protection de page ADMIN
   include_once('./_protectpageadm.php');
// **************************************
// Parametres de Connexion a la BD
	include_once('./connexion.php');
// **************************************
// Parametres de CONFIGURATION de la NEWS
	include_once('./config.php');
// **************************************
// Fonctions de traitement d image
	include_once('./fct_traitement_image.php');
// **************************************
// Gestion des photos supprimees
// ----------------------------------
if ($_POST['PhotoAvant'] != '' && @$_POST['PHOTOdelete'] == 'ON')
{
	// Suppression de la PHOTO ancienne
	@unlink($DossierNewsPhotoCourt.$_POST['PhotoAvant']);
	// Suppression dans la base de donnees par UPDATE
	mysql_query("UPDATE PERSON SET Avatar='' WHERE IdPers= ".$persID);
}
// ----------------------------------
// Traitement de la photo si uploadee
// ----------------------------------
if(isset($_FILES['PHOTO']))
{
	// --------------------------
	// GESTION DES ERREURS
	// --------------------------
	$traiter_photo_OK = 'OK'; // (par defaut)
	$msgErreurPhoto = ''; // message d erreur
	// --------------------------
	// on verifie les restrictions sur les fichiers
	if (UPLOAD_ERR_OK<>0 && UPLOAD_ERR_FORM_SIZE==2) {
		$msgErreurPhoto .= 'Error ! Size of file too important ('.$ImageSizeMax.' bytes)<br />';
		$traiter_photo_OK = 'NO';
	}
	// --------------------------
	// on verifie la taille maxi
	if (@$_FILES['PHOTO']['size'] > $ImageSizeMax) {
		$msgErreurPhoto .= 'Error ! PHOTO<br />Size of file greater than the authorized maximum size ('.$ImageSizeMax.' bytes)<br />';
		$traiter_photo_OK = 'NO';
	}
	// --------------------------
	// on verifie l extension
	if (@$_FILES['PHOTO']['size']>0 && @strpos($ImageExtOK,strtolower(substr($_FILES['PHOTO']['name'], -3)))=='') {
		$msgErreurPhoto .= 'Error ! PHOTO<br />It is not a valid IMAGE file (jpg, jpeg, png)<br />';
		$traiter_photo_OK = 'NO';
	}
	// --------------------------
	if ($traiter_photo_OK == 'NO') {
		$msgErreurPhoto .= '<br />Error : Impossible to save the picture.';
	}
	// -------------------------------------
	// si pas d'erreur : TRAITEMENT
	// -------------------------------------
	if ($traiter_photo_OK == 'OK')
	{
		if($_FILES['PHOTO']['size']>0)
		{
			// --------------------
			// enregistement de la PHOTO sous forme id_nom-image(.jpg, ...)
			// NB : id etant unique (auto-increment), cela rend le nom de la photo unique
			$PHOTOupload = $persID.'_'.$_FILES['PHOTO']['name'];
			// remplacement des caracteres accentues par non-accentues
			// remplacement des espaces par -
			// tout en minuscules
			$PHOTOupload = nomsansaccent($PHOTOupload);
			// pour eviter tout souci par la suite, on remplace aussi .jpeg par .jpg
			$PHOTOupload = str_replace('.jpeg','.jpg',$PHOTOupload);
			// --------------------
			// extension
			$tabfile = explode('.',$_FILES['PHOTO']['name']);
			$extension = $tabfile[sizeof($tabfile)-1]; // dernier element (apres le dernier .)
			// pour de simplifier les comparaisons, on met en minuscule
			$extension = strtolower($extension);
			// --------------------
			// enregistrement de la photo dans le dossier
			$temp = $_FILES['PHOTO']['tmp_name'];
			move_uploaded_file($temp, $DossierNewsPhotoCourt.$PHOTOupload);
			// --------------------
			// REDIMENSIONNEMENT et SAUVEGARDE de la PHOTO (si necessaire)
			// on recupere la largeur souhaitee de l image
			$photolargeur = $_POST['photolargeur'];
			// ecraser (remplacer) la photo (meme rep, meme nom)
			$redimPHOTOOK = fctredimimage($photolargeur,0,'','',$DossierNewsPhotoCourt,$PHOTOupload);
			// --------------------
			// SUPPRESSION des ANCIENNES PHOTOS (si necessaire)
			if ($_POST['PhotoAvant'] != '' && $_POST['PhotoAvant'] != $PHOTOupload)
			{
				// Suppression de l ancienne PHOTO dans le dossier
				@unlink($DossierNewsPhotoCourt.$_POST['PhotoAvant']);
			}
			// --------------------
			// enregistrement du NOM de la PHOTO dans la base de donnees par UPDATE
			mysql_query("UPDATE PERSON SET Avatar='".$PHOTOupload."' WHERE IdPers= '".$persID."'");
		} 
	}
	// fin TRAITEMENT PHOTO
}
// --------------------------------------
?>