<?php
// ***************************************************************
// LISTING des NEWS (avec résumé du contenu)
// ***************************************************************
// Parametres de Connexion a la BD
	include_once('connexion.php');
// -------------------------
// Parametres de Configuration Generale de la NEWS
	include_once('Admin/fonctions/config.php');
// ***************************************************************
// CONFIGURATION des PARAMETRES du LISTING des NEWS avec RESUME
// ***************************************************************
// ==> CHOISIR le NOM de cette page
//	$nomDeCettePage = 'notes_liste.php';
// ou (car ce script peut etre integre dans une autre page)
 $nomDeCettePage = $_SERVER["PHP_SELF"];
// **************************************
// fonction de RESUME du "Contenu"
// ==> CHOISIR de la mise en forme du résumé (brut ou formaté)
// ==> l'un ou l'autre, mais pas les 2 !
// texte brut :
	//include_once('News/fonctions/fct_resume_brut.php');
// (OU) texte formaté (html) :
	include_once('Admin/fonctions/fct_resume_html.php');
// **************************************
// ==> CHOISIR la Taille maxi du RESUME (en nombre de caractères)
	$resumeNbreCaracteres = 80;
// -------------------------
// ==> CHOISIR la Taille des PETITES photos (en pixels)
	$tailleNewsPicto = ' style="width:100px;" ';
// ou : 
//	$tailleNewsPicto = ' style="height:50px;" ';
// -------------------------
// PAGINATION :
// ==> CHOISIR le Nombre de News a afficher par page
	$nbreNewsParPage = 2;
// -------------------------
// ==> on ne veut prendre en compte que les xxx plus récentes (ex : les 30 dernieres)
	$nbreNewsMaxiOk = 3;
// ***************************************************************
// liens vers chacune des pages (pagination)
if (isset($_GET['page'])) {
	$page = $_GET['page']; // On recupere le numero de la page dans l'URL
} else { // si c'est la premiere fois qu'on charge la page
	$page = 1; // On se met sur la page 1 (par defaut)
}
// -------------------------
// nombre total de messages dans la BD
	$nbreNewsTotal_query = 	"SELECT COUNT(*) AS nbre_total FROM notes WHERE IdDept = '".$_SESSION["IdDept"]."' ";
	$nbreNewsTotal_result =	mysql_query($nbreNewsTotal_query);
	$nbreNewsTotal_row = 	mysql_fetch_array($nbreNewsTotal_result);
	$nbreNewsTotal = 		$nbreNewsTotal_row['nbre_total'];
// -------------------------
// on ne prend en compte que les xxx plus récentes
	if ($nbreNewsTotal > $nbreNewsMaxiOk) { $nbreNewsTotal = $nbreNewsMaxiOk; }
// nombre de pages a creer
	$nombrePages = ceil($nbreNewsTotal / $nbreNewsParPage);
// -------------------------


// -------------------------
// Affichage d un RESUME des News
// Petite photo + titre + date + résumé du contenu + lien [suite]
// -------------------------
// On calcule le numero du premier message qu'on prend pour le LIMIT de MySQL (pagination)
	$num_debut = 	($page - 1) * $nbreNewsParPage;
	$notes_query = 	"SELECT * FROM notes WHERE IdDept = '".$_SESSION["IdDept"]."' ORDER BY DateNt DESC LIMIT ".$num_debut.",".$nbreNewsParPage."; ";
	$notes_result = 	mysql_query($notes_query);
	$notesNb = mysql_num_rows($notes_result);
	
	if ($notesNb > 0)
	{
					?>
<div style="float:right;">
	<a href="Forms/notes_full_list.php"><div class="large blue button"> View All</div></a>
</div>
<div class="clearfix"></div><br/>
						<?php							
				
while ($notes_row = mysql_fetch_array($notes_result))
{
	$notesID = 		$notes_row['IdNt'];
	$notesTitle = 	stripslashes($notes_row['TitleNt']);
	$notesContent = 	stripslashes($notes_row['ContentNt']);
	$notesDate = 	$notes_row['DateNt'];
	$notesPhoto = 	$notes_row['PhotoNt'];
	$notesFiche = 	$notes_row['FileNt'];
	// Editeur WYSIWYG : on doit indiquer correctement le chemin vers le dossier
	// (pour affichage correct des "smyleys", par exemple)
	//$notesContenu = 	str_replace('../'.$EditeurWysiwyg,$EditeurWysiwyg,$notesContenu);
	// Résumé du Contenu
	$notesContenuResume = texte_resume($notesContent, $resumeNbreCaracteres);
?>
	<table style="border:none;">
		<tr style="border-bottom:thin #666666 solid;">
			<th style="text-align:left;"><?php echo $notesTitle; ?></th>
			<th style="text-align:right;">Posted on <?php echo date('M d, Y @ h:i A', $notesDate); ?></th>
		</tr>
		<tr>
			<td colspan="2">
<?php	if ($notesPhoto != ''){ ?>
			<img src="<?php echo $DossierNewsPhoto.$notesPhoto; ?>" <?php echo $tailleNewsPicto; ?> alt="" class="imageG" />
<?php	} ?>
			<?php echo $notesContenuResume; ?> ... <a href="Forms/thenote.php?id=<?php echo $notesID; ?>">[Read more]</a>
			</td>
		</tr>
	</table>
	<br />
<?php
} // (fin du while)
mysql_free_result($notes_result);
} //End if
elseif ($notesNb == 0)
	{
	?>
	 <div align="center">There is no note for now.</div>
	
	<?php
	}

?>

<br />