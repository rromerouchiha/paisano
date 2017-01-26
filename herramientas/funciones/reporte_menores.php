<?php

include_once("../clases/Conexion.php");
include_once('funciones.php');

/*
@define('CONEXION','MYSQL');          // [MYSQL, MSSQL, ORACLE]
@define('SERVIDOR','127.0.0.1');
@define('USUARIO','root');
@define('CLAVE','');    //
@define('BASE','menores');
@define('BASE_SID',BASE);     // base/sid -> para cambiar de base a esquema dependiendo del servidor de base [MYSQL, MSSQL, ORACLE]
//@define('_DIR','inami2015');
@define('PUERTO','3306'); 
//@define('_DIR',''); //qa
*/

@define('CONEXION','MYSQL');          // [MYSQL, MSSQL, ORACLE]
@define('SERVIDOR','127.0.0.1');
@define('USUARIO','root');
@define('CLAVE','');    //
@define('BASE','menores');
@define('BASE_SID',BASE);     // base/sid -> para cambiar de base a esquema dependiendo del servidor de base [MYSQL, MSSQL, ORACLE]
//@define('_DIR','inami2015');
@define('PUERTO','3306'); 
//@define('_DIR',''); //qa


              require_once '../../includes/librerias/PHPExcel/Classes/PHPExcel.php';
              require_once '../../includes/librerias/PHPExcel/Classes/PHPExcel/Writer/Excel2007.php';
              
              $c = new ConexionMySQL(SERVIDOR,USUARIO,CLAVE,BASE,PUERTO);
              $SQLmenores = 'select ma.*, v.* from viaje v inner join salida_menor sm on v.id = sm.id_viaje inner join menor_adolescente ma on sm.id_menor = ma.id where v.fecha_viaje > "2015-07-02" and v.fecha_viaje < "2015-07-04" order by ma.nombre;';
              $menores = $c->query($SQLmenores,'arregloAsociado');
              
              
              
              
              $cabecera = array('Folio','Fecha recepción','Tipo','Causa','Lugar de registro','Medio de recepción','Estatus operador','Estatus Actual','Dependencias');
              $cacheMethod = PHPExcel_CachedObjectStorageFactory:: cache_to_phpTemp; 
              $cacheSettings = array( 'memoryCacheSize' => '16MB'); 
              PHPExcel_Settings::setCacheStorageMethod($cacheMethod, $cacheSettings); 
              $objPHPExcel = new PHPExcel();
              ini_set('memory_limit', '-1');
              $objPHPExcel->getActiveSheet()->fromArray($cabecera, null,'A1');
              $objPHPExcel->getActiveSheet()->fromArray($menores,null,'A2');
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


?>