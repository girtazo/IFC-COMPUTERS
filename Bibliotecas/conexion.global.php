<?php
if( ( $_SERVER["HTTP_HOST"] == "www.ifc-shop.tk" ) || ( $_SERVER["HTTP_HOST"] == "ifc-shop.tk" ) ) {
	define("BASEDATOS", "u693390274_ifc");
	define("USUARIO", "u693390274_david");
	define("BASEDATOS_PASSWORD", "12345.");
	define("HOST", "mysql.hostinger.es");
} else {
	define("BASEDATOS", "ifc");
	define("USUARIO", "root");
	define("BASEDATOS_PASSWORD", "");
	define("HOST", "localhost");
}
?>