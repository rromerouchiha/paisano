<?php
//local

@define('CONEXION','MYSQL');          // [MYSQL, MSSQL, ORACLE]
@define('SERVIDOR','127.0.0.1');
@define('USUARIO','root');
@define('CLAVE','');    //
@define('BASE','paisano');
@define('BASE_SID',BASE);     // base/sid -> para cambiar de base a esquema dependiendo del servidor de base [MYSQL, MSSQL, ORACLE]
//@define('_DIR','inami2015');
@define('_DIR','/paisano3.0'); //localhost
@define('PUERTO','3306'); 
@define('CINICIO','10$2$');
//@define('_DIR',''); //qa

//QA
/*
@define('CONEXION','MYSQL');          // [MYSQL, MSSQL, ORACLE]
@define('SERVIDOR','172.16.22.66');
@define('USUARIO','intrapaisano');
@define('CLAVE','p#W%/j8');    //
@define('BASE','intrapaisano');
@define('BASE_SID',BASE);     // base/sid -> para cambiar de base a esquema dependiendo del servidor de base [MYSQL, MSSQL, ORACLE]
//@define('_DIR','inami2015');
@define('PUERTO','3306'); 
@define('CINICIO','10$2$');
@define('_DIR',''); */
?>
