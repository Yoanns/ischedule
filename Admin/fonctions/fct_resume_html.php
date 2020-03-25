<?php
// ****************************************************************
// RESUME d un texte html + reparation des balises html
// ****************************************************************
// http://www.developpez.net/forums/d757484-8/php/langage/contribuez/discussion-reparer-code-html/

// $texte : le texte format� (avec des balise html)
// $nbreCar : le nombre de caract�res texte � afficher (sans compter les balises html)
// $nbreCar (minimum) : pour ne pas couper un mot, le compte s arretera a l espace suivant
// --------------------------------
function texte_resume($texte, $nbreCar)
{
	// **********************************
	// MASQUE de l'expression r�guli�re
	// **********************************
	$MasqueHtmlSplit = '#</?([a-zA-Z1-6]+)(?: +[a-zA-Z]+="[^"]*")*( ?/)?>#';
	$MasqueHtmlMatch = '#<(?:/([a-zA-Z1-6]+)|([a-zA-Z1-6]+)(?: +[a-zA-Z]+="[^"]*")*( ?/)?)>#';
	// ----------------------------------
	// Explication du masque : recherche de TOUTES les balises html
	// ---------------
	// d�tail : </?([a-zA-Z1-6]+)
	// recherche de chaines commencant par un < 
	// suivi optionnellement d'un / (==> balises "fermantes")
	// suivi de (caract�res alphab�tiques (insensible � la casse) ou num�riques (1 � 6)) au moins une fois
	// Suivi optionnellement (0, 1fois ou plus) par un ou plusieurs attributs et leur valeur :
	// ---------------
	// d�tail : (?: +[a-zA-Z]+="[^"]*")*
	// caract�re espace une fois ou plus [space]+
	// suivi d'au moins un caract�re alphab�tique [a-zA-Z]+
	// suivi d'un =
	// suivi d'une paire de guillemets contenant otpionnellement (0, 1fois ou plus) tout caract�re autre que guillemet "[^"]*"
	// ---------------
	// d�tail : ( ?/)?
	// caract�re espace optionnel [space]?
	// suivi optionnellement d'un slash / (==> balises "orphelines")
	// NB : un :? suivant une parenth�se ouvrante signifie que l'on ne capture pas la parenth�se

	// **********************************
	// RECHERCHE DU TEXTE DU RESUME
	// **********************************
	// ajout d'un espace de fin au cas ou le texte n'en contiendrait pas...
	$texte .= ' ';
	// ----------------------------------
	// Capture de tous les bouts de texte (en dehors des balises html)
	$BoutsTexte = preg_split($MasqueHtmlSplit, $texte, -1,  PREG_SPLIT_OFFSET_CAPTURE | PREG_SPLIT_NO_EMPTY);
	// ----------------------------------
	// Explication preg_split : voir http://fr.php.net/manual/fr/function.preg-split.php
	// => on obtient un tableau (array) :
	// $BoutsTexte[xx][0] : le bout de texte
	// $BoutsTexte[xx][1] : sa position (dans la chaine)
	// ----------------------------------
	// Nombre d �l�ments du tableau
	$NombreBouts = count($BoutsTexte);
	
	// **********************************
	// CALCUL de la POSITION de la coupe
	// **********************************
	// Si seulement un seul �l�ment dans l'array, c'est que le texte ne contient pas de balises :
	// on renvoie directement le texte tronqu�
	if( $NombreBouts == 1 )
	{
		$longueur = strlen($texte);
		// pour ne pas couper un mot, on va a l espace suivant
		return substr($texte, 0, strpos($texte, ' ', $longueur > $nbreCar ? $nbreCar : $longueur));
	}
	// ----------------------------------
	// Variable contenant la longueur des bouts de texte
	$longueur = 0;
	// ----------------------------------
	// (position du dernier �l�ment du tableau $chaines)
	$indexDernierBout = $NombreBouts - 1;
	// ----------------------------------
	// Position par d�faut de la c�sure au cas ou la longueur du texte serait inf�rieure au nombre de carat�res � s�lectionner
	// La position de la c�sure est �gal � sa position [1] + la longueur du bout de texte [0] - 1 (dernier caract�re)
	$position = $BoutsTexte[$indexDernierBout][1] + strlen($BoutsTexte[$indexDernierBout][0]) - 1;
	// ----------------------------------
	$indexBout = $indexDernierBout;
	$rechercheEspace = true;
	// ----------------------------------
	// Boucle parcourant l'array et ayant pour fonction d'incr�menter au fur et � mesure la longueur des morceaux de texte, 
	// et de calculer la position de c�sure de l'extrait dans le texte
	foreach( $BoutsTexte as $index => $bout )
	{
		$longueur += strlen($bout[0]);
		// Si la longueur d�sir�e de l'extrait � obtenir est atteinte
		if( $longueur >= $nbreCar )
		{
			// On calcule la position de c�sure du texte (position de cha�ne + sa longueur -1 )
			$position_fin_bout = $bout[1] + strlen($bout[0]) - 1;
			// calcul de la position de c�sure
			$position = $position_fin_bout - ($longueur - $nbreCar);
			// On regarde si un espace est pr�sent apr�s la position dans le bout de texte
			if( ($positionEspace = strpos($bout[0], ' ', $position - $bout[1])) !== false  )
			{
				// Un espace est d�tecte dans le bout de texte APR�S la position
				$position = $bout[1] + $positionEspace;
				$rechercheEspace = false;
			}
			// Si on ne se trouve pas sur le dernier �l�ment
			if( $index != $indexDernierBout )
				$indexBout = $index + 1;
			break;
		}
	}
	// ----------------------------------
	// Donc il n'y avait pas d'espace dans le bout de texte o� la position de c�sure sert de r�f�rence
	if( $rechercheEspace === true )
	{
		// Recherche d'un espace dans les bouts de texte suivants
		for( $i=$indexBout; $i<=$indexDernierBout; $i++ )
		{
			$position = $BoutsTexte[$i][1];
			if( ($positionEspace = strpos($BoutsTexte[$i][0], ' ')) !== false )
			{
				$position += $positionEspace;
				break;
			}
		}
	}
	// **********************************
	// COUPE DU TEXTE pour le RESUME
	// **********************************
	// On effectue la c�sure sur le texte suivant la position calcul�e
	$texte = substr($texte, 0, $position);

	// **********************************
	// RECHERCHE DES BALISES HTML
	// **********************************
	// R�cup�ration de toutes les balises du texte et de leur position (PREG_OFFSET_CAPTURE)
	preg_match_all($MasqueHtmlMatch, $texte, $retour, PREG_OFFSET_CAPTURE);
	// ----------------------------------
	// Explication preg_match_all : voir http://fr.php.net/manual/fr/function.preg-match-all.php
	// $retour[0][xx][0] contient la balise html enti�re
	// $retour[0][xx][1] contient la position de la balise html enti�re
	// $retour[1][xx][0] contient le nom de la balise html fermante$rechercheEspace
	// $retour[2][xx][0] contient le nom de la balise html ouvrante
	// $retour[3][xx][0] contient le slash de fermeture de balise unique (cette varaible n'existe pas si la balise n'est pas unique)
	// ----------------------------------
	// Array destin� � enregistrer les noms de balises ouvrantes
	$BoutsTag = array();
	// ----------------------------------
	foreach( $retour[0] as $index => $tag )
	{
		// Si on se trouve sur une balise unique, on passe au tour suivant
		if( isset($retour[3][$index][0]) )
		{
			continue;
		}
		// Si le caract�re slash n'est pas d�tect� en seconde position dans la balise enti�re, on est sur une balise ouvrante
		if( $retour[0][$index][0][1] != '/' )
		{
			// On empile l'�l�ment en d�but de l'array
			array_unshift($BoutsTag, $retour[2][$index][0]);
		}
		// Donc balise fermante
		else
		{
			// suppression du premier �l�ment de l'array
			array_shift($BoutsTag);
		}
	}
	// **********************************
	// REPARATION des balises html
	// **********************************
	// Il reste des tags � fermer ?
	// balises ouvertes, mais non-ferm�es : on ajoute les balises fermantes a la fin du texte
	if( !empty($BoutsTag) )
	{
		foreach( $BoutsTag as $tag )
		{
			$texte .= '</' . $tag . '>';
		}
	}
	// ----------------------------------
	// On renvoie le r�sum� du texte correctement format�.
	return $texte;
}
?>