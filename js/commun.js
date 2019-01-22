function scrolled(){

	var className = ((document.body.scrollTop || document.documentElement.scrollTop) >= header.offsetHeight - 90) ? "fixe" : "";
	document.getElementById("menuNavigation").setAttribute("class",className);
}
