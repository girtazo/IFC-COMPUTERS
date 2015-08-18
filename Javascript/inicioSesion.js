var inicio;
var validacion = new Array();
function inicioSesion() {
	if( ! inicio ) {
		validacion[0]="inicio[correo]r";
		validacion[1]=/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/i;
		validacion[2]="inicio[password]r";
		validacion[3]=/(?=^.{8,}$)((?=.*\d)|(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$/;
		if( validacion.validar() ) {
			var parametros = validacion.parametro;
			inicio = new Ajax("./procesos/inicioSesion.php","POST",inicioSesion,"Texto",parametros,"application/x-www-form-urlencoded" );
		} else {
			document.getElementById("mensajeError").innerHTML = "";
			var clase = document.getElementsByName("inicio[correo]")[0].className;
			document.getElementById("mensajeError").innerHTML += "<input id=\"aceptar\" type=\"button\" value=\"OK\" onclick=\"cerrarError()\">";
			if( clase.substr( clase.length-9, 9 ) == "no_valido" ) {
				document.getElementById("mensajeError").innerHTML += "<p class=\"texto\">No has insertado un correo adecuado</p>";
			}
			clase = document.getElementsByName('inicio[password]')[0].className;
			if( clase.substr( clase.length-9, 9 ) == "no_valido" ) {
				document.getElementById("mensajeError").innerHTML += "<p class=\"texto\">No has inserta un contraseña de 8 caracteres con una mayuscula, un numero y un caracter especial</p>";
			}
			document.getElementById("pantallaError").className = "mostrar";
			document.getElementById("mensajeError").className = "mostrar";
		}
	} else {
		validacion.numero_parametro = 0;
		respuesta = inicio.objecto.responseXML.getElementsByTagName("xml")[0].getElementsByTagName("mensaje")[0].innerHTML;
		if( respuesta == "Inicia Sesion" ) {
			location.assign("http://"+location.hostname+"/inicio");
		} else {
			document.getElementById("mensajeError").innerHTML = "";
			document.getElementById("mensajeError").innerHTML += "<input id=\"aceptar\" type=\"button\" value=\"OK\" onclick=\"cerrarError()\">";
			document.getElementById("mensajeError").innerHTML += "<p class=\"texto\">"+respuesta+"</p>";
			document.getElementById("pantallaError").className = "mostrar";
			document.getElementById("mensajeError").className = "mostrar";
		}
		inicio = null;
	}
}