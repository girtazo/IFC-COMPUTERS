<?php
require_once "conexion.global.php";
require_once "baseDatos.class.php";
require_once "expresionesRegulares.php";
class relacion_pedido extends gestionTablas
{
	protected $pedidos_id;
	protected $detalle_pedidos_id;
	function __construct ( $pedidos_id, $detalle_pedidos_id )
	{
		try {
			$this->conexion = new baseDatos( BASEDATOS, "detalle_pedido_has_pedido", HOST, USUARIO, BASEDATOS_PASSWORD );
			$this->valido = true;
			$this->sincronizado = false;
			$this->respuestaxml = "";
			$this->validar("pedidos_id", $pedidos_id);
			$this->validar("detalle_pedidos_id", $detalle_pedidos_id);
			$this->relacionar();
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
					$resultado = parent :: insercion( $this->campos, "detalle_pedido_has_pedido" );
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
			if( ! $resultado = parent :: borrado( "detalle_pedido_has_pedido", $this->campos ) ) {
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
	static function recogeRelacion_pedido ( $campo, $valor = false )
	{
		$resultado = false;
		try {
			if( ! $relacion_pedido = parent :: recoge( $campo , $valor , "detalle_pedido_has_pedido" ) ) {
				print "<error tipo=\"logico\">relacion pedido no encontrada</error>\n";
			} else {
				$relacion_pedido = new self( $relacion_pedido["pedidos_id"], $relacion_pedido["detalle_pedidos_id"] );
				if( $relacion_pedido->nombre == "" ) {
					$relacion_pedido->respuestaxml .= "<error tipo=\"logico\">relacion pedido no recogida</error>\n";
				} else {
					$relacion_pedido->respuestaxml .= "<mensaje>relacion pedido recogida</mensaje>\n";
				}
			}
			$resultado = $relacion_pedido;
		} catch ( Exception $error ) {
			print "<error tipo=\"sql\">".$error->getMessage()."</error>\n";
		}
		return $resultado;
	}
	static function recogeRelaciones_pedido ( $campo , $valor = false )
	{
		$resultado = false;
		try {
			if( ! $relaciones_pedido = parent :: recogeObjectos( $campo , $valor, "detalle_pedido_has_pedido" ) ) {
				print  "<error tipo=\"logico\">"."detalle_pedido_has_pedido"."s no encontrados</error>\n";
			} else {
				$numero = 0;
				$relacion_pedido = new ArrayObject();
				while ( $fila = $relaciones_pedido->fetch ( PDO::FETCH_ASSOC ) ) {
					$numero = $numero + 1;
					$relacion_pedido[ $numero ] = new self( $fila["pedidos_id"], $fila["detalle_pedidos_id"] );
					if( $relacion_pedido[$numero]->pedidos_id == "" ) {
						$relacion_pedido[$numero]->respuestaxml .= "<error tipo=\"logico\">detalle_pedido_has_pedido $fila[detalle_pedidos_id] no recogido</error>\n";
					} else {
						$relacion_pedido[$numero]->respuestaxml .= "<mensaje>detalle_pedido_has_pedido $fila[detalle_pedidos_id] recogido</mensaje>\n";
					}
				}
				$resultado = $relacion_pedido;
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
				if($this->pedidos_id) {
					$this->campos["pedidos_id"] = $this->pedidos_id;
				}
				if($this->detalle_pedidos_id) {
					$this->campos["id"] = $this->id;
				}
			} else {
				$this->campos = $busqueda;
			}
			parent :: sincronizar( $this->campos, "detalle_pedido_has_pedido" );
		} catch ( Exception $error ) {
			$this->respuestaxml .= "<error tipo=\"sql\">".$error->getMessage()."</error>\n";
		}
	}
	private function validar( $propiedad, $valor )
	{
		switch ( $propiedad ) {
			case "pedidos_id":
				if ( ! preg_match( ID, $valor ) ) {
					$this->respuestaxml .= "<error campo=\"$propiedad\" tipo=\"validacion\">fallo de validacion de $propiedad</error>\n";
					$this->valido = false;
				}
				break;
			case "detalle_pedidos_id":
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