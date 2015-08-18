<?php
require_once "conexion.global.php";
require_once "baseDatos.class.php";
require_once "expresionesRegulares.php";
class usuario extends gestionTablas
{
	use encriptacion;
	protected $correo;
	protected $password;
	protected $nombre;
	protected $apellidos;
	protected $dni;
	protected $codigo_postal;
	protected $direccion;
	protected $telefono_fijo;
	protected $telefono_movil;
	protected $administrador;
	protected $boletin;
	protected $fidelidades_id;
	function __construct ( $correo, $password, $nombre = false, $apellidos = false, $dni = false, $codigo_postal = false, $direccion = false, $telefono_fijo = false, $telefono_movil = false, $boletin = false, $fidelidades_id = false, $administrador = false, $id = "no" ) {
		try {
			$this->conexion = new baseDatos( BASEDATOS, "usuario", HOST, USUARIO, BASEDATOS_PASSWORD );
			$this->valido = true;
			$this->sincronizado = false;
			$this->respuestaxml = "";
			if( $id == "no" ) {
				$this->validar("correo", $correo);
				$this->validar("password", $password);
				if( $nombre ) {
					$this->validar("nombre", $nombre);
				}
				if( $apellidos ) {
					$this->validar("apellidos", $apellidos);
				}
				if( $dni ) {
					$this->validar("dni", $dni);
				}
				if( $codigo_postal ) {
					$this->validar("codigo_postal", $codigo_postal);
				}
				if( $direccion ) {
					$this->validar("direccion", $direccion);
				}
				if( $telefono_fijo ) {
					$this->validar("telefono_fijo", $telefono_fijo);
				}
				if( $telefono_movil ) {
					$this->validar("telefono_movil", $telefono_movil);
				}
				if( $fidelidades_id ) {
					$this->validar("fidelidades_id", $fidelidades_id);
				}
				if( $boletin ) {
					$this->validar("boletin", $boletin);
				}
				if( $administrador ) {
					$this->validar("administrador", $administrador);
				}
				$resultado = $this->alta();
			} else {
				$this->id = $id;
				$this->correo = $correo;
				$this->password = $password;
				if( $nombre ) {
					$this->nombre = $nombre;
				}
				if( $apellidos ) {
					$this->apellidos = $apellidos;
				}
				if( $dni ) {
					$this->dni = $dni;
				}
				if( $codigo_postal ) {
					$this->codigo_postal = $codigo_postal;
				}
				if( $direccion ) {
					$this->direccion = $direccion;
				}
				if( $telefono_fijo ) {
					$this->telefono_fijo = $telefono_fijo;
				}
				if( $telefono_movil ) {
					$this->telefono_movil = $telefono_movil;
				}
				if( $fidelidades_id ) {
					$this->fidelidades_id = $fidelidades_id;
				}
				if( $boletin ) {
					$this->boletin = $boletin;
				}
				if( $administrador ) {
					$this->administrador = $administrador;
				}
			}
		} catch ( Exception $error ) {
			$this->respuestaxml .= "<mensaje>".$error->getMessage()."</mensaje>\n";
		}
	}
	private function alta () {
		$resultado = false;
		try {
			
			if( $this->valido ) {
				if( $this->existe( "correo" ) ) {
					$this->respuestaxml .= "<error campo=\"correo\" tipo=\"existe\">ya existe el correo</error>\n";
				} else if( $this->existe( "dni" ) ) {
					$this->respuestaxml .= "<error campo=\"dni\" tipo=\"existe\">ya existe el dni</error>\n";
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
	function __set ( $propiedad, $valor) {
		$resultado = false;
		try {
			if ( $this->validar( $propiedad, $valor ) ) {
				
				if( $propiedad == "correo" ) {
					if( $this->existe( "correo" ) ) {
						$this->respuestaxml .= "<error campo=\"correo\" tipo=\"existe\">ya existe el correo</error>\n";
					} else {
						$resultado = parent :: modificacion( $propiedad, $valor, __CLASS__ );
					}
				} else if( $propiedad == "dni" ) {
					if( $this->existe( "dni" ) ) {
						$this->respuestaxml .= "<error campo=\"dni\" tipo=\"existe\">ya existe el dni</error>\n";
					} else {
						$resultado = parent :: modificacion( $propiedad, $valor, __CLASS__ );
					}
				} else if( $propiedad == "password" ) {
					$hash = $this->getHash( $valor );
					while ( $hash == "*0") {
						$hash = $this->getHash($valor);
					}
					$resultado = parent :: modificacion( $propiedad, $hash, __CLASS__ );
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
	function baja () {
		$resultado = false;
		try {
			$resultado = parent :: borrado( __CLASS__ );
			/* Se podria comprobar el estado de la insercion y lanzar un mensaje personlizado, ya hay un mensaje por defecto*/
		} catch ( Exception $error ) {
			print "<error tipo=\"sql\">".$error->getMessage()."</error>\n";
		}
		return $resultado;
	}
	static function recogeUsuario ( $campo , $valor = false ) {
		$resultado = false;
		try {
			if( ! $usuario = parent :: recoge( $campo , $valor , __CLASS__ ) ) {
				print "<error tipo=\"logico\">".__CLASS__." no encontrado</error>\n";
			} else {
				$usuario = new self( $usuario["correo"], $usuario["password"], $usuario["nombre"], $usuario["apellidos"], $usuario["dni"], $usuario["codigo_postal"], $usuario["direccion"], $usuario["telefono_fijo"], $usuario["telefono_movil"], $usuario["boletin"], $usuario["fidelidades_id"], $usuario["administrador"], $usuario["id"] );
				if( $usuario->correo == "" ) {
					$usuario->respuestaxml .= "<error tipo=\"logico\">".__CLASS__." no recogido</error>\n";
				} else {
					$usuario->sincronizado = true;
					$usuario->respuestaxml .= "<mensaje>".__CLASS__." recogido</mensaje>\n";
				}
			}
			$resultado = $usuario;
		} catch ( Exception $error ) {
			print "<error tipo=\"sql\">".$error->getMessage()."</error>\n";
		}
		return $resultado;
	}
	static function recogeUsuarios ( $campo , $valor = false, $comparacion = "=" ) {
		$resultado = false;
		try {
			if( ! $usuarios = parent :: recogeObjectos( $campo , $valor, __CLASS__, $comparacion ) ) {
				print  "<error tipo=\"logico\">".__CLASS__."s no encontrados</error>\n";
			} else {
				while ( $fila = $usuarios->fetch ( PDO::FETCH_ASSOC ) ) {
					$usuario[ $fila["id"] ] = new self( $fila["correo"], $fila["password"], $fila["nombre"], $fila["apellidos"], $fila["dni"], $fila["codigo_postal"], $fila["direccion"], $fila["telefono_fijo"], $fila["telefono_movil"], $fila["boletin"], $fila["fidelidades_id"], $fila["administrador"], $fila["id"] );
					if( $usuario[$fila["id"]]->correo == "" ) {
						$usuario[$fila["id"]]->respuestaxml .= "<error tipo=\"logico\">".__CLASS__." $fila[id] no recogido</error>\n";
					} else {
						$usuario[$fila["id"]]->sincronizado = true;
						$usuario[$fila["id"]]->respuestaxml .= "<mensaje>".__CLASS__." $fila[id] recogido</mensaje>\n";
					}
				}
				$resultado = $usuario;
				/*print  "<mensaje>".__CLASS__."s recogidos</mensaje>\n";*/
			}
			
		} catch ( Exception $error ) {
			print "<error tipo=\"sql\">".$error->getMessage()."</error>\n";
		}
		return $resultado;
	}
	function sincronizar( $busqueda = false) {
		try {
			if( ! $busqueda ) {
				if($this->correo) {
					$this->campos["correo"] = $this->correo;
				}
				if($this->password) {
					$this->campos["password"] = $this->password;
				}
				if($this->nombre) {
					$this->campos["nombre"] = $this->nombre;
				}
				if($this->apellidos) {
					$this->campos["apellidos"] = $this->apellidos;
				}
				if($this->dni) {
					$this->campos["dni"] = $this->dni;
				}
				if($this->codigo_postal) {
					$this->campos["codigo_postal"] = $this->codigo_postal;
				}
				if($this->direccion) {
					$this->campos["direccion"] = $this->direccion;
				}
				if($this->telefono_fijo) {
					$this->campos["telefono_fijo"] = $this->telefono_fijo;
				}
				if($this->telefono_movil) {
					$this->campos["telefono_movil"] = $this->telefono_movil;
				}
				if($this->administrador) {
					$this->campos["administrador"] = $this->administrador;
				}
				if($this->boletin) {
					$this->campos["boletin"] = $this->boletin;
				}
				if($this->fidelidades_id) {
					$this->campos["fidelidades_id"] = $this->fidelidades_id;
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
	function iniciarSesion ($password) {
		$resultado = false;
		session_start();
		if( ! $this->verificarPassword( $password, $this->password ) ) {
			print ":".$password.":";
			$this->respuestaxml .= "<mensaje>Sesion no iniciada</mensaje>\n";
		} else {
			$resultado = true;
			$this->respuestaxml .= "<mensaje>Sesion iniciada</mensaje>\n";
		}
		return $resultado;
	}
	function cerrarSesion() {
		session_destroy();
		$this->respuestaxml = "<mensaje>Sesion cerrada</mensaje>\n";
	}
	private function validar( $propiedad, $valor ) {
		switch ( $propiedad ) {
			case "correo":
				if ( ! preg_match( CORREO, $valor ) ) {
					$this->respuestaxml .= "<error campo=\"$propiedad\" tipo=\"validacion\">fallo de validacion de $propiedad</error>\n";
					$this->valido = false;
				}
				break;
			case "password":
				if ( ! preg_match( PASSWORD, $valor ) ) {
					$this->respuestaxml .= "<error campo=\"$propiedad\" tipo=\"validacion\">fallo de validacion de $propiedad</error>\n";
					$this->valido = false;
				}
				break;
			case "nombre":
				if ( ! preg_match( NOMBRE, $valor ) ) {
					$this->respuestaxml .= "<error campo=\"$propiedad\" tipo=\"validacion\">fallo de validacion de $propiedad</error>\n";
					$this->valido = false;
				}
				break;
			case "apellidos":
				if ( ! preg_match( APELLIDOS, $valor ) ) {
					$this->respuestaxml .= "<error campo=\"$propiedad\" tipo=\"validacion\">fallo de validacion de $propiedad</error>\n";
					$this->valido = false;
				}
				break;
			case "dni":
				if ( ! preg_match( DNI, $valor ) ) {
					$this->respuestaxml .= "<error campo=\"$propiedad\" tipo=\"validacion\">fallo de validacion de $propiedad</error>\n";
					$this->valido = false;
				}
				break;
			case "codigo_postal":
				if ( ! preg_match( CODIGO_POSTAL, $valor ) ) {
					$this->respuestaxml .= "<error campo=\"$propiedad\" tipo=\"validacion\">fallo de validacion de $propiedad</error>\n";
					$this->valido = false;
				}
				break;
			case "direccion":
				if ( ! preg_match( DIRECCION, $valor ) ) {
					$this->respuestaxml .= "<error campo=\"$propiedad\" tipo=\"validacion\">fallo de validacion de $propiedad</error>\n";
					$this->valido = false;
				}
				break;
			case "telefono_fijo":
				if ( ! preg_match( TELEFONO, $valor ) ) {
					$this->respuestaxml .= "<error campo=\"$propiedad\" tipo=\"validacion\">fallo de validacion de $propiedad</error>\n";
					$this->valido = false;
				}
				break;
			case "telefono_movil":
				if ( ! preg_match( TELEFONO, $valor ) ) {
					$this->respuestaxml .= "<error campo=\"$propiedad\" tipo=\"validacion\">fallo de validacion de $propiedad</error>\n";
					$this->valido = false;
				}
				break;
			case "fidelidades_id":
				if ( ! preg_match( ID, $valor ) ) {
					$this->respuestaxml .= "<error campo=\"$propiedad\" tipo=\"validacion\">fallo de validacion de $propiedad</error>\n";
					$this->valido = false;
				}
				break;
			case "boletin":
				if ( ! ( preg_match( BOOLEANOCADENA, $valor ) ||  preg_match( BOOLEANO, $valor )  ) ) {
					$this->respuestaxml .= "<error campo=\"$propiedad\" tipo=\"validacion\">fallo de validacion de $propiedad</error>\n";
					$this->valido = false;
				}
				break;
			case "administrador":
				if ( ! preg_match( BOOLEANO, $valor ) ) {
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
			if( $propiedad == "password" ) {
				$hash = $this->getHash($valor);
				while ( $hash == "*0") {
					$hash = $this->getHash($valor);
				}
				$valor = $hash;
			}
			if( $propiedad == "boletin" ) {
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
	function __get($propiedad) {
		return $this->$propiedad;
	}
}
?>
