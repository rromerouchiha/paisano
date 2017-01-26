<?php
error_reporting(E_ALL);
ini_set('display_errors','1');
 //FUNCION QUE TE ARROJA UN FORMATO DE FECHA VISIBLE AL USUARIO RECIBE LA FECHA DE HOY 'AAAA-MM-DD'
function fechaFormato($fecha,$ban){
    ini_set('date.timezone', 'America/Mexico_City');
    $meses=array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
    $diaActual = substr($fecha,8,2); //extraemos el dia 
    $mesActual = substr($fecha,5,2); //extraemos el mes 
    $anioActual = substr($fecha,0,4); //extraemos el año
    if($ban == 0){
        $hora = '<span id="_hor">'.date('h').'</span><span id="_seg"> : </span><span class="_min"><span id="_min">'.date('i').'</span></span> <span id="_ampm">'.date('a').'</span>';
        return '<p class="normal"><span class="glyphicon glyphicon-calendar"></span>'.$diaActual."/".$mesActual."/".$anioActual . ", ".$hora.'</p>';
    }else{
        return $diaActual." de ".$meses[$mesActual-1]." del ".$anioActual;
    }
}
/*
function fechaFormato($ban,$gmt){
	#ini_set('date.timezone', 'America/Mexico_City');
	$timezone  = $gmt;  
	$fecha = gmdate("Y/m/j H:i:s", time() + 3600*($timezone+date("I")));
	#echo $fecha;
    $diaActual = substr($fecha,8,2); //extraemos el dia 
    $mesActual = substr($fecha,5,2); //extraemos el mes 
    $anioActual = substr($fecha,0,4); //extraemos el año
	$ho = substr($fecha,11,2); //extraemos el año
	$min = substr($fecha,14,2); //extraemos el año
	#$hora = $ho.':'.$min;
    if($ban == 0){
       $hora = '<span id="_hor">'.$ho.'</span><span id="_seg"> : </span><span class="_min"><span id="_min">'.$min.'</span>';
        return '<p class="normal"><span class="glyphicon glyphicon-calendar"></span>'.$diaActual."/".$mesActual."/".$anioActual . ", ".$hora.'</p>';
    }else{
        return $diaActual." de ".$meses[$mesActual-1]." del ".$anioActual;
    }
}
*/
function cabeceraHTML($css,$js,$titulo,$charset='utf-8')
{
	$tab   = chr(9);
    $salto = chr(13).chr(10);
	$CSS   = '';
    $JS    = '';
    $url   = _DIR;
	$cssF  = $salto.$tab.$tab.'<link rel="stylesheet" type="text/css" href="%s"/>';
	$jsF   = $salto.$tab.$tab.'<script type="text/javascript" src="%s"></script>';
	$oculto = (!empty($_SESSION['n_completo']))? '' : 'visible-md visible-lg';
	$html  = '<!DOCTYPE html>'.
		    $salto.'<html>'.
		    $salto.$tab.'<head>'.
		    $salto.$tab.$tab.'<meta charset="%s">'.
		    $salto.$tab.$tab.'<meta http-equiv="X-UA-Compatible" content="IE=Edge">'.
            $salto.$tab.$tab.'<meta name="viewport" content="width=device-width, initial-scale=1">'.
            $salto.$tab.$tab.' <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">'.
		    $salto.$tab.$tab.'<title>%s</title>%s'.
            $salto.$tab.$tab.'<!--[if lt IE 9]>'.
            $salto.$tab.$tab.$tab.'<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>'.
            $salto.$tab.$tab.$tab.'<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>'.
            $salto.$tab.$tab.'<![endif]-->'.
		    $salto.$tab.'</head>'.
		    $salto.$tab.'<body>'.
            $salto.$tab.$tab.'<nav class="navbar navbar-inverse nvar1 '.$oculto.'" role="navigation">'.
            $salto.$tab.$tab.$tab.'<div class="container">'.
            $salto.$tab.$tab.$tab.$tab.'<div class="navbar-header">'.
            $salto.$tab.$tab.$tab.$tab.$tab.'<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">'.
            $salto.$tab.$tab.$tab.$tab.$tab.$tab.'<span class="sr-only">Desplegar navegación</span>'.
            $salto.$tab.$tab.$tab.$tab.$tab.$tab.'<span class="sr-only">Desplegar navegación</span>'.
            $salto.$tab.$tab.$tab.$tab.$tab.$tab.'<span class="icon-bar"></span>'.
            $salto.$tab.$tab.$tab.$tab.$tab.$tab.'<span class="icon-bar"></span>'.
            $salto.$tab.$tab.$tab.$tab.$tab.$tab.'<span class="icon-bar"></span>'.
            $salto.$tab.$tab.$tab.$tab.$tab.'</button>'.
            $salto.$tab.$tab.$tab.$tab.$tab.'<a class="navbar-brand" href="#" class="thumbnail"><img src="includes/img/inm-brand.png" class="inm" /></a>'.
            $salto.$tab.$tab.$tab.$tab.'</div>'.
		    $salto.$tab.$tab.$tab.$tab.'<div class="collapse navbar-collapse navbar-ex1-collapse ">'.
		    $salto.$tab.$tab.$tab.$tab.$tab.'<ul class="nav navbar-nav navbar-left">'.
			$salto.$tab.$tab.$tab.$tab.$tab.$tab.'<li>Paisano</li>'.
			$salto.$tab.$tab.$tab.$tab.$tab.'</ul>'.
			$salto.$tab.$tab.$tab.$tab.$tab.'<ul class="nav navbar-nav navbar-right">'.
			$salto.$tab.$tab.$tab.$tab.$tab.$tab.'%s'.
			$salto.$tab.$tab.$tab.$tab.$tab.'</ul>'.
		    $salto.$tab.$tab.$tab.$tab.'</div>'.
			$salto.$tab.$tab.$tab.'</div>'.
			$salto.$tab.$tab.'</nav>'.
			$salto.$tab.$tab.'<div class="navbar navbar-default '.$oculto.'">'.
			$salto.$tab.$tab.$tab.'<div class="container">'.
			$salto.$tab.$tab.$tab.$tab.'<div class="navbar-header">'.
			$salto.$tab.$tab.$tab.$tab.$tab.'<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">'.
			$salto.$tab.$tab.$tab.$tab.$tab.$tab.'<span class="sr-only">Desplegar navegación</span>'.
			$salto.$tab.$tab.$tab.$tab.$tab.$tab.'<span class="icon-bar"></span>'.
			$salto.$tab.$tab.$tab.$tab.$tab.$tab.'<span class="icon-bar"></span>'.
			$salto.$tab.$tab.$tab.$tab.$tab.$tab.'<span class="icon-bar"></span>'.
			$salto.$tab.$tab.$tab.$tab.$tab.'</button>'.
			$salto.$tab.$tab.$tab.$tab.$tab.'<a class="navbar-brand" href="#">%s</a>'.
			$salto.$tab.$tab.$tab.$tab.$tab.'<ul class="nav navbar-nav navbar-left">'.
			$salto.$tab.$tab.$tab.$tab.$tab.$tab.'<li><a href="#">%s</a></li>'.
			$salto.$tab.$tab.$tab.$tab.$tab.'</ul>'.
			$salto.$tab.$tab.$tab.$tab.'</div>'.
			$salto.$tab.$tab.$tab.$tab.'<div class="collapse navbar-collapse navbar-ex1-collapse ">'.
			$salto.$tab.$tab.$tab.$tab.$tab.'<ul class="nav navbar-nav navbar-right">'.
			$salto.$tab.$tab.$tab.$tab.$tab.$tab.'<li><a href="#">%s</a></li>'.
			$salto.$tab.$tab.$tab.$tab.$tab.'</ul>'.
			$salto.$tab.$tab.$tab.$tab.'</div>'.
			$salto.$tab.$tab.$tab.'</div>'.
			$salto.$tab.$tab.'</div>'
		   ;
	if((is_array($css)) && (!empty($css)))
	{
		foreach($css as $valor)
		{
			$CSS .= sprintf($cssF,$url.'/includes/css/'.$valor);
		}
	}
    if((is_array($js)) && (!empty($js)))
	{
		foreach($js as $valor)
		{
			$JS .= sprintf($jsF,$url.'/includes/js/'.$valor);
		}
	}
    $usuario = (!empty($_SESSION['n_completo']))? '<span class="glyphicon glyphicon-user"></span> '.utf8_encode($_SESSION['n_completo'].' / ' . $_SESSION['rol']. ' / '.$_SESSION['nombre_estado']) : '';
	$usuarioL = (!empty($_SESSION['n_completo']))? 'Usuario': '';
	$fecha  = (!empty($_SESSION['n_completo']))? fechaFormato(date("Y-m-d"),0) : '';
	$salir = (!empty($_SESSION['n_completo']))? '<li><a href="herramientas/funciones/cerrarSesion.php">Salir&nbsp;<span class="glyphicon glyphicon-log-out"></span></a></li>': '<li><p class="navbar-text">Paisano&nbsp;<span class="glyphicon glyphicon-log-in"></span></p></li>';
	#$fecha  = fechaFormato(0,-7);
	return sprintf($html,$charset,$titulo,$CSS.$JS,$salir,$usuarioL,$usuario,$fecha);
}

function footer(){
	$tab   = chr(9);
    $salto = chr(13).chr(10);
	$foot =
	$salto.$tab.$tab.'<br/><div class="container"><ol class="breadcrumb"></ol></div>'.
	$salto.$tab.$tab.'<script>'.
	$salto.$tab.$tab.$tab.'$(".contenido").animate({'.
	$salto.$tab.$tab.$tab.$tab.'height: "show" '.
	$salto.$tab.$tab.$tab.'}, 1000);'.
	$salto.$tab.$tab.'</script>'.
	$salto.$tab.$tab.''.
	$salto.$tab.$tab.'<footer class="navbar navbar-inverse navbar-fixed-bottom" role="navigation">'.
    $salto.$tab.$tab.$tab.'<p class="navbar-text text-center" style="text-align:center !important;width:100%;">© 2016 Instituto Nacional de Migración</p>'.
    $salto.$tab.$tab.'</footer>'.
	$salto.$tab.'</body>'.
	$salto.'</html>';
	return $foot;
}

function menuP(){
		$permisos = verPermisosPrincipal();
		//print_r($permisos);echo "<br/><br/>";
		$principal = MenuPrincipal();
		//print_r($principal);
		
		$nm = count($principal);
		if($nm > 0 ){
			echo '<div class="row">';
			for($i = 0; $i < $nm; $i++){
				if($principal[$i]['activo'] == 1){
					$siTiene = 0;
					for($j=0; $j < count($permisos);$j++){
						if($principal[$i]['id'] == $permisos[$j]['id']){
							$siTiene = 1;
						}
					}
					if($siTiene > 0){
						menuIcono($principal[$i]['enlace'],$principal[$i]['texto'],$principal[$i]['accion']);
					}else{
						menuIconoDes($principal[$i]['texto']);
					}
					
				}else{
					menuIconoDes($principal[$i]['texto']);
				}
				
			}
			echo '</div>';
		}else{
			echo "<div class='alert alert-warning'>Lo sentimos, <strong> no hay informaci&oacute;n de operaciones </strong></div>";
		}
}



function verPermisosPrincipal(){
	include_once('herramientas/configuracion/configuracion.inc.php');
	include_once('herramientas/clases/Conexion.php');
	include_once('herramientas/clases/Usuario.php');
	$u = new Usuario(SERVIDOR,USUARIO,CLAVE,BASE,PUERTO);
	$permisos = $u->verPermisosPrincipal($_SESSION['id']);
	return $permisos;
}

function MenuPrincipal(){
	include_once('herramientas/configuracion/configuracion.inc.php');
	include_once('herramientas/clases/Conexion.php');
	$c = new ConexionMySQL(SERVIDOR,USUARIO,CLAVE,BASE,PUERTO);
	$sql = "select * from accion where nivel_menu_id = 1;";
	$menu = $c->query($sql,'arregloAsociado');
	return $menu;
}

function menuS($principal){
		$permisos = verPermisosSecundarios($principal);
		include_once('herramientas/configuracion/configuracion.inc.php');
		include_once('herramientas/clases/Conexion.php');
		$c = new ConexionMySQL(SERVIDOR,USUARIO,CLAVE,BASE,PUERTO);
		$sqlPerAct = "select activo from accion where id = %d;";
		$np = count($permisos);
		//print_r($permisos);
		if($np > 0 ){
			echo '<div class="row">';
			for($i = 0; $i < $np; $i++){
				$edo = $c->query(sprintf($sqlPerAct,$permisos[$i]['id']),'registro');
				if($edo['activo'] == 1){
					menuIcono($permisos[$i]['enlace'],$permisos[$i]['texto'],$permisos[$i]['accion'],$permisos[$i]['pagina']);
				}else{
					menuIconoDes($permisos[$i]['texto']);
				}
			}
			echo '</div>';
		}else{
			echo "<div class='alert alert-warning'>Lo sentimos, <strong> usted no cuenta con permisos asignados </strong> para este módulo</div>";
		}
		
}

function verPermisosSecundarios($principal){
	include_once('herramientas/configuracion/configuracion.inc.php');
	include_once('herramientas/clases/Conexion.php');
	include_once('herramientas/clases/Usuario.php');
	$u = new Usuario(SERVIDOR,USUARIO,CLAVE,BASE,PUERTO);
	$permisos = $u->verPermisosSecundarios($_SESSION['id'],$principal);
	return $permisos;
}

function menuIcono($m,$texto,$titulo,$p=null){
	$ref = "index.php?m=".md5($m);
	if (!empty($p)){
		$ref .= "&p=".md5($p);
	}
	echo "<div class='col-md-3 col-xs-6 menunav'>
            <a href='".$ref."'>
				<center><img src='includes/img/logos/registro.png' title='".utf8_encode($titulo)."' class='imgMenu'/>
				<br/><span class='smenu'>".utf8_encode($texto)."</span><center>
            </a>
        </div>";
}

function menuIconoDes($texto){
	echo "<div class='col-md-3 col-xs-6 menunav'>
            <a href='#'>
				<center><img src='includes/img/logos/registro.png' title='Inactivo' class='imgMenuDes'/>
				<br/><span class='smenu'>".utf8_encode($texto)."</span><center>
            </a>
        </div>";
}

function cadenaDes($c){
	$datos = array('administracion','usuarios','QPseguimiento','QPregistro','QPbusqueda','QPreseteo','busquedaAtEn','busquedaAtRep','registroAtEn','registroAtRep','atenciones', 'quejaypeticion','reportes','Rmensual','Rgeneral');
	for($i = 0; $i < count($datos); $i++){
		if($c == md5($datos[$i])){
			$ret = $datos[$i];
			break;
		}else{
			$ret = 'error';
		}
	}
	return $ret;
}


?>