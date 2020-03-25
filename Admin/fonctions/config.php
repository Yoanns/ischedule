<?php

// ***************************************************************
// PARAMETRES POUR LES PHOTOS jointes
// ---------------------------------------------------------------
// ==> Choix du dossier de stockage des photos
// (ce dossier doit etre deprotege en ecriture : chmod 777)
// (par défaut : 'news_photos/')
// Partie publique (site)
	$DossierNewsPhoto = '../Avatars/';		// (par defaut)
	
	//chmod($DossierNewsPhoto, 777);

// partie privée (administration)
	$DossierNewsPhotoCourt = '../'.$DossierNewsPhoto;
// ==> Restrictions sur les fichiers
	// taille maxi des fichiers-image
	$ImageSizeMax = 2000000;
	// extensions acceptees (images)
	$ImageExtOK = '" .jpg .jpeg .png"'; 	// (NB: l espace avant .jpg est important)
// ***************************************************************
// PARAMETRES POUR LES FICHIERS joints
// ---------------------------------------------------------------
// ==> Choix du dossier de stockage des fichiers
// (ce dossier doit etre deprotege en ecriture : chmod 777)
// Partie publique (site)
	$DossierNewsFichier = '../Files/';		// (par defaut)
// partie privée (administration)
	$DossierNewsFichierCourt = '../'.$DossierNewsFichier;
// ==> Restrictions sur les fichiers
	// taille maxi des fichiers
	$FichierSizeMax = 2000000;
	// extensions acceptees (fichiers)
	$FichierExtOK = '" .pdf .doc .xls"'; 				// (par defaut : fichiers pdf uniquement)
// ***************************************************************
// DOSSIER des ICONES (administration)
// ---------------------------------------------------------------
	$DossierIcones = '../icones/';
// ***************************************************************
// PARAMETRES POUR L EDITEUR WYSIWYG
// ---------------------------------------------------------------
// ==> Choix de l editeur
//	$EditeurWysiwyg = 'fckeditor';			// par defaut : fckeditor
	$EditeurWysiwyg = 'ckeditor';			// ckeditor
//	$EditeurWysiwyg = 'tinymce';			// tinymce
//	$EditeurWysiwyg = ''; 					// rien (pour du texte brut)
// ---------------------------------------------------------------
?>