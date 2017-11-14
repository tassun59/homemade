<?php echo '<section id="recettes" class="recettes">'; ?>
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
						<?php echo '<a href="recette.php?recette_id='.$recette_id.'">
							<div id="recette">
								<div id="image_recette">
									<img src="'.$recette_image_principale.'">
								</div>
								<div id="contenu_recette">
									<div id="titre_recette">'; ?>
										<?php echo $row_recettes['REC_TITRE']; ?><?php if ($recette_favori != '1') {?> <?php echo '&#160;<img id="favori" class="favori_liste tooltip" src="images/favori_3.PNG" title="Favori"/>'; ?><?php } ?>
									<?php echo '</div>
									<div id="indicateurs_recette">
										<div class="image_indicateur_liste">
											<img alt="Temps de préparation" title="temps de préparation" class="image_indicateur_liste tooltip" src="images/temps3.PNG"/>
										</div>
										<div class="texte_indicateur_liste">&#160;:'; ?>
										<?php 
											if ($recette_tps_prepa != null) echo $recette_tps_prepa." min."; else echo "-";
										?> <?php echo '&#160;&#160;&#160;&#160;&#160;
										</div>
										<div class="image_indicateur_liste">
											<img alt="Temps de repos" title="temps de repos" class="image_indicateur_liste tooltip" src="images/Temps_repos2.PNG"/>
										</div>
										<div class="texte_indicateur_liste">&#160;: '; ?>
											<?php 
												if ($recette_tps_repos != null) echo $recette_tps_repos." min."; else echo "-";
											?><?php echo '&#160;&#160;&#160;&#160;&#160;
										</div>
										<div class="image_indicateur_liste">
											<img alt="Temps de cuisson" title="temps de cuisson" class="image_indicateur_liste tooltip" src="images/Temps_cuisson_2.PNG"/>
										</div>
										<div class="texte_indicateur_liste">&#160;: '; ?>
											<?php 
												if ($recette_tps_cuisson != null) echo $recette_tps_cuisson." min."; else echo "-";
											?><?php echo '&#160;&#160;&#160;&#160;&#160;
										</div>
									</div>
									<div id="niveaux_liste">
										<div class="div_niveau_liste" title="';  ?> <?php if($niveau) {echo $niveau->NIV_LIBELLE;} else {echo '???';} ?> <?php echo '">
											<div class="titre_niveau">';  ?> <?php if($niveau) {echo $niveau->NIV_LIBELLE;} else {echo '???';} ?> <?php echo '</div>
											<div class="niveau">
												<div class="image_niveau'; ?> <?php if($niveau->NIV_ID != null && $niveau->NIV_ID >= 1) echo "niveau_1";?><?php echo '"></div>
												<div class="image_niveau'; ?> <?php if($niveau->NIV_ID != null && $niveau->NIV_ID >= 2) echo "niveau_2";?><?php echo '"></div>
												<div class="image_niveau'; ?> <?php if($niveau->NIV_ID != null && $niveau->NIV_ID >= 3) echo "niveau_3";?><?php echo '"></div>
												<div class="image_niveau'; ?> <?php if($niveau->NIV_ID != null && $niveau->NIV_ID >= 4) echo "niveau_4";?><?php echo '"></div>
											</div>
										</div>
										<div class="div_budget_liste" title="';  ?> <?php if($budget) {echo $budget->BUD_LIBELLE;} else {echo '???';} ?> <?php echo '">
											<div class="titre_budget">';  ?> <?php if($budget) {echo $budget->BUD_LIBELLE;} else {echo '???';} ?> <?php echo '</div>
											<div class="budget">
												<div class="image_budget'; ?> <?php if($budget->BUD_ID != null && $budget->BUD_ID >= 1) echo "niveau_1";?><?php echo '"></div>
												<div class="image_budget'; ?> <?php if($budget->BUD_ID != null && $budget->BUD_ID >= 2) echo "niveau_2";?><?php echo '"></div>
												<div class="image_budget'; ?> <?php if($budget->BUD_ID != null && $budget->BUD_ID >= 3) echo "niveau_3";?><?php echo '"></div>
											</div>
										</div>
									</div>

								</div>
							</div>
						</a>'; ?>
					<?php
				}
		?>
		
	<?php	
	echo '</section>'; ?>