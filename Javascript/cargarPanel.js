function cargarPanel(panel) {
	switch (panel) {
		case "contacto":
			document.getElementById('contacto').className = "mostrar";
			break;
		case "aviso_legal":
			document.getElementById('aviso_legal').className = "mostrar";
			break;
		case "politicaCookies":
			document.getElementById('politicaCookies').className = "mostrar";
			break;
		case "privacidad":
			document.getElementById('privacidad').className = "mostrar";
			break;
	}
	document.getElementById('pantalla').className = "mostrar";
}