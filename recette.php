<!DOCTYPE html>

<?php

if (isset($_GET['recette_id']))
{
	$recette_id = $_GET['recette_id'];
}
include('admin/sql.php');

if (isset($_GET['modifier']) && $_GET['modifier'] == 'O')
{
	$modifier = 'O';
}
else
{
	$modifier = 'N';
}

if (isset($_GET['new']) && $_GET['new'] == 'O')
{
	$modifier = 'O';
	
	$max_recette_id = $bdd->prepare('SELECT MAX(REC_ID) MAX_REC_ID FROM T_RECETTE');
	$max_recette_id->execute();
	$max_rec_id = $max_recette_id->fetch(PDO::FETCH_OBJ);
	
	$ajout_recette = $bdd->prepare('INSERT INTO T_RECETTE (REC_ID,REC_CATEGORIE,REC_SOUS_CATEGORIE) values ('.($max_rec_id->MAX_REC_ID + 1).', '. $_GET['categorie'] .', '. $_GET['sscategorie'].');');
	$ajout_recette->execute();
	$recette_id = $max_rec_id->MAX_REC_ID + 1;
}


if (isset($_GET['modifier']) && $_GET['modifier'] == 'O' && isset($_GET['ajout_sec_ing']) && $_GET['ajout_sec_ing'] == 'O' )
{
	$modifier = 'O';
	$ajout_section_ingredient = $bdd->prepare('INSERT INTO T_RECETTE_INGREDIENTS_ENTETE (REC_ID) values (?)');
	$ajout_section_ingredient->execute(array($recette_id));
}


$nom_dossier = './ressources';

$bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

//Récupération données recette
$result_t_recette = $bdd->query("select REC_ID, REC_TITRE, REC_CATEGORIE, REC_SOUS_CATEGORIE, REC_NIVEAU, REC_BUDGET, REC_TPS_PREPA, REC_TPS_REPOS, REC_TPS_CUISSON, REC_NB_CONVIVES, REC_UNI_FAB_ID, REC_NB_REALISATIONS, REC_DATE_CREATION, REC_DATE_MODIF, REC_ID_EVENEMENT, REC_ID_LIEU, REC_TAG, REC_ID_SOURCE, REC_LIEN_SOURCE, REC_FAVORI, REC_IMG_PRINC FROM T_RECETTE where REC_ID=".$recette_id."");
while ($recette = $result_t_recette->fetch(PDO::FETCH_ASSOC))
{
	$recette_id =  $recette['REC_ID'];
	$recette_titre =  $recette['REC_TITRE'];
	$recette_categorie =  $recette['REC_CATEGORIE'];
	$recette_sous_categorie =  $recette['REC_SOUS_CATEGORIE'];
	$recette_niveau =  $recette['REC_NIVEAU'];
	$recette_budget =  $recette['REC_BUDGET'];
	$recette_tps_prepa =  $recette['REC_TPS_PREPA'];
	$recette_tps_repos =  $recette['REC_TPS_REPOS'];
	$recette_tps_cuisson =  $recette['REC_TPS_CUISSON'];
	$recette_nb_convives =  $recette['REC_NB_CONVIVES'];
	$recette_uni_fab_id =  $recette['REC_UNI_FAB_ID'];
	$recette_nb_réalisations =  $recette['REC_NB_REALISATIONS'];
	$recette_date_creation =  $recette['REC_DATE_CREATION'];
	$recette_date_modif =  $recette['REC_DATE_MODIF'];
	$recette_id_evenement =  $recette['REC_ID_EVENEMENT'];
	$recette_id_lieu =  $recette['REC_ID_LIEU'];
	$recette_tag =  $recette['REC_TAG'];
	$recette_id_source =  $recette['REC_ID_SOURCE'];
	$recette_lien_source =  $recette['REC_LIEN_SOURCE'];
	$recette_favori =  $recette['REC_FAVORI'];
	$recette_image_principale =  $recette['REC_IMG_PRINC'];
}


//Récupération données budgets
$result_t_budgets = $bdd->query("select BUD_ID, BUD_LIBELLE FROM T_BUDGET");
$budgets = $result_t_budgets->fetchAll(PDO::FETCH_ASSOC);


//Récupération données niveaux
$result_t_niveaux = $bdd->query("select NIV_ID, NIV_LIBELLE FROM T_NIVEAU");
$niveaux = $result_t_niveaux->fetchAll(PDO::FETCH_ASSOC);


//Récupération données source
$result_t_sources = $bdd->query("select SRC_ID, SRC_LIBELLE FROM T_SOURCE");
$sources = $result_t_sources->fetchAll(PDO::FETCH_ASSOC);


//Récupération données étapes
$result_t_recette_etapes = $bdd->query("select ETA_ID, ETA_TITRE, ETA_DESCRIPTION, REC_ID_LIEN FROM T_RECETTE_ETAPES where REC_ID = ".$recette_id."");
$etapes = $result_t_recette_etapes->fetchAll(PDO::FETCH_ASSOC);
//$count_etapes = $result_t_recette_etapes->rowCount();
$result_t_recette_etapes_max_id = $bdd->query("select max(ETA_ID) as MAX_ETAPE from T_RECETTE_ETAPES WHERE REC_ID = ".$recette_id."");
$recette_etapes_max_id = $result_t_recette_etapes_max_id->fetch(PDO::FETCH_OBJ);



//Récupération données sous catégories
$result_t_sous_categories = $bdd->query("select SCA_ID, CAT_ID, SCA_TITRE FROM T_SOUS_CATEGORIE where CAT_ID=".$recette_categorie." order by CAT_ID, SCA_ID;");
$sous_categories = $result_t_sous_categories->fetchAll(PDO::FETCH_ASSOC);

//Récupération données matériel
$result_t_materiels = $bdd->query("select MAT_ID, MAT_LIBELLE FROM T_MATERIEL order by MAT_ID");
$materiels = $result_t_materiels->fetchAll(PDO::FETCH_ASSOC);
$count_materiels = $result_t_materiels->rowCount();
$rupture_count_materiels = ceil($count_materiels / 3);

//Récupération données recette matériel
$result_t_recette_materiel = $bdd->query("select MAT_ID, REC_ID, RMA_QUANTITE FROM T_RECETTE_MATERIEL where REC_ID = ".$recette_id." order by MAT_ID");
$recette_materiel = $result_t_recette_materiel->fetchAll(PDO::FETCH_ASSOC);
$count_recette_materiel = $result_t_recette_materiel->rowCount();
$rupture_count_recette_materiel = ceil($count_recette_materiel / 3);

//Récupération données ingrédients
$result_t_ingredients = $bdd->query("select ING_ID, ING_LIBELLE FROM T_INGREDIENT order by ING_ID");
$ingredients = $result_t_ingredients->fetchAll(PDO::FETCH_ASSOC);

//Récupération données entete ingredient recette
$result_t_recette_ingredient_entete = $bdd->query("select RIE_ID, REC_ID, RIE_LIBELLE, REC_ID_LIEN from T_RECETTE_INGREDIENTS_ENTETE WHERE REC_ID = ".$recette_id." order by RIE_ID");
$recette_ingredient_entete = $result_t_recette_ingredient_entete->fetchAll(PDO::FETCH_ASSOC);
$result_t_recette_ingredient_entete_max_id = $bdd->query("select max(RIE_ID) as MAX_ENTETE from T_RECETTE_INGREDIENTS_ENTETE WHERE REC_ID = ".$recette_id."");
$recette_ingredient_entete_max_id = $result_t_recette_ingredient_entete_max_id->fetch(PDO::FETCH_ASSOC);

//Récupération données ingredient recette
$result_t_recette_ingredient = $bdd->query("select RIN_ID, RIE_ID, REC_ID, ING_ID, RIN_COMMENTAIRE, RIN_QTE, UNI_ID from T_RECETTE_INGREDIENTS WHERE REC_ID = ".$recette_id." order by RIN_ID");
$recette_ingredient = $result_t_recette_ingredient->fetchAll(PDO::FETCH_ASSOC);

//Récupération données unite mesure
$result_t_unite_mesure = $bdd->query("SELECT UNI_ID, UNI_LIBELLE FROM T_UNITE order by UNI_ID");
$unite_mesure = $result_t_unite_mesure->fetchAll(PDO::FETCH_ASSOC);

//Récupération données actuces recette
$result_t_recette_astuces = $bdd->query("select RAS_ID, REC_ID, RAS_DESCRIPTION FROM T_RECETTE_ASTUCES WHERE REC_ID = ".$recette_id." order by RAS_ID");
$recette_astuces = $result_t_recette_astuces->fetchAll(PDO::FETCH_ASSOC);
//$count_astuces = $result_t_recette_astuces->rowCount();

$result_t_recette_astuces_max_id = $bdd->query("select max(RAS_ID) as MAX_ASTUCE from T_RECETTE_ASTUCES WHERE REC_ID = ".$recette_id."");
$recette_a_max_id = $result_t_recette_astuces_max_id->fetch(PDO::FETCH_OBJ);

//Récupération données unite fabrication
$result_t_unite_fabrication = $bdd->query("SELECT FAB_ID, FAB_LIBELLE FROM T_UNITE_FAB order by FAB_ID");
$unite_fabrication = $result_t_unite_fabrication->fetchAll(PDO::FETCH_ASSOC);

// liste des recette techniques de base
$result_t_recette_technique_base = $bdd->query("select REC_ID, REC_TITRE FROM T_RECETTE where REC_CATEGORIE=1 AND REC_ID != ".$recette_id."");
$recette_technique_base = $result_t_recette_technique_base->fetchAll(PDO::FETCH_ASSOC);

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
	
	<!-- Lightbox -->
	<link rel="stylesheet" href="css/lightbox/lightbox.css">
	<script src="js/lightbox/lightbox-plus-jquery.min.js"></script>
	
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
	
	<!-- AJAX -->
	<script src="js/ajax/oXHR.js"></script>
	
	
	<!-- menu -->
    <link rel="stylesheet" href="font/menu/css/font-awesome.css" >
	
     <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
      <script src="http://css3-mediaqueries-js.googlecode.com/files/css3-mediaqueries.js"></script>
    <![endif]-->

	<!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js" type="text/javascript" ></script>-->

	<!--slideshow-->
	<link rel="stylesheet" href="css/slideshow/styles.css" />
	
	 <!-- Jquery Tag-it -->
    <!--<link rel="stylesheet" type="text/css" href="http://yui.yahooapis.com/2.9.0/build/reset-fonts/reset-fonts.css">
    <link rel="stylesheet" type="text/css" href="http://yui.yahooapis.com/2.9.0/build/base/base-min.css">
    <link href="http://fonts.googleapis.com/css?family=Brawler" rel="stylesheet" type="text/css">
    <link href="css/tag/master.css" rel="stylesheet" type="text/css">
    <link href="css/tag/subpage.css" rel="stylesheet" type="text/css">
    <link href="css/tag/examples.css" rel="stylesheet" type="text/css">-->
	    <!-- /ignore -->


    <!-- INSTRUCTIONS -->

    <!-- 2 CSS files are required: -->
    <!--   * Tag-it's base CSS (jquery.tagit.css). -->
    <!--   * Any theme CSS (either a jQuery UI theme such as "flick", or one that's bundled with Tag-it, e.g. tagit.ui-zendesk.css as in this example.) -->
    <!-- The base CSS and tagit.ui-zendesk.css theme are scoped to the Tag-it widget, so they shouldn't affect anything else in your site, unlike with jQuery UI themes. -->
    <link href="css/tag/jquery.tagit.css" rel="stylesheet" type="text/css">
    <link href="css/tag/tagit.ui-zendesk.css" rel="stylesheet" type="text/css">
    <!-- If you want the jQuery UI "flick" theme, you can use this instead, but it's not scoped to just Tag-it like tagit.ui-zendesk is: -->
    <!--   <link rel="stylesheet" type="text/css" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1/themes/flick/jquery-ui.css"> -->

    <!-- jQuery and jQuery UI are required dependencies. -->
    <!-- Although we use jQuery 1.4 here, it's tested with the latest too (1.8.3 as of writing this.) -->
    <!--<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js" type="text/javascript" charset="utf-8"></script>-->
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.9.2/jquery-ui.min.js" type="text/javascript" charset="utf-8"></script>

    <!-- The real deal -->
    <script src="js/tag/tag-it.js" type="text/javascript" charset="utf-8"></script>
	<script>
        $(function(){
            var sampleTags = ['c++', 'java', 'php', 'coldfusion', 'javascript', 'asp', 'ruby', 'python', 'c', 'scala', 'groovy', 'haskell', 'perl', 'erlang', 'apl', 'cobol', 'go', 'lua'];

            //-------------------------------
            // Minimal
            //-------------------------------
            $('#myTags').tagit();

            //-------------------------------
            // Single field
            //-------------------------------
            $('#singleFieldTags').tagit({
                availableTags: sampleTags,
                // This will make Tag-it submit a single form value, as a comma-delimited field.
                singleField: true,
                singleFieldNode: $('#mySingleField')
            });

            // REC_TAG is an INPUT element, rather than a UL as in the other 
            // examples, so it automatically defaults to singleField.
            $('#REC_TAG').tagit({
                availableTags: sampleTags
            });

            //-------------------------------
            // Preloading data in markup
            //-------------------------------
            $('#myULTags').tagit({
                availableTags: sampleTags, // this param is of course optional. it's for autocomplete.
                // configure the name of the input field (will be submitted with form), default: item[tags]
                itemName: 'item',
                fieldName: 'tags'
            });

            //-------------------------------
            // Tag events
            //-------------------------------
            var eventTags = $('#eventTags');

            var addEvent = function(text) {
                $('#events_container').append(text + '<br>');
            };

            eventTags.tagit({
                availableTags: sampleTags,
                beforeTagAdded: function(evt, ui) {
                    if (!ui.duringInitialization) {
                        addEvent('beforeTagAdded: ' + eventTags.tagit('tagLabel', ui.tag));
                    }
                },
                afterTagAdded: function(evt, ui) {
                    if (!ui.duringInitialization) {
                        addEvent('afterTagAdded: ' + eventTags.tagit('tagLabel', ui.tag));
                    }
                },
                beforeTagRemoved: function(evt, ui) {
                    addEvent('beforeTagRemoved: ' + eventTags.tagit('tagLabel', ui.tag));
                },
                afterTagRemoved: function(evt, ui) {
                    addEvent('afterTagRemoved: ' + eventTags.tagit('tagLabel', ui.tag));
                },
                onTagClicked: function(evt, ui) {
                    addEvent('onTagClicked: ' + eventTags.tagit('tagLabel', ui.tag));
                },
                onTagExists: function(evt, ui) {
                    addEvent('onTagExists: ' + eventTags.tagit('tagLabel', ui.existingTag));
                }
            });

            //-------------------------------
            // Read-only
            //-------------------------------
            $('#readOnlyTags').tagit({
                readOnly: true
            });

            //-------------------------------
            // Tag-it methods
            //-------------------------------
            $('#methodTags').tagit({
                availableTags: sampleTags
            });

            //-------------------------------
            // Allow spaces without quotes.
            //-------------------------------
            $('#allowSpacesTags').tagit({
                availableTags: sampleTags,
                allowSpaces: true
            });

            //-------------------------------
            // Remove confirmation
            //-------------------------------
            $('#removeConfirmationTags').tagit({
                availableTags: sampleTags,
                removeConfirmation: true
            });
            
        });
    </script>
	
	
	
<script src="js/menu/menu.js" type="text/javascript"></script> 
<script src="jquery.auto-complete.js"></script>
<link rel="stylesheet" href="jquery.auto-complete.css">	
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
	
	
	
	
	
	
<!-- Upload fichier -->	
	
<script type="text/javascript" src="js/upload/jquery.form.min.js"></script>
	
	

	
	
<!-- Fin Upload fichier -->		
	
	
		
	<script src="js/recette.js" type="text/javascript"></script> 
</head>
  
 <body>

	<header>
	 
	 <!--Menu MainWrap-->
	 <?php include('inc/menu.inc.php'); ?>
	 <!--end menu MainWrap-->
<div id="infoBulle"></div>
<div id="Resultat_Recherche"></div>
<!--<script>$(document).ready(function(){
    $('#infoBulle').fadeOut('slow');
    });</script>-->
<!-- Barre recherche -->
 <!--<div class="slider2 slider--right" id="right">
  <p><input type="search"><input type ="button" id="button_search" value="Ok"/><a class="lien_discret" href="#">Recherche avancée ...<a/></p>
</div>-->

<!-- Boutons action -->
<div class="div_action">
 	<div class="image_action"><a id="link" href="#"><img class="action tooltip" src="images/export2.PNG" title="Exporter"/></a></div>
	<div class="image_action"><a id="link" href="#"><img class="action tooltip" src="images/mail2.PNG" title="Envoyer"/></a></div>
	<?php if ($modifier == "N")	{ ?><div class="image_action"><a id="link" href="recette.php?recette_id=<?php echo $recette_id; ?>&modifier=O"><img class="action tooltip" src="images/modifier2.PNG" title="Modifier la recette"/></a></div><?php } ?>
	<div class="image_action"><a id="link" href="#" onclick="javascript:window.print()"><img class="action tooltip" src="images/imprimer.PNG" title="Imprimer"/></a></div>
	<?php if ($modifier == "O")	{ ?><div class="image_action"><a id="link" href="recette.php?recette_id=<?php echo $recette_id; ?>"><img class="action tooltip" src="images/retour2.PNG" title="Retour en consultation"/></a></div><?php } ?>
	<div class="image_action"><a id="link" href="#"><img class="supprimer tooltip" src="images/annuler.PNG" title="Supprimer la recette"/></a></div>
</div>

<div class="fil_ariane">
 	<nav>
		<?php 
		foreach ($categories as $row_recette_categorie)
		{
			if($row_recette_categorie['CAT_ID'] == $recette_categorie)
			{
				$recette_categorie_libelle = $row_recette_categorie['CAT_TITRE'];
				break;
			}
		}
		foreach ($sous_categories as $row_sous_categories)
				{
					if($row_sous_categories['SCA_ID'] == $recette_sous_categorie)
					{
						$recette_sous_categorie_libelle = $row_sous_categories['SCA_TITRE'];
						break;
					}
				}
		?>
		<a href="#">Accueil</a> > <a href="#">Recettes</a> > <?php echo $recette_categorie_libelle; ?> > <?php echo $recette_sous_categorie_libelle; ?>
	</nav>
</div>
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
				
				<?php if ($modifier == 'O')
				{
				?>
					Titre : <input type="text" name = "rec_titre" id = "rec_titre" value="<?php echo $recette_titre; ?>" onchange="Update_champ_recette(this.id, this.value, <?php echo $recette_id; ?>)"/>
					&#160;Favori : <select name="rec_favori" id="rec_favori" onchange="Update_champ_recette(this.id, this.value, <?php echo $recette_id; ?>)">
					<option/>
					<option value="0" <?php if ($recette_favori != '1') { echo 'selected="selected"';} ?> >Non</option>
					<option value="1" <?php if ($recette_favori == '1') { echo 'selected="selected"';} ?> >Oui</option>
					</select>
				<?php
				}
				else
				{
				?>
					<input type="hidden" name="rec_favori" id="rec_favori" value="<?php echo $recette_favori; ?>"/>
				<?php
					echo $recette_titre; ?>&#160;<a id="lien_favori" href="#"><img id="favori" class="favori tooltip <?php if ($recette_favori != '1') { echo ' semi_transparent';} ?>" src="images/favori_3.PNG" title="Ajouter aux favoris" onclick="update_favori(<?php echo $recette_id; ?>, 'rec_favori');"/></a>
				<?php 
				} 
				?>
				
			</h1>
		</div>
	</header>
	<br/><br/>
	<section class="entete">
		<article class="entete_recette">
			<div class="source_recette">
				Source : 
				
				
				<?php 
				
				foreach ($sources as $row_sources)
				{
					if($row_sources['SRC_ID'] == $recette_id_source)
					{
						$source_libelle = $row_sources['SRC_LIBELLE'];
						break;
					}
				}
				
					if ($modifier == 'O')
					{
					?>
						&#160;Type de source : 
						<select name="rec_id_source" id="rec_id_source" onchange="Update_champ_recette(this.id, this.value, <?php echo $recette_id; ?>)">
							<option/>
							<?php 
							foreach ($sources as $row_sources)
							{
							?>
								<option value=<?php echo $row_sources['SRC_ID'];?> <?php if($row_sources['SRC_ID'] == $recette_id_source) { echo ' selected="selected"';} ?>> <?php echo $row_sources['SRC_LIBELLE']; ?></option>
							<?php 
							}
							?>
						</select>
						<input type="text" name = "rec_lien_source" id = "rec_lien_source" value="<?php  echo $recette_lien_source; ?>" onchange="Update_champ_recette(this.id, this.value, <?php echo $recette_id; ?>)"/>
					<?php
					}
					else
					{
					?>
						<a class="lien_discret" href="<?php  echo  $recette_lien_source ?>" target="blank"><?php  echo $source_libelle; ?></a>
					<?php 
					}
				?>
			</div>
			<div class="photos_principales">
				<section id="slideshow">
					<div class="container">
							<img src="<?php echo $recette_image_principale; ?>" alt="" />
					</div>
					<div class="materiel">
						<header>
							<h2 class="titre_ardoise"><u>Matériel nécessaire</u></h2>
						</header>
						<br/>
						<div>
							<div class="colonne_materiel">
								<table class="tableau_materiel">
									<tr>
										<th/>
									</tr>
									<?php
									if ($modifier == 'O')
									{
										foreach ($materiels as $row_materiels)
										{
											$materiel_checked = 'N';
											foreach ($recette_materiel as $row_recette_materiel)
											{
												$materiel_checked = 'N';
												if($row_recette_materiel['MAT_ID'] == $row_materiels['MAT_ID'])
												{
													$materiel_checked = 'O';
													break;
												}
											}
									?>
											<tr id="ligne_materiel-<?php echo $row_materiels['MAT_ID']; ?>">
												<td class="libelle_materiel">&#160;<input type="checkbox" name="mat_id-<?php echo $row_materiels['MAT_ID']; ?>" id="mat_id-<?php echo $row_materiels['MAT_ID']; ?>" <?php if($materiel_checked == 'O') { echo ' checked="checked"';} ?> onclick="AfficherMasquerQuantite(this, 'rma_quantite-<?php echo $row_materiels['MAT_ID']; ?>', 'libelle_materiel-<?php echo $row_materiels['MAT_ID']; ?>', 'mat_id-<?php echo $row_materiels['MAT_ID']; ?>', <?php echo $recette_id; ?>,'mat_id-<?php echo $row_materiels['MAT_ID']; ?>');"/>&#160;<span id="libelle_materiel-<?php echo $row_materiels['MAT_ID'];?>" <?php if($materiel_checked != 'O') { echo 'class="grey"';} ?>><?php echo $row_materiels['MAT_LIBELLE']; ?></span></td>
												<td class="quantite_materiel"><input type="<?php if($materiel_checked == 'O') { echo 'text';} else { echo 'hidden';} ?>" name="rma_quantite-<?php echo $row_materiels['MAT_ID']; ?>" id="rma_quantite-<?php echo $row_materiels['MAT_ID']; ?>" value="<?php if($materiel_checked == 'O') { echo $row_recette_materiel['RMA_QUANTITE'];} ?>" onchange="Update_champ_recette_materiel('rma_quantite-<?php echo $row_materiels['MAT_ID']; ?>', this.value, <?php echo $recette_id; ?>,'mat_id-<?php echo $row_materiels['MAT_ID']; ?>');"/></td>
											</tr>
											
											<?php
											
										}
									}
									else
									{
										foreach ($recette_materiel as $row_recette_materiel)
										{
											foreach ($materiels as $row_materiels)
											{
												$recette_materiel_libelle = '';
												if($row_materiels['MAT_ID'] == $row_recette_materiel['MAT_ID'])
												{
													$recette_materiel_libelle = $row_materiels['MAT_LIBELLE'];
													break;
												}
											}
											?>
											<tr>
													<td class="libelle_materiel"><?php echo $recette_materiel_libelle; ?></td>
													<td class="quantite_materiel"><?php echo $row_recette_materiel['RMA_QUANTITE']; ?></td>
												</tr>
											<?php
											
										}
									}
									
									?>
									<tr>
										<td colspan="2"><br/></td>
									</tr>
								</table>
							</div>
						</div>
					</div>
					<div>
						<?php 
		
			foreach ($niveaux as $row_niveaux)
			{
				if($row_niveaux['NIV_ID'] == $recette_niveau)
				{
					$niveau_libelle = $row_niveaux['NIV_LIBELLE'];
				}
			}
			
			foreach ($budgets as $row_budgets)
			{
				if($row_budgets['BUD_ID'] == $recette_budget)
				{
					$budget_libelle = $row_budgets['BUD_LIBELLE'];
				}
			}
			
			if ($modifier == 'O')
			{
			?>
				<div class="div_niveau">
					<img class="img_niveau" src="images/toque2.PNG"/>&#160;<select name="rec_niveau" id="rec_niveau" onchange="Update_champ_recette(this.id, this.value, <?php echo $recette_id; ?>)">
						<option/>
						<?php 
						foreach ($niveaux as $row_niveaux)
						{
						?>
							<option value="<?php echo $row_niveaux['NIV_ID'];?>" <?php if($row_niveaux['NIV_ID'] == $recette_niveau) { echo ' selected="selected"';} ?>><?php echo $row_niveaux['NIV_LIBELLE']; ?></option>
						<?php 
						}
						?>
						</select></div>
						<div class="div_budget">
						<img class="img_budget" src="images/euro.PNG"/>&#160;<select name="rec_budget" id="rec_budget" onchange="Update_champ_recette(this.id, this.value, <?php echo $recette_id; ?>)">';
						<option/>
						<?php 
						foreach ($budgets as $row_budgets)
						{
						?>
							<option value="<?php echo $row_budgets['BUD_ID'];?>"  <?php if($row_budgets['BUD_ID'] == $recette_budget) { echo ' selected="selected"';} ?>><?php echo $row_budgets['BUD_LIBELLE']; ?></option>
						<?php
						}
						?>
						</select></div>

				<!--<div class="div_budget">
					<div class="image_budget"><img class="budget" src="images/euro.PNG"/></div>
					<div class="image_budget"><img class="budget'.($recette_budget < 2 ? ' semi_transparent' : '').'" src="images/euro.PNG"/></div>
					<div class="image_budget"><img class="budget'.($recette_budget < 3 ? ' semi_transparent' : '').'" src="images/euro.PNG"/></div>
				</div>-->
			<?php 
			}
			else
			{
			?>
				<div class="div_niveau" title="<?php if($recette_niveau) { echo $niveau_libelle;} else {echo '???';} ?>">
					<div class="titre_niveau"><?php if($recette_niveau) { echo $niveau_libelle;} else {echo '???';} ?></div>
					<div class="niveau">
						<div class="image_niveau <?php if($recette_niveau != null && $recette_niveau >= 1) echo "niveau_1";?>"></div>
						<div class="image_niveau <?php if($recette_niveau != null && $recette_niveau >= 2) echo "niveau_2";?>"></div>
						<div class="image_niveau <?php if($recette_niveau != null && $recette_niveau >= 3) echo "niveau_3";?>"></div>
						<div class="image_niveau <?php if($recette_niveau != null && $recette_niveau >= 4) echo "niveau_4";?>"></div>
					</div>
				</div>
				<div class="div_budget" title="<?php if($recette_budget != null) { echo $budget_libelle;} else {echo '???';} ?>">
					<div class="titre_budget"><?php if($recette_budget != null) { echo $budget_libelle;} else {echo '???';} ?></div>
					<div class="budget">
						<div class="image_budget <?php if($recette_budget != null&& $recette_budget >= 1) echo "niveau_1";?>"></div>
						<div class="image_budget <?php if($recette_budget != null&& $recette_budget >= 2) echo "niveau_2";?>"></div>
						<div class="image_budget <?php if($recette_budget != null&& $recette_budget >= 3) echo "niveau_3";?>"></div>
					</div>
				</div>
			<?php 
			}
		?>
					</div>
					
				</section>
				<article>
			<div class="temps_preparation">
				<header>
					<h2>Préparations</h2>
				</header>
				<br/>
				<div class="div_indicateur">
					<div class="image_indicateur">
						<img alt="Temps de préparation" title="temps de préparation" class="indicateur tooltip" src="images/temps3.PNG"/>
					</div>
					<div class="texte_indicateur">&#160;: 
					<?php 
						if ($modifier == 'O')
						{
					?>
							<input type="text" name = "rec_tps_prepa" id = "rec_tps_prepa" value="<?php echo $recette_tps_prepa; ?>" onchange="Update_champ_recette(this.id, this.value, <?php echo $recette_id; ?>)"/> min.
					<?php 
						}
						else
						{
							if ($recette_tps_prepa != null) echo $recette_tps_prepa." min."; else echo "-";
						}
					
					?> 
					</div>
				</div>
				<div class="div_indicateur">
					<div class="image_indicateur">
					<img alt="Temps de repos" title="temps de repos" class="indicateur tooltip" src="images/Temps_repos2.png"/>
					</div>
					<div class="texte_indicateur">&#160;: 
						<?php 
							if ($modifier == 'O')
							{
						?>
								<input type="text" name = "rec_tps_repos" id = "rec_tps_repos" value="<?php echo $recette_tps_repos; ?>" onchange="Update_champ_recette(this.id, this.value, <?php echo $recette_id; ?>)"/> min.
						<?php 
						}
							else
							{
								if ($recette_tps_repos != null) echo $recette_tps_repos." min."; else echo "-";
							}
						?>
					</div>
				</div>
				<div class="div_indicateur">
					<div class="image_indicateur">
					<img alt="Temps de cuisson" title="temps de cuisson" class="indicateur tooltip" src="images/Temps_cuisson_2.png"/>
					</div>
					<div class="texte_indicateur">&#160;: 
						<?php 
							if ($modifier == 'O')
							{
						?>
								<input type="text" name = "rec_tps_cuisson" id = "rec_tps_cuisson" value="<?php echo $recette_tps_cuisson; ?>" onchange="Update_champ_recette(this.id, this.value, <?php echo $recette_id; ?>);"/> min.
						<?php
							}
							else
							{
								if ($recette_tps_cuisson != null) echo $recette_tps_cuisson." min."; else echo "-";
							}
						?>
					</div>
				</div>
			</div>
			
				
		</article>

			</div>
			</div>

			
		</article>
		
	</section>

	<section class="categories">
		<article>
			<div>
				<script>
				$("body").on("change","#rec_sous_categorie",function(){
					   alert("clicked");
					});
				</script>
				
					<?php 
						if ($modifier == 'O')
						{
					?>
							Catégorie:&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;
							<select name = "rec_categorie" id = "rec_categorie" required onchange="recup_sous_categorie('sous_categorie', this.value, <?php echo $recette_id; ?>);Update_champ_recette(this.id, this.value, <?php echo $recette_id; ?>)">
								<option/>
								<?php
									foreach ($categories as $row_categories)
									{?>
										<option value="<?php echo $row_categories['CAT_ID']; ?>"<?php if($row_categories['CAT_ID'] == $recette_categorie) {echo ' selected="selected"';} ?>><?php echo $row_categories['CAT_TITRE']; ?></option>
								<?php	}
								?>	
							</select>
							<br/>
							Sous-catégorie:&#160;
							<span id="sous_categorie">
							
								<select name = "rec_sous_categorie" id = "rec_sous_categorie" onchange="Update_champ_recette(this.id, this.value, <?php echo $recette_id; ?>)" required>
								<option/>
								<?php
									foreach ($sous_categories as $row_sous_categories)
									{?>
										<option value="<?php echo $row_sous_categories['SCA_ID']; ?>"<?php if($row_sous_categories['SCA_ID'] == $recette_sous_categorie) {echo ' selected="selected"';} ?>><?php echo $row_sous_categories['SCA_TITRE']; ?></option>
								<?php	}
								?>	
							</select></span>
					<?php 
						}					
					?> 
				</div>
		</article>
	</section>
	
	<section class="ingredients">
		<article>
			<br/>
			<br/>
			<header>
				<h2>
					<?php
						// recuperation libelle de l unite de fabrication
						foreach ($unite_fabrication as $row_unite_fabrication)
						{
							$unite_fabrication_libelle = '';
							if($row_unite_fabrication['FAB_ID'] == $recette_uni_fab_id)
							{
								$unite_fabrication_libelle = $row_unite_fabrication['FAB_LIBELLE'];
								break;
							}
						}
					?>
					Ingrédients 
						<span class="nbPersonnes">
							<?php
							if ($modifier == "O")
							{
							?>
								<input type="text" name="rec_nb_convives" id="rec_nb_convives" value="<?php echo$recette_nb_convives; ?>" onchange="Update_champ_recette(this.id, this.value, <?php echo $recette_id; ?>)">
								<select name="rec_uni_fab_id" id="rec_uni_fab_id" onchange="Update_champ_recette(this.id, this.value, <?php echo $recette_id; ?>)">
								<option/>
								<?php 
								foreach ($unite_fabrication as $row_unite_fabrication)
								{
								?>
									<option value=<?php echo $row_unite_fabrication['FAB_ID'];?> <?php if($row_unite_fabrication['FAB_ID'] == $recette_uni_fab_id) { echo ' selected="selected"';} ?>> <?php echo $row_unite_fabrication['FAB_LIBELLE']; ?></option>
								<?php 
								}
								?>
							</select>
							<?php
							}
							else{
								echo '(Pour '.$recette_nb_convives.'&#160;'.$unite_fabrication_libelle.')';
							}
							?>
							
						</span>
					<?php
					if ($modifier == "O")
					{
					?>
					<input type="hidden" name="max_section_recette" id="max_section_recette" value="<?php echo $recette_ingredient_entete_max_id['MAX_ENTETE']; ?>"/>
					<a href="recette.php?recette_id=<?php echo $recette_id; ?>&amp;modifier=O&amp;ajout_sec_ing=O"><img class="ajout_section_ingredient" src="images/insertion.PNG"  onclick="Ajout_section_ingredient('max_section_recette', <?php echo $recette_id; ?>);"/></a>
					<?php 
						}					
					?>
				</h2>
			</header>
			<br/>
			<div id="entete_recette">
				<?php
				if ($modifier == 'O')
				{
					
					$liste_ingredients="";
					//foreach ($ingredients as $row_ingredients) $liste_ingredients = $liste_ingredients.'"'.$row_ingredients["ING_LIBELLE"].'",';
					foreach ($ingredients as $row_ingredients) $liste_ingredients = $liste_ingredients.'["'.$row_ingredients["ING_LIBELLE"].'","'.$row_ingredients["ING_ID"].'"],';
					//on cree une variable pour la liste des unités en ajout
					$liste_unite = "";
				?>
					<script type='text/javascript'>
					liste_unite = new Array();
					<?php
						foreach($unite_mesure as $row_unite_mesure){
						 
							echo "liste_unite[".$row_unite_mesure['UNI_ID']."] = '".$row_unite_mesure['UNI_LIBELLE']."';";
						 
						}
					?>	 
					</script>
					
					
					<?php
					//on liste les entete de recettes
					foreach ($recette_ingredient_entete as $row_recette_ingredient_entete)
					{
					?>
					<div class="colonne_ingredients" id="colonne_ingredients-<?php echo $row_recette_ingredient_entete['RIE_ID']; ?>">
						
						<table class="tableau_ingredient" id="tableau_ingredient-<?php echo $row_recette_ingredient_entete['RIE_ID']; ?>">
							<tr>
								<th colspan="2">Titre Recette : <input type="text" name="rie_libelle-<?php echo $row_recette_ingredient_entete['RIE_ID']; ?>" id="rie_libelle-<?php echo $row_recette_ingredient_entete['RIE_ID']; ?>" value="<?php echo $row_recette_ingredient_entete['RIE_LIBELLE']; ?>"  onchange="Update_champ_recette_entete_ingredient(this.id, this.value, <?php echo $recette_id; ?>, <?php echo $row_recette_ingredient_entete['RIE_ID']; ?>)"/>&#160;&#160;&#160;
									<img class="supprimer_petit" src="images/Supprimer.PNG" title="Supprimer la section" onclick="supprimer_section_ingredient(<?php echo $row_recette_ingredient_entete['RIE_ID']; ?>, 'colonne_ingredients-<?php echo $row_recette_ingredient_entete['RIE_ID']; ?>', <?php echo $recette_id; ?>);"/>
								</th>	
							</tr>
						<?php
						$count_nb_ingredients = 0;
						foreach ($recette_ingredient as $row_recette_ingredient)
						{
							
							if($row_recette_ingredient['RIE_ID'] == $row_recette_ingredient_entete['RIE_ID'])
							{
								$count_nb_ingredients = $count_nb_ingredients + 1;
								// recuperation libele de l ingredient
								foreach ($ingredients as $row_ingredients)
								{
									$recette_ingredient_libelle = '';
									if($row_ingredients['ING_ID'] == $row_recette_ingredient['ING_ID'])
									{
										$recette_ingredient_libelle = $row_ingredients['ING_LIBELLE'];
										break;
									}
								}
								// recuperation libelle de l unite de mesure
								foreach ($unite_mesure as $row_unite_mesure)
								{
									$unite_mesure_libelle = '';
									if($row_unite_mesure['UNI_ID'] == $row_recette_ingredient['UNI_ID'])
									{
										$unite_mesure_libelle = $row_unite_mesure['UNI_LIBELLE'];
										break;
									}
								}
								?>
								<tr class="ligne_ingredient-<?php echo $row_recette_ingredient['RIN_ID']; ?>">
										<td class="libelle_ingredient"><?php echo $recette_ingredient_libelle; ?> :</td>
										<td class="quantite_ingredient">
											<input type="hidden" name="chp:recette_ingredient_id-<?php echo $row_recette_ingredient['RIN_ID']; ?>" id="chp:recette_ingredient_id-<?php echo $row_recette_ingredient['RIN_ID']; ?>" value="<?php echo $row_recette_ingredient['RIN_ID']; ?>"/>
											<input type="text" name="rin_qte-<?php echo $row_recette_ingredient['RIN_ID']; ?>" id="rin_qte-<?php echo $row_recette_ingredient['RIN_ID']; ?>" value=" <?php echo $row_recette_ingredient['RIN_QTE']; ?>" onchange="Update_champ_recette_ingredient(this.id, this.value, <?php echo $row_recette_ingredient['RIN_ID']; ?>, <?php echo $recette_id; ?>)"/>
											<select name="uni_id-<?php echo $row_recette_ingredient['RIN_ID']; ?>" id="uni_id-<?php echo $row_recette_ingredient['RIN_ID']; ?>" onchange="Update_champ_recette_ingredient(this.id, this.value, <?php echo $row_recette_ingredient['RIN_ID']; ?>, <?php echo $recette_id; ?>)"><option/>
												<?php
												foreach ($unite_mesure as $row_unite_mesure)
												{
												?>
													<option value="<?php echo $row_unite_mesure['UNI_ID']; ?>" <?php if($row_unite_mesure['UNI_ID'] == $row_recette_ingredient['UNI_ID']) {echo ' selected="selected"';} ?>> <?php echo $row_unite_mesure['UNI_LIBELLE']; ?></option>
												<?php
												}
												?>
											</select>
											&#160;
											<img class="supprimer_petit" src="images/Supprimer.PNG" title="Supprimer l'ingrédient" onclick="Supprimer_Ligne(this, 'tableau_ingredient-<?php echo $row_recette_ingredient_entete['RIE_ID']; ?>', <?php echo $row_recette_ingredient['RIN_ID']; ?>, <?php echo $recette_id; ?>);"/>
										</td>
									</tr>
							<?php
							}
						}
					?>
					</table>
					<?php 
						if ($count_nb_ingredients == 0 )
						{
							?>Lien vers technique de base : 
							<select name="rec_id_lien-<?php echo $row_recette_ingredient_entete['RIE_ID'];?>" id="rec_id_lien-<?php echo $row_recette_ingredient_entete['RIE_ID'];?>" onchange="Update_champ_recette_entete_ingredient(this.id, this.value, <?php echo $recette_id; ?>, <?php echo $row_recette_ingredient_entete['RIE_ID']; ?>)">
							<option value="null"/>
							<?php 
							foreach ($recette_technique_base as $row_recette_technique_base)
							{
							?>
								<option value=<?php echo $row_recette_technique_base['REC_ID'];?> <?php if($row_recette_technique_base['REC_ID'] == $row_recette_ingredient_entete['REC_ID_LIEN']) { echo ' selected="selected"';} ?>> <?php echo $row_recette_technique_base['REC_TITRE']; ?></option>
							<?php 
							}
							?>
						</select>
						<?php 	
						}
					if($row_recette_ingredient_entete['REC_ID_LIEN'] == 0)
					{					
					?>
					<table id="AjoutIngredient-<?php echo $row_recette_ingredient_entete['RIE_ID']; ?>"><tr>
								<td>
									<input id="ingredientsId-<?php echo $row_recette_ingredient_entete['RIE_ID']; ?>" type="hidden" id="ingredientsId-<?php echo $row_recette_ingredient_entete['RIE_ID']; ?>"/>
									<input id="ingredients-<?php echo $row_recette_ingredient_entete['RIE_ID']; ?>" autofocus type="text" id="ingredients-<?php echo $row_recette_ingredient_entete['RIE_ID']; ?>" placeholder="Ajouter un ingrédient"/>
									<img class="ajout" src="images/insertion.PNG" title="Ajouter l'ingrédient" onclick="Ajout_Ligne('tableau_ingredient-<?php echo $row_recette_ingredient_entete['RIE_ID']; ?>', 'ingredients-<?php echo $row_recette_ingredient_entete['RIE_ID']; ?>', liste_unite, <?php echo $recette_id; ?>, <?php echo $row_recette_ingredient_entete['RIE_ID']; ?>, 'ingredientsId-<?php echo $row_recette_ingredient_entete['RIE_ID']; ?>');"/>
									<!--<INPUT type="image" class="ajout" src="images/insertion.PNG" onclick="Ajout_Ligne('tableau_ingredient-<?php echo $row_recette_ingredient_entete['RIE_ID']; ?>', 'ingredients-<?php echo $row_recette_ingredient_entete['RIE_ID']; ?>', liste_unite, <?php echo $recette_id; ?>, <?php echo $row_recette_ingredient_entete['RIE_ID']; ?>, 'ingredientsId-<?php echo $row_recette_ingredient_entete['RIE_ID']; ?>');"/>-->
									<br/>
									
									<script>
									
									//champ de recherche pour les ingrédient  
									  $(function(){
										$("#ingredients-<?php echo $row_recette_ingredient_entete['RIE_ID']; ?>").autoComplete({
											minChars: 1,
											source: function(term, suggest){
												term = term.toLowerCase();
												var choices = [<?php echo $liste_ingredients; ?>];
												var suggestions = [];
												
												for (i=0;i<choices.length;i++)
												{
													if (~choices[i][0].toLowerCase().indexOf(term)) suggestions.push(choices[i]);
													// 	alert(choices[i][0]);
												}
												suggest(suggestions);
												
											},
											renderItem: function (item, search){
												search = search.replace(/[-\/\\^$*+?.()|[\]{}]/g, '\\$&');
												var re = new RegExp("(" + search.split(' ').join('|') + ")", "gi");
												return '<div class="autocomplete-suggestion" data-ingredient="'+item[0]+'" data-id="'+item[1]+'" data-val="'+search+'"> '+item[0].replace(re, "<b>$1</b>")+'</div>';
											},
											onSelect: function(e, term, item){
												document.getElementById('ingredients-<?php echo $row_recette_ingredient_entete['RIE_ID']; ?>').value = item.data('ingredient');
												document.getElementById('ingredientsId-<?php echo $row_recette_ingredient_entete['RIE_ID']; ?>').value = item.data('id');
												//alert('Item "'+item.data('ingredient')+' ('+item.data('id')+')" selected by '+(e.type == 'keydown' ? 'pressing enter' : 'mouse click')+'.');
											}	
										});
									});
									</script>
						</td>
					<td/>
							</tr>
							<tr><td>&#160;</td></tr></table><?php }	?>
					</div>
					<?php
					}
				}
				else
				{
					foreach ($recette_ingredient_entete as $row_recette_ingredient_entete)
					{
					?>
						<div class="colonne_ingredients">
						<table class="tableau_ingredient">
							<tr>
								<th colspan="2"><?php echo $row_recette_ingredient_entete['RIE_LIBELLE']; ?></th>
							</tr>
						<?php
						
						//on regarde par rapport à la recette ou la recette mis en lien en technique de base
						if($row_recette_ingredient_entete['REC_ID_LIEN'] != 0)
						{
							//Récupération données ingredient recette
							$result_t_recette_lien_ingredient = $bdd->query("select RIN_ID, RIE_ID, REC_ID, ING_ID, RIN_COMMENTAIRE, RIN_QTE, UNI_ID from T_RECETTE_INGREDIENTS WHERE REC_ID = ".$row_recette_ingredient_entete['REC_ID_LIEN']." order by RIN_ID");
							$recette_ingredient = $result_t_recette_lien_ingredient->fetchAll(PDO::FETCH_ASSOC);
							foreach ($recette_ingredient as $row_recette_ingredient)
							{
								
								//on filtre les ingrédient liés à la recette
								
									// recuperation libele de l ingredient
									foreach ($ingredients as $row_ingredients)
									{
										$recette_ingredient_libelle = '';
										if($row_ingredients['ING_ID'] == $row_recette_ingredient['ING_ID'])
										{
											$recette_ingredient_libelle = $row_ingredients['ING_LIBELLE'];
											break;
										}
									}
									// recuperation libelle de l unite de mesure
									foreach ($unite_mesure as $row_unite_mesure)
									{
										$unite_mesure_libelle = '';
										if($row_unite_mesure['UNI_ID'] == $row_recette_ingredient['UNI_ID'])
										{
											$unite_mesure_libelle = $row_unite_mesure['UNI_LIBELLE'];
											break;
										}
									}
									?>
									<tr>
										<td class="libelle_ingredient"><?php echo $recette_ingredient_libelle; ?> :</td>
										<td class="quantite_ingredient"><?php echo $row_recette_ingredient['RIN_QTE'].'&#160;'.$unite_mesure_libelle; ?></td>
									</tr>
								<?php

							}
						}
						else
						{
							foreach ($recette_ingredient as $row_recette_ingredient)
							{
								
								//on filtre les ingrédient liés à la recette
								if($row_recette_ingredient['RIE_ID'] == $row_recette_ingredient_entete['RIE_ID'])
								{
									// recuperation libele de l ingredient
									foreach ($ingredients as $row_ingredients)
									{
										$recette_ingredient_libelle = '';
										if($row_ingredients['ING_ID'] == $row_recette_ingredient['ING_ID'])
										{
											$recette_ingredient_libelle = $row_ingredients['ING_LIBELLE'];
											break;
										}
									}
									// recuperation libelle de l unite de mesure
									foreach ($unite_mesure as $row_unite_mesure)
									{
										$unite_mesure_libelle = '';
										if($row_unite_mesure['UNI_ID'] == $row_recette_ingredient['UNI_ID'])
										{
											$unite_mesure_libelle = $row_unite_mesure['UNI_LIBELLE'];
											break;
										}
									}
									?>
									<tr>
										<td class="libelle_ingredient"><?php echo $recette_ingredient_libelle; ?> :</td>
										<td class="quantite_ingredient"><?php echo $row_recette_ingredient['RIN_QTE'].'&#160;'.$unite_mesure_libelle; ?></td>
									</tr>
								<?php
								}
							}
						}
						?>
						<tr>
								<td></td>
								<td></td>
							</tr>
							</table>	
						</div>
					<?php
					}
				}
				?>
				
				</div>
		</article>
	</section>
	<section class="etapes_recette" id="etapes_recette">
	<br/>
	<br/>
	<h2>
		Recette
		<?php
		if ($modifier == "O")
		{
		?>
		&#160;<img class="ajout" src="images/insertion.PNG" title="Ajouter l'ingrédient" onclick="Ajout_Etape(document.getElementById('Neta_id').value, <?php echo $recette_id; ?>);"/>
		<input type="hidden" name="Neta_id" id="Neta_id" value="<?php echo $recette_etapes_max_id->MAX_ETAPE; ?>"/>
		<?php 
		}
		?>
	</h2>
	<br/>
	<?php
		foreach ($etapes as $row_etapes)
		{
			$etapes_id =  $row_etapes['ETA_ID'];
			$etapes_titre =  $row_etapes['ETA_TITRE'];
			$etapes_description =  $row_etapes['ETA_DESCRIPTION'];
			$etapes_recette_lien =  $row_etapes['REC_ID_LIEN'];
			
			?>
			<article id="Etape_<?php echo $etapes_id; ?>">
				<header>
					<h3>
						<?php if ($modifier == "N")
						{
						?>
							<label><input type="checkbox"/>
						<?php 
						}
						?>
						Etape <?php echo $etapes_id; ?>&#160;:&#160;</label>
						<?php 
						if ($modifier == "O")
						{
							?>
							<input type="text" name="eta_titre-<?php echo $etapes_id; ?>" id="eta_titre-<?php echo $etapes_id; ?>" value=" <?php echo $etapes_titre; ?>" onchange="Update_champ_recette_etape('eta_titre-<?php echo $etapes_id; ?>', this.value, <?php echo $recette_id; ?>,'eta_id-<?php echo $etapes_id; ?>');"/>
							<?php
						}
						else
						{
							echo $etapes_titre;
						}
						?>
						&#160;<?php if ($row_etapes != end($etapes)){?><img class="ordre" src="images/chevron_bas.png" title="Descendre l'étape" onclick="alert('descendre');"/><?php } ?><?php if ($row_etapes != reset($etapes)){?><img class="ordre" src="images/chevron_haut.png" title="Monter l'étape" onclick="alert('Monter');"/><?php } ?>
						<?php if ($modifier == "O")
						{
						?>
						&#160;&#160;<img class="supprimer_petit" src="images/Supprimer.PNG" title="Supprimer la section" onclick="supprimer_etape(<?php echo $etapes_id; ?>, 'Etape_<?php echo $etapes_id; ?>', <?php echo $recette_id; ?>);"/>
						<?php 
						}
						?>
					</h3>
				</header>
				<div class="etape_recette" id="etape_recette">
				
				<?php
				$ressources_images = glob($nom_dossier."/" . $recette_id . "/etapes/".$etapes_id."/*.jpg");
						foreach ($ressources_images as $filename)
						{
							?>
							<div id="photo<?php echo $filename; ?>">
							<?php 
							echo '<a class="photo_link" href="'.$filename.'" data-lightbox="etape'.$etapes_id.'"><img class="photo" src="'.$filename.'" alt=""/></a>';
							if ($modifier == "O")
							{
								?>
								<img class="supprimer_petit" src="images/Supprimer.PNG" title="Supprimer l\'image" onclick="supprimer_image('<?php echo $filename; ?>', 'photo<?php echo $filename; ?>', <?php echo $recette_id; ?>, 'etape_recette');"/>
								
								<?php
							}
							?>
							</div>
							<?php
						}
						
				
			
				if ($modifier == "O")
				{
					?>
					
					<script type="text/javascript">
						$(document).ready(function() { 
							var options = { 
									target:   '#output-<?php echo $etapes_id; ?>',   // target element(s) to be updated with server response 
									beforeSubmit:  beforeSubmit,  // pre-submit callback 
									success:       afterSuccess,  // post-submit callback 
									uploadProgress: OnProgress, //upload progress callback 
									resetForm: true        // reset the form after successful submit 
								}; 
								
							 $('#MyUploadForm-<?php echo $etapes_id; ?>').submit(function() { 
									$(this).ajaxSubmit(options);  			
									// always return false to prevent standard browser submit and page navigation 
									return false; 
								}); 
								

						//function after succesful file upload (when server response)
						function afterSuccess()
						{
							$('#submit-btn-<?php echo $etapes_id; ?>').show(); //hide submit button
							$('#loading-img-<?php echo $etapes_id; ?>').hide(); //hide submit button
							$('#progressbox-<?php echo $etapes_id; ?>').delay( 1000 ).fadeOut(); //hide progress bar

						}

						//function to check file size before uploading.
						function beforeSubmit(){
							//check whether browser fully supports all File API
						   if (window.File && window.FileReader && window.FileList && window.Blob)
							{
								
								if( !$('#FileInput-<?php echo $etapes_id; ?>').val()) //check empty input filed
								{
									$("#output-<?php echo $etapes_id; ?>").html("Are you kidding me?");
									return false
								}
								
								var fsize = $('#FileInput-<?php echo $etapes_id; ?>')[0].files[0].size; //get file size
								var ftype = $('#FileInput-<?php echo $etapes_id; ?>')[0].files[0].type; // get file type
								

								//allow file types 
								switch(ftype)
								{
									case 'image/png': 
									case 'image/gif': 
									case 'image/jpeg': 
									case 'image/pjpeg':
									case 'text/plain':
									case 'text/html':
									case 'application/x-zip-compressed':
									case 'application/pdf':
									case 'application/msword':
									case 'application/vnd.ms-excel':
									case 'video/mp4':
										break;
									default:
										$("#output-<?php echo $etapes_id; ?>").html("<b>"+ftype+"</b> Unsupported file type!");
										return false
								}
								
								//Allowed file size is less than 5 MB (1048576)
								/*if(fsize>5242880) 
								{
									$("#output").html("<b>"+bytesToSize(fsize) +"</b> Too big file! <br />File is too big, it should be less than 5 MB.");
									return false
								}*/
										
								$('#submit-btn-<?php echo $etapes_id; ?>').hide(); //hide submit button
								$('#loading-img-<?php echo $etapes_id; ?>').show(); //hide submit button
								$("#output-<?php echo $etapes_id; ?>").html("");  
							}
							else
							{
								//Output error to older unsupported browsers that doesn't support HTML5 File API
								$("#output-<?php echo $etapes_id; ?>").html("Please upgrade your browser, because your current browser lacks some new features we need!");
								return false;
							}
						}

						//progress bar function
						function OnProgress(event, position, total, percentComplete)
						{
							//Progress bar
							$('#progressbox-<?php echo $etapes_id; ?>').show();
							$('#progressbar-<?php echo $etapes_id; ?>').width(percentComplete + '%') //update progressbar percent complete
							$('#statustxt-<?php echo $etapes_id; ?>').html(percentComplete + '%'); //update status text
							if(percentComplete>50)
								{
									$('#statustxt-<?php echo $etapes_id; ?>').css('color','#000'); //change status text to white after 50%
								}
						}

						//function to format bites bit.ly/19yoIPO
						function bytesToSize(bytes) {
						   var sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB'];
						   if (bytes == 0) return '0 Bytes';
						   var i = parseInt(Math.floor(Math.log(bytes) / Math.log(1024)));
						   return Math.round(bytes / Math.pow(1024, i), 2) + ' ' + sizes[i];
						}

						}); 

						</script>
					
					

					
					
					
					<div>
						<h3>Ajax File Uploader</h3>
							<form action="ajax/Upload_file/processupload.php" method="post" enctype="multipart/form-data" id="MyUploadForm-<?php echo $etapes_id; ?>">
							<input name="FileInput-<?php echo $etapes_id; ?>" id="FileInput-<?php echo $etapes_id; ?>" type="file" />
							<input name="FileOutput-<?php echo $etapes_id; ?>" id="FileOutput-<?php echo $etapes_id; ?>" type="hidden" value="../../ressources/<?php echo $recette_id; ?>/etapes/<?php echo $etapes_id; ?>/"/>
							<input name="Name_File_id-<?php echo $etapes_id; ?>" id="Name_File_id-<?php echo $etapes_id; ?>" type="hidden" value="<?php echo $etapes_id; ?>"/>
							<input type="hidden" name="index" id="index" value="<?php echo $etapes_id; ?>" />
							<input type="submit"  id="submit-btn-<?php echo $etapes_id; ?>" value="Upload" />
							<img src="images/ajax-loader.gif" id="loading-img" style="display:none;" alt="Please Wait"/>
							</form>
							<div id="progressbox-<?php echo $etapes_id; ?>" ><div id="progressbar-<?php echo $etapes_id; ?>"></div ><div id="statustxt-<?php echo $etapes_id; ?>">0%</div></div>
							<div id="output-<?php echo $etapes_id; ?>"></div>
					
						<input type="hidden" name="eta_id-<?php echo $etapes_id; ?>" id="eta_id-<?php echo $etapes_id; ?>" value="<?php echo $etapes_id; ?>"/>
						<?php
						if($etapes_recette_lien == 0)
						{
							?>
							<textarea name="eta_description-<?php echo $etapes_id; ?>" id="eta_description-<?php echo $etapes_id; ?>" rows="10" cols="200" onchange="Update_champ_recette_etape('eta_description-<?php echo $etapes_id; ?>', this.value, <?php echo $recette_id; ?>,'eta_id-<?php echo $etapes_id; ?>');"><?php echo $etapes_description; ?></textarea>
							<img class="lien_recette" src="images/lien_recette.png" title="Ajouter un lien à une technique de base" onclick="supprimer_image('<?php echo $filename; ?>', 'photo<?php echo $filename; ?>', <?php echo $recette_id; ?>, 'etape_recette');"/>
							<?php
						}
						else
						{
							?>
							<img class="lien_recette" src="images/broken-link.png" title="supprimer le lien vers la technique de base" onclick="supprimer_image('<?php echo $filename; ?>', 'photo<?php echo $filename; ?>', <?php echo $recette_id; ?>, 'etape_recette');"/>
							<?php
						}
						?>
					</div>
				<?php
				}
				else
				{
					
						
					
						

						?>
						<div>
						<?php 
						echo $etapes_description;
						?>
						</div>

					<?php
				
				}
				?>
				</div>
			</article>
			<br/>
			<br/>
		<?php
		}
	?>
	</section>
	<section class="astuce_remarque_recette" id="astuces_recette">
		<br/>
		<br/>
		<article>
			<header>
				<h3>
					Astuces/Remarques
					<?php
					if ($modifier == "O")
					{
					?>
					&#160;<img class="ajout" src="images/insertion.PNG" title="Ajouter l'astuce" onclick="Ajout_Astuce(document.getElementById('Nras_id').value, <?php echo $recette_id; ?>);"/>
					<input type="hidden" name="Nras_id" id="Nras_id" value="<?php echo $recette_a_max_id->MAX_ASTUCE; ?>"/>
					<?php
					}
					?>
				</h3>
			<br/>
			</header>
			<div>
			<ul class="astuces" id="astuces">
			<?php
			foreach ($recette_astuces as $row_recette_astuces)
			{
				$astuce_id =  $row_recette_astuces['RAS_ID'];
				$astuce_description =  $row_recette_astuces['RAS_DESCRIPTION'];
				
				if ($modifier == "O")
				{
					?>
					<li id="Astuce_<?php echo $astuce_id; ?>">
					<?php echo $astuce_id; ?>.&#160;&#160;
					<input type="hidden" name="ras_id-<?php echo $astuce_id; ?>" id="ras_id-<?php echo $astuce_id; ?>" value="<?php echo $astuce_id; ?>"/>
					<textarea name="ras_description-<?php echo $astuce_id; ?>" id="ras_description-<?php echo $astuce_id; ?>" rows="3" cols="200" onchange="Update_champ_recette_astuce('ras_description-<?php echo $astuce_id; ?>', this.value, <?php echo $recette_id; ?>,'ras_id-<?php echo $astuce_id; ?>');"><?php echo $astuce_description; ?></textarea>
					&#160;&#160;<img class="supprimer_petit" src="images/Supprimer.PNG" title="Supprimer l'astuce" onclick="supprimer_astuce(<?php echo $astuce_id; ?>, 'Astuce_<?php echo $astuce_id; ?>', <?php echo $recette_id; ?>);"/>
					<br/>
					<br/>
					</li>
			
				<?php
				}
				else
				{
					echo '<li>';
					echo $astuce_id.'.&#160;&#160';
					echo $astuce_description;
					echo '</li>';
				}
			}
				?>
			</ul>
			</div>
		</article>
			<br/>
			<br/>
		<?php
		if ($modifier == "O")
		{
			//AJOUTER UN BOUTON D'AJOUT D'ASTUCE
		}
		
		?>

	</section>
	<section class="bonus_recette">
		<article>
			<br/>
			<br/>
			<header>
				<h2>
					Ressources associées
				</h2>
			</header>
			<br/>
			<div align="center">
			
					<script type="text/javascript">
$(document).ready(function() { 
	var options = { 
			target:   '#output',   // target element(s) to be updated with server response 
			beforeSubmit:  beforeSubmit,  // pre-submit callback 
			success:       afterSuccess,  // post-submit callback 
			uploadProgress: OnProgress, //upload progress callback 
			resetForm: true        // reset the form after successful submit 
		}; 
		
	 $('#MyUploadForm').submit(function() { 
			$(this).ajaxSubmit(options);  			
			// always return false to prevent standard browser submit and page navigation 
			return false; 
		}); 
		

//function after succesful file upload (when server response)
function afterSuccess()
{
	$('#submit-btn').show(); //hide submit button
	$('#loading-img').hide(); //hide submit button
	$('#progressbox').delay( 1000 ).fadeOut(); //hide progress bar

}

//function to check file size before uploading.
function beforeSubmit(){
    //check whether browser fully supports all File API
   if (window.File && window.FileReader && window.FileList && window.Blob)
	{
		
		if( !$('#FileInput').val()) //check empty input filed
		{
			$("#output").html("Are you kidding me?");
			return false
		}
		
		var fsize = $('#FileInput')[0].files[0].size; //get file size
		var ftype = $('#FileInput')[0].files[0].type; // get file type
		

		//allow file types 
		switch(ftype)
        {
            case 'image/png': 
			case 'image/gif': 
			case 'image/jpeg': 
			case 'image/pjpeg':
			case 'text/plain':
			case 'text/html':
			case 'application/x-zip-compressed':
			case 'application/pdf':
			case 'application/msword':
			case 'application/vnd.ms-excel':
			case 'video/mp4':
                break;
            default:
                $("#output").html("<b>"+ftype+"</b> Unsupported file type!");
				return false
        }
		
		//Allowed file size is less than 5 MB (1048576)
		/*if(fsize>5242880) 
		{
			$("#output").html("<b>"+bytesToSize(fsize) +"</b> Too big file! <br />File is too big, it should be less than 5 MB.");
			return false
		}*/
				
		$('#submit-btn').hide(); //hide submit button
		$('#loading-img').show(); //hide submit button
		$("#output").html("");  
	}
	else
	{
		//Output error to older unsupported browsers that doesn't support HTML5 File API
		$("#output").html("Please upgrade your browser, because your current browser lacks some new features we need!");
		return false;
	}
}

//progress bar function
function OnProgress(event, position, total, percentComplete)
{
    //Progress bar
	$('#progressbox').show();
    $('#progressbar').width(percentComplete + '%') //update progressbar percent complete
    $('#statustxt').html(percentComplete + '%'); //update status text
    if(percentComplete>50)
        {
            $('#statustxt').css('color','#000'); //change status text to white after 50%
        }
}

//function to format bites bit.ly/19yoIPO
function bytesToSize(bytes) {
   var sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB'];
   if (bytes == 0) return '0 Bytes';
   var i = parseInt(Math.floor(Math.log(bytes) / Math.log(1024)));
   return Math.round(bytes / Math.pow(1024, i), 2) + ' ' + sizes[i];
}

}); 

</script>
			
				<h3>Ajax File Uploader</h3>
				<form action="ajax/Upload_file/processupload.php" method="post" enctype="multipart/form-data" id="MyUploadForm">
				<input name="FileInput" id="FileInput" type="file" />
				<input name="FileOutput" id="FileOutput" type="hidden" value="../../ressources/<?php echo $recette_id; ?>/"/>
				<input name="Name_File_id" id="Name_File_id" type="hidden" value="<?php echo $recette_id; ?>"/>
				<input type="hidden" name="index"  id="index" value="0" />
				<input type="submit"  id="submit-btn" value="Upload" />
				<img src="images/ajax-loader.gif" id="loading-img" style="display:none;" alt="Please Wait"/>
				</form>
				<div id="progressbox" ><div id="progressbar"></div ><div id="statustxt">0%</div></div>
				<div id="output"></div>
			</div>
			<div id="photos">

			<?php
				
				$ressources_images = glob($nom_dossier."/" . $recette_id . "/*.jpg");
				foreach ($ressources_images as $filename)
				{
					?>
					<div id="photo<?php echo $filename; ?>">
					 
					<a class="photo_link" href="<?php echo $filename; ?>" data-lightbox="example-set"><img class="photo" src="<?php echo $filename; ?>" alt=""/></a>
					<img class="supprimer_petit" src="images/Supprimer.PNG" title="Supprimer l\'astuce" onclick="supprimer_image('<?php echo $filename; ?>', 'photo<?php echo $filename; ?>', <?php echo $recette_id; ?>, 'photos');"/>
				
<input type="radio"  <?php if($filename == $recette_image_principale) { echo 'checked="checked"';} ?> name="rec_img_princ" id = "rec_img_princ" value="<?php echo $filename; ?>" onchange="Update_champ_recette(this.id, this.value, <?php echo $recette_id; ?>)"/>
				</div>
				<?php
				}
			?>
			
			
			</div>
			<div id="videos">
			
				<?php
					$ressources_videos = glob($nom_dossier."/" . $recette_id . "/*.mp4");
					foreach ($ressources_videos as $filename_video)
					{
				?>
						<div class="colonne_video">
							<table>
								<tr>
									<th>Recette gateau</th>
								</tr>
									<td><br/></td>
								<tr>
									<td>
										<video class="video_recette" controls src="<?php echo $filename_video; ?>">Ici la description alternative</video>
									</td>
								</tr>
								<tr>
									<td><br/></td>
								</tr>
							</table>
						</div>
				<?php				
				}
				?>
			</div>
	
		</article>
	</section>
	
	<section class="tags_recette">
		<br/>
		<br/>
		<article>
			<header>
				<h3>
					Tags
				</h3>
			</header>
            <input name="tags" name="REC_TAG" id="REC_TAG" value="<?php echo $recette_tag; ?>" onchange="Update_champ_recette(this.id, this.value, <?php echo $recette_id; ?>)">
		</article>
	</section>
 </main>

</body>
</html>