<?php
require_once "conexion.global.php";
require_once "baseDatos.class.php";
require_once "expresionesRegulares.php";
class producto extends gestionTablas
{
	protected $nombre;
	protected $descripcion;
	protected $peso;
	protected $stock;
	protected $precio;
	protected $oferta;
	protected $servicio;
	protected $imagen;
	function __construct ( $nombre, $descripcion, $peso = false, $stock = false, $precio = false, $oferta = false, $servicio = false, $imagen = false, $id = "no" )
	{
		try {
			$this->conexion = new baseDatos( BASEDATOS, "producto", HOST, USUARIO, BASEDATOS_PASSWORD );
			$this->valido = true;
			$this->sincronizado = false;
			$this->respuestaxml = "";
			if( ! $id == "no" ) {
				$this->validar("nombre", $nombre);
				$this->validar("descripcion", $descripcion);
				if( $peso ) {
					$this->validar("peso", $peso);
				}
				if( $stock ) {
					$this->validar("stock", $stock);
				}
				if( $precio ) {
					$this->validar("precio", $precio);
				}
				if( $imagen ) {
					$this->validar("imagen", $imagen);
				}
				if( $oferta ) {
					$this->validar("oferta", $oferta);
				}
				if( $oferta ) {
					$this->validar("servicio", $oferta);
				}
				$resultado = $this->alta();
			} else {
				$this->id = $id;
				$this->nombre = $nombre;
				$this->descripcion = $descripcion;
				$this->peso = $peso;
				$this->stock = $stock;
				$this->precio = $precio;
				$this->imagen = $imagen;
				$this->oferta = $oferta;
				$this->servicio = $servicio;
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
	static function recogeProducto ( $campo , $valor = false )
	{
		$resultado = false;
		try {
			if( ! $producto = parent :: recoge( $campo , $valor , __CLASS__ ) ) {
				print "<error tipo=\"logico\">".__CLASS__." no encontrado</error>\n";
			} else {
				$producto = new self( $producto["nombre"], $producto["descripcion"], $producto["peso"], $producto["stock"], $producto["precio"], $producto["oferta"], $producto["servicio"], $producto["imagen"], $producto["id"] );
				if( $producto->nombre == "" ) {
					$producto->respuestaxml .= "<error tipo=\"logico\">".__CLASS__." no recogido</error>\n";
				} else {
					$producto->respuestaxml .= "<mensaje>".__CLASS__." recogido</mensaje>\n";
				}
			}
			$resultado = $producto;
		} catch ( Exception $error ) {
			print "<error tipo=\"sql\">".$error->getMessage()."</error>\n";
		}
		return $resultado;
	}
	static function recogeProductos ( $campo , $valor = false )
	{
		$resultado = false;
		try {
			if( ! $productos = parent :: recogeObjectos( $campo , $valor, __CLASS__ ) ) {
				print  "<error tipo=\"logico\">".__CLASS__."s no encontrados</error>\n";
			} else {
				while ( $fila = $productos->fetch ( PDO::FETCH_ASSOC ) ) {
					$producto[ $fila["id"] ] = new self( $fila["nombre"], $fila["descripcion"], $fila["peso"], $fila["stock"], $fila["precio"], $fila["oferta"], $fila["servicio"], $fila["imagen"], $fila["id"] );
					if( $producto[$fila["id"]]->nombre == "" ) {
						$producto[$fila["id"]]->respuestaxml .= "<error tipo=\"logico\">".__CLASS__." $fila[id] no recogido</error>\n";
					} else {
						$producto[$fila["id"]]->respuestaxml .= "<mensaje>".__CLASS__." $fila[id] recogido</mensaje>\n";
					}
				}
				$resultado = $producto;
				//print  "<mensaje>".__CLASS__."s recogidos</mensaje>\n";
			}
			
		} catch ( Exception $error ) {
			print "<error tipo=\"sql\">".$error->getMessage()."</error>\n";
		}
		return $resultado;
	}
	static function recogeTodosProductos( $orden = false ) {
		$resultado = false;
		try {
			if( ! $productos = parent:: recogeTodos( __CLASS__, $orden) ) {
				print  "<error tipo=\"logico\">".__CLASS__."s no encontrados</error>\n";
			} else {
				while ( $fila = $productos->fetch ( PDO::FETCH_ASSOC ) ) {
					$producto[ $fila["id"] ] = new self( $fila["nombre"], $fila["descripcion"], $fila["peso"], $fila["stock"], $fila["precio"], $fila["oferta"], $fila["servicio"], $fila["imagen"], $fila["id"] );
					if( $producto[$fila["id"]]->nombre == "" ) {
						$producto[$fila["id"]]->respuestaxml .= "<error tipo=\"logico\">".__CLASS__." $fila[id] no recogido</error>\n";
					} else {
						$producto[$fila["id"]]->respuestaxml .= "<mensaje>".__CLASS__." $fila[id] recogido</mensaje>\n";
					}
				}
				$resultado = $producto;
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
				if($this->descripcion) {
					$this->campos["descripcion"] = $this->nombre;
				}
				if($this->peso) {
					$this->campos["peso"] = $this->peso;
				}
				if($this->stock) {
					$this->campos["stock"] = $this->stock;
				}
				if($this->precio) {
					$this->campos["precio"] = $this->precio;
				}
				if($this->oferta) {
					$this->campos["oferta"] = $this->oferta;
				}
				if($this->oferta) {
					$this->campos["servicio"] = $this->servicio;
				}
				if($this->imagen) {
					$this->campos["imagen"] = $this->imagen;
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
			case "descripcion":
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
			case "stock":
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
			case "imagen":
				if ( ! preg_match( IMAGEN, $valor ) ) {
					$this->respuestaxml .= "<error campo=\"$propiedad\" tipo=\"validacion\">fallo de validacion de $propiedad</error>\n";
					$this->valido = false;
				}
				break;
			case "oferta":
				if ( ! (  preg_match( BOOLEANOCADENA, $valor ) ||  preg_match( BOOLEANO, $valor ) ) ) {
					$this->respuestaxml .= "<error campo=\"$propiedad\" tipo=\"validacion\">fallo de validacion de $propiedad</error>\n";
					$this->valido = false;
				}
				break;
			case "servicio":
				if ( ! (  preg_match( BOOLEANOCADENA, $valor ) ||  preg_match( BOOLEANO, $valor ) ) ) {
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
			if( $propiedad == "oferta" ) {
				if( ( $valor == "true" ) || ( $valor == 1 ) ) {
					$valor = 1;
				} else {
					$valor = 0;
				}
			} else if( $propiedad == "servicio" ) {
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