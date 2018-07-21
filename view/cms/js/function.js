function mvc_toggle( id ) {
    var x = document.getElementById(id);
    if (x.style.display === "none" || !x.style.display) {
        x.style.display = "block";
    } else {
        x.style.display = "none";
    }
}

function mvc_setDisplay( element , set_display) {
	var first = element.charAt(0);
	if (first=='.'){
		element = element.split('.').join('');
		var x = document.getElementsByClassName(element);
		for (i = 0; i < x.length; i++) {
		    x[i].style.display = set_display;
		}
		console.log('clase');
	}

	if (first=='#'){
		element = element.split('#').join('');
		var x = document.getElementById(element);
		x.style.display = set_display;
		console.log('id');
	}
}