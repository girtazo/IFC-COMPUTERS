<?php
function __autoload($clase) {
    require_once  "../Bibliotecas/". $clase .".class.php";
}
?>