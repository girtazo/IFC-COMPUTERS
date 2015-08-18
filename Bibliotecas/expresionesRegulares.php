<?php
define("CORREO", "/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/i");
define("TELEFONO","/^[9|6|7][0-9]{8}$/");
define("NOMBRE","/^[A-Za-záéíóúñ]{2,}([\s][A-Za-záéíóúñ]{2,})*$/");
define("APELLIDOS","/^[A-Za-záéíóúñ]{2,}([\s][A-Za-záéíóúñ]{2,})+$/");
define("PASSWORD","/(?=^.{8,}$)((?=.*\d)|(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$/");
define("DNI","/^[0-9]{8}[A-Z]$/");
define("CODIGO_POSTAL","/^[0-9]{5}$/");
define("DIRECCION","/^[A-Za-záéíóúñ]{2,}([\s][A-Za-záéíóúñ]{2,})+([\s][A-Za-záéíóúñ0-9]+)+$/");
define("BOOLEANOCADENA","/^(false|true)$/");
define("ID","/^[1-9][0-9]*$/");
define("DENOMINACION","/([a-zñÑçÇáàéèíìóòúùÁÀÉÈÍÌÓÒÚÙ][0-9][\.][\-][_][[::space]][\@])+/");
define("ENTERO","/[0-9]+/");
define("DECIMAL","/^[0-9]+(\.[0-9][0-9]?)?$/");
define("BOOLEANO","/^[0-1]$/");
define("DATETIME", "/^[1-9][0-9]{3}\s[0-2][0-3]([\:][0-5][0-9]){2}$/");
define("IMAGEN", "/^[\sa-z0-9\_\-\.\,\:]$/i");
?>