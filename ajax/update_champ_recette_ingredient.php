<?PHP
/***********************************************************/
/***  ***/
/***********************************************************/
header("Content-Type: text/xml");

//Connexion à la Base MySQL
include('../admin/sql.php');


//id_recette
$id_recette_ingredient = $_GET["rin_id"];
$nom_champ = strtoupper($_GET["nom_champ"]);
$valeur = $_GET["valeur"];
$id_recette = $_GET["rec_id"];

try
{
	//Préparer la requête pour la rendre dynamique
	$result_t_recette_ingredient = $bdd->prepare("update T_RECETTE_INGREDIENTS set ".$nom_champ." = :valeur where RIN_ID = :id_recette_ingredient;");
	$result_t_recette_ingredient->bindParam(":valeur",$valeur);
	$result_t_recette_ingredient->bindParam(":id_recette_ingredient",$id_recette_ingredient);
	$result_t_recette_ingredient->execute();

	//Le chmap n\'a pas pu être mis à jour
	$result_t_test_recette_ingredient = $bdd->prepare("SELECT ".$nom_champ." FROM T_RECETTE_INGREDIENTS where RIN_ID=:id_recette_ingredient;");
	$result_t_test_recette_ingredient->bindParam(":id_recette_ingredient",$id_recette_ingredient);
	$result_t_test_recette_ingredient->execute();
	$test_recette_ingredient = $result_t_test_recette_ingredient->fetch(PDO::FETCH_OBJ);

//Affichage de l'erreur SQL
	if ($result_t_recette_ingredient == TRUE && $test_recette_ingredient->$nom_champ == $valeur) {
		//MAJ Timestamp
		include('../inc/maj_date_modif.inc.php');

		echo '<input type="hidden" name="result" id="result" value="succes"/>champ ingrédient mis à jour avec succès !';
	}
	if ($result_t_recette_ingredient == FALSE || $test_recette_ingredient->$nom_champ != $valeur)
		echo '<input type="hidden" name="result" id="result" value="echec"/>Le champ ingrédient n\'a pas pu être mis à jour !';
}
catch(Exception $e)
{
	exit('<input type="hidden" name="result" id="result" value="echec"/>Le champ ingrédient n\'a pas pu être mis à jour ! '. $e->getMessage());
}
?>