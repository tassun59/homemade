<?PHP
/***********************************************************/
/***  ***/
/***********************************************************/
header("Content-Type: text/xml");

//Connexion à la Base MySQL
include('../admin/sql.php');


//id_recette
$mat_id = $_POST["mat_id"];
$id_recette = $_POST["rec_id"];
$nom_champ = strtoupper($_POST["nom_champ"]);
$valeur = $_POST["valeur"];
$type = $_POST["type"];

try
{
	if($type == "I")
	{
		//Préparer la requête pour la rendre dynamique
		$result_t_recette_materiel = $bdd->prepare("insert into T_RECETTE_MATERIEL (MAT_ID, REC_ID) values (:mat_id, :id_recette);");
		$result_t_recette_materiel->bindParam(":mat_id",$valeur);
		$result_t_recette_materiel->bindParam(":id_recette",$id_recette);
		$result_t_recette_materiel->execute();

		//Le chmap n\'a pas pu être mis à jour
		//$result_t_test_recette = $bdd->query("SELECT ".$nom_champ." FROM T_RECETTE where REC_ID=".$id_recette.";");
		$result_t_test_recette_materiel = $bdd->prepare("SELECT ".$nom_champ." FROM T_RECETTE_MATERIEL where REC_ID=:id_recette and mat_id=:mat_id;");
		$result_t_test_recette_materiel->bindParam(":mat_id",$valeur);
		$result_t_test_recette_materiel->bindParam(":id_recette",$id_recette);
		$result_t_test_recette_materiel->execute();

	//Affichage de l'erreur SQL
		if ($result_t_recette_materiel == TRUE && $result_t_test_recette_materiel->rowCount() == 1) {
			echo '<input type="hidden" name="result" id="result" value="succes"/>Matériel ajouté avec succès !';
		}
		if ($result_t_recette_materiel == FALSE || $result_t_test_recette_materiel->rowCount() == 0)
			echo '<input type="hidden" name="result" id="result" value="echec"/>Le matériel ne peut pas être ajouté !';
	}
	else
	{
		//Préparer la requête pour la rendre dynamique
		$result_t_recette_materiel = $bdd->prepare("delete from T_RECETTE_MATERIEL where MAT_ID=:mat_id and rec_id=:id_recette;");
		$result_t_recette_materiel->bindParam(":mat_id",$valeur);
		$result_t_recette_materiel->bindParam(":id_recette",$id_recette);
		$result_t_recette_materiel->execute();

		//Le chmap n\'a pas pu être mis à jour
		//$result_t_test_recette = $bdd->query("SELECT ".$nom_champ." FROM T_RECETTE where REC_ID=".$id_recette.";");
		$result_t_test_recette_materiel = $bdd->prepare("SELECT ".$nom_champ." FROM T_RECETTE_MATERIEL where REC_ID=:id_recette and mat_id=:mat_id;");
		$result_t_test_recette_materiel->bindParam(":mat_id",$valeur);
		$result_t_test_recette_materiel->bindParam(":id_recette",$id_recette);
		$result_t_test_recette_materiel->execute();
		$test_recette = $result_t_test_recette_materiel->fetch(PDO::FETCH_OBJ);

	//Affichage de l'erreur SQL
		if ($result_t_recette_materiel == TRUE && $result_t_test_recette_materiel->rowCount() == 0) {
			//MAJ Timestamp
			include('../inc/maj_date_modif.inc.php');
			echo '<input type="hidden" name="result" id="result" value="succes"/>Matériel supprimé avec succès !';
		}
		if ($result_t_recette_materiel == FALSE || $result_t_test_recette_materiel->rowCount() == 1)
			echo '<input type="hidden" name="result" id="result" value="echec"/>Le matériel ne peut pas être supprimé !';
	}
}
catch(Exception $e)
{
	exit('<input type="hidden" name="result" id="result" value="echec"/>Le matériel ne peut pas être mis à jour ! '. $e->getMessage());
}
?>