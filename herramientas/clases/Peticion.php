<?php
error_reporting(E_ALL);
ini_set('display_errors','1');

class Peticion extends Solicitud{
   private $id_peticion;
   private $solicitud;
   private $observaciones;
   private $dependencia_peticion;
   private $otra_dependencia;
   
   
    public function __construct($serv,$usua,$clav,$base='',$puerto=''){
        parent::__construct($serv,$usua,$clav,$base,$puerto);
    }
    

     function iniciaPeticion($info){
        $this->id_peticion = (!empty($info['id_peticion']))? $info['id_peticion']: 0;
        $this->solicitud = utf8_decode($info['solicitud_peticion']);
        $this->observaciones = utf8_decode($info['describe_peticion']);
        $this->dependencia_peticion = $info['dependencia_peticion'];
        $this->otra_dependencia = (!empty($info['otra_dep_pet']))? $info['otra_dep_pet'] : null;
        $this->fecha_hoy = new DateTime();
    }
    
    function agregaPeticion($info,$idusu_reg,$estado, $rol, $archivos){
        $this->iniciaPeticion($info);
        $resSol = $this->creaSolicitud($info,$idusu_reg,$estado, $rol);
        $resSol['log'] = (!empty($resSol['log']))? $resSol['log'] : '';
        if($resSol['estatus'] == 1){
            
            $sqlNvaPet = "insert into informacion_peticion values(null,'%s','%s',%d,'%s');";
            $this->id_peticion = $this->query(sprintf($sqlNvaPet,$this->solicitud,$this->observaciones,$this->getIdSol(),$this->otra_dependencia),'id');
            
            if($this->id_peticion != 0){
                if($this->cargaEvidenciasPet($archivos)){
                    $this->cargaDependencias();
                    if($info['causa'] == 18){
                        if($this->cargaIdentificaciones($archivos)){
                            $resSol['num_folio'] = $this->getIdFolio();
                            $resSol['estatus'] = 1;
                            $resSol['log'] .= "identificaciones cargada con exito";
                        }else{
                            $resSol['log'] .= "No se cargo Identificaciones";
                            $resSol['estatus'] = 0;
                        }
                    }else{
                        $resSol['estatus'] = 1;
                        $resSol['log'] .= "peticion cargada con exito";
                        $resSol['num_folio'] = $this->getIdFolio();
                    }

                }else{
                    $resSol['log'] .= "No se cargo Evidencia";
                    $resSol['estatus'] = 0;
                }
            }else{
                $resSol['log'] .= "No se agrego peticion";
                $resSol['estatus'] = 0;
            }
        }else{
            $resSol['log'] .= "No se agrego Solicitud";
            $resSol['estatus'] = 0;
        }
        return $resSol;
        
    }
    
    
    function cargaEvidenciasPet($archivos){
        $resEvi = array();
        if(!empty($archivos['archivo_peticion']) && $archivos['archivo_peticion']['error'] == 0){
            $url = "../../includes/archivos/peticiones/";
            $urlb = "includes/archivos/peticiones/";
            $tipo = 4;
            $resEvi = $this->cargarArchivo($archivos['archivo_peticion']['tmp_name'],$url,$archivos['archivo_peticion']['name'],$urlb,$tipo);
            if($resEvi['estatus_evidencia'] != 0){
                $sqlRelArch = "insert into evidencia_peticion values(null,%d,%d);";
                $this->query(sprintf($sqlRelArch,$this->id_peticion,$resEvi['id_evidencia']),'');
                return true;
            }else{
                return false;
            }
        }else{
            return true;
        }
    }
    
    function operacionesEvidenciasPet($archivos,$datos){
         $resEvi = array();
         $url = "../../includes/archivos/peticiones/";
         $urlb = "includes/archivos/peticiones/";
         $tipo = 4;
        if(!empty($archivos['archivo_peticion']) && $archivos['archivo_peticion']['error'] == 0){
            if(!empty($datos['id_evidencia_peticion'])){
               $resEvi = $this->modificaArchivo($archivos['archivo_peticion']['tmp_name'],$url,$archivos['archivo_peticion']['name'],$datos['id_evidencia_peticion']);
               if($resEvi['estatus_evidencia'] == 0){
                  return false;
               }
            }else{
               $resEvi = $this->cargarArchivo($archivos['archivo_peticion']['tmp_name'],$url,$archivos['archivo_peticion']['name'],$urlb,$tipo);
               if($resEvi['estatus_evidencia'] != 0){
                   $sqlRelArch = "insert into evidencia_peticion values(null,%d,%d);";
                   $this->query(sprintf($sqlRelArch,$this->id_peticion,$resEvi['id_evidencia']),'');
               }else{
                   return false;
               }
            }
            
        }
        return true;
    }
    
    
    function cargaIdentificaciones($archivos){
         $resEvi2 = $resEvi = array();
         $url = "../../includes/archivos/peticiones/identificaciones/";
         $urlb = "includes/archivos/peticiones/identificaciones/";
         $sqlRelArch = "insert into evidencia_peticion values(null,%d,%d);";
         if(!empty($archivos['id_solicitante_a']) && $archivos['id_solicitante_a']['error'] == 0){
            $resEvi = $this->cargarArchivo($archivos['id_solicitante_a']['tmp_name'],$url,$archivos['id_solicitante_a']['name'],$urlb,2);
            if($resEvi['estatus_evidencia'] != 0){
                $this->query(sprintf($sqlRelArch,$this->id_peticion,$resEvi['id_evidencia']),'');
            }else{
                return false;
            }
        }
        if(!empty($archivos['id_alocalizar']) && $archivos['id_alocalizar']['error'] == 0){
            $resEvi2 = $this->cargarArchivo($archivos['id_alocalizar']['tmp_name'],$url,$archivos['id_alocalizar']['name'],$urlb,3);
            if($resEvi2['estatus_evidencia'] != 0){
               $this->query(sprintf($sqlRelArch,$this->id_peticion,$resEvi2['id_evidencia']),'');
            }else{
               return false;
            }
        }
        return true;
    }
    
    function cargaDependencias(){
        $sqlDepPet = "insert into dependencia_contactada values(null,%d,%d);";
        for($i = 0; $i < count($this->dependencia_peticion);$i++){
            $this->query(sprintf($sqlDepPet,$this->id_peticion,$this->dependencia_peticion[$i]),'');
        }
    }
   
   public function actualizaPeticion($datos,$archivos){
      $resSol = array();
      $this->iniciaPeticion($datos);
      $sqlActPet = "UPDATE informacion_peticion set solicitud = '".$this->solicitud."', observaciones = '".$this->observaciones."',otra_dependencia = '".$this->otra_dependencia."' where id = ".$this->id_peticion.";";
      if($this->query($sqlActPet,'')){
         $sqlDelDep = "delete from dependencia_contactada where peticion_id = ".$this->id_peticion.";";
         $this->query($sqlDelDep,'');
         $this->cargaDependencias();
         if($datos['causa'] == 18){
            if($this->operacionIdentificaciones($archivos,$datos)){
               $resSol['log'] = "identificaciones cargada con exito";
            }else{
               $resSol['log'] = "No se cargo Identificaciones";
            }
         }else{
            if(!empty($datos['id_solicitante_archivo']) && !empty($datos['id_alocalizar_archivo'])){
               $sqlDatEvid = "select concat('../../',ruta_arch,nombre_arch) 'archivo' from evidencia where id = %d;";
              // echo sprintf($sqlDatEvid,$datos['id_solicitante_archivo']);
               $solicitante_datos = $this->query(sprintf($sqlDatEvid,$datos['id_solicitante_archivo']),'arregloUnicoAsoc');
               //print_r($solicitante_datos);
               $alocalizar_datos = $this->query(sprintf($sqlDatEvid,$datos['id_alocalizar_archivo']),'arregloUnicoAsoc');
               if(file_exists($solicitante_datos['archivo'])){
                unlink($solicitante_datos['archivo']);
               }
               if(file_exists($alocalizar_datos['archivo'])){
                unlink($alocalizar_datos['archivo']);
               }
               $sqlDelEvid = "delete from evidencia where id = %d;";
               $sqlEvidPet = "delete from evidencia_peticion where evidencia_id = %d;";
               $this->query(sprintf($sqlEvidPet,$datos['id_solicitante_archivo']),'');
               $this->query(sprintf($sqlDelEvid,$datos['id_solicitante_archivo']),'');
               $this->query(sprintf($sqlEvidPet,$datos['id_alocalizar_archivo']),'');
               $this->query(sprintf($sqlDelEvid,$datos['id_alocalizar_archivo']),'');
               
            }
         }
         if($this->operacionesEvidenciasPet($archivos,$datos)){
            $resSol['estatus'] = 1;
            $resSol['mensaje'] = "La petici&oacute;n se actualiz&oacute; con &eacute;xito";
         }

      }else{
         $resSol['log'] .= "No se modifico petición";
         $resSol['estatus'] = 0;
         $resSol['mensaje']  = "No se logro actualizar la petici&oacute;n, por favor intente de nuevo";
      }
      return $resSol;
   }
   
   function operacionIdentificaciones($archivos,$datos){
      $resEvi2 = $resEvi = array();
      $url = "../../includes/archivos/peticiones/identificaciones/";
      $urlb = "includes/archivos/peticiones/identificaciones/";
      $sqlRelArch = "insert into evidencia_peticion values(null,%d,%d);";
      if(!empty($archivos['id_solicitante_a']) && $archivos['id_solicitante_a']['error'] == 0){
         if(!empty($datos['id_solicitante_archivo'])){
            $resEvi = $this->modificaArchivo($archivos['id_solicitante_a']['tmp_name'],$url,$archivos['id_solicitante_a']['name'],$datos['id_solicitante_archivo']);
            if($resEvi['estatus_evidencia'] == 0){
               return false;
            }
         }else{
            $resEvi = $this->cargarArchivo($archivos['id_solicitante_a']['tmp_name'],$url,$archivos['id_solicitante_a']['name'],$urlb,2);
            if($resEvi['estatus_evidencia'] != 0){
                $this->query(sprintf($sqlRelArch,$this->id_peticion,$resEvi['id_evidencia']),'');
            }else{
                return false;
            }
         }
         
      }
      if(!empty($archivos['id_alocalizar']) && $archivos['id_alocalizar']['error'] == 0){
         if(!empty($datos['id_alocalizar_archivo'])){
            $resEvi2 = $this->modificaArchivo($archivos['id_alocalizar']['tmp_name'],$url,$archivos['id_alocalizar']['name'],$datos['id_alocalizar_archivo']);
            if($resEvi2['estatus_evidencia'] == 0){
               return false;
            }
         }else{
            $resEvi2 = $this->cargarArchivo($archivos['id_alocalizar']['tmp_name'],$url,$archivos['id_alocalizar']['name'],$urlb,3);
            if($resEvi2['estatus_evidencia'] != 0){
               $this->query(sprintf($sqlRelArch,$this->id_peticion,$resEvi2['id_evidencia']),'');
            }else{
               return false;
            }
         }
         
      }
      return true;
   }
   
   //-------------------------------------------reporte mensual------------------------------------------------------------------------------------
   
   public function totPeticiones($fecha_inicio_re,$fecha_final_re,$estado,$e){
      $totPetNva = $this->totalPeticionesNva($fecha_inicio_re,$fecha_final_re,$estado);
      $totPetOIC = $this->totalPeticionesOIC($fecha_inicio_re,$fecha_final_re,$estado);
      $totPetDNPP = $this->totalPeticionesDNPP($fecha_inicio_re,$fecha_final_re,$estado);
      $totPetCon = $this->totalPeticionesConcluida($fecha_inicio_re,$fecha_final_re,$estado,$e);
      $totPetGRAL = ($totPetOIC['total'] + $totPetDNPP['total'] + $totPetNva['total'] + $totPetCon);
      return $totPetGRAL;
   }
   
    public function totalPeticionesOIC($fecha_inicio_re,$fecha_final_re,$estado){
      $inicio = new DateTime($fecha_inicio_re);
      $fin = new DateTime($fecha_final_re);
      $queryTot = "select count(*) 'total' from solicitud s
                  inner join historial_estatus he on s.id = he.solicitud_id
                  where (s.fecha_recepcion >= '".$inicio->format('Y-m-d')."' and s.fecha_recepcion <= '".$fin->format('Y-m-d')."')
                  and s.tipo_registro_operacion_id = 2 ".$estado."
                  and he.cve_estatus = 4
                  and (select count(*) from historial_estatus where solicitud_id = s.id and cve_estatus = 5) = 0;";
      $total = $this->query($queryTot,'registro');
      return $total;
    }
    
    public function totalPeticionesDNPP($fecha_inicio_re,$fecha_final_re,$estado){
      $inicio = new DateTime($fecha_inicio_re);
      $fin = new DateTime($fecha_final_re);
      $queryTot = "select count(*) 'total' from solicitud s inner join historial_estatus he on s.id = he.solicitud_id
                  where (s.fecha_recepcion >= '".$inicio->format('Y-m-d')."' and s.fecha_recepcion <= '".$fin->format('Y-m-d')."')
                  and s.tipo_registro_operacion_id = 2 ".$estado."
                  and he.cve_estatus = 5
                  and (select cve_estatus from historial_estatus where solicitud_id = s.id and activo = 1) != 2;";
      $total = $this->query($queryTot,'registro');
      return $total;
    }
    
    public function totalPeticionesNva($fecha_inicio_re,$fecha_final_re,$estado){
      $inicio = new DateTime($fecha_inicio_re);
      $fin = new DateTime($fecha_final_re);
      $queryTot = "select count(*) 'total' from solicitud s inner join historial_estatus he on s.id = he.solicitud_id
                  where (s.fecha_recepcion >= '".$inicio->format('Y-m-d')."' and s.fecha_recepcion <= '".$fin->format('Y-m-d')."')
                  and s.tipo_registro_operacion_id = 2 ".$estado."
                  and he.cve_estatus = 1
                  and activo = 1";
      $total = $this->query($queryTot,'registro');
      return $total;
    }
    /*
    public function totalPeticionesConcluida($fecha_inicio_re,$fecha_final_re,$estado,$e){
      $inicio = new DateTime($fecha_inicio_re);
      $fin = new DateTime($fecha_final_re);
      $rol = $this->obtenerRol($_SESSION['rol_usuario_id']);
      $queryTot = "select count(*) 'total' from solicitud s inner join historial_estatus he on s.id = he.solicitud_id
                  where (s.fecha_recepcion >= '".$inicio->format('Y-m-d')."' and s.fecha_recepcion <= '".$fin->format('Y-m-d')."')
                  and s.tipo_registro_operacion_id = 2 ".$estado."
                  and he.cve_estatus = 3
                  and he.activo = 1;";
      $concluidas = (($rol == 1 || $rol == 5) && $e == $_SESSION['edo_rep'])? " and (he.asignado = 5 or he.asignado = 1) " : " and he.asigno = ".$rol;
      $queryTot = sprintf($queryTot, $concluidas);
      $total = $this->query($queryTot,'registro');
      return $total;
    }*/
    
     public function totalPeticionesConcluida($fecha_inicio_re,$fecha_final_re,$estado,$e){
      $inicio = new DateTime($fecha_inicio_re);
      $fin = new DateTime($fecha_final_re);
      $totCon = 0;
      $rol = $this->obtenerRol($_SESSION['rol_usuario_id']);
      $queryTot = "select s.* from solicitud s inner join historial_estatus he on s.id = he.solicitud_id
                  where (s.fecha_recepcion >= '".$inicio->format('Y-m-d')."' and s.fecha_recepcion <= '".$fin->format('Y-m-d')."')
                  and s.tipo_registro_operacion_id = 2 ".$estado."
                  and he.cve_estatus = 3
                  and he.activo = 1;";
      //$queryTot = sprintf($queryTot, $concluidas);
      //print_r($queryTot);
      $total = $this->query($queryTot,'arregloAsociado');
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