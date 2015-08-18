function permitirClick(permitido) {
	if( permitido ) {
		document.getElementById('pantalla').setAttribute("onclick","cerrarPanel(this)");
	} else {
		document.getElementById('pantalla').setAttribute("onclick","");
	}
}