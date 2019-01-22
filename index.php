<!DOCTYPE html>

<?php

include('admin/sql.php');



//Préparer la requête pour la liste de recette
$result_t_recettes = $bdd->prepare("select REC_ID, REC_TITRE, REC_CATEGORIE, REC_SOUS_CATEGORIE, REC_NIVEAU, REC_BUDGET, REC_TPS_PREPA, REC_TPS_REPOS, REC_TPS_CUISSON, REC_NB_CONVIVES, REC_NB_REALISATIONS, REC_DATE_CREATION, REC_DATE_MODIF, REC_ID_EVENEMENT, REC_ID_LIEU, REC_TAG, REC_ID_SOURCE, REC_LIEN_SOURCE, REC_FAVORI,REC_IMG_PRINC FROM T_RECETTE order by REC_DATE_MODIF DESC LIMIT 7");
$result_t_recettes->execute();
$recettes = $result_t_recettes->fetchAll(PDO::FETCH_ASSOC);



//Récupération données catégories
$result_t_categories = $bdd->query("select CAT_ID, CAT_TITRE FROM T_CATEGORIE order by CAT_ORDRE_AFF");
$categories = $result_t_categories->fetchAll(PDO::FETCH_ASSOC);

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
	
	
	<link href="https://fonts.googleapis.com/css?family=Poor+Story" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Roboto|Roboto+Slab" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Acme|Montserrat:700" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Comfortaa|Kalam" rel="stylesheet">
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

	<section id="Accueil_recettes" class="Accueil_recettes">
		
			<div id="accueil_recette_new">
				<div id="accueil_contenu_recette_new">
					<div id="accueil_titre_recette_new">
						Créer une nouvelle recette
					</div>
					<div class="triangle_new"></div>
					<div id="creation_recette">
						<script>
						$("body").on("change","#rec_sous_categorie",function(){
							   alert("clicked");
							});
						</script>
						Catégorie:&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;
						<select name ="rec_categorie" id = "rec_categorie" onchange="recup_sous_categorie('sous_categorie',this.value);">
							<option/>
							<?php
								foreach ($categories as $row_categories)
								{?>
									<option value="<?php echo $row_categories['CAT_ID']; ?>"><?php echo $row_categories['CAT_TITRE']; ?></option>
							<?php	}
							?>	
						</select>
						<br/>
						<br/>
						Sous-catégorie:&#160;
						<span id="sous_categorie">
							<select name = "rec_sous_categorie" id = "rec_sous_categorie">
							<option/>	
						</select></span>

					</div>
					<br/>
					<div id="bouton_creation_recette">
						<a href="javascript:creer();">+ Ajouter une nouvelle recette</a>
					</div>

				</div>
			</div>
		
		
		<?php 
		
			foreach ($recettes as $row_recettes)
				{
					$recette_id =  $row_recettes['REC_ID'];
					$recette_titre =  $row_recettes['REC_TITRE'];
					$recette_categorie =  $row_recettes['REC_CATEGORIE'];
					$recette_sous_categorie =  $row_recettes['REC_SOUS_CATEGORIE'];
					$recette_niveau =  $row_recettes['REC_NIVEAU'];
					$recette_budget =  $row_recettes['REC_BUDGET'];
					$recette_tps_prepa =  $row_recettes['REC_TPS_PREPA'];
					$recette_tps_repos =  $row_recettes['REC_TPS_REPOS'];
					$recette_tps_cuisson =  $row_recettes['REC_TPS_CUISSON'];
					$recette_nb_convives =  $row_recettes['REC_NB_CONVIVES'];
					$recette_nb_réalisations =  $row_recettes['REC_NB_REALISATIONS'];
					$recette_date_creation =  $row_recettes['REC_DATE_CREATION'];
					$recette_date_modif =  $row_recettes['REC_DATE_MODIF'];
					$recette_id_evenement =  $row_recettes['REC_ID_EVENEMENT'];
					$recette_id_lieu =  $row_recettes['REC_ID_LIEU'];
					$recette_tag =  $row_recettes['REC_TAG'];
					$recette_id_source =  $row_recettes['REC_ID_SOURCE'];
					$recette_lien_source =  $row_recettes['REC_LIEN_SOURCE'];
					$recette_favori =  $row_recettes['REC_FAVORI'];
					$recette_image_principale =  $row_recettes['REC_IMG_PRINC'];
					
					
					//Récupération données budgets
					$result_t_budget = $bdd->prepare("select BUD_ID, BUD_LIBELLE FROM T_BUDGET where BUD_ID=:budget_id");
					$result_t_budget->bindParam(":budget_id",$recette_budget);
					$result_t_budget->execute();
					$budget = $result_t_budget->fetch(PDO::FETCH_OBJ);
					
					


					//Récupération données niveaux
					$result_t_niveau = $bdd->prepare("select NIV_ID, NIV_LIBELLE FROM T_NIVEAU where NIV_ID=:niveau_id");
					$result_t_niveau->bindParam(":niveau_id",$recette_niveau);
					$result_t_niveau->execute();
					$niveau = $result_t_niveau->fetch(PDO::FETCH_OBJ);
					
					?>
						
							<div id="accueil_recette">
								
								<div id="accueil_titre_recette">
									<a href="recette.php?recette_id=<?php echo $recette_id; ?>"><?php echo $row_recettes['REC_TITRE']; ?></a>
								</div>
								<div id="accueil_favori">
									<?php if ($recette_favori == '1')
										echo'<img id="favori" class="favori tooltip" src="images/favori_3.png"/>';
									?>
								</div>
								<div class="triangle"></div>
								<div id="accueil_image_recette">
									<a href="recette.php?recette_id=<?php echo $recette_id; ?>">
										<img src="<?php if($recette_image_principale == '') {echo 'images/No_photo.png';} else {echo $recette_image_principale;} ?>"/>
									</a>
								</div>
								<div id="accueil_contenu_recette">
									<div id="indicateurs_recette">
										<div class="image_indicateur_liste">
											<img alt="Temps de préparation" title="temps de préparation" class="image_indicateur_liste tooltip" src="images/temps3.png"/>
										</div>
										<div class="texte_indicateur_liste">&#160;: 
										<?php 
											if ($recette_tps_prepa != null) echo $recette_tps_prepa." min."; else echo "-";
										?> &#160;&#160;&#160;&#160;&#160;
										</div>
										<div class="image_indicateur_liste">
											<img alt="Temps de repos" title="temps de repos" class="image_indicateur_liste tooltip" src="images/Temps_repos2.png"/>
										</div>
										<div class="texte_indicateur_liste">&#160;: 
											<?php 
												if ($recette_tps_repos != null) echo $recette_tps_repos." min."; else echo "-";
											?>&#160;&#160;&#160;&#160;&#160;
										</div>
										<div class="image_indicateur_liste">
											<img alt="Temps de cuisson" title="temps de cuisson" class="image_indicateur_liste tooltip" src="images/Temps_cuisson_2.png"/>
										</div>
										<div class="texte_indicateur_liste">&#160;: 
											<?php 
												if ($recette_tps_cuisson != null) echo $recette_tps_cuisson." min."; else echo "-";
											?>&#160;&#160;&#160;&#160;&#160;
										</div>
									</div>
									<div id="niveaux_liste">
										<div class="div_niveau_liste" title="<?php if($niveau) { echo $niveau->NIV_LIBELLE;} else {echo '???';} ?>">
											<div class="titre_niveau"><?php if($niveau) { echo $niveau->NIV_LIBELLE;} else {echo '???';} ?></div>
											<div class="niveau">
												<div class="image_niveau <?php if($niveau->NIV_ID >= 1) echo "niveau_1";?>"></div>
												<div class="image_niveau <?php if($niveau->NIV_ID >= 2) echo "niveau_2";?>"></div>
												<div class="image_niveau <?php if($niveau->NIV_ID >= 3) echo "niveau_3";?>"></div>
												<div class="image_niveau <?php if($niveau->NIV_ID >= 4) echo "niveau_4";?>"></div>
											</div>
										</div>
										<div class="div_budget_liste" title="<?php if($budget) { echo $budget->BUD_LIBELLE;} else {echo '???';} ?>">
											<div class="titre_budget"><?php if($budget) { echo $budget->BUD_LIBELLE;} else {echo '???';}  ?></div>
											<div class="budget">
												<div class="image_budget <?php if($budget->BUD_ID >= 1) echo "niveau_1";?>"></div>
												<div class="image_budget <?php if($budget->BUD_ID >= 2) echo "niveau_2";?>"></div>
												<div class="image_budget <?php if($budget->BUD_ID >= 3) echo "niveau_3";?>"></div>
											</div>
										</div>
									</div>
									<div id="nb_tests_recette">
										<div align="center">
											<?php if($recette_nb_réalisations == null || $recette_nb_réalisations == 0)
											{echo '<div><img class="nouvelle_recette" alt="Nouvelle recette" title="Nouvelle recette" class="tooltip" src="images/nouveau_1.png"/></div>';}
										else
											{echo '<div>Réalisée </div><div class="font_bold">'.$recette_nb_réalisations.' </div><div>fois</div>';}?>
										<?php echo '</div>';?>
									</div>
								</div>
							</div>
					<?php
				}
		
		?>
		
		
	</section>	

 </main>

</body>
</html>