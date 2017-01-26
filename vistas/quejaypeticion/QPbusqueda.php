<?php
header('content-type: text/html; charset:utf-8');
ini_set('display_errors','1');
include_once('herramientas/configuracion/configuracion.inc.php');
include_once("herramientas/clases/Conexion.php");
include_once("herramientas/clases/Usuario.php");
include_once("herramientas/clases/Solicitud.php");
include_once("herramientas/clases/Tabulador.php");
include_once("herramientas/configuracion/seguridad.php");
$css = array('prism.css','bootstrap.min.css','estilos.css','fileinput.min.css','bootstrap-datetimepicker.min.css','bootstrap-multiselect.css');
$js  = array('jquery-1.11.0.min.js','funcionesGlobales.js','bootstrap.min.js','jqueryvalidation.js','jquery-validate-adicional.js','fileinput.min.js','fileinput_locale_es.js','moment/moment.js','bootstrap-datetimepicker.min.js','moment/locale/es.js','bootstrap-multiselect.js','jquery.numeric.min.js');

$u = new Usuario(SERVIDOR,USUARIO,CLAVE,BASE,PUERTO);
$idusu = (!empty($_SESSION['id']))? $_SESSION['id']: 0 ;
echo cabeceraHTML($css,$js,'Paisano');
    echo '
    <div class="container caption contenido" id="contP">';
    
        if($u -> verPermisoUsu($idusu,'BUSQP',2)){
            
            echo '<ol class="breadcrumb">
                    <li><a href="index.php"><script class="glyphicon glyphicon-home"></script></a></li>
                    <li><a href="index.php?m='.md5('quejaypeticion').'">Quejas y peticiones de ayuda</a></li>
                    <li>B&uacute;squeda de quejas y peticiones de Ayuda</li>
            </ol>';
            echo '<div class="page-header" id="titBus"><h1>B&uacute;squeda de quejas y peticiones de ayuda</h1></div>';
            $qyp = new Solicitud(SERVIDOR,USUARIO,CLAVE,BASE,PUERTO);
            echo $qyp->formBusqueda($_SESSION['rol_usuario_id']);
            echo '
            <script type="text/javascript" src="includes/js/solicitudes.js"></script>
            <script>busInicio();</script>';
        }else{
            echo "<div class='alert alert-warning'>Lo sentimos, <strong> usted no cuenta con permiso </strong> para este módulo</div>";
        }
        
    echo '</div>';
echo footer();
?>
   

