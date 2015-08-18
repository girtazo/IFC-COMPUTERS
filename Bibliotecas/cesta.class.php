<?php
// BIBLIOTECAS
require_once "conexion.global.php";
require_once "Arrays.php";
require_once "expresionesRegulares.php";
class cesta extends gestionTablas
{
	protected $nombre;
	protected $fecha;
	protected $total;
	protected $productos;
	protected $clientes_id;
	function __construct ( $clientes_id = false, $nombre = false , $total = false, $fecha = false, $id = "no" )
	{
		try {
			$this->conexion = new baseDatos( BASEDATOS, "cesta", HOST, USUARIO, BASEDATOS_PASSWORD );
			$this->valido = true;
			$this->sincronizado = false;
			$this->respuestaxml = "";
			$this->productos = false;
			$this->clientes_id = $clientes_id;
			$this->nombre = $nombre;
			if( ! $total ) {
				$this->total = 0;
			} else {
				$this->total = $total;
			}
			$this->fecha = $fecha;
			// comprueba si existe sino vacia
			if( $id != "no" ) {
				$this->validar("id", $id);
			} else {
				$this->productos = new ArrayObject();
			}
		} catch ( Exception $error ) {
			$this->respuestaxml .= "<mensaje>".$error->getMessage()."</mensaje>\n";
		}
	}
	function guarda ( $nombre, $fecha = false, $id = "no" )
	{
		$resultado = false;
		try {
			if( ! ( $this->productos && $this->valido ) ) {
				$this->respuestaxml .= "<error tipo=\"logico\">No hay productos</error>\n";
			} else if( ! $this->clientes_id ){
				$this->respuestaxml .= "<error tipo=\"logico\">No estas logueado</error>\n";
			} else {
				$this->validar( "nombre" );
				$this->campos[ "clientes_id" ] = $this->clientes_id;
				if( existe($this->campos) ) {
					$this->respuestaxml .= "<error tipo=\"existe\">Ya hay una cesta con el mismo nombre</error>\n";
				} else {
					$fechaActual = getDate();
					$this->campos["fecha"] = $fechaActual["year"]."-". $fechaActual["mon"]."-".$fechaActual["mday"]." ".$fechaActual["hours"]."-".$fechaActual["minutes"]."-".$fechaActual["seconds"];
					foreach ( $this->productos as $id => $producto ) {
						$this->campos["total"] = $this->campos["total"] + $producto->precio*$producto->cantidad;
					}
					if( $resultado = parent :: insercion( $this->campos, __CLASS__ ) ) {
						foreach ( $this->productos as $id => $producto ) {
							$resultado = $producto->guardar( $this->id );
						}
					}
				}
			}
			return $resultado;
		} catch ( Exception $error ) {
			$this->respuestaxml .= "<error tipo=\"sql\">".$error->getMessage()."</error>\n";
		}
	}
	function __set ( $propiedad, $valor)
	{
		try {
			if( $propiedad == "clientes_id" ) {
				$this->clientes_id = $valor;
			} else if ( $this->validar( $propiedad, $valor ) ) {
				if( $propiedad == "nombre" ) {
					if( $this->existe( "nombre" ) ) {
						$this->respuestaxml .= "<error campo=\"nombre\" tipo=\"existe\">ya existe el nombre</error>\n";
					}
				}
				$resultado = parent :: modificacion( $propiedad, $valor, __CLASS__ );
			}
		} catch ( Exception $error ) {
			$this->respuestaxml .= "<error tipo=\"sql\">".$error->getMessage()."</error>\n";
		}
		return $resultado;
	}
	function elimina ()
	{
		$resultado = false;
		try {
			if( $resultado = parent :: borrado( __CLASS__ ) ) {
				foreach ( $productos as $id => $producto ) {
					$resultado = $producto->eliminar( $this->id );
				}
			}
			return $resultado;
		} catch ( Exception $error ) {
			print "<error tipo=\"sql\">".$error->getMessage()."</error>\n";
		}
	}
	function actualizar( $producto, $cantidad = 1 )
	{
		if( $this->productos->offsetExists( $producto->id ) ) {
			//DEPURACION PUEDE SER PORQUE NO ES EL PRIMER INTENTO AL DARLE COMPRAR ME INTERESA EL PRIMERO 
			if( $cantidad == 0) {
				$cantidad =  - $this->productos[$producto->id]->cantidad;
			}
			$this->productos[$producto->id]->actualizar( $cantidad );
		} else {
			$this->productos[$producto->id] = new detalle_cesta( $cantidad, $producto->precio, $producto->id );
		}
		$this->total = $this->total + ( $this->productos[$producto->id]->precio * $cantidad );
		$this->campos["total"] = $this->total;
		if( $this->productos[$producto->id]->cantidad == 0 ) {
			$this->productos->offsetUnset($producto->id);
		}
	}
	static function recogeCesta ( $campo , $valor = false )
	{
		$resultado = false;
		try {
			
			if( ! $cesta = parent :: recoge( $campo , $valor , __CLASS__ ) ) {
				print "<error tipo=\"logico\">".__CLASS__." no encontrado</error>\n";
			} else {
				$cesta = new self( $cesta["clientes_id"], $cesta["nombre"], $cesta["total"],  $cesta["fecha"], $cesta["id"] );
				if( $cesta->nombre == "" ) {
					$cesta->respuestaxml .= "<error tipo=\"logico\">".__CLASS__." no recogido</error>\n";
				} else {
					$cesta->respuestaxml .= "<mensaje>".__CLASS__." recogido</mensaje>\n";
					$relaciones = relacion_cesta::recogeRelaciones_cesta( "id", $this->id );
					foreach ($relaciones as $numero => $relacion ) {
						$busqueda["id"] = $relacion["detalle_cestas_id"];
						$this->productos = detalle_cesta::recogeDetalles_cesta($busqueda);
					}
				}
			}
			$resultado = $cesta;
		} catch ( Exception $error ) {
			print "<error tipo=\"sql\">".$error->getMessage()."</error>\n";
		}
		return $resultado;
	}
	static function recogeCestas ( $campo , $valor = false )
	{
		$resultado = false;
		try {
			
			if( ! $cestas = parent :: recogeObjectos( $campo , $valor, __CLASS__ ) ) {
				print  "<error tipo=\"logico\">".__CLASS__."s no encontrados</error>\n";
			} else {
				while ( $fila = $cestas->fetch ( PDO::FETCH_ASSOC ) ) {
					$cesta[ $fila["id"] ] = new self( $fila["clientes_id"], $fila["nombre"], $fila["total"],  $fila["fecha"], $fila["id"] );
					if( $cesta[$fila["id"]]->nombre == "" ) {
						$cesta[$fila["id"]]->respuestaxml .= "<error tipo=\"logico\">".__CLASS__." $fila[id] no recogido</error>\n";
					} else {
						$cesta->respuestaxml .= "<mensaje>".__CLASS__." recogido</mensaje>\n";
						$relaciones = relacion_cesta::recogeRelaciones_cesta( "id", $this->id );
						foreach ($relaciones as $numero => $relacion ) {
							$busqueda["id"] = $relacion["detalle_cestas_id"];
							$this->productos = detalle_cesta::recogeDetalles_cesta($busqueda);
						}
					}
				}
				$resultado = $cesta;
				print  "<mensaje>".__CLASS__."s recogidos</mensaje>\n";
			}
			return $resultado;
		} catch ( Exception $error ) {
			print "<error tipo=\"sql\">".$error->getMessage()."</error>\n";
		}
	}
	function sincronizar( $busqueda = false)
	{
		if( ! $busqueda ) {
			if($this->nombre) {
				$this->campos["nombre"] = $this->nombre;
			}
			if($this->total) {
				$this->campos["total"] = $this->total;
			}
			if($this->clientes_id) {
				$this->campos["clientes_id"] = $this->clientes_id;
			}
			if($this->fecha) {
				$this->campos["fecha"] = $this->fecha;
			}
			if($this->id != "no") {
				$this->campos["id"] = $this->id;
			}
		} else {
			$this->campos = $busqueda;
		}
		parent :: sincronizar( $this->campos, __CLASS__ );
	}
	private function validar( $propiedad, $valor )
	{
		switch ( $propiedad ) {
			case "nombre":
				if ( ! preg_match( DENOMINACION, $valor ) ) {
					$this->respuestaxml .= "<error campo=\"$propiedad\" tipo=\"validacion\">fallo de validacion de $propiedad</error>\n";
					$this->valido = false;
				}
				break;
			case "total":
				if ( ! preg_match( NUMERO_DECIMAL, $valor ) ) {
					$this->respuestaxml .= "<error campo=\"$propiedad\" tipo=\"validacion\">fallo de validacion de $propiedad</error>\n";
					$this->valido = false;
				}
				break;
			case "clientes_id":
				if ( ! preg_match( ID, $valor ) ) {
					$this->respuestaxml .= "<error campo=\"$propiedad\" tipo=\"validacion\">fallo de validacion de $propiedad</error>\n";
					$this->valido = false;
				}
				break;
			case "fecha":
				if ( ! preg_match( DATETIME, $valor ) ) {
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
