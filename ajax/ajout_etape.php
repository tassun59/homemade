<?PHP
/***********************************************************/
/***  ***/
/***********************************************************/
header("Content-Type: text/xml");

//Connexion à la Base MySQL
include('../admin/sql.php');


//id_recette
$id_recette = $_GET["rec_id"];
$id_etape = $_GET["eta_id"];

try
{
	$result_t_recette_etapes = $bdd->query("INSERT INTO T_RECETTE_ETAPES(REC_ID, ETA_ID) VALUES (".$id_recette.",".$id_etape.");");

	$result_count = $bdd->query("SELECT count(1) FROM T_RECETTE_ETAPES where REC_ID=".$id_recette." and ETA_ID = ".$id_etape.";");
	$count = $result_count->rowCount();

//Affichage de l'erreur SQL
	if ($result_t_recette_etapes == TRUE && $count == 1) {
		//MAJ Timestamp
		include('../inc/maj_date_modif.inc.php');
		echo '<input type="hidden" name="result" id="result" value="succes"/>Etape ajoutée avec succès !';
	}
	if ($count == 0)
		echo '<input type="hidden" name="result" id="result" value="echec"/>L\'étape n\'a pas pu être ajoutée !';
}
catch(Exception $e)
{
	exit('<input type="hidden" name="result" id="result" value="echec"/>L\'étape n\'a pas pu être ajoutée ! '. $e->getMessage());
}
?>