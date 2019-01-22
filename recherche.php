<!DOCTYPE html>

<?php

include('admin/sql.php');

//Récupération données ingrédients
$result_t_type_ingredients = $bdd->query("select TIN_ID, TIN_LIBELLE FROM T_TYPE_INGREDIENT order by TIN_ID");
$type_ingredients = $result_t_type_ingredients->fetchAll(PDO::FETCH_ASSOC);

$result_t_ingredients_all = $bdd->query("select ING_ID, ING_LIBELLE FROM T_INGREDIENT order by ING_ID");
$count_ingredients = $result_t_ingredients_all->rowCount();

//Récupération données catégories
$result_t_themes = $bdd->query("select EVE_ID, EVE_TITRE FROM T_EVENEMENT order by EVE_ID");
$themes = $result_t_themes->fetchAll(PDO::FETCH_ASSOC);

//Récupération données catégories
$result_t_categories = $bdd->query("select CAT_ID, CAT_TITRE FROM T_CATEGORIE order by CAT_ORDRE_AFF");
$categories = $result_t_categories->fetchAll(PDO::FETCH_ASSOC);

//Récupération données budgets
$result_t_budgets = $bdd->query("select BUD_ID, BUD_LIBELLE FROM T_BUDGET order by BUD_ID");
$budgets = $result_t_budgets->fetchAll(PDO::FETCH_ASSOC);


//Récupération données niveaux
$result_t_niveaux = $bdd->query("select NIV_ID, NIV_LIBELLE FROM T_NIVEAU order by NIV_ID");
$niveaux = $result_t_niveaux->fetchAll(PDO::FETCH_ASSOC);

$v_requete = '';

if (isset($_POST['valider']))
{
	$v_requete = "select REC_ID, REC_TITRE, REC_CATEGORIE, REC_SOUS_CATEGORIE, REC_NIVEAU, REC_BUDGET, REC_TPS_PREPA, REC_TPS_REPOS, REC_TPS_CUISSON, REC_NB_CONVIVES, REC_NB_REALISATIONS, REC_DATE_CREATION, REC_DATE_MODIF, REC_ID_EVENEMENT, REC_ID_LIEU, REC_TAG, REC_ID_SOURCE, REC_LIEN_SOURCE, REC_FAVORI, REC_IMG_PRINC FROM T_RECETTE where 1=1";
	if (isset($_POST['titre']) && !empty($_POST['titre']))
	{
		$v_requete = $v_requete." AND REC_TITRE=:rec_titre";
	}
	if (isset($_POST['categorie']) && !empty($_POST['categorie']))
	{
		$v_requete = $v_requete." AND REC_CATEGORIE=:categorie";
	}
	if (isset($_POST['souscategorie']) && !empty($_POST['souscategorie']))
	{
		$v_requete = $v_requete." AND REC_SOUS_CATEGORIE=:souscategorie";
	}
	if (isset($_POST['evenement']) && !empty($_POST['evenement']))
	{
		$v_requete = $v_requete." AND REC_ID_EVENEMENT=:evenement";
	}
	if (isset($_POST['favori']) && !empty($_POST['favori']))
	{
		$v_requete = $v_requete." AND REC_FAVORI=:favori";
	}
	if (isset($_POST['tag']) && !empty($_POST['tag']))
	{
		$v_requete = $v_requete." AND REC_TAG like CONCAT('%',:tag,'%')";
	}
	if (isset($_POST['niveau']) && !empty($_POST['niveau']))
	{
		$v_requete = $v_requete." AND REC_NIVEAU=:niveau";
	}
	if (isset($_POST['budget']) && !empty($_POST['budget']))
	{
		$v_requete = $v_requete." AND REC_BUDGET=:budget";
	}
	if (isset($_POST['ingredients']) && !empty($_POST['ingredients']))
	{
		$v_requete = $v_requete." AND REC_ID in (select rec_id from (select count(1) nb_ing, c.rec_id from (SELECT rec_id, ing_id FROM T_RECETTE_INGREDIENTS WHERE ing_id in (".$_POST['ingredients'].") group by rec_id, ing_id) c group by c.rec_id) d where d.nb_ing=:nbingredients)";
	}
	//Préparer la requête pour la liste de recette
	$result_t_recettes = $bdd->prepare($v_requete);
	if (isset($_POST['titre']) && !empty($_POST['titre']))
	{
		$result_t_recettes->bindParam(":rec_titre",$_POST['titre']);
	}
	if (isset($_POST['categorie']) && !empty($_POST['categorie']))
	{
		$result_t_recettes->bindParam(":categorie",$_POST['categorie']);
	}
	if (isset($_POST['souscategorie']) && !empty($_POST['souscategorie']))
	{
		$result_t_recettes->bindParam(":souscategorie",$_POST['souscategorie']);
	}
	if (isset($_POST['evenement']) && !empty($_POST['evenement']))
	{
		$result_t_recettes->bindParam(":evenement",$_POST['evenement']);
	}
	if (isset($_POST['favori']) && !empty($_POST['favori']))
	{
		$result_t_recettes->bindParam(":favori",$_POST['favori']);
	}
	if (isset($_POST['tag']) && !empty($_POST['tag']))
	{
		$result_t_recettes->bindParam(":tag",$_POST['tag']);
	}
	if (isset($_POST['niveau']) && !empty($_POST['niveau']))
	{
		$result_t_recettes->bindParam(":niveau",$_POST['niveau']);
	}
	if (isset($_POST['budget']) && !empty($_POST['budget']))
	{
		$result_t_recettes->bindParam(":budget",$_POST['budget']);
	}
	if (isset($_POST['ingredients']) && !empty($_POST['ingredients']))
	{
		//$result_t_recettes->bindParam(":ingredients",$_POST['ingredients']);
		$result_t_recettes->bindParam(":nbingredients",$_POST['nbingredients']);
	}
	$result_t_recettes->execute();
	$recettes = $result_t_recettes->fetchAll(PDO::FETCH_ASSOC);
	//$recettes_count = $result_t_recettes->rowCount();
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
	<!-- Javascripts commun a toutes les pages -->
	<script type="text/javascript" src="js/commun.js"></script>
	<!-- Style menu -->
	<link rel="stylesheet" href="css/menu/style.css" type="text/css" media="screen">
	
	<!-- Style page -->
	<link rel="stylesheet" type="text/css" href="css/style_commun.css">
	<link rel="stylesheet" type="text/css" media="screen and (min-width:801px)" href="css/style.css">
	<link rel="stylesheet" type="text/css" media="screen and (max-width:800px)" href="css/style_max_800.css">
	<link rel="stylesheet" type="text/css" media="screen and (max-width:600px)" href="css/style_max_600.css">
	<link rel="stylesheet" type="text/css" media="print" href="css/style_print.css"/>	
	
	
	<!-- AJAX -->
	<script src="js/ajax/oXHR.js"></script>
		
	
	<!-- menu -->
    <link rel="stylesheet" href="font/menu/css/font-awesome.css" >
	
 
	
<script src="js/menu/menu.js" type="text/javascript"></script> 

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

 </header>
 <main>
	<?php include('inc/bandeau_entete.inc.php'); ?>

	<header>
		<div id="titre_recherche">
			<h1>Recherche</h1>
		</div>
	</header>
	<br/><br/>
	<section id="recherche_formulaire_recettes" class="recherche_formulaire_recettes">
		<div id="recherche_recettes">
			<form method="post">
				<div id="titre"><!--<?php echo $recettes_count;?>-->
					<div class="titre_champ_recherche">
						Titre
					</div>
					<div class="champ_recherche">
						<input type="text" name = "titre" id = "titre" value="<?php if (isset($_POST['titre']) && !empty($_POST['titre'])) echo $_POST['titre'];?>"/>
					</div>
				</div>
				<div id="categorie">
					<div class="titre_champ_recherche">
						Catégorie
					</div>
					<div class="champ_recherche">
						<select name = "categorie" id = "categorie" onchange="recup_sous_categorie('souscategorie', this.value);">
							<option/>
							<?php
								foreach ($categories as $row_categories)
								{?>
									<option value="<?php echo $row_categories['CAT_ID']; ?>" <?php if(isset($_POST['categorie']) && !empty($_POST['categorie']) && $row_categories['CAT_ID'] == $_POST['categorie']) {echo ' selected="selected"';} ?>><?php echo $row_categories['CAT_TITRE']; ?></option>
							<?php	}
							?>	
						</select>
					</div>
				</div>
				<div id="sousCategorie">
					<div class="titre_champ_recherche">
						Sous-catégorie
					</div>
					<div id="souscategorie" class="champ_recherche">
						<select name = "souscategorie" id = "souscategorie">
							<option/>
						</select>
					</div>
				</div>
				<div id="theme">
					<div class="titre_champ_recherche">
						Type d'évènement
					</div>
					<div class="champ_recherche">
						<select name = "evenement" id = "evenement">
							<option/>
							<?php
								foreach ($themes as $row_themes)
								{?>
									<option value="<?php echo $row_themes['EVE_ID']; ?>" <?php if(isset($_POST['evenement']) && !empty($_POST['evenement']) && $row_themes['EVE_ID'] == $_POST['evenement']) {echo ' selected="selected"';} ?>><?php echo $row_themes['EVE_TITRE']; ?></option>
							<?php	}
							?>	
						</select>
					</div>
				</div>
				<div id="favori">
					<div class="titre_champ_recherche">
						Favori
					</div>
					<div class="champ_recherche">
						<select name="favori" id="favori">
							<option/>
							<option value="0" <?php if(isset($_POST['favori']) && !empty($_POST['favori']) && 0 == $_POST['favori']) {echo ' selected="selected"';} ?>>Non</option>
							<option value="1" <?php if(isset($_POST['favori']) && !empty($_POST['favori']) && 1 == $_POST['favori']) {echo ' selected="selected"';} ?>>Oui</option>
						</select>
					</div>
				</div>
				<div id="tag">
					<div class="titre_champ_recherche">
						Mots-clés
					</div>
					<div class="champ_recherche">
						<input type="text" name = "tag" id = "tag" value="<?php if (isset($_POST['tag']) && !empty($_POST['tag'])) echo $_POST['tag'];?>"/>
					</div>
				</div>
				<div id="niveau">
					<div class="titre_champ_recherche">
						Niveau de difficulté
					</div>
					<div class="champ_recherche">
						<select name = "niveau" id = "niveau">
							<option/>
							<?php
								foreach ($niveaux as $row_niveaux)
								{?>
									<option value="<?php echo $row_niveaux['NIV_ID']; ?>" <?php if(isset($_POST['niveau']) && !empty($_POST['niveau']) && $row_niveaux['NIV_ID'] == $_POST['niveau']) {echo ' selected="selected"';} ?>><?php echo $row_niveaux['NIV_LIBELLE']; ?></option>
							<?php	}
							?>	
						</select>
					</div>
				</div>
				<div id="budget">
					<div class="titre_champ_recherche">
						Budget
					</div>
					<div class="champ_recherche">
						<select name = "budget" id = "budget">
							<option/>
							<?php
								foreach ($budgets as $row_budgets)
								{?>
									<option value="<?php echo $row_budgets['BUD_ID']; ?>" <?php if(isset($_POST['budget']) && !empty($_POST['budget']) && $row_budgets['BUD_ID'] == $_POST['budget']) {echo ' selected="selected"';} ?>><?php echo $row_budgets['BUD_LIBELLE']; ?></option>
							<?php	}
							?>	
						</select>
					</div>
				</div>
				<div id="type_ingredient">
					<!--  REQUETE POUR LA RECHERCHE D'INGREDIENTS
					select rec_id from (select count(1) nb_ing, c.rec_id from (SELECT rec_id, ing_id FROM `t_recette_ingredients` WHERE ing_id in (3,14) group by rec_id, ing_id) c group by c.rec_id) d where d.nb_ing=2-->
					<div class="titre_champ_recherche">
						Ingrédients
					</div>
					<div class="champ_recherche_ingredient">
					<input type="hidden" name="ingredients" id="ingredients" value=""/>
					<input type="hidden" name="nbingredients" id="nbingredients" value=""/>
						<?php
						$i = 1;
						foreach ($type_ingredients as $row_type_ingredients)
						{
						?>
							<div id="recherche_type_ingredient">
								<?php
									echo '<div id="recherche_type_ingredient_entete-'.$row_type_ingredients['TIN_ID'].'" onclick="montrerCacher(\'recherche_type_ingredient_liste-'.$row_type_ingredients['TIN_ID'].'\');">';
									echo $row_type_ingredients['TIN_LIBELLE'];
									echo '</div>';

							//Récupération données ingrédients
							echo '<div id="recherche_type_ingredient_liste-'.$row_type_ingredients['TIN_ID'].'">';
							$result_t_ingredients = $bdd->prepare("select ING_ID, ING_LIBELLE FROM T_INGREDIENT where TIN_ID=:id_type_ingredient order by ING_ID;");
							$result_t_ingredients->bindParam(":id_type_ingredient",$row_type_ingredients['TIN_ID']);
							$result_t_ingredients->execute();
							$ingredients = $result_t_ingredients->fetchAll(PDO::FETCH_ASSOC);
							
							foreach ($ingredients as $row_ingredients)
							{
								?>
								<div id="recherche_ingredient">
									<input type="checkbox" name="ingredient-<?php echo $i; ?>"  id="ingredient-<?php echo $i; ?>" value="<?php echo $row_ingredients['ING_ID']; ?>" onclick="concatener('ingredient-',<?php echo $count_ingredients; ?>);"> <label for="ingredient-<?php echo $i; ?>"><?php echo $row_ingredients['ING_LIBELLE']; ?></label>
								</div>
								<?php 
								$i = $i + 1;
							}
							echo '</div>';

						echo '</div>';
						}
						?>
					<!--<input name="recherche_formulaire_recettes" type="text" id="accueil_input_recherche" placeholder="Parmi les recettes et vidéos">
					<input type="image" name="Valid" id="Valid" src="images" onclick="alert('A METTRE EN PLACE');">-->
					</div>
				</div>
				<div id="bouton_formulaire">
					<input type="submit" id="valider" name="valider" value="Rechercher"/>
				</div>
			</form>
		</div>
	</section>	

	<?php if($v_requete != null) {include('inc/liste_recettes.inc.php');} ?>
	
 </main>

</body>
</html>