<?php
	$result_t_recette = $bdd->prepare("update T_RECETTE set REC_DATE_MODIF = now() where REC_ID = :id_recette;");
	$result_t_recette->bindParam(":id_recette",$id_recette);
	$result_t_recette->execute();
?>
