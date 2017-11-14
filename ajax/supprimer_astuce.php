<?PHP
/***********************************************************/
/***  ***/
/***********************************************************/
header("Content-Type: text/xml");

//Connexion à la Base MySQL
include('../admin/sql.php');


//id_recette
$id_astuce = $_GET["ras_id"];
$id_recette = $_GET["rec_id"];

try
{
	$result_t_recette_astuce = $bdd->query("delete from T_RECETTE_ASTUCES WHERE RAS_ID=".$id_astuce.";");

	$result_count = $bdd->query("SELECT count(1) FROM T_RECETTE_ASTUCES WHERE RAS_ID=".$id_astuce.";");
	$count = 0;

//Affichage de l'erreur SQL
	if ($result_t_recette_astuce == TRUE && $count == 0) {
		//MAJ Timestamp
		include('../inc/maj_date_modif.inc.php');
		echo '<input type="hidden" name="result" id="result" value="succes"/>Astuce supprimée avec succès !';
	}
	if ($count != 0)
		echo '<input type="hidden" name="result" id="result" value="echec"/>L\'astuce n\'a pas pu être supprimée !';
}
catch(Exception $e)
{
	exit('<input type="hidden" name="result" id="result" value="echec"/>L\'astuce n\'a pas pu être supprimée ! '. $e->getMessage());
}
?>