<?php
trait encriptacion
{
	function getHash( $password )
	{
		$salt = substr ( base64_encode ( openssl_random_pseudo_bytes ( '30' ) ), 0, 22 );
		$hash = crypt ( $password, '$2y$10$' . $salt );
		return $hash;
	}
	function verificarPassword( $password, $hash )
	{
		return crypt ( $password, $hash ) == $hash;
	}
	function verificarPasswordBaseDatos( $correo, $password,$conexion = false)
	{
		$resultado = false;
		if( ! $conexion ) {
			$conexion = $this->conexion;
		}
		$usuario["correo"] = $correo;
		$usuario["password"] = $password;
		$campo = $this->conexion->buscarRegistros($usuario);
		if( $campo )
		{
			$resultado = $this->verificarPassword( $usuario["password"], $campo["password"] );
		}
		return $resultado;
	}
}
?>