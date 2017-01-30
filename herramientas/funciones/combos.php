<?php
session_start();
//ini_set('display_errors','1');

include_once('../configuracion/configuracion.inc.php');
include_once('../clases/Conexion.php');

$sql = array();
$sql['roles'] = 'SELECT id,rol FROM rol_usuario where activo = true and clave != "OIC" and clave != "ADM" order by rol';
$sql['roles_adm'] = 'SELECT id,rol FROM rol_usuario where activo = true and clave != "OIC" order by rol';
$sql['estados_m'] = 'select e.id,e.nombre_estado from pais p inner join estado e on p.id = e.pais_id where p.clave = "MEX" and e.id != 83 order by nombre_estado;';
$sql['estados_usa'] = 'select e.id,e.nombre_estado from pais p inner join estado e on p.id = e.pais_id where p.clave = "USA" order by nombre_estado;';
$sql['estados_solo_df'] = 'select e.id,e.nombre_estado from pais p inner join estado e on p.id = e.pais_id where e.id = 83 order by nombre_estado;';
$sql['atencion'] = 'SELECT cve_atencion,tipo_atencion FROM cat_tipo_atenciones order by tipo_atencion;';
$sql['tema'] = 'SELECT cvet_tema,nombre_tema FROM cat_temas order by nombre_tema;';
$sql['tipo_registro'] = 'Select id, nombre_operacion from operacion where clave = "Q" or clave = "P" and activo = true order by nombre_operacion;';
$sql['medio_recepcion'] = 'SELECT id, medio_recepcion FROM medio_recepcion where activo = true order by medio_recepcion;' ;
$sql['pais'] = 'SELECT id,nombre_pais FROM pais where activo = true;';
$sql['estado'] = 'SELECT id, nombre_estado FROM estado where activo = true and pais_id =';
$sql['estados_todos'] = 'SELECT id, nombre_estado FROM estado where activo = true order by pais_id, nombre_estado;';
$sql['estados_con_solicitudes'] = 'select e.id, e.nombre_estado from estado e where e.id in(SELECT aplica_estado_id FROM solicitud group by aplica_estado_id) order by e.pais_id, e.nombre_estado;';
$sql['ciudad'] = 'SELECT id, nombre_ciudad FROM ciudad where activo = true and estado_id =';
$sql['causa'] = 'SELECT id,causa FROM causa where activo = true and quien_aplica = 3 or quien_aplica = ';
$sql['sexo'] = 'SELECT id,sexo FROM sexo where activo = true order by sexo;';
$sql['dependencia_q'] = 'SELECT id,dependencia FROM dependencia where activo = true and (quien_aplica = 1 or quien_aplica = 3) order by dependencia;';
$sql['dependencia_p'] = 'SELECT id,dependencia FROM dependencia where activo = true and (quien_aplica = 2 or quien_aplica = 3)  order by dependencia;';
$sql['estatus_usuario'] = 'SELECT id, estatus FROM estatus_usuario where activo = true and clave != "E" order by estatus;';
$sql['estatus_usuario_adm'] = 'SELECT id, estatus FROM estatus_usuario where activo = true order by estatus;';
$sql['estatus_peticion_adm'] = 'SELECT id, estatus_peticion FROM estatus_peticion where activo = true order by estatus_peticion;';
$sql['estatus_peticion'] = 'SELECT id, estatus_peticion FROM estatus_peticion where activo = true and id != 6 order by estatus_peticion;';
$sql['nacionalidad'] = 'SELECT id,nacionalidad FROM pais where activo = true;';
$sql['tipo_atencion'] = 'SELECT id,tipo_atencion FROM tipo_atencion where activo = true;';
$sql['tema'] = 'SELECT id, nombre_tema FROM tema where activo = true;';

$c = Conexion(CONEXION,SERVIDOR,USUARIO,CLAVE,BASE_SID,PUERTO);
$consulta = (int) $_GET['consulta'];
$select = '';

switch($consulta){
    case 1 : $select = $sql['atencion']; break;
    case 2 : $select = $sql['tema']; break;
    case 3 : $select = $sql['tipo_registro']; break;
    case 4 : $select = $sql['medio_recepcion']; break;
    case 5 : $select = $sql['pais']; break;
    case 6 : $select = $sql['estado'].$_GET['pa']." order by nombre_estado"; break;
    case 7 : $select = $sql['ciudad'].$_GET['es']." order by nombre_ciudad"; break;
    case 8 : $select = $sql['causa'].$_GET['tr']." order by causa;"; break;
    case 9 : $select = $sql['sexo']; break;
    case 10 : $select = $sql['']; break;
    case 11 : $select = $sql['']; break;
    case 12 : $select = $sql['']; break;
    case 13 : $select = $sql['dependencia_p']; break;
    case 14 :
         if(!empty($_SESSION['rol_usuario_id'])&& $_SESSION['rol_usuario_id'] == md5(5)){
            $select = $sql['roles_adm'];
         }else{ $select = $sql['roles'];}
    break;
    case 15 : $select = $sql['estados_m']; break;
    case 16 : $select = $sql['estados_usa']; break;
    case 17 :
        if(!empty($_SESSION['rol_usuario_id'])&& $_SESSION['rol_usuario_id'] == md5(5)){
            $select = $sql['estatus_usuario_adm'];
         }else{ $select = $sql['estatus_usuario'];}
    break;
    case 18 : $select = $sql['estatus_peticion_adm'];break;
    case 19 : $select = $sql['dependencia_q']; break;
    case 20 : $select = $sql['estados_con_solicitudes']; break;
    case 21 : $select = $sql['estados_solo_df']; break;
    
    case 22 : $select = $sql['nacionalidad']; break;
    case 23 : $select = $sql['tema']; break;
    case 24 : $select = $sql['tipo_atencion']; break;
    default: $select = null;break;
}

if(!empty($select)){
   $datos = $c->query($select,'arregloNumerico');
   for($i = 0; $i < count($datos); $i++){
        $datos[$i][1] = utf8_encode($datos[$i][1]);
   }
   #print_r($datos);
    echo json_encode($datos);
   
}

?>