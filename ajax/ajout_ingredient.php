<?PHP
/***********************************************************/
/***  ***/
/***********************************************************/
header("Content-Type: text/xml");

//Connexion à la Base MySQL
include('../admin/sql.php');


//id_recette
$id_recette = $_GET["rec_id"];
$id_recette_ingredient_entete = $_GET["rie_id"];
$id_ingredient = $_GET["ing_id"];

try
{
	$result_t_recette_ingredients = $bdd->query("INSERT INTO T_RECETTE_INGREDIENTS(REC_ID, RIE_ID, ING_ID) VALUES (".$id_recette.",".$id_recette_ingredient_entete.",".$id_ingredient.");");

	$result_count = $bdd->query("SELECT count(1) FROM T_RECETTE_INGREDIENTS where REC_ID=".$id_recette." and RIE_ID = ".$id_recette_ingredient_entete." and ING_ID = ".$id_ingredient.";");
	$count = $result_count->rowCount();

//Affichage de l'erreur SQL
	if ($result_t_recette_ingredients == TRUE && $count == 1) {
		//MAJ Timestamp
		include('../inc/maj_date_modif.inc.php');
		echo '<input type="hidden" name="result" id="result" value="succes"/>Ingrédient ajouté avec succès !';
	}
	if ($count == 0)
		echo '<input type="hidden" name="result" id="result" value="echec"/>L\'ingrédient n\'a pas pu être ajouté !';
}
catch(Exception $e)
{
	exit('<input type="hidden" name="result" id="result" value="echec"/>L\'ingrédient n\'a pas pu être ajouté ! '. $e->getMessage());
}
?>