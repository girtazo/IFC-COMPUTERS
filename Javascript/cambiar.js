function cambiar(elemento) {
	switch(elemento.src) {
		case "http://"+location.hostname+"/imagenes/menu-inicio.png":
			elemento.src = "http://"+location.hostname+"/imagenes/menu-inicio-black.png"
			break;
		case "http://"+location.hostname+"/imagenes/menu-ordenadores.png":
			elemento.src = "http://"+location.hostname+"/imagenes/menu-ordenadores-black.png"
			break;
		case "http://"+location.hostname+"/imagenes/menu-servicios.png":
			elemento.src = "http://"+location.hostname+"/imagenes/menu-servicios-black.png"
			break;
		case "http://"+location.hostname+"/imagenes/cesta.png":
			if(elemento.alt =="cesta") {
				elemento.src = "http://"+location.hostname+"/imagenes/cesta_negra.png"
			}
			break;
		case "http://"+location.hostname+"/imagenes/menu-inicio-black.png":
			elemento.src = "http://"+location.hostname+"/imagenes/menu-inicio.png"
			break;
		case "http://"+location.hostname+"/imagenes/menu-ordenadores-black.png":
			elemento.src = "http://"+location.hostname+"/imagenes/menu-ordenadores.png"
			break;
		case "http://"+location.hostname+"/imagenes/menu-servicios-black.png":
			elemento.src = "http://"+location.hostname+"/imagenes/menu-servicios.png"
			break;
		case "http://"+location.hostname+"/imagenes/cesta_negra.png":
			if(elemento.alt =="cesta") {
			    elemento.src = "http://"+location.hostname+"/imagenes/cesta.png"
			}
			break;
		case "http://"+location.hostname+"/imagenes/cerrarSesion.png":
			elemento.src = "http://"+location.hostname+"/imagenes/cerrarSesion_hover.png"
			break;
		case "http://"+location.hostname+"/imagenes/cerrarSesion_hover.png":
			elemento.src = "http://"+location.hostname+"/imagenes/cerrarSesion.png"
			break;
	}
	switch(elemento.id) {
		case "pedido":
			if( elemento.childNodes[3].src == "http://"+location.hostname+"/imagenes/realiza_pedido.png" ) {
				elemento.childNodes[1].className = "texto right titulo_inferior negro";
				elemento.childNodes[3].src = "http://"+location.hostname+"/imagenes/realiza_pedido_black.png";
			} else {
				elemento.childNodes[1].className = "texto right titulo_inferior";
				elemento.childNodes[3].src = "http://"+location.hostname+"/imagenes/realiza_pedido.png";
			}
			break;
		case "logo_perfil":
			if( elemento.childNodes[1].src == "http://"+location.hostname+"/imagenes/icono_usuario.png" ) {
				elemento.childNodes[1].src= "http://"+location.hostname+"/imagenes/icono_usuario_hover.png";
				elemento.childNodes[3].className= "titulo_inferior left negro";
			} else {
				elemento.childNodes[1].src= "http://"+location.hostname+"/imagenes/icono_usuario.png";
				elemento.childNodes[3].className= "titulo_inferior left";
			}
			break;
	}
}