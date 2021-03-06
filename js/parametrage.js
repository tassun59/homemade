function Update_champ_param(nom_champ, valeur, id, table, nom_champ_id)
{

	var xhr = getXMLHttpRequest();

	xhr.onreadystatechange = function() {
		if (xhr.readyState == 4 && (xhr.status == 200 || xhr.status == 0)) {
			afficher_info_bulle('infoBulle', 'result', xhr.responseText);
		}
	};

	xhr.open("GET", "ajax/update_champ_param.php?table=" + table + "&nom_champ_id=" + nom_champ_id + "&id=" + id + "&nom_champ=" + nom_champ + "&valeur=" + valeur, true);
	xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	xhr.send(null);
	
}

function ajout_ligne_param(idChpAjout, chpAUpdater, NomTable, chpId){
	
	var xhr = getXMLHttpRequest();

	xhr.onreadystatechange = function() {
		if (xhr.readyState == 4 && (xhr.status == 200 || xhr.status == 0)) {
			afficher_info_bulle('infoBulle', 'result', xhr.responseText);
		}
	};

	xhr.open("GET", "ajax/ajout_ligne_param.php?chpAUpdater=" + chpAUpdater + "&valeur=" + document.getElementById(idChpAjout).value + "&NomTable=" + NomTable, false);
	xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	xhr.send(null);
	
	// On recupere l id de la ligne creee
	var idValeur = recupererId(idChpAjout, chpAUpdater, NomTable, chpId);
	var div = document.createElement("div");
	div.setAttribute("id", "ligne-" + idValeur);
	var parent = document.getElementById("liste");
	parent.appendChild(div);
	
	document.getElementById("ligne-" + idValeur).innerHTML = '<input type="hidden" name="id-'+idValeur+'" id="id-'+idValeur+'" value="'+idValeur+'"/><input type="text" name="libelle-'+idValeur+'" id="libelle-'+idValeur+'" value="'+document.getElementById(idChpAjout).value+'" onchange="Update_champ_param(this.id, this.value, '+idValeur+', '+NomTable+', '+chpId+');"/>&#160;<img class="supprimer_petit" src="images/Supprimer.png" title="Supprimer la ligne" onclick="Supprimer_ligne_param('+idValeur+', '+NomTable+', \'liste\', \'ligne-'+idValeur+'\', '+chpId+');"/>';
	
}


function Supprimer_ligne_param(id_param, NomTable, parent, child, chpId){
	
	if (confirm("voulez-vous supprimer la ligne?"))
	{
		var xhr = getXMLHttpRequest();

		xhr.onreadystatechange = function() {
			if (xhr.readyState == 4 && (xhr.status == 200 || xhr.status == 0)) {
				afficher_info_bulle('infoBulle', 'result', xhr.responseText);
			}
		};

		xhr.open("GET", "ajax/supprimer_ligne_param.php?id_param=" + document.getElementById(id_param).value + "&NomTable=" + NomTable + "&chpId=" + chpId, true);
		xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		xhr.send(null);

		delElem(parent, child)
	}
}

function recupererId(idChpAjout, chpAUpdater, NomTable, chpId){

		var xhr = getXMLHttpRequest();

		xhr.onreadystatechange = function() {
			if (xhr.readyState == 4 && (xhr.status == 200 || xhr.status == 0)) {
				document.getElementById('Resultat_Recherche').innerHTML = xhr.responseText;
			}
		};

		xhr.open("GET", "ajax/Recuperer_ligne_param.php?chpAUpdater=" + chpAUpdater + "&valeur=" + document.getElementById(idChpAjout).value + "&NomTable=" + NomTable + "&chpId=" + chpId, false);
		xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		xhr.send(null);
		
		return document.getElementById("id_param").value;
}


function ajout_ligne_param_2_champs(idChpAjout, chpAUpdater, idChpAjout2, chpAUpdater2, NomTable, chpId){
	
	var xhr = getXMLHttpRequest();

	xhr.onreadystatechange = function() {
		if (xhr.readyState == 4 && (xhr.status == 200 || xhr.status == 0)) {
			afficher_info_bulle('infoBulle', 'result', xhr.responseText);
		}
	};

	xhr.open("GET", "ajax/ajout_ligne_param_2_champs.php?chpAUpdater=" + chpAUpdater + "&valeur=" + document.getElementById(idChpAjout).value + "&chpAUpdater2=" + chpAUpdater2 + "&valeur2=" + document.getElementById(idChpAjout2).value + "&NomTable=" + NomTable, false);
	xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	xhr.send(null);
	
	// On recupere l id de la ligne creee
	var idValeur = recupererId(idChpAjout, chpAUpdater, NomTable, chpId);
	
	
	var div = document.createElement("div");
	div.setAttribute("id", "ligne-" + idValeur);
	var parent = document.getElementById("liste");
	parent.appendChild(div);
	
	document.getElementById("ligne-" + idValeur).innerHTML = '<input type="hidden" name="id-'+idValeur+'" id="id-'+idValeur+'" value="'+idValeur+'"/><input type="text" name="libelle-'+idValeur+'" id="libelle-'+idValeur+'" value="'+document.getElementById(idChpAjout).value+'" onchange="Update_champ_param(this.id, this.value, '+idValeur+', '+NomTable+', '+chpId+');"/>&#160;&#160<input type="text" name="champ2-'+idValeur+'" id="champ2-'+idValeur+'" value="'+document.getElementById(idChpAjout2).value+'" onchange="Update_champ_param(this.id, this.value, '+idValeur+', '+NomTable+', '+chpId+');"/>&#160;<img class="supprimer_petit" src="images/Supprimer.png" title="Supprimer la ligne" onclick="Supprimer_ligne_param('+idValeur+', '+NomTable+', \'liste\', \'ligne-'+idValeur+'\', '+chpId+');"/>';
	
	document.getElementById(idChpAjout).value = '';
	document.getElementById(idChpAjout2).value = '';
}

function ajout_ligne_param_4_champs(idChpAjout, chpAUpdater, idChpAjout2, chpAUpdater2, idChpAjout3, chpAUpdater3, idChpAjout4, chpAUpdater4, NomTable, chpId, listeTypesIngredients, liste_unites){
	
	var xhr = getXMLHttpRequest();

	xhr.onreadystatechange = function() {
		if (xhr.readyState == 4 && (xhr.status == 200 || xhr.status == 0)) {
			afficher_info_bulle('infoBulle', 'result', xhr.responseText);
		}
	};

	xhr.open("GET", "ajax/ajout_ligne_param_4_champs.php?chpAUpdater=" + chpAUpdater + "&valeur=" + document.getElementById(idChpAjout).value + "&chpAUpdater2=" + chpAUpdater2 + "&valeur2=" + document.getElementById(idChpAjout2).value + "&chpAUpdater3=" + chpAUpdater3 + "&valeur3=" + document.getElementById(idChpAjout3).value + "&chpAUpdater4=" + chpAUpdater4 + "&valeur4=" + document.getElementById(idChpAjout4).value + "&NomTable=" + NomTable, false);
	xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	xhr.send(null);
	
	// On recupere l id de la ligne creee
	var idValeur = recupererId(idChpAjout, chpAUpdater, NomTable, chpId);
	
	var listetypeIngredient = '<select name="champ2-'+idValeur+'" id="champ2-'+idValeur+'" onchange="Update_champ_param(chpAUpdater2, this.value, '+idValeur+', '+NomTable+', '+chpId+'))"><option/>';
	for (var i = 1; i < listeTypesIngredients.length; i++) {
		if(listeTypesIngredients[i])
		{
			if(i == document.getElementById(idChpAjout2).value)
			{
				listetypeIngredient = listetypeIngredient + '<option value="'+i+'" selected="selected">'+listeTypesIngredients[i]+'</option>';
			}
			else
			{
				listetypeIngredient = listetypeIngredient + '<option value="'+i+'">'+listeTypesIngredients[i]+'</option>';
			}
		}
	}
	listetypeIngredient = listetypeIngredient + '</select>';
	
	var listeUnite = '<select name="champ3-'+idValeur+'" id="champ3-'+idValeur+'" onchange="Update_champ_param(chpAUpdater3, this.value, '+idValeur+', '+NomTable+', '+chpId+'))"><option/>';
	for (var i = 1; i < liste_unites.length; i++) {
		if(liste_unites[i])
		{
			if(i == document.getElementById(idChpAjout3).value)
			{
				listeUnite = listeUnite + '<option value="'+i+'" selected="selected">'+liste_unites[i]+'</option>';
			}
			else
			{
				listeUnite = listeUnite + '<option value="'+i+'">'+liste_unites[i]+'</option>';
			}
		}
	}
	listeUnite = listeUnite + '</select>';
	
	var div = document.createElement("div");
	div.setAttribute("id", "ligne-" + idValeur);
	var parent = document.getElementById("liste");
	parent.appendChild(div);
	
	document.getElementById("ligne-" + idValeur).innerHTML = '<input type="hidden" name="id-'+idValeur+'" id="id-'+idValeur+'" value="'+idValeur+'"/><input type="text" name="libelle-'+idValeur+'" id="libelle-'+idValeur+'" value="'+document.getElementById(idChpAjout).value+'" onchange="Update_champ_param(this.id, this.value, '+idValeur+', '+NomTable+', '+chpId+');"/>&#160;'+listetypeIngredient+'&#160'+listeUnite+'&#160<input type="text" name="champ4-'+idValeur+'" id="champ4-'+idValeur+'" value="'+document.getElementById(idChpAjout4).value+'" onchange="Update_champ_param(this.id, this.value, '+idValeur+', '+NomTable+', '+chpId+');"/>&#160;&#160;&#160;<img class="supprimer_petit" src="images/Supprimer.png" title="Supprimer la ligne" onclick="Supprimer_ligne_param('+idValeur+', '+NomTable+', \'liste\', \'ligne-'+idValeur+'\', '+chpId+');"/>';
	
	document.getElementById(idChpAjout).value = '';
	document.getElementById(idChpAjout2).value = '';
	document.getElementById(idChpAjout3).value = '';
	document.getElementById(idChpAjout4).value = '';
}

