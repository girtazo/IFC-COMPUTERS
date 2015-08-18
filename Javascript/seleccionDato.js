var valorAnterior;
function seleccionDato(elemento) {
	elemento.parentNode.className = "modificable hover";
	valorAnterior = elemento.textContent; 
}