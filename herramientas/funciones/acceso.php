<?php
session_start();
ini_set('display_errors','1');
include_once("../configuracion/configuracion.inc.php");
include_once("../clases/Conexion.php");
include_once("../clases/Autenticacion.php");
extract($_POST);
$autenticacion = new Autenticacion($usu,$con,SERVIDOR,USUARIO,CLAVE,BASE,PUERTO);
if($autenticacion->verAutenticacion()){
    $resultado = array('estado'=>1);
}else{
    $resultado = array('estado'=>0,'mensaje'=>'La informaci&oacute;n es incorrecta');
}

echo json_encode($resultado);

?>