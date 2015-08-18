<?php
require_once "./panel.php";
function preparar_inicio() {

	// GLOBALES
	global $titulo, $js, $css, $ofertas;

	// TITULO DE LA PAGINA
	$titulo = "INICIO";
	
	//CSS APLICADOS EN LA PAGINA

	//JS APLICADOS EN LA PAGINA
	$js[] = "registrar";
	$js[] = "siguienteOferta";
	$js[] = "anteriorOferta";
	$js[] = "css_selector";
	$js[] = "inicioSesion";

	// RECOGER OFERTAS
	$ofertas = producto::recogeProductos("oferta", 1);
}
function preparar_ordenadores() {
	// GLOBALES
	global $titulo, $js, $css, $producto;

	// TITULO DE LA PAGINA
	$titulo = "ORDENADORES";
	
	//CSS APLICADOS EN LA PAGINA
	$css[] = "ordenadores";

	//JS APLICADOS EN LA PAGINA
	$js[] = "inicioSesion";
	$js[] = "ver_producto";
	$js[] = "guardar_producto";
	$js[] = "quitar_producto";
	$js[] = "eliminar_producto";

	// RECOGER PRODUCTOS
	$producto = producto::recogeTodosProductos();
}
function preparar_servicios() {
	// GLOBALES
	global $titulo, $js, $css, $servicio;

	// TITULO DE LA PAGINA
	$titulo = "SERVICIOS";
	
	//CSS APLICADOS EN LA PAGINA
	$css[] = "servicios";
	
	//JS APLICADOS EN LA PAGINA
	$js[] = "inicioSesion";

	// RECOGER SERVICIOS
	$servicio = producto::recogeProductos("servicio",1);
}
function preparar_pedido() {
	// GLOBALES
	global $titulo, $js, $css, $sesionUsuario;

	if( ! $sesionUsuario) {
  		header( "Location: ./inicio" );
	}

	// TITULO DE LA PAGINA
	$titulo = "PEDIDO";
	
	//CSS APLICADOS EN LA PAGINA
	$css[] = "pedidos";

	//JS APLICADOS EN LA PAGINA
	$js[] = "seleccion_envio";
	$js[] = "seleccion_pago";
	$js[] = "navegar_pedido";
	$js[] = "pedir_pedido";

	// PRODUCTO ACTUAL : VISUALIZACION DE PAGINACIÓN
	$_SESSION["VISUALIZAR_MAXIMO_PRODUCTOS"] = 14;

	// INICIALIZACIÓN DE PRODUCTO ACTUAL
	if( ! isset( $_SESSION["numero_producto"] ) ) {
  		$_SESSION["numero_producto"] = 1;
  		$_SESSION["coste_envio"] = 0;
  		$_SESSION["recargo"] = 0;
	}	
}
function preparar_areaPrivada() {
	// GLOBALES
	global $titulo, $js, $css, $sesionUsuario, $parametro, $contenido;
	if( ! $sesionUsuario) {
  		header( "Location: ./inicio" );
	}

	// TITULO DE LA PAGINA
	$titulo = "AREA PRIVADA";
	
	//CSS APLICADOS EN LA PAGINA
	$css[] = "areaPrivada";

	//JS APLICADOS EN LA PAGINA
	$js[] = "seleccionDato";
	$js[] = "cambiar_dato";
	$js[] = "cambiarPassword";
	$js[] = "cambiarEstado";
	$js[] = "cancelarPedido";

	if( count( $parametro ) > 0 ) {
  		$contenido = $parametro[1];
	} else {
  		$contenido = "datos_cuenta";
	}
}
function cargarContenido( ) {
	global $pagina, $sesionUsuario, $producto, $contenido, $servicio, $ofertas;
	switch ( $pagina ) {
  		case 'inicio':
  			preparar_inicio();
    		slider($ofertas);
    		cuadro_registro();
    		break;
    	case 'ordenadores':
    		preparar_ordenadores();
        	mostrarOrdenadores( $producto, $_SESSION["cesta"] ); 
    		break;
    	case 'servicios':
    		preparar_servicios();
    		mostrarServicios( $servicio ); 
    		break;
    	case 'pedido':
    		eleccion();
    		break;
    	case 'areaprivada':
    		menuAreaPrivada($contenido);
    		contenidoAreaPrivada($contenido);
    		break;
	}
	cargarCesta();
}
?>