<?PHP
/***********************************************************/
/***  ***/
/***********************************************************/
header("Content-Type: text/xml");

//Connexion à la Base MySQL
include('../admin/sql.php');


$chpAUpdater = $_GET["chpAUpdater"];
$valeur = $_GET["valeur"];
$NomTable = $_GET["NomTable"];
$chpId = $_GET["chpId"];

try
{
	//Préparer la requête pour la rendre dynamique
	$result_t_param = $bdd->prepare("select max(".$chpId.") max from ".$NomTable." where ".$chpAUpdater." = :valeur;");
	$result_t_param->bindParam(":valeur",$valeur);
	$result_t_param->execute();
	$t_param = $result_t_param->fetch(PDO::FETCH_OBJ);


//Affichage de l'erreur SQL
	if ($result_t_param == TRUE) {
		echo '<input type="hidden" name="id_param" id="id_param" value="'.$t_param->max.'"/><input type="hidden" name="result" id="result" value="succes"/>Récupération id_param avec succès !';
	}
	if ($result_t_param == FALSE)
		echo '<input type="hidden" name="result" id="result" value="echec"/>Echec Récupération id_param !';
}
catch(Exception $e)
{
	exit('<input type="hidden" name="result" id="result" value="echec"/>Echec Récupération id_param ! '. $e->getMessage());
}
?>