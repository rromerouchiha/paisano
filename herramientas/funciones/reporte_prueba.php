<?php
session_start();
include_once('../configuracion/configuracion.inc.php');
include_once("../clases/Conexion.php");
include_once("../clases/Solicitud.php");
include_once("../clases/Queja.php");
include_once("../clases/Peticion.php");
include_once("../clases/Tabulador.php");
include_once("../clases/Usuario.php");
include_once('funciones.php');

  require_once '../../includes/librerias/PHPExcel/Classes/PHPExcel.php';
              require_once '../../includes/librerias/PHPExcel/Classes/PHPExcel/Writer/Excel2007.php';
              
              $cabecera = array('Folio','Fecha recepción','Tipo','Causa','Lugar de registro','Medio de recepción','Estatus operador','Estatus Actual','Dependencias');
             $cacheMethod = PHPExcel_CachedObjectStorageFactory:: cache_to_phpTemp; 
              $cacheSettings = array( 'memoryCacheSize' => '16MB'); 
              PHPExcel_Settings::setCacheStorageMethod($cacheMethod, $cacheSettings); 
              $objPHPExcel = new PHPExcel();
              ini_set('memory_limit', '-1');
              $objPHPExcel->getActiveSheet()->fromArray($cabecera, null,'A1');
              $objPHPExcel->getActiveSheet()->fromArray($solicitudes,null,'A2');
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
              
            


?>