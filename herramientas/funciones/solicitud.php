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
if(empty($_SESSION['id'])){
        echo "<div class='alert alert-warning'>Lo sentimos, su sesi&oacute;n caduco, debe volver a <a href='index.php'>Ingresar</a></div>";
        exit();
}
//print_r($_SESSION);
//print_r($_POST);echo "<br/><br/>";print_r($_FILES);exit();
if($opcion == 1){//Agregar Solicitud
        $estatus = 0;
        $mensaje = "";
        $estado = (!empty($_SESSION['edo_rep'])) ? $_SESSION['edo_rep'] : 32;
        $idusu = (!empty($_SESSION['id']))? $_SESSION['id']: 0 ;
        $rol = 1;
        while(md5($rol) != $_SESSION['rol_usuario_id']){  
            $rol++;
        }
        
    if($tipo_registro == 1){ // Agregar Queja
        $resQueja = array();
        //echo $rol;
        $q = new Queja(SERVIDOR,USUARIO,CLAVE,BASE,PUERTO);
        $resQueja = $q->agregaQueja($_POST,$idusu,$estado, $rol, $_FILES);
        //print_r($resQueja);
        if($resQueja['estatus'] == 1){
            $mensaje = 'La queja fue agregada con &eacute;xito, no olvide anotar su n&uacute;mero de folio <strong>'.$resQueja['num_folio'].'</strong>';
            $estatus = 1;
        }else{
            $mensaje = 'No fue posible agregar la queja, por favor intente de nuevo<button type="button" id="cierraMenE" class="close" aria-hidden="true">&times;</button>';
        }
       
        
    }else if($tipo_registro == 2){ // Agregar Peticion
        $p = new Peticion(SERVIDOR,USUARIO,CLAVE,BASE,PUERTO);
        $resPet = $p->agregaPeticion($_POST,$idusu,$estado, $rol, $_FILES);
        //print_r($resPet);
        if($resPet['estatus'] == 1){
            $mensaje = 'La petici&oacute;n fue agregada con &eacute;xito, no olvide anotar su n&uacute;mero de folio <strong>'.$resPet['num_folio'].'</strong>';
            $estatus = 1;
        }else{
            $mensaje = 'No fue posible agregar la petici&oacute;n, por favor intente de nuevo';
        }
       
    }
    //$resQueja['mensaje']= "prueba javascript";
    
    echo '<script type="text/javascript" src="../../includes/js/jquery-1.11.0.min.js"></script>
        <script type="text/javascript" src="../../includes/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="../../includes/js/solicitudes.js"></script>
        <script>eventoAgregarQP("'.$mensaje.'",'.$estatus.');</script>';
    
    
    
}else if($opcion == 2){ //form nueva
    $qyp = new  Solicitud(SERVIDOR,USUARIO,CLAVE,BASE,PUERTO);
    $qyp->formSolicitud();
     echo '</div>
            <script type="text/javascript" src="includes/js/solicitudes.js"></script>
    <script>cargaForm();</script>';
}else if($opcion == 3){ //datos de la bandeja de entrada
        $p = (!empty($pag))? $pag: 1;
        $qyp = new Solicitud(SERVIDOR,USUARIO,CLAVE,BASE,PUERTO);
        $beliminar = 0;
        if($rol == 2 || $rol == 3){
                if(!empty($busca)){
                    $solicitudes = $qyp->datosBandeja($_SESSION['rol_usuario_id'],$tipo,$_SESSION['edo_rep'],$busca);
                }else{
                    $solicitudes = $qyp->datosBandeja($_SESSION['rol_usuario_id'],$tipo,$_SESSION['edo_rep']);
                }
                $cabecera = $qyp->daCabecera($_SESSION['rol_usuario_id']);
        }
        else if($rol == 1 || $rol == 5){
                $u = new Usuario(SERVIDOR,USUARIO,CLAVE,BASE,PUERTO);
                $idusu = (!empty($_SESSION['id']))? $_SESSION['id']: 0 ;
                $beliminar = $u -> verPermisoUsu($idusu,'ELQPA',3);
                
                if(!empty($busca)){
                       $solicitudes = $qyp->datosBandeja($_SESSION['rol_usuario_id'],$tipo,null,$busca);  
                }else{
                     $solicitudes = $qyp->datosBandeja($_SESSION['rol_usuario_id'],$tipo);     
                }
                $cabecera = $qyp->daCabecera($_SESSION['rol_usuario_id']);
        }
        $totalN = count($solicitudes);
        if($totalN > 0){
                $tab = new Tabulador($solicitudes,$cabecera,$p,50,array(1,1,0,$beliminar,0),1);
                echo '<div style="width:100%;">';
                $tab->muestraTabla();
                echo '</div>';
                $qyp->botonesSolSeg($_SESSION['rol_usuario_id'],$tipo);
                 echo '<script>botonesBandeja();paginadorEv();</script>';
        }else{
            echo '<div class="alert alert-warning text-center"><i>Sin resultados</i></div>';
        }       
    
}else if($opcion == 4){ //asignar a la dnpp
    $qyp = new  Solicitud(SERVIDOR,USUARIO,CLAVE,BASE,PUERTO);
    $idusu = (!empty($_SESSION['id']))? $_SESSION['id']: 0 ;
    $rol = $qyp->obtenerRol($_SESSION['rol_usuario_id']);
    if($qyp->asignarDNPP($sel,$idusu,$rol)){
        $res['estatus'] = 1;
    }else{
        $res['estatus'] = 0;
    }
    //$res['estatus'] = 1;
    
    echo json_encode($res);
}else if($opcion == 5){ //cargar/actualizar bandeja
    $qyp = new Solicitud(SERVIDOR,USUARIO,CLAVE,BASE,PUERTO);
    if($rol == 2 || $rol == 3){
        $solicitudes = $qyp->datosBandeja($_SESSION['rol_usuario_id'],1,$_SESSION['edo_rep']);
        $solicitudesOIC = $qyp->datosBandeja($_SESSION['rol_usuario_id'],2,$_SESSION['edo_rep']);
    }
    else if($rol == 1 || $rol == 5){
        $solicitudes = $qyp->datosBandeja($_SESSION['rol_usuario_id'],1);
        $solicitudesOIC = $qyp->datosBandeja($_SESSION['rol_usuario_id'],2);
    }
    $totalN = count($solicitudes);
    $totalOic = count($solicitudesOIC);
    echo $qyp->mostrarBandeja($totalN,$totalOic);
    
}else if($opcion == 6){ //asignar a oic
    $qyp = new  Solicitud(SERVIDOR,USUARIO,CLAVE,BASE,PUERTO);
    $idusu = (!empty($_SESSION['id']))? $_SESSION['id']: 0 ;
    $rol = $qyp->obtenerRol($_SESSION['rol_usuario_id']);
    if($qyp->asignarOIC($sel,$idusu,$rol)){
        $res['estatus'] = 1;
    }else{
        $res['estatus'] = 0;
    }
    //$res['estatus'] = 1;
    
    echo json_encode($res);
}else if($opcion == 7){ // concluir solicitud
    $qyp = new  Solicitud(SERVIDOR,USUARIO,CLAVE,BASE,PUERTO);
    $idusu = (!empty($_SESSION['id']))? $_SESSION['id']: 0 ;
    $rol = $qyp->obtenerRol($_SESSION['rol_usuario_id']);
    if($qyp->concluirSol($sel,$idusu,$rol,$tipo)){
        $res['estatus'] = 1;
    }else{
        $res['estatus'] = 0;
    }
    $res['estatus'] = 1;
    
    echo json_encode($res);
}else if($opcion == 8){ // rechazar solicitud
    $qyp = new  Solicitud(SERVIDOR,USUARIO,CLAVE,BASE,PUERTO);
    $idusu = (!empty($_SESSION['id']))? $_SESSION['id']: 0 ;
    $rol = $qyp->obtenerRol($_SESSION['rol_usuario_id']);
    if($qyp->rechazarSol($sel,$idusu,$rol,$tipo)){
        $res['estatus'] = 1;
    }else{
        $res['estatus'] = 0;
    }
    //$res['estatus'] = 1;
    
    echo json_encode($res);
}else if($opcion == 9){ //ver para editar/seguimiento
        $qyp = new  Solicitud(SERVIDOR,USUARIO,CLAVE,BASE,PUERTO);
        echo '<div class="page-header" id="titulo_f"></div>';
        $qyp->formSolicitud();
        echo '</div><script>cargaForm();</script>';
        $qyp->llenaFormularioDetalle($cual);
        if($vista == 1){ //ver en seguimiento
                $qyp->botonesSolSeg($_SESSION['rol_usuario_id'],$tipo);
                echo '<script>botonesBandeja();botonesBusquedaDetalle();$("#justifica_cambios").show();$("#justifica_cambios_componentes").hide();desactivaSolicitud();$(".eliminarInvolucrado, .eliminarTestigo").prop("disabled",true).removeClass("eliminarInvolucrado eliminarTestigo btn-danger");$("#agregaInv").attr("disabled",true).hide();
                        $("#agregarInvolucradoFrm").slideUp();$("#btnInvolucrado").html("");
                        $("#agregarTestigoFrm").slideUp();$("#btnTestigo").html("");
                        if($("#tipo_registro").val() == 2){
                                $("#enviaroic").hide();
                        }
                        </script>';
        }else if($vista == 3){
                $qyp->botonesSolBusDet($boton);
                echo '<script>botonesBusquedaDetalle();$("#justifica_cambios").show();$("#justifica_cambios_componentes").hide();$("#tipo_registro").off().prop("disabled",true);$(".eliminarInvolucrado, .eliminarTestigo").prop("disabled",true).removeClass("eliminarInvolucrado eliminarTestigo btn-danger");$("#agregaInv").attr("disabled",true).hide();
                        $("#agregarInvolucradoFrm").slideUp();$("#btnInvolucrado").html("");$("#agregarTestigoFrm").slideUp();$("#btnTestigo").html("");</script>';
        }else{//editar
                $qyp->botonesSolBusDet($boton);
                echo '<script>botonesBusquedaDetalle();$("#justifica_cambios").show();$("#tipo_registro").off().prop("disabled",true);$("#titulo_f").html("<h1>" + $("#titulo_f").text().replace("Detalle","Edici&oacute;n" ) + "</h1>");$("#opcionEd").val(13);</script>';
        }
        
}else if($opcion == 10){ // eliminar solicitud
    $qyp = new  Solicitud(SERVIDOR,USUARIO,CLAVE,BASE,PUERTO);
    $idusu = (!empty($_SESSION['id']))? $_SESSION['id']: 0 ;
    if($qyp->eliminarSol($sel,$idusu,$rol,$tipo)){
        $res['estatus'] = 1;
    }else{
        $res['estatus'] = 0;
    }

    echo json_encode($res);
}else if($opcion == 11){//busqueda
        $p = (!empty($pag))? $pag: 1;
        $qyp = new  Solicitud(SERVIDOR,USUARIO,CLAVE,BASE,PUERTO);
        $u = new Usuario(SERVIDOR,USUARIO,CLAVE,BASE,PUERTO);
        $idusu = (!empty($_SESSION['id']))? $_SESSION['id']: 0 ;
        $rol = $qyp->obtenerRol($_SESSION['rol_usuario_id']);
        if($rol == 2 || $rol == 3){
                if(!empty($busca)){
                    $solicitudes = $qyp->datosBusqueda($_SESSION['rol_usuario_id'],$_POST,$_SESSION['edo_rep'],$busca);
                }else{
                    $solicitudes = $qyp->datosBusqueda($_SESSION['rol_usuario_id'],$_POST,$_SESSION['edo_rep']);
                }
                $cabecera = $qyp->daCabeceraB($_SESSION['rol_usuario_id']);
               
        }
        else if($rol == 1 || $rol == 5){
                if(!empty($busca)){
                       $solicitudes = $qyp->datosBusqueda($_SESSION['rol_usuario_id'],$_POST,null,$busca);  
                }else{
                     $solicitudes = $qyp->datosBusqueda($_SESSION['rol_usuario_id'],$_POST);     
                }
                $cabecera = $qyp->daCabeceraB($_SESSION['rol_usuario_id']);
        }
        $totalN = count($solicitudes);
        if($totalN > 0){
                //$botones = $qyp->botonesTablaBusqueda($rol, $u->verPermisoUsu($idusu,'MUMU',3), $u->verPermisoUsu($idusu,'MUEU',3));
                $tab = new Tabulador($solicitudes,$cabecera,$p,50,array(0,1,1,1,0),1,array(1,2,3,4,7));
                echo '<div style="width:100%;">';
                $tab->muestraTabla();
                echo '</div><br/><br/>';
                echo '<script>paginadorEvBus();eventosBusquedaSolDatos();$("#reporte_bus").show();</script>';
        }else{
            echo '<div class="alert alert-warning text-center"><i>Sin resultados</i></div>';
            echo '<script>$("#reporte_bus").hide();</script>';
        }       
}else if($opcion == 12){//eliminar en busqueda
    $qyp = new  Solicitud(SERVIDOR,USUARIO,CLAVE,BASE,PUERTO);
    $idusu = (!empty($_SESSION['id']))? $_SESSION['id']: 0 ;
    $rol = $qyp->obtenerRol($_SESSION['rol_usuario_id']);
    if($qyp->eliminarSolBus($sel,$idusu,$rol)){
        $res['estatus'] = 1;
    }else{
        $res['estatus'] = 0;
    }
    //$res['estatus'] = 1;
    
    echo json_encode($res);
}else if($opcion == 13){//modificar Solicitud
        $res = array();
        //print_r($_POST);exit();
        $qyp = new  Solicitud(SERVIDOR,USUARIO,CLAVE,BASE,PUERTO);
        $idusu = (!empty($_SESSION['id']))? $_SESSION['id']: 0 ;
        $rol = $qyp->obtenerRol($_SESSION['rol_usuario_id']);
        if($qyp->actualizarSolicitud($_POST,$_FILES,$idusu,$rol)){
                if($tipo_registro == 1){// queja
                        $q = new Queja(SERVIDOR,USUARIO,CLAVE,BASE,PUERTO);
                        //print_r($_POST);
                        $res = $q-> actualizaQuejas($_POST,$_FILES);
                }else if($tipo_registro == 2){//peticion
                        $p = new Peticion(SERVIDOR,USUARIO,CLAVE,BASE,PUERTO);
                        $res = $p->actualizaPeticion($_POST,$_FILES);
                }
                //$res['estatus'] = 1;
        }else{
                $res['estatus'] = 0;
                $res['mensaje'] = "No se logr&oacute; actualizar la solicitud, por favor intente de nuevo";
        }       
        
         echo '<script type="text/javascript" src="../../includes/js/jquery-1.11.0.min.js"></script>
        <script type="text/javascript" src="../../includes/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="../../includes/js/solicitudes.js"></script>
        <script>eventoModificarQP("'.$res['mensaje'].'",'.$res['estatus'].','.$id_solicitud.');</script>';
        
}else if($opcion == 14){ //Muestra Estatus
        //print_r($_POST);
        //echo "sdsdfsdf  ".$folio_es;
        $qyp = new  Solicitud(SERVIDOR,USUARIO,CLAVE,BASE,PUERTO);
        $rol = $qyp->obtenerRol($_SESSION['rol_usuario_id']);
        $qyp->datosEstatus($folio_es,$rol,$_SESSION['edo_rep']);
        
        
}else if($opcion == 15){ //mostrar datos reporte mensual
       // print_r($_POST);
        $estados = (!empty($estados_re))? $estados_re : 0 ;
        $q = new Queja(SERVIDOR,USUARIO,CLAVE,BASE,PUERTO);
        $p = new Peticion(SERVIDOR,USUARIO,CLAVE,BASE,PUERTO);
        if($estados > 0){
                $estadoCad = "and aplica_estado_id = ".$estados;
        }else{
                $estadoCad = "and aplica_estado_id = ".$_SESSION['edo_rep'];
        }
        $totq = $q->totalQuejas($fecha_inicio_re,$fecha_final_re,$estadoCad,$estados);
        $totp = $p->totPeticiones($fecha_inicio_re,$fecha_final_re,$estadoCad,$estados);
        echo '   <div class="page-header ocultaVer"><h1> &nbsp;Resultados</h1></div>
                <div style="width:100%;">
                        <table class="table table-striped">
                                <thead>
                                    <tr class="success">
                                        <th>Atenciones</th>
                                        <th>Quejas</th>
                                        <th>Peticiones de ayuda</th>
                                    </tr>
                                </thead>
                                <tbody>
                                        <td>0</td>
                                        <td>'.$totq.'</td>
                                        <td>'.$totp.'</td>
                                </tbody>
                        </table>
                </div> ';
}else if($opcion == 16){ //eliminar estatus
        $res['estatus'] = 0;
       // print_r($_POST);
        $s = new  Solicitud(SERVIDOR,USUARIO,CLAVE,BASE,PUERTO);
        $idusu = (!empty($_SESSION['id']))? $_SESSION['id']: 0 ;
        if($s->eliminarEstatusDat($estatus_base,$sol,$idusu)){
                $res['estatus'] = 1;
        }
        echo json_encode($res);
}else if($opcion == 17){ //busqueda reporte
        $p = (!empty($pag))? $pag: 1;
        $qyp = new  Solicitud(SERVIDOR,USUARIO,CLAVE,BASE,PUERTO);
        $u = new Usuario(SERVIDOR,USUARIO,CLAVE,BASE,PUERTO);
        $idusu = (!empty($_SESSION['id']))? $_SESSION['id']: 0 ;
        $rol = $qyp->obtenerRol($_SESSION['rol_usuario_id']);
        if($rol == 2 || $rol == 3){
                if(!empty($busca)){
                    $solicitudes = $qyp->datosBusqueda($_SESSION['rol_usuario_id'],$_POST,$_SESSION['edo_rep'],$busca);
                }else{
                    $solicitudes = $qyp->datosBusqueda($_SESSION['rol_usuario_id'],$_POST,$_SESSION['edo_rep']);
                }
                $cabecera = $qyp->daCabeceraB($_SESSION['rol_usuario_id']);
        }
        else if($rol == 1 || $rol == 5){
                if(!empty($busca)){
                       $solicitudes = $qyp->datosBusqueda($_SESSION['rol_usuario_id'],$_POST,null,$busca);  
                }else{
                     $solicitudes = $qyp->datosBusqueda($_SESSION['rol_usuario_id'],$_POST);     
                }
                $cabecera = $qyp->daCabeceraB($_SESSION['rol_usuario_id']);
        }
        $totalN = count($solicitudes);
        if($totalN > 0){
                $tab = new Tabulador($solicitudes,$cabecera,$p,50,array(0,0,0,0,0),1,array());
                echo '<div style="width:100%;">';
                $tab->muestraTabla();
                echo '  <br/><br/><div class="col-md-12 text-right"><button type="button" class="btn btn-default" id="reporte_bus" style="font-color:green;"><img src="includes/img/excel.png"  class="IMGicono"  style="width:25px;" />&nbsp;Generar </button></div><br/><br/>
                      </div><br/>
                ';
                echo '<script>paginadorEvBus();eventosBusquedaSolDatos();$("#reporte_bus").show();</script>';
        }else{
            echo '<div class="alert alert-warning text-center"><i>Sin resultados</i></div>';
            echo '<script>$("#reporte_bus").hide();</script>';
        }       
}else if($opcion == 18){ //mostrar Involucrados
        $q = new Queja(SERVIDOR,USUARIO,CLAVE,BASE,PUERTO);
        $cabecera = array("Nombre","Sexo","Instancia","Uniforme","Vehiculo");
        //echo "--".$quejaId."--";
        if(!empty($quejaId)){
                //echo "aqui si entra"; echo "---{".$huerfano."}----";
               $involucrados = $q->mostrarInvolQuej($quejaId,$huerfano);
        }else{
               $involucrados = $q->mostrarInvolCve($huerfano);
        }
        $totalI = count($involucrados);
        $btnEl = 1;
        $enlace = (!empty($enlace))? $enlace : 0;
        if($totalI > 0){
                $tab = new Tabulador($involucrados,$cabecera,1,10,array(0,$enlace,0,$btnEl,0),1,array(5));
                        echo '<div style="width:100%;">';
                $tab->muestraTabla();
                echo '</div><br/>
                <script>paginadorEvBus();eliminaInvolucrado();</script>
                ';
        }else{
             echo '<div class="alert alert-warning text-center"><i>Sin involucrados</i></div>';   
        }
} else if($opcion == 19){// agregar involucrado
        //print_r($_POST);
        $_SESSION['cveHu'] = $cveHuerfanos;
        $q = new Queja(SERVIDOR,USUARIO,CLAVE,BASE,PUERTO);
        $res["estatus"] = $q->agregarInvolucrado($_POST);
        echo json_encode($res);
        
}else if($opcion == 20){ //eliminar involucrado
        $q = new Queja(SERVIDOR,USUARIO,CLAVE,BASE,PUERTO);
        if(!empty($queja)){
               $res['estatus'] = $q->eliminarInvolucrado(1,$sel);
        }else{
               $res['estatus'] = $q->eliminarInvolucrado(0,$sel);
        }
        echo json_encode($res);     
}else if($opcion == 21){// mostrar testigo
        $q = new Queja(SERVIDOR,USUARIO,CLAVE,BASE,PUERTO);
        $cabecera = array("Nombre","Telef&oacute;no","Correo");
        if(!empty($quejaId)){
               $testigos = $q->mostrarTestigoQuej($quejaId,$huerfano);
        }else{
               $testigos = $q->mostrarTestigoCve($huerfano);
        }
        $totalt = count($testigos);
        $btnEl = 1;
        if($totalt > 0){
                $tab = new Tabulador($testigos,$cabecera,1,10,array(0,$enlace,0,$btnEl,0),1,array(6));
                        echo '<div style="width:100%;">';
                $tab->muestraTabla();
                echo '</div><br/>
                <script>paginadorEvBus();eliminaTestigo();</script>
                ';
        }else{
             echo '<div class="alert alert-warning text-center"><i>Sin Testigos</i></div>';   
        }
        
}else if($opcion == 22){// agregar Testigo
        // print_r($_POST);
        $_SESSION['cveHu'] = $cveHuerfanos;
        $q = new Queja(SERVIDOR,USUARIO,CLAVE,BASE,PUERTO);
        $res["estatus"] = $q->agregarTestigo($_POST);
        echo json_encode($res);
        
}else if($opcion == 23){// eliminar Testigo
         $q = new Queja(SERVIDOR,USUARIO,CLAVE,BASE,PUERTO);
        if(!empty($queja)){
               $res['estatus'] = $q->eliminarTestigo(1,$sel);
        }else{
               $res['estatus'] = $q->eliminarTestigo(0,$sel);
        }
        echo json_encode($res);
}else if($opcion == 24){ // ver involucrado
        $q = new Queja(SERVIDOR,USUARIO,CLAVE,BASE,PUERTO);
        $q->datosInvolucrado($cual);
        
}else if($opcion == 25){//modificar involucrado
        //print_r($_POST);
        $_SESSION['cveHu'] = $cveHuerfanos;
        $q = new Queja(SERVIDOR,USUARIO,CLAVE,BASE,PUERTO);
        $res = $q->actualizaInvolucrado($_POST);
        echo json_encode($res);
        
}else if($opcion == 26){ //ver testigo
        $q = new Queja(SERVIDOR,USUARIO,CLAVE,BASE,PUERTO);
        $q->datosTestigo($cual);
}else if($opcion == 27){ // modificar testigo
        $_SESSION['cveHu'] = $cveHuerfanos;
        $q = new Queja(SERVIDOR,USUARIO,CLAVE,BASE,PUERTO);
        $res = $q->actualizaTestigo($_POST);
        echo json_encode($res);
}


?>