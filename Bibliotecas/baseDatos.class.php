<?php
class baseDatos {
	private $host;
	private $usuario;
	private $contrasenya;
	private $conexion;
	private $tabla;
	function __construct($baseDatos , $tabla = false , $host = "localhost", $usuario = "root", $contrasenya = "") {
		$this->baseDatos = $baseDatos;
		$this->host = $host;
		$this->usuario = $usuario;
		$this->contrasenya = $contrasenya;
		try {
			$this->conexion = new PDO ( "mysql:host=$this->host;dbname=$this->baseDatos", $this->usuario, $this->contrasenya );
			$this->conexion->setAttribute ( PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, true );
			if( $tabla ) {
				$this->tabla = $tabla;
			}
		} catch ( PDOException $error ) {
			throw new Exception ( "Ha sido imposible realizar la conexion a la base de datos" );
		}
	}
	function __destruct()
	{
		$this->conexion = null;
	}
	function cambiarTabla ($tabla)
	{
		$this->tabla = $tabla;
		try {
			$this->conexion = new PDO ( "mysql:host=$this->host;dbname=$this->baseDatos", $this->usuario, $this->contrasenya );
			$this->conexion->setAttribute ( PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, true );
		} catch ( PDOException $error ) {
			throw new Exception ( "<p class=\"mensajeError\">Ha sido imposible realizar la conexion a la base de datos</p>" );
		}
	}
	function insertarRegistro($campo)
	{
		$resultado = true;
		$numeroCampos = count ( $campo );
		try {
			$consulta = "INSERT INTO $this->tabla (";
			$campos = 0;
			foreach ( $campo as $nombre => $valor ) {
				$campos ++;
				if ($campos < $numeroCampos) {
					$consulta .= "$nombre, ";
				} else {
					$consulta .= "$nombre) ";
				}
			}
			$consulta .= "VALUES (";
			$campos = 0;
			foreach ( $campo as $nombre => $valor ) {
				$campos ++;
				if ($campos < $numeroCampos) {
					$consulta .= ":$nombre, ";
				} else {
					$consulta .= ":$nombre)";
				}
			}
			$conexion = $this->conexion;
			$resultado = $conexion->prepare ( $consulta );
			foreach ( $campo as $nombre => &$valor ) {
				$resultado->bindParam ( ":" . $nombre, $valor );
			}
			if( ! $resultado->execute () ) {
				$resultado = $resultado->errorInfo();
				throw new Exception( 
					"\nCódigo de error SQLSTATE: ".$resultado[0]."\n".
					"Código de error específico del driver: ".$resultado[1]."\n".
					"Mensaje del error específico del driver: ".$resultado[2]."\n"
				);
			}
		} catch ( PDOException $error ) {
			$resultado = false;
		}
		return $resultado;
	}
	function borrarRegistro( $campo , $inverso = false )
	{
		$numeroCampos = count ( $campo );
		$resultado = true;
		try {
			$consulta = "DELETE FROM $this->tabla WHERE ";
			$campos = 0;
			if ($inverso) {
				foreach ( $campo as $nombre => $valor ) {
					$campos ++;
					if ($campos < $numeroCampos) {
						$consulta .= "$nombre!=:$nombre AND ";
					} else {
						$consulta .= "$nombre!=:$nombre";
					}
				}
			} else {
				foreach ( $campo as $nombre => $valor ) {
					$campos ++;
					if ($campos < $numeroCampos) {
						$consulta .= "$nombre=:$nombre AND ";
					} else {
						$consulta .= "$nombre=:$nombre";
					}
				}
			}
			$conexion = $this->conexion;
			$resultado = $conexion->prepare ( $consulta );
			foreach ( $campo as $nombre => &$valor ) {
				$resultado->bindParam ( ":" . $nombre, $valor );
			}
			if( ! $resultado->execute () ) {
				$resultado = $resultado->errorInfo();
				throw new Exception( 
					"\nCódigo de error SQLSTATE: ".$resultado[0]."\n".
					"Código de error específico del driver: ".$resultado[1]."\n".
					"Mensaje del error específico del driver: ".$resultado[2]."\n"
				);
			}
			$resultado = $resultado->rowCount();
		} catch ( PDOException $error ) {
			$resultado = false;
		}
		return $resultado;
	}
	function modificarRegistro ( $campo , $condicionNombre , $condicionValor )
	{
		try{
			$numeroCampos = count ( $campo );
			$campos = 0;
			$consulta = "UPDATE $this->tabla SET ";
			foreach ( $campo as $nombre => $valor ) {
				$campos ++;
				if ($campos < $numeroCampos) {
					$consulta .= "$nombre=:$nombre, ";
				} else {
					$consulta .= "$nombre=:$nombre ";
				}
			}
			$consulta .= "WHERE $condicionNombre=:$condicionNombre";
			$conexion = $this->conexion;
			$resultado = $conexion->prepare ( $consulta );
			foreach ( $campo as $nombre => &$valor ) {
				$resultado->bindParam ( ":" . $nombre, $valor );
			}
			$resultado->bindParam ( ":" . $condicionNombre, $condicionValor );
			if( ! $resultado->execute () ) {
				$resultado = $resultado->errorInfo();
				throw new Exception( 
					"\nCódigo de error SQLSTATE: ".$resultado[0]."\n".
					"Código de error específico del driver: ".$resultado[1]."\n".
					"Mensaje del error específico del driver: ".$resultado[2]."\n"
				);
			}
		} catch ( PDOException $error ) {
			$resultado = false;
		}
		return $resultado;
	}
	function numeroRegistros()
	{
		try {
			$consulta = "Select count(*) from $this->nombre";
			$conexion = $this->conexion;
			$resultado = $conexion->query ( $consulta );
		} catch ( PDOException $error ) {
			$resultado = false;
		} catch ( Exception $error ) {
			$resultado = false;
		}
		return $resultado;
	}
	function listar ( $orden = false )
	{
		try {
			$consulta = "Select * from $this->tabla";
			if (isset ( $orden ["orden"] )) {
				$consulta .= " ORDER BY " . $orden ["orden"] ["campo"] . " " . $orden ["orden"] ["orden"];
			}
			if (isset ( $orden ["listado"] )) {
				$consulta .= " LIMIT " . $orden ["listado"] ["desde"] . "," . $orden ["listado"] ["registros"];
			}
			$conexion = $this->conexion;
			$resultado = $conexion->query ( $consulta );
		} catch ( PDOException $error ) {
			$resultado = false;
		} catch ( Exception $error ) {
			$resultado = false;
		}
		return $resultado;
	}
	function numeroBuscarRegistros($campo)
	{
		try {
			$numeroCampos = count ( $campo );
			$consulta = "Select count(*) from $this->tabla WHERE ";
			$campos = 0;
			foreach ( $campo as $nombre => $valor ) {
				$campos ++;
				if ($campos < $numeroCampos) {
					$consulta .= "$nombre LIKE :$nombre AND ";
				} else {
					$consulta .= "$nombre LIKE :$nombre";
				}
			}
			$conexion = $this->conexion;
			$resultado = $conexion->prepare ( $consulta );
			foreach ( $campo as $nombre => &$valor ) {
				$resultado->bindParam ( ":" . $nombre, $valor );
			}
			if( ! $resultado->execute () ) {
				$resultado = $resultado->errorInfo();
				throw new Exception( 
					"\nCódigo de error SQLSTATE: ".$resultado[0]."\n".
					"Código de error específico del driver: ".$resultado[1]."\n".
					"Mensaje del error específico del driver: ".$resultado[2]."\n"
				);
			}
			$resultado = $resultado->fetchColumn ();
		} catch ( PDOException $error ) {
			$resultado = false;
		}
		return $resultado;
	}
	function buscarRegistros( $campo, $opcion = false ,$comparacion = "LIKE" )
	{
		try {
			$numeroCampos = count ( $campo );
			$consulta = "Select * from $this->tabla WHERE ";
			$campos = 0;
			foreach ( $campo as $nombre => $valor ) {
				$campos ++;
				if ($campos < $numeroCampos) {
					$consulta .= "$nombre $comparacion :$nombre AND ";
				} else {
					$consulta .= "$nombre $comparacion :$nombre";
				}
			}
			if (isset ( $opcion ["orden"] )) {
				$consulta .= " ORDER BY " . $opcion ["orden"] ["campo"] . " " . $opcion ["orden"] ["orden"];
			}
			if (isset ( $opcion ["listado"] )) {
				$consulta .= " LIMIT " . $opcion ["listado"] ["desde"] . "," . $opcion ["listado"] ["registros"];
			}
			$conexion = $this->conexion;
			$resultado = $conexion->prepare ( $consulta );
			foreach ( $campo as $nombre => &$valor ) {
				$resultado->bindParam ( ":" . $nombre, $valor );
			}
			if( ! $resultado->execute() ) {
				$resultado = $resultado->errorInfo();
				throw new Exception( 
					"\nCódigo de error SQLSTATE: ".$resultado[0]."\n".
					"Código de error específico del driver: ".$resultado[1]."\n".
					"Mensaje del error específico del driver: ".$resultado[2]."\n"
				);
			}
		} catch ( PDOException $error ) {
			$resultado = false;
		}
		return $resultado;
	}
	function ejecutarSQL ( $consulta , $parametros)
	{
		try {
			$resultado = $this->conexion;
			if($parametros) {
				$resultado = $resultado->prepare ( $consulta );
				foreach ( $parametros as $parametro => &$valor ) {
					$resultado->bindParam ( ":" . $parametro, $valor );
				}
				if( ! $resultado->execute() ) {
					$resultado = $resultado->errorInfo();
					throw new Exception( 
						"\nCódigo de error SQLSTATE: ".$resultado[0]."\n".
						"Código de error específico del driver: ".$resultado[1]."\n".
						"Mensaje del error específico del driver: ".$resultado[2]."\n"
					);
				}
			} else {
				$resultado->query( $consulta );
			}
			
		} catch ( PDOException $error ) {
			$resultado = false;
		}
		return $resultado;
	}
}
?>