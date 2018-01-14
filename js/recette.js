function AfficherMasquerQuantite(champ, input_qte, champ_libelle, nom_champ,  rec_id, mat_id){
	if(champ.checked == true)
	{
		document.getElementById(input_qte).type='text';
		document.getElementById(champ_libelle).setAttribute("class","");
		insert_delete_champ_recette_materiel(nom_champ, rec_id, mat_id, 'I');
	}
	else
	{
		document.getElementById(input_qte).type='hidden';
		document.getElementById(champ_libelle).setAttribute("class","grey");
		insert_delete_champ_recette_materiel(nom_champ, rec_id, mat_id, 'D');
	}
}


function Recuperer_Rin_Id(rec_id, rie_id, ing_id){

		var xhr = getXMLHttpRequest();

		xhr.onreadystatechange = function() {
			if (xhr.readyState == 4 && (xhr.status == 200 || xhr.status == 0)) {
				document.getElementById('Resultat_Recherche').innerHTML = xhr.responseText;
			}
		};

		xhr.open("GET", "ajax/Recuperer_Rin_Id.php?rec_id=" + rec_id + "&rie_id=" + rie_id + "&ing_id=" + ing_id, false);
		xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		xhr.send(null);
		
		return document.getElementById("rin_id").value;
}


function Ajout_Ligne(tableID, AjoutID, listeUnites, rec_id, rie_id, ing_id){
	
	
	
		var xhr = getXMLHttpRequest();

		xhr.onreadystatechange = function() {
			if (xhr.readyState == 4 && (xhr.status == 200 || xhr.status == 0)) {
				afficher_info_bulle('infoBulle', 'result', xhr.responseText);
			}
		};

		xhr.open("GET", "ajax/ajout_ingredient.php?rec_id=" + rec_id + "&rie_id=" + rie_id + "&ing_id=" + document.getElementById(ing_id).value, false);
		xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		xhr.send(null);

	var Rin_d = Recuperer_Rin_Id(rec_id, rie_id, document.getElementById(ing_id).value);
	var listeUnite = '<select name="uni_id-'+Rin_d+'" id="uni_id-'+Rin_d+'" onchange="Update_champ_recette_ingredient(this.id, this.value, '+Rin_d+', '+rec_id+')"><option/>';
	for (var i = 1; i < listeUnites.length; i++) {
		listeUnite = listeUnite + '<option value="'+i+'">'+listeUnites[i]+'</option>'
	}
	listeUnite = listeUnite + '</select>';
	var newRow = document.getElementById(tableID).insertRow(-1);
	var newCell = newRow.insertCell(0);
	newCell.innerHTML = '<td class="libelle_ingredient">'+ document.getElementById(AjoutID).value +' :</td>';
	newCell = newRow.insertCell(1);
	newCell.innerHTML = '<td class="quantite_ingredient"><input type="hidden" name="chp:recette_ingredient_id-'+Rin_d+'" id="chp:recette_ingredient_id-'+Rin_d+'" value="'+Rin_d+'"/><input type="text" name="rin_qte-'+Rin_d+'" id="rin_qte-'+Rin_d+'" onchange="Update_champ_recette_ingredient(this.id, this.value, '+Rin_d+', '+rec_id+')"/>&#160;&#160;'+listeUnite+'</td>';
	document.getElementById(AjoutID).value = "";
	document.getElementById(ing_id).value = "";
}



function Supprimer_Ligne(r,tableID, rin_id, rec_id){
	
	if (confirm("voulez-vous supprimer l'ingrédient?"))
	{
		var xhr = getXMLHttpRequest();

		xhr.onreadystatechange = function() {
			if (xhr.readyState == 4 && (xhr.status == 200 || xhr.status == 0)) {
				afficher_info_bulle('infoBulle', 'result', xhr.responseText);
			}
		};

		xhr.open("GET", "ajax/supprimer_ingredient.php?rin_id=" + rin_id + "&rec_id=" + rec_id, true);
		xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		xhr.send(null);

		var i = r.parentNode.parentNode.rowIndex;
		document.getElementById(tableID).deleteRow(i);
	}
}
	

function recup_sous_categorie(div_id, cat_id, rec_id){

		var xhr = getXMLHttpRequest();

		xhr.onreadystatechange = function() {
			if (xhr.readyState == 4 && (xhr.status == 200 || xhr.status == 0)) {
				if (document.getElementById(div_id))
					document.getElementById(div_id).innerHTML = xhr.responseText;
			}
		};

		xhr.open("GET", "ajax/recup_sous_categorie.php?cat_id=" + cat_id + "&rec_id=" + rec_id, true);
		xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		xhr.send(null);


}

function recup_sous_categorie(div_id, cat_id){

		var xhr = getXMLHttpRequest();

		xhr.onreadystatechange = function() {
			if (xhr.readyState == 4 && (xhr.status == 200 || xhr.status == 0)) {
				if (document.getElementById(div_id))
					document.getElementById(div_id).innerHTML = xhr.responseText;
			}
		};

		xhr.open("GET", "ajax/recup_sous_categorie.php?cat_id=" + cat_id, true);
		xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		xhr.send(null);


}


function supprimer_section_ingredient(rie_id, id_div, rec_id){
	
	if (confirm("voulez-vous supprimer la section?"))
	{
		var xhr = getXMLHttpRequest();

		xhr.onreadystatechange = function() {
			if (xhr.readyState == 4 && (xhr.status == 200 || xhr.status == 0)) {
				delElem('entete_recette', id_div);
				afficher_info_bulle('infoBulle', 'result', xhr.responseText);

			}
		};

		xhr.open("GET", "ajax/supprimer_section.php?rec_id=" + rec_id + "&rie_id=" + rie_id, true);
		xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		xhr.send(null);
	}
}

function delElem(parent, child)
{
var obj = document.getElementById(parent);
var old = document.getElementById(child);

obj.removeChild(old);
}



function afficher_info_bulle(id_info_bulle, id_chp_etat, message)
{
	if (document.getElementById(id_info_bulle))
	{
		document.getElementById(id_info_bulle).innerHTML = message;
		if(document.getElementById(id_chp_etat).value=='succes')
		{
			document.getElementById(id_info_bulle).setAttribute("class","success");
		}
		else
		{
			document.getElementById(id_info_bulle).setAttribute("class","error");
		}
		$(document).ready(function(){
		$('#'+id_info_bulle).fadeIn(100).delay(1500).fadeOut(1000);
		});
	}
}

function Update_champ_recette(nom_champ, valeur, rec_id)
{

	var xhr = getXMLHttpRequest();

	xhr.onreadystatechange = function() {
		if (xhr.readyState == 4 && (xhr.status == 200 || xhr.status == 0)) {
			afficher_info_bulle('infoBulle', 'result', xhr.responseText);
		}
	};

	xhr.open("GET", "ajax/update_champ_recette.php?rec_id=" + rec_id + "&nom_champ=" + nom_champ + "&valeur=" + valeur, true);
	xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	xhr.send(null);
	
}


function Update_champ_recette_etape(nom_champ, valeur, rec_id, eta_id)
{
	
	var xhr = getXMLHttpRequest();

	xhr.onreadystatechange = function() {
		if (xhr.readyState == 4 && (xhr.status == 200 || xhr.status == 0)) {
			afficher_info_bulle('infoBulle', 'result', xhr.responseText);
		}
	};

	xhr.open("POST", "ajax/update_champ_recette_etape.php?", true);
	xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	xhr.send("eta_id=" + document.getElementById(eta_id).value + "&rec_id=" + rec_id + "&nom_champ=" + nom_champ.substring(0, nom_champ.indexOf('-')) + "&valeur=" + valeur);
	
}

function Update_champ_recette_astuce(nom_champ, valeur, rec_id, ras_id)
{
	
	var xhr = getXMLHttpRequest();

	xhr.onreadystatechange = function() {
		if (xhr.readyState == 4 && (xhr.status == 200 || xhr.status == 0)) {
			afficher_info_bulle('infoBulle', 'result', xhr.responseText);
		}
	};

	xhr.open("POST", "ajax/update_champ_recette_astuce.php?", true);
	xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	xhr.send("ras_id=" + document.getElementById(ras_id).value + "&rec_id=" + rec_id + "&nom_champ=" + nom_champ.substring(0, nom_champ.indexOf('-')) + "&valeur=" + valeur);
	
}

function insert_delete_champ_recette_materiel(nom_champ, rec_id, mat_id, type)
{
	
	var xhr = getXMLHttpRequest();

	xhr.onreadystatechange = function() {
		if (xhr.readyState == 4 && (xhr.status == 200 || xhr.status == 0)) {
			afficher_info_bulle('infoBulle', 'result', xhr.responseText);
		}
	};

	xhr.open("POST", "ajax/insert_delete_champ_recette_materiel.php?", true);
	xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	xhr.send("mat_id=" + document.getElementById(mat_id).value + "&rec_id=" + rec_id + "&nom_champ=" + nom_champ.substring(0, nom_champ.indexOf('-')) + "&valeur=" + nom_champ.substring(nom_champ.indexOf('-')+1, nom_champ.length) + "&type=" + type);
	
}

function Update_champ_recette_materiel(nom_champ, valeur, rec_id, mat_id)
{
	
	var xhr = getXMLHttpRequest();

	xhr.onreadystatechange = function() {
		if (xhr.readyState == 4 && (xhr.status == 200 || xhr.status == 0)) {
			afficher_info_bulle('infoBulle', 'result', xhr.responseText);
		}
	};

	xhr.open("POST", "ajax/update_champ_recette_materiel.php?", true);
	xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	xhr.send("mat_id=" + mat_id.substring(mat_id.indexOf('-')+1, mat_id.length) + "&rec_id=" + rec_id + "&nom_champ=" + nom_champ.substring(0, nom_champ.indexOf('-')) + "&valeur=" + valeur);
	
}

function Update_champ_recette_entete_ingredient(nom_champ, valeur, rec_id, rie_id)
{
	
	var xhr = getXMLHttpRequest();

	xhr.onreadystatechange = function() {
		if (xhr.readyState == 4 && (xhr.status == 200 || xhr.status == 0)) {
			afficher_info_bulle('infoBulle', 'result', xhr.responseText);
			
		}
	};

	xhr.open("POST", "ajax/update_champ_recette_entete_ingredient.php?", true);
	xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	xhr.send("rie_id=" + rie_id + "&rec_id=" + rec_id + "&nom_champ=" + nom_champ.substring(0, nom_champ.indexOf('-')) + "&valeur=" + valeur);
	
}

function Update_champ_recette_ingredient(nom_champ, valeur, rin_id, rec_id)
{

	var xhr = getXMLHttpRequest();

	xhr.onreadystatechange = function() {
		if (xhr.readyState == 4 && (xhr.status == 200 || xhr.status == 0)) {
			afficher_info_bulle('infoBulle', 'result', xhr.responseText);
		}
	};

	xhr.open("GET", "ajax/update_champ_recette_ingredient.php?rec_id=" +rec_id+ "&rin_id=" + rin_id + "&nom_champ=" + nom_champ.substring(0, nom_champ.indexOf('-')) + "&valeur=" + valeur, true);
	xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	xhr.send(null);
	
}


function Ajout_Etape(EtapeID, rec_id){
	
	
	Etape_suiv = 1 + Number(EtapeID);
		var xhr = getXMLHttpRequest();

		xhr.onreadystatechange = function() {
			if (xhr.readyState == 4 && (xhr.status == 200 || xhr.status == 0)) {
				afficher_info_bulle('infoBulle', 'result', xhr.responseText);
			}
		};

		xhr.open("GET", "ajax/ajout_etape.php?rec_id=" + rec_id + "&eta_id=" + Etape_suiv, false);
		xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		xhr.send(null);

	// Crée un nouvel élément de paragraphe
var article = document.createElement("article");
var br = document.createElement("br");
var br2 = document.createElement("br");
article.setAttribute("id", "Etape_" + Etape_suiv);
// l'ajoute à la fin du corps du document
document.getElementById("etapes_recette").appendChild(article);
document.getElementById("Etape_" + Etape_suiv).innerHTML = '<header><h3>Etape '+Etape_suiv+'</h3></header><div><input type="hidden" name="eta_id-'+Etape_suiv+'" id="eta_id-'+Etape_suiv+'" value="'+Etape_suiv+'"/><textarea name="eta_description-'+Etape_suiv+'" id="eta_description-'+Etape_suiv+'" rows="10" cols="200" onchange="Update_champ_recette_etape(\'eta_description-'+Etape_suiv+'\', this.value, '+Etape_suiv+',\'eta_id-'+Etape_suiv+'\');"></textarea></div>';
document.getElementById("etapes_recette").appendChild(br);
document.getElementById("etapes_recette").appendChild(br2);
document.getElementById("Neta_id").value = Etape_suiv;
}


function supprimer_etape(eta_id, id_article, rec_id){
	
	if (confirm("voulez-vous supprimer l'étape?"))
	{
		var xhr = getXMLHttpRequest();

		xhr.onreadystatechange = function() {
			if (xhr.readyState == 4 && (xhr.status == 200 || xhr.status == 0)) {
				delElem('etapes_recette', id_article);
				afficher_info_bulle('infoBulle', 'result', xhr.responseText);

			}
		};

		xhr.open("GET", "ajax/supprimer_etape.php?rec_id=" + rec_id + "&eta_id=" + eta_id, true);
		xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		xhr.send(null);
	}
}


function Ajout_Astuce(AstuceID, rec_id){
	
	
	Astuce_suiv = 1 + Number(AstuceID);

		var xhr = getXMLHttpRequest();

		xhr.onreadystatechange = function() {
			if (xhr.readyState == 4 && (xhr.status == 200 || xhr.status == 0)) {
				afficher_info_bulle('infoBulle', 'result', xhr.responseText);
			}
		};

		xhr.open("GET", "ajax/ajout_astuce.php?rec_id=" + rec_id + "&ras_id=" + Astuce_suiv, false);
		xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		xhr.send(null);

	// Crée un nouvel élément de paragraphe
var li = document.createElement("li");
li.setAttribute("id", "Astuce_" + Astuce_suiv);
// l'ajoute à la fin du corps du document
document.getElementById("astuces").appendChild(li);
document.getElementById("Astuce_" + Astuce_suiv).innerHTML = Astuce_suiv+'.&#160;&#160;<input type="hidden" name="ras_id-'+Astuce_suiv+'" id="ras_id-'+Astuce_suiv+'" value="'+Astuce_suiv+'"/><textarea name="ras_description-'+Astuce_suiv+'" id="ras_description-'+Astuce_suiv+'" rows="3" cols="200" onchange="Update_champ_recette_astuce(\'ras_description-'+Astuce_suiv+'\', this.value, '+rec_id+',\'ras_id-'+Astuce_suiv+'\');"></textarea>&#160;&#160;<img class="supprimer_petit" src="images/Supprimer.PNG" title="Supprimer l\'astuce" onclick="supprimer_astuce('+Astuce_suiv+', \'Astuce_'+Astuce_suiv+'\', '+ rec_id +');"/><br/><br/>';
document.getElementById("Nras_id").value = Astuce_suiv;
}


function supprimer_astuce(ras_id, id_li, rec_id){
	
	if (confirm("voulez-vous supprimer l'étape?"))
	{
		var xhr = getXMLHttpRequest();

		xhr.onreadystatechange = function() {
			if (xhr.readyState == 4 && (xhr.status == 200 || xhr.status == 0)) {
				delElem('astuces', id_li);
				afficher_info_bulle('infoBulle', 'result', xhr.responseText);

			}
		};

		xhr.open("GET", "ajax/supprimer_astuce.php?rec_id=" + rec_id + "&ras_id=" + ras_id, true);
		xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		xhr.send(null);
	}
}


function update_favori(rec_id, id_favori)
{
	if(document.getElementById('result') && document.getElementById('result').value == 'succes')
	{
		if(document.getElementById(id_favori).value == 0)
		{
			document.getElementById('favori').className='favori tooltip';
			document.getElementById(id_favori).value = 1;
		}
		else
		{
			document.getElementById('favori').className='favori tooltip semi_transparent';
			document.getElementById(id_favori).value = 0;
		}
	}
	Update_champ_recette(id_favori, document.getElementById(id_favori).value, rec_id);
	
}

function creer()
{
	
	select_categorie = document.getElementById("rec_categorie");
	choice_categorie = select_categorie.selectedIndex;
	valeur_cherchee_categorie = select_categorie.options[choice_categorie].value;

	
	select_sscategorie = document.getElementById("REC_SOUS_CATEGORIE");
	choice_sscategorie = select_sscategorie.selectedIndex;
	valeur_cherchee_sscategorie = select_sscategorie.options[choice_sscategorie].value;
	
	document.location.href = 'recette.php?new=O&categorie='+valeur_cherchee_categorie +'&sscategorie='+valeur_cherchee_sscategorie;
}

function concatener(id, max)
{
	document.getElementById('ingredients').value = '';
	document.getElementById('nbingredients').value = '';
	var count=0;
	for (i=1; i <= max; ++i) {
        if (document.getElementById(id + i).checked == true) {
            document.getElementById('ingredients').value = document.getElementById('ingredients').value + document.getElementById(id + i).value + ',';
			count = count + 1;
        }
    }
	document.getElementById('ingredients').value = document.getElementById('ingredients').value.substring(0, document.getElementById('ingredients').value.length - 1);
	document.getElementById('nbingredients').value = count;
}


function montrerCacher(id)
{
	if(document.getElementById(id).style.display == 'block')
	{
		document.getElementById(id).style.display = 'none';
	}
	else
	{
		document.getElementById(id).style.display = 'block';
	}
	
}


function supprimer_image(filename, id_div, rec_id, id_parent){
	
	if (confirm("voulez-vous supprimer l'image?"))
	{
		var xhr = getXMLHttpRequest();

		xhr.onreadystatechange = function() {
			if (xhr.readyState == 4 && (xhr.status == 200 || xhr.status == 0)) {
				delElem(id_parent, id_div);
				afficher_info_bulle('infoBulle', 'result', xhr.responseText);

			}
		};

		xhr.open("GET", "ajax/supprimer_image_recette.php?filename=" + filename + "&rec_id=" + rec_id, true);
		xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		xhr.send(null);
	}
}


