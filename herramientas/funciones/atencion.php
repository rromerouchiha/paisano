<?php
extract($_POST);
session_start();
include_once('../configuracion/configuracion.inc.php');
include_once("../clases/Conexion.php");
include_once("../clases/Atencion.php");
include_once("../clases/Tabulador.php");
include_once("../clases/Usuario.php");

if(empty($_SESSION['id'])){
        echo "<div class='alert alert-warning'>Lo sentimos, su sesi&oacute;n caduco, debe volver a <a href='index.php'>Ingresar</a></div>";
        exit();
}
print_r($_SESSION);exit();
if($opcion == 1){
    
}


?>