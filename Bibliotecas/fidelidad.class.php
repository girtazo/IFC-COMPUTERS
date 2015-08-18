<?php
require_once "conexion.global.php";
require_once "baseDatos.class.php";
require_once "expresionesRegulares.php";
class fidelidad extends gestionTablas
{
	protected $nombre;
	function __construct ( $nombre, $id = "no" )
	{
		try {
			$this->conexion = new baseDatos( BASEDATOS, "fidelidad", HOST, USUARIO, BASEDATOS_PASSWORD );
			$this->valido = true;
			$this->sincronizado = false;
			$this->respuestaxml = "";
			$this->validar("nombre", $nombre);
			if( $id == "no" ) {
				$resultado = $this->alta();
			} else {
				$this->nombre = $nombre;
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
				if( $this->existe( "nombre" ) ) {
					$this->respuestaxml .= "<error campo=\"nombre\" tipo=\"existe\">ya existe el nombre</error>\n";
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
				if( $propiedad == "nombre" ) {
					if( $this->existe( "nombre" ) ) {
						$this->respuestaxml .= "<error campo=\"nombre\" tipo=\"existe\">ya existe el nombre</error>\n";
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
	static function recogeFidelidad ( $campo , $valor = false )
	{
		$resultado = false;
		try {
			if( ! $fidelidad = parent :: recoge( $campo , $valor , __CLASS__ ) ) {
				print "<error tipo=\"logico\">".__CLASS__." no encontrado</error>\n";
			} else {
				$fidelidad = new self( $fidelidad["nombre"], $fidelidad["id"] );
				if( $fidelidad->nombre == "" ) {
					$fidelidad->respuestaxml .= "<error tipo=\"logico\">".__CLASS__." no recogido</error>\n";
				} else {
					$fidelidad->respuestaxml .= "<mensaje>".__CLASS__." recogido</mensaje>\n";
				}
			}
			$resultado = $fidelidad;
		} catch ( Exception $error ) {
			print "<error tipo=\"sql\">".$error->getMessage()."</error>\n";
		}
		return $resultado;
	}
	static function recogeFidelidades ( $campo , $valor = false )
	{
		$resultado = false;
		try {
			if( ! $fidelidades = parent :: recogeObjectos( $campo , $valor, __CLASS__ ) ) {
				print  "<error tipo=\"logico\">".__CLASS__."s no encontrados</error>\n";
			} else {
				while ( $fila = $fidelidades->fetch ( PDO::FETCH_ASSOC ) ) {
					$fidelidad[ $fila["id"] ] = new self( $fila["nombre"], $fila["id"] );
					if( $fidelidad[$fila["id"]]->nombre == "" ) {
						$fidelidad[$fila["id"]]->respuestaxml .= "<error tipo=\"logico\">".__CLASS__." $fila[id] no recogido</error>\n";
					} else {
						$fidelidad[$fila["id"]]->respuestaxml .= "<mensaje>".__CLASS__." $fila[id] recogido</mensaje>\n";
					}
				}
				$resultado = $fidelidad;
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
				if($this->nombre) {
					$this->campos["nombre"] = $this->nombre;
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
			case "nombre":
				if ( ! preg_match( DENOMINACION, $valor ) ) {
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