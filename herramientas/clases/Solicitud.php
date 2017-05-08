<?php
error_reporting(E_ALL);
ini_set('display_errors','1');

class Solicitud extends ConexionMySQL{
    private $id;
    private $tipo_registro_operacion_id;
    private $fecha_recepcion;
    private $medio_recepcion_id;
    private $fecha_hechos;
    private $estatus;
    private $pais_hechos_id;
    private $estado_hechos_id;
    private $ciudad_hechos_id;
    private $causa;
    private $otra_causa;
    private $lugar_hechos;
    private $anonimo;
    private $solicitante; // TABLA PERSONA
    private $usuario_id; // TABLA USUARIO
    private $folio_id; //TABLA FOLIO
    private $folio_cadena; //TABLA FOLIO
    private $aplica_estado_id; // TABLA ESTADOS
    private $monitoreable;
    private $nombre_persona;
    private $apellidos_persona;
    private $sexo_persona;
    private $pais_origen_persona;
    private $estado_origen_persona;
    private $ciudad_origen_persona;
    private $telefono_persona;
    private $correo_persona;
    private $direccion_persona;
    public $fecha_hoy;
    
   
    public function __construct($serv,$usua,$clav,$base='',$puerto=''){
        parent::__construct($serv,$usua,$clav,$base,$puerto);
        date_default_timezone_set('America/Mexico_City');
    }
    function obtenerRol($rol){
        $r = 1;
        for($i = $r; $i < 10; $i++ ){
            if(md5($i) == $rol){
                $ro = $i;
            }
        }
        return $ro;
    }
    
    public function generaFolio(){
        $sqlFolio = "insert into folio_operacion values(null,%d,null);";
        $this->folio_id = $this->query(sprintf($sqlFolio,$this->tipo_registro_operacion_id),'id');
        $num_folio = (string) $this->folio_id;
        $tam = strlen($num_folio);
        $cadfol = "";
        if($tam < 7){
            for($i = $tam; $i < 7; $i++ ){
                $cadfol .= "0";
            }
            $num_folio = $cadfol.$num_folio;
        }
        $this->folio_cadena = $num_folio;
        $upFol = "update folio_operacion set numero_folio = '".$num_folio."' where id = ".$this->folio_id.";";
        $this->query($upFol,'');
    }
    
    public function iniciaQuejoso($info){
        $this->solicitante = (!empty($info['id_solicitante']))? $info['id_solicitante'] : 0;
        $this->nombre_persona = (!empty($info['nombreq']))? utf8_decode(trim($info['nombreq'])) : '';
        $this->apellidos_persona = (!empty($info['apellidosq']))? utf8_decode(trim($info['apellidosq'])) : '';
        $this->sexo_persona = (!empty($info['sexoq']))? $info['sexoq'] : 'null';
        $this->pais_origen_persona = (!empty($info['pais_origen']))? $info['pais_origen']: "null";
        $this->estado_origen_persona = (!empty($info['estado_origen']))? $info['estado_origen']: "null";
        $this->ciudad_origen_persona = (!empty($info['ciudad_origen']))? $info['ciudad_origen']: "null";
        $this->correo_persona = (!empty($info['correoq']))? trim($info['correoq']): "";
        $this->telefono_persona = (!empty($info['telefonoq']))? trim($info['telefonoq']): "";
        $this->direccion_persona = (!empty($info['direccionq']))? utf8_decode(trim($info['direccionq'])): "";
        $this->aplica_estado_id = (!empty($info['direccionq']))? utf8_decode(trim($info['direccionq'])): "";
    }
    
    public function agregaQuejoso(){
        $sqlAgreQso = "insert into persona values(null,'%s','%s',%s,%s,%s,%s,null,null,'%s','%s','%s');";
        $this->solicitante = $this->query(sprintf($sqlAgreQso,$this->nombre_persona,$this->apellidos_persona,$this->sexo_persona,$this->pais_origen_persona,$this->estado_origen_persona,$this->ciudad_origen_persona,$this->telefono_persona,$this->correo_persona,$this->direccion_persona),'id');
        if(!empty($this->solicitante)&& $this->solicitante != 0){
            return true;
        }else{
            return false;
        }
    }
    
    public function iniciarSolicitud($info){
        $this->id = (!empty($info['id_solicitud']))? $info['id_solicitud']: 0;
        $this->tipo_registro_operacion_id = $info['tipo_registro'];
        $fecha_rec = new DateTime($info['fecha_recepcion']);
        $this->fecha_recepcion = $fecha_rec->format('Y-m-d');
        $this->estatus = (!empty($info['estatus_peticion']))? $info['estatus_peticion'] : 1;
        $this->medio_recepcion_id = $info['medio_recepcion'];
        if(!empty($info['fecha_hechos'])){
            $fecha_hec = new DateTime($info['fecha_hechos']);
            $this->fecha_hechos = $fecha_hec->format('Y-m-d');
        }else{
            $this->fecha_hechos = '0000-00-00';
        }        
        $this->pais_hechos_id = (!empty($info['pais_hechos']))? $info['pais_hechos']: "null";
        $this->estado_hechos_id = (!empty($info['estado_hechos']))? $info['estado_hechos']: "null";
        $this->ciudad_hechos_id = (!empty($info['ciudad_hechos']))? $info['ciudad_hechos']: "null";
        $this->causa = $info['causa'];
        $this->otra_causa = (!empty($info['otra_causa']))? $info['otra_causa']: '';
        $this->lugar_hechos = (!empty($info['lugar_hechos']))? $info['lugar_hechos']: '';
        $this->anonimo = (!empty($info['anonimo']))? 1: 0;
        $this->aplica_estado_id = (!empty($info['id_estado_aplica']))? $info['id_estado_aplica'] : $this->aplica_estado_id;
        $this->fecha_hoy = new DateTime();
    }
    
    public function agregarSolicitud(){
        $sqlAgregaSol = "insert into solicitud values(null,%d,'%s',%d,'%s',%s,%s,%s,%d,'%s','%s',%d,%d,%d,%d,%d,null,'%s');";
        $sqlAgregaSol = sprintf($sqlAgregaSol,$this->tipo_registro_operacion_id,$this->fecha_recepcion,$this->medio_recepcion_id,$this->fecha_hechos,$this->pais_hechos_id,$this->estado_hechos_id,$this->ciudad_hechos_id,$this->causa,$this->otra_causa,$this->lugar_hechos,$this->anonimo,$this->solicitante,$this->usuario_id,$this->folio_id,$this->aplica_estado_id,$this->fecha_hoy->format('Y-m-d'));
        $this->id = $this->query($sqlAgregaSol,'id');
        if(!empty($this->id) && $this->id != 0){
            return true;
        }else{
            return false;
        }
    }
    
    public function agregarEstatus($rol){
        $sqlEstatus = "insert into historial_estatus values(null,'%s',%d,%d,%d,%d,1,null);";
        if($rol == 5){ $rol = 1;}
        $idestatus = $this->query(sprintf($sqlEstatus,$this->fecha_hoy->format('Y-m-d H:i'),$this->id,$this->estatus,$this->usuario_id,$rol),'id');
        if(!empty($idestatus)){
            return true;
        }else{
            return false;
        }
    }
       
     public function creaSolicitud($info,$idusu_reg,$estado, $rol){
        $resSol = array('estatus'=>0,'log'=>'');
        $this->iniciaQuejoso($info);
        if($this->agregaQuejoso()){
            $this->usuario_id = $idusu_reg;
            $this->aplica_estado_id = $estado;
            $this->iniciarSolicitud($info);
            $this->generaFolio();
            if($this->agregarSolicitud()){
                if($this->agregarEstatus($rol)){
                    $resSol['estatus'] = 1;
                    $resSol['log'] .= "Solicitud Agregada.";
                }else{
                    $resSol['estatus'] = 0;
                $resSol['log'] .= "Estatus NO Agregado.";
                }
                
            }else{
                $resSol['estatus'] = 0;
                $resSol['log'] .= "Solicitud NO Agregada.";
            }
        }else{
            $resSol['estatus'] = 0;
            $resSol['log'] .= "No agrego quejoso.";
        }
        return $resSol;
    }
    
    
    public function cargarArchivo($temporal,$url,$nombre,$urlb,$tipo){
        $res = array();
        $id_evidencia = 0;
        $nombre_arch = substr($this->fecha_hoy->format('d-m-Y'), 0, 2).substr($this->fecha_hoy->format('d-m-Y'), 3, 2).substr($this->fecha_hoy->format('d-m-Y'), 8, 2);
        $nombre_arch .= $this->id.".";
        $cadena_desc = explode('.',$nombre);
        $nombre_arch .= strtolower($cadena_desc[(count($cadena_desc)-1)]);
        $cont = 1;
        while(file_exists($url.$nombre_arch)){
            $nombre_arch = $cont."_".$nombre_arch;
            $cont++;
        }
        if(move_uploaded_file($temporal, $url.$nombre_arch)){
             $sqlNvoArch = "insert into evidencia(id,nombre_arch,ruta_arch,fecha_carga,tipo_evidencia_id) values(null,'%s','%s','%s',%d);";
             $id_evidencia = $this->query(sprintf($sqlNvoArch,$nombre_arch,$urlb,$this->fecha_hoy->format('Y-m-d'),$tipo),'id');
             if($id_evidencia != 0 && $id_evidencia != ''){
                $res['estatus_evidencia'] = 1;
                $res['log'] = 'archivo cargado e insertado';
                $res['id_evidencia'] = $id_evidencia;
             }else{
                $res['estatus_evidencia'] = 0;
                $res['log'] = 'No inserto archivo';
             }
         }else{
            $res['estatus_evidencia'] = 0;
            $res['log'] = 'No cargo archivo';
         }
         return $res;
    }
    
     public function modificaArchivo($temporal,$url,$nombre,$id_cambio){
        $res = array();
        $nombre_arch = substr($this->fecha_hoy->format('d-m-Y'), 0, 2).substr($this->fecha_hoy->format('d-m-Y'), 3, 2).substr($this->fecha_hoy->format('d-m-Y'), 8, 2);
        $nombre_arch .= $this->id."act.";
        $cadena_desc = explode('.',$nombre);
        $nombre_arch .= strtolower($cadena_desc[(count($cadena_desc)-1)]);
        $cont = 1;
        while(file_exists($url.$nombre_arch)){
            $nombre_arch = $cont."_".$nombre_arch;
            $cont++;
        }
        if(move_uploaded_file($temporal, $url.$nombre_arch)){
            $sqlArchElim = "select concat('../../',ruta_arch,nombre_arch) 'archivo' from evidencia where id = ".$id_cambio.";";
            $archivodel = $this->query($sqlArchElim,'arregloUnicoAsoc');
            if(file_exists($archivodel['archivo'])){
                if(unlink($archivodel['archivo'])){
                    $res['estatus_evidencia'] = 0;
                    $res['log'] = 'no se pudo eliminar el archivo';
                }else{
                    $res['estatus_evidencia'] = 0;
                    $res['log'] = 'no se encontro el archivo';
                }
            }
            $sqlUpdateArch = "update evidencia set nombre_arch = '".$nombre_arch."' where id = ".$id_cambio.";";
            if($this->query($sqlUpdateArch,'')){
                $res['estatus_evidencia'] = 1;
                $res['log'] = 'archivo cargado y modificado';
             }else{
                $res['estatus_evidencia'] = 0;
                $res['log'] = 'No modifico archivo';
             }
         }else{
            $res['estatus_evidencia'] = 0;
            $res['log'] = 'No cargo archivo';
         }
         return $res;
    }
    
    public function getIdSol(){
        return $this->id;
    }
    
     public function getIdFolio(){
        return $this->folio_cadena;
    }
    
    
    
    public function basuraHuerfanos($cveH){
        //print_r($_SESSION);
      // unset($_SESSION['involucradoMod']);
       //unset($_SESSION['testigoElim']);
        if(!empty($_SESSION['cveHu'])){
            if($_SESSION['cveHu'] != $cveH){
                //involucrados eliminados
                if(!empty($_SESSION['involucradoElim']) && count($_SESSION['involucradoElim']) > 0){
                    $involucradosDel = $_SESSION['involucradoElim'];
                    for($i = 0; $i < count($involucradosDel); $i++){
                        $idvehiculonvoD = "null";
                        if($involucradosDel[$i]['tenia_vehiculo'] == 1){
                            $sqlInfoVeD = "insert into informacion_vehiculo values(null,'%s','%s','%s');";
                            $idvehiculonvoD = $this->query(sprintf($sqlInfoVeD,$involucradosDel[$i]['descripcion'],$involucradosDel[$i]['placas'],$involucradosDel[$i]['color']),'id');
                        }
                        $edadD = (!empty($involucradosDel[$i]['edad_aprox']))? $involucradosDel[$i]['edad_aprox'] : 'null' ;
                        $estaturaD = (!empty($involucradosDel[$i]['estatura_aprox']))? $involucradosDel[$i]['estatura_aprox'] : 'null';
                        $sqlInvDel = "insert into involucrado values(null,'%s',%d,'%s','%s','%s',%s,%s,'%s',%d,'%s','%s','%s','%s','%s',%s,'%s',%d);";
                        $id_involucradoDel = $this->query(sprintf($sqlInvDel,$involucradosDel[$i]['nombre'],$involucradosDel[$i]['sexo_id'],$involucradosDel[$i]['tez'],
                                                        $involucradosDel[$i]['complexion'],$involucradosDel[$i]['color_ojos'],$edadD,$estaturaD,
                                                        $involucradosDel[$i]['cargo'],$involucradosDel[$i]['dependencia_id'],$involucradosDel[$i]['otra_dependencia'],$involucradosDel[$i]['num_identificacion'],
                                                        $involucradosDel[$i]['uniforme'],$involucradosDel[$i]['senias_particulares'],$involucradosDel[$i]['tenia_vehiculo'],$idvehiculonvoD,$involucradosDel[$i]['clave'],$involucradosDel[$i]['activo']),'id');
                        $sqlUniSol = "insert into involucrados_queja values(null, ".$involucradosDel[$i]['informacion_queja_id'].",".$id_involucradoDel.");";
                        $this->query($sqlUniSol,'');
                        //-------------------------------cambios id------------------------------------------------------------
                        if(!empty($_SESSION['involucradoMod']) && count($_SESSION['involucradoMod']) > 0){
                            $iMod = $_SESSION['involucradoMod'];
                            for($j = 0; $j < count($iMod); $j++){
                                if($iMod[$j]['id'] == $involucradosDel[$i]['id']){
                                    $iMod[$j]['id'] = $id_involucradoDel;
                                } 
                                if($iMod[$j]['informacion_vehiculo_id'] == $involucradosDel[$i]['informacion_vehiculo_id']){
                                    $iMod[$j]['informacion_vehiculo_id'] = $idvehiculonvoD;
                                }
                            }
                            $_SESSION['involucradoMod'] = $iMod;
                        }
                        if(!empty($_SESSION['involucrado']) && count($_SESSION['involucrado']) > 0){
                            for($k = 0; $k < count($_SESSION['involucrado']); $k++){
                                 if($_SESSION['involucrado'][$k] == $involucradosDel[$i]['id']){
                                    $_SESSION['involucrado'][$k] = $id_involucradoDel;
                                } 
                            }
                        }
                        //------------------------------------------------------------------------------------------------------
                    }
                    unset($_SESSION['involucradoElim']);
                }
                
                //Involucrados Modificados
                if(!empty($_SESSION['involucradoMod']) && count($_SESSION['involucradoMod']) > 0){
                    $involucradosMod = $_SESSION['involucradoMod'];
                    for($i = (count($involucradosMod)-1); $i >= 0; $i--){
                        $sqlMod = "select i.*, iv.descripcion,iv.placas,iv.color from involucrado i left join informacion_vehiculo iv on i.informacion_vehiculo_id = iv.id where i.id = ".$involucradosMod[$i]['id'].";";
                        $involucradoModAct = $this->query($sqlMod,'arregloUnicoAsoc');
                        if(count($involucradoModAct) > 0){
                            $agregaDatVe = "";
                            if($involucradosMod[$i]['tenia_vehiculo'] == 1){
                                if($involucradoModAct['tenia_vehiculo'] != 1){
                                    $sqlInfoVe = "insert into informacion_vehiculo values(null,'%s','%s','%s');";
                                    $idvehiculonvo = $this->query(sprintf($sqlInfoVe,$involucradosMod[$i]['descripcion'],$involucradosMod[$i]['placas'],$involucradosMod[$i]['color']),'id');
                                    $agregaDatVe = ",informacion_vehiculo_id = ".$idvehiculonvo." ";
                                }else{
                                    $sqlUpVe = "update informacion_vehiculo set descripcion ='".$involucradosMod[$i]['descripcion']."', placas = '".$involucradosMod[$i]['placas']."', color = '".$involucradosMod[$i]['color']."' where id = ".$involucradosMod[$i]['informacion_vehiculo_id'].";";
                                    $this->query($sqlUpVe,'');
                                    $info_vehiculo_id = $involucradosMod[$i]['informacion_vehiculo_id'];
                                    $agregaDatVe = ",informacion_vehiculo_id = ".$info_vehiculo_id." ";
                                }
                            }else{
                                if($involucradoModAct['tenia_vehiculo'] == 1){
                                    $delInfoVe = "delete from informacion_vehiculo where id = ".$involucradoModAct['informacion_vehiculo_id'].";";
                                    $agregaDatVe = ",informacion_vehiculo_id = null ";
                                }
                            }
                            $edad = (!empty($involucradosMod[$i]['edad_aprox']))? $involucradosMod[$i]['edad_aprox'] : 'null' ;
                            $estatura = (!empty($involucradosMod[$i]['estatura_aprox']))? $involucradosMod[$i]['estatura_aprox'] : 'null';
                            $sqlActInvolucradoTmp = "UPDATE involucrado set nombre = '".$involucradosMod[$i]['nombre']."', sexo_id = ".$involucradosMod[$i]['sexo_id'].", tez = '".$involucradosMod[$i]['tez']."',
                            complexion = '".$involucradosMod[$i]['complexion']."', color_ojos = '".$involucradosMod[$i]['color_ojos']."', edad_aprox = ".$edad.", estatura_aprox = ".$estatura.",
                            dependencia_id = ".$involucradosMod[$i]['dependencia_id'].", otra_dependencia = '".$involucradosMod[$i]['otra_dependencia']."', cargo = '".$involucradosMod[$i]['cargo']."', num_identificacion = '".$involucradosMod[$i]['num_identificacion']."',
                            uniforme = '".$involucradosMod[$i]['uniforme']."', senias_particulares = '".$involucradosMod[$i]['senias_particulares']."', tenia_vehiculo = '".$involucradosMod[$i]['tenia_vehiculo']."' ".$agregaDatVe."
                            where id = ".$involucradosMod[$i]['id'].";";
                            $this->query($sqlActInvolucradoTmp,'');
                            if(!empty($delInfoVe)){
                               $this->query($delInfoVe,'');
                            }
                        }
                    }
                    unset($_SESSION['involucradoMod']);
                }
                //Involucrados agregados
                if(!empty($_SESSION['involucrado']) && count($_SESSION['involucrado']) > 0){
                    for($i = 0; $i < count($_SESSION['involucrado']); $i++){
                        $sqlExiste = "select count(*) 'total' from involucrados_queja where involucrado_id = ".$_SESSION['involucrado'][$i].";";
                        $tot = $this->query($sqlExiste,'registro');
                        if($tot['total'] == 0){
                            $delInv = "delete from involucrado where id = ".$_SESSION['involucrado'][$i].";";
                            $this->query($delInv,'');
                            if(!empty($_SESSION['vehiculo'][$i])){
                                $delInv = "delete from informacion_vehiculo where id = ".$_SESSION['vehiculo'][$i].";";
                                $this->query($delInv,'');
                            }
                        }
                    }
                }
                
                
                //testigo eliminado
                 if(!empty($_SESSION['testigoElim']) && count($_SESSION['testigoElim']) > 0 && !empty($_SESSION['testigoElim'][0])){
                    $testigosDel = $_SESSION['testigoElim'];
                    for($i = 0; $i < count($testigosDel); $i++){
                        
                        $sqlTest = "insert into testigo values(null,'%s','%s','%s','%s',%d);";
                        $id_testigoDel = $this->query(sprintf($sqlTest,$testigosDel[$i]['nombre'],$testigosDel[$i]['telefono'],$testigosDel[$i]['correo'],$testigosDel[$i]['clave'],$testigosDel[$i]['activo']),'id');

                        $sqlUniSolT = "insert into testigo_queja values(null, ".$testigosDel[$i]['informacion_queja_id'].",".$id_testigoDel.");";
                        $this->query($sqlUniSolT,'');
                        
                        //-------------------------------cambios id------------------------------------------------------------
                        if(!empty($_SESSION['testigoMod']) && count($_SESSION['testigoMod']) > 0){
                            $tMod = $_SESSION['testigoMod'];
                            for($j = 0; $j < count($tMod); $j++){
                                if($tMod[$j]['id'] == $testigosDel[$i]['id']){
                                    $tMod[$j]['id'] = $id_testigoDel;
                                } 
                            }
                            $_SESSION['testigoMod'] = $tMod;
                        }
                        if(!empty($_SESSION['testigo']) && count($_SESSION['testigo']) > 0){
                            for($k = 0; $k < count($_SESSION['testigo']); $k++){
                                 if($_SESSION['testigo'][$k] == $testigosDel[$i]['id']){
                                    $_SESSION['testigo'][$k] = $id_testigoDel;
                                } 
                            }
                        }
                        //------------------------------------------------------------------------------------------------------
                    }
                    unset($_SESSION['testigoElim']);
                }
                
                //Testigos Modificados
                if(!empty($_SESSION['testigoMod']) && count($_SESSION['testigoMod']) > 0){
                    $testigoMod = $_SESSION['testigoMod'];
                    for($i = (count($testigoMod)-1); $i >= 0; $i--){
                        $sqlModTes = "select t.* from testigo t where t.id = ".$testigoMod[$i]['id'].";";
                        $testigoModAct = $this->query($sqlModTes,'arregloUnicoAsoc');
                        if(count($testigoModAct) > 0){
                            $sqlActTestigoTmp = "UPDATE testigo set nombre = '".$testigoMod[$i]['nombre']."', telefono = '".$testigoMod[$i]['telefono']."',
                            correo = '".$testigoMod[$i]['correo']."',clave = '".$testigoMod[$i]['clave']."', activo = ".$testigoMod[$i]['activo']."
                            where id = ".$testigoMod[$i]['id'].";";
                            $this->query($sqlActTestigoTmp,'');
                        }
                    }
                    unset($_SESSION['testigoMod']);
                }
                
                //testigos agregados
                if(!empty($_SESSION['testigo']) && count($_SESSION['testigo']) > 0){
                    for($i = 0; $i < count($_SESSION['testigo']); $i++){
                        $sqlExisteTes = "select count(*) 'total' from testigo_queja where testigo_id = ".$_SESSION['testigo'][$i].";";
                        $tot = $this->query($sqlExisteTes,'registro');
                        if($tot['total'] == 0){
                            $delInv = "delete from testigo where id = ".$_SESSION['testigo'][$i].";";
                            $this->query($delInv,'');
                        }
                    }
                }
                $_SESSION['cveHu'] = $cveH;
                unset($_SESSION['involucrado']);
                unset($_SESSION['vehiculo']);
                unset($_SESSION['testigo']);
            }
        }
    }
    
    public function formSolicitud(){
        $cveHuerf = date('dmYGis').rand(1,1000);
        //print_r($_SESSION);
        $this->basuraHuerfanos($cveHuerf);
        //echo "<br/><br/>";
        // print_r($_SESSION);
        echo '<form role="form" enctype="multipart/form-data" action="herramientas/funciones/solicitud.php" id="qypForm" method="POST" target="opcFrameQYP" >
                <input type="hidden" name="id_solicitud" id="id_solicitud" />
                <input type="hidden" name="folio" id="folio" />
				<input type="hidden" name="opcion" id="opcionEd" />
                <input type="hidden" name="id_solicitante" id="id_solicitanteEd"/>
                <input type="hidden" name="id_queja" id="id_queja" />
                <input type="hidden" name="id_peticion" id="id_peticion" />
                <input type="hidden" name="id_vehiculo" id="id_vehiculo" />
                <input type="hidden" name="id_evidencia_queja" id="id_evidencia_queja" />
                <input type="hidden" name="id_evidencia_peticion" id="id_evidencia_peticion" />
                <input type="hidden" name="id_solicitante_archivo" id="id_solicitante_archivo" />
                <input type="hidden" name="id_alocalizar_archivo" id="id_alocalizar_archivo" />
                <input type="hidden" name="id_estado_aplica" id="id_estado_aplica"/>
                <input type="hidden" name="cveHuerfanos" id="cveHuerfanos" value="'.$cveHuerf.'"/>
                <input type="hidden" name="totInvolucrados" id="totInvolucrados" value="0"/>
                <input type="hidden" name="totTestigos" id="totTestigos" value="0"/>
                <input type="hidden" name="id_involucrado" id="id_involucrado"/>
                 <input type="hidden" name="id_testigo" id="id_testigo"/>
                <div id="quejaypeticion">
                    <h4>Datos generales de la queja o petici&oacute;n de ayuda</h4><br/>
                    <div class="row oculta" id="muestra_folio">
                        <div class="form-group col-md-4">
                            <label for="folio_m" class="control-label">Folio</label>
                            <input type="text" name="folio_m" id="folio_m" class="form-control input-sm" />
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-4">
                            <label for="tipo_registro" class="control-label">Tipo registro<span class="required-tag">*</span>:</label>
                            <select class="form-control input-sm" id="tipo_registro" name="tipo_registro"></select>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="fecha_recepcion" class="control-label">Fecha de recepci&oacute;n<span class="required-tag">*</span>:</label>
                            <div class="input-group date" id="fecha_recepciond">
                                <input type="text" class="form-control input-sm" id="fecha_recepcion" name="fecha_recepcion"/>
                                <span class="input-group-addon glyphicon glyphicon-calendar" id="glyph_recepcion"></span>
                            </div>
                        </div>
                        <div class="form-group col-md-4">
                             <label for="medio_recepcion" class="control-label">Medio de recepci&oacute;n<span class="required-tag">*</span>:</label>
                             <select class="form-control input-sm" id="medio_recepcion" name="medio_recepcion"></select>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="form-group col-md-4">
                            <label for="estatus_peticion" class="control-label">Estatus<span class="required-tag">*</span>:</label>
							<select class="form-control input-sm " id="estatus_peticion" name="estatus_peticion"></select>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="fecha_hechos" class="control-label">Fecha de los hechos:</label>
                            <div class="input-group" id="fecha_hechosd">
                                <input type="text" class="form-control input-sm queja" id="fecha_hechos" name="fecha_hechos"/>
                                <span class="input-group-addon glyphicon glyphicon-calendar" id="glyph_hechos"></span>
                            </div>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="pais_hechos" class="control-label">Pa&iacute;s de los hechos:</label>
                            <select class="form-control input-sm queja" id="pais_hechos" name="pais_hechos"></select>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="form-group col-md-4">
                            <label for="estado_hechos" class="control-label">Estado de los hechos:</label>
                            <select class="form-control input-sm queja" id="estado_hechos" name="estado_hechos"></select>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="ciudad_hechos" class="control-label">Ciudad/Municipio de los hechos:</label>
                            <select class="form-control input-sm queja" id="ciudad_hechos" name="ciudad_hechos"></select>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="causa" class="control-label">Causa<span class="required-tag">*</span>:</label>
                            <select class="form-control input-sm" id="causa" name="causa"></select>
                        </div>
                    </div>
                    <div id="identificaciones_causa" class="oculta">
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="id_solicitante_a" class="control-label">Identificaci&oacute;n solicitante<span class="required-tag">*</span>:</label>
                                    <div class="fileC"><input type="file" id="id_solicitante_a" class="fileimage" name="id_solicitante_a"/></div>
                                    <div class="oculta contArch" id="id_solicitante_aCont">
                                        <div id="pdfsolicitanteCont" class="oculta contArch">
                                            <div class="panel panel-default">
                                                <div class="panel-body">
                                                    <iframe style="width:100%;height:250px;background:silver;" id="id_solicitante_aPDF" name="pdfcont" src=""></iframe>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="imgsolicitanteCont" class="apareceImg oculta">
                                            <div class="apareceImg">
                                                <div class="panel panel-default"><div class="panel-body text-center"><img src="" id="id_solicitante_aIMG" class="img-thumbnail" /></div></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="id_alocalizar" class="control-label">Documento de la persona a localizar<span class="required-tag">*</span>:</label>
                                     <div class="fileC"><input type="file" class="fileimage" id="id_alocalizar" name="id_alocalizar" /></div>
                                    <div class="oculta contArch" id="id_alocalizarCont">
                                        <div id="pdfalocalizarCont" class="oculta contArch">
                                            <div class="panel panel-default">
                                                <div class="panel-body">
                                                    <iframe style="width:100%;height:250px;background:silver;" id="id_alocalizarPDF" name="pdfcont" src=""></iframe>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="imgalocalizarCont" class="apareceImg oculta">
                                            <div id="pdfAct" class="apareceImg">
                                                <div class="panel panel-default"><div class="panel-body text-center"><img src="" id="id_alocalizarIMG" class="img-thumbnail" /></div></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    </div>
                    <div class="row oculta" id="otra_causaC">
                        <div class="form-group col-md-8"></div>
                        <div class="form-group col-md-4" >
                           <label for="otra_causa" class="control-label">Otra causa<span class="required-tag">*</span>:</label>
                           <input type="text" class="form-control input-sm" id="otra_causa" name="otra_causa"/>
                        </div>
                    </div>
                     <div class="row">
                        <div class="form-group col-md-12">
                           <label for="lugar_hechos" class="control-label">Lugar de los hechos:</label>
                           <textarea class="form-control input-sm queja conSaltos" rows="4" id="lugar_hechos" name="lugar_hechos" placeholder="Kil&oacute;metro, Aeropuerto, Ventanilla, Aduana, Referencias de ubicaci&oacute;n"></textarea>
                        </div>
                    </div>
                    
                    <br/><h4>Datos del quejoso o interesado</h4><br/>
                    <div class="row">
                        <div class="form-group col-md-4">
                            <label for="anonimo" class="control-label">Persona an&oacute;nima:</label>
                            <input type="checkbox" id="anonimo" name="anonimo" />
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-4">
                             <label for="nombreq" class="control-label">Nombre<span class="required-tag">*</span>:</label>
                            <input type="text" class="form-control input-sm  anonimore" id="nombreq" name="nombreq" />
                        </div>
                        <div class="form-group col-md-4">
                             <label for="apellidosq" class="control-label">Apellidos<span class="required-tag">*</span>:</label>
                            <input type="text" class="form-control input-sm anonimore" id="apellidosq" name="apellidosq"/>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="sexoq" class="control-label ">Sexo<span class="required-tag">*</span>:</label>
                            <select class="form-control input-sm anonimore" id="sexoq" name="sexoq"></select>
                        </div>
                    </div>
                     <div class="row">
                        <div class="form-group col-md-4">
                             <label for="pais_origen" class="control-label">Pa&iacute;s de origen:</label>
                            <select class="form-control input-sm " id="pais_origen" name="pais_origen"></select>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="estado_origen" class=" control-label">Estado de origen:</label>
                            <select class="form-control input-sm " id="estado_origen" name="estado_origen"></select>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="ciudad_origen" class="control-label">Ciudad/Municipio de origen:</label>
                            <select class="form-control input-sm " id="ciudad_origen" name="ciudad_origen"></select>
                        </div>
                    </div>
                    <br/><h4>Datos de contacto del quejoso o interesado </h4>
                    <p class="text-primary alert alert-info" id="obliContacto">Se deber&aacute; capturar al menos uno de los siguientes tres campos.</p>
                     <div class="row">
                        <div class="form-group col-md-12">
                            <label for="direccionq" class="control-label">Direcci&oacute;n completa:</label>
                            <textarea class="form-control input-sm obliC conSaltos" rows="4" id="direccionq" name="direccionq" ></textarea>
                        </div>
                    </div>
                     <div class="row">
                        <div class="form-group col-md-4">
                             <label for="telefonoq" class="control-label">Tel&eacute;fono:</label>
                            <input type="text" class="form-control input-sm obliC" id="telefonoq" name="telefonoq" />
                        </div>
                        <div class="form-group col-md-4">
                            <label for="correoq" class="control-label">Correo:</label>
                            <input type="text" class="form-control input-sm obliC" id="correoq" name="correoq" />
                        </div>                       
                    </div>
                    <br/>
                    <div class="row ocultaVer" >
                        <div class="form-group col-md-8"></div>
                        <div class="form-group col-md-4">
                            <div class="pull-right">
                                <button name="siguienteqyp" class="btn btn-primary" id="siguienteqyp" >Siguiente</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="queja" class="oculta">
                    <div class="page-header ocultaVer"><h1> Queja</h1></div>
                    <h4>Datos del o los servidores p&uacute;blicos o sujetos involucrados</h4>
                    <h5>M&iacute;nimo uno, m&aacute;ximo tres servidores p&uacute;blicos o involucrados</h5><br/>
                    <div id="agregarInvolucradoFrm">
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label class="control-label" for="nombre_servidor">Nombre:</label>
                                <input type="text" name="nombre_servidor" id="nombre_servidor" class="form-control input-sm qja involucradoQja" />
                            </div>
                            <div class="form-group col-md-4">
                                <label class="control-label" for="sexo_servidor">Sexo<span class="required-tag">*</span>:</label>
                                <select class="form-control input-sm qja qjare involucradoQja" name="sexo_servidor" id="sexo_servidor"></select>
                            </div>
                            <div class="form-group col-md-4">
                                <label class="control-label" for="tez_servidor">Tez:</label>
                                <input type="text" class="form-control input-sm qja involucradoQja" name="tez_servidor" id="tez_servidor" />
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label class="control-label" for="complexion_servidor">Complexi&oacute;n:</label>
                                <input type="text" name="complexion_servidor" id="complexion_servidor" class="form-control input-sm qja involucradoQja" />
                            </div>
                            <div class="form-group col-md-4">
                                <label class="control-label" for="ojos_servidor">Color de ojos:</label>
                                <input type="text" name="ojos_servidor" id="ojos_servidor" class="form-control input-sm qja involucradoQja" />
                            </div>
                            <div class="form-group col-md-4">
                                <label class="control-label" for="edad_servidor">Edad aproximada:</label>
                                <input type="text" class="form-control input-sm qja involucradoQja" name="edad_servidor" id="edad_servidor"/>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-4">
                                 <label class="control-label" for="estatura_servidor">Estatura aproximada en cm:</label>
                                <input type="text" name="estatura_servidor" id="estatura_servidor" class="form-control input-sm qja involucradoQja" />
                            </div>
                            <div class="form-group col-md-4">
                                <label class="control-label" for="cargo_servidor">Cargo:</label>
                                <input type="text" class="form-control input-sm involucradoQja" name="cargo_servidor" id="cargo_servidor"/>
                            </div>
                            <div class="form-group col-md-4">
                                <label class=" control-label" for="dependencia_servidor">Instancia involucrada<span class="required-tag">*</span>:</label>
                                <select name="dependencia_servidor" id="dependencia_servidor" class="form-control input-sm qja qjare involucradoQja" ></select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label class="control-label" for="identificacion_servidor">N&uacute;mero de identificaci&oacute;n:</label>
                                <input type="text" name="identificacion_servidor" id="identificacion_servidor" class="form-control input-sm qja involucradoQja" />
                            </div>
                            <div class="form-group col-md-4">
                                 <label class="control-label" for="uniforme_servidor">¿Ten&iacute;a uniforme?<span class="required-tag">*</span>:</label>
                                <select name="uniforme_servidor" id="uniforme_servidor" class="form-control input-sm qja qjare involucradoQja">
                                    <option value="Si">Si</option>
                                    <option value="No" selected="selected">No</option>
                                </select>
                            </div>
                            <div class="form-group col-md-4 oculta" id="otra_dep_queC">
                               <label for="otra_dep_que" class="control-label">Otra instancia<span class="required-tag">*</span>:</label>
                               <input type="text" class="form-control input-sm qja involucradoQja" id="otra_dep_que" name="otra_dep_que"/>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-8">
                                <label class="control-label" for="senias_servidor">Se&ntilde;as particulares:</label>
                                <textarea type="text" class="form-control input-sm qja involucradoQja conSaltos" name="senias_servidor" rows="4" id="senias_servidor"></textarea>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label for="vehiculo_servidor" >¿El servidor ten&iacute;a veh&iacute;culo?</label>
                                <input type="radio" name="vehiculo_servidor" id="vehiculo_servidor" value="1" class="qjare involucradoQja">&nbsp; Si&nbsp&nbsp
                                <input type="radio" name="vehiculo_servidor" id="vehiculo_servidor2" value="0" checked>&nbsp; No
                            </div>
                        </div>
                        <div id="siVehiculo" class="oculta">
                                <div class="row">
                                    <div class="form-group col-md-8">
                                         <label class="control-label" for="desc_vehi_servidor">¿C&oacute;mo era el veh&iacute;culo que usaba?<span class="required-tag">*</span>:</label>
                                        <textarea name="desc_vehi_servidor" id="desc_vehi_servidor" class="form-control qja siveh involucradoQja conSaltos" rows="4"></textarea>
                                    </div>
                                    <div class="form-group col-md-4">
                                         <label class="control-label" for="placas_servidor">Placas:</label>
                                        <input type="text" class="form-control input-sm qja siveh involucradoQja" name="placas_servidor" id="placas_servidor" />
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-4">
                                        <label class="control-label" for="color_vehi_servidor">Color del veh&iacute;culo:</label>
                                        <input type="text" class="form-control input-sm qja siveh involucradoQja" id="color_vehi_servidor" name="color_vehi_servidor" />
                                    </div>
                                </div>
                        </div>
                    </div>    
                    <div class="row" id="btnInvolucrado">
                        <div class="col-md-7 form-group "></div>
                        <div class="col-md-5 form-group text-right">
                            <button name="cancelaModificaInv" id="cancelaModificaInv" class="btn btn-default oculta">Cancelar</button>
                            <button name="modificaInvolucrado" id="modificaInvolucrado" class="btn oculta btn-primary">Actualizar involucrado</button>
                            <button name="agregaInv" id="agregaInv" class="btn btn-primary">Agregar Involucrado</button>
                        </div>
                    </div>
                    <div class="row" id="tablaInvo"></div>
                    
                    <br/><h4>Narraci&oacute;n de los hechos</h4><br/>
                    <div class="row">
                        <div class="form-group col-md-12">
                            <label class="control-label" for="narracion_servidor">Breve descripción de lo ocurrido al paisano:</label>
                            <textarea class="form-control qja conSaltos" name="narracion_servidor" id="narracion_servidor" rows="4"></textarea>
                            <p id="contador_narracion_servidor" class="text-right" style="fint-size:10px"></p>
                        </div>
                        <br/>
                    </div>
                   
                    <div class="row">
                        <div class="form-group col-md-4">
                            <label class="control-label" for="testigos_servidor" >¿Hay testigos?</label>
                            <input type="radio" name="testigos_servidor" id="testigos_servidor" value="1" >&nbsp; Si &nbsp;&nbsp;
                            <input type="radio" name="testigos_servidor" id="testigos_servidor2" value="2" checked>&nbsp; No
                        </div>
                    </div>
                    <div id="siTestigos" class="oculta">
                        <div id="agregarTestigoFrm">
                            <p class="text-primary alert alert-info" id="obliTestigoDiv">Se deber&aacute; capturar correo o telef&oacute;no, no pueden ir vacios ambos.</p>
                            <h5>M&iacute;nimo uno, m&aacute;ximo tres testigos</h5>
                            <div class="row">
                                <div class="form-group col-md-4">
                                    <label class="control-label" for="nombre_testigo">Nombre<span class="required-tag">*</span>:</label>
                                    <input type="text" name="nombre_testigo" id="nombre_testigo" class="form-control qja testigoQja"/>
                                </div>
                                <div class="form-group col-md-4">
                                    <label class="control-label" for="telefono_testigo">Tel&eacute;fono:</label>
                                    <input type="text" class="form-control input-sm qja testigoQja obliTestQueja" name="telefono_testigo" id="telefono_testigo" />
                                </div>
                                <div class="form-group col-md-4">
                                    <label class="control-label" for="correo_testigo">Correo:</label>
                                    <input type="text" class="form-control input-sm qja testigoQja obliTestQueja" id="correo_testigo" name="correo_testigo" />
                                </div>
                            </div>
                            <div class="row" id="btnTestigo">
                                <div class="col-md-9 form-group "></div>
                                <div class="col-md-3 form-group text-right">
                                    <button name="cancelaModificaTes" id="cancelaModificaTes" class="btn btn-default oculta">Cancelar</button>
                                    <button name="modificaTes" id="modificaTes" class="btn oculta btn-primary">Actualizar testigo</button>
                                    <button name="agregaTest" id="agregaTest" class="btn btn-primary">Agregar Testigo</button>
                                </div>
                            </div>
                        </div>
                        <div class="row" id="tablaTest"></div>
                    </div>
                    
                    <div class="row">
                        <div class="form-group col-md-8">
                            <label class="control-label" for="pruebas_servidor">Soporte documental:</label>
                            <div class="fileC">
                                <input type="file" class="file qja" name="pruebas_servidor" id="pruebas_servidor" />
                                <span class="help-block">Queja, Constancia telefónica, Fotografías, etc.</span>
                            </div>
                            <div class="oculta contArch" id="pruebas_servidorCont">
                                <div id="pdfcontquejaCont" class="oculta contArch">
                                    <div class="panel panel-default">
                                        <div class="panel-body">
                                            <iframe style="width:100%;height:350px;background:silver;" id="pdfcontqueja" name="pdfcont" src=""></iframe>
                                        </div>
                                    </div>
                                </div>
                                <div class="oculta contArch" id="imgcontquejaCont">
                                    <div id="imgAct" class="apareceImg">
                                        <div class="apareceImg">
                                            <div class="panel panel-default"><div class="panel-body text-center"><img src="" id="imgcontqueja" class="img-thumbnail" /></div></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div><br/>
                    <div class="row ocultaVer">
                        <div class="form-group col-md-8"></div>
                        <div class="form-group col-md-4">
                            <div class="pull-right">
                                <button name="limpiarqja" id="limpiarqja" class="btn btn-default">Limpiar</button>
                                <button name="regresarqja" id="regresarqja" class="btn btn-warning regresar">Regresar</button>
                                <button name="guardarqja" id="guardarqja" class="btn btn-success">Guardar</button>
                            </div>
                        </div>
                    </div> 
                </div>
                <div id="peticion" class="oculta">
                    <div class="page-header ocultaVer"><h1>Petici&oacute;n de ayuda</h1></div>
                    <h4>Datos de la petici&oacute;n de ayuda</h4><br/>
                    <div class="row">
                        <div class="form-group col-md-8">
                            <label class="control-label" for="dependencia_peticion">Instancia contactada<span class="required-tag">*</span>:</label><br/>
                            <select class="form-control rpet" id="dependencia_peticion" name="dependencia_peticion[]" multiple></select>
                        </div>
                        <div class="form-group col-md-4 oculta" id="otra_dep_petC">
                           <label for="otra_dep_pet" class="control-label">Otra instancia<span class="required-tag">*</span>:</label>
                           <input type="text" class="form-control input-sm pet" id="otra_dep_pet" name="otra_dep_pet"/>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-12">
                            <label class="control-label" for="solicitud_peticion">Solicitud<span class="required-tag">*</span>:</label>
                            <textarea class="form-control pet rpet conSaltos" name="solicitud_peticion" id="solicitud_peticion" rows="4"></textarea>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-12">
                            <label class="control-label" for="describe_peticion">Gestiones realizadas<span class="required-tag">*</span>:</label>
                            <textarea class="form-control pet rpet conSaltos" name="describe_peticion" id="describe_peticion" rows="4"></textarea>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="form-group col-md-8">
                            <label class="control-label" for="archivo_peticion">Soporte documental:</label>
                            <div class="fileC"><input type="file" class="file pet" name="archivo_peticion" id="archivo_peticion"/></div>
                            <div class="oculta contArch" id="archivo_peticionCont">
                                <div id="pdfcontpeticionCont" class="oculta contArch">
                                    <div class="panel panel-default">
                                        <div class="panel-body">
                                            <iframe style="width:100%;height:350px;background:silver;" id="pdfcontpeticion" name="pdfcont" src=""></iframe>
                                        </div>
                                    </div>
                                </div>
                                <div class="oculta contArch" id="imgcontpeticionCont">
                                    <div id="imgAct" class="apareceImg">
                                        <div class="apareceImg">
                                            <div class="panel panel-default"><div class="panel-body text-center"><img src="" id="imgcontpeticion" class="img-thumbnail" /></div></div>
                                        </div>
                                    </div>
                                </div>
                            
                            </div>
                        </div>
                    </div><br/>
                     <div class="row ocultaVer">
                        <div class="form-group col-md-8"></div>
                        <div class="form-group col-md-4">
                            <div class="pull-right">
                                <button name="limpiarpet" id="limpiarpet" class="btn btn-default">Limpiar</button>
                                <button name="regresapet" id="regresapet" class="btn btn-warning regresar">Regresar</button>
                                <button name="guardapet" id="guardapet" class="btn btn-success">Guardar</button>
                            </div>
                        </div>
                    </div> 
                </div>
                <div id="justifica_cambios" class="oculta">
                    <div class="row" id="justifica_cambios_componentes">
                        <div class="form-group col-md-12">
                            <label class="control-label" for="justificacion_mod">Justifique cambios<span class="required-tag">*</span>:</label><br/>
                              <textarea class="form-control input-sm pet conSaltos" id="justificacion_mod" name="justificacion_mod"></textarea>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-12">
                            <h1>Hist&oacute;rico de modificaciones
                                <button name="abajo" id="abajo" class="btn btn-default btn-xs"><span class="glyphicon glyphicon-chevron-down"></span></button>
                                <button name="arriba" id="arriba" class="btn btn-default btn-xs oculta"><span class="glyphicon glyphicon-chevron-up"></span></button>
                            </h1>
                            <!-- button type="button" class="close" aria-hidden="true">&times;</button -->
                            <div id="detalleEstatus" class="oculta"></div>
                        </div>
                    </div>
                </div>
                <!-- input type="submit" name="edita" value="enviaEd"/ -->
            </form>
            <div id="mensajeSol"></div>
            
            <iframe id="opcFrameQYP" name="opcFrameQYP" style="display:none;"></iframe>
        ';
    }
    
    
    public function daCabecera($rol){
        $r = $this->obtenerRol($rol);
         if($r == 2 || $r == 3){
            return array('Folio','Fecha recepci&oacute;n','Tipo','Causa');
         }else if($r == 1 || $r == 5){
            return array('Folio','Fecha recepci&oacute;n','Tipo','Causa','Capturado por','Fecha captura','Estatus');
         }else{
            return array();
         }
    }
   public function mostrarBandeja($totalN,$totalOic = null){
        return '
        <div class="list-group">
            <a class="list-group-item list-group-item-success" href="#" id="nuevas"><span class="badge pull-right">'.$totalN.'</span>Nuevas</a>
            <a class="list-group-item" href="#" id="asig_oic"><span class="badge pull-right">'.$totalOic.'</span>Turnadas a OIC</a>
        </div>
        <script>
            $( document ).ready(function() {
                bandeja();
            });
        </script>
        ';
    }
    
    function datosBandeja($rol,$tipo,$estado = null,$busqueda = null){
        $solicitudes = array();
        $r = $this->obtenerRol($rol);
        //echo $r;
        if($r == 2 || $r == 3){//enlace o representante
            switch($tipo){
                case 1 ://nuevos
                    if($busqueda != null){
                    $sqlSol = "select s.id,fo.numero_folio,DATE_FORMAT(s.fecha_recepcion,'%d-%m-%Y') 'registrada',o.nombre_operacion,c.causa
                                from solicitud s inner join operacion o on s.tipo_registro_operacion_id = o.id
                                inner join causa c on c.id = s.causa
                                inner join historial_estatus he on s.id = he.solicitud_id and he.activo = 1 and he.asignado = ".$r."
                                inner join folio_operacion fo on fo.id = s.folio_id where (he.cve_estatus = 1 and s.aplica_estado_id = ".$estado.")
                                and (fo.numero_folio like '%".$busqueda."%' or o.nombre_operacion like
                                '%".$busqueda."%' or c.causa like '%".$busqueda."%' or DATE_FORMAT(s.fecha_recepcion,'%d-%m-%Y') like '%".$busqueda."%')
                                order by fo.numero_folio;";
                                $solicitudes = $this->query($sqlSol,'arregloAsociado');
                    }else{
                        $sqlSol = "select s.id,fo.numero_folio,DATE_FORMAT(s.fecha_recepcion,'%d-%m-%Y') 'registrada',o.nombre_operacion,c.causa
                            from solicitud s inner join operacion o on s.tipo_registro_operacion_id = o.id
                            inner join causa c on c.id = s.causa
                            inner join historial_estatus he on s.id = he.solicitud_id and he.activo = 1 and he.asignado = ".$r."
                            inner join folio_operacion fo on fo.id = s.folio_id where he.cve_estatus = 1 and s.aplica_estado_id = ".$estado."
                            order by fo.numero_folio;";
                            $solicitudes = $this->query($sqlSol,'arregloAsociado');
                            // echo "--<br/>";print_r($solicitudes);
                    }
                break;
                case 2 ://oic
                    if($busqueda != null){
                         $sqlSol = "select s.id,fo.numero_folio,DATE_FORMAT(s.fecha_recepcion,'%d-%m-%Y') 'registrada',o.nombre_operacion,c.causa from solicitud s
                        inner join operacion o on s.tipo_registro_operacion_id = o.id inner join causa c on c.id = s.causa
                        inner join historial_estatus he on s.id = he.solicitud_id and he.activo = 1 and he.asignado = 4 and he.asigno = ".$r."
                        inner join folio_operacion fo on fo.id = s.folio_id where (he.cve_estatus = 4 and s.aplica_estado_id = ".$estado.")
                        and (fo.numero_folio like '%".$busqueda."%' or o.nombre_operacion like
                        '%".$busqueda."%' or c.causa like '%".$busqueda."%' or DATE_FORMAT(s.fecha_recepcion,'%d-%m-%Y') like '%".$busqueda."%')
                        order by fo.numero_folio;";
                         $solicitudes = $this->query($sqlSol,'arregloAsociado');
                    }else{
                        $sqlSol = "select s.id,fo.numero_folio,DATE_FORMAT(s.fecha_recepcion,'%d-%m-%Y') 'registrada',o.nombre_operacion,c.causa from solicitud s
                        inner join operacion o on s.tipo_registro_operacion_id = o.id inner join causa c on c.id = s.causa
                        inner join historial_estatus he on s.id = he.solicitud_id and he.activo = 1 and he.asignado = 4 and he.asigno = ".$r."
                        inner join folio_operacion fo on fo.id = s.folio_id where he.cve_estatus = 4 and s.aplica_estado_id = ".$estado."
                        order by fo.numero_folio;";
                         $solicitudes = $this->query($sqlSol,'arregloAsociado');
                    }
                break;
                default: $solicitudes = null; break;
            }
           
           
        }else if($r == 1 || $r == 5){ //admin o centrales
            switch($tipo){
                case 1 ://nuevos
                    if($busqueda != null){
                       $sqlSol = "select s.id,fo.numero_folio,DATE_FORMAT(he.fecha_actualizacion,'%d-%m-%Y') 'asignada',o.nombre_operacion,c.causa, edo.nombre_estado,DATE_FORMAT(s.fecha_recepcion,'%d-%m-%Y') 'registrada',ep.estatus_peticion from solicitud s
                                    inner join operacion o on s.tipo_registro_operacion_id = o.id inner join causa c on c.id = s.causa
                                    inner join historial_estatus he on s.id = he.solicitud_id and he.asignado = 1 and he.activo = 1
                                    inner join estatus_peticion ep on ep.id = he.cve_estatus
                                    inner join folio_operacion fo on fo.id = s.folio_id
                                    inner join estado edo on edo.id = s.aplica_estado_id
                                    where (he.cve_estatus = 1 or he.cve_estatus = 5)
                                    and (fo.numero_folio like '%".$busqueda."%' or o.nombre_operacion like '%".$busqueda."%'
                                    or c.causa like '%".$busqueda."%' or edo.nombre_estado like '%".$busqueda."%' or ep.estatus_peticion like '%".$busqueda."%'
                                    or DATE_FORMAT(he.fecha_actualizacion,'%d-%m-%Y') like '%".$busqueda."%' or DATE_FORMAT(s.fecha_recepcion,'%d-%m-%Y') like '%".$busqueda."%')
                                    order by fo.numero_folio;";
                        $solicitudes = $this->query($sqlSol,'arregloAsociado');
                    }else{
                         $sqlSol = "select s.id,fo.numero_folio,DATE_FORMAT(he.fecha_actualizacion,'%d-%m-%Y') 'asignada',o.nombre_operacion,c.causa, edo.nombre_estado,DATE_FORMAT(s.fecha_recepcion,'%d-%m-%Y') 'registrada',ep.estatus_peticion from solicitud s
                                    inner join operacion o on s.tipo_registro_operacion_id = o.id inner join causa c on c.id = s.causa
                                    inner join historial_estatus he on s.id = he.solicitud_id and he.asignado = 1 and he.activo = 1
                                    inner join estatus_peticion ep on ep.id = he.cve_estatus
                                    inner join folio_operacion fo on fo.id = s.folio_id
                                    inner join estado edo on edo.id = s.aplica_estado_id
                                    where he.cve_estatus = 1 or he.cve_estatus = 5
                                    order by fo.numero_folio;";
                        $solicitudes = $this->query($sqlSol,'arregloAsociado');
                    }
                break;
                case 2 ://oic
                    if($busqueda != null){
                        $sqlSol = "select s.id,fo.numero_folio,DATE_FORMAT(he.fecha_actualizacion,'%d-%m-%Y') 'asignada',o.nombre_operacion,c.causa, edo.nombre_estado,DATE_FORMAT(s.fecha_recepcion,'%d-%m-%Y') 'registrada',ep.estatus_peticion
                                    from solicitud s inner join operacion o on s.tipo_registro_operacion_id = o.id
                                    inner join causa c on c.id = s.causa
                                    inner join historial_estatus he on s.id = he.solicitud_id and he.asignado = 4 and (he.asigno = 1 or he.asigno = 5) and he.activo = 1
                                    inner join estatus_peticion ep on ep.id = he.cve_estatus
                                    inner join folio_operacion fo on fo.id = s.folio_id
                                    inner join estado edo on edo.id = s.aplica_estado_id
                                    where he.cve_estatus = 4
                                    and (fo.numero_folio like '%".$busqueda."%' or o.nombre_operacion like '%".$busqueda."%'
                                    or c.causa like '%".$busqueda."%' or edo.nombre_estado like '%".$busqueda."%' or ep.estatus_peticion like '%".$busqueda."%'
                                    or DATE_FORMAT(he.fecha_actualizacion,'%d-%m-%Y') like '%".$busqueda."%' or DATE_FORMAT(s.fecha_registro,'%d-%m-%Y') like '%".$busqueda."%')
                                    order by fo.numero_folio;";
                        $solicitudes = $this->query($sqlSol,'arregloAsociado');
                    }else{
                        $sqlSol = "select s.id,fo.numero_folio,DATE_FORMAT(he.fecha_actualizacion,'%d-%m-%Y') 'asignada',o.nombre_operacion,c.causa, edo.nombre_estado,DATE_FORMAT(s.fecha_recepcion,'%d-%m-%Y') 'registrada',ep.estatus_peticion
                                    from solicitud s inner join operacion o on s.tipo_registro_operacion_id = o.id
                                    inner join causa c on c.id = s.causa
                                    inner join historial_estatus he on s.id = he.solicitud_id and he.asignado = 4 and (he.asigno = 1 or he.asigno = 5) and he.activo = 1
                                    inner join estatus_peticion ep on ep.id = he.cve_estatus
                                    inner join folio_operacion fo on fo.id = s.folio_id
                                    inner join estado edo on edo.id = s.aplica_estado_id
                                    where he.cve_estatus = 4
                                    order by fo.numero_folio;";
                        $solicitudes = $this->query($sqlSol,'arregloAsociado');
                    }
                break;
                default: $solicitudes = null; break;
            }
           
        }
        //print_r($solicitudes);
         return $solicitudes;
    }
    
    public function botonesSolSeg($rol,$tipo){
        $r = $this->obtenerRol($rol);
        //echo $r;
        if($r == 2 || $r == 3){//enlace o representante
            switch($tipo){
                case 1 ://nuevos o asignados a dnpp
                    echo '<div class="row">
                            <div class="form-group col-md-6"></div>
                            <div class="form-group col-md-6 text-right">
                                <div>
                                    <!-- button name="rechazar" id="rechazar" class="btn btn-primary"><span class="glyphicon glyphicon-remove"></span>&nbsp;Rechazar</button-->
                                    <button name="enviardnpp" id="enviardnpp" class="btn btn-primary">Enviar a la DNPP</button>
                                    <button name="enviaroic" id="enviaroic" class="btn btn-primary">Turnar a OIC</button>
                                    <button name="concluir" id="concluir" class="btn btn-success">Concluir</button>
                                </div>
                            </div>
                        </div> ';
                        
                break;
                case 2 ://oic
                    echo '<div class="row">
                            <div class="form-group col-md-10"></div>
                            <div class="form-group col-md-2 text-right">
                                <div>
                                    <!-- button name="rechazar" id="rechazar" class="btn btn-primary"><span class="glyphicon glyphicon-remove"></span>&nbsp;Rechazar</button--> 
                                    <button name="concluir" id="concluir" class="btn btn-success">Concluir</button>
                                </div>
                            </div>
                        </div> ';
                break;
                default: break;
            }           
        }else if($r == 1 || $r == 5){ //admin o centrales
            
            switch($tipo){
                case 1 ://nuevos
                        echo '<div class="row">
                            <div class="form-group col-md-7"></div>
                            <div class="form-group col-md-5 text-right">
                                <div>
                                    <button name="rechazar" id="rechazar" class="btn btn-primary">Rechazar</button>
                                    <button name="enviaroic" id="enviaroic" class="btn btn-primary regresar">Turnar a OIC</button>
                                    <button name="concluir" id="concluir" class="btn btn-success">Concluir</button>
                                </div>
                            </div>
                        </div> ';
                break;
                case 2 ://oic
                        echo '<div class="row">
                            <div class="form-group col-md-8"></div>
                            <div class="form-group col-md-4 text-right">
                                <div>
                                    <button name="rechazar" id="rechazar" class="btn btn-primary">Rechazar</button> 
                                    <button name="concluir" id="concluir" class="btn btn-success">Concluir</button>
                                </div>
                            </div>
                        </div> ';
                break;
                default: break;
            }
        }
    }
    
    function asignarDNPP($sol,$usuario,$rol){
        $sqlUp = "update historial_estatus set activo = 0 where solicitud_id = ".$sol.";";
        $this->query($sqlUp,'');
        $sqlEstatus = "insert into historial_estatus values(null,'%s',%d,%d,%d,%d,1,".$rol.");";
        $hoy = new DateTime();
        $idestatus = $this->query(sprintf($sqlEstatus,$hoy->format('Y-m-d H:i'),$sol,5,$usuario,1),'id');
        if($idestatus != 0){
            return true;
        }else{
            return false;
        }
    }
    
    function asignarOIC($sol,$usuario,$rol){
        $sqlUp = "update historial_estatus set activo = 0 where solicitud_id = ".$sol.";";
        $this->query($sqlUp,'');
        $sqlEstatus = "insert into historial_estatus values(null,'%s',%d,%d,%d,%d,1,".$rol.");";
        $hoy = new DateTime();
        $idestatus = $this->query(sprintf($sqlEstatus,$hoy->format('Y-m-d H:i'),$sol,4,$usuario,4),'id');
        if($idestatus != 0){
            return true;
        }else{
            return false;
        }
    }
    
    function concluirSol($sol,$usuario,$rol,$tipo){
        $usu_tipo = ($tipo == 2)? 4 : $rol;
        $asigno = "null";
        if($rol == 2 || $rol == 3){
            if($usu_tipo != 4){
                $asigno = $rol;
            }
        }
        $sqlUp = "update historial_estatus set activo = 0 where solicitud_id = ".$sol.";";
        $this->query($sqlUp,'');
        $sqlEstatus = "insert into historial_estatus values(null,'%s',%d,%d,%d,%d,1,".$asigno.");";
        $hoy = new DateTime();
        $idestatus = $this->query(sprintf($sqlEstatus,$hoy->format('Y-m-d H:i'),$sol,3,$usuario,$usu_tipo),'id');
        if($idestatus != 0){
            return true;
        }else{
            return false;
        }
    }
    function rechazarSol($sol,$usuario,$rol,$tipo){
        $usu_tipo = ($tipo == 2)? 4 : $rol;
        $sqlUp = "update historial_estatus set activo = 0 where solicitud_id = ".$sol.";";
        $this->query($sqlUp,'');
        $sqlEstatus = "insert into historial_estatus values(null,'%s',%d,%d,%d,%d,1,".$rol.");";
        $hoy = new DateTime();
        $idestatus = $this->query(sprintf($sqlEstatus,$hoy->format('Y-m-d H:i'),$sol,6,$usuario,$usu_tipo),'id');
        if($idestatus != 0){
            return true;
        }else{
            return false;
        }
    }
    
    function eliminarSol($sol,$usuario,$rol,$tipo){
        $usu_tipo = ($tipo == 2)? 4 : $rol;
        $sqlUp = "update historial_estatus set activo = 0 where solicitud_id = ".$sol.";";
        $this->query($sqlUp,'');
        $sqlEstatus = "insert into historial_estatus values(null,'%s',%d,%d,%d,%d,1,".$rol.");";
        $hoy = new DateTime();
        $idestatus = $this->query(sprintf($sqlEstatus,$hoy->format('Y-m-d H:i'),$sol,2,$usuario,$usu_tipo),'id');
        if($idestatus != 0){
            return true;
        }else{
            return false;
        }
    }
    
 
    public function llenaFormularioDetalle($solicitud){
        $solicitudP = array();
        $script = "";
        $sqlSol = "select s.*,DATE_FORMAT(s.fecha_recepcion,'%d-%m-%Y') 'recepcionf',DATE_FORMAT(s.fecha_hechos,'%d-%m-%Y') 'hechosf',f.numero_folio,p.nombre_persona,p.apellidos_persona,p.sexo_id,p.pais_origen_id, p.estado_origen_id,p.ciudad_origen_id,p.telefono_persona,p.correo_persona,p.direccion_persona,hs.cve_estatus from solicitud s inner join persona p on s.solicitante = p.id inner join folio_operacion f on f.id = s.folio_id inner join historial_estatus hs on s.id = hs.solicitud_id and activo = 1 where s.id = ".$solicitud.";";
        $solicitudP = $this->query($sqlSol,'arregloUnicoAsoc');
       //print_r($solicitudP);exit();
        if(count($solicitudP) > 0){
            $modificaciones = $this->detalleCambios($solicitudP['folio_id'],$solicitudP['id']);
            $otracausa = (!empty($solicitudP['otra_causa']))? '$("#otra_causa").val("'.$solicitudP['otra_causa'].'");' : '' ;
            $nombreq = (!empty($solicitudP['nombre_persona']))?  "$('#nombreq').val('".utf8_encode($solicitudP['nombre_persona'])."');" : "";
            $apellidosq = (!empty($solicitudP['apellidos_persona']))? " $('#apellidosq').val('".utf8_encode($solicitudP['apellidos_persona'])."');" : "";
            $sexoq = (!empty($solicitudP['sexo_id']))? "$('#sexoq').val(".$solicitudP['sexo_id'].");" : "";
            $paisq = (!empty($solicitudP['pais_origen_id']))?  "$('#pais_origen').val(".$solicitudP['pais_origen_id'].").change();" : "";
            $estadoq = (!empty($solicitudP['estado_origen_id']))? " $('#estado_origen').val(".$solicitudP['estado_origen_id'].").change();" : "";
            $ciudadq = (!empty($solicitudP['ciudad_origen_id']))? "$('#ciudad_origen').val(".$solicitudP['ciudad_origen_id'].");" : "";
            
            if(!empty($solicitudP['direccion_persona'])){
                     $direccionq = " $('#direccionq').val('".utf8_encode(str_replace('<br />','\n',$solicitudP['direccion_persona']))."');";
            }else{
                    $direccionq ="";
            }
            
            $telefonoq = (!empty($solicitudP['telefono_persona']))?  "$('#telefonoq').val('".$solicitudP['telefono_persona']."');" : "";
            $correoq = (!empty($solicitudP['correo_persona']))? " $('#correoq').val('".$solicitudP['correo_persona']."');" : "";
             
            $script .= '<script>
                    $(".ocultaVer").hide();
                    $("#id_solicitud").val('.$solicitudP["id"].');
                    $("#folio_m").val("'.$solicitudP['numero_folio'].'").attr("disabled",true);
                    $("#folio").val('.$solicitudP['folio_id'].');
                    $("#id_solicitanteEd").val('.$solicitudP['solicitante'].');
                    $("#muestra_folio").show();
                    $("#tipo_registro").val('.$solicitudP['tipo_registro_operacion_id'].').change();
                    $("#fecha_recepcion").prop("value","'.$solicitudP['recepcionf'].'");
                    $("#medio_recepcion").val('.$solicitudP['medio_recepcion_id'].');
                    $("#estatus_peticion").val('.$solicitudP['cve_estatus'].');
                    $("#causa").val('.$solicitudP['causa'].').change();
                    $("#detalleEstatus").html("'.$modificaciones.'");
                    '.$otracausa.$nombreq.$apellidosq.$sexoq.$paisq.$estadoq.$ciudadq.$direccionq.$telefonoq.$correoq.'
                    $("#obliContacto").slideUp();
            ';
            if($solicitudP['anonimo'] == 1){
                $script .= "$('#anonimo').click();";
            }        
                    
            if($solicitudP['tipo_registro_operacion_id'] == 1){//queja
                
                $sqldatosqueja = "SELECT iq.* FROM informacion_queja iq where iq.solicitud_id = ".$solicitudP['id'].";";
                $datosqueja = $this->query($sqldatosqueja,'arregloUnicoAsoc');
                //print_r($datosqueja);
                $paish = (!empty($solicitudP['pais_hechos_id']))?  "$('#pais_hechos').val(".$solicitudP['pais_hechos_id'].").change();" : "";
                $estadoh = (!empty($solicitudP['estado_hechos_id']))? " $('#estado_hechos').val(".$solicitudP['estado_hechos_id'].").change();" : "";
                $ciudadh = (!empty($solicitudP['ciudad_hechos_id']))? "$('#ciudad_hechos').val(".$solicitudP['ciudad_hechos_id'].");" : "";
                $cvequeja = ' $("#id_queja").val('.$datosqueja["id"].');';
                $testigos = ($datosqueja['testigos'] == 1)? " $('#testigos_servidor').click();" : " $('#testigos_servidor2').click();";
                if(!empty($datosqueja['hechos'])){
                     $hechosss = " $('#narracion_servidor').val('".utf8_encode(str_replace('<br />','\n',$datosqueja['hechos']))."').change();";
                }else{
                    $hechosss ="";
                }
                
               
                $sqlArchivos = "SELECT e.* FROM evidencia_queja eq inner join evidencia e on eq.evidencia_id = e.id where e.tipo_evidencia_id = %d and eq.queja_id = %d;";
                $sqlEvidenciaQja = sprintf($sqlArchivos,1,$datosqueja['id']);
                $evidencia = $this->query($sqlEvidenciaQja,'arregloUnicoAsoc');
                //print_r($evidencia);
                 if(count($evidencia) > 0){
                    $cadena_desc = explode('.',$evidencia['nombre_arch']);
                    $ext = strtolower($cadena_desc[(count($cadena_desc)-1)]);
                    $script .= '$("#id_evidencia_queja").val('.$evidencia["id"].');';
                    if($ext == 'pdf'){
                        $script .= '$("#pdfcontquejaCont, #pruebas_servidorCont").show();
                              $("#pdfcontqueja").attr("src","'.$evidencia['ruta_arch'].$evidencia['nombre_arch'].'");  ';
                    }else{
                        $script .= '$("#imgcontquejaCont, #pruebas_servidorCont").show();
                              $("#imgcontqueja").attr("src","'.$evidencia['ruta_arch'].$evidencia['nombre_arch'].'");  ';
                    }
                }else{
                    $script .= '$("#pruebas_servidorCont").html("").show().html("No hay Evidencia de soporte documental para esta queja.");';
                }
                $totInvo = "select count(*) 'tin' from involucrados_queja where informacion_queja_id = ".$datosqueja["id"].";";
                $tinvolucrados = $this->query($totInvo,'registro');
                $totTes = "select count(*) 'ttes' from testigo_queja where informacion_queja_id = ".$datosqueja["id"].";";
                $ttestigos = $this->query($totTes,'registro');
                $scveh =  (!empty($_SESSION['cveHu']))? $_SESSION['cveHu'] : '12345';
                $huerfanos = '$("#totInvolucrados").val('.$tinvolucrados["tin"].');$("#totTestigos").val('.$ttestigos["ttes"].'); mostrarInvolucrados('.$datosqueja["id"].','.$scveh.',1); mostrarTestigos('.$datosqueja["id"].','.$scveh.',1);';
                if($tinvolucrados['tin'] == 3){
                    $huerfanos .= '$("#agregaInv").attr("disabled",true).slideUp(); $("#agregarInvolucradoFrm, #btnInvolucrado").slideUp();';
                }
                if($ttestigos['ttes'] == 3){
                     $huerfanos .= '$("#agregaTest").attr("disabled",true).slideUp();$("#agregarTestigoFrm").slideUp();';
                }
                
                if(!empty($solicitudP['lugar_hechos'])){
                     $lugar_hechosM = " $('#lugar_hechos').val('".str_replace('<br />','\n',$solicitudP['lugar_hechos'])."');";
                }else{
                    $lugar_hechosM ="";
                }
                
                $script .= '
                    $("#titulo_f").html("<h1>Detalle de la queja</h1>");
                    $("#queja").show();
                    $("#id_quejaEd").val('.$datosqueja["id"].');
                    $("#fecha_hechos").prop("value","'.$solicitudP['hechosf'].'");
                    '.$paish.$estadoh.$ciudadh.$lugar_hechosM.'
                    validacionQueja();'.
                    $cvequeja.$hechosss.$huerfanos.$testigos;
                    
            }else if($solicitudP['tipo_registro_operacion_id'] == 2){//PETICIÓN DE AYUDA-------------------------------------------------------------------------------------------------
                
                $sqlArchivos = "SELECT e.* FROM evidencia_peticion ep inner join evidencia e on ep.evidencia_id = e.id where e.tipo_evidencia_id = %d and ep.peticion_id = %d;";
                $sqldatospet = "SELECT ip.* FROM informacion_peticion ip where ip.solicitud_id = ".$solicitudP['id'].";";
                $datospet = $this->query($sqldatospet,'arregloUnicoAsoc');
                $script .= '$("#id_peticion").val('.$datospet["id"].');';
                if($solicitudP['causa'] == 18){
                    $sqlSolicitante = sprintf($sqlArchivos,2,$datospet['id']);
                    $Solicitante = $this->query($sqlSolicitante,'arregloUnicoAsoc');
                    $sqlAlocalizar = sprintf($sqlArchivos,3,$datospet['id']);
                    $Alocalizar = $this->query($sqlAlocalizar,'arregloUnicoAsoc');
                    
                    if(count($Solicitante) > 0){
                        $script .= '$("#id_solicitante_archivo").val('.$Solicitante["id"].');';
                        $cadena_descSol = explode('.',$Solicitante['nombre_arch']);
                        $extSol = strtolower($cadena_descSol[(count($cadena_descSol)-1)]);
                        if($extSol == 'pdf'){
                            $script .= '$("#id_solicitante_aCont, #pdfsolicitanteCont").show();
                                  $("#id_solicitante_aPDF").attr("src","'.$Solicitante['ruta_arch'].$Solicitante['nombre_arch'].'");  ';
                        }else{
                            $script .= '$("#id_solicitante_aCont, #imgsolicitanteCont").show();
                                  $("#id_solicitante_aIMG").attr("src","'.$Solicitante['ruta_arch'].$Solicitante['nombre_arch'].'");  ';
                        }
                    }else{
                        $script .= '$("#id_solicitante_aCont").show().html("No se encontro informaci&oacute;n de la identificaci&oacute;n del solicitante");';
                    }
                    if(count($Alocalizar) > 0){
                        $script .= '$("#id_alocalizar_archivo").val('.$Alocalizar["id"].');';
                        $cadena_descAloc = explode('.',$Alocalizar['nombre_arch']);
                        $extAloc = strtolower($cadena_descAloc[(count($cadena_descAloc)-1)]);
                        if($extAloc == 'pdf'){
                            $script .= '$("#id_alocalizarCont, #pdfalocalizarCont").show();
                                  $("#id_alocalizarPDF").attr("src","'.$Alocalizar['ruta_arch'].$Alocalizar['nombre_arch'].'");  ';
                        }else{
                            $script .= '$("#id_alocalizarCont, #imgalocalizarCont").show();
                                  $("#id_alocalizarIMG").attr("src","'.$Alocalizar['ruta_arch'].$Alocalizar['nombre_arch'].'");  ';
                        }
                    }else{
                         $script .= '$("#id_alocalizarCont").show().html("No se encontro informaci&oacute;n de la persona a localizar");';
                    }
                }
                $contSolicitud = $contDescribe = "";
                                
                if(!empty($datospet['solicitud'])){
                     $contSolicitud = " $('#solicitud_peticion').val('".utf8_encode(str_replace('<br />','\n',$datospet['solicitud']))."');";
                }
                if(!empty($datospet['observaciones'])){
                     $contDescribe = " $('#describe_peticion').val('".utf8_encode(str_replace('<br />','\n',$datospet['observaciones']))."');";
                }
                
                $script .= '
                    $("#titulo_f").html("<h1>Detalle de la petici&oacute;n de ayuda</h1>");
                    $("#peticion").show();
                    $("#id_peticion").val('.$datospet["id"].');
                    '.$contSolicitud.$contDescribe;
                $sqlDependencias = "SELECT * FROM dependencia_contactada where peticion_id = ".$datospet['id'].";";
                $dependencias = $this->query($sqlDependencias,'arregloAsociado');
                for($i = 0; $i < count($dependencias); $i++){
                    $script .= '$("option[value=\"'.$dependencias[$i]['dependencia_id'].'\"]", $("#dependencia_peticion")).prop("selected", true);';
                    if($dependencias[$i]['dependencia_id'] == 23){
                        $script .= '$("#otra_dep_pet").val("'.utf8_encode($datospet['otra_dependencia']).'");
                                $("#otra_dep_petC").show();';
                    }
                }
                $sqlEvidencia = sprintf($sqlArchivos,4,$datospet['id']);
                $evidencia = $this->query($sqlEvidencia,'arregloUnicoAsoc');
                if(count($evidencia) > 0){
                    $cadena_desc = explode('.',$evidencia['nombre_arch']);
                    $ext = strtolower($cadena_desc[(count($cadena_desc)-1)]);
                    $script .= '$("#id_evidencia_peticion").val('.$evidencia["id"].');';
                    if($ext == 'pdf'){
                        $script .= '$("#pdfcontpeticionCont, #archivo_peticionCont").show();
                              $("#pdfcontpeticion").attr("src","'.$evidencia['ruta_arch'].$evidencia['nombre_arch'].'");  ';
                    }else{
                        $script .= '$("#imgcontpeticionCont, #archivo_peticionCont").show();
                              $("#imgcontpeticion").attr("src","'.$evidencia['ruta_arch'].$evidencia['nombre_arch'].'");  ';
                    }
                }else{
                    $script .= '$("#archivo_peticionCont").html("").show().html("No hay Evidencia de soporte documental para esta petici&oacute;n de ayuda.");';
                }
                $testigos = '';
            }
            $script .= '  $("#dependencia_peticion").multiselect("refresh"); '.$testigos.'
                            
               </script>';
            
        }else{
            $script .= '<br/><div class="alert alert-warning text-center"><i>Sin resultados</i></div>
                <script>$("#qypForm").slideUp();</script>';
        }
        echo $script;
    }

 //-----Busqueda Y edición ------------------------------------------------------------------------------------------------------------------------------------------------------
 public function construirFolio($folio){
    $num_folio = (string) $folio;
    $tam = strlen($num_folio);
    $cadfol = "";
    if($tam < 7){
        for($i = $tam; $i < 7; $i++ ){
                $cadfol .= "0";
        }
        $f = $cadfol.$num_folio;
    }else{
        $f = $folio;
    }
    return $f;
 }
 
 function formBusqueda($rol){
    if($this->obtenerRol($rol) == 1 || $this->obtenerRol($rol) == 5){
        $estados = '
            <div class="row">
                <div class="form-group col-md-8">
                    <label class="control-label" for="estados_b">Lugar de registro:</label><br/>
                    <select class="form-control" id="estados_b" name="estados_b[]" multiple></select>
                </div>
            </div>';
    }else if($this->obtenerRol($rol) == 2 || $this->obtenerRol($rol) == 3){
        $estados = '';
    }
    
    return '
        <form role="form" action="herramientas/funciones/solicitud.php" id="busSol" method="POST">
            <input type="hidden" name="opcion" id="opcion" value="11"/>
            <input type="hidden" name="pag" id="pag" value="1"/>
            <input type="hidden" name="r" id="r" value="2"/>
            <div class="row">
            <div class="form-group col-md-4">
                    <label for="folio_b" class="control-label">Folio:</label>
                    <input type="text" class="form-control input-sm" id="folio_b" name="folio_b" />
                </div>
                <div class="form-group col-md-4">
                    <label for="fecha_inicio_b" class="control-label">Fecha inicial<span class="required-tag">*</span>:</label>
                    <div class="input-group date" id="fecha_inicio_bdiv">
                        <input type="text" class="form-control input-sm sol_bus_obli sifolio tecleofolio" id="fecha_inicio_b" name="fecha_inicio_b"/>
                        <span class="input-group-addon glyphicon glyphicon-calendar" id="glyph_inicio_b"></span>
                    </div>
                </div>
                <div class="form-group col-md-4">
                    <label for="fecha_final_b" class="control-label">Fecha final<span class="required-tag">*</span>:</label>
                    <div class="input-group date" id="fecha_final_bdiv">
                        <input type="text" class="form-control input-sm sol_bus_obli sifolio tecleofolio" id="fecha_final_b" name="fecha_final_b"/>
                        <span class="input-group-addon glyphicon glyphicon-calendar" id="glyph_fin_b"></span>
                    </div>
                </div>
               
            </div>
            <div class="row">
                 <div class="form-group col-md-4">
                        <label for="tipo_b" class="control-label">Tipo registro:</label>
                        <select class="form-control input-sm sifolio tecleofolio" id="tipo_b" name="tipo_b"></select>
                </div>
                <div class="form-group col-md-4">
                    <label for="causa_b" class="control-label">Causa:</label>
                    <select class="form-control input-sm sifolio tecleofolio" id="causa_b" name="causa_b"></select>
                </div>
                <div class="form-group col-md-4">
                    <label for="estatus_b" class="control-label">Estatus:</label>
                    <select class="form-control input-sm sifolio tecleofolio" id="estatus_b" name="estatus_b"></select>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-4">
                    <label for="medio_recepcion_b" class="control-label ">Medio de recepci&oacute;n:</label>
                    <select class="form-control input-sm tecleofolio" id="medio_recepcion_b" name="medio_recepcion_b"></select>
                </div>
                <div class="form-group col-md-4">
                    <label class=" control-label" for="dependencia_b">Instancia involucrada:</label>
                    <select name="dependencia_b" id="dependencia_b" class="form-control input-sm tecleofolio" ></select>
                </div>
            </div>
            '.$estados.'
            <div class="row">
                <div class="form-group col-md-8"></div>
                <div class="form-group col-md-4">
                    <div class="pull-right">
                        <button name="limpia_b" id="limpia_b" class="btn btn-default">Limpiar</button>
                        <button name="buscar_b" id="buscar_b" class="btn btn-primary">Buscar</button>
                    </div>
                </div>
            </div>
            <div class="row" id="contInputBusqueda">
                <div class="page-header ocultaVer"><h1> &nbsp;Resultados</h1></div>
                <div class="col-md-10">
                    <div class="form-group">
                        <label class=" control-label" for="busca"> Buscar </label>
                        <input type="text" class="inputBusqueda" id="busca" name="busca">
                    </div>
                </div>
            </div>
        </form>
        <div class="row"><div class="col-md-12" id="contBusqueda"></div></div>
        <div class="row"><div class="col-md-12" id="pintaTablaDet"></div></div>
        <div class="row">
            <div class="col-md-12" id="carga" style="display:none;"><center><img src="includes/img/loading.gif" style="width:100px;"/></center></div>
        </div>
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
    ';
 }
 
    public function daCabeceraB($rol){
        $r = $this->obtenerRol($rol);
         if($r == 2 || $r == 3){
            return array('Folio','Fecha recepci&oacute;n','Tipo','Causa','Lugar de registro','Medio de recepci&oacute;n','Estatus operador','Estatus Actual');//,'Responsable','Asigno');
         }else if($r == 1 || $r == 5){
            return array('Folio','Fecha recepci&oacute;n','Tipo','Causa','Lugar de registro','Medio de recepci&oacute;n','Estatus');//,'Responsable','Asigno');
         }else{
            return array();
         }
    }
 
    function datosBusqueda($rol,$datos,$estado = null,$busqueda = null,$reporte = null){
       // echo $reporte;
        $solicitudes = array();
        $r = $this->obtenerRol($rol);
        $estado_enlace_rep = "";
        $depCon = "";
        $condicionDep = "";
        $datosHechos = $unionesHechos = "";
        if(!empty($reporte) && $reporte != null){
            $datosHechos = ",pis.nombre_pais,edos.nombre_estado 'nombre_estado_hechos',cdad.nombre_ciudad";
            $unionesHechos = " left join pais pis on pis.id = s.pais_hechos_id left join estado edos on edos.id = s.estado_hechos_id left join ciudad cdad on cdad.id = s.ciudad_hechos_id";
        }
        //exit();
        if(!empty($datos['tipo_b'])){
            if(!empty($datos['dependencia_b'])){
                if($datos['tipo_b'] == 1){ //queja
                    //$depCon = "";
                    $condicionDep = "inner join informacion_queja inque on s.id = inque.solicitud_id and inque.dependencia_id =". $datos['dependencia_b'];
                }else if($datos['tipo_b'] == 2){ // peticion
                    $condicionDep = "inner join informacion_peticion inpe on s.id = inpe.solicitud_id
                               inner join dependencia_contactada depcon on inpe.id = depcon.peticion_id and depcon.dependencia_id = ".$datos['dependencia_b'] ;
                    //$condicionDep = "";
                }
            }
            
        }
        if($r == 2 || $r == 3){//enlace o representante
            if(!empty($_SESSION['edo_rep']) && $_SESSION['edo_rep'] == 32){
                $quienLoHizo = " and (select rol_usuario_id from usuario where id = s.usuario_id) = ".$r;
            }
            //print_r($_SESSION);
            
          if(!empty($datos['folio_b'])){
                $folio_comp = $this->construirFolio($datos['folio_b']);
                if($busqueda != null){
                        $sqlSol = "select s.id,fo.numero_folio,DATE_FORMAT(s.fecha_recepcion,'%d-%m-%Y') 'recepcion',o.nombre_operacion,c.causa, edo.nombre_estado, mr.medio_recepcion,
                            case (select epp.estatus_peticion from historial_estatus hee inner join estatus_peticion epp on epp.id = hee.cve_estatus where hee.solicitud_id = s.id and hee.asigno = ".$r." order by hee.id desc limit 1)  when 'Turnada a DNPP' then 'Turnada a DNPP' when 'Concluida' then 'Concluida' when 'Turnada a OIC' then 'Turnada a OIC' when 'Eliminada' then 'Eliminada' else 'Nueva' end  'Estatus Ficticio',
                            (select epp.estatus_peticion from historial_estatus hee inner join estatus_peticion epp on epp.id = hee.cve_estatus where hee.solicitud_id = s.id and hee.activo = 1) 'Estatus real'
                            -- (select rrol.rol from historial_estatus hhe inner join rol_usuario rrol on rrol.id = hhe.asignado where hhe.solicitud_id = s.id and hhe.activo = 1) 'responsable',
                            -- (select rrol.rol from historial_estatus hhe inner join rol_usuario rrol on rrol.id = hhe.asigno where hhe.solicitud_id = s.id and hhe.activo = 1) 'quien asigno'
                            ".$datosHechos."
                            from solicitud s
                            inner join operacion o on s.tipo_registro_operacion_id = o.id
                            inner join causa c on c.id = s.causa
                            inner join historial_estatus he on s.id = he.solicitud_id
                            inner join estatus_peticion ep on ep.id = he.cve_estatus
                            inner join folio_operacion fo on fo.id = s.folio_id
                            inner join estado edo on edo.id = s.aplica_estado_id
                            inner join medio_recepcion mr on s.medio_recepcion_id = mr.id
                            ".$unionesHechos."
                            where (he.asigno = ".$r." or he.asignado = ".$r.")
                            and fo.numero_folio = '".$folio_comp."'
                            and s.aplica_estado_id = ".$estado."
                            and (fo.numero_folio like '%".$busqueda."%' or o.nombre_operacion like '%".$busqueda."%'
                            or c.causa like '%".$busqueda."%' or edo.nombre_estado like '%".$busqueda."%'
                            or (select epp.estatus_peticion from historial_estatus hee inner join estatus_peticion epp on epp.id = hee.cve_estatus where hee.solicitud_id = s.id and hee.activo = 1)  like '%".$busqueda."%'
                            or case (select epp.estatus_peticion from historial_estatus hee inner join estatus_peticion epp on epp.id = hee.cve_estatus where hee.solicitud_id = s.id and hee.asigno = ".$r." order by hee.id desc limit 1)  when 'Turnada a DNPP' then 'Turnada a DNPP' when 'Concluida' then 'Concluida' when 'Turnada a OIC' then 'Turnada a OIC' when 'Eliminada' then 'Eliminada' else 'Nueva' end like '%".$busqueda."%'
                            or DATE_FORMAT(s.fecha_recepcion,'%d-%m-%Y') like '%".$busqueda."%' or mr.medio_recepcion like '%".$busqueda."%')
                            group by numero_folio order by fo.numero_folio;";
                        $solicitudes = $this->query($sqlSol,'arregloAsociado');
                    }else{
                        $sqlSol = "select s.id,fo.numero_folio,DATE_FORMAT(s.fecha_recepcion,'%d-%m-%Y') 'recepcion',o.nombre_operacion,c.causa, edo.nombre_estado, mr.medio_recepcion,
                             case (select epp.estatus_peticion from historial_estatus hee inner join estatus_peticion epp on epp.id = hee.cve_estatus where hee.solicitud_id = s.id and hee.asigno = ".$r." order by hee.id desc limit 1)  when 'Turnada a DNPP' then 'Turnada a DNPP' when 'Concluida' then 'Concluida' when 'Turnada a OIC' then 'Turnada a OIC' when 'Eliminada' then 'Eliminada' else 'Nueva' end  'Estatus Ficticio',
                            (select epp.estatus_peticion from historial_estatus hee inner join estatus_peticion epp on epp.id = hee.cve_estatus where hee.solicitud_id = s.id and hee.activo = 1) 'Estatus real'
                            -- (select rrol.rol from historial_estatus hhe inner join rol_usuario rrol on rrol.id = hhe.asignado where hhe.solicitud_id = s.id and hhe.activo = 1) 'responsable',
                            -- (select rrol.rol from historial_estatus hhe inner join rol_usuario rrol on rrol.id = hhe.asigno where hhe.solicitud_id = s.id and hhe.activo = 1) 'quien asigno'
                            ".$datosHechos."
                            from solicitud s
                            inner join operacion o on s.tipo_registro_operacion_id = o.id
                            inner join causa c on c.id = s.causa
                            inner join historial_estatus he on s.id = he.solicitud_id
                            inner join estatus_peticion ep on ep.id = he.cve_estatus
                            inner join folio_operacion fo on fo.id = s.folio_id
                            inner join estado edo on edo.id = s.aplica_estado_id
                            inner join medio_recepcion mr on s.medio_recepcion_id = mr.id
                            ".$unionesHechos."
                            where (he.asigno = ".$r." or he.asignado = ".$r.")
                            and fo.numero_folio like '".$folio_comp."'
                            and s.aplica_estado_id = ".$estado."
                            group by numero_folio order by fo.numero_folio;";
                        $solicitudes = $this->query($sqlSol,'arregloAsociado');
                    }
            }else{
                $inicio = new DateTime($datos['fecha_inicio_b']);
                $fin = new DateTime($datos['fecha_final_b']);
                $tipOperacion = (!empty($datos['tipo_b']))? " and s.tipo_registro_operacion_id =".$datos['tipo_b'] : "";
                $causaDat = (!empty($datos['causa_b']))? " and s.causa =".$datos['causa_b'] : "";
                $mrecepcion = (!empty($datos['medio_recepcion_b']))? " and s.medio_recepcion_id =".$datos['medio_recepcion_b']. " " : "";
                $asig = $estatusDat = "";
                if(!empty($datos['estatus_b'])){
                    if($datos['estatus_b'] == 1){
                        $estatusDat = " and he.cve_estatus = ".$datos['estatus_b']." and he.activo = 1";
                        $asig = "and (he.asigno = ".$r." or he.asignado = ".$r.")";
                    }else if($datos['estatus_b'] == 2){
                        $estatusDat = " and he.cve_estatus = ".$datos['estatus_b']."  and he.activo = 1";
                        $asig = "";
                    }else if($datos['estatus_b'] == 3){
                        $estatusDat = " and he.cve_estatus = ".$datos['estatus_b']."  and he.activo = 1 and he.asignado = ".$r;
                        $asig = "and (he.asigno = ".$r." or he.asignado = ".$r.")";
                    }else if($datos['estatus_b'] == 4){
                        $estatusDat = " and he.cve_estatus = ".$datos['estatus_b']."";
                        $asig = "and (he.asigno = ".$r." or he.asignado = ".$r.")";
                    }else if($datos['estatus_b'] == 5){
                        $estatusDat = " and he.cve_estatus = ".$datos['estatus_b']."";
                        $asig = "and (he.asigno = ".$r." or he.asignado = ".$r.")";
                    }else if($datos['estatus_b'] == 6){
                        $estatusDat = " and he.cve_estatus = ".$datos['estatus_b']."";
                        $asig = "and (he.asigno = ".$r." or he.asignado = ".$r.")";
                    }
                }
                if($busqueda != null){
                        $sqlSol = "select s.id,fo.numero_folio,DATE_FORMAT(s.fecha_recepcion,'%d-%m-%Y') 'recepcion',o.nombre_operacion,c.causa, edo.nombre_estado,mr.medio_recepcion,
                            case (select epp.estatus_peticion from historial_estatus hee inner join estatus_peticion epp on epp.id = hee.cve_estatus where hee.solicitud_id = s.id and hee.asigno = ".$r." order by hee.id desc limit 1)  when 'Turnada a DNPP' then 'Turnada a DNPP' when 'Concluida' then 'Concluida' when 'Turnada a OIC' then 'Turnada a OIC' when 'Eliminada' then 'Eliminada' else 'Nueva' end  'Estatus Ficticio',
                            (select epp.estatus_peticion from historial_estatus hee inner join estatus_peticion epp on epp.id = hee.cve_estatus where hee.solicitud_id = s.id and hee.activo = 1) 'Estatus real'
                            -- (select rrol.rol from historial_estatus hhe inner join rol_usuario rrol on rrol.id = hhe.asignado where hhe.solicitud_id = s.id and hhe.activo = 1) 'responsable',
                            -- (select rrol.rol from historial_estatus hhe inner join rol_usuario rrol on rrol.id = hhe.asigno where hhe.solicitud_id = s.id and hhe.activo = 1) 'quien asigno'
                            ".$datosHechos."
                            from solicitud s
                            inner join operacion o on s.tipo_registro_operacion_id = o.id
                            inner join causa c on c.id = s.causa
                            inner join historial_estatus he on s.id = he.solicitud_id
                            inner join estatus_peticion ep on ep.id = he.cve_estatus
                            inner join folio_operacion fo on fo.id = s.folio_id
                            inner join estado edo on edo.id = s.aplica_estado_id
                            inner join medio_recepcion mr on s.medio_recepcion_id = mr.id
                            ".$condicionDep."
                            ".$unionesHechos."
                            where (s.fecha_recepcion >= '".$inicio->format('Y-m-d')."' and s.fecha_recepcion <= '".$fin->format('Y-m-d')."')
                            ".$asig.$estatusDat.$tipOperacion.$mrecepcion.$causaDat."
                            and s.aplica_estado_id = ".$estado."
                            ".$quienLoHizo."
                            and (fo.numero_folio like '%".$busqueda."%' or o.nombre_operacion like '%".$busqueda."%'
                            or c.causa like '%".$busqueda."%' or edo.nombre_estado like '%".$busqueda."%'
                            or (select epp.estatus_peticion from historial_estatus hee inner join estatus_peticion epp on epp.id = hee.cve_estatus where hee.solicitud_id = s.id and hee.activo = 1) like '%".$busqueda."%'
                            or case (select epp.estatus_peticion from historial_estatus hee inner join estatus_peticion epp on epp.id = hee.cve_estatus where hee.solicitud_id = s.id and hee.asigno = ".$r." order by hee.id desc limit 1)  when 'Turnada a DNPP' then 'Turnada a DNPP' when 'Concluida' then 'Concluida' when 'Turnada a OIC' then 'Turnada a OIC' when 'Eliminada' then 'Eliminada' else 'Nueva' end like '%".$busqueda."%'
                            or DATE_FORMAT(s.fecha_recepcion,'%d-%m-%Y') like '%".$busqueda."%' or mr.medio_recepcion like '%".$busqueda."%')
                            group by numero_folio order by fo.numero_folio;";
                        $solicitudes = $this->query($sqlSol,'arregloAsociado');
                }else{
                         $sqlSol = "select s.id,fo.numero_folio,DATE_FORMAT(s.fecha_recepcion,'%d-%m-%Y') 'recepcion',o.nombre_operacion,c.causa, edo.nombre_estado,mr.medio_recepcion,
                            case (select epp.estatus_peticion from historial_estatus hee inner join estatus_peticion epp on epp.id = hee.cve_estatus where hee.solicitud_id = s.id and hee.asigno = ".$r."  order by hee.id desc limit 1)  when 'Turnada a DNPP' then 'Turnada a DNPP' when 'Concluida' then 'Concluida' when 'Turnada a OIC' then 'Turnada a OIC' when 'Eliminada' then 'Eliminada' else 'Nueva' end  'Estatus Ficticio',
                            (select epp.estatus_peticion from historial_estatus hee inner join estatus_peticion epp on epp.id = hee.cve_estatus where hee.solicitud_id = s.id and hee.activo = 1) 'Estatus real'
                            -- (select rrol.rol from historial_estatus hhe inner join rol_usuario rrol on rrol.id = hhe.asignado where hhe.solicitud_id = s.id and hhe.activo = 1) 'responsable',
                            -- (select rrol.rol from historial_estatus hhe inner join rol_usuario rrol on rrol.id = hhe.asigno where hhe.solicitud_id = s.id and hhe.activo = 1) 'quien asigno'
                            ".$datosHechos."
                            from solicitud s
                            inner join operacion o on s.tipo_registro_operacion_id = o.id
                            inner join causa c on c.id = s.causa
                            inner join historial_estatus he on s.id = he.solicitud_id
                            inner join estatus_peticion ep on ep.id = he.cve_estatus
                            inner join folio_operacion fo on fo.id = s.folio_id
                            inner join estado edo on edo.id = s.aplica_estado_id
                            inner join medio_recepcion mr on s.medio_recepcion_id = mr.id
                            ".$condicionDep."
                            ".$unionesHechos."
                            where (s.fecha_recepcion >= '".$inicio->format('Y-m-d')."' and s.fecha_recepcion <= '".$fin->format('Y-m-d')."')
                            ".$asig.$estatusDat.$tipOperacion.$mrecepcion.$causaDat."
                            and s.aplica_estado_id = ".$estado."
                            ".$quienLoHizo."
                            group by numero_folio order by fo.numero_folio;";
                        $solicitudes = $this->query($sqlSol,'arregloAsociado');
                }
          
            }
        }else if($r == 1 || $r == 5){ //------------------------------------------------------------------------------------------------------------------------------------------------------------
            if(!empty($datos['folio_b'])){
                $folio_comp = $this->construirFolio($datos['folio_b']);
                if($busqueda != null){
                         $sqlSol = "select s.id,fo.numero_folio,DATE_FORMAT(s.fecha_recepcion,'%d-%m-%Y') 'recepcion',o.nombre_operacion,c.causa,edo.nombre_estado,mr.medio_recepcion,
                            (select epp.estatus_peticion from historial_estatus hee inner join estatus_peticion epp on epp.id = hee.cve_estatus where hee.solicitud_id = s.id and hee.activo = 1) 'Estatus real'
                            -- (select rrol.rol from historial_estatus hhe inner join rol_usuario rrol on rrol.id = hhe.asignado  where hhe.solicitud_id = s.id and hhe.activo = 1) 'responsable'
                            ".$datosHechos."
                            from solicitud s
                            inner join operacion o on s.tipo_registro_operacion_id = o.id
                            inner join causa c on c.id = s.causa
                            inner join historial_estatus he on s.id = he.solicitud_id
                            inner join estatus_peticion ep on ep.id = he.cve_estatus
                            inner join folio_operacion fo on fo.id = s.folio_id
                            inner join estado edo on edo.id = s.aplica_estado_id
                            inner join medio_recepcion mr on s.medio_recepcion_id = mr.id
                            ".$unionesHechos."
                            where fo.numero_folio = '".$folio_comp."'
                            and (fo.numero_folio like '%".$busqueda."%' or o.nombre_operacion like '%".$busqueda."%'
                            or c.causa like '%".$busqueda."%' or edo.nombre_estado like '%".$busqueda."%' or (select epp.estatus_peticion from historial_estatus hee inner join estatus_peticion epp on epp.id = hee.cve_estatus where hee.solicitud_id = s.id and hee.activo = 1) like '%".$busqueda."%'
                            or (select rrol.rol from historial_estatus hhe inner join rol_usuario rrol on rrol.id = hhe.asignado where hhe.solicitud_id = s.id and hhe.activo = 1) like '%".$busqueda."%'
                            or DATE_FORMAT(s.fecha_recepcion,'%d-%m-%Y') like '%".$busqueda."%' or mr.medio_recepcion like '%".$busqueda."%') 
                            group by numero_folio order by fo.numero_folio;";
                            
                        $solicitudes = $this->query($sqlSol,'arregloAsociado');
                    }else{
                        $sqlSol = "select s.id,fo.numero_folio,DATE_FORMAT(s.fecha_recepcion,'%d-%m-%Y') 'recepcion',o.nombre_operacion,c.causa,edo.nombre_estado,mr.medio_recepcion,
                            (select epp.estatus_peticion from historial_estatus hee inner join estatus_peticion epp on epp.id = hee.cve_estatus where hee.solicitud_id = s.id and hee.activo = 1) 'Estatus real'
                            -- (select rrol.rol from historial_estatus hhe inner join rol_usuario rrol on rrol.id = hhe.asignado  where hhe.solicitud_id = s.id and hhe.activo = 1) 'responsable'
                            ".$datosHechos."
                            from solicitud s
                            inner join operacion o on s.tipo_registro_operacion_id = o.id
                            inner join causa c on c.id = s.causa
                            inner join historial_estatus he on s.id = he.solicitud_id
                            inner join estatus_peticion ep on ep.id = he.cve_estatus
                            inner join folio_operacion fo on fo.id = s.folio_id
                            inner join estado edo on edo.id = s.aplica_estado_id
                            inner join medio_recepcion mr on s.medio_recepcion_id = mr.id
                            ".$unionesHechos."
                            where fo.numero_folio like '".$folio_comp."'
                            group by numero_folio order by fo.numero_folio;";
                      
                        $solicitudes = $this->query($sqlSol,'arregloAsociado');
                    }
            }else{
                
                $inicio = new DateTime($datos['fecha_inicio_b']);
                $fin = new DateTime($datos['fecha_final_b']);
                $tipOperacion = (!empty($datos['tipo_b']))? " and s.tipo_registro_operacion_id =".$datos['tipo_b'] : "";
                $causaDat = (!empty($datos['causa_b']))? " and s.causa =".$datos['causa_b'] : "";
                $mrecepcion = (!empty($datos['medio_recepcion_b']))? " and s.medio_recepcion_id =".$datos['medio_recepcion_b']. " " : "";
                $estatusDat = (!empty($datos['estatus_b']))? " and he.cve_estatus =".$datos['estatus_b']. " and he.activo = 1" : "";
               
                $estadosDat = "";
                if(!empty($datos['estados_b'])){
                    $estadosDat .= " and s.aplica_estado_id in(";
                    if(count($datos['estados_b']) > 0 ){
                        for($i = 0; $i < count($datos['estados_b']); $i++){
                            if($i > 0){
                                $estadosDat .= ",";
                            }
                            $estadosDat .= $datos['estados_b'][$i];
                        }
                    }
                    $estadosDat .= ")";
                }
                if($busqueda != null){
                         $sqlSol = "select s.id,fo.numero_folio,DATE_FORMAT(s.fecha_recepcion,'%d-%m-%Y') 'recepcion',o.nombre_operacion,c.causa,edo.nombre_estado,mr.medio_recepcion,
                            (select epp.estatus_peticion from historial_estatus hee inner join estatus_peticion epp on epp.id = hee.cve_estatus where hee.solicitud_id = s.id and hee.activo = 1) 'Estatus real'
                            -- (select rrol.rol from historial_estatus hhe inner join rol_usuario rrol on rrol.id = hhe.asignado  where hhe.solicitud_id = s.id and hhe.activo = 1) 'responsable'
                            ".$datosHechos."
                            from solicitud s
                            inner join operacion o on s.tipo_registro_operacion_id = o.id
                            inner join causa c on c.id = s.causa
                            inner join historial_estatus he on s.id = he.solicitud_id
                            inner join estatus_peticion ep on ep.id = he.cve_estatus
                            inner join folio_operacion fo on fo.id = s.folio_id
                            inner join estado edo on edo.id = s.aplica_estado_id
                            inner join medio_recepcion mr on s.medio_recepcion_id = mr.id
                            ".$condicionDep."
                            ".$unionesHechos."
                            where  (s.fecha_recepcion >= '".$inicio->format('Y-m-d')."' and s.fecha_recepcion <= '".$fin->format('Y-m-d')."')".$tipOperacion.$estado_enlace_rep.$estadosDat."
                            and (fo.numero_folio like '%".$busqueda."%' or o.nombre_operacion like '%".$busqueda."%'
                            or c.causa like '%".$busqueda."%' or edo.nombre_estado like '%".$busqueda."%' or
                            (select epp.estatus_peticion from historial_estatus hee inner join estatus_peticion epp on epp.id = hee.cve_estatus where hee.solicitud_id = s.id and hee.activo = 1) like '%".$busqueda."%'
                            -- or (select rrol.rol from historial_estatus hhe inner join rol_usuario rrol on rrol.id = hhe.asignado where hhe.solicitud_id = s.id and hhe.activo = 1) like '%".$busqueda."%'
                            or DATE_FORMAT(s.fecha_recepcion,'%d-%m-%Y') like '%".$busqueda."%' or mr.medio_recepcion like '%".$busqueda."%') ".$estadosDat.$causaDat.$mrecepcion.$estatusDat."
                            group by numero_folio order by fo.numero_folio;";
                        $solicitudes = $this->query($sqlSol,'arregloAsociado');
                    }else{
                        $sqlSol = "select s.id,fo.numero_folio,DATE_FORMAT(s.fecha_recepcion,'%d-%m-%Y') 'recepcion',o.nombre_operacion,c.causa,edo.nombre_estado,mr.medio_recepcion,
                            (select epp.estatus_peticion from historial_estatus hee inner join estatus_peticion epp on epp.id = hee.cve_estatus where hee.solicitud_id = s.id and hee.activo = 1) 'Estatus real'
                            -- (select rrol.rol from historial_estatus hhe inner join rol_usuario rrol on rrol.id = hhe.asignado  where hhe.solicitud_id = s.id and hhe.activo = 1) 'responsable',
                            -- (select rrol.rol from historial_estatus hhe inner join rol_usuario rrol on rrol.id = hhe.asigno  where hhe.solicitud_id = s.id and hhe.activo = 1) 'quien asigno'                      
                            ".$datosHechos."
                            from solicitud s
                            inner join operacion o on s.tipo_registro_operacion_id = o.id
                            inner join causa c on c.id = s.causa
                            inner join historial_estatus he on s.id = he.solicitud_id
                            inner join estatus_peticion ep on ep.id = he.cve_estatus
                            inner join folio_operacion fo on fo.id = s.folio_id
                            inner join estado edo on edo.id = s.aplica_estado_id
                            inner join medio_recepcion mr on s.medio_recepcion_id = mr.id
                            ".$condicionDep."
                            ".$unionesHechos."
                            where (s.fecha_recepcion >= '".$inicio->format('Y-m-d')."' and s.fecha_recepcion <= '".$fin->format('Y-m-d')."')".$tipOperacion.$estadosDat.$causaDat.$mrecepcion.$estatusDat."
                            group by numero_folio order by fo.numero_folio;";
                        $solicitudes = $this->query($sqlSol,'arregloAsociado');
                    }
            }
            
        }
        //print_r($solicitudes);
        return $solicitudes;
    }
    
    //pendiente
    /*
    public function botonesTablaBusqueda($rol, $permisoEditar, $permisoEliminar){
        $r = $this->obtenerRol($rol);
        $botones = array('editar' => 0,'eliminar' => 0);
        if($r == 2 || $r == 3){
            date_default_timezone_set('America/Mexico_City');
            echo $hoy = date('j');
            if($hoy >= 1 && $hoy <= 2){
                if($permisoEditar == 1){
                    $botones['editar'] = 1;
                }
                if($permisoEliminar == 1){
                    $botones['eliminar'] = 1;
                }
            }
        }else if($r == 1 || $r == 5){
            if($permisoEditar == 1){
                $botones['editar'] = 1;
            }
            if($permisoEliminar == 1){
                $botones['eliminar'] = 1;
            }
        }
        return $botones;
    }*/
 
 
     function eliminarSolBus($sol,$usuario,$rol){
        $sqlUp = "delete from historial_estatus where solicitud_id = ".$sol.";";
        $this->query($sqlUp,'');
        $sqlEstatus = "insert into historial_estatus values(null,'%s',%d,%d,%d,%d,1,".$rol.");";
        $hoy = new DateTime();
        $idestatus = $this->query(sprintf($sqlEstatus,$hoy->format('Y-m-d H:i'),$sol,2,$usuario,$rol),'id');
        if($idestatus != 0){
            return true;
        }else{
            return false;
        }
    }
    
 
    public function botonesSolBusDet($tipo){
       //$r = $this->obtenerRol($rol);
        switch($tipo){
            case 1 ://nuevos o asignados a dnpp
                echo '<div class="row">
                        <div class="form-group col-md-10"></div>
                        <div class="form-group col-md-2">
                            <div class="text-right">
                                <button name="regresarBus" id="regresarBus" class="btn btn-primary">Regresar</button>
                            </div>
                        </div>
                </div>
                <script>desactivaSolicitud();</script>';
            break;
            case 2 ://modificar
                echo '<div class="row">
                        <div class="form-group col-md-9"></div>
                        <div class="form-group col-md-3">
                            <div class="text-right">
                                <button name="regresarBus" id="regresarBus" class="btn btn-primary">Regresar</button>
                                <button name="formSBedita" id="formSBedita" class="btn btn-warning">Actualizar</button>
                            </div>
                        </div>
                </div> ';
            break;
            default: echo "No hay funcionalidad disponible."; break;
        }
    }
    
    public function detalleCambios($folio_id,$solicitud_id){
        $act = "";
        $sqlMod = "SELECT CONCAT(u.nombre, ' ', u.paterno, ' ', u.materno) 'usuario', DATE_FORMAT(act.fecha,'%d-%m-%Y') 'cuando',DATE_FORMAT(act.fecha,'%H:%i') 'hora',act.descripcion  FROM actualizacion act inner join usuario u on act.usuario_id = u.id where act.folio_operacion_id = ".$folio_id." order by act.id;";
        $cambios = $this->query($sqlMod,'arregloAsociado');
        $act .= "<div class='bs-callout bs-callout-success'>";
        if(count($cambios) > 0){
            $act .= "<!-- h4>Historial de actualizaciones</h4 -->";
            for($i = 0;$i < count($cambios);$i++){
                if(!empty($cambios[$i]['descripcion'])){
                     $descripcion = str_replace('<br />','\n',$cambios[$i]['descripcion']);
                }else{
                    $descripcion ="Sin descripci&oacute;n";
                }
                $act .= "<strong>Realizo operaci&oacute;n: </strong>".utf8_encode($cambios[$i]['usuario'])."&nbsp;&nbsp;&nbsp;<strong>Fecha de operaci&oacute;n: </strong>".$cambios[$i]['cuando']."&nbsp;&nbsp;&nbsp;<strong>Hora: </strong>".$cambios[$i]['hora']."<br/><strong>Justificaci&oacute;n: </strong>". $descripcion."<br/><br/>";
            }
        }
        $sqlEstados = "select ep.estatus_peticion,DATE_FORMAT(he.fecha_actualizacion,'%d-%m-%Y') 'cuando',DATE_FORMAT(he.fecha_actualizacion,'%H:%i') 'hora',CONCAT(u.nombre, ' ', u.paterno, ' ', u.materno) 'usuario', ru.rol
                    from historial_estatus he inner join usuario u on he.usuario_modifico_id = u.id
                    left join rol_usuario ru on ru.id = he.asigno
                    inner join estatus_peticion ep on ep.id = he.cve_estatus
                    where he.solicitud_id = ".$solicitud_id." order by he.id;";
        $estados = $this->query($sqlEstados,'arregloAsociado');

        
        if(count($estados) > 0){
            $act .= "<h4>Historial de estatus</h4>";
            for($i = 0;$i < count($estados);$i++){
                $actual = ($i == (count($estados)-1))? "&nbsp;&nbsp;<span class='label label-success'>Actual</span>" : "";
                $diagonal = (!empty($estados[$i]['rol']))? " / " : "";
                $act .= "<strong>Realizo operaci&oacute;n: </strong>".utf8_encode($estados[$i]['usuario'].$diagonal.$estados[$i]['rol']). "&nbsp;&nbsp;&nbsp;<strong>Fecha de operaci&oacute;n: </strong>".$estados[$i]['cuando']."&nbsp;&nbsp;&nbsp;<strong>Hora: </strong>".$estados[$i]['hora']."&nbsp;&nbsp;&nbsp;<strong>Estatus: </strong>". utf8_encode($estados[$i]['estatus_peticion']).$actual."<br/>";
            }
        }
        $act .= "</div>";

        return $act;
    }
 
 
 // --------------------------------Modificar---------------------------------------------------------------------------
 
    public function actualizarSolicitud($datos,$archivos,$idusu,$rol){
        $this->iniciarSolicitud($datos);
        $sqlModSol = "UPDATE solicitud set 
        medio_recepcion_id = ".$this->medio_recepcion_id.",
        causa = ".$this->causa.",
        otra_causa = '".$this->otra_causa."',
        fecha_recepcion = '".$this->fecha_recepcion."',
        fecha_hechos = '".$this->fecha_hechos."',
        pais_hechos_id = ".$this->pais_hechos_id.",
        estado_hechos_id = ".$this->estado_hechos_id.",
        ciudad_hechos_id = ".$this->ciudad_hechos_id.",
        lugar_hechos = '".$this->lugar_hechos."',
        anonimo = ".$this->anonimo." where id = ".$this->id.";";
        $this->actualizaQuejoso($datos);
        $this->query($sqlModSol,'');
        $this->insertaModificacion($datos,$idusu);
        return true;
    }
    
    public function actualizaQuejoso($datos){
        $this->iniciaQuejoso($datos);
        $sqlActQuejo = "update persona set 
        nombre_persona = '".$this->nombre_persona."',
        apellidos_persona ='".$this->apellidos_persona."',
        sexo_id =".$this->sexo_persona.",
        pais_origen_id =".$this->pais_origen_persona.",
        estado_origen_id =".$this->estado_origen_persona.",
        ciudad_origen_id =".$this->ciudad_origen_persona.",
        telefono_persona ='".$this->telefono_persona."',
        correo_persona ='".$this->correo_persona."',
        direccion_persona ='".$this->direccion_persona."' 
        where id = ".$this->solicitante.";";
        $this->query($sqlActQuejo,'');
        return true;
    }
    
    public function insertaModificacion($datos,$idusu){
        date_default_timezone_set('America/Mexico_City');
        $hoy = new DateTime();
        $insertModi = "insert into actualizacion values(null,'".$datos['justificacion_mod']."','".$hoy->format('Y-m-d H:i')."',".$idusu.",".$datos['folio'].");";
        $this->query($insertModi,'');
    }
    
    //cambio estatus------------------------------------------------------------------------------------------------------------------------------------
    
    function formCambioEstatus(){
    return '
        <form role="form" class="form-horizontal" action="herramientas/funciones/solicitud.php" id="cambioEst" method="POST">
            <input type="hidden" name="opcion" id="opcion" value="14"/>
            <div class="form-group">
                 <label class="col-lg-2 control-label" for="folio_es">N&uacute;mero de folio</label>
                 <div class="col-lg-4">
                    <input type="text" class="form-control input-sm" id="folio_es" name="folio_es" />
                 </div>
                 <div class="col-lg-1">
                    <button name="buscar_es" id="buscar_es" class="btn btn-primary">Buscar</button>
                 </div>
                 <div class="col-lg-3"></div>
            </div>
        </form>
        <div class="row"><div class="col-md-12" id="contEstatus"></div></div>
        <div class="row">
            <div class="col-md-12" id="carga" style="display:none;"><center><img src="includes/img/loading.gif" style="width:100px;"/></center></div>
        </div>
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
    ';
 }
 
 public function datosEstatus($folio_n,$rol,$estadoDonde){
    $folio = $this->construirFolio($folio_n);
    $eliminada = $dnpp = 0;
    $donde = ($rol == 2 || $rol == 3)? " and s.aplica_estado_id = ".$estadoDonde : "" ;
    $sql = "select he.id, ep.estatus_peticion,he.cve_estatus, s.id 'solicitud_id',fo.id 'folio_id' from folio_operacion fo
    inner join solicitud s on s.folio_id = fo.id
    inner join historial_estatus he on s.id = he.solicitud_id
    inner join estatus_peticion ep on he.cve_estatus = ep.id
    where fo.numero_folio = '".$folio."'".$donde."
    order by he.id; ";
    $estatusS = $this->query($sql,'arregloAsociado');
    if(count($estatusS) > 0){
        $sqlDatosSol = "select o.nombre_operacion,DATE_FORMAT(s.fecha_recepcion,'%d-%m-%Y') 'fecha',e.nombre_estado from solicitud s
        inner join operacion o on s.tipo_registro_operacion_id = o.id
        inner join estado e on e.id = s.aplica_estado_id
        where s.id = ".$estatusS[0]['solicitud_id'].";";
        $datos = $this->query($sqlDatosSol,'registro');
        $resetea = 0;
        echo '<div id="contInfoEstDat">
                <div class="bs-callout bs-callout-success"><h4>Informaci&oacute;n del registro</h4>
                    <strong>Fecha recepci&oacute;n: </strong>'.$datos['fecha'].' / <strong> Tipo de registro: </strong>'.utf8_encode($datos['nombre_operacion']).' / <strong> Lugar de registro: </strong>'.utf8_encode($datos['nombre_estado']).' / <strong>Folio:</strong> '. $folio .'
                </div>
                <div class="row">
                    <div class="col-sm-12 col-md-12">
                            <div id="parrafoInf" class="alert alert-info"></div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12 col-md-12">
                        <div class="list-group">
                            <input type="hidden" name="folioEstCam" id="folioEstCam" value="'.$folio.'"/>
                            <input type="hidden" name="solicitudId" id="solicitudId" value="'.$estatusS[0]['solicitud_id'].'"/>';
                        for($i = 0;$i < count($estatusS);$i++){
                            if($i != (count($estatusS)-1)){
                                 echo '<div class="list-group-item" id="lis'.($i+1).'">
                                    <input type="radio" name="estatus" checked for="lis'.($i+1).'" id="'.($i+1).'" value="'.$estatusS[$i]['id'].'" />&nbsp;'.$estatusS[$i]['estatus_peticion'].'
                                </div>';
                            }else{
                                 echo '<div class="list-group-item" id="lis'.($i+1).'">
                                    <input type="radio" name="estatus" for="lis'.($i+1).'" id="'.($i+1).'" value="'.$estatusS[$i]['id'].'" style="display:none;" />&nbsp;&nbsp;&nbsp;'.$estatusS[$i]['estatus_peticion'].'
                                </div>';
                            }
                           
                            if($estatusS[$i]['cve_estatus'] == 5){
                                $dnpp = 1;
                            }
                            if($estatusS[$i]['cve_estatus'] == 2){
                               $eliminada = 1;
                               $resetea = $estatusS[$i]['id'];
                            }
                        }
                    echo '</div>
                            <div class="col-sm-12 col-md-12 text-right">
                                  <button name="cambiarEstatus" id="cambiarEstatus" class="btn btn-danger">Modificar estatus</button><br/><br/>
                                  <button name="reiniciaSolicitud" id="reiniciaSolicitud" class="btn btn-danger" for="'.$resetea.'">Reiniciar solicitud</button><br/><br/>
                            </div>
                    </div>
                </div>
            </div>
        <script>
            $("#lis'.count($estatusS).'").addClass("list-group-item-success");
            $("#parrafoInf").html("Usted puede regresar la solicitud al estatus de su elecci&oacute;n, debe estar conciente de que <strong>los estatus posteriores al seleccionado ser&aacute;n eliminados</strong>");
            $("#reiniciaSolicitud").hide();
        </script>';
       
        if($rol == 2 || $rol == 3){
            date_default_timezone_set('America/Mexico_City');
            $recepcion = date($datos['fecha']);
            $month = substr($recepcion, 3, 2);
            $year = substr($recepcion, 6, 4);
            $diasMes = $this->getMonthDays($month, $year);
            $inicioMes =  date('Y-m-d', mktime(0,0,0, $month, 1, $year));
            $ultimoDiaAct = strtotime ( '+'.($diasMes+4).' day' , strtotime ( $inicioMes ) ) ;
            $ultimoDiaActF = date ( 'Y-m-d' , $ultimoDiaAct );
            $ultimoDiaActMen = date( 'd-m-Y' , $ultimoDiaAct );
            $hoy = date( 'Y-m-d');
            if(strtotime($hoy) >= strtotime($inicioMes) && strtotime($hoy) <= strtotime($ultimoDiaActF)){
                if(count($estatusS) == 1){
                        if($eliminada == 1){
                             echo '<script>
                                $("input[type=radio]").prop("disabled",true);
                                $("#parrafoInf").html("Esta solicitud ha sido eliminada por el encargado de '.utf8_encode($datos["nombre_estado"]).', al reiniciar su estatus, <strong>ser&aacute; presentada como una solicitud nueva</strong>");
                                $("#reiniciaSolicitud").show();
                                $("#cambiarEstatus").hide();
                            </script>';
                        }else{
                            echo '<script>
                                $("#parrafoInf").html("Esta solicitud s&oacute;lo <strong>cuenta con un estatus</strong>, no es posible hacer alg&uacute;n cambio");
                                $("#cambiarEstatus").hide();
                            </script>';
                        }
                }
                if($dnpp == 1){
                    echo '<script>
                        $("input[type=radio]").prop("disabled",true);
                        $("#parrafoInf").html("Lo sentimos, al asignar la solicitud a la DNPP usted <strong>no puede cambiar el estatus</strong> de esta");
                        $("#cambiarEstatus").hide();
                    </script>';
                    for($i = 0;$i < count($estatusS);$i++){
                        echo '<script>$("#lis'.($i+1).'").addClass("disabled");</script>';
                    }
                }
                
                
            }
            else{
                 echo '<script>
                    $("input[type=radio]").prop("disabled",true);
                    $("#parrafoInf").html("Lo sentimos, <strong>ha transcurrido el tiempo l&iacute;mite para modificar esta solicitud ('.$ultimoDiaActMen.')</strong> ");
                    $("#cambiarEstatus").hide();
                    </script>';
            }
            
        }else if($rol == 1 || $rol == 5){
            if(count($estatusS) > 1){
                
            }else if(count($estatusS) == 1){
                if($eliminada == 1){
                     echo '<script>
                        $("input[type=radio]").prop("disabled",true);
                        $("#parrafoInf").html("Esta solicitud ha sido eliminada por el encargado de '.utf8_encode($datos["nombre_estado"]).', al reiniciar su estatus, <strong>ser&aacute; presentada como una solicitud nueva</strong>");
                        $("#reiniciaSolicitud").show();
                        $("#cambiarEstatus").hide();
                    </script>';
                }else{
                    echo '<script>
                        $("#parrafoInf").html("Esta solicitud s&oacute;lo <strong>cuenta con un estatus</strong>, no es posible hacer alg&uacute;n cambio");
                        $("#cambiarEstatus").hide();
                    </script>';
                }
            }else{
                
            }
        }
        
         echo '<script>cambioEstatus();</script>';
    }else{
        echo '<div class="alert alert-warning text-center"><i>Sin resultados</i></div>';
        
    }
    
 }
 
  function getMonthDays($Month, $Year){ // funcion, dias del mes
       //Si la extensión que mencioné está instalada, usamos esa.
       if( is_callable("cal_days_in_month"))
       {
          return cal_days_in_month(CAL_GREGORIAN, $Month, $Year);
       }
       else
       {
          //Lo hacemos a mi manera.
          return date("d",mktime(0,0,0,$Month+1,0,$Year));
       }
    }
 
 public function eliminarEstatusDat($estatus_base,$sol,$idusu){
    $verEst = "select * from historial_estatus where id = ".$estatus_base.";";
    $datEst = $this->query($verEst,'registro');
    if($datEst['cve_estatus'] == 2){
        $SQLasignado = "select aplica_estado_id from solicitud where id = ".$sol.";";
        $asignado = $this->query($SQLasignado,'registro');
        if($asignado['aplica_estado_id'] == 83){
            $as = ",asignado = 1";
        }else{
            $sqlPais = "SELECT pais_id FROM estado where id = ".$asignado['aplica_estado_id'].";";
            $pais = $this->query($sqlPais,'registro');
            if($pais['pais_id'] == 1){
                $as = ",asignado = 3";
            }else{
                $as = ",asignado = 2";
            }
        }
        
        $sqlNueva = "update historial_estatus set cve_estatus = 1, asigno = null".$as." where id = ".$estatus_base.";";
         $this->query($sqlNueva,'');
         $selFolio = "select folio_id from solicitud where id = ". $sol .";";
         $folioId = $this->query($selFolio,'registro');
         $this->insertaModificacion(array('justificacion_mod' => 'Cambio el estatus de la solicitud a Nueva','folio' => $folioId['folio_id']),$idusu);
    }else{
        $sqlDelEs = "delete FROM historial_estatus where id > ".$estatus_base." and solicitud_id = ".$sol.";";
        $this->query($sqlDelEs,'');
        $sqlModEst = "update historial_estatus set activo = 1 where id = ".$estatus_base.";";
        $this->query($sqlModEst,'');
    }
    return true;
    
 }

 
 //---------------------------------------------------------reporte mensual--------------------------------------------------------------------------------------------------------
 public function formReporteMensual($rol){
    $estados = '';
    if($this->obtenerRol($rol) == 1 || $this->obtenerRol($rol) == 5){
        $estados = '
            <div class="row">
                <div class="form-group col-md-4">
                    <label class="control-label" for="estados_re">Lugar de registro:</label><br/>
                    <select class="form-control" id="estados_re" name="estados_re"><option value="">Seleccione</option></select>
                </div>
            </div>';
    }
    return '
        <form role="form" action="herramientas/funciones/solicitud.php" id="repMen" method="POST">
            <input type="hidden" name="opcion" id="opcion" value="15"/>
            <input type="hidden" name="r" value="1" />
            <div class="row">
                <div class="form-group col-md-4">
                    <label for="fecha_inicio_re" class="control-label">Fecha inicial<span class="required-tag">*</span>:</label>
                    <div class="input-group date" id="fecha_inicio_rediv">
                        <input type="text" class="form-control input-sm" id="fecha_inicio_re" name="fecha_inicio_re"/>
                        <span class="input-group-addon glyphicon glyphicon-calendar" id="glyph_inicio_re"></span>
                    </div>
                </div>
                <div class="form-group col-md-4">
                    <label for="fecha_final_re" class="control-label">Fecha de final<span class="required-tag">*</span>:</label>
                    <div class="input-group date" id="fecha_final_rediv">
                        <input type="text" class="form-control input-sm" id="fecha_final_re" name="fecha_final_re"/>
                        <span class="input-group-addon glyphicon glyphicon-calendar" id="glyph_final_re"></span>
                    </div>
                </div>
                '.$estados.'
            </div>
            <div class="row">
                <div class="form-group col-md-8"></div>
                <div class="form-group col-md-4">
                    <div class="pull-right">
                        <button name="limpia_re" id="limpia_re" class="btn btn-default">Limpiar</button>
                        <button name="buscar_re" id="buscar_re" class="btn btn-primary">Buscar</button>
                    </div>
                </div>
            </div>
        </form>
        <div class="row"><div class="col-md-12" id="BusMenMen"></div></div>
        <div class="row">
            <div class="col-md-12" id="carga" style="display:none;"><center><img src="includes/img/loading.gif" style="width:100px;"/></center></div>
        </div>
        <!-- Modal -->
        <div class="modal fade" id="ModalGral" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header" id="modal-header"></div>
                    <div class="modal-body" id="modal-body"></div>
                    <div class="modal-footer" id="modal-footer"></div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-10" id="BusMenMen"></div>
            <div class="col-md-2 text-right"><button name="EnlacePdf" id="EnlacePdf" class="btn btn btn-default" style="display:none"><img src="includes/img/pdf.png"  class="IMGicono"  style="width:20px;"> Generar</button></div>
        </div>
        
    ';
 }
 
 
}

?>