<?PHP
/***********************************************************/
/***  ***/
/***********************************************************/
header("Content-Type: text/xml");

//Connexion à la Base MySQL
include('../admin/sql.php');


//id_recette
$id = $_GET["id"];
$nom_champ_id = $_GET["nom_champ_id"];
$nom_champ = strtoupper($_GET["nom_champ"]);
$valeur = $_GET["valeur"];
$table = $_GET["table"];

try
{
	//Préparer la requête pour la rendre dynamique
	$result_t_param = $bdd->prepare("update ".$table." set ".$nom_champ." = :valeur where ".$nom_champ_id." = :id;");
	$result_t_param->bindParam(":valeur",$valeur);
	$result_t_param->bindParam(":id",$id);
	$result_t_param->execute();

	//Le chmap n\'a pas pu être mis à jour
	$result_t_test_param = $bdd->prepare("SELECT ".$nom_champ." FROM ".$table." where ".$nom_champ_id."=:id;");
	$result_t_test_param->bindParam(":id",$id);
	$result_t_test_param->execute();
	$test_param = $result_t_test_param->fetch(PDO::FETCH_OBJ);

//Affichage de l'erreur SQL
	if ($result_t_param == TRUE && $test_param->$nom_champ == $valeur) {
		//MAJ Timestamp
		echo '<input type="hidden" name="result" id="result" value="succes"/>champ mis à jour avec succès !';
	}
	if ($result_t_param == FALSE || $test_param->$nom_champ != $valeur)
		echo '<input type="hidden" name="result" id="result" value="echec"/>Le champ n\'a pas pu être mis à jour !';
}
catch(Exception $e)
{
	exit('<input type="hidden" name="result" id="result" value="echec"/>Le chmap n\'a pas pu être mis à jour ! '. $e->getMessage());
}
?>