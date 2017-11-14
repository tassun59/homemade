<?PHP
/***********************************************************/
/***  ***/
/***********************************************************/
header("Content-Type: text/xml");

//Connexion à la Base MySQL
include('../admin/sql.php');


//id_recette
$id_recette = $_GET["rec_id"];
$id_astuce = $_GET["ras_id"];

try
{
	$result_t_recette_astuces = $bdd->query("INSERT INTO T_RECETTE_ASTUCES(REC_ID, RAS_ID) VALUES (".$id_recette.",".$id_astuce.");");

	$result_count = $bdd->query("SELECT count(1) FROM T_RECETTE_ASTUCES where REC_ID=".$id_recette." and RAS_ID = ".$id_astuce.";");
	$count = $result_count->rowCount();

//Affichage de l'erreur SQL
	if ($result_t_recette_astuces == TRUE && $count == 1) {
		//MAJ Timestamp
		include('../inc/maj_date_modif.inc.php');
		echo '<input type="hidden" name="result" id="result" value="succes"/>Astuce ajoutée avec succès !';
	}
	if ($count == 0)
		echo '<input type="hidden" name="result" id="result" value="echec"/>L\'astuce n\'a pas pu être ajoutée !';
}
catch(Exception $e)
{
	exit('<input type="hidden" name="result" id="result" value="echec"/>L\'astuce n\'a pas pu être ajoutée ! '. $e->getMessage());
}
?>