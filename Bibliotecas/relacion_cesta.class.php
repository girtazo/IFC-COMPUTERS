<?php
require_once "conexion.global.php";
require_once "baseDatos.class.php";
require_once "expresionesRegulares.php";
class relacion_cesta extends gestionTablas
{
	protected $cestas_id;
	protected $detalle_cestas_id;
	function __construct ( $cestas_id, $detalle_cestas_id )
	{
		try {
			$this->conexion = new baseDatos( BASEDATOS, "relacion_cesta", HOST, USUARIO, BASEDATOS_PASSWORD );
			$this->valido = true;
			$this->sincronizado = false;
			$this->respuestaxml = "";
			$this->validar("cestas_id", $cestas_id);
			$this->validar("detalle_cestas_id", $detalle_cestas_id);
		} catch ( Exception $error ) {
			$this->respuestaxml .= "<mensaje>".$error->getMessage()."</mensaje>\n";
		}
	}
	private function relacionar ()
	{
		$resultado = false;
		try {
			if( $this->valido ) {
				if( $this->existe( $this->campos ) ) {
					$this->respuestaxml .= "<error tipo=\"existe\">ya existe la relacion</error>\n";
				} else {
					if( $resultado = parent :: insercion( $this->campos, "detalle_cesta_has_cesta" ) )
					{
						$this->respuestaxml .= "<mensaje>ya se ha relacionado</mensaje>\n";
					}
					/* Se podria comprobar el estado de la inserción y lanzar un mensaje personlizado, ya hay un mensaje por defecto*/
				}
			}
		} catch ( Exception $error ) {
			$this->respuestaxml .= "<error tipo=\"sql\">".$error->getMessage()."</error>\n";
		}
		return $resultado;
	}
	function eliminar ()
	{
		$resultado = false;
		try {
			if( ! $resultado = parent :: borrado( "detalle_cesta_has_cesta", $this->campos ) ) {
				$this->respuestaxml .= "<error tipo=\"logico\">no se ha podido eliminar la relación</error>\n";
			} else {
				$this->respuestaxml .= "<mensaje>ya se ha eleminado la relación</mensaje>\n";
			}
			/* Se podria comprobar el estado y lanzar un mensaje personalizado, ya hay un mensaje por defecto*/
		} catch ( Exception $error ) {
			print "<error tipo=\"sql\">".$error->getMessage()."</error>\n";
		}
		return $resultado;
	}
	static function recogeRelacion_cesta ( $campo, $valor = false )
	{
		$resultado = false;
		try {
			if( ! $relacion_cesta = parent :: recoge( $campo , $valor , "detalle_cesta_has_cesta" ) ) {
				print "<error tipo=\"logico\">relacion cesta no encontrada</error>\n";
			} else {
				$relacion_cesta = new self( $relacion_cesta["cestas_id"], $relacion_cesta["detalle_cestas_id"] );
				if( $relacion_cesta->nombre == "" ) {
					$relacion_cesta->respuestaxml .= "<error tipo=\"logico\">relacion cesta no recogida</error>\n";
				} else {
					$relacion_cesta->respuestaxml .= "<mensaje>relacion cesta recogida</mensaje>\n";
				}
			}
			$resultado = $relacion_cesta;
		} catch ( Exception $error ) {
			print "<error tipo=\"sql\">".$error->getMessage()."</error>\n";
		}
		return $resultado;
	}
	static function recogeRelaciones_cesta ( $campo , $valor = false )
	{
		$resultado = false;
		try {
			if( ! $relaciones_cesta = parent :: recogeObjectos( $campo , $valor, "detalle_cesta_has_cesta" ) ) {
				print  "<error tipo=\"logico\">"."detalle_cesta_has_cesta"."s no encontrados</error>\n";
			} else {
				$numero = 0;
				while ( $fila = $relaciones_cesta->fetch ( PDO::FETCH_ASSOC ) ) {
					$numero = $numero + 1;
					$relacion_cesta[ $numero ] = new self( $fila["cestas_id"], $fila["id"] );
					if( $relacion_cesta[$numero]->cestas_id == "" ) {
						$relacion_cesta[$numero]->respuestaxml .= "<error tipo=\"logico\">detalle_cesta_has_cesta $fila[id] no recogido</error>\n";
					} else {
						$relacion_cesta[$numero]->respuestaxml .= "<mensaje>detalle_cesta_has_cesta $fila[id] recogido</mensaje>\n";
					}
				}
				$resultado = $relacion_cesta;
				print  "<mensaje>detalle_cesta_has_cestas recogidos</mensaje>\n";
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
				if($this->cestas_id) {
					$this->campos["cestas_id"] = $this->cestas_id;
				}
				if($this->detalle_cestas_id) {
					$this->campos["id"] = $this->id;
				}
			} else {
				$this->campos = $busqueda;
			}
			parent :: sincronizar( $this->campos, "detalle_cesta_has_cesta" );
		} catch ( Exception $error ) {
			$this->respuestaxml .= "<error tipo=\"sql\">".$error->getMessage()."</error>\n";
		}
	}
	private function validar( $propiedad, $valor )
	{
		switch ( $propiedad ) {
			case "cestas_id":
				if ( ! preg_match( ID, $valor ) ) {
					$this->respuestaxml .= "<error campo=\"$propiedad\" tipo=\"validacion\">fallo de validacion de $propiedad</error>\n";
					$this->valido = false;
				}
				break;
			case "detalle_cestas_id":
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