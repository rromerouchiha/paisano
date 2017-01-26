<?php
error_reporting(E_ALL);
header('content-type: text/html; charset:utf-8');
ini_set('display_errors','1');
include_once('herramientas/configuracion/configuracion.inc.php');
$css = array('prism.css','bootstrap.min.css','estilos.css');
$js  = array('jquery-1.11.0.min.js','funcionesGlobales.js','bootstrap.min.js','jqueryvalidation.js','jquery-validate-adicional.js');
echo cabeceraHTML($css,$js,'Paisano');
    echo '<div class="container caption contenido">';	
        //print_r($_SESSION);echo md5(date('z').'PAI');
        if(!empty($_SESSION['rol_usuario_id'])){
           echo '<div class="page-header"><h1>Paisano</h1></div>';
			menuP();
            		
			if($_SESSION['rol_usuario_id'] == md5(2)||$_SESSION['rol_usuario_id'] == md5(3)||$_SESSION['rol_usuario_id'] == md5(1)){
			   ?>
				  <script>$( document ).ready(function() {
					 $("img[title='Módulo Administrador']").attr("href","#");
					 $("img[title='Módulo Administrador']").addClass('imgMenuDes').removeClass("imgMenu");
					 $("img[title='Módulo Administrador']").attr("href","#");
				  });</script>
			   <?php
			}
		}else{
			
            echo '<div class="page-header"><h1>Inicio de sesi&oacute;n</h1></div>
                    <form role="form" class="form-horizontal" method="POST" id="formLogueo" >
                        <div class="form-group">
                          <div class="col-md-12" id="men"></div>
                        </div> 
                        <div class="form-group">
                          <label for="usuario" class="col-md-4 control-label" >Usuario*</label>            
                          <div class="col-md-4">
                            <input class="form-control valid-field requerido" id="usuario" name="usuario" type="text" />
                          </div>
                        </div> 
                        <div class="form-group">
                          <label for="clave" class="col-md-4 control-label" >Contrase&ntilde;a*</label>      
                          <div class="col-md-4">
                            <input class="form-control valid-field requerido" id="clave" name="clave" type="password" />
                          </div>
                        </div>
                        <div class="form-group">
                          <div class="col-md-8 text-right">
                            <input type="submit" value="Ingresar" class="btn btn-primary"  id="btnAcc" />
                          </div>
                        </div>
                    </form>
                    <script type="text/javascript" src="includes/js/acceso.js"></script>
            ';
			
		}
    echo '</div>';

echo footer();

			