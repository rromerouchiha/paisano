<?php
error_reporting(E_ALL);
ini_set('display_errors','1');

class Queja extends Solicitud{
   private $id_queja;
   private $hechos;
   private $testigos_servidor;
   
   private $id_involucrado;
   private $nombre_servidor;
   private $sexo_servidor;
   private $tez_servidor;
   private $complexion_servidor;
   private $ojos_servidor;
   private $edad_servidor;
   private $estatura_servidor;
   private $dependencia_servidor;
   private $otra_dependencia;
   private $cargo_servidor;
   private $identificacion_servidor;
   private $uniforme_servidor;
   private $senias_servidor;
   private $vehiculo_servidor;
   private $info_vehiculo_id;
   private $desc_vehi_servidor;
   private $placas_servidor;
   private $color_vehi_servidor;
   
   private $id_testigo ;
   private $nombre_testigo;
   private $telefono_testigo;
   private $correo_testigo;


    public function __construct($serv,$usua,$clav,$base='',$puerto=''){
        parent::__construct($serv,$usua,$clav,$base,$puerto);
    }
    
    function iniciaQueja($info){
       $this->id_queja = (!empty($info['id_queja']))? $info['id_queja']: 0;
       $this->hechos = (!empty($info['narracion_servidor']))? utf8_decode($info['narracion_servidor']) : '';
       $this->testigos_servidor = (!empty($info['testigos_servidor']))? $info['testigos_servidor'] : '';
       $this->fecha_hoy = new DateTime();
    }
    
     public function iniciaTestigo($info){
        $this->id_testigo = (!empty($info['id_testigo']))? $info['id_testigo']: 0;
        $this->nombre_testigo = (!empty($info['nombre_testigo']))? utf8_decode($info['nombre_testigo']) : '' ;
        $this->telefono_testigo = (!empty($info['telefono_testigo']))? utf8_decode($info['telefono_testigo']) : '';
        $this->correo_testigo = (!empty($info['correo_testigo']))? utf8_decode($info['correo_testigo']) : '';
     }
    
    function iniciaInvolucrado($info){
        $this->id_involucrado = (!empty($info['id_involucrado']))? $info['id_involucrado']: 0;
        $this->nombre_servidor = (!empty($info['nombre_servidor']))? utf8_decode($info['nombre_servidor']) : '' ;
        $this->sexo_servidor = $info['sexo_servidor'] ;
        $this->tez_servidor = (!empty($info['tez_servidor']))? utf8_decode($info['tez_servidor']) : '';
        $this->complexion_servidor = (!empty($info['complexion_servidor']))? utf8_decode($info['complexion_servidor']) : '';
        $this->ojos_servidor = (!empty($info['ojos_servidor']))? utf8_decode($info['ojos_servidor']) : '';
        $this->edad_servidor = (!empty($info['edad_servidor']))? $info['edad_servidor']: 'null';
        $this->estatura_servidor = (!empty($info['estatura_servidor']))? $info['estatura_servidor']: 'null';
        $this->dependencia_servidor = $info['dependencia_servidor'];
        $this->otra_dependencia = (!empty($info['otra_dep_que']))? $info['otra_dep_que'] : null;
        $this->cargo_servidor = (!empty($info['cargo_servidor']))? utf8_decode($info['cargo_servidor']) : '';
        $this->identificacion_servidor = (!empty($info['identificacion_servidor']))? $info['identificacion_servidor'] : '';
        $this->uniforme_servidor = (!empty($info['uniforme_servidor']))?$info['uniforme_servidor'] : '';
        $this->senias_servidor = (!empty($info['senias_servidor']))? utf8_decode($info['senias_servidor']) : '';
        $this->vehiculo_servidor = (!empty($info['vehiculo_servidor']))? $info['vehiculo_servidor'] : 0;
        $this->info_vehiculo_id = (!empty($info['id_vehiculo']))? $info['id_vehiculo'] : 'null';
        $this->desc_vehi_servidor = (!empty($info['desc_vehi_servidor']))? utf8_decode($info['desc_vehi_servidor']) : '' ;
        $this->placas_servidor = (!empty($info['placas_servidor']))? utf8_decode($info['placas_servidor']) : '';
        $this->color_vehi_servidor = (!empty($info['color_vehi_servidor']))? utf8_decode($info['color_vehi_servidor']): '';
    }
    
    
     function agregaQueja($info,$idusu_reg,$estado, $rol, $archivos){
         $this->iniciaQueja($info);
         $resSol = $this->creaSolicitud($info,$idusu_reg,$estado, $rol);
         $resSol['log'] = (!empty($resSol['log']))? $resSol['log'] : '';
         if($resSol['estatus'] == 1){
            
            $sqlNvaQja = "insert into informacion_queja values(null,'%s','%s',%d);";
            $this->id_queja = $this->query(sprintf($sqlNvaQja,$this->hechos,$this->testigos_servidor,$this->getIdSol()),'id');
            if($this->id_queja != 0){
               $this->ordenaTestigosEInvolucrados();
               if($this->cargaEvidenciaQueja($archivos)){
                    $resSol['estatus'] = 1;
                    $resSol['log'] .= "queja cargada con exito";
                    $resSol['num_folio'] = $this->getIdFolio();
               }else{
                    $resSol['log'] .= "No se cargo Evidencia";
                    $resSol['estatus'] = 0;
               }
                
            }else{
                $resSol['log'] .= "No se agrego Queja";
                $resSol['estatus'] = 0;
            }
         }else{
            $resSol['log'] .= "No se agrego Solicitud";
            $resSol['estatus'] = 0;
         }
         return $resSol;
     }
    
   function ordenaTestigosEInvolucrados(){
      //session_start();
      $involucrado = (!empty($_SESSION['involucrado']))? $_SESSION['involucrado'] : array() ;
      $testigo = (!empty($_SESSION['testigo']))? $_SESSION['testigo'] : array() ;
      $sqlInv = "insert into involucrados_queja values(null,".$this->id_queja.",%d);";
      $sqlInvMod = "update involucrado set activo = 1, clave = null where id = %d;";
      for($i = 0; $i < count($involucrado); $i++){
         $sqlInvEx = "select count(*) 'tot' from involucrado where id = ".$involucrado[$i].";";
         $exInv = $this->query($sqlInvEx,'registro');
         if($exInv['tot'] > 0){
            $this->query(sprintf($sqlInv,$involucrado[$i]),'');
            $this->query(sprintf($sqlInvMod,$involucrado[$i]),'');
         }
         unset($_SESSION['involucrado'][$i]);
      }
      unset($_SESSION['vehiculo'],$_SESSION['involucrado']);
      $sqlTes = "insert into testigo_queja values(null,".$this->id_queja.",%d);";
      $sqlTesMod = "update testigo set activo = 1, clave = null where id = %d;";
      $deleteTes = "delete from testigo where id = %d;";
      for($i = 0; $i < count($testigo); $i++){
         if($this->testigos_servidor == 1){
            $sqlTesEx = "select count(*) 'tot' from testigo where id = ".$testigo[$i].";";
            $exTes = $this->query($sqlTesEx,'registro');
            if($exTes['tot'] > 0){
               $this->query(sprintf($sqlTes,$testigo[$i]),'');
               $this->query(sprintf($sqlTesMod,$testigo[$i]),'');
            }
            unset($_SESSION['testigo']);
         }else{
            $this->query(sprintf($deleteTes,$testigo[$i]),'');
         }
         
      }
    }
    
    function agregaInfoVehiculo(){
        $sqlInfoVe = "insert into informacion_vehiculo values(null,'%s','%s','%s');";
        $this->info_vehiculo_id = $this->query(sprintf($sqlInfoVe,$this->desc_vehi_servidor,$this->placas_servidor,$this->color_vehi_servidor),'id');
    }
    
    function cargaEvidenciaQueja($archivos){
        $resEvi = array();
        if(!empty($archivos['pruebas_servidor']) && $archivos['pruebas_servidor']['error'] == 0){
            $url = "../../includes/archivos/quejas/";
            $urlb = "includes/archivos/quejas/";
            $tipo = 1;
            $resEvi = $this->cargarArchivo($archivos['pruebas_servidor']['tmp_name'],$url,$archivos['pruebas_servidor']['name'],$urlb,$tipo);
            if($resEvi['estatus_evidencia'] != 0){
                $sqlRelArch = "insert into evidencia_queja values(null,%d,%d);";
                $this->query(sprintf($sqlRelArch,$resEvi['id_evidencia'],$this->id_queja),'');
                return true;
            }else{
                return false;
            }
        }else{
            return true;
        }
    }

   public function agregarInvolucrado($info){
      $this->iniciaInvolucrado($info);
      if($this->vehiculo_servidor == 1){
         $this->agregaInfoVehiculo();
      }
      $sqlInv = "insert into involucrado values(null,'%s',%d,'%s','%s','%s',%s,%s,'%s',%d,'%s','%s','%s','%s','%s',%s,'".$info['cveHuerfanos']."',0);";
      $this->id_involucrado = $this->query(sprintf($sqlInv,$this->nombre_servidor,$this->sexo_servidor,$this->tez_servidor,$this->complexion_servidor,$this->ojos_servidor,$this->edad_servidor,$this->estatura_servidor,$this->cargo_servidor,$this->dependencia_servidor,$this->otra_dependencia,$this->identificacion_servidor,$this->uniforme_servidor,$this->senias_servidor,$this->vehiculo_servidor,$this->info_vehiculo_id),'id');
      $_SESSION["involucrado"][] = $this->id_involucrado;
      if($this->vehiculo_servidor == 1){
         $_SESSION["vehiculo"][(count($_SESSION["involucrado"]) - 1)] =  $this->info_vehiculo_id;
      }
      if($this->id_involucrado > 0){
         return 1;
      }else{
         return 0;
      }
    }
    
    public function mostrarInvolQuej($quejaId,$huerfano){
      //echo "---{".$huerfano."}----";
         $sqlInv = "select i.id,case i.nombre when '' then 'Desconocido' else i.nombre end 'nombre', s.sexo,dep.dependencia,i.uniforme, Case tenia_vehiculo when 1 then 'Si' else 'No' end 'vehiculo'
         from involucrado i inner join sexo s on s.id = i.sexo_id
         inner join dependencia dep on dep.id = i.dependencia_id
         inner join involucrados_queja iq on iq.involucrado_id = i.id
         where iq.informacion_queja_id = ". $quejaId ." order by i.id; ";
         $involucrados = $this->query($sqlInv,'arregloAsociado');
         $involucradosCve = $this->mostrarInvolCve($huerfano);
         $invol = array_merge($involucrados,$involucradosCve);
         return $invol;
    }
    
   public function mostrarInvolCve($huerfano){
         $sqlInv = "select i.id,case i.nombre when '' then 'Desconocido' else i.nombre end 'nombre', s.sexo,dep.dependencia,i.uniforme, Case tenia_vehiculo when 1 then 'Si' else 'No' end 'vehiculo'
         from involucrado i inner join sexo s on s.id = i.sexo_id
         inner join dependencia dep on dep.id = i.dependencia_id
         where i.clave = '".$huerfano."' order by i.id;";
         $involucrados = $this->query($sqlInv,'arregloAsociado');
         return $involucrados;
   }
   
   
   public function eliminarInvolucrado($tipo,$cual){
      //echo $tipo;
      if($tipo == 1){ // existe id queja
         $sqlExTe = "select count(*) 'totInv' from involucrados_queja where involucrado_id = ".$cual.";";
         $totIn = $this->query($sqlExTe,'registro');
         if($totIn['totInv'] > 0){
            $this->eliminaInvolucradoTemp($cual);
            $sqliga = "delete from involucrados_queja where involucrado_id = ".$cual.";";
            $this->query($sqliga,'');
         }         
      }
      $sqlVeh = "select informacion_vehiculo_id from involucrado where id = ".$cual.";";
      $vehiculo = $this->query($sqlVeh,'registro');
      $sqlInv = "delete from involucrado where id = ".$cual.";";
      $this->query($sqlInv,'');

      if($vehiculo['informacion_vehiculo_id'] > 0){
         $delVehi = "delete from informacion_vehiculo where id = ".$vehiculo['informacion_vehiculo_id'].";";
         $this->query($delVehi,'');
      }
      return 1;
   }
    
   public function datosInvolucrado($cual){
      $sqlInv = "select * from involucrado where id = ".$cual.";";
      $datosInv = $this->query($sqlInv,'arregloUnicoAsoc');
      $id_involucrado = ' $("#id_involucrado").val('.$datosInv["id"].');';
      $nombres = (!empty($datosInv['nombre']))?  "$('#nombre_servidor').val('".utf8_encode($datosInv['nombre'])."');" : "";
      $sexos = "$('#sexo_servidor').val(".$datosInv['sexo_id'].");";
      $tezs = (!empty($datosInv['tez']))? " $('#tez_servidor').val('".utf8_encode($datosInv['tez'])."');" : "";
      $complexions = (!empty($datosInv['complexion']))?  "$('#complexion_servidor').val('".utf8_encode($datosInv['complexion'])."');" : "";
      $colors = (!empty($datosInv['color_ojos']))? " $('#ojos_servidor').val('".utf8_encode($datosInv['color_ojos'])."');" : "";
      $edads = (!empty($datosInv['edad_aprox']))? "$('#edad_servidor').val(".$datosInv['edad_aprox'].");" : "";
      $estaturas = (!empty($datosInv['estatura_aprox']))? '$("#estatura_servidor").val("'.utf8_encode($datosInv['estatura_aprox']).'");' : '' ;
      $dependencias = (!empty($datosInv['dependencia_id']))?  "$('#dependencia_servidor').val('".$datosInv['dependencia_id']."').change();" : "";
      $otradependencias = (!empty($datosInv['otra_dependencia']))? " $('#otra_dep_que').val('".utf8_encode($datosInv['otra_dependencia'])."');" : "";
      $cargos = (!empty($datosInv['cargo']))? " $('#cargo_servidor').val('".utf8_encode($datosInv['cargo'])."');" : "";
      $identificacions = (!empty($datosInv['num_identificacion']))? " $('#identificacion_servidor').val('".$datosInv['num_identificacion']."');" : "";
      $uniformes = (!empty($datosInv['uniforme']))? " $('#uniforme_servidor').val('".$datosInv['uniforme']."');" : "";
      
      if(!empty($datosInv['senias_particulares'])){
         $seniass = " $('#senias_servidor').val('".utf8_encode(str_replace('<br />','\n',$datosInv['senias_particulares']))."');";
      }else{
         $seniass ="";
      }
      
      $vehiculo = ($datosInv['tenia_vehiculo'] == 1)? " $('#vehiculo_servidor').attr('disabled',false);$('#vehiculo_servidor').click();$('#siVehiculo').slideDown();" : " $('#vehiculo_servidor2').click();";
	  $cve_vehiculo = $descripcionv = $placasv = $colorv = "";
      if(!empty($datosInv['informacion_vehiculo_id'])){
         $sqlVehiculo = "select * from informacion_vehiculo where id = " . $datosInv['informacion_vehiculo_id'] . ";";
         $datos_vehiculo = $this->query($sqlVehiculo,'arregloUnicoAsoc');
         $cve_vehiculo = ' $("#id_vehiculo").val('.$datos_vehiculo["id"].');';
         if(!empty($datos_vehiculo['descripcion'])){
            $descripcionv = " $('#desc_vehi_servidor').val('".utf8_encode(str_replace('<br />','\n',$datos_vehiculo['descripcion']))."');";
         }
         $placasv = (!empty($datos_vehiculo['placas']))? " $('#placas_servidor').val('".$datos_vehiculo['placas']."');" : "";
         $colorv = (!empty($datos_vehiculo['color']))? " $('#color_vehi_servidor').val('".utf8_encode($datos_vehiculo['color'])."');" : "";
      }else{
         $cve_vehiculo = ' $("#id_vehiculo").val("");';
      }
      echo "<script>
         ".	$nombres.$sexos.$tezs.$complexions.$colors.$edads.$estaturas.$dependencias.$otradependencias.$cargos.$identificacions.$uniformes.$seniass.$vehiculo.$cve_vehiculo.$descripcionv.$placasv.$colorv.$id_involucrado."
      </script>";
   }
   
    public function datosTestigo($cual){
      $sqlTes = "select * from testigo where id = ".$cual.";";
      $datosTes = $this->query($sqlTes,'arregloUnicoAsoc');
      $id_testigo = ' $("#id_testigo").val('.$datosTes["id"].');';
      $nombre = (!empty($datosTes['nombre']))?  "$('#nombre_testigo').val('".utf8_encode($datosTes['nombre'])."');" : "";
      $telefono = (!empty($datosTes['telefono']))? '$("#telefono_testigo").val("'.$datosTes['telefono'].'");' : "" ;
      $correo = (!empty($datosTes['correo']))?  "$('#correo_testigo').val('".$datosTes['correo']."');" : "";
      
      echo "<script>
         ".$nombre.$telefono.$correo.$id_testigo."
      </script>";
      
   }
   
   
   public function actualizaInvolucrado($datos){
      $resSol = array();
      $this->iniciaInvolucrado($datos);
      $this->actualizaInvolucradoTemp();
      $agregaDatVe = "";
      if($this->vehiculo_servidor == 1){
         if(!empty($this->info_vehiculo_id) && $this->info_vehiculo_id > 0){
            $sqlUpVe = "update informacion_vehiculo set descripcion ='".$this->desc_vehi_servidor."', placas = '".$this->placas_servidor."', color = '".$this->color_vehi_servidor."' where id = ".$this->info_vehiculo_id.";";
            $this->query($sqlUpVe,'');
         }else{
            $this->agregaInfoVehiculo();
            $agregaDatVe = ",informacion_vehiculo_id = ".$this->info_vehiculo_id." ";
         }
      }else{
          if(!empty($this->info_vehiculo_id) && $this->info_vehiculo_id > 0){
            $delInfoVe = "delete from informacion_vehiculo where id = ".$this->info_vehiculo_id.";";
            $agregaDatVe = ",informacion_vehiculo_id = null ";
          }
      }
      $sqlActInvolucrado = "UPDATE involucrado set nombre = '".$this->nombre_servidor."', sexo_id = ".$this->sexo_servidor.", tez = '".$this->tez_servidor."',
      complexion = '".$this->complexion_servidor."', color_ojos = '".$this->ojos_servidor."', edad_aprox = ".$this->edad_servidor.", estatura_aprox = ".$this->estatura_servidor.",
      dependencia_id = ".$this->dependencia_servidor.", otra_dependencia = '".$this->otra_dependencia."', cargo = '".$this->cargo_servidor."', num_identificacion = '".$this->identificacion_servidor."',
      uniforme = '".$this->uniforme_servidor."', senias_particulares = '".$this->senias_servidor."', tenia_vehiculo = '".$this->vehiculo_servidor."' ".$agregaDatVe."
      where id = ".$this->id_involucrado.";";
      $this->query($sqlActInvolucrado,'');
      if(!empty($delInfoVe)){
         $this->query($delInfoVe,'');
      }
      $resSol['estatus'] = 1;
      $resSol['mensaje'] = "El involucrado se actualizo con &eacute;xito";
      
      return $resSol;
   }
   public function actualizaInvolucradoTemp(){
      $sqlMod = "select i.*, iv.descripcion,iv.placas,iv.color from involucrado i left join informacion_vehiculo iv on i.informacion_vehiculo_id = iv.id where i.id = ".$this->id_involucrado.";";
      $_SESSION['involucradoMod'][] = $this->query($sqlMod,'arregloUnicoAsoc');
   }
   
   public function eliminaInvolucradoTemp($cual){
      $sqlTempDel = "select i.*, iv.descripcion,iv.placas,iv.color,ique.informacion_queja_id from involucrado i left join informacion_vehiculo iv on i.informacion_vehiculo_id = iv.id inner join involucrados_queja ique on ique.involucrado_id = i.id where i.id = ".$cual.";";
      $_SESSION['involucradoElim'][] = $this->query($sqlTempDel,'arregloUnicoAsoc');
   }
  
  
  
   public function agregarTestigo($info){
      $this->iniciaTestigo($info);
      $sqlInv = "insert into testigo values(null,'%s','%s','%s','".$info['cveHuerfanos']."',0);";
      $this->id_testigo = $this->query(sprintf($sqlInv,$this->nombre_testigo,$this->telefono_testigo,$this->correo_testigo),'id');
      $_SESSION["testigo"][] = $this->id_testigo;
      if($this->id_testigo > 0){
         return 1;
      }else{
         return 0;
      }
    }
   
    public function mostrarTestigoQuej($quejaId,$huerfano){
         $sqlTesti = "select t.id,t.nombre,case t.telefono when '' then '' else t.telefono end 'telefono',case t.correo when '' then '' else t.correo end 'correo'
                     from testigo t inner join testigo_queja tq on tq.testigo_id = t.id where tq.informacion_queja_id = ". $quejaId ." order by t.id; ";
         $testigos = $this->query($sqlTesti,'arregloAsociado');
         $testigosCve = $this->mostrarTestigoCve($huerfano);
         $testi = array_merge($testigos,$testigosCve);
         
         return $testi;
    }
    
   public function mostrarTestigoCve($huerfano){
         $sqlTesti = "select t.id,t.nombre,case t.telefono when '' then '' else t.telefono end 'telefono',case t.correo when '' then '' else t.correo end 'correo' from testigo t where t.clave = '".$huerfano."' order by t.id;";
         $testigos = $this->query($sqlTesti,'arregloAsociado');
         return $testigos;
   }

   public function eliminarTestigo($tipo,$cual){
      //echo $tipo;
      if($tipo == 1){ // existe id queja
         $sqlExTe = "select count(*) 'totTes' from testigo_queja where testigo_id = ".$cual.";";
         $totTe = $this->query($sqlExTe,'registro');
         if($totTe['totTes'] > 0){
            $this->eliminaTestigoTemp($cual);
         }
         
         $sqliga = "delete from testigo_queja where testigo_id = ".$cual.";";
         $this->query($sqliga,'');
      }
      $sqlTes = "delete from testigo where id = ".$cual.";";
      $this->query($sqlTes,'');
      return 1;
   }
   
   public function actualizaTestigo($datos){
      $resSol = array();
      $this->iniciaTestigo($datos);
      $this->actualizaTestigoTemp();
      $sqlActTestigo = "UPDATE testigo set nombre = '".$this->nombre_testigo."', telefono = '".$this->telefono_testigo."', correo = '".$this->correo_testigo."' where id = ".$this->id_testigo.";";
      $this->query($sqlActTestigo,'');
      $resSol['estatus'] = 1;
      $resSol['mensaje'] = "El testigo se actualizo con &eacute;xito";
      return $resSol;
   }
   
   public function actualizaTestigoTemp(){
      $sqlMod = "select t.* from testigo t where t.id = ".$this->id_testigo.";";
      $_SESSION['testigoMod'][] = $this->query($sqlMod,'arregloUnicoAsoc');
   }
   
   public function eliminaTestigoTemp($cual){
      $sqlTempDel = "select t.*,tque.informacion_queja_id from testigo t inner join testigo_queja tque on tque.testigo_id = t.id where t.id = ".$cual.";";
      $_SESSION['testigoElim'][] = $this->query($sqlTempDel,'arregloUnicoAsoc');
   }
    
    

// ---------------------------------------------------MODIFICACIONES--------------------------------------------------------------------------------------------------

   public function actualizaQuejas($datos,$archivos){
      $resSol = array();
      $this->iniciaQueja($datos);
      $agregaDatVe = "";
     
      $sqlActQueja = "UPDATE informacion_queja set hechos = '".$this->hechos."', testigos = '".$this->testigos_servidor."' where id = ".$this->id_queja.";";
      $this->query($sqlActQueja,'');
      if($this->testigos_servidor == 2){
         //$delTes = "delete tq, t from testigo_queja tq inner join testigo t where tq.testigo_id = t.id where tq.informacion_queja_id = ".$this->id_queja.";";
         $datTesQuej = "select * from testigo_queja where informacion_queja_id = ".$this->id_queja.";";
         $datTestQuej = $this->query($datTesQuej,'arregloAsociado');
         for($i = 0; $i < count($datTestQuej); $i++){
            $delTes = "delete from testigo_queja where id = ".$datTestQuej[$i]['id'].";";
            $this->query($delTes,'');
            $delTestigo = "delete from testigo where id = ".$datTestQuej[$i]['testigo_id'].";";
            $this->query($delTestigo,'');
         }
      }
      $this->ordenaTestigosEInvolucrados();
      if($this->operacionesEvidenciasQueja($archivos,$datos)){
         $resSol['estatus'] = 1;
         $resSol['mensaje'] = "La queja se actualiz&oacute; con &eacute;xito";
      }else{
         $resSol['estatus'] = 0;
         $resSol['mensaje']  = "No se logro actualizar la queja, por favor intente de nuevo";
      }
      unset($_SESSION['involucradoElim'],$_SESSION['involucradoMod'],$_SESSION['testigoElim'],$_SESSION['testigoMod']);
      return $resSol;
   }
   
    function operacionesEvidenciasQueja($archivos,$datos){
         $resEvi = array();
         $url = "../../includes/archivos/quejas/";
         $urlb = "includes/archivos/quejas/";
         $tipo = 1;
        if(!empty($archivos['pruebas_servidor']) && $archivos['pruebas_servidor']['error'] == 0){
            if(!empty($datos['id_evidencia_queja'])){
               $resEvi = $this->modificaArchivo($archivos['pruebas_servidor']['tmp_name'],$url,$archivos['pruebas_servidor']['name'],$datos['id_evidencia_queja']);
               if($resEvi['estatus_evidencia'] == 0){
                  return false;
               }
            }else{
               $resEvi = $this->cargarArchivo($archivos['pruebas_servidor']['tmp_name'],$url,$archivos['pruebas_servidor']['name'],$urlb,$tipo);
               if($resEvi['estatus_evidencia'] != 0){
                   $sqlRelArch = "insert into evidencia_queja values(null,%d,%d);";
                   $this->query(sprintf($sqlRelArch,$resEvi['id_evidencia'],$this->id_queja),'');
               }else{
                   return false;
               }
            }
            
        }
        return true;
    }

    //-------------------------------------------------------------reporte mensual---------------------------------------------------------------------------
    public function totalQuejas($fecha_inicio_re,$fecha_final_re,$estado,$e){
      $totQueNva = $this->totalQuejasNva($fecha_inicio_re,$fecha_final_re,$estado);
      $totQueOIC = $this->totalQuejasOIC($fecha_inicio_re,$fecha_final_re,$estado);
      $totQueDNPP = $this->totalQuejasDNPP($fecha_inicio_re,$fecha_final_re,$estado);
      $totQueCon = $this->totalQuejasConcluida($fecha_inicio_re,$fecha_final_re,$estado,$e);
      $totQueGRAL = ($totQueOIC['total'] + $totQueDNPP['total'] + $totQueNva['total'] + $totQueCon);
      return $totQueGRAL;
    }
    
    public function totalQuejasOIC($fecha_inicio_re,$fecha_final_re,$estado){
      $inicio = new DateTime($fecha_inicio_re);
      $fin = new DateTime($fecha_final_re);
      $queryTot = "select count(*) 'total' from solicitud s
                  inner join historial_estatus he on s.id = he.solicitud_id
                  where (s.fecha_recepcion >= '".$inicio->format('Y-m-d')."' and s.fecha_recepcion <= '".$fin->format('Y-m-d')."') and s.tipo_registro_operacion_id = 1 ".$estado."
                  and he.cve_estatus = 4
                  and (select count(*) from historial_estatus where solicitud_id = s.id and cve_estatus = 5) = 0;";
      $total = $this->query($queryTot,'registro');
      return $total;
    }
    
    public function totalQuejasDNPP($fecha_inicio_re,$fecha_final_re,$estado){
      $inicio = new DateTime($fecha_inicio_re);
      $fin = new DateTime($fecha_final_re);
      $queryTot = "select count(*) 'total' from solicitud s inner join historial_estatus he on s.id = he.solicitud_id
                  where (s.fecha_recepcion >= '".$inicio->format('Y-m-d')."' and s.fecha_recepcion <= '".$fin->format('Y-m-d')."')
                  and s.tipo_registro_operacion_id = 1 ".$estado."
                  and he.cve_estatus = 5
                  and (select cve_estatus from historial_estatus where solicitud_id = s.id and activo = 1) != 2;";
      $total = $this->query($queryTot,'registro');
      return $total;
    }
    
   public function totalQuejasNva($fecha_inicio_re,$fecha_final_re,$estado){
      $inicio = new DateTime($fecha_inicio_re);
      $fin = new DateTime($fecha_final_re);
       $queryTot = "select count(*) 'total' from solicitud s inner join historial_estatus he on s.id = he.solicitud_id
                  where (s.fecha_recepcion >= '".$inicio->format('Y-m-d')."' and s.fecha_recepcion <= '".$fin->format('Y-m-d')."')
                  and s.tipo_registro_operacion_id = 1 ".$estado."
                  and he.cve_estatus = 1
                  and activo = 1";
      $total = $this->query($queryTot,'registro');
      return $total;
    }
    /*
   public function totalQuejasConcluida($fecha_inicio_re,$fecha_final_re,$estado,$e){
      $inicio = new DateTime($fecha_inicio_re);
      $fin = new DateTime($fecha_final_re);
      $rol = $this->obtenerRol($_SESSION['rol_usuario_id']);
       $queryTot = "select count(*) 'total' from solicitud s inner join historial_estatus he on s.id = he.solicitud_id
                  where (s.fecha_recepcion >= '".$inicio->format('Y-m-d')."' and s.fecha_recepcion <= '".$fin->format('Y-m-d')."')
                  and s.tipo_registro_operacion_id = 1 ".$estado."
                  and he.cve_estatus = 3
                  and he.activo = 1;";
      $concluidas = (($rol == 1 || $rol == 5) && $e == $_SESSION['edo_rep'])? " and (he.asignado = 5 or he.asignado = 1) " : " and he.asigno = ".$rol;
      $queryTot = sprintf($queryTot, $concluidas);
      $total = $this->query($queryTot,'registro');
      return $total;
    }
    */
    public function totalQuejasConcluida($fecha_inicio_re,$fecha_final_re,$estado,$e){
      $inicio = new DateTime($fecha_inicio_re);
      $fin = new DateTime($fecha_final_re);
      $totCon = 0;
      $rol = $this->obtenerRol($_SESSION['rol_usuario_id']);
      $queryTot = "select s.* from solicitud s inner join historial_estatus he on s.id = he.solicitud_id
                  where (s.fecha_recepcion >= '".$inicio->format('Y-m-d')."' and s.fecha_recepcion <= '".$fin->format('Y-m-d')."')
                  and s.tipo_registro_operacion_id = 1 ".$estado."
                  and he.cve_estatus = 3
                  and he.activo = 1;";
     // $queryTot = sprintf($queryTot, $concluidas);
      //print_r($queryTot);
      $total = $this->query($queryTot,'arregloAsociado');
      //print_r($total);
      //echo count($total);
      for($i=0; $i < count($total); $i++){
         $sqlAsig = "select count(*) 'total' from solicitud s inner join historial_estatus he on s.id = he.solicitud_id where s.id = ".$total[$i]['id']." and (he.cve_estatus = 4 or he.cve_estatus = 5);";
         $asig = $this->query($sqlAsig,'registro');
         if($asig['total'] > 0){
            $totCon++;
         }
      }
      return  (count($total) - $totCon);
    }
    
   
   
}


?>