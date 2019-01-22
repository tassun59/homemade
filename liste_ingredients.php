<!DOCTYPE html>

<?php

include('admin/sql.php');

$v_type_ingredient = $_GET['type_ingredient'];




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


<?php
//Récupération données type ingredient
$result_t_type_ingredient = $bdd->prepare("select TIN_ID, TIN_LIBELLE FROM T_TYPE_INGREDIENT where TIN_ID=:type_ingredient;");
$result_t_type_ingredient->bindParam(":type_ingredient",$v_type_ingredient);
$result_t_type_ingredient->execute();
$type_ingredient = $result_t_type_ingredient->fetch(PDO::FETCH_OBJ);


//Récupération données ingredients
$result_t_ingredients = $bdd->prepare("select ING_ID, ING_LIBELLE FROM T_INGREDIENT where TIN_ID=:type_ingredient order by ING_ID");
$result_t_ingredients->bindParam(":type_ingredient",$v_type_ingredient);
$result_t_ingredients->execute();
$ingredient = $result_t_ingredients->fetchAll(PDO::FETCH_ASSOC);
?>
<?php include('inc/bandeau_entete.inc.php'); ?>
<div class="fil_ariane">
 	<nav>
		<br/>
<br/>
		<a href="#">Accueil</a> > <a href="#">Ingrédients</a> > <?php echo $type_ingredient->TIN_LIBELLE; ?>
	</nav>
</div>
<br/>
<br/>
<br/>
<br/>
<br/>
<br/>
<br/>
<br/>
 </header>
 <main>
	<header>
		<div class="titre_recette">
			<h1>
				<?php echo $type_ingredient->TIN_LIBELLE; ?>
				
			</h1>
			<p>Toutes nos recettes :</p>
		</div>
	</header>
	<br/><br/>
	<section id="ingredient" class="ingredient">
		
		<?php 
		
			foreach ($ingredient as $row_ingredient)
				{
					?>
						<a href="liste_recettes.php?ingredient=<?php echo $row_ingredient['ING_ID']; ?>">
							<div id="ingredient">
								<div id="entete_ingredient" style="background-image:url('images/ingredients/framboise.jpg')">
									<!--<img src="<?php if($row_sous_categories['SCA_IMAGE'] == '') {echo 'images/No_photo.png';} else {echo $row_sous_categories['SCA_IMAGE'];}?>">-->

								</div>
								<div id="titre_ingredient">
									<?php echo $row_ingredient['ING_LIBELLE']; ?>
								</div>
							</div>
						</a>
					<?php
				}
		
		?>
		
		
	</section>	

 </main>

</body>
</html>