<?php
require_once "conexion.global.php";
require_once "baseDatos.class.php";
require_once "expresionesRegulares.php";
class pago extends gestionTablas
{
	protected $pago;
	protected $incremento;
	function __construct ( $pago, $incremento = false, $id = "no" )
	{
		try {
			$this->conexion = new baseDatos( BASEDATOS, "pago", HOST, USUARIO, BASEDATOS_PASSWORD );
			$this->valido = true;
			$this->sincronizado = false;
			$this->respuestaxml = "";
			if( $id == "no" ) {
				$this->validar("pago", $pago);
				if( $incremento ) {
					$this->validar("incremento", $incremento);
				}
				$resultado = $this->alta();
			} else {
				$this->pago = $pago;
				$this->incremento = $incremento;
				$this->id = $id;
			}
		} catch ( Exception $error ) {
			$this->respuestaxml .= "<mensaje>".$error->getMessage()."</mensaje>\n";
		}
	}
	private function alta ()
	{
		$resultado = false;
		try {
			if( $this->valido ) {
				if( $this->existe( "pago" ) ) {
					$this->respuestaxml .= "<error campo=\"pago\" tipo=\"existe\">ya existe el pago</error>\n";
				} else {
					$resultado = parent :: insercion( $this->campos, __CLASS__ );
					/* Se podria comprobar el estado de la insercion y lanzar un mensaje personlizado, ya hay un mensaje por defecto*/
				}
			}
		} catch ( Exception $error ) {
			$this->respuestaxml .= "<error tipo=\"sql\">".$error->getMessage()."</error>\n";
		}
		return $resultado;
	}
	function __set ( $propiedad, $valor)
	{
		$resultado = false;
		try {
			if ( $this->validar( $propiedad, $valor ) ) {
				if( $propiedad == "pago" ) {
					if( $this->existe( "pago" ) ) {
						$this->respuestaxml .= "<error campo=\"pago\" tipo=\"existe\">ya existe el pago</error>\n";
					} else {
						$resultado = parent :: modificacion( $propiedad, $valor, __CLASS__ );
					}
				} else {
					$resultado = parent :: modificacion( $propiedad, $valor, __CLASS__ );
				}
				/* Se podria comprobar el estado de la insercion y lanzar un mensaje personlizado, ya hay un mensaje por defecto*/
			}
		} catch ( Exception $error ) {
			$this->respuestaxml .= "<error tipo=\"sql\">".$error->getMessage()."</error>\n";
		}
		return $resultado;
	}
	function baja ()
	{
		$resultado = false;
		try {
			$resultado = parent :: borrado( __CLASS__ );
			/* Se podria comprobar el estado de la insercion y lanzar un mensaje personlizado, ya hay un mensaje por defecto*/
		} catch ( Exception $error ) {
			print "<error tipo=\"sql\">".$error->getMessage()."</error>\n";
		}
		return $resultado;
	}
	static function recogePago ( $campo , $valor = false )
	{
		$resultado = false;
		try {
			if( ! $pago = parent :: recoge( $campo , $valor , __CLASS__ ) ) {
				print "<error tipo=\"logico\">".__CLASS__." no encontrado</error>\n";
			} else {
				$pago = new self( $pago["pago"], $pago["incremento"], $pago["id"] );
				if( $pago->pago == "" ) {
					$pago->respuestaxml .= "<error tipo=\"logico\">".__CLASS__." no recogido</error>\n";
				} else {
					$pago->respuestaxml .= "<mensaje>".__CLASS__." recogido</mensaje>\n";
				}
			}
			$resultado = $pago;
		} catch ( Exception $error ) {
			print "<error tipo=\"sql\">".$error->getMessage()."</error>\n";
		}
		return $resultado;
	}
	static function recogePagos ( $campo , $valor = false )
	{
		$resultado = false;
		try {
			if( ! $pagos = parent :: recogeObjectos( $campo , $valor, __CLASS__ ) ) {
				print  "<error tipo=\"logico\">".__CLASS__."s no encontrados</error>\n";
			} else {
				while ( $fila = $pagos->fetch ( PDO::FETCH_ASSOC ) ) {
					$pago[ $fila["id"] ] = new self( $fila["pago"], $fila["incremento"], $fila["id"] );
					if( $pago[$fila["id"]]->pago == "" ) {
						$pago[$fila["id"]]->respuestaxml .= "<error tipo=\"logico\">".__CLASS__." $fila[id] no recogido</error>\n";
					} else {
						$pago[$fila["id"]]->respuestaxml .= "<mensaje>".__CLASS__." $fila[id] recogido</mensaje>\n";
					}
				}
				$resultado = $pago;
				print  "<mensaje>".__CLASS__."s recogidos</mensaje>\n";
			}
			
		} catch ( Exception $error ) {
			print "<error tipo=\"sql\">".$error->getMessage()."</error>\n";
		}
		return $resultado;
	}
	static function recogeTodosPagos( $orden = false ) {
		$resultado = false;
		try {
			if( ! $pagos = parent:: recogeTodos( __CLASS__, $orden) ) {
				print  "<error tipo=\"logico\">".__CLASS__."s no encontrados</error>\n";
			} else {
				while ( $fila = $pagos->fetch ( PDO::FETCH_ASSOC ) ) {
					$pago[ $fila["id"] ] = new self( $fila["pago"], $fila["incremento"], $fila["id"] );
					if( $pago[$fila["id"]]->pago == "" ) {
						$pago[$fila["id"]]->respuestaxml .= "<error tipo=\"logico\">".__CLASS__." $fila[id] no recogido</error>\n";
					} else {
						$pago[$fila["id"]]->respuestaxml .= "<mensaje>".__CLASS__." $fila[id] recogido</mensaje>\n";
					}
				}
				$resultado = $pago;
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
				if($this->pago) {
					$this->campos["pago"] = $this->pago;
				}
				if($this->incremento) {
					$this->campos["incremento"] = $this->incremento;
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
			case "pago":
				if ( ! preg_match( DENOMINACION, $valor ) ) {
					$this->respuestaxml .= "<error campo=\"$propiedad\" tipo=\"validacion\">fallo de validacion de $propiedad</error>\n";
					$this->valido = false;
				}
				break;
			case "incremento":
				if ( ! preg_match( DECIMAL, $valor ) ) {
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
		if( $this->valido ) {
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