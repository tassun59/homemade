<?PHP
/***********************************************************/
/***  ***/
/***********************************************************/
header("Content-Type: text/xml");

//Connexion à la Base MySQL
include('../admin/sql.php');


//id_recette
$id_recette_etape = $_POST["eta_id"];
$id_recette = $_POST["rec_id"];
$nom_champ = strtoupper($_POST["nom_champ"]);
$valeur = $_POST["valeur"];

try
{
	//Préparer la requête pour la rendre dynamique
	$result_t_recette_etape = $bdd->prepare("update T_RECETTE_ETAPES set ".$nom_champ." = :valeur where REC_ID = :id_recette and ETA_ID = :id_recette_etape;");
	$result_t_recette_etape->bindParam(":valeur",$valeur);
	$result_t_recette_etape->bindParam(":id_recette",$id_recette);
	$result_t_recette_etape->bindParam(":id_recette_etape",$id_recette_etape);
	$result_t_recette_etape->execute();

	//Le chmap n\'a pas pu être mis à jour
	$result_t_test_recette_etape = $bdd->prepare("SELECT ".$nom_champ." FROM T_RECETTE_ETAPES where REC_ID=:id_recette and ETA_ID = :id_recette_etape;");
	$result_t_test_recette_etape->bindParam(":id_recette",$id_recette);
	$result_t_test_recette_etape->bindParam(":id_recette_etape",$id_recette_etape);
	$result_t_test_recette_etape->execute();
	$test_recette_etape = $result_t_test_recette_etape->fetch(PDO::FETCH_OBJ);

//Affichage de l'erreur SQL
	if ($result_t_test_recette_etape == TRUE && $test_recette_etape->$nom_champ == $valeur) {
		//MAJ Timestamp
		include('../inc/maj_date_modif.inc.php');
		echo '<input type="hidden" name="result" id="result" value="succes"/>Etape de recette mise à jour avec succès !';
	}
	if ($result_t_test_recette_etape == FALSE || $test_recette_etape->$nom_champ != $valeur)
		echo '<input type="hidden" name="result" id="result" value="echec"/>L\'étape de recette n\'a pas pu être mise à jour !';
}
catch(Exception $e)
{
	exit('<input type="hidden" name="result" id="result" value="echec"/>L\'étape de recette n\'a pas pu être mise à jour ! '. $e->getMessage());
}
?>