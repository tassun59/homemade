<?PHP
/***********************************************************/
/***  ***/
/***********************************************************/
header("Content-Type: text/xml");

//Connexion à la Base MySQL
include('../admin/sql.php');


$id_recette = $_GET["rec_id"];
$filename = $_GET["filename"];


//Affichage de l'erreur SQL
	if(unlink(".".$filename))
	   {
		die('<input type="hidden" name="result" id="result" value="succes"/>Success! File Deleted.');
	}else{
		die('<input type="hidden" name="result" id="result" value="echec"/>error deleting File!');
	}


?>