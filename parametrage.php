<!DOCTYPE html>

<?php

include('admin/sql.php');

	if($_GET['param'] == 'type_ingredient')
	{
		//Récupération données type ingredient
		$result_param = $bdd->prepare("select TIN_ID, TIN_LIBELLE FROM T_TYPE_INGREDIENT order by TIN_LIBELLE;");
		$result_param->execute();
		$param = $result_param->fetchAll(PDO::FETCH_ASSOC);
		
		$v_table = 'T_TYPE_INGREDIENT';
		$v_chpId = 'TIN_ID';
		$v_chpLibelle = 'TIN_LIBELLE';
	}
	if($_GET['param'] == 'type_source')
	{
		//Récupération données type source
		$result_param = $bdd->prepare("select SRC_ID, SRC_LIBELLE FROM T_SOURCE order by SRC_LIBELLE;");
		$result_param->execute();
		$param = $result_param->fetchAll(PDO::FETCH_ASSOC);
		
		$v_table = 'T_SOURCE';
		$v_chpId = 'SRC_ID';
		$v_chpLibelle = 'SRC_LIBELLE';
	}
	if($_GET['param'] == 'materiel')
	{
		//Récupération données type source
		$result_param = $bdd->prepare("select MAT_ID, MAT_LIBELLE FROM T_MATERIEL order by MAT_LIBELLE;");
		$result_param->execute();
		$param = $result_param->fetchAll(PDO::FETCH_ASSOC);
		
		$v_table = 'T_MATERIEL';
		$v_chpId = 'MAT_ID';
		$v_chpLibelle = 'MAT_LIBELLE';
	}
	if($_GET['param'] == 'unite_ingredient')
	{
		//Récupération données type source
		$result_param = $bdd->prepare("select UNI_ID, UNI_LIBELLE FROM T_UNITE order by UNI_LIBELLE;");
		$result_param->execute();
		$param = $result_param->fetchAll(PDO::FETCH_ASSOC);
		
		$v_table = 'T_UNITE';
		$v_chpId = 'UNI_ID';
		$v_chpLibelle = 'UNI_LIBELLE';
	}
	if($_GET['param'] == 'unite_fabrication')
	{
		//Récupération données type source
		$result_param = $bdd->prepare("select FAB_ID, FAB_LIBELLE FROM T_UNITE_FAB order by FAB_LIBELLE;");
		$result_param->execute();
		$param = $result_param->fetchAll(PDO::FETCH_ASSOC);
		
		$v_table = 'T_UNITE_FAB';
		$v_chpId = 'FAB_ID';
		$v_chpLibelle = 'FAB_LIBELLE';
	}
	if($_GET['param'] == 'theme')
	{
		//Récupération données type source
		$result_param = $bdd->prepare("select EVE_ID, EVE_TITRE FROM T_EVENEMENT order by EVE_ID;");
		$result_param->execute();
		$param = $result_param->fetchAll(PDO::FETCH_ASSOC);
		
		$v_table = 'T_EVENEMENT';
		$v_chpId = 'EVE_ID';
		$v_chpLibelle = 'EVE_TITRE';
	}
	if($_GET['param'] == 'categorie_tuto')
	{
		//Récupération données type source
		$result_param = $bdd->prepare("select TCT_ID, TCT_LIBELLE FROM T_CATEGORIE_TUTO order by TCT_ID;");
		$result_param->execute();
		$param = $result_param->fetchAll(PDO::FETCH_ASSOC);
		
		$v_table = 'T_CATEGORIE_TUTO';
		$v_chpId = 'TCT_ID';
		$v_chpLibelle = 'TCT_LIBELLE';
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
	<script src="js/parametrage.js" type="text/javascript"></script>
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

<div id="infoBulle"></div>
<div id="Resultat_Recherche"></div>
<?php include('inc/bandeau_entete.inc.php'); ?>
<div class="fil_ariane">
 	<nav>
		<a href="#">Accueil</a> > <a href="#">Parametrage</a> > 
		<?php
			if($_GET['param'] == 'type_ingredient')
			{
				echo "Type d'ingrédients";
			}
			if($_GET['param'] == 'type_source')
			{
				echo "Sources des recettes";
			}
			if($_GET['param'] == 'materiel')
			{
				echo "Matériel";
			}
			if($_GET['param'] == 'unite_ingredient')
			{
				echo "unités des ingrédients";
			}
			if($_GET['param'] == 'unite_fabrication')
			{
				echo "Unités de fabrication";
			}
			if($_GET['param'] == 'theme')
			{
				echo "Thèmes";
			}
			if($_GET['param'] == 'categorie_tuto')
			{
				echo "Catégories des tutoriels";
			}
		?>
	</nav>
</div>
<br/>
<br/>
 </header>
 <main>
	<header>
		<div class="titre_recette">
			<h1>
				Bibliothèque  
				<?php
					if($_GET['param'] == 'type_ingredient')
					{
						echo "des types d'ingrédients";
					}
					if($_GET['param'] == 'type_source')
					{
						echo "des sources des recettes";
					}
					if($_GET['param'] == 'materiel')
					{
						echo "de matériel";
					}
					if($_GET['param'] == 'unite_ingredient')
					{
						echo "des unités d'ingrédients";
					}
					if($_GET['param'] == 'unite_fabrication')
					{
						echo "des unités de fabrication";
					}
					if($_GET['param'] == 'theme')
					{
						echo "des thèmes";
					}
					if($_GET['param'] == 'categorie_tuto')
					{
						echo "des catégories de tutoriels";
					}
				?>
			</h1>
		</div>
	</header>
	<br/><br/>
	<section id="parametrage" class="parametrage">
		<div id="liste">
		<?php 
		
			foreach ($param as $row_param)
				{
					if($_GET['param'] == 'type_ingredient')
					{
						$id =  $row_param['TIN_ID'];
						$libelle =  $row_param['TIN_LIBELLE'];
					}
					if($_GET['param'] == 'type_source')
					{
						$id =  $row_param['SRC_ID'];
						$libelle =  $row_param['SRC_LIBELLE'];
					}
					if($_GET['param'] == 'materiel')
					{
						$id =  $row_param['MAT_ID'];
						$libelle =  $row_param['MAT_LIBELLE'];
					}
					if($_GET['param'] == 'unite_ingredient')
					{
						$id =  $row_param['UNI_ID'];
						$libelle =  $row_param['UNI_LIBELLE'];
					}
					if($_GET['param'] == 'unite_fabrication')
					{
						$id =  $row_param['FAB_ID'];
						$libelle =  $row_param['FAB_LIBELLE'];
					}
					if($_GET['param'] == 'theme')
					{
						$id =  $row_param['EVE_ID'];
						$libelle =  $row_param['EVE_TITRE'];
					}
					if($_GET['param'] == 'categorie_tuto')
					{
						$id =  $row_param['TCT_ID'];
						$libelle =  $row_param['TCT_LIBELLE'];
					}
					
					?>
					<div id="ligne-<?php echo $id; ?>">
					<input type="hidden" name="id-<?php echo $id; ?>" id="id-<?php echo $id; ?>" value="<?php echo $id; ?>"/>
					<input type="text" name="libelle-<?php echo $id; ?>" id="libelle-<?php echo $id; ?>" value="<?php echo $libelle; ?>" onchange="Update_champ_param('<?php echo $v_chpLibelle; ?>', this.value, <?php echo $id; ?>, '<?php echo $v_table; ?>', '<?php echo $v_chpId; ?>');"/>
					&#160;
					<img class="supprimer_petit" src="images/Supprimer.png" title="Supprimer la ligne" onclick="Supprimer_ligne_param('id-<?php echo $id; ?>', '<?php echo $v_table; ?>', 'liste', 'ligne-<?php echo $id; ?>', '<?php echo $v_chpId; ?>');"/>
					</div>
					<?php
				}
		
		?>
		</div>
		<div id="ajout">
			<input type="text" name="Nlibelle" id="Nlibelle"/>
			<img class="ajout" src="images/insertion.png" title="Ajouter la ligne" onclick="ajout_ligne_param('Nlibelle', '<?php echo $v_chpLibelle; ?>', '<?php echo $v_table; ?>', '<?php echo $v_chpId; ?>');"/>
									
					
		</div>
	</section>	

 </main>

</body>
</html>