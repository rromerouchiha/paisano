<?php
ini_set('display_errors','1');
session_start();
include_once('../configuracion/configuracion.inc.php');
include_once('../clases/Conexion.php');
include_once('../clases/Solicitud.php');
$s = new  Solicitud(SERVIDOR,USUARIO,CLAVE,BASE,PUERTO);
$cveH = "12345";
$s->basuraHuerfanos($cveH);
session_destroy();
header('Location: ../../index.php');
?>