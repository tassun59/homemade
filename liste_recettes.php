<!DOCTYPE html>

<?php

include('admin/sql.php');


if (isset($_GET['sous_categorie']))
{
	$v_sous_categorie = $_GET['sous_categorie'];
	//Récupération données sous catégories
	$result_t_sous_categorie = $bdd->query("select SCA_ID, CAT_ID, SCA_TITRE FROM T_SOUS_CATEGORIE where SCA_ID=".$v_sous_categorie.";");
	$sous_categorie = $result_t_sous_categorie->fetch(PDO::FETCH_OBJ);


	//Récupération données catégories
	$result_t_categorie = $bdd->prepare("select CAT_ID, CAT_TITRE FROM T_CATEGORIE where CAT_ID=:categorie_id");
	$result_t_categorie->bindParam(":categorie_id",$sous_categorie->CAT_ID);
	$result_t_categorie->execute();
	$categorie = $result_t_categorie->fetch(PDO::FETCH_OBJ);



	//Préparer la requête pour la liste de recette
	$result_t_recettes = $bdd->prepare("select REC_ID, REC_TITRE, REC_CATEGORIE, REC_SOUS_CATEGORIE, REC_NIVEAU, REC_BUDGET, REC_TPS_PREPA, REC_TPS_REPOS, REC_TPS_CUISSON, REC_NB_CONVIVES, REC_NB_REALISATIONS, REC_DATE_CREATION, REC_DATE_MODIF, REC_ID_EVENEMENT, REC_ID_LIEU, REC_TAG, REC_ID_SOURCE, REC_LIEN_SOURCE, REC_FAVORI, REC_IMG_PRINC FROM T_RECETTE where REC_SOUS_CATEGORIE=:sous_categorie_id");
	$result_t_recettes->bindParam(":sous_categorie_id",$sous_categorie->SCA_ID);
	$result_t_recettes->execute();
	$recettes = $result_t_recettes->fetchAll(PDO::FETCH_ASSOC);
}

if (isset($_GET['theme']))
{
	$v_theme = $_GET['theme'];
	//Récupération données catégories
	$result_t_evenement = $bdd->query("select EVE_ID, EVE_TITRE FROM T_EVENEMENT where EVE_ID=".$v_theme.";");
	$evenement = $result_t_evenement->fetch(PDO::FETCH_OBJ);




	//Préparer la requête pour la liste de recette
	$result_t_recettes = $bdd->prepare("select REC_ID, REC_TITRE, REC_CATEGORIE, REC_SOUS_CATEGORIE, REC_NIVEAU, REC_BUDGET, REC_TPS_PREPA, REC_TPS_REPOS, REC_TPS_CUISSON, REC_NB_CONVIVES, REC_NB_REALISATIONS, REC_DATE_CREATION, REC_DATE_MODIF, REC_ID_EVENEMENT, REC_ID_LIEU, REC_TAG, REC_ID_SOURCE, REC_LIEN_SOURCE, REC_FAVORI, REC_IMG_PRINC FROM T_RECETTE where REC_ID_EVENEMENT=:evenement");
	$result_t_recettes->bindParam(":evenement",$v_theme);
	$result_t_recettes->execute();
	$recettes = $result_t_recettes->fetchAll(PDO::FETCH_ASSOC);

}

if (isset($_GET['ingredient']))
{
	$v_ingredient = $_GET['ingredient'];
	
	//Récupération données catégories
	$result_t_ingredient = $bdd->prepare("select ING_ID, ING_LIBELLE FROM T_INGREDIENT where ING_ID=:ingredient;");
	$result_t_ingredient->bindParam(":ingredient",$v_ingredient);
	$result_t_ingredient->execute();
	$ingredient = $result_t_ingredient->fetch(PDO::FETCH_OBJ);
	
	
	
	//Préparer la requête pour la liste de recette
	$result_t_recettes = $bdd->prepare("select REC_ID, REC_TITRE, REC_CATEGORIE, REC_SOUS_CATEGORIE, REC_NIVEAU, REC_BUDGET, REC_TPS_PREPA, REC_TPS_REPOS, REC_TPS_CUISSON, REC_NB_CONVIVES, REC_NB_REALISATIONS, REC_DATE_CREATION, REC_DATE_MODIF, REC_ID_EVENEMENT, REC_ID_LIEU, REC_TAG, REC_ID_SOURCE, REC_LIEN_SOURCE, REC_FAVORI, REC_IMG_PRINC FROM T_RECETTE where exists (SELECT 1 FROM T_RECETTE_INGREDIENTS where REC_ID = T_RECETTE.REC_ID and ING_ID = :ingredient)");
	$result_t_recettes->bindParam(":ingredient",$v_ingredient);
	$result_t_recettes->execute();
	$recettes = $result_t_recettes->fetchAll(PDO::FETCH_ASSOC);
}
?>

<!--[if lt IE 7 ]><html class="ie ie6" lang="en"> <![endif]-->
<!--[if IE 7 ]><html class="ie ie7" lang="en"> <![endif]-->
<!--[if IE 8 ]><html class="ie ie8" lang="en"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!--><html lang="en"> <!--<![endif]-->
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
   <meta charset="utf-8">
    <title>Home Made</title>
    <link rel="icon" type="image/png" href="images/icone.png" />
	
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

	
	<!-- Tooltip -->
	<link rel="stylesheet" type="text/css" href="css/tooltipster/tooltipster.bundle.min.css" />
    <script type="text/javascript" src="http://code.jquery.com/jquery-1.10.0.min.js"></script>
    <script type="text/javascript" src="js/tooltipster/tooltipster.bundle.min.js"></script>
	
	<!-- Style menu -->
	<link rel="stylesheet" href="css/menu/style.css" type="text/css" media="screen">
	
	<!-- Style page -->
	<link rel="stylesheet" type="text/css" href="css/style_commun.css">
	<link rel="stylesheet" type="text/css" media="screen and (min-width:801px)" href="css/style.css">
	<link rel="stylesheet" type="text/css" media="screen and (max-width:800px)" href="css/style_max_800.css">
	<link rel="stylesheet" type="text/css" media="screen and (max-width:600px)" href="css/style_max_600.css">
	<link rel="stylesheet" type="text/css" media="print" href="css/style_print.css"/>	
	
	<!-- menu -->
    <link rel="stylesheet" href="font/menu/css/font-awesome.css" >
	
 
	
	<script src="js/menu/menu.js" type="text/javascript"></script> 
	<!-- Javascripts commun a toutes les pages -->
	<script type="text/javascript" src="js/commun.js"></script>	
	<script>
        $(document).ready(function() {
            $('.tooltip').tooltipster();
        });
		
		
    </script>

	
	<script>
        function masquer_afficher(lien, lien2){
			document.getElementById(lien).style.display='none';
			document.getElementById(lien2).style.display='block';
		}
		
		window.addEventListener("scroll", scrolled, false);
    </script>
		
	<script src="js/recette.js" type="text/javascript"></script>
</head>
  
 <body>

	<header>
	 <!--Menu MainWrap-->
	 <?php include('inc/menu.inc.php'); ?>
	 <!--end menu MainWrap-->

<!-- Barre recherche -->
<!--<div class="slider2 slider--right" id="right">
  <p><input type="search"><input type ="button" id="button_search" value="Ok"/><a class="lien_discret" href="#">Recherche avancée ...<a/></p>
</div>-->

	 <?php include('inc/bandeau_entete.inc.php'); ?>
<div class="fil_ariane">
 	<nav>
		<a href="#">Accueil</a> > <a href="#">Recettes</a> >
		<?php 
			if (isset($_GET['sous_categorie']))
			{
		?>
			 <?php echo $categorie->CAT_TITRE; ?>  > <?php echo $sous_categorie->SCA_TITRE; ?>
		<?php 
			}
		?>
		<?php 
			if (isset($_GET['theme']))
			{
		?>
			 <?php echo $evenement->EVE_TITRE; ?>
		<?php 
			}
		?>
	</nav>
</div>

<br/>

 </header>
 <main>
	<header>
		<div class="titre_recette">
			<h1>
				<?php 
					if (isset($_GET['sous_categorie']))
					{
				?>
					 <?php echo $sous_categorie->SCA_TITRE; ?>
				<?php 
					}
				?>
				<?php 
					if (isset($_GET['theme']))
					{
				?>
					 <?php echo $evenement->EVE_TITRE; ?>
				<?php 
					}
				?>

			</h1>
			<p>Toutes mes recettes :</p>
		</div>
	</header>

	<?php include('inc/liste_recettes.inc.php'); ?>

 </main>

</body>
</html>