<?PHP
/***********************************************************/
/***  ***/
/***********************************************************/
header("Content-Type: text/xml");

//Connexion à la Base MySQL
include('../admin/sql.php');


$id_recette = $_GET["rec_id"];
$id_etape = $_GET["eta_id"];

try
{
	$result_t_recette_etape = $bdd->query("delete from T_RECETTE_ETAPES WHERE ETA_ID=".$id_etape.";");

	$result_count = $bdd->query("SELECT count(1) FROM T_RECETTE_ETAPES WHERE ETA_ID=".$id_etape.";");
	$count = 0;

//Affichage de l'erreur SQL
	if ($result_t_recette_etape == TRUE && $count == 0) {
		//MAJ Timestamp
		include('../inc/maj_date_modif.inc.php');
		echo '<input type="hidden" name="result" id="result" value="succes"/>Etape supprimée avec succès !';
	}
	if ($count != 0)
		echo '<input type="hidden" name="result" id="result" value="echec"/>L\'étape n\'a pas pu être supprimée !';
}
catch(Exception $e)
{
	exit('<input type="hidden" name="result" id="result" value="echec"/>L\'étape n\'a pas pu être supprimée ! '. $e->getMessage());
}
?>