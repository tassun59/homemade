<?PHP
/***********************************************************/
/***  ***/
/***********************************************************/
header("Content-Type: text/xml");

//Connexion à la Base MySQL
include('../admin/sql.php');
$id_recette='';
if (isset($_GET["rec_id"]))
{
	$id_recette = $_GET["rec_id"];
}
$id_recette_categorie = $_GET["cat_id"];


try
{
	$result_t_sous_categories = $bdd->query("select SCA_ID, SCA_TITRE from T_SOUS_CATEGORIE where CAT_ID=".$id_recette_categorie.";");
	$sous_categories = $result_t_sous_categories->fetchAll(PDO::FETCH_ASSOC);


//Affichage de l'erreur SQL
	if ($result_t_sous_categories == TRUE) {
		
		if ($id_recette!='')
		{
			echo '<select name = "REC_SOUS_CATEGORIE" id = "REC_SOUS_CATEGORIE" onchange="Update_champ_recette(this.id, this.value, '.$id_recette.')">
								<option/>';
		}
		else
		{
			echo '<select name = "REC_SOUS_CATEGORIE" id = "REC_SOUS_CATEGORIE">
								<option/>';
		}
								
		foreach ($sous_categories as $row_sous_categories)
		{
			echo '<option value="'. $row_sous_categories['SCA_ID'] .'">'.$row_sous_categories['SCA_TITRE'] .'</option>';
		}
				
		echo'</select>';
	}
}
catch(Exception $e)
{
	exit('Erreur de recuperation sous categorie ! '. $e->getMessage());
}
?>