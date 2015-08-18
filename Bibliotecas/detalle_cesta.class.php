<?php
require_once "conexion.global.php";
class detalle_cesta extends gestionTablas
{
	protected $cantidad;
	protected $precio;
	protected $productos_id;
	function __construct ( $cantidad = false, $precio = false, $productos_id = false, $id = "no" )
	{
		try {
			$this->conexion = new baseDatos( BASEDATOS, "detalle_cesta", HOST, USUARIO, BASEDATOS_PASSWORD );
			$this->valido = true;
			$this->sincronizado = false;
			$this->respuestaxml = "";
			if( $cantidad ) {
				$this->validar("cantidad", $cantidad);
			}
			if( $precio ) {
				$this->validar("precio", $precio);
			}
			if( $productos_id ) {
				$this->validar("productos_id", $productos_id);
			}
			if( $id != "no" ) {
				$this->validar("id", $id);
			}
		} catch ( Exception $error ) {
			$this->respuestaxml .= "<mensaje>".$error->getMessage()."</mensaje>\n";
		}
	}
	function guardar ( $cesta_id )
	{
		$resultado = false;
		try {
			if( $this->valido ) {
				if( $this->existe( $this->campos ) ) {
					$this->respuestaxml .= "<mensaje>ya existe el mismo detalle de cesta</mensaje>\n";
				} else {
					if( $resultado = parent :: insercion( $this->campos, __CLASS__ ) ) {
						$relacion = new relacion_cesta( $cesta_id, $this->id );
						$relacion->relacionar();
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
			$relaciones = relacion_cesta::recogeRelaciones_cesta( "detalle_cestas_id", $id );
			if( count( $relaciones ) < 1 ) {
				$resultado = parent :: borrado( __CLASS__ );
			}
			$relacion["cesta_id"] = $cesta_id;
			$relacion["detalle_cestas_id"] = $id;
			$relacion = relacion::recogeRelacion_cesta( $relacion );
			$resultado = $relacion->eliminar();
			/* Se podria comprobar el estado  y lanzar un mensaje personalizado, ya hay un mensaje por defecto*/
		} catch ( Exception $error ) {
			print "<error tipo=\"sql\">".$error->getMessage()."</error>\n";
		}
		return $resultado;
	}
	function actualizar( $cantidad ) {

		$this->cantidad = $this->cantidad + $cantidad;
	}
	static function recogeDetalle_cesta ( $campo , $valor = false )
	{
		$resultado = false;
		try {
			if( ! $detalle_cesta = parent :: recoge( $campo , $valor , __CLASS__ ) ) {
				print "<error tipo=\"logico\">".__CLASS__." no encontrado</error>\n";
			} else {
				$detalle_cesta = new self( $detalle_cesta["cantidad"], $detalle_cesta["precio"], $detalle_cesta["productos_id"], $detalle_cesta["id"] );
				if( $detalle_cesta->nombre == "" ) {
					$detalle_cesta->respuestaxml .= "<error tipo=\"logico\">".__CLASS__." no recogido</error>\n";
				} else {
					$detalle_cesta->respuestaxml .= "<mensaje>".__CLASS__." recogido</mensaje>\n";
				}
			}
			$resultado = $detalle_cesta;
		} catch ( Exception $error ) {
			print "<error tipo=\"sql\">".$error->getMessage()."</error>\n";
		}
		return $resultado;
	}
	static function recogeDetalles_cesta ( $campo , $valor = false )
	{
		$resultado = false;
		try {
			if( ! $detalles_cesta = parent :: recogeObjectos( $campo , $valor, __CLASS__ ) ) {
				print  "<error tipo=\"logico\">".__CLASS__."s no encontrados</error>\n";
			} else {
				while ( $fila = $detalles_cesta->fetch ( PDO::FETCH_ASSOC ) ) {
					$detalle_cesta[ $fila["id"] ] = new self( $detalle_cesta["cantidad"], $detalle_cesta["precio"], $detalle_cesta["productos_id"], $fila["id"] );
					if( $detalle_cesta[$fila["id"]]->nombre == "" ) {
						$detalle_cesta[$fila["id"]]->respuestaxml .= "<error tipo=\"logico\">".__CLASS__." $fila[id] no recogido</error>\n";
					} else {
						$detalle_cesta[$fila["id"]]->respuestaxml .= "<mensaje>".__CLASS__." $fila[id] recogido</mensaje>\n";
					}
				}
				$resultado = $detalle_cesta;
				print  "<mensaje>".__CLASS__."s recogidos</mensaje>\n";
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
			$this->$propiedad = $valor;
		}
		return $this->valido;
	}
	function __get($propiedad) 
	{
		return $this->$propiedad;
	}
}
?>