<?php
session_start();
include_once('herramientas/funciones/funciones.php');
$modulo  = (!empty($_GET['m']))? cadenaDes($_GET['m']) : 'usuario';
$pagina  = (!empty($_GET['p']))? cadenaDes($_GET['p']) : 'inicio';
//$vista   = (!empty($_GET['v']))? $_GET['v'] : 'logueo';
$pagina  = $pagina.'.php';
$modulo .= '/';
$ruta    = 'vistas/'.$modulo.$pagina;
if(!file_exists($ruta))
{
    $vista   = 'error';
    $ruta    = 'vistas/inicio.php';
}
include_once $ruta;
?>