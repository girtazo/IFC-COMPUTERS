var consulta;
var validacion = new Array();
function enviarConsulta() {
	if( ! consulta ) {
		validacion[0]="contacto[correo]r";
		validacion[1]=/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/i;
		validacion[2]="contacto[consulta]r";
		validacion[3]=/^[^]+$/;
		if( validacion.validar() ) {
			var parametros = validacion.parametro;
			consulta = new Ajax("./procesos/enviarConsulta.php","POST",enviarConsulta,"Texto",parametros,"application/x-www-form-urlencoded" );
		} else {
			document.getElementById("mensajeError").innerHTML = "";
			var clase = document.getElementsByName("contacto[correo]")[0].className;
			document.getElementById("mensajeError").innerHTML += "<input id=\"aceptar\" type=\"button\" value=\"OK\" onclick=\"cerrarError()\">";
			if( clase.substr( clase.length-9, 9 ) == "no_valido" ) {
				document.getElementById("mensajeError").innerHTML += "<p class=\"texto\">No has insertado un correo adecuado</p>";
			}
			clase = document.getElementsByName('contacto[consulta]')[0].className;
			if( clase.substr( clase.length-9, 9 ) == "no_valido" ) {
				document.getElementById("mensajeError").innerHTML += "<p class=\"texto\">Escribe una consulta valida</p>";
			}
			document.getElementById("pantallaError").className = "mostrar";
			document.getElementById("mensajeError").className = "mostrar";
		}
	} else {
		validacion.numero_parametro = 0;
		respuesta = consulta.objecto.responseXML.getElementsByTagName("xml")[0].innerHTML;
		/*if( respuesta == "Inicia Sesion" ) {
			location.assign("http://"+location.hostname+"/inicio");
		} else {
			document.getElementById("mensajeError").innerHTML = "";
			document.getElementById("mensajeError").innerHTML += "<input id=\"aceptar\" type=\"button\" value=\"OK\" onclick=\"cerrarError()\">";
			document.getElementById("mensajeError").innerHTML += "<p class=\"texto\">"+respuesta+"</p>";
			document.getElementById("pantallaError").className = "mostrar";
			document.getElementById("mensajeError").className = "mostrar";
		}*/
		consulta = null;
	}
}