<?PHP
/***********************************************************/
/***  ***/
/***********************************************************/
header("Content-Type: text/xml");

//Connexion à la Base MySQL
include('../admin/sql.php');


//id_recette
$id_recette_astuce = $_POST["ras_id"];
$id_recette = $_POST["rec_id"];
$nom_champ = strtoupper($_POST["nom_champ"]);
$valeur = $_POST["valeur"];

try
{
	//Préparer la requête pour la rendre dynamique
	$result_t_recette_astuce = $bdd->prepare("update T_RECETTE_ASTUCES set ".$nom_champ." = :valeur where REC_ID = :id_recette and RAS_ID = :id_recette_astuce;");
	$result_t_recette_astuce->bindParam(":valeur",$valeur);
	$result_t_recette_astuce->bindParam(":id_recette",$id_recette);
	$result_t_recette_astuce->bindParam(":id_recette_astuce",$id_recette_astuce);
	$result_t_recette_astuce->execute();

	//Le chmap n\'a pas pu être mis à jour
	$result_t_test_recette_astuce = $bdd->prepare("SELECT ".$nom_champ." FROM T_RECETTE_ASTUCES where REC_ID=:id_recette and RAS_ID = :id_recette_astuce;");
	$result_t_test_recette_astuce->bindParam(":id_recette",$id_recette);
	$result_t_test_recette_astuce->bindParam(":id_recette_astuce",$id_recette_astuce);
	$result_t_test_recette_astuce->execute();
	$test_recette_astuce = $result_t_test_recette_astuce->fetch(PDO::FETCH_OBJ);

//Affichage de l'erreur SQL
	if ($result_t_test_recette_astuce == TRUE && $test_recette_astuce->$nom_champ == $valeur) {
		//MAJ Timestamp
		include('../inc/maj_date_modif.inc.php');
		echo '<input type="hidden" name="result" id="result" value="succes"/>astuce de recette mise à jour avec succès !';
	}
	if ($result_t_test_recette_astuce == FALSE || $test_recette_astuce->$nom_champ != $valeur)
		echo '<input type="hidden" name="result" id="result" value="echec"/>L\'astuce de recette n\'a pas pu être mise à jour !';
}
catch(Exception $e)
{
	exit('<input type="hidden" name="result" id="result" value="echec"/>L\'astuce de recette n\'a pas pu être mise à jour ! '. $e->getMessage());
}
?>