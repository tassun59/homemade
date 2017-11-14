<?PHP
/***********************************************************/
/***  ***/
/***********************************************************/
header("Content-Type: text/xml");

//Connexion à la Base MySQL
include('../admin/sql.php');


//id_recette
$rie_id = $_GET["rie_id"];
$id_recette = $_GET["rec_id"];
$ing_id = $_GET["ing_id"];

try
{
	//Préparer la requête pour la rendre dynamique
	$result_t_recette_materiel = $bdd->prepare("select max(RIN_ID) max from T_RECETTE_INGREDIENTS where REC_ID = :id_recette and RIE_ID = :rie_id and ING_ID = :ing_id;");
	$result_t_recette_materiel->bindParam(":id_recette",$id_recette);
	$result_t_recette_materiel->bindParam(":rie_id",$rie_id);
	$result_t_recette_materiel->bindParam(":ing_id",$ing_id);
	$result_t_recette_materiel->execute();
	$t_recette_materiel = $result_t_recette_materiel->fetch(PDO::FETCH_OBJ);


//Affichage de l'erreur SQL
	if ($result_t_recette_materiel == TRUE) {
		echo '<input type="text" name="rin_id" id="rin_id" value="'.$t_recette_materiel->max.'"/><input type="hidden" name="result" id="result" value="succes"/>Récupération RIN_ID avec succès !';
	}
	if ($result_t_recette_materiel == FALSE)
		echo '<input type="hidden" name="result" id="result" value="echec"/>Echec Récupération RIN_ID !';
}
catch(Exception $e)
{
	exit('<input type="hidden" name="result" id="result" value="echec"/>Echec Récupération RIN_ID ! '. $e->getMessage());
}
?>