<?php
extract($_POST);
session_start();
include_once('../configuracion/configuracion.inc.php');
include_once("../clases/Conexion.php");
include_once("../clases/Usuario.php");
include_once("../clases/Tabulador.php");

if($opcion == 1){//Busqueda
    $u = new Usuario(SERVIDOR,USUARIO,CLAVE,BASE,PUERTO);
    $busqueda = array();
    $cabecera = array('Nombre','Rol','Estado Encargado','Fecha de Registro','Estatus');
    $busqueda = $u -> buscaUsuarios($rol_b,$edo_b,$nombre_b,$_SESSION['rol_usuario_id']);
    $pagina = (!empty($p))? $p : 1; 
    $tab = new Tabulador($busqueda,$cabecera,$pagina,10,array(0,1,0,0,1),1);
    $totB = count($busqueda);
    if($busqueda > 0 && !empty($busqueda[0]['id'])){
        $tab->muestraTabla();
        echo "<script>eventosTabla();paginadorEv();</script>";
    }else{
         echo '<div class="alert alert-warning text-center"><i>Sin resultados</i></div>';
    }
    
}else if($opcion == 2){//Formulario agregar usuario
     $u = new Usuario(SERVIDOR,USUARIO,CLAVE,BASE,PUERTO);
     echo $u->formUsuario();
     echo $u->btnAgregar();
     echo "<script>formUsuario();soloActivo();</script>";
     
}else if($opcion == 3){//Permisos
    $u = new Usuario(SERVIDOR,USUARIO,CLAVE,BASE,PUERTO);
    echo $u->formPermisos($rol);
   //echo "<script>$('input[type=checkbox]').prop('checked',true);</script>";
    
}else if($opcion == 4){//Formulario Ver/Editar/Eliminar
    $idusu = (!empty($_SESSION['id']))? $_SESSION['id']: 0 ;
    $u = new Usuario(SERVIDOR,USUARIO,CLAVE,BASE,PUERTO);
    echo $u->formUsuario();
    echo "<script>formUsuario();</script>";
    echo $u->cargaDatosUsu($idusu,$usuario);
    echo $u->btnEditaElimina($idusu);
    
}else if($opcion == 5){//permisos por usuario / seleccionar los permisos con los que cuenta el usuario
    $idusu = (!empty($_SESSION['id']))? $_SESSION['id']: 0 ;
    $u = new Usuario(SERVIDOR,USUARIO,CLAVE,BASE,PUERTO);
    echo $u->permisoOperaciones($idusu,$usuario);
    if(!empty($editar)){ //Validar su podra Editar Permisos
        $idusu = (!empty($_SESSION['id']))? $_SESSION['id']: 0 ;
        $cambioPer = $u->validarPermiso($idusu,25);
        //print_r($cambioPer);
        if(!empty($cambioPer) && $cambioPer['activo'] == 0){
            echo "<script>$('input[type=checkbox]').prop('disabled',true);$('#rol').prop('disabled',true);</script>";
        }
    }
    
}else if($opcion == 6){// validar si existe usuario
     $u = new Usuario(SERVIDOR,USUARIO,CLAVE,BASE,PUERTO);
     $res = array();
    if(!empty($id)){
        $res = $u->validarUsu($usuario,$id);
    }else{
        $res = $u->validarUsu($usuario);
    }
    echo json_encode($res);
}else if($opcion == 7){// Agregar usuario
    $u = new Usuario(SERVIDOR,USUARIO,CLAVE,BASE,PUERTO);
    $res = array();
    $res = $u->agregarUsuario($_POST);
    echo json_encode($res);
    
}else if($opcion == 8){// Actualizar usuario
    //print_r($_POST);exit(0);
    $u = new Usuario(SERVIDOR,USUARIO,CLAVE,BASE,PUERTO);
    $res = array();
    $res = $u->modificarUsuario($_POST);
    echo json_encode($res);
    
}else if($opcion == 9){// Eliminar usuario
    $u = new Usuario(SERVIDOR,USUARIO,CLAVE,BASE,PUERTO);
    $res = array();
    $res = $u->eliminarUsuario($_POST);
    echo json_encode($res);
    
}

?>