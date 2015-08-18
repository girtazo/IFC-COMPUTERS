var cambiadoDato;
var parametros = new Array();
var valido = true;
function cambiar_dato() {
	if( ! cambiadoDato ) {
		elemento = event.srcElement;
		campo = elemento.title;
		valor = elemento.textContent;
		elemento.parentNode.className = "modificable";
		if( valor != valorAnterior ) {
			switch (campo) {
				case "correo":
			        expresion = /^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/i;
			        break;
			    case "nombre":
			        expresion = /^[A-Za-záéíóúñ]{2,}([\s][A-Za-záéíóúñ]{2,})*$/;
			        break;
			    case "apellidos":
			        expresion = /^[A-Za-záéíóúñ]{2,}([\s][A-Za-záéíóúñ]{2,})+$/;
			        break;
			    case "dni":
			        expresion = /^[0-9]{8}[A-Z]$/;
			        break;
			    case "telefono_fijo":
			        expresion = /^[9|6|7][0-9]{8}$/;
			        break;
			    case "telefono_movil":
			        expresion = /^[9|6|7][0-9]{8}$/;
			        break;
			    case "codigo_postal":
			        expresion = /^[0-9]{5}$/;
			        break;
		        case "direccion":
		        	expresion = /^[A-Za-záéíóúñ]{2,}([\s][A-Za-záéíóúñ]{2,})+([\s][A-Za-záéíóúñ0-9]+)+$/;
		        	break;
			}
			if( expresion.test( valor ) ) {
				parametros[0] = "actualiza["+campo+"]";
				parametros[1] = valor;
				cambiadoDato = new Ajax("http://"+location.hostname+"/procesos/cambiar_dato.php","POST",cambiar_dato,"Texto",parametros,"application/x-www-form-urlencoded" );
			} else {
				elemento.textContent = valorAnterior;
				document.getElementById("mensajeError").innerHTML = "";
				document.getElementById("pantallaError").className = "mostrar";
				document.getElementById("mensajeError").className = "mostrar";
				document.getElementById("mensajeError").innerHTML +="<input id=\"aceptar\" type=\"button\" value=\"OK\" onclick=\"cerrarError()\">";
				switch (campo) {
					case "correo":
				        document.getElementById("mensajeError").innerHTML += "<p class=\"texto\">No has insertado un correo adecuado</p>";
				        break;
				    case "nombre":
				        document.getElementById("mensajeError").innerHTML += "<p class=\"texto\">Solo se aceptan nombres validos, no es un nick, solo se aceptan caracteres alfabeticos</p>";
				        break;
				    case "apellidos":
				        document.getElementById("mensajeError").innerHTML += "<p class=\"texto\">Solo se aceptan apellidos validos, no es un nick, solo se aceptan caracteres alfabeticos</p>";
				        break;
				    case "dni":
				        document.getElementById("mensajeError").innerHTML += "<p class=\"texto\">El dni debe tener 8 numeros y una letra al final</p>";
				        break;
				    case "telefono_fijo":
				        document.getElementById("mensajeError").innerHTML += "<p class=\"texto\">El telefono fijo debe empezar por 9, por 6 o por 7 y tener un total de 9 dígitos</p>";
				        break;
				    case "telefono_movil":
				        document.getElementById("mensajeError").innerHTML += "<p class=\"texto\">El telefono movil debe empezar por 9, por 6 o por 7 y tener un total de 9 dígitos</p>";
				        break;
				    case "codigo_postal":
				        document.getElementById("mensajeError").innerHTML += "<p class=\"texto\">El codigo postal debe estar compuesto de 5 digitos del 0 al 9</p>";
				        break;
			        case "direccion":
			        	document.getElementById("mensajeError").innerHTML += "<p class=\"texto\">En la direccion se debera indicar el tipo de via, la calle, el numero, etc. No debe contener ni comas ni puntos</p>";
			        break;
			    }
			}
		}
	} else {
		var xml = cambiadoDato.objecto.responseXML.getElementsByTagName('xml')[0];
		campo = xml.getElementsByTagName('campo')[0].textContent;
		var elemento = document.getElementsByTagName('td');
		for (var i = elemento.length - 1; i >= 0; i--) {
			if ( elemento[i].title == campo ) {
				valor = elemento[i].textContent;
				elemento = elemento[i];
				break;
			}
		}
		if( xml.getElementsByTagName('error').length > 0 ) {
			elemento.textContent = valorAnterior;
			document.getElementById("mensajeError").innerHTML = "";
			document.getElementById("pantallaError").className = "mostrar";
			document.getElementById("mensajeError").className = "mostrar";
			document.getElementById("mensajeError").innerHTML +="<input id=\"aceptar\" type=\"button\" value=\"OK\" onclick=\"cerrarError()\">";
			document.getElementById("mensajeError").innerHTML += "<p class=\"texto\">"+ xml.getElementsByTagName('error')[0].textContent +"</p>";
		}
		cambiadoDato = null;
	}
}