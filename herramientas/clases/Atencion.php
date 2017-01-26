<?php
error_reporting(E_ALL);
ini_set('display_errors','1');

class Atencion extends ConexionMySQL{
    private $id;
    private $folio_id;
    private $folio_cadena;
    private $fecha_registro;
    private $tipo_atencion;
    private $tema_id;
    private $otro_tema;
    private $sedes;
    private $npersonas;
    private $persona_atendida_id;
    private $nombre;
    private $apellidos;
    private $sexo_id;
    private $nacionalidad;
    private $estado_origen_id;
    private $ciudad_origen_id;
    private $estado_residencia_id;
    private $ciudad_residencia_id;
    private $telefono;
    private $correo;
    
   public function __construct($serv,$usua,$clav,$base='',$puerto=''){
        parent::__construct($serv,$usua,$clav,$base,$puerto);
        date_default_timezone_set('America/Mexico_City');
    }
    
    public function iniciaAtencionRepresentante($info){
        $this->id = (!empty($info['id_atencion']))? $info['id_atencion'] : 0;
        $this->fecha_registro = (!empty($info['fecha_registro']))? $info['fecha_registro'] : '';
        $this->tipo_atencion = (!empty($info['tipo_atencion']))? $info['tipo_atencion'] : 0;
        $this->tema_id = (!empty($info['tema']))? $info['tema'] : 0;
        $this->otro_tema = (!empty($info['otro_tema']))? trim($info['otro_tema']) : '';
        $this->sedes = (!empty($info['sedes']))? $info['sedes'] : '';
        $this->npersonas = (!empty($info['npersonas']))? $info['npersonas'] : 'null';
        $this->persona_atendida_id = (!empty($info['persona_atendida_id']))? $info['persona_atendida_id'] : 0;
        $this->nombre = (!empty($info['nombre']))? $info['nombre'] : '';
        $this->apellidos = (!empty($info['apellidos']))? $info['apellidos'] : '';
        $this->sexo_id = (!empty($info['sexo']))? $info['sexo'] : 'null';
        $this->nacionalidad = (!empty($info['nacionalidad']))? $info['nacionalidad']: "null";
        $this->estado_origen_id = (!empty($info['estado_origen']))? $info['estado_origen']: "null";
        $this->ciudad_origen_id = (!empty($info['ciudad_origen']))? $info['ciudad_origen']: "null";
        $this->estado_residencia_id = (!empty($info['estado_residencia']))? $info['estado_residencia']: "null";
        $this->ciudad_residencia_id = (!empty($info['ciudad_residencia']))? $info['ciudad_residencia']: "null";
        $this->correo = (!empty($info['correo']))? trim($info['correo']): "";
        $this->telefono = (!empty($info['telefono']))? trim($info['telefono']): "";
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
        $this->folio_id = $this->query(sprintf($sqlFolio,3),'id');
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
    
        public function formAtencionRepresentante(){
        echo '<form role="form" action="herramientas/funciones/atencion.php" id="arepForm" method="POST" target="opcFrameAR" >
                <input type="hidden" name="id_atencion" id="id_atencion" />
                <input type="hidden" name="persona_atendida_id" id="persona_atendida_id" />
                <input type="hidden" name="opcionEd" id="opcionEd" />
                <div id="atencionRep">
                    <h4>Datos de la atenci&oacute;n</h4><br/>
                    <div class="row oculta" id="muestra_folio">
                        <div class="form-group col-md-4">
                            <label for="folio_m" class="control-label">Folio</label>
                            <input type="text" name="folio_m" id="folio_m" class="form-control input-sm" />
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-4">
                            <label for="fecha_registro" class="control-label">Fecha de registro<span class="required-tag">*</span>:</label>
                            <div class="input-group date" id="fecha_registrod">
                                <input type="text" class="form-control input-sm" id="fecha_registro" name="fecha_registro"/>
                                <span class="input-group-addon glyphicon glyphicon-calendar" id="glyph_registro"></span>
                            </div>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="tipo_atencion" class="control-label">Tipo atenci&oacute;n<span class="required-tag">*</span>:</label>
                            <select class="form-control input-sm" id="tipo_atencion" name="tipo_atencion"></select>
                        </div>
                        <div class="form-group col-md-4">
                             <label for="tema" class="control-label">Tema<span class="required-tag">*</span>:</label>
                             <select class="form-control input-sm" id="tema" name="tema"></select>
                        </div>
                    </div>
                    <div class="row oculta" id="otro_temaDiv">
                        <div class="form-group col-md-8"></div>
                        <div class="form-group col-md-4" >
                           <label for="otro_tema" class="control-label">Otro tema<span class="required-tag">*</span>:</label>
                           <input type="text" class="form-control input-sm" id="otro_tema" name="otro_tema"/>
                        </div>
                    </div>
                    
                    
                    <br/><h4>Informaci&oacute;n de la atenci&oacute;n grupal</h4><br/>
                    <div class="row">
                        <div class="form-group col-md-4">
                            <label for="sedes" class="control-label">Sedes:</label>
							<input type="text" class="form-control input-sm grupalre" id="sedes" name="sedes"/>
                        </div>
                         <div class="form-group col-md-4">
                            <label class="control-label" for="npersonas">No. Personas:</label>
                            <input type="number" class="form-control input-sm grupalre" name="npersonas" id="npersonas"/>
                        </div>
                    </div>

                    <br/><h4>Informaci&oacute;n de la persona atendida</h4><br/>
                    <div class="row">
                        <div class="form-group col-md-4">
                             <label for="nombre" class="control-label">Nombre<span class="required-tag">*</span>:</label>
                            <input type="text" class="form-control input-sm " id="nombre" name="nombre" />
                        </div>
                        <div class="form-group col-md-4">
                             <label for="apellidos" class="control-label">Apellidos<span class="required-tag">*</span>:</label>
                            <input type="text" class="form-control input-sm " id="apellidos" name="apellidos"/>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="sexoq" class="control-label ">Sexo<span class="required-tag">*</span>:</label>
                            <select class="form-control input-sm" id="sexo" name="sexo"></select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-4">
                             <label for="nacionalidad" class="control-label">Nacionalidad:</label>
                            <select class="form-control input-sm " id="nacionalidad" name="nacionalidad"></select>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="estado_origen" class=" control-label">Estado de origen:</label>
                            <select class="form-control input-sm " id="estado_origen" name="estado_origen"></select>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="ciudad_origen" class="control-label">Ciudad/Condado de origen:</label>
                            <select class="form-control input-sm " id="ciudad_origen" name="ciudad_origen"></select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-4">
                            <label for="estado_residencia" class=" control-label">Estado de residencia:</label>
                            <select class="form-control input-sm " id="estado_residencia" name="estado_residencia"></select>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="ciudad_residencia" class="control-label">Ciudad/Condado de residencia:</label>
                            <select class="form-control input-sm " id="ciudad_residencia" name="ciudad_residencia"></select>
                        </div>
                    </div>
                    
                    <br/><h4>Datos de contacto de la persona atendida</h4>
                    <p class="text-primary alert alert-info" id="obliContacto">Se deber&aacute; capturar al menos uno de los siguientes campos.</p>
                     <div class="row">
                        <div class="form-group col-md-4">
                             <label for="telefono" class="control-label">Tel&eacute;fono<span class="required-tag">*</span>:</label>
                            <input type="text" class="form-control input-sm obliC" id="telefono" name="telefono" />
                        </div>
                        <div class="form-group col-md-4">
                            <label for="correo" class="control-label">Correo<span class="required-tag">*</span>:</label>
                            <input type="text" class="form-control input-sm obliC" id="correo" name="correo" />
                        </div>                       
                    </div>
                   
                    <div class="row ocultaVer">
                        <div class="form-group col-md-8"></div>
                        <div class="form-group col-md-4">
                            <div class="pull-right">
                                <button name="limpiaratre" id="limpiaratre" class="btn btn-default">Limpiar</button>
                                <button name="guardaratere" id="guardaratere" class="btn btn-success">Guardar</button>
                            </div>
                        </div>
                    </div> 
                </div>
            </form>
            <div id="mensajeSol"></div>
            <iframe id="opcFrameAR" name="opcFrameAR" style="display:none;"></iframe>
        ';
    }
    
    
    public function agregarAtencionRepresentante($datos){
        
    }
    
    
}

?>