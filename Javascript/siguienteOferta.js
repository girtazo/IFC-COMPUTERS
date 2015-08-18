function siguienteOferta() {
	slider = document.getElementById('slider_lista');
	margen = slider.style.marginTop;
	if( margen == "" ) {
		margen = css_selector("ul").marginTop;
	}
	margen = margen.substr( 0, margen.length - 2 );
	margen = parseInt(margen);
	if( margen > ( ( ( slider.getElementsByTagName('li').length - 1 ) * 352 ) * -1 ) ) {
		margen = margen - 352;
		margen =  margen.toString();
		margen = margen + "px";
		document.getElementById('slider_lista').style.marginTop = margen;
	}
}