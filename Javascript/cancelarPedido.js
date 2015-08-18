var cancelado_pedido;
var parametros = new Array();
function cancelarPedido(pedido) {
	if( ! cancelado_pedido ) {
		parametros[0] = "pedido";
		parametros[1] = pedido;
		cancelado_pedido = new Ajax("http://"+location.hostname+"/procesos/cancelarPedido.php","POST",cancelarPedido,"Texto",parametros,"application/x-www-form-urlencoded" );
	} else {
		xml = cancelado_pedido.objecto.responseXML;
		if(xml.childNodes.length <= 1 ) {
			numero = xml.getElementsByTagName('pedido')[0].innerHTML;
			tr = document.getElementById(numero);
			if( tr.parentNode.getElementsByTagName('tr').length == 1 ) {
				tr.parentNode.parentNode.parentNode.innerHTML = "<div id=\"aviso\">No tienes ningun pedido</div>";
			} else {
				tr.parentNode.removeChild(tr);
			}
		} else {
			document.getElementById("pantallaError").className="mostrar";
			document.getElementById("mensajeError").className="mostrar";
			document.getElementById("mensajeError").innerHTML = xml.getElementsByTagName("error").innerHTML;
		}
		cancelado_pedido = null;
	}
}