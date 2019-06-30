<!DOCTYPE html>

<?php

	include('admin/sql.php');
	
	//Récupération données type source
	$result_param = $bdd->prepare("select COU_ID, COU_LIBELLE, COU_VALEUR FROM T_COUTS order by COU_LIBELLE;");
	$result_param->execute();
	$param = $result_param->fetchAll(PDO::FETCH_ASSOC);

	$v_table = 'T_COUTS';
	$v_chpId = 'COU_ID';
	$v_chpLibelle = 'COU_LIBELLE';
	$v_chpValeur = 'COU_VALEUR';

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
		<a href="#">Accueil</a> > <a href="#">Parametrage</a> > Gestion des coûts
	</nav>
</div>

<br/>
<br/>
 </header>
 <main>
	<header>
		<div class="titre_recette">
			<h1>
				Les différents coûts
			</h1>
		</div>
	</header>
	<br/><br/>
	<section id="couts" class="couts">
		<div id="liste">
		<?php 
		
			foreach ($param as $row_param)
				{
				
					$id =  $row_param['COU_ID'];
					$libelle =  $row_param['COU_LIBELLE'];
					$valeur =  $row_param['COU_VALEUR'];
				
					
					?>
					<div id="ligne-<?php echo $id; ?>">
					<input type="hidden" name="id-<?php echo $id; ?>" id="id-<?php echo $id; ?>" value="<?php echo $id; ?>"/>
					<input type="text" name="libelle-<?php echo $id; ?>" id="libelle-<?php echo $id; ?>" value="<?php echo $libelle; ?>" onchange="Update_champ_param('<?php echo $v_chpLibelle; ?>', this.value, <?php echo $id; ?>, '<?php echo $v_table; ?>', '<?php echo $v_chpId; ?>');"/>
					&#160;
					<input type="text" name="champ2-<?php echo $id; ?>" id="champ2-<?php echo $id; ?>" value="<?php echo $valeur; ?>" onchange="Update_champ_param('<?php echo $v_chpValeur; ?>', this.value, <?php echo $id; ?>, '<?php echo $v_table; ?>', '<?php echo $v_chpId; ?>');"/>
					&#160;
					<img class="supprimer_petit" src="images/Supprimer.png" title="Supprimer la ligne" onclick="Supprimer_ligne_param('id-<?php echo $id; ?>', '<?php echo $v_table; ?>', 'liste', 'ligne-<?php echo $id; ?>', '<?php echo $v_chpId; ?>');"/>
					</div>
					<?php
				}
		
		?>
		</div>
		<div id="ajout">
			<input type="text" name="Nlibelle" id="Nlibelle"/>
			&#160;
			&#160;
			<input type="text" name="Nchamp2" id="Nchamp2"/>
			&#160;
			<img class="ajout" src="images/insertion.png" title="Ajouter la ligne" onclick="ajout_ligne_param_2_champs('Nlibelle', '<?php echo $v_chpLibelle; ?>', 'Nchamp2', '<?php echo $v_chpValeur; ?>', '<?php echo $v_table; ?>', '<?php echo $v_chpId; ?>');"/>
					
		</div>
	</section>	

 </main>

</body>
</html>