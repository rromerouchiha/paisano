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
//$r = (!empty($r))? $r : 0;
//print_r($_POST);//exit();
if(!empty($_SESSION['id'])){
       if($r == 1){
              $q = new Queja(SERVIDOR,USUARIO,CLAVE,BASE,PUERTO);
              $p = new Peticion(SERVIDOR,USUARIO,CLAVE,BASE,PUERTO);
              $c = new ConexionMySQL(SERVIDOR,USUARIO,CLAVE,BASE,PUERTO);
              $estados = (!empty($estados_re))? $estados_re : 0 ;
              $cadenaEstado = "";
              $estado = $_SESSION['nombre_estado'];
              
              if($estados > 0){
                     $cadenaEstado = "";
                     $estadoCad = " and s.aplica_estado_id = ".$estados;
                     $sql = "select nombre_estado from estado where id = ".$estados.";";
                     $edo = $c->query($sql,'registro');
                     $cadenaEstado .= $edo['nombre_estado'];
              }else{
                     $estadoCad = " and s.aplica_estado_id = ".$_SESSION['edo_rep'];
                     $cadenaEstado = $estado;
              } 
              
              $totPetNva = $p->totalPeticionesNva($fecha_inicio_re,$fecha_final_re,$estadoCad);
              $totPetOIC = $p->totalPeticionesOIC($fecha_inicio_re,$fecha_final_re,$estadoCad);
              $totPetDNPP = $p->totalPeticionesDNPP($fecha_inicio_re,$fecha_final_re,$estadoCad);
              $totPetCon = $p->totalPeticionesConcluida($fecha_inicio_re,$fecha_final_re,$estadoCad,$estados);
              $totPetGRAL = ($totPetOIC['total'] + $totPetDNPP['total'] + $totPetNva['total'] + $totPetCon);
              
              $totQueNva = $q->totalQuejasNva($fecha_inicio_re,$fecha_final_re,$estadoCad);
              $totQueOIC = $q->totalQuejasOIC($fecha_inicio_re,$fecha_final_re,$estadoCad);
              $totQueDNPP = $q->totalQuejasDNPP($fecha_inicio_re,$fecha_final_re,$estadoCad);
              $totQueCon = $q->totalQuejasConcluida($fecha_inicio_re,$fecha_final_re,$estadoCad,$estados);
              $totQueGRAL = ($totQueOIC['total'] + $totQueDNPP['total'] + $totQueNva['total'] + $totQueCon);

              $r = $q->obtenerRol($_SESSION['rol_usuario_id']);
              $nombre = $_SESSION['nombre'] . ' ' . $_SESSION['paterno'] . ' ' . $_SESSION['materno'];
             
              if($r == 1 || $r == 5){
                     $firma = $nombre."<br/>Direcci&oacute;n Nacional del Programa Paisano<br/>";
              }else if($r == 2){
                     $firma = $nombre."<br/>Representante del programa paisano en ". $estado;
              }else if($r == 3){
                     $firma = $nombre."<br/>Enlace del programa paisano en ". $estado;
              }else{
                    $firma = "sin datos"; 
              }
            
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
                                              <td style="text-align:right !important;"><img src="../../includes/img/inm-brand.png" style="width:75px;"/></td>
                                          </tr>
                                   </table><br/><br/>
                                   <table class="table table-bordered text-center table-condensed">
                                          <thead>
                                                 <tr>
                                                        <th colspan="12" class="success text-center">REPORTE MENSUAL DE ATENCIONES, QUEJAS Y PETICIONES DE AYUDA</th>
                                                 </tr>
                                          </thead>
                                          <tbody>
                                                 <tr>
                                                        <td colspan="12" class="text-center success">DATOS DEL USUARIO</td>
                                                 </tr>
                                                 <tr>
                                                        <td colspan="2" class="active">USUARIO</td>
                                                        <td colspan="4" class="">'.utf8_encode($cadenaEstado).'</td>
                                                        <td colspan="3" class="active">Fecha inicial:<br/> '.$fecha_inicio_re.'</td>
                                                        <td colspan="3" class="active">Fecha final:<br/> '.$fecha_final_re.'</td>
                                                 </tr>
                                                 <tr>
                                                        <td colspan="12" class="success">I. ATENCIONES</td>
                                                 </tr>
                                                 <tr>
                                                        <td colspan="2" class="active">Atenci&oacute;n presencial</td>
                                                        <td colspan="10" class="">0</td>
                                                 </tr>
                                                 <tr>
                                                        <td colspan="2" rowspan="2" class="active">Llamadas telef&oacute;nicas</td>
                                                        <td colspan="5" class="active">Atendidas personalmente</td>
                                                        <td colspan="5" class="active">Sistema de atenci&oacute;n automatizado</td>
                                                 </tr>
                                                  <tr>
                                                        <td colspan="5" class="">0</td>
                                                        <td colspan="5" class="">0</td>
                                                 </tr>
                                                 <tr>
                                                        <td colspan="2" class="active">Correos electr&oacute;nicos</td>
                                                        <td colspan="10" class="">0</td>
                                                 </tr>
                                                 <tr>
                                                        <td colspan="2" rowspan="2" class="active">Atenciones grupales</td>
                                                        <td colspan="5" class="active">No. de atenciones</td>
                                                        <td colspan="5" class="active">Personas atendidas</td>
                                                 </tr>
                                                  <tr>
                                                        <td colspan="5" class="">0</td>
                                                        <td colspan="5" class="">0</td>
                                                 </tr>
                                                 <tr>
                                                        <td colspan="12" class="success">II. QUEJAS Y PETICIONES DE AYUDA</td>
                                                 </tr>
                                                 <tr>
                                                        <td colspan="2" rowspan="2" class="active">Quejas</td>
                                                        <td colspan="2" class="active">Nuevas</td>
                                                        <td colspan="2" class="active">Turnadas al OIC</td>
                                                        <td colspan="2" class="active">Turnadas a la DNPP</td>
                                                        <td colspan="2" class="active">Concluidas</td>
                                                        <td colspan="2" class="active">Total</td>
                                                 </tr>
                                                  <tr>
                                                        <td colspan="2" class="">'.$totQueNva['total'].'</td>
                                                        <td colspan="2" class="">'.$totQueOIC['total'].'</td>
                                                        <td colspan="2" class="">'.$totQueDNPP['total'].'</td>
                                                        <td colspan="2" class="">'.$totQueCon.'</td>
                                                        <td colspan="2" class="">'.$totQueGRAL.'</td>
                                                 </tr>
                                                 <tr>
                                                        <td colspan="2" rowspan="2" class="active">Peticiones de ayuda</td>
                                                        <td colspan="2" class="active">Nuevas</td>
                                                        <td colspan="2" class="active">Turnadas al OIC</td>
                                                        <td colspan="2" class="active">Turnadas a la DNPP</td>
                                                        <td colspan="2" class="active">Concluidas</td>
                                                        <td colspan="2" class="active">Total</td>
                                                 </tr>
                                                  <tr>
                                                        <td colspan="2" class="">'.$totPetNva['total'].'</td>
                                                        <td colspan="2" class="active"></td>
                                                        <td colspan="2" class="">'.$totPetDNPP['total'].'</td>
                                                        <td colspan="2" class="">'.$totPetCon.'</td>
                                                        <td colspan="2" class="">'.$totPetGRAL.'</td>
                                                 </tr>
                                          </tbody>
                                   </table>
                                   <span class="help-block">*La informacion reportada es su responsabilidad y al firmar, esta de acuerdo en que los datos son veraces y confiables.</span>
                                   <br/><br/><br/><br/><br/><br/>
                                   <table style="width:100%;">
                                          <tr >
                                              <td style="width:25%;"></td>
                                              <td style="width:50%;"><center><hr style=" height: 1px;background-color:#555;width: 100%;" />'.utf8_encode($firma).'</center></td>
                                              <td style="width:25%;"></td>
                                          </tr>
                                   </table>
                                   
                            </div>
                     </body>
              </html>';
              //echo $htmlCont;
           require_once '../../includes/librerias/DOMPDF/autoload.inc.php';
              $dompdf = new Dompdf\Dompdf;
              $dompdf->loadHtml($htmlCont);
              $dompdf->setPaper('A4', 'portrait');
              $dompdf->render();
              $dompdf->stream("ReporteMensual_".utf8_encode($estado), array("Attachment" => false));
              
       }else if($r == 2){
              //print_r($_SESSION);EXIT();
              require_once '../../includes/librerias/PHPExcel/Classes/PHPExcel.php';
              require_once '../../includes/librerias/PHPExcel/Classes/PHPExcel/Writer/Excel2007.php';
              $qyp = new  Solicitud(SERVIDOR,USUARIO,CLAVE,BASE,PUERTO);
              $u = new Usuario(SERVIDOR,USUARIO,CLAVE,BASE,PUERTO);
              $idusu = (!empty($_SESSION['id']))? $_SESSION['id']: 0 ;
              $rol = $qyp->obtenerRol($_SESSION['rol_usuario_id']);
              $cfin = "K";
              $logImg = "H";
              $hoy = new DateTime();
              if($rol == 2 || $rol == 3){
                      if(!empty($busca)){
                          $solicitudes = $qyp->datosBusqueda($_SESSION['rol_usuario_id'],$_POST,$_SESSION['edo_rep'],$busca,1);
                      }else{
                          $solicitudes = $qyp->datosBusqueda($_SESSION['rol_usuario_id'],$_POST,$_SESSION['edo_rep'],null,1);
                      }
                      $cabecera = array('  Folio Solicitud  ','  Fecha recepción  ','  Tipo de Solicitud  ','  Causa  ','  Lugar de registro  ','  Medio de recepción  ','  Estatus operador  ','  Estatus Actual  ','  País de los hechos  ','  Estado de los hechos  ','  Ciudad de los hechos  ','  Dependencias Contactadas/Involucradas  ');
                      $cfin = "L";
                      $logImg = "I";
              }
              else if($rol == 1 || $rol == 5){
                      if(!empty($busca)){
                             $solicitudes = $qyp->datosBusqueda($_SESSION['rol_usuario_id'],$_POST,null,$busca,1);  
                      }else{
                           $solicitudes = $qyp->datosBusqueda($_SESSION['rol_usuario_id'],$_POST,null,null,1);     
                      }
                      $cabecera = array('  Folio Solicitud  ','  Fecha recepción  ','  Tipo de Solicitud  ','  Causa  ','  Lugar de registro  ','  Medio de recepción  ','  Estatus Actual  ','  País de los hechos  ','  Estado de los hechos  ','  Ciudad de los hechos  ','  Dependencias Contactadas/Involucradas  ');
              }
              $totalN = count($solicitudes);
              if($totalN > 0){
                     $informacion = array();       
                     for($i = 0; $i < $totalN; $i++){
                            $ids = $solicitudes[$i]['id'];
                            $solicitudes[$i]['dependencia'] = "";
                            if($solicitudes[$i]['nombre_operacion'] == "Queja"){
                                   $sqlDp = "select dep.dependencia from informacion_queja iq
                                          inner join involucrados_queja inq on iq.id = inq.informacion_queja_id
                                          inner join involucrado inv on inq.involucrado_id = inv.id
                                          inner join dependencia dep on dep.id = inv.dependencia_id
                                          where iq.solicitud_id = ".$ids.";";
                                   $dep = $qyp->query($sqlDp,"arregloAsociado");
                                   for($j = 0; $j < count($dep); $j++){
                                          if($j > 0){
                                                $solicitudes[$i]['dependencia'] .= ", "; 
                                          }
                                          $solicitudes[$i]['dependencia'] .= utf8_encode($dep[$j]['dependencia']);
                                   }
                                   
                            }else{
                                   $sqlDp = "select dep.dependencia from informacion_peticion infopet inner join solicitud sol on sol.id = infopet.solicitud_id inner join dependencia_contactada depcon on depcon.peticion_id = infopet.id
                                          inner join dependencia dep on dep.id = depcon.dependencia_id where sol.id =".$ids.";";
                                   $dep = $qyp->query($sqlDp,"arregloAsociado");
                                   for($j = 0; $j < count($dep); $j++){
                                          if($j > 0){
                                                $solicitudes[$i]['dependencia'] .= ", "; 
                                          }
                                          $solicitudes[$i]['dependencia'] .= utf8_encode($dep[$j]['dependencia']);
                                   }
                            }
                            
                            
                            unset($solicitudes[$i]['id']);
                            $solicitudes[$i]['nombre_operacion'] = utf8_encode($solicitudes[$i]['nombre_operacion']);
                            $solicitudes[$i]['causa'] = utf8_encode($solicitudes[$i]['causa']);
                            $solicitudes[$i]['nombre_estado'] = utf8_encode($solicitudes[$i]['nombre_estado']);
                            $solicitudes[$i]['medio_recepcion'] = utf8_encode($solicitudes[$i]['medio_recepcion']);
                           
                            $solicitudes[$i]['nombre_pais'] = utf8_encode($solicitudes[$i]['nombre_pais']);
                            $solicitudes[$i]['nombre_estado_hechos'] = utf8_encode($solicitudes[$i]['nombre_estado_hechos']);
                            $solicitudes[$i]['nombre_ciudad'] = utf8_encode($solicitudes[$i]['nombre_ciudad']);
                            
                            if(!empty($solicitudes[$i]['Estatus operador'])){
                                   $solicitudes[$i]['Estatus operador'] = utf8_encode($solicitudes[$i]['Estatus operador']);
                            }
                            $solicitudes[$i]['Estatus real'] = utf8_encode($solicitudes[$i]['Estatus real']);
                     }
              }
              //print_r($solicitudes);exit();
              
              $cacheMethod = PHPExcel_CachedObjectStorageFactory:: cache_to_phpTemp; 
              $cacheSettings = array( 'memoryCacheSize' => '16MB'); 
              PHPExcel_Settings::setCacheStorageMethod($cacheMethod, $cacheSettings); 
              $objPHPExcel = new PHPExcel();
              ini_set('memory_limit', '-1');
              
              
              
              //HEADER
              $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:'.$cfin.'1');
              $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A2:E2');
              $objPHPExcel->setActiveSheetIndex(0)->mergeCells('F2:'.$cfin.'2');
              
              
              $objDrawing = new PHPExcel_Worksheet_Drawing();
              $objDrawing->setName('Logo');
              $objDrawing->setDescription('Logo');
              $logo = '../../includes/img/paisano.png'; // Provide path to your logo file
              $objDrawing->setPath($logo);
              $objDrawing->setOffsetX(10);    // setOffsetX works properly
              $objDrawing->setOffsetY(5);  //setOffsetY has no effect
              $objDrawing->setCoordinates('A1');
              $objDrawing->setHeight(110);
              $objDrawing->setWorksheet($objPHPExcel->getActiveSheet()); 
              
              $objDrawing2 = new PHPExcel_Worksheet_Drawing();
              $objDrawing2->setName('Logo');
              $objDrawing2->setDescription('Logo');
              $logo = '../../includes/img/cab.png'; // Provide path to your logo file
              $objDrawing2->setPath($logo);
              $objDrawing2->setOffsetX(0);    // setOffsetX works properly
              $objDrawing2->setOffsetY(25);  //setOffsetY has no effect
              $objDrawing2->setCoordinates($logImg.'1');
              //$objDrawing2->setWidth(60);
              //$objDrawing2->setWidthAndHeight(250,500);
              //$objDrawing2->setResizeProportional(true);
              $objDrawing2->setHeight(75);
              $objDrawing2->setWorksheet($objPHPExcel->getActiveSheet()); 
              
              
              //CABECERA TABLA
              $objPHPExcel->getActiveSheet()->getStyle('A3:'.$cfin.'3')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
              $objPHPExcel->getActiveSheet()->getStyle('A3:'.$cfin.'3')->getFill()->getStartColor()->setARGB('AA594A7D');
              $objPHPExcel->getActiveSheet()->getStyle("A3:".$cfin."3")->getFont()->setBold(true);
              $objPHPExcel->getActiveSheet()->getStyle()->getFont()->setSize(13);
              $objPHPExcel->getActiveSheet()->getStyle('A3:'.$cfin.'3')->getFont()->applyFromArray(array('name'=> 'Arial Unicode MS','bold'=> true,'italic'=> false,'strike'=> false));
              
              //ENCABEZADO REPORTE
              $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', 'Reporte de quejas
y peticiones');
              $objPHPExcel->getActiveSheet()->getRowDimension(1)->setRowHeight(90);
              $objPHPExcel->getActiveSheet()->getRowDimension(2)->setRowHeight(40);
              $objPHPExcel->getActiveSheet()->getStyle('A1')->getFill()->getStartColor()->setARGB('FFFF0000');
              $objPHPExcel->getActiveSheet()->getStyle("A1:I2")->getFont()->setBold(true);
              $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setSize(28);
              $objPHPExcel->getActiveSheet()->getStyle('A2:L2')->getFont()->setSize(18);
              $objPHPExcel->getActiveSheet()->getStyle('A3:'.$cfin.'3')->getFont()->setSize(17);
              $objPHPExcel->getActiveSheet()->getStyle('A4:'.$cfin.(count($solicitudes)+3))->getFont()->setSize(15);
              
              $objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->applyFromArray(
                     array(
                         'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                         'vertical'   => PHPExcel_Style_Alignment::VERTICAL_BOTTOM ,
                         'rotation'   => 0,
                         'wrap'       => true
                     )
              );
              
              $objPHPExcel->getActiveSheet()->getStyle('A2:I2')->getAlignment()->applyFromArray(
                     array(
                         'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                         'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER ,
                         'rotation'   => 0,
                         'wrap'       => true
                     )
              );
              $objPHPExcel->getActiveSheet()->getStyle('A3:'.$cfin.'3')->getAlignment()->applyFromArray(
                     array(
                         'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                         'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER ,
                         'rotation'   => 0,
                         'wrap'       => true
                     )
              );
              
              $objPHPExcel->getActiveSheet()->getStyle("A3:".$cfin."3")->getFont()->setBold(true)->getColor()->setRGB('FFFFFFFF');
              
              // Add some data
              $objPHPExcel->getActiveSheet()->getStyle('A3:'.$cfin.'3')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
              $objPHPExcel->getActiveSheet()->getStyle('A2:I2')->getFill()->getStartColor()->setARGB('29bb04');
              
              $objPHPExcel->getActiveSheet()->fromArray($cabecera, null,'A3');
              $objPHPExcel->getActiveSheet()->fromArray($solicitudes,null,'A4');
              $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F2', "Usuario : ".$_SESSION['n_completo']);
              $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A2','Fecha en que se realiza el reporte: '.$hoy->format('d-m-Y H:i'));
              
              for ($col = 'A'; $col != 'M'; $col++) {
                     $objPHPExcel->getActiveSheet()->getColumnDimension($col)->setAutoSize(true);
              }
              
              
              header('Content-Disposition: attachment;filename="QuejasyPeticiones.xls"');
              $objPHPExcel->getProperties()
              ->setCreator("Cattivo")
              ->setLastModifiedBy("Cattivo")
              ->setTitle("Documento Excel ")
              ->setSubject("Documento Excel d")
              ->setDescription("Reportes.")
              ->setKeywords("Excel Office 2007 openxml php")
              ->setCategory("Reportes de Excel");
               
              // Renombrar Hoja
              $objPHPExcel->getActiveSheet()->setTitle('PAISANO');
               
              // Establecer la hoja activa, para que cuando se abra el documento se muestre primero.
              $objPHPExcel->setActiveSheetIndex(0);
              // Se modifican los encabezados del HTTP para indicar que se envia un archivo de Excel.
              header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
              header('Cache-Control: max-age=0');
              $objWriter=PHPExcel_IOFactory::createWriter($objPHPExcel,'Excel5');
              $objWriter->save('php://output');
              exit;
              
             }else{
                    echo "Debe inicias sesi&oacute; nuevamente.";
             }
}


?>