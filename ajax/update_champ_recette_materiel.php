<?PHP
/***********************************************************/
/***  ***/
/***********************************************************/
header("Content-Type: text/xml");

//Connexion à la Base MySQL
include('../admin/sql.php');


//id_recette
$mat_id = $_POST["mat_id"];
$id_recette = $_POST["rec_id"];
$nom_champ = strtoupper($_POST["nom_champ"]);
$valeur = $_POST["valeur"];

try
{
	//Préparer la requête pour la rendre dynamique
	$result_t_recette_materiel = $bdd->prepare("update T_RECETTE_MATERIEL set ".$nom_champ." = :valeur where REC_ID = :id_recette and MAT_ID = :id_recette_materiel;");
	$result_t_recette_materiel->bindParam(":valeur",$valeur);
	$result_t_recette_materiel->bindParam(":id_recette",$id_recette);
	$result_t_recette_materiel->bindParam(":id_recette_materiel",$mat_id);
	$result_t_recette_materiel->execute();

	//Le chmap n\'a pas pu être mis à jour
	$result_t_test_recette_materiel = $bdd->prepare("SELECT ".$nom_champ." FROM T_RECETTE_MATERIEL where REC_ID=:id_recette and MAT_ID = :id_recette_materiel;");
	$result_t_test_recette_materiel->bindParam(":id_recette",$id_recette);
	$result_t_test_recette_materiel->bindParam(":id_recette_materiel",$mat_id);
	$result_t_test_recette_materiel->execute();
	$test_recette_materiel = $result_t_test_recette_materiel->fetch(PDO::FETCH_OBJ);

//Affichage de l'erreur SQL
	if ($result_t_test_recette_materiel == TRUE && $test_recette_materiel->$nom_champ == $valeur) {
		//MAJ Timestamp
		include('../inc/maj_date_modif.inc.php');
		echo '<input type="hidden" name="result" id="result" value="succes"/>Quantité de matériel mise à jour avec succès !';
	}
	if ($result_t_test_recette_materiel == FALSE || $test_recette_materiel->$nom_champ != $valeur)
		echo '<input type="hidden" name="result" id="result" value="echec"/>La quantité de matériel n\'a pas pu être mise à jour !';
}
catch(Exception $e)
{
	exit('<input type="hidden" name="result" id="result" value="echec"/>La quantité de matériel n\'a pas pu être mise à jour ! '. $e->getMessage());
}
?>