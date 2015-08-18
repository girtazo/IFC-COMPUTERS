<?php
require_once "conexion.global.php";
class detalle_pedido extends gestionTablas
{
	protected $cantidad;
	protected $precio;
	protected $productos_id;
	function __construct ( $cantidad, $precio, $productos_id, $pedido_id, $id = "no" )
	{
		try {
			$this->conexion = new baseDatos( BASEDATOS, "detalle_pedido", HOST, USUARIO, BASEDATOS_PASSWORD );
			$this->valido = true;
			$this->sincronizado = false;
			$this->respuestaxml = "";
			if( $id == "no" ) {
				$this->validar("cantidad", $cantidad);
				$this->validar("precio", $precio);
				$this->validar("productos_id", $productos_id);
				$this->guardar($pedido_id);
			} else {
				$this->cantidad = $cantidad;
				$this->precio = $precio;
				$this->productos_id = $productos_id;
				$this->id = $id;
			}
		} catch ( Exception $error ) {
			$this->respuestaxml .= "<mensaje>".$error->getMessage()."</mensaje>\n";
		}
	}
	function guardar ($pedido_id)
	{
		$resultado = false;
		try {
			if( $this->valido ) {
				$campo["cantidad"] = $this->campos["cantidad"];
				$campo["precio"] = $this->campos["precio"];
				$campo["productos_id"] = $this->campos["productos_id"];
				$this->sincronizar($campo);
				if( $this->existe( $this->campos ) ) {
					$this->respuestaxml .= "<mensaje>ya existe el mismo detalle de pedido</mensaje>\n";
					$relacion = new relacion_pedido( $pedido_id, $this->id );
				} else {
					if( $resultado = parent :: insercion( $this->campos, __CLASS__ ) ) {
						$relacion = new relacion_pedido( $pedido_id, $this->id );
					}
					/* Se podria comprobar el estado de la insercion y lanzar un mensaje personlizado, ya hay un mensaje por defecto*/
				}
			}
		} catch ( Exception $error ) {
			$this->respuestaxml .= "<error tipo=\"sql\">".$error->getMessage()."</error>\n";
		}
		return $resultado;
	}
	function eliminar ( $cesta_id )
	{
		$resultado = false;
		try {
			$relaciones = relacion_cesta::recogeRelaciones_cesta( "detalle_pedidos_id", $id );
			if( count( $relaciones ) < 1 ) {
				$resultado = parent :: borrado( __CLASS__ );
			}
			$relacion["cesta_id"] = $cesta_id;
			$relacion["detalle_pedidos_id"] = $id;
			$relacion = relacion::recogeRelacion_cesta( $relacion );
			$resultado = $relacion->eliminar();
			/* Se podria comprobar el estado  y lanzar un mensaje personalizado, ya hay un mensaje por defecto*/
		} catch ( Exception $error ) {
			print "<error tipo=\"sql\">".$error->getMessage()."</error>\n";
		}
		return $resultado;
	}
	static function recogeDetalle_pedido ( $campo , $valor = false )
	{
		$resultado = false;
		try {
			if( ! $detalle_pedido = parent :: recoge( $campo , $valor , __CLASS__ ) ) {
				print "<error tipo=\"logico\">".__CLASS__." no encontrado</error>\n";
			} else {
				$detalle_pedido = new self( $detalle_pedido["cantidad"], $detalle_pedido["precio"], $detalle_pedido["productos_id"], false, $detalle_pedido["id"] );
				if( $detalle_pedido->cantidad == "" ) {
					$detalle_pedido->respuestaxml .= "<error tipo=\"logico\">".__CLASS__." no recogido</error>\n";
				} else {
					$detalle_pedido->respuestaxml .= "<mensaje>".__CLASS__." recogido</mensaje>\n";
				}
			}
			$resultado = $detalle_pedido;
		} catch ( Exception $error ) {
			print "<error tipo=\"sql\">".$error->getMessage()."</error>\n";
		}
		return $resultado;
	}
	static function recogeDetalles_pedido ( $campo , $valor = false )
	{
		$resultado = false;
		$numero = 0;
		$detalle_pedido = new ArrayObject();
		try {
			if( ! $detalles_pedido = parent :: recogeObjectos( $campo , $valor, __CLASS__ ) ) {
				print  "<error tipo=\"logico\">".__CLASS__."s no encontrados</error>\n";
			} else {
				while ( $fila = $detalles_pedido->fetch ( PDO::FETCH_ASSOC ) ) {
					$numero++;
					$detalle_pedido[ $numero ] = new self( $fila["cantidad"], $fila["precio"], $fila["productos_id"],false, $fila["id"] );
					if( $detalle_pedido[$numero]->cantidad == "" ) {
						$detalle_pedido[$numero]->respuestaxml .= "<error tipo=\"logico\">".__CLASS__." $fila[id] no recogido</error>\n";
					} else {
						$detalle_pedido[$numero]->respuestaxml .= "<mensaje>".__CLASS__." $fila[id] recogido</mensaje>\n";
					}
				}
				$resultado = $detalle_pedido;
			}
			
		} catch ( Exception $error ) {
			print "<error tipo=\"sql\">".$error->getMessage()."</error>\n";
		}
		return $resultado;
	}
	function sincronizar( $busqueda = false)
	{
		try {
			if( ! $busqueda ) {
				if($this->cantidad) {
					$this->campos["cantidad"] = $this->cantidad;
				}
				if($this->precio) {
					$this->campos["precio"] = $this->precio;
				}
				if($this->productos_id) {
					$this->campos["productos_id"] = $this->productos_id;
				}
				if($this->id != "no") {
					$this->campos["id"] = $this->id;
				}
			} else {
				$this->campos = $busqueda;
			}
			parent :: sincronizar( $this->campos, __CLASS__ );
		} catch ( Exception $error ) {
			$this->respuestaxml .= "<error tipo=\"sql\">".$error->getMessage()."</error>\n";
		}
	}
	private function validar( $propiedad, $valor )
	{
		switch ( $propiedad ) {
			case "cantidad":
				if ( ! preg_match( ENTERO, $valor ) ) {
					$this->respuestaxml .= "<error campo=\"$propiedad\" tipo=\"validacion\">fallo de validacion de $propiedad</error>\n";
					$this->valido = false;
				}
				break;
			case "precio":
				if ( ! preg_match( DECIMAL, $valor ) ) {
					$this->respuestaxml .= "<error campo=\"$propiedad\" tipo=\"validacion\">fallo de validacion de $propiedad</error>\n";
					$this->valido = false;
				}
				break;
			case "productos_id":
				if ( ! preg_match( ID, $valor ) ) {
					$this->respuestaxml .= "<error campo=\"$propiedad\" tipo=\"validacion\">fallo de validacion de $propiedad</error>\n";
					$this->valido = false;
				}
				break;
			case "id":
				if ( ! preg_match( ID, $valor ) ) {
					$this->respuestaxml .= "<error campo=\"$propiedad\" tipo=\"validacion\">fallo de validacion de $propiedad</error>\n";
					$this->valido = false;
				}
				break;
		}
		if($this->valido) {
			$this->campos[$propiedad] = $valor;
		}
		return $this->valido;
	}
	function __get($propiedad) 
	{
		return $this->$propiedad;
	}
}
?>