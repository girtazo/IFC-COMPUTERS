var cierraSesion;
var validacion = new Array();
function cerrarSesion() {
	if( ! cierraSesion ) {
		cierraSesion = new Ajax( "http://"+location.hostname+"/procesos/cerrarSesion.php",false,cerrarSesion );
	} else {
		validacion.numero_parametro = 0;
		respuesta = cierraSesion.objecto.responseText.match(/<mensaje[^>]*>(.*?)<\/mensaje>/);
		if( respuesta == null ) {
			respuesta = false;
		}
		if( ! respuesta ) {
			location.assign("http://"+location.hostname+"/inicio");
		}
		cierraSesion = null;
	}
}