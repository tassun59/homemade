<?PHP
/***********************************************************/
/***  ***/
/***********************************************************/
header("Content-Type: text/xml");

//Connexion à la Base MySQL
include('../admin/sql.php');


$id_recette = $_GET["rec_id"];
$id_recette_ingredient_entete = $_GET["rie_id"];

try
{
	$result_t_recette_ingredients = $bdd->query("delete from T_RECETTE_INGREDIENTS_ENTETE WHERE RIE_ID=".$id_recette_ingredient_entete.";");

	$result_count = $bdd->query("SELECT count(1) FROM T_RECETTE_INGREDIENTS_ENTETE WHERE RIE_ID=".$id_recette_ingredient_entete.";");
	$count = 0;

//Affichage de l'erreur SQL
	if ($result_t_recette_ingredients == TRUE && $count == 0) {
		//MAJ Timestamp
		include('../inc/maj_date_modif.inc.php');
		echo '<input type="hidden" name="result" id="result" value="succes"/>Section supprimée avec succès !';
	}
	if ($count != 0)
		echo '<input type="hidden" name="result" id="result" value="echec"/>La section n\'a pas pu être supprimée !';
}
catch(Exception $e)
{
	exit('<input type="hidden" name="result" id="result" value="echec"/>La section n\'a pas pu être supprimée ! '. $e->getMessage());
}
?>