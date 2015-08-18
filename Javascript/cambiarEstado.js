var cambiadoEstado;
var parametros = new Array();
function cambiarEstado(elemento) {
	if( ! cambiadoEstado ) {
		parametros[0] = elemento.name;
		if( document.getElementsByName(elemento.name)[0].checked == true ) {
			parametros[1] = 1;
		} else {
			parametros[1] = 0;
		}
		cambiadoEstado = new Ajax("http://"+location.hostname+"/procesos/cambiarEstado.php","POST",cambiarEstado,"Texto",parametros,"application/x-www-form-urlencoded" );
	} else {
		campo = cambiadoEstado.objecto.responseXML.getElementsByTagName('campo')[0].innerHTML;
		id = cambiadoEstado.objecto.responseXML.getElementsByTagName('id')[0].innerHTML;
		valor = cambiadoEstado.objecto.responseXML.getElementsByTagName('valor')[0].innerHTML;
		name="actualiza["+campo+"]["+id+"]";
		document.getElementsByName("actualiza["+campo+"]["+id+"]")[0].value = valor;
		cambiadoEstado = null;
	}
}