<?php
header('content-type: text/html; charset:utf-8');
ini_set('display_errors','1');
include_once('herramientas/configuracion/configuracion.inc.php');
include_once("herramientas/clases/Conexion.php");
include_once("herramientas/clases/Usuario.php");
include_once("herramientas/configuracion/seguridad.php");
$css = array('prism.css','bootstrap.min.css','estilos.css','fileinput.min.css','bootstrap-datetimepicker.min.css');
$js  = array('jquery-1.11.0.min.js','funcionesGlobales.js','bootstrap.min.js','jqueryvalidation.js','jquery-validate-adicional.js','fileinput.min.js','fileinput_locale_es.js','moment/moment.js','bootstrap-datetimepicker.min.js','moment/locale/es.js');

$u = new Usuario(SERVIDOR,USUARIO,CLAVE,BASE,PUERTO);
$idusu = (!empty($_SESSION['id']))? $_SESSION['id']: 0 ;
echo cabeceraHTML($css,$js,'Paisano');
    echo '
    <div class="container caption contenido" id="contP">';
        if($u -> verPermisoUsu($idusu,'MU',2)){
            echo '<ol class="breadcrumb">
                    <li><a href="index.php"><script class="glyphicon glyphicon-home"></script></a></li>
                    <li><a href="index.php?m='.md5("administracion").'">Men&uacute; administraci&oacute;n</a></li>
                    <li>Usuarios</li>
            </ol>
            <form id="usuario_bus" name="usuario_bus" method="POST">
                <div class="row">
                  <div class="form-group col-md-4">
                    <label class="control-label" for="rol_bus">Rol de usuario:</label>
                    <select name="rol_bus" class="form-control"  id="rol_bus"></select> 
                  </div>
                  <div class="form-group col-md-4">
                    <label class="control-label" for="edo_bus">Estado/Condado:</label>
                    <select name="edo_bus" class="form-control"  id="edo_bus"></select>
                  </div>
                  <div class="form-group col-md-4">
                    <label class="control-label" for="nombre_bus">Nombre(s):</label>
                    <input name="nombre_bus"  maxlength="20" type="text" class="form-control"  id="nombre_bus" />
                  </div>
                </div>';
                $u->btnBuscarNuevo($idusu);
             echo '   
            </form>
            <div id="usuarioMen" style="width:100%;"></div>
            <div id="usuarioCo" style="width:100%;"></div>
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
            </div>
            ';
       
            echo '<script type="text/javascript" src="includes/js/usuarios.js"></script>
                    <script>busqueda();</script>';
        }else{
            echo "<div class='alert alert-warning'>Lo sentimos, <strong> usted no cuenta con permiso </strong> para este módulo</div>";
        }
        
    echo '</div>';
echo footer();
?>