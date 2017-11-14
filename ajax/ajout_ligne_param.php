<?PHP
/***********************************************************/
/***  ***/
/***********************************************************/
header("Content-Type: text/xml");

//Connexion à la Base MySQL
include('../admin/sql.php');


//id_recette
$chpAUpdater = $_GET["chpAUpdater"];
$valeur = $_GET["valeur"];
$NomTable = $_GET["NomTable"];

try
{

	//Préparer la requête pour la rendre dynamique
	$result_t_param = $bdd->prepare("INSERT INTO ".$NomTable." (".$chpAUpdater.") value (:valeur);");
	$result_t_param->bindParam(":valeur",$valeur);
	$result_t_param->execute();
	
	
	$result_count = $bdd->prepare("SELECT count(1) FROM ".$NomTable." where ".$chpAUpdater." = :valeur;");
	$result_count->bindParam(":valeur",$valeur);
	$result_count->execute();
	$count = $result_count->rowCount();

//Affichage de l'erreur SQL
	if ($result_t_param == TRUE && $count == 1) {
		//MAJ Timestamp
		include('../inc/maj_date_modif.inc.php');
		echo '<input type="hidden" name="result" id="result" value="succes"/>paramètre ajouté avec succès !';
	}
	if ($count == 0)
		echo '<input type="hidden" name="result" id="result" value="echec"/>Le paramètre n\'a pas pu être ajouté !';
}
catch(Exception $e)
{
	exit('<input type="hidden" name="result" id="result" value="echec"/>Le paramètre n\'a pas pu être ajouté ! '. $e->getMessage());
}
?>