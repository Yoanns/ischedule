<?php
// ****************************************************************
// RESUME d un texte html + reparation des balises html
// ****************************************************************
// http://www.developpez.net/forums/d757484-8/php/langage/contribuez/discussion-reparer-code-html/

// $texte : le texte formaté (avec des balise html)
// $nbreCar : le nombre de caractères texte à afficher (sans compter les balises html)
// $nbreCar (minimum) : pour ne pas couper un mot, le compte s arretera a l espace suivant
// --------------------------------
function texte_resume($texte, $nbreCar)
{
	// **********************************
	// MASQUE de l'expression régulière
	// **********************************
	$MasqueHtmlSplit = '#</?([a-zA-Z1-6]+)(?: +[a-zA-Z]+="[^"]*")*( ?/)?>#';
	$MasqueHtmlMatch = '#<(?:/([a-zA-Z1-6]+)|([a-zA-Z1-6]+)(?: +[a-zA-Z]+="[^"]*")*( ?/)?)>#';
	// ----------------------------------
	// Explication du masque : recherche de TOUTES les balises html
	// ---------------
	// détail : </?([a-zA-Z1-6]+)
	// recherche de chaines commencant par un < 
	// suivi optionnellement d'un / (==> balises "fermantes")
	// suivi de (caractères alphabétiques (insensible à la casse) ou numériques (1 à 6)) au moins une fois
	// Suivi optionnellement (0, 1fois ou plus) par un ou plusieurs attributs et leur valeur :
	// ---------------
	// détail : (?: +[a-zA-Z]+="[^"]*")*
	// caractère espace une fois ou plus [space]+
	// suivi d'au moins un caractère alphabétique [a-zA-Z]+
	// suivi d'un =
	// suivi d'une paire de guillemets contenant otpionnellement (0, 1fois ou plus) tout caractère autre que guillemet "[^"]*"
	// ---------------
	// détail : ( ?/)?
	// caractère espace optionnel [space]?
	// suivi optionnellement d'un slash / (==> balises "orphelines")
	// NB : un :? suivant une parenthèse ouvrante signifie que l'on ne capture pas la parenthèse

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
	// Nombre d éléments du tableau
	$NombreBouts = count($BoutsTexte);
	
	// **********************************
	// CALCUL de la POSITION de la coupe
	// **********************************
	// Si seulement un seul élément dans l'array, c'est que le texte ne contient pas de balises :
	// on renvoie directement le texte tronqué
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
	// (position du dernier élément du tableau $chaines)
	$indexDernierBout = $NombreBouts - 1;
	// ----------------------------------
	// Position par défaut de la césure au cas ou la longueur du texte serait inférieure au nombre de caratères à sélectionner
	// La position de la césure est égal à sa position [1] + la longueur du bout de texte [0] - 1 (dernier caractère)
	$position = $BoutsTexte[$indexDernierBout][1] + strlen($BoutsTexte[$indexDernierBout][0]) - 1;
	// ----------------------------------
	$indexBout = $indexDernierBout;
	$rechercheEspace = true;
	// ----------------------------------
	// Boucle parcourant l'array et ayant pour fonction d'incrémenter au fur et à mesure la longueur des morceaux de texte, 
	// et de calculer la position de césure de l'extrait dans le texte
	foreach( $BoutsTexte as $index => $bout )
	{
		$longueur += strlen($bout[0]);
		// Si la longueur désirée de l'extrait à obtenir est atteinte
		if( $longueur >= $nbreCar )
		{
			// On calcule la position de césure du texte (position de chaîne + sa longueur -1 )
			$position_fin_bout = $bout[1] + strlen($bout[0]) - 1;
			// calcul de la position de césure
			$position = $position_fin_bout - ($longueur - $nbreCar);
			// On regarde si un espace est présent après la position dans le bout de texte
			if( ($positionEspace = strpos($bout[0], ' ', $position - $bout[1])) !== false  )
			{
				// Un espace est détecte dans le bout de texte APRÈS la position
				$position = $bout[1] + $positionEspace;
				$rechercheEspace = false;
			}
			// Si on ne se trouve pas sur le dernier élément
			if( $index != $indexDernierBout )
				$indexBout = $index + 1;
			break;
		}
	}
	// ----------------------------------
	// Donc il n'y avait pas d'espace dans le bout de texte où la position de césure sert de référence
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
	// On effectue la césure sur le texte suivant la position calculée
	$texte = substr($texte, 0, $position);

	// **********************************
	// RECHERCHE DES BALISES HTML
	// **********************************
	// Récupération de toutes les balises du texte et de leur position (PREG_OFFSET_CAPTURE)
	preg_match_all($MasqueHtmlMatch, $texte, $retour, PREG_OFFSET_CAPTURE);
	// ----------------------------------
	// Explication preg_match_all : voir http://fr.php.net/manual/fr/function.preg-match-all.php
	// $retour[0][xx][0] contient la balise html entière
	// $retour[0][xx][1] contient la position de la balise html entière
	// $retour[1][xx][0] contient le nom de la balise html fermante$rechercheEspace
	// $retour[2][xx][0] contient le nom de la balise html ouvrante
	// $retour[3][xx][0] contient le slash de fermeture de balise unique (cette varaible n'existe pas si la balise n'est pas unique)
	// ----------------------------------
	// Array destiné à enregistrer les noms de balises ouvrantes
	$BoutsTag = array();
	// ----------------------------------
	foreach( $retour[0] as $index => $tag )
	{
		// Si on se trouve sur une balise unique, on passe au tour suivant
		if( isset($retour[3][$index][0]) )
		{
			continue;
		}
		// Si le caractère slash n'est pas détecté en seconde position dans la balise entière, on est sur une balise ouvrante
		if( $retour[0][$index][0][1] != '/' )
		{
			// On empile l'élément en début de l'array
			array_unshift($BoutsTag, $retour[2][$index][0]);
		}
		// Donc balise fermante
		else
		{
			// suppression du premier élément de l'array
			array_shift($BoutsTag);
		}
	}
	// **********************************
	// REPARATION des balises html
	// **********************************
	// Il reste des tags à fermer ?
	// balises ouvertes, mais non-fermées : on ajoute les balises fermantes a la fin du texte
	if( !empty($BoutsTag) )
	{
		foreach( $BoutsTag as $tag )
		{
			$texte .= '</' . $tag . '>';
		}
	}
	// ----------------------------------
	// On renvoie le résumé du texte correctement formaté.
	return $texte;
}
?>