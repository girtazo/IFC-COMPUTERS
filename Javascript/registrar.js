var registro;
var validacion = new Array();
function registrar() {
	if( ! registro ) {
		validacion.numero_parametro = 0;
		validacion[0]="registro[correo]r";
		validacion[1]=/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/i;
		validacion[2]="registro[password]r";
		validacion[3]=/(?=^.{8,}$)((?=.*\d)|(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$/;
		validacion[4]="registro[nombre]r";
		validacion[5]=/^[A-Za-záéíóúñ]{2,}([\s][A-Za-záéíóúñ]{2,})*$/;
		validacion[6]="registro[apellidos]r";
		validacion[7]=/^[A-Za-záéíóúñ]{2,}([\s][A-Za-záéíóúñ]{2,})+$/;
		validacion[8]="registro[dni]r";
		validacion[9]=/^[0-9]{8}[A-Z]$/;
		validacion[10]="registro[telefono_fijo]";
		validacion[11]=/^[9|6|7][0-9]{8}$/;
		validacion[12]="registro[telefono_movil]";
		validacion[13]=/^[9|6|7][0-9]{8}$/;
		validacion[14]="registro[codigo_postal]";
		validacion[15]=/^[0-9]{5}$/;
		validacion[16]="registro[direccion]";
		validacion[17]=/^[A-Za-záéíóúñ]{2,}([\s][A-Za-záéíóúñ]{2,})+([\s][A-Za-záéíóúñ0-9]+)+$/;
		if( validacion.validar() ) {
			var parametros = validacion.parametro;
			parametros[18] = "registro[boletin]";
			parametros[19] = document.getElementsByName("registro[boletin]")[0].checked;
			registro = new Ajax("http://"+location.hostname+"/procesos/registro.php","POST",registrar,"Texto",parametros,"application/x-www-form-urlencoded" );
		} else {
			document.getElementById("mensajeError").innerHTML = "";
			var clase = document.getElementsByName("registro[correo]")[0].className;
			document.getElementById("mensajeError").innerHTML +="<input id=\"aceptar\" type=\"button\" value=\"OK\" onclick=\"cerrarError()\">";
			clase = clase.substr( clase.length-9, 9 );
			if( clase.substr( clase.length-9, 9 ) == "no_valido") {
				document.getElementById("mensajeError").innerHTML += "<p class=\"texto\">No has insertado un correo adecuado</p>";
			}
			clase = document.getElementsByName('registro[password]')[0].className;
			if( clase.substr( clase.length-9, 9 ) == "no_valido" ) {
				document.getElementById("mensajeError").innerHTML += "<p class=\"texto\">No has insertado una contraseña de 8 caracteres con una mayúscula, un número y un carácter especial</p>";
			}
			clase = document.getElementsByName('registro[nombre]')[0].className;
			if( clase.substr( clase.length-9, 9 ) == "no_valido" ) {
				document.getElementById("mensajeError").innerHTML += "<p class=\"texto\">Solo se aceptan nombres válidos, no es un nick, solo se aceptan caracteres alfabéticos</p>";
			}
			clase = document.getElementsByName('registro[apellidos]')[0].className;
			if( clase.substr( clase.length-9, 9 ) == "no_valido" ) {
				document.getElementById("mensajeError").innerHTML += "<p class=\"texto\">Solo se aceptan apellidos válidos, no es un nick, solo se aceptan caracteres alfabéticos</p>";
			}
			clase = document.getElementsByName('registro[dni]')[0].className;
			if( clase.substr( clase.length-9, 9 ) == "no_valido" ) {
				document.getElementById("mensajeError").innerHTML += "<p class=\"texto\">El dni debe tener 8 numeros y una letra al final</p>";
			}
			clase = document.getElementsByName('registro[telefono_fijo]')[0].className;
			if( clase.substr( clase.length-9, 9 ) == "no_valido" ) {
				document.getElementById("mensajeError").innerHTML += "<p class=\"texto\">El teléfono fijo debe empezar por 9, por 6 o por 7 y tener un total de 9 dígitos</p>";
			}
			clase = document.getElementsByName('registro[telefono_movil]')[0].className;
			if( clase.substr( clase.length-9, 9 ) == "no_valido" ) {
				document.getElementById("mensajeError").innerHTML += "<p class=\"texto\">El teléfono móvil debe empezar por 9, por 6 o por 7 y tener un total de 9 dígitos</p>";
			}
			clase = document.getElementsByName('registro[codigo_postal]')[0].className;
			if( clase.substr( clase.length-9, 9 ) == "no_valido" ) {
				document.getElementById("mensajeError").innerHTML += "<p class=\"texto\">El código postal debe estar compuesto de 5 dígitos del 0 al 9</p>";
			}
			clase = document.getElementsByName('registro[direccion]')[0].className;
			if( clase.substr( clase.length-9, 9 ) == "no_valido" ) {
				document.getElementById("mensajeError").innerHTML += "<p class=\"texto\">En la dirección se deberá indicar el tipo de via, la calle, el número, etc. No debe contener ni comas ni puntos</p>";
			}
			document.getElementById("pantallaError").className = "mostrar";
			document.getElementById("mensajeError").className = "mostrar";
		}
	} else {
		validacion.numero_parametro = 0;
		xml = registro.objecto.responseXML;
		if( xml.getElementsByTagName("error").length > 0 ) {
			document.getElementById('informativa').innerHTML = registro.objecto.responseXML.getElementsByTagName("error")[0].innerHTML;
		} else {
			document.getElementById('informativa').innerHTML = registro.objecto.responseXML.getElementsByTagName("aviso")[0].innerHTML;
		}
		document.getElementById("pantalla").className = "mostrar";
		document.getElementById("informativa").className = "mostrar";
		registro = null;
	}
}