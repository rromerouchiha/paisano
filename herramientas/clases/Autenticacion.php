<?php
date_default_timezone_set("Mexico/General");
class Autenticacion extends ConexionMySQL{
    private $usuario;
    private $clave;
    
    public function __construct($usuario,$clave,$serv,$usua,$clav,$base='',$puerto=''){
        parent::__construct($serv,$usua,$clav,$base,$puerto);
        $this->usuario = htmlspecialchars(trim($usuario), ENT_QUOTES);
        $this->clave = htmlspecialchars(trim($clave), ENT_QUOTES);
    }
    
    public function protegeCla(){
        $this->clave = md5($this->clave.CINICIO);
        //echo $this->clave;
    }
    
    public function valIngreso(){ 
        $consulta = "select u.id, u.nombre, u.paterno, u.materno, Concat(u.nombre, ' ', u.paterno, ' ', u.materno) 'n_completo',u.donde_representante_o_enlace_id 'edo_rep', e.nombre_estado,u.usuario_cuenta,u.rol_usuario_id,cr.rol,e.gmt from usuario u inner join rol_usuario cr on u.rol_usuario_id = cr.id left join estado e on u.donde_representante_o_enlace_id = e.id WHERE u.usuario_cuenta = '%s' and u.clave = '%s' and estatus_id = 1;";
        $consulta = sprintf($consulta,$this->usuario,$this->clave);
        $hay = $this->query($consulta,'numeroRegistros');
        #echo $hay;
        if($hay >= 1){
            $usuario = $this->query($consulta,'arregloAsociado');
            $usuario[0]['existe'] = 1;
            return $usuario;
        }else{
            return array(array('existe' => 0));
        }
    }
    
    public function verAutenticacion(){
        $this->protegeCla();
        return $this->creaSesion($this->valIngreso());
    }
    
    public function creaSesion($usu){
        if($usu[0]['existe'] == 1){
            foreach($usu as $clave => $valor){
                foreach($valor as $in => $val){
                    $_SESSION[$in] = $val;
                }
            }
            $_SESSION['autenticacion'] = md5(date('z').'PAI');
            $_SESSION['rol_usuario_id'] = md5($_SESSION['rol_usuario_id']);
            $_SESSION['cveHu'] = "1234";
            return true;
        }else{
            $this->cerrarSesion();
            return false;
        }
    }
    public function cerrarSesion(){
        session_destroy();
    }
   
     
}


?>