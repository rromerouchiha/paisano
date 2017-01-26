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
        //print_r($_SESSION);
        if($u -> verPermisoUsu($idusu,'SQPA',2)){
            $qyp = new Solicitud(SERVIDOR,USUARIO,CLAVE,BASE,PUERTO);
            $solicitudes = $qyp->datosBandeja($_SESSION['rol_usuario_id'],1,$_SESSION['edo_rep']); 
            $solicitudesOic = $qyp->datosBandeja($_SESSION['rol_usuario_id'],2,$_SESSION['edo_rep']);
            $cabecera = $qyp->daCabecera($_SESSION['rol_usuario_id']);
            $totalN = count($solicitudes);
            $totalOic = count($solicitudesOic);
            $beliminar = ($qyp->obtenerRol($_SESSION['rol_usuario_id']) == 1 || $qyp->obtenerRol($_SESSION['rol_usuario_id']) == 5)? 1 : 0;
            echo '<ol class="breadcrumb">
                    <li><a href="index.php"><script class="glyphicon glyphicon-home"></script></a></li>
                    <li><a href="index.php?m='.md5('quejaypeticion').'">Quejas y peticiones de ayuda</a></li>
                    <li>Seguimiento a quejas y peticiones de ayuda</li>
            </ol>';
            echo '<div class="page-header"><h1>Seguimiento a quejas y peticiones de ayuda</h1></div>
            <div id="contSegSol" class="container">
                <div class="row">
                    <div class="col-md-2"></div>
                    <div class="col-md-10">
                        <form class="form-inline col-md-10" role="form" id="busquedaSolBtn">
                            <div class="form-group">
                                <label class=" control-label" for="busquedaSol"> Buscar </label>
                                <input type="text" class="inputBusqueda" id="busquedaSol" name="busquedaSol">
                                <input type="hidden" class="" id="tipo" name="tipo" value="1">
                                <input type="hidden" class="" id="rol" name="rol"  value="'.$qyp->obtenerRol($_SESSION['rol_usuario_id']).'">
                            </div>
                        </form>
                        <div class="col-md-2 text-right"><button type="button" class="btn btn-link" id="actualiza">Actualizar <span class="glyphicon glyphicon-refresh"></span></button></div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-2" id="mBandeja">
                            '.$qyp->mostrarBandeja($totalN,$totalOic).'
                    </div>
                    <div class="col-md-10" id="pintaTabla">';
                        if($totalN > 0){
                            $tab = new Tabulador($solicitudes,$cabecera,1,50,array(1,1,0,$beliminar,0),1);
                            echo '<div style="width:100%;">';
                            $tab->muestraTabla();
                            //echo '</div>';
                            $qyp->botonesSolSeg($_SESSION['rol_usuario_id'],1);
                        }else{
                            echo "<div class='alert alert-warning text-center'><i>Sin resultados</i></div>";
                        }
                            echo '
                    </div>
                    <div class="col-md-2"></div>
                    <div class="col-md-10" id="carga" style="display:none;"><center><img src="includes/img/loading.gif" style="width:100px;"/></center></div>
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
                </div>';
            echo '
            </div>
            <script type="text/javascript" src="includes/js/solicitudes.js"></script>
            <script>inicioSeg();botonesBandeja();paginadorEv();</script>';
            
        }else{
            echo "<div class='alert alert-warning'>Lo sentimos, <strong> usted no cuenta con permiso </strong> para este módulo</div>";
        }
        
    echo '</div>';
echo footer();

?>
   

