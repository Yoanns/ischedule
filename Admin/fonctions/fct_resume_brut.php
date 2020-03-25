<?php
// ****************************************************************
// RESUME BRUT d un texte html : SUPPRESSION des balises html
// ****************************************************************
// http://www.developpez.net/forums/d757484-8/php/langage/contribuez/discussion-reparer-code-html/

// $texte : le texte formaté (avec des balise html)
// $nbreCar : le nombre de caractères texte à afficher (sans compter les balises html)
// $nbreCar (minimum) : pour ne pas couper un mot, le compte s arretera a l espace suivant
// --------------------------------
function texte_resume($texte, $nbreCar)
{
	// **********************************
	// SUPPRESSION des balises html
	// **********************************
	$texte = strip_tags($texte);
	// Explication strip_tags : voir http://fr.php.net/manual/fr/function.strip-tags.php

	// **********************************
	// COUPE DU TEXTE pour le RESUME
	// **********************************
	// ajout d'un espace de fin au cas ou le texte n'en contiendrait pas...
	$texte .= ' ';
	// ----------------------------------
	$longueur = strlen($texte);
	// pour ne pas couper un mot, on va a l espace suivant
	$texte = substr($texte, 0, strpos($texte, ' ', $longueur > $nbreCar ? $nbreCar : $longueur));

	// ----------------------------------
	// On renvoie le résumé du texte correctement formaté.
	return $texte;
}
?>