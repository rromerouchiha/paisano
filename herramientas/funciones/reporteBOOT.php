<?php
extract($_POST);
session_start();
include_once('../configuracion/configuracion.inc.php');
include_once("../clases/Conexion.php");
include_once("../clases/Solicitud.php");
include_once("../clases/Queja.php");
include_once("../clases/Peticion.php");
include_once("../clases/Tabulador.php");
include_once("../clases/Usuario.php");
include_once('funciones.php');
$r=1;
if(!empty($_SESSION['id'])){
       if($r == 1){
            //include("../../includes/librerias/MPDF5/mpdf.php");

            $htmlCont = '
            <!DOCTYPE html>
              <html>
                     <head>
                            <title>Paisano</title>
                            <link rel="stylesheet" type="text/css" href="../../includes/css/prism.css"/>
                            <link rel="stylesheet" type="text/css" href="../../includes/css/bootstrap.min.css"/>
                            <link rel="stylesheet" type="text/css" href="../../includes/css/estilos.css"/>
                            <script type="text/javascript" src="../../includes/js/jquery-1.11.0.min.js"></script>
                            <script type="text/javascript" src="../../includes/js/bootstrap.min.js"></script>
                            <style>
                                   
                            </style>
                     </head>
                     <body>
                            <div class="container">
                                   <table style="width:100%;">
                                          <tr>
                                              <td><img src="../../includes/img/paisano.png" style="width:70px;"/></td>
                                              <th><center><p>DIRECCI&Oacute;N GENERAL</p><p> DE PROTECCI&Oacute;N AL MIGRANTE Y VINCULACI&Oacute;N</p><p> DIRECCI&Oacute;N NACIONAL DEL PROGRAMA PAISANO</p></th>
                                              <td style="text-align:right !important;"><img src="../../includes/img/inm-brand.png" /></td>
                                          </tr>
                                   </table><br/><br/>
                                   <table class="table table-bordered text-center table-condensed">
                                          <thead>
                                                 <tr>
                                                        <th colspan="9" class="success text-center">REPORTE MENSUAL DE ATENCIONES, QUEJAS Y PETICIONES DE AYUDA</th>
                                                 </tr>
                                          </thead>
                                          <tbody>
                                                 <tr>
                                                        <td colspan="9" class="text-center success">DATOS DEL USUARIO</td>
                                                 </tr>
                                                 <tr>
                                                        <td colspan="3" class="active">USUARIO</td>
                                                        <td colspan="2" class="">'.$estado.'</td>
                                                        <td colspan="2" class="active">Fecha inicial: '.$finicio.'</td>
                                                        <td colspan="2" class="active">Fecha final: '.$ffin.'</td>
                                                 </tr>
                                                 <tr>
                                                        <td colspan="9" class="success">I. ATENCIONES</td>
                                                 </tr>
                                                 <tr>
                                                        <td colspan="3" class="active">Atenci&oacute;n presencial</td>
                                                        <td colspan="6" class="">0</td>
                                                 </tr>
                                                 <tr>
                                                        <td colspan="3" rowspan="2" class="active">Llamadas telef&oacute;nicas</td>
                                                        <td colspan="3" class="active">Atendidas personalmente</td>
                                                        <td colspan="3" class="active">Sistema de atenci&oacute;n automatizado</td>
                                                 </tr>
                                                  <tr>
                                                        <td colspan="3" class="">0</td>
                                                        <td colspan="3" class="">0</td>
                                                 </tr>
                                                 <tr>
                                                        <td colspan="3" class="active">Correos electr&oacute;nicos</td>
                                                        <td colspan="3" class="">0</td>
                                                 </tr>
                                                 <tr>
                                                        <td colspan="3" rowspan="2" class="active">Atenciones grupales</td>
                                                        <td colspan="3" class="active">No. de atenciones</td>
                                                        <td colspan="3" class="active">Personas atendidas</td>
                                                 </tr>
                                                  <tr>
                                                        <td colspan="3" class="">0</td>
                                                        <td colspan="3" class="">0</td>
                                                 </tr>
                                                 <tr>
                                                        <td colspan="9" class="success">II. QUEJAS Y PETICIONES DE AYUDA</td>
                                                 </tr>
                                                 <tr>
                                                        <td colspan="3" rowspan="2" class="active">Quejas</td>
                                                        <td colspan="2" class="active">Turnadas al OIC</td>
                                                        <td colspan="2" class="active">Turnadas a la DNPP</td>
                                                        <td colspan="2" class="active">Total</td>
                                                 </tr>
                                                  <tr>
                                                        <td colspan="2" class="">'.$totQueOIC['total'].'</td>
                                                        <td colspan="2" class="">'.$totQueDNPP['total'].'</td>
                                                        <td colspan="2" class="">'.$totQueGRAL.'</td>
                                                 </tr>
                                                 <tr>
                                                        <td colspan="3" rowspan="2" class="active">Peticiones de ayuda</td>
                                                        <td colspan="2" class="active">Turnadas al OIC</td>
                                                        <td colspan="2" class="active">Turnadas a la DNPP</td>
                                                        <td colspan="2" class="active">Total</td>
                                                 </tr>
                                                  <tr>
                                                        <td colspan="2" class="">'.$totPetOIC['total'].'</td>
                                                        <td colspan="2" class="">'.$totPetDNPP['total'].'</td>
                                                        <td colspan="2" class="">'.$totPetGRAL.'</td>
                                                 </tr>
                                          </tbody>
                                   </table>
                                   <span class="help-block">*La informacion reportada es su responsabilidad y al firmar, esta de acuerdo en que los datos son veraces y confiables.</span>
                                   <br/><br/><br/><br/><br/><br/>
                                   <table style="width:100%;">
                                          <tr >
                                              <td style="width:25%;"></td>
                                              <td style="width:50%;"><center><hr style=" height: 1px;background-color:#555;width: 100%;" />'.$firma.'</center></td>
                                              <td style="width:25%;"></td>
                                          </tr>
                                   </table>
                                   
                            </div>
                     </body>
              </html>';
             require_once '../../includes/librerias/DOMPDF/autoload.inc.php';

              // instantiate and use the dompdf class
              $dompdf = new Dompdf\Dompdf;
              $dompdf->loadHtml($htmlCont);
              
              // (Optional) Setup the paper size and orientation
              //$dompdf->setPaper('A4', 'landscape');
              $dompdf->setPaper('A4', 'portrait');
              
              // Render the HTML as PDF
              $dompdf->render();
              
              // Output the generated PDF to Browser
              //$dompdf->stream();
              // $dompdf->output();
              $dompdf->stream("mensual".rand(10,1000).".pdf", array("Attachment" => false));
       }
}


?>