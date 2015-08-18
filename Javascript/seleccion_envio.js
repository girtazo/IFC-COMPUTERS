var selecciona_envio;
var parametros = new Array();
function seleccion_envio(elemento) {
	if( ! selecciona_envio ) {
		parametros[0] ="id";
		parametros[1] = elemento.value;
		parametros[2] = "incremento_pago";
		recargo = document.getElementsByName("incremento_pago")[0].innerHTML;
		parametros[3] = recargo.substr( 0, recargo.length -1 );
		selecciona_envio = new Ajax( "http://"+location.hostname+"/procesos/seleccion_envio.php","POST",seleccion_envio,"Texto",parametros,"application/x-www-form-urlencoded" );
	} else {
		validacion.numero_parametro = 0;
		xml = selecciona_envio.objecto.responseXML;
		document.getElementsByName("empresa_envio")[0].innerHTML = xml.getElementsByTagName("empresa")[0].innerHTML;
		document.getElementsByName("tipo_envio")[0].innerHTML = xml.getElementsByTagName("tipo")[0].innerHTML;
		document.getElementsByName("coste_envio")[0].innerHTML = xml.getElementsByTagName("coste")[0].innerHTML+"€";
		document.getElementsByName("recargo")[0].innerHTML = xml.getElementsByTagName("recargo")[0].innerHTML+"€";
		document.getElementById("productos").getElementsByTagName("tfoot")[0].getElementsByTagName("tr")[2].getElementsByTagName("td")[3].innerHTML = xml.getElementsByTagName("total")[0].innerHTML+"€";
		selecciona_envio =null;
	}
}