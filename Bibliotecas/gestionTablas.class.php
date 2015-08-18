<?php
require_once "conexion.global.php";
class gestionTablas
{
	public $conexion;
	public $respuestaxml;
	protected $valido;
	protected $sincronizado;
	protected $campos;
	protected $id;
	protected function existe( $campo, $campo2 = false, $conexion = false) { 
		$resultado = false;
		try {
			if( ! $conexion ) {
				$conexion = $this->conexion;
			}
			if( ! is_array( $campo ) )
			{
				$busqueda[$campo] = $this->campos[$campo];
			} else {
				$busqueda = $campo;
			}
			$resultado = $conexion->numeroBuscarRegistros($busqueda);
		} catch ( Exception $error ) {
			$this->respuestaxml .= "<error tipo=\"sql\">".$error->getMessage()."</error>\n";
		}
		return $resultado;
	}
	protected function sincronizar( $campos, $clase ) {
		$resultado = false;
		$conexion = $this->conexion;
		try {
			if( ! $objecto = $conexion->buscarRegistros($campos) ) {
				$this->respuestaxml .= "<error tipo=\"logico\">$clase no sincronizado/a</error>\n";
			} else {
				$objecto->execute();
				if ( $campo = $objecto->fetch(PDO::FETCH_ASSOC) ) {
					foreach ($campo as $propiedad => $valor) {
						$this->$propiedad = $valor;
					}
					$this->sincronizado = true;
					$resultado = $this->sincronizado;
				}
				$this->respuestaxml .= "<mensaje>$clase sincronizado/a</mensaje>\n";
			}
		} catch ( Exception $error ) {
			$this->respuestaxml .= "<error tipo=\"sql\">".$error->getMessage()."</error>\n";
		}
		return $resultado;
	}
	protected function insercion( $campo, $clase ) {
		$resultado = false;
		$conexion = $this->conexion;
		try {
			if( ! $conexion->insertarRegistro( $campo ) ) {
				$this->respuestaxml .= "<error tipo=\"logico\">$clase no insertado</error>\n";
			} else {
				$this->respuestaxml .= "<mensaje>$clase insertado/a</mensaje>\n";
				$this->sincronizar( $campo );
				$resultado = true;
			}
		} catch ( Exception $error ) {
			$this->respuestaxml .= "<error tipo=\"sql\">".$error->getMessage()."</error>\n";
		}
		return $resultado;
	}
	protected function modificacion( $propiedad, $valor, $clase ) {
		$resultado = false;
		$conexion = $this->conexion;
		$objecto[$propiedad] = $valor;
		try {
			if( $propiedad != "id") {
				if( ! $conexion->modificarRegistro( $objecto , "id" , $this->id ) ) {
					$this->respuestaxml .= "<error tipo=\"logico\">$clase no modificado/a</error>\n";
				} else {
					$this->respuestaxml .= "<mensaje>$clase modificado/a</mensaje>\n";
					$this->$propiedad = $valor;
					$resultado = true;
				}
			} else {
				$this->sincronizar( $objecto );
			}
		} catch ( Exception $error ) {
			$this->respuestaxml .= "<error tipo=\"sql\">".$error->getMessage()."</error>\n";
		}
		return $resultado;
	}
	protected function borrado( $clase , $campo = false ){
		$resultado = false;
		$conexion = $this->conexion;
		if( !$campo ) {
			$campo["id"] = $this->id;
		}
		try {
			if( ! $conexion->borrarRegistro( $campo ) ) {
				$this->respuestaxml .= "<error tipo=\"logico\">$clase no borrado/a</error>\n";
			} else {
				$this->respuestaxml .= "<mensaje>$clase borrado/a</mensaje>\n";
				$resultado = true;
			}
		} catch ( Exception $error ) {
			$this->respuestaxml .= "<error tipo=\"sql\">".$error->getMessage()."</error>\n";
		}
		return $resultado;
	}
	protected function recoge( $campo , $valor, $clase ) {
		$resultado = false;
		try {
			$conexion = new baseDatos( BASEDATOS, $clase, HOST, USUARIO, BASEDATOS_PASSWORD );
			if( ! is_array( $campo ) ) {
				$busqueda[$campo] = $valor;
			} else {
				$busqueda = $campo;
			}
			if( ! $resultado = $conexion->buscarRegistros( $busqueda ) ) {
				$resultado = false;
			} else {
				$resultado = $resultado->fetch( PDO::FETCH_ASSOC );
			}
		} catch ( Exception $error ) {
			print "<error tipo=\"sql\">".$error->getMessage()."</error>\n";
		}
		return $resultado;
	}
	protected function recogeObjectos( $campo , $valor = false, $clase, $comparacion = "=" ) {
		$resultado = false;
		try {
			$conexion = new baseDatos( BASEDATOS, $clase, HOST, USUARIO, BASEDATOS_PASSWORD );
			if( ! is_array( $campo ) ) {
				$busqueda[$campo] = $valor;
			} else {
				$busqueda = $campo;
			}
			$objectos = $conexion->buscarRegistros( $busqueda, false, $comparacion );
			$resultado = $objectos;
		} catch ( Exception $error ) {
			print "<error tipo=\"sql\">".$error->getMessage()."</error>\n";
		}
		return $resultado;
	}
	protected function recogeTodos( $clase, $orden ) {
		$resultado = false;
		try {
			$conexion = new baseDatos( BASEDATOS, $clase, HOST, USUARIO, BASEDATOS_PASSWORD );
			$objectos = $conexion->listar( $orden );
			$resultado = $objectos;
		} catch ( Exception $error ) {
			$this->respuestaxml .= "<error tipo=\"sql\">".$error->getMessage()."</error>\n";
		}
		return $resultado;
	}
}
?>