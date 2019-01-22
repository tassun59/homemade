<?php
//Récupération données catégories
$result_t_themes = $bdd->query("select EVE_ID, EVE_TITRE FROM T_EVENEMENT order by EVE_ID");
$themes = $result_t_themes->fetchAll(PDO::FETCH_ASSOC);

//Récupération données catégories
$result_t_categories = $bdd->query("select CAT_ID, CAT_TITRE FROM T_CATEGORIE order by CAT_ORDRE_AFF");
$categories = $result_t_categories->fetchAll(PDO::FETCH_ASSOC);

//Récupération données type ingredient
$result_t_type_ingredient = $bdd->query("select TIN_ID, TIN_LIBELLE FROM T_TYPE_INGREDIENT order by TIN_ID");
$type_ingredient = $result_t_type_ingredient->fetchAll(PDO::FETCH_ASSOC);

//Choix recette random
$result_t_random_recette = $bdd->query("select REC_ID from T_RECETTE order by rand() limit 1");
$random_recette = $result_t_random_recette->fetch(PDO::FETCH_OBJ);

//Récupération données type tuto
$result_t_categorie_tuto = $bdd->query("select TCT_ID, TCT_LIBELLE FROM T_CATEGORIE_TUTO order by TCT_ID");
$categorie_tuto = $result_t_categorie_tuto->fetchAll(PDO::FETCH_ASSOC);


echo '<div id="menuNavigation">
	 
	 <a id="touch-menu" class="mobile-menu" href="#"><i class="icon-reorder"></i>Menu</a>
		
		<nav class="navigation">
		<ul class="menu">
	   <li><a  href="index.php"><i class="icon-home"></i>HOME</a></li>
	   <li><a href="#"><i class="icon-home"></i>RECETTES</a>
	   <ul class="sub-menu">';
			foreach ($categories as $row_categories)
			{
				
				$categories_id =  $row_categories['CAT_ID'];
				$categories_titre =  $row_categories['CAT_TITRE'];
			
			
				
				echo '<li><a href="liste_sous_categorie.php?categorie='.$categories_id.'">'.$categories_titre.'</a></li>';
		 } 
		
	   
	   echo '</ul>
	   </li>
	  <li><a  href="#"><i class="icon-user"></i>THEMES</a>
	  <ul class="sub-menu">';
			foreach ($themes as $row_themes)
			{
				
				$themes_id =  $row_themes['EVE_ID'];
				$themes_titre =  $row_themes['EVE_TITRE'];
			
			
				
				echo '<li><a href="liste_recettes.php?theme='.$themes_id.'">'.$themes_titre.'</a></li>';
		 } 
		
	   
	   echo '</ul>
	  </li>
	  <li><a  href="#"><i class="icon-camera"></i>INGREDIENTS</a>
	  <ul class="sub-menu">';
	   foreach ($type_ingredient as $row_type_ingredient)
			{
				
				$type_ingredient_id =  $row_type_ingredient['TIN_ID'];
				$type_ingredient_titre =  $row_type_ingredient['TIN_LIBELLE'];
			
			
				
				echo '<li><a href="liste_ingredients.php?type_ingredient='.$type_ingredient_id.'">'.$type_ingredient_titre.'</a></li>';
		 } 
		
	   
	   echo '</ul>
	  </li>
	  <li><a  href="#"><i class="icon-bullhorn"></i>TUTORIELS</a>
	  <ul class="sub-menu">';
	   foreach ($categorie_tuto as $row_categorie_tuto)
			{
				
				$categorie_tuto_id =  $row_categorie_tuto['TCT_ID'];
				$categorie_tuto_titre =  $row_categorie_tuto['TCT_LIBELLE'];
			
			
				
				echo '<li><a href="liste_tutos.php?categorie_tuto='.$categorie_tuto_id.'">'.$categorie_tuto_titre.'</a></li>';
		 } 
		
	   
	   echo '</ul>
	  </li>
	  <li><a  href="#"><i class="icon-link"></i>LIENS UTILES</a></li>
	  <li><a  href="recette.php?recette_id='.$random_recette->REC_ID.'"><i class="icon-magic"></i>RECETTE AU HASARD</a></li>
	  <li><a  href="#"><i class="icon-cogs"></i>PARAMETRAGE</a>
		<ul class="sub-menu">
			<li><a href="parametrage.php?param=type_source">Types de source</a></li>
			<li><a href="parametrage.php?param=type_ingredient">Types d\'ingrédient</a></li>
			<li><a href="parametrage_ingredient.php">Ingrédients</a></li>
			<li><a href="parametrage.php?param=materiel">Matériel</a></li>
			<li><a href="parametrage.php?param=unite_ingredient">Unités d\'ingrédient</a></li>
			<li><a href="parametrage.php?param=unite_fabrication">Unités de fabrication</a></li>
			<li><a href="parametrage.php?param=theme">Thèmes</a></li>
			<li><a href="parametrage.php?param=categorie_tuto">Catégories tutoriels</a></li>
		</ul>
	  </li>
	  <li><a  href="recherche.php"><i class="icon-search"></i></a></li>
	  </ul>
	  </nav>
 </div>';
?>


<!-- pour un champ recherche intéractif
<li><a  href="#left" class="ouvrir" id="lien_recherche_ouverture" onclick="masquer_afficher(\'lien_recherche_ouverture\', \'lien_recherche_fermeture\');"><i class="icon-search"></i></a><a  href="#right" class="fermer" id="lien_recherche_fermeture" onclick="masquer_afficher(\'lien_recherche_fermeture\', \'lien_recherche_ouverture\');"><i class="icon-search"></i></a></li>
	  <script>
       document.getElementById(\'lien_recherche_ouverture\').style.display=\'none\';
    </script>

-->