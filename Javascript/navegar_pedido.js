var navegado_pedido;
var parametros = new Array();
function navegar_pedido(elemento) {
	if( ! navegado_pedido ) {
		parametros[0] = "productos";
		parametros[1] = elemento.alt;
		navegado_pedido = new Ajax("http://"+location.hostname+"/procesos/navegar_pedido.php","POST",navegar_pedido,"Texto",parametros,"application/x-www-form-urlencoded" );
	} else {
		validacion.numero_parametro = 0;
		xml = navegado_pedido.objecto.responseXML;
		numeroCambiarFilas = document.getElementById("productos").getElementsByTagName("tbody")[0].getElementsByTagName("tr").length;
		productos = xml.getElementsByTagName("producto").length;
		if( numeroCambiarFilas < productos ) {
			productos = productos - numeroCambiarFilas;
		} else if( numeroCambiarFilas > productos ) {
			aux = numeroCambiarFilas;
			numeroCambiarFilas = productos;
			productos = productos - aux;
		} else {
			productos = 0;
		}
		if(xml.getElementsByTagName("productos")[0].hasChildNodes()) {
			for(td = 0;td < numeroCambiarFilas;td = td + 1) {
				if( td == 0 ) {
					document.getElementById("productos").getElementsByTagName("td")[td].innerHTML = xml.getElementsByTagName("producto")[td].getElementsByTagName("nombre")[0].innerHTML;
					document.getElementById("productos").getElementsByTagName("td")[td+1].innerHTML = xml.getElementsByTagName("producto")[td].getElementsByTagName("cantidad")[0].innerHTML;
					document.getElementById("productos").getElementsByTagName("td")[td+2].innerHTML = xml.getElementsByTagName("producto")[td].getElementsByTagName("precio")[0].innerHTML;
					document.getElementById("productos").getElementsByTagName("td")[td+3].innerHTML = xml.getElementsByTagName("producto")[td].getElementsByTagName("importe")[0].innerHTML;
				} else {
					document.getElementById("productos").getElementsByTagName("td")[td*4].innerHTML = xml.getElementsByTagName("producto")[td].getElementsByTagName("nombre")[0].innerHTML;
					document.getElementById("productos").getElementsByTagName("td")[(td*4)+1].innerHTML = xml.getElementsByTagName("producto")[td].getElementsByTagName("cantidad")[0].innerHTML;
					document.getElementById("productos").getElementsByTagName("td")[(td*4)+2].innerHTML = xml.getElementsByTagName("producto")[td].getElementsByTagName("precio")[0].innerHTML;
					document.getElementById("productos").getElementsByTagName("td")[(td*4)+3].innerHTML = xml.getElementsByTagName("producto")[td].getElementsByTagName("importe")[0].innerHTML;			
				}
			}
		}
		if( productos > 0) {
			for(td = numeroCambiarFilas;td < (numeroCambiarFilas + productos);td = td + 1) {
				document.getElementById("productos").getElementsByTagName("tbody")[0].innerHTML += "<tr>\n<td></td><td class=\"text_center\"></td><td class=\"text_right\"></td><td class=\"text_right\"></td>";
				document.getElementById("productos").getElementsByTagName("td")[td*4].innerHTML = xml.getElementsByTagName("producto")[td].getElementsByTagName("nombre")[0].innerHTML;
				document.getElementById("productos").getElementsByTagName("td")[(td*4)+1].innerHTML = xml.getElementsByTagName("producto")[td].getElementsByTagName("cantidad")[0].innerHTML;
				document.getElementById("productos").getElementsByTagName("td")[(td*4)+2].innerHTML = xml.getElementsByTagName("producto")[td].getElementsByTagName("precio")[0].innerHTML;
				document.getElementById("productos").getElementsByTagName("td")[(td*4)+3].innerHTML = xml.getElementsByTagName("producto")[td].getElementsByTagName("importe")[0].innerHTML;
			}
		} else if(productos < 0) {
			productos = productos * -1;
			numero = numeroCambiarFilas;
			for(tr = numeroCambiarFilas;tr < (numeroCambiarFilas + productos);tr = tr + 1) {
				document.getElementById("productos").getElementsByTagName("tbody")[0].removeChild(document.getElementById("productos").getElementsByTagName("tbody")[0].getElementsByTagName("tr")[numero]);
			}
		}
		navegado_pedido = null;
	}
}