var cambiadaPassword;
var validacion = new Array();
function cambiarPassword() {
	if( ! cambiadaPassword ) {
		var distintas = true;
		var iguales = true;
		validacion.numero_parametro = 0;
		validacion[0]="password[password]r";
		validacion[1]=/(?=^.{8,}$)((?=.*\d)|(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$/;
		validacion[2]="password[npassword]r";
		validacion[3]=/(?=^.{8,}$)((?=.*\d)|(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$/;
		validacion[4]="password[rpassword]r";
		validacion[5]=/(?=^.{8,}$)((?=.*\d)|(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$/;
		if( document.getElementsByName("password[password]")[0].value == document.getElementsByName("password[npassword]")[0].value ) {
			distintas = false;
		}
		if( document.getElementsByName("password[npassword]")[0].value != document.getElementsByName("password[rpassword]")[0].value ) {
			iguales = false;
		}
		if( validacion.validar() && distintas && iguales ) {
			parametros = validacion.parametro;
			cambiadaPassword = new Ajax("http://"+location.hostname+"/procesos/cambiarPassword.php","POST",cambiarPassword,"Texto",parametros,"application/x-www-form-urlencoded" );
		} else {
			document.getElementById("pantallaError").className = "mostrar";
			document.getElementById("mensajeError").className = "mostrar";
			var mensajeError = document.getElementById("mensajeError");
			mensajeError.innerHTML = "";
			mensajeError.innerHTML +="<input id=\"aceptar\" type=\"button\" value=\"OK\" onclick=\"cerrarError()\">";
			var clase = document.getElementsByName("password[password]")[0].className;
			if( clase.substr( clase.length-9, 9 ) == "no_valido") {
				mensajeError.innerHTML += "<p class=\"texto\">No has insertado una contraseña de 8 caracteres con una mayuscula, un numero y un caracter especial</p>";
				distintas = true;
			}
			clase = document.getElementsByName('password[npassword]')[0].className;
			if( clase.substr( clase.length-9, 9 ) == "no_valido" ) {
				mensajeError.innerHTML += "<p class=\"texto\">No has insertado una contraseña de 8 caracteres con una mayuscula, un numero y un caracter especial</p>";
				distintas = true;
			}
			clase = document.getElementsByName('password[rpassword]')[0].className;
			if( clase.substr( clase.length-9, 9 ) == "no_valido" ) {
				mensajeError.innerHTML += "<p class=\"texto\">No has insertado una contraseña de 8 caracteres con una mayuscula, un numero y un caracter especial</p>";
				distintas = true;
			}
			if( ! distintas ) {
				mensajeError.innerHTML += "<p class=\"texto\">La contraseña nueva y la actual son identicas</p>";
			}
			if( ! iguales ) {
				mensajeError.innerHTML += "<p class=\"texto\">La contraseña nueva y repite contraseña no son identicas</p>";
			}
		}
	} else {
		xml = cambiadaPassword.objecto.responseXML;
		if( xml.getElementsByTagName("error").length > 0 ) {
			document.getElementById("pantallaError").className = "mostrar";
			document.getElementById("mensajeError").className = "mostrar";
			var mensajeError = document.getElementById("mensajeError");
			mensajeError.innerHTML = "";
			mensajeError.innerHTML +="<input id=\"aceptar\" type=\"button\" value=\"OK\" onclick=\"cerrarError()\">";
			mensajeError.innerHTML +=xml.getElementsByTagName("error")[0].textContent;
		} else {
			document.getElementById("pantalla").className = "mostrar";
			document.getElementById("informativa").className = "mostrar";
			document.getElementById("informativa").innerHTML = xml.getElementsByTagName("aviso")[0].innerHTML;
		}
		cambiadaPassword = null;
	}
}