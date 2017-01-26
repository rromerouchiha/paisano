<?php
header('content-type: text/html; charset:utf-8');
ini_set('display_errors','1');
include_once('herramientas/configuracion/configuracion.inc.php');
include_once("herramientas/clases/Conexion.php");
include_once("herramientas/clases/Usuario.php");
include_once("herramientas/clases/Atencion.php");
include_once("herramientas/configuracion/seguridad.php");
$css = array('prism.css','bootstrap.min.css','estilos.css','fileinput.min.css','bootstrap-datetimepicker.min.css','bootstrap-multiselect.css');
$js  = array('jquery-1.11.0.min.js','funcionesGlobales.js','bootstrap.min.js','jqueryvalidation.js','jquery-validate-adicional.js','fileinput.min.js','fileinput_locale_es.js','moment/moment.js','bootstrap-datetimepicker.min.js','moment/locale/es.js','bootstrap-multiselect.js','jquery.numeric.min.js');

$u = new Usuario(SERVIDOR,USUARIO,CLAVE,BASE,PUERTO);
$idusu = (!empty($_SESSION['id']))? $_SESSION['id']: 0 ;
echo cabeceraHTML($css,$js,'Paisano');
    echo '
    
    <div class="container caption contenido" id="contP">
        <!-- Modal -->
        <div class="modal fade" id="ModalGral" role="dialog">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header" id="modal-header"></div>
                    <div class="modal-body" id="modal-body"></div>
                    <div class="modal-footer" id="modal-footer"></div>
                </div>
            </div>
        </div>';
        if($u -> verPermisoUsu($idusu,'AEU',2)){
            $ar = new  Atencion(SERVIDOR,USUARIO,CLAVE,BASE,PUERTO);
            echo '<ol class="breadcrumb">
                    <li><a href="index.php"><script class="glyphicon glyphicon-home"></script></a></li>
                    <li><a href="index.php?m='.md5('atenciones').'">Atenciones</a></li>
                    <li>Registrar atenci&oacute;n</li>
            </ol>
            <div class="page-header"><h1>Registrar atenci&oacute;n</h1></div>
            <div id="contSol">';
            $ar->formAtencionRepresentante();
            echo '</div>
            <script type="text/javascript" src="includes/js/atencion.js"></script>
            <script>formCargaAtencionRep();</script>';
            
        }else{
            echo "<div class='alert alert-warning'>Lo sentimos, <strong> usted no cuenta con permiso </strong> para este m&oacute;dulo</div>";
        }
        
    echo '</div>';
echo footer();

?>
   

