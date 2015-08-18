function cerrarPanel(elemento) {
	if(document.getElementById("mensajeError").className != "mostrar") {
		document.getElementById(elemento.id).className = "ocultar";
		document.getElementById("contacto").className = "ocultar";
		document.getElementById("aviso_legal").className = "ocultar";
		document.getElementById("privacidad").className = "ocultar";
		document.getElementById("politicaCookies").className = "ocultar";
		document.getElementById("informativa").className = "ocultar";
		document.getElementById("producto_detalle").className = "ocultar";
	}
}