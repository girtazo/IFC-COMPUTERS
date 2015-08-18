<?php
require_once "conexion.global.php";
require_once "baseDatos.class.php";
require_once "expresionesRegulares.php";
class envio extends gestionTablas
{
	protected $tipo;
	protected $coste;
	protected $tiempo;
	protected $peso;
	protected $empresas_transporte_id;
	function __construct ( $tipo, $coste, $tiempo, $peso, $empresas_transporte_id, $id = "no" )
	{
		try {
			if( $id == "no" ) {
				$this->conexion = new baseDatos( BASEDATOS, "envio", HOST, USUARIO, BASEDATOS_PASSWORD );
				$this->valido = true;
				$this->sincronizado = false;
				$this->respuestaxml = "";
				$this->validar("tipo", $tipo);
				$this->validar("coste", $coste);
				$this->validar("tiempo", $tiempo);
				$this->validar("empresas_transporte_id", $empresas_transporte_id);
				$this->validar("peso", $peso);
				$resultado = $this->alta();
			} else {
				$this->tipo = $tipo;
				$this->coste = $coste;
				$this->tiempo = $tiempo;
				$this->empresas_transporte_id = $empresas_transporte_id;
				$this->peso = $peso;
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
			$resultado = parent :: insercion( $this->campos, __CLASS__ );
			/* Se podria comprobar el estado de la insercion y lanzar un mensaje personlizado, ya hay un mensaje por defecto*/
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
				if( $propiedad == "nombre" ) {
					$resultado = parent :: modificacion( $propiedad, $valor, __CLASS__ );
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
	static function recogeEnvio ( $campo , $valor = false )
	{
		$resultado = false;
		try {
			if( ! $envio = parent :: recoge( $campo , $valor , __CLASS__ ) ) {
				print "<error tipo=\"logico\">".__CLASS__." no encontrado</error>\n";
			} else {
				$envio = new self( $envio["tipo"], $envio["coste"], $envio["tiempo"], $envio["peso"], $envio["empresas_transporte_id"], $envio["id"] );
				if( $envio->tipo == "" ) {
					$envio->respuestaxml .= "<error tipo=\"logico\">".__CLASS__." no recogido</error>\n";
				} else {
					$envio->respuestaxml .= "<mensaje>".__CLASS__." recogido</mensaje>\n";
				}
			}
			$resultado = $envio;
		} catch ( Exception $error ) {
			print "<error tipo=\"sql\">".$error->getMessage()."</error>\n";
		}
		return $resultado;
	}
	static function recogeEnvios ( $campo , $valor = false, $comparacion = ">=" )
	{
		$resultado = false;
		try {
			if( ! $envios = parent :: recogeObjectos( $campo , $valor, __CLASS__, $comparacion ) ) {
				print  "<error tipo=\"logico\">".__CLASS__."s no encontrados</error>\n";
			} else {
				while ( $fila = $envios->fetch ( PDO::FETCH_ASSOC ) ) {
					$envio[ $fila["id"] ] = new self( $fila["tipo"], $fila["coste"], $fila["tiempo"], $fila["peso"], $fila["empresas_transporte_id"], $fila["id"] );
					if( $envio[$fila["id"]]->tipo == "" ) {
						$envio[$fila["id"]]->respuestaxml .= "<error tipo=\"logico\">".__CLASS__." $fila[id] no recogido</error>\n";
					} else {
						$envio[$fila["id"]]->respuestaxml .= "<mensaje>".__CLASS__." $fila[id] recogido</mensaje>\n";
					}
				}
				$resultado = $envio;
			}
		} catch ( Exception $error ) {
			print "<error tipo=\"sql\">".$error->getMessage()."</error>\n";
		}
		return $resultado;
	}
	static function enviosPedido($peso) {
		$resultado = false;
		try {
			$parametros["peso"] = $peso;
			$conexion = new baseDatos(BASEDATOS,"envio");
			$parametros["peso"] = $peso;
			if( ! $envios = $conexion->ejecutarSQL( "SELECT DISTINCT * FROM envio WHERE peso <= :peso ORDER BY peso DESC", $parametros ) ) {
				print  "<error tipo=\"logico\">".__CLASS__."s no encontrados</error>\n";
			} else {
				$peso = "inicio";
				while ( $fila = $envios->fetch ( PDO::FETCH_ASSOC ) ) {
					if( $peso == "inicio" ) {
						$peso = $fila["peso"];
					}
					if( $fila["peso"] == $peso ) {
						$envio[ $fila["id"] ] = new self( $fila["tipo"], $fila["coste"], $fila["tiempo"], $fila["peso"], $fila["empresas_transporte_id"], $fila["id"] );
						if( $envio[$fila["id"]]->tipo == "" ) {
							$envio[$fila["id"]]->respuestaxml .= "<error tipo=\"logico\">".__CLASS__." $fila[id] no recogido</error>\n";
						} else {
							$envio[$fila["id"]]->respuestaxml .= "<mensaje>".__CLASS__." $fila[id] recogido</mensaje>\n";
						}
					}
				}
				$resultado = $envio;
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
				if($this->tipo) {
					$this->campos["tipo"] = $this->tipo;
				}
				if($this->coste) {
					$this->campos["coste"] = $this->coste;
				}
				if($this->tiempo) {
					$this->campos["tiempo"] = $this->tiempo;
				}
				if($this->peso) {
					$this->campos["peso"] = $this->peso;
				}
				if($this->nombre) {
					$this->campos["empresas_transporte_id"] = $this->empresas_transporte_id;
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
			case "tipo":
				if ( ! preg_match( DENOMINACION, $valor ) ) {
					$this->respuestaxml .= "<error campo=\"$propiedad\" tipo=\"validacion\">fallo de validacion de $propiedad</error>\n";
					$this->valido = false;
				}
				break;
			case "coste":
				if ( ! preg_match( DECIMAL, $valor ) ) {
					$this->respuestaxml .= "<error campo=\"$propiedad\" tipo=\"validacion\">fallo de validacion de $propiedad</error>\n";
					$this->valido = false;
				}
				break;
			case "tiempo":
				if ( ! preg_match( DENOMINACION, $valor ) ) {
					$this->respuestaxml .= "<error campo=\"$propiedad\" tipo=\"validacion\">fallo de validacion de $propiedad</error>\n";
					$this->valido = false;
				}
				break;
			case "peso":
				if ( ! preg_match( DECIMAL, $valor ) ) {
					$this->respuestaxml .= "<error campo=\"$propiedad\" tipo=\"validacion\">fallo de validacion de $propiedad</error>\n";
					$this->valido = false;
				}
				break;
			case "empresas_transporte_id":
				if ( ! preg_match( DENOMINACION, $valor ) ) {
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