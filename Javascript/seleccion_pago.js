var selecciona_pago;
var parametros = new Array();
function seleccion_pago(elemento) {
	if( ! selecciona_pago ) {
		parametros[0] ="id";
		parametros[1] = elemento.value;
		selecciona_pago = new Ajax("http://"+location.hostname+"/procesos/seleccion_pago.php","POST",seleccion_pago,"Texto",parametros,"application/x-www-form-urlencoded" );
	} else {
		validacion.numero_parametro = 0;
		xml = selecciona_pago.objecto.responseXML;
		document.getElementsByName("tipo_pago")[0].innerHTML = xml.getElementsByTagName("tipo")[0].innerHTML;
		document.getElementsByName("incremento_pago")[0].innerHTML = xml.getElementsByTagName("incremento")[0].innerHTML+"%";
		document.getElementById("productos").getElementsByTagName("tfoot")[0].getElementsByTagName("tr")[0].getElementsByTagName("td")[3].innerHTML = xml.getElementsByTagName("recargo")[0].innerHTML+"€";
		document.getElementById("productos").getElementsByTagName("tfoot")[0].getElementsByTagName("tr")[2].getElementsByTagName("td")[3].innerHTML = xml.getElementsByTagName("total")[0].innerHTML+"€";
		selecciona_pago =null;
	}
}