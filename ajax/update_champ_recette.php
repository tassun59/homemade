<?PHP
/***********************************************************/
/***  ***/
/***********************************************************/
header("Content-Type: text/xml");

//Connexion à la Base MySQL
include('../admin/sql.php');


//id_recette
$id_recette = $_GET["rec_id"];
$nom_champ = strtoupper($_GET["nom_champ"]);
$valeur = $_GET["valeur"];

try
{
	//Préparer la requête pour la rendre dynamique
	//$result_t_recette = $bdd->query("update T_RECETTE set ".$nom_champ." = '".$valeur."' where REC_ID = ".$id_recette.";");
	$result_t_recette = $bdd->prepare("update T_RECETTE set ".$nom_champ." = :valeur where REC_ID = :id_recette;");
	$result_t_recette->bindParam(":valeur",$valeur);
	$result_t_recette->bindParam(":id_recette",$id_recette);
	$result_t_recette->execute();

	//Le chmap n\'a pas pu être mis à jour
	//$result_t_test_recette = $bdd->query("SELECT ".$nom_champ." FROM T_RECETTE where REC_ID=".$id_recette.";");
	$result_t_test_recette = $bdd->prepare("SELECT ".$nom_champ." FROM T_RECETTE where REC_ID=:id_recette;");
	$result_t_test_recette->bindParam(":id_recette",$id_recette);
	$result_t_test_recette->execute();
	$test_recette = $result_t_test_recette->fetch(PDO::FETCH_OBJ);

//Affichage de l'erreur SQL
	if ($result_t_recette == TRUE && $test_recette->$nom_champ == $valeur) {
		//MAJ Timestamp
		include('../inc/maj_date_modif.inc.php');
		echo '<input type="hidden" name="result" id="result" value="succes"/>champ mis à jour avec succès !';
	}
	if ($result_t_recette == FALSE || $test_recette->$nom_champ != $valeur)
		echo '<input type="hidden" name="result" id="result" value="echec"/>Le champ n\'a pas pu être mis à jour !';
}
catch(Exception $e)
{
	exit('<input type="hidden" name="result" id="result" value="echec"/>Le chmap n\'a pas pu être mis à jour ! '. $e->getMessage());
}
?>