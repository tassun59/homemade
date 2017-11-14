<?PHP
/***********************************************************/
/***  ***/
/***********************************************************/
header("Content-Type: text/xml");

//Connexion à la Base MySQL
include('../admin/sql.php');


//id_recette
$id_recette_entete_ingredient = $_POST["rie_id"];
$id_recette = $_POST["rec_id"];
$nom_champ = strtoupper($_POST["nom_champ"]);
$valeur = $_POST["valeur"];

try
{
	//Préparer la requête pour la rendre dynamique
	$result_t_recette_entete_ingredient = $bdd->prepare("update T_RECETTE_INGREDIENTS_ENTETE set ".$nom_champ." = :valeur where REC_ID = :id_recette and RIE_ID = :id_recette_entete_ingredient;");
	$result_t_recette_entete_ingredient->bindParam(":valeur",$valeur);
	$result_t_recette_entete_ingredient->bindParam(":id_recette",$id_recette);
	$result_t_recette_entete_ingredient->bindParam(":id_recette_entete_ingredient",$id_recette_entete_ingredient);
	$result_t_recette_entete_ingredient->execute();

	//Le chmap n\'a pas pu être mis à jour
	$result_t_test_recette_entete_ingredient = $bdd->prepare("SELECT ".$nom_champ." FROM T_RECETTE_INGREDIENTS_ENTETE where REC_ID=:id_recette and RIE_ID = :id_recette_entete_ingredient;");
	$result_t_test_recette_entete_ingredient->bindParam(":id_recette",$id_recette);
	$result_t_test_recette_entete_ingredient->bindParam(":id_recette_entete_ingredient",$id_recette_entete_ingredient);
	$result_t_test_recette_entete_ingredient->execute();
	$test_recette_etape = $result_t_test_recette_entete_ingredient->fetch(PDO::FETCH_OBJ);

//Affichage de l'erreur SQL
	if ($result_t_test_recette_entete_ingredient == TRUE && $test_recette_etape->$nom_champ == $valeur) {
		//MAJ Timestamp
		include('../inc/maj_date_modif.inc.php');
		echo '<input type="hidden" name="result" id="result" value="succes"/>Champ mis à jour avec succès !';
	}
	if ($result_t_test_recette_entete_ingredient == FALSE || $test_recette_etape->$nom_champ != $valeur)
		echo '<input type="hidden" name="result" id="result" value="echec"/>Ce champ n\'a pas pu être mis à jour !';
}
catch(Exception $e)
{
	exit('<input type="hidden" name="result" id="result" value="echec"/>Ce champ n\'a pas pu être mis à jour ! '. $e->getMessage());
}
?>