<?PHP
/***********************************************************/
/***  ***/
/***********************************************************/
header("Content-Type: text/xml");

//Connexion à la Base MySQL
include('../admin/sql.php');


$valeur = $_GET["id_param"];
$NomTable = $_GET["NomTable"];
$chpId = $_GET["chpId"];

try
{
	$result_t_ligne_param = $bdd->prepare("delete from ".$NomTable." WHERE ".$chpId."=:valeur;");
	$result_t_ligne_param->bindParam(":valeur",$valeur);
	$result_t_ligne_param->execute();
	$count = $result_t_ligne_param->rowCount();


//Affichage de l'erreur SQL
	if ($result_t_ligne_param == TRUE && $count == 1) {
		//MAJ Timestamp
		echo '<input type="hidden" name="result" id="result" value="succes"/>ligne supprimée avec succès !';
	}
	if ($count != 1)
		echo '<input type="hidden" name="result" id="result" value="echec"/>'. $count .' ---- La ligne n\'a pas pu être supprimée !';
}
catch(Exception $e)
{
	exit('<input type="hidden" name="result" id="result" value="echec"/>La ligne n\'a pas pu être supprimée ! '. $e->getMessage());
}
?>