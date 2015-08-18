var pedido;
var parametros = new Array();
function pedir_pedido() {
	if( ! pedido ) {
		parametros[0] = "pedido[envio]";
		for(i = 0;i < document.getElementsByName("envio").length;i++ ) {
			if( document.getElementsByName("envio")[i].checked ) {
				parametros[1] = document.getElementsByName("envio")[i].value;
			}
		}
		parametros[2] = "pedido[pago]";
		for(i = 0;i < document.getElementsByName("pago").length;i++ ) {
			if( document.getElementsByName("pago")[i].checked ) {
				parametros[3] = document.getElementsByName("pago")[i].value;
			}
		}
		pedido = new Ajax("http://"+location.hostname+"/procesos/pedir_pedido.php","POST",pedir_pedido,"Texto",parametros,"application/x-www-form-urlencoded" );
	} else {
		document.getElementById('informativa').innerHTML = pedido.objecto.responseXML.getElementsByTagName("aviso")[0].innerHTML;
		document.getElementById("pantalla").className = "mostrar";
		document.getElementById("informativa").className = "mostrar";
		pedido = null;
	}
}