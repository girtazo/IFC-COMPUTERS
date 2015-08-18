<?php
require_once "conexion.global.php";
// BIBLIOTECAS
require_once "Arrays.php";
require_once "expresionesRegulares.php";
class pedido extends gestionTablas
{
	protected $total;
	protected $pagos_id;
	protected $envios_id;
	protected $fecha;
	protected $pagado;
	protected $enviado;
	protected $clientes_id;
	protected $comentario_id;
	protected $detalles;
	function __construct ( $pagos_id, $envios_id, $clientes_id = false, $cesta = false, $comentario_id = false, $fecha= false, $total = false, $pagado = false, $enviado = false, $id = "no" )
	{
		try {
				$this->conexion = new baseDatos( BASEDATOS, "pedido", HOST, USUARIO, BASEDATOS_PASSWORD );
				$this->valido = true;
				$this->sincronizado = false;
				$this->respuestaxml = "";
				if( $id != "no" ) {
					$this->pagos_id = $pagos_id;
					$this->envios_id = $envios_id;
					$this->fecha = $fecha;
					$this->total = $total;
					$this->pagado = $pagado;
					$this->enviado = $enviado;
					$this->clientes_id = $clientes_id;
					$this->comentario_id = $comentario_id;
					$this->id = $id;
				} else {
					$this->validar("pagos_id", $pagos_id);
					$this->validar("envios_id", $envios_id);
					if( $pagado ) {
						$this->validar("pagado", $pagado);
					}
					if( $enviado ) {
						$this->validar("enviado", $enviado);
					}
					if( $comentario_id ) {
						$this->validar("comentario_id", $comentario_id);
					}
					if( $clientes_id ) {
						$this->validar("clientes_id", $clientes_id);
					}
					$this->guarda($cesta);
				}
		} catch ( Exception $error ) {
			$this->respuestaxml .= "<mensaje>".$error->getMessage()."</mensaje>\n";
		}
	}
	function guarda ($cesta)
	{
		$resultado = false;
		try {
			if( ! ( $this->valido ) ) {
				$this->respuestaxml .= "<error tipo=\"logico\">Hay fallos de validacion</error>\n";
			} else {
				$fechaActual = getDate();
				if( $fechaActual["mon"] < 10 ) {
					$fechaActual["mon"] = "0".$fechaActual["mon"];
				}
				if( $fechaActual["mday"] < 10 ) {
					$fechaActual["mday"] = "0".$fechaActual["mday"];
				}
				if( $fechaActual["hours"] < 10 ) {
					$fechaActual["hours"] = "0".$fechaActual["hours"];
				}
				if( $fechaActual["minutes"] < 10 ) {
					$fechaActual["minutes"] = "0".$fechaActual["minutes"];
				}
				if( $fechaActual["seconds"] < 10 ) {
					$fechaActual["seconds"] = "0".$fechaActual["seconds"];
				}
				$this->campos["fecha"] = $fechaActual["year"]."-". $fechaActual["mon"]."-".$fechaActual["mday"]." ".$fechaActual["hours"].":".$fechaActual["minutes"].":".$fechaActual["seconds"];
				$envio = envio::recogeEnvio("id",$this->campos["envios_id"]);
				$pago = pago::recogePago("id",$this->campos["pagos_id"]);
				$this->campos["total"] = ( ( $cesta->total + $envio->coste ) * ( ( $pago->incremento / 100 ) + 1 ) );
				if( ! $resultado = parent :: insercion( $this->campos, __CLASS__ ) ) {
					$this->respuestaxml .= "<error tipo=\"logico\">Hay fallos de validacion</error>\n";
				} else {
					foreach ( $cesta->productos as $id => $producto ) {
						$this->detalles[$id] = new detalle_pedido( $producto->cantidad, $producto->precio, $producto->productos_id, $this->id );
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
			if ( $propiedad == "detalles" ) {
				$this->detalles = $valor;
			} else if ( $this->validar( $propiedad, $valor ) ) {
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
			if( $pedidos = parent :: borrado( __CLASS__ ) ) {
				/*foreach ( $pedidos as $id => $pedido ) {

					$resultado = $pedido->eliminar( $this->id );
				}*/
			}
			return $resultado;
		} catch ( Exception $error ) {
			print "<error tipo=\"sql\">".$error->getMessage()."</error>\n";
		}
	}
	static function recogePedido ( $campo , $valor = false )
	{
		$resultado = false;
		try {
			
			if( ! $pedido = parent :: recoge( $campo , $valor , __CLASS__ ) ) {
				print "<error tipo=\"logico\">".__CLASS__." no encontrado</error>\n";
			} else {
				$pedido = new self( $pedido["pagos_id"], $pedido["envios_id"], $pedido["clientes_id"], false, $pedido["comentario_id"], $pedido["fecha"], $pedido["total"], $pedido["pagado"], $pedido["enviado"], $pedido["id"] );
				if( $pedido->pagos_id == "" ) {
					$pedido->respuestaxml .= "<error tipo=\"logico\">".__CLASS__." no recogido</error>\n";
				} else {
					$pedido->respuestaxml .= "<mensaje>".__CLASS__." recogido</mensaje>\n";
					$relaciones = relacion_pedido::recogeRelaciones_pedido( "pedidos_id", $pedido->id );
					foreach ($relaciones as $indice => $relacion) {
						$detalles[$indice] = detalle_pedido::recogeDetalles_pedido("id",$relacion->detalle_pedidos_id);
					}
					$pedido->detalles = $detalles;
				}
			}
			$resultado = $pedido;
		} catch ( Exception $error ) {
			print "<error tipo=\"sql\">".$error->getMessage()."</error>\n";
		}
		return $resultado;
	}
	static function recogePedidos ( $campo , $valor = false )
	{
		$resultado = false;
		$pedido = Array();
		try {
			if( ! $pedidos = parent :: recogeObjectos( $campo , $valor, __CLASS__ ) ) {
				print  "<error tipo=\"logico\">".__CLASS__."s no encontrados</error>\n";
			} else {
				while ( $fila = $pedidos->fetch ( PDO::FETCH_ASSOC ) ) {
					$pedido[ $fila["id"] ] = new self( $fila["pagos_id"], $fila["envios_id"], $fila["clientes_id"], false, $fila["comentario_id"], $fila["fecha"], $fila["total"], $fila["pagado"], $fila["enviado"], $fila["id"] );
					if( $pedido[$fila["id"]]->pagos_id == "" ) {
						$pedido[$fila["id"]]->respuestaxml .= "<error tipo=\"logico\">".__CLASS__." $fila[id] no recogido</error>\n";
					} else {
						$pedido[$fila["id"]]->respuestaxml .= "<mensaje>".__CLASS__." recogido</mensaje>\n";
						$relaciones = relacion_pedido::recogeRelaciones_pedido( "pedidos_id", $pedido[$fila["id"]]->id );
						foreach ( $relaciones as $indice => $relacion ) {
							$detalles[$indice] = detalle_pedido::recogeDetalles_pedido("id",$relacion->detalle_pedidos_id);
						}
						$pedido[$fila["id"]]->detalles = $detalles;
					}
				}
				$resultado = $pedido;
			}
			return $resultado;
		} catch ( Exception $error ) {
			print "<error tipo=\"sql\">".$error->getMessage()."</error>\n";
		}
	}
	static function recogeTodosPedidos ( $orden = false )
	{
		$resultado = false;
		try {
			if( ! $pedidos = parent :: recogeTodos( __CLASS__, $orden ) ) {
				print  "<error tipo=\"logico\">".__CLASS__."s no encontrados</error>\n";
			} else {
				while ( $fila = $pedidos->fetch ( PDO::FETCH_ASSOC ) ) {
					$pedido[ $fila["id"] ] = new self( $fila["pagos_id"], $fila["envios_id"], $fila["clientes_id"], false, $fila["comentario_id"], $fila["fecha"], $fila["total"], $fila["pagado"], $fila["enviado"], $fila["id"] );
					if( $pedido[$fila["id"]]->pagos_id == "" ) {
						$pedido[$fila["id"]]->respuestaxml .= "<error tipo=\"logico\">".__CLASS__." $fila[id] no recogido</error>\n";
					} else {
						$pedido[$fila["id"]]->respuestaxml .= "<mensaje>".__CLASS__." recogido</mensaje>\n";
						$relaciones = relacion_pedido::recogeRelaciones_pedido( "pedidos_id", $pedido[$fila["id"]]->id );
						foreach ( $relaciones as $indice => $relacion ) {
							$detalles[$indice] = detalle_pedido::recogeDetalles_pedido("id",$relacion->detalle_pedidos_id);
						}
						$pedido[$fila["id"]]->detalles = $detalles;
					}
				}
				$resultado = $pedido;
			}
			return $resultado;
		} catch ( Exception $error ) {
			print "<error tipo=\"sql\">".$error->getMessage()."</error>\n";
		}
	}
	function sincronizar( $busqueda = false)
	{
		if( ! $busqueda ) {
			if($this->pagos_id) {
				$this->campos["pagos_id"] = $this->pagos_id;
			}
			if($this->envios_id) {
				$this->campos["envios_id"] = $this->envios_id;
			}
			if($this->clientes_id) {
				$this->campos["clientes_id"] = $this->clientes_id;
			}
			if($this->comentario_id) {
				$this->campos["comentario_id"] = $this->comentario_id;
			}
			if($this->fecha) {
				$this->campos["fecha"] = $this->fecha;
			}
			if($this->total) {
				$this->campos["total"] = $this->total;
			}
			if($this->pagado) {
				$this->campos["pagado"] = $this->pagado;
			}
			if($this->enviado) {
				$this->campos["enviado"] = $this->enviado;
			}
			if($this->id) {
				$this->campos["id"] = $this->id;
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
			case "pagos_id":
				if ( ! preg_match( ID, $valor ) ) {
					$this->respuestaxml .= "<error campo=\"$propiedad\" tipo=\"validacion\">fallo de validacion de $propiedad</error>\n";
					$this->valido = false;
				}
				break;
			case "envios_id":
				if ( ! preg_match( ID, $valor ) ) {
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
			case "pagado":
				if ( ! preg_match( BOOLEANO, $valor ) ) {
					$this->respuestaxml .= "<error campo=\"$propiedad\" tipo=\"validacion\">fallo de validacion de $propiedad</error>\n";
					$this->valido = false;
				}
				break;
			case "enviado":
				if ( ! preg_match( BOOLEANO, $valor ) ) {
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
			case "comentario_id":
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
			if( $propiedad == "pagado" ) {
				if( ( $valor == "true" ) || ( $valor == 1 ) ) {
					$valor = 1;
				} else {
					$valor = 0;
				}
			}
			if( $propiedad == "enviado" ) {
				if( ( $valor == "true" ) || ( $valor == 1 ) ) {
					$valor = 1;
				} else {
					$valor = 0;
				}
			}
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
