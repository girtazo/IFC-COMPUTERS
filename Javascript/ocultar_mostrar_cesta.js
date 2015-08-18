function ocultar_mostrar_cesta() {
	if( document.getElementById('cuadro_cesta').className == "right mostrar" ) {
		document.getElementById('cuadro_cesta').className = "right ocultar";
	} else {
		document.getElementById('cuadro_cesta').className = "right mostrar";
	}
}