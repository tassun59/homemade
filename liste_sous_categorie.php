<!DOCTYPE html>

<?php

include('admin/sql.php');

if (isset($_GET['categorie']))
{
	$v_categorie = $_GET['categorie'];
}
else
{
	$v_categorie = 1;
}



//Récupération données catégories
$result_t_categorie = $bdd->query("select CAT_ID, CAT_TITRE FROM T_CATEGORIE where CAT_ID=".$v_categorie);
$categorie = $result_t_categorie->fetch(PDO::FETCH_OBJ);

//Récupération données sous catégories
$result_t_sous_categories = $bdd->query("select SCA_ID, CAT_ID, SCA_TITRE, SCA_IMAGE FROM T_SOUS_CATEGORIE where CAT_ID=".$v_categorie." order by CAT_ID, SCA_ID;");
$sous_categories = $result_t_sous_categories->fetchAll(PDO::FETCH_ASSOC);

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


<div class="fil_ariane">
 	<nav>
		<br/>
<br/>
		<a href="#">Accueil</a> > <a href="#">Recettes</a> > <?php echo $categorie->CAT_TITRE; ?>
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
				
				<?php echo $categorie->CAT_TITRE; ?>
				
			</h1>
			<p>Toutes nos recettes :</p>
		</div>
	</header>
	<br/><br/>
	<section id="sous_categorie" class="sous_categorie">
		
		<?php 
		
			foreach ($sous_categories as $row_sous_categories)
				{
					?>
						<a href="liste_recettes.php?sous_categorie=<?php echo $row_sous_categories['SCA_ID']; ?>">
							<div id="sous_categorie">
								<div id="entete_sous_categorie">
									<img src="<?php if($row_sous_categories['SCA_IMAGE'] == '') {echo 'images/sous_categories/No_photo.png';} else {echo $row_sous_categories['SCA_IMAGE'];}?>">
								</div>
								<div id="titre_sous_categorie">
									<?php echo $row_sous_categories['SCA_TITRE']; ?>
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