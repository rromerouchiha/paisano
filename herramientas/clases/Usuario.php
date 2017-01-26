<?php
error_reporting(E_ALL);
ini_set('display_errors','1');

class Usuario  extends ConexionMySQL{
    private $nombre;
    private $paterno;
    private $materno;
    private $sexo;
    private $fecha_nacimiento;
    private $correo;
    private $usuario_cuenta;
    private $clave;
    private $estatus;
    private $fecha_registro;
    private $rol_usuario;
    private $asignado;

     
    public function __construct($serv,$usua,$clav,$base='',$puerto=''){
        parent::__construct($serv,$usua,$clav,$base,$puerto);
    }
    
    public function iniciarUsuario($Nusuario){
        $this->nombre = utf8_decode(trim($Nusuario['nombre']));
        $this->paterno = utf8_decode(trim($Nusuario['paterno']));
        $this->materno = utf8_decode(trim($Nusuario['materno']));
        $this->sexo = $Nusuario['sexo'];
		$this->fecha_nacimiento = '';
		if(!empty($Nusuario['fecha_nacimiento'])){
			$fecha_nac = new DateTime($Nusuario['fecha_nacimiento']);
			$this->fecha_nacimiento = $fecha_nac->format('Y-m-d');
		}
        $this->correo = (!empty($Nusuario['correo']))? trim($Nusuario['correo']) : '';
        $this->usuario_cuenta = trim($Nusuario['usuario']);
        $this->clave = md5(trim($Nusuario['clave']).CINICIO);
        $this->estatus = $Nusuario['estatus'];
        $this->fecha_registro = date('Y-m-d');
        $this->rol_usuario = (!empty($Nusuario['rol']))? $Nusuario['rol']: "0";
        $this->asignado = $Nusuario['asignado'];
        
    }
    
    public function agregarUsuario($usu){
		$resultado = array();
		$this->iniciarUsuario($usu);
		//print_r($usu);
		$sqlNvoUsr = "insert into usuario values(null,'%s','%s','%s',%d,'%s','%s','%s','%s',%d,'%s',%d,%d);";
		$sqlNvoUsr = sprintf($sqlNvoUsr,$this->nombre,$this->paterno,$this->materno,$this->sexo,$this->fecha_nacimiento,$this->correo,$this->usuario_cuenta,$this->clave,$this->estatus,$this->fecha_registro,$this->rol_usuario,$this->asignado);
		$id = $this->query($sqlNvoUsr,'id');
		if(!empty($id)){
			if($this->establecerPermisos($usu,$id)){
				$resultado['estado'] = 1;
				$resultado['men'] = "El usuario fue agregado con &eacute;xito.";
			}
		}else{
			$resultado['estado'] = 0;
			$resultado['men'] = "No fue posible agregar el usuario, int&eacute;ntelo de nuevo.";
		}
		return $resultado;
		
    }
	
	public function establecerPermisos($usu,$id){
		$permisosSQL = "SELECT apr.*,a.clave  FROM accion_por_rol apr inner join accion a on apr.accion_id = a.id where apr.rol_usuario_id = ".$this->rol_usuario." order by a.nivel_menu_id;";
		$permisos = $this->query($permisosSQL,'arregloAsociado');
		$aqlCancela = "UPDATE permiso set activo = false where usuario_id = " . $id . ";";
		$this->query($aqlCancela,'');
		if(!empty($id)){
			for($i = 0; $i < count($permisos);$i++){
				$activo = 0;
				if(!empty($usu[$permisos[$i]['clave']])){
					$activo = true;
				}				
				$sqlBusPer = "select id from permiso where accion_id = ".$permisos[$i]['accion_id']." and usuario_id = ".$id.";";
				$per_existe = $this->query($sqlBusPer,'registro');
				
				if(!empty($per_existe) && count($per_existe) > 0){
					$sqPer = "update permiso set activo = ".$activo." where id = ".$per_existe['id'].";";
				}else{
					$sqPer = "insert into permiso values (null,".$permisos[$i]['accion_id'].",".$id.",".$activo.");";
				}
				
				$this->query($sqPer,'');
			}
			return true;
		}else{
			return false;
		}
	}
    
    public function modificarUsuario($usu){
		$this->iniciarUsuario($usu);
		
		if(!empty($usu['rol']) && $usu['rol'] > 0){
			$permisos = $this->establecerPermisos($usu,$usu['id']);
			$this->rol_usuario = "rol_usuario_id = ".$usu['rol'].","; 
		}else{
			$permisos = true;
			$this->rol_usuario = "";
		}
		
		if($usu['clave'] != ''){
			$sqlActUsr = "Update usuario set nombre = '%s', paterno = '%s', materno = '%s',sexo_id = %d, fecha_nacimiento = '%s', correo = '%s', usuario_cuenta = '%s', clave = '%s', estatus_id = %d,%s donde_representante_o_enlace_id = %d where id = %d;";
			$sqlActUsr = sprintf($sqlActUsr,$this->nombre,$this->paterno,$this->materno,$this->sexo,$this->fecha_nacimiento,$this->correo,$this->usuario_cuenta,$this->clave,$this->estatus,$this->rol_usuario,$this->asignado,$usu['id']);
		}else{
			$sqlActUsr = "Update usuario set nombre = '%s', paterno = '%s', materno = '%s',sexo_id = %d, fecha_nacimiento = '%s', correo = '%s', usuario_cuenta = '%s', estatus_id = %d,%s donde_representante_o_enlace_id = %d where id = %d;";
			$sqlActUsr = sprintf($sqlActUsr,$this->nombre,$this->paterno,$this->materno,$this->sexo,$this->fecha_nacimiento,$this->correo,$this->usuario_cuenta,$this->estatus,$this->rol_usuario,$this->asignado,$usu['id']);
		}
       // echo $sqlActUsr;
		if($this->query($sqlActUsr,'')){
			if($permisos){
				$resultado['estado'] = 1;
				$resultado['men'] = "Se actualiz&oacute; el usuario con &eacute;xito .";
			}else{
				$resultado['estado'] = 0;
				$resultado['men'] = "No fue posible actualizar los permisos del usuario, int&eacute;ntelo de nuevo.";
			}
		}else{
			$resultado['estado'] = 0;
			$resultado['men'] = "No fue posible actualizar la informaci&oacute;n del usuario, int&eacute;ntelo de nuevo.";
		}
		return $resultado;
	}
    
    public function eliminarUsuario($usu){
			$sqlEli = "Update usuario set estatus_id = 3 where id = %d";
			$sqlEli = sprintf($sqlEli,$usu['id']);
			$this->query($sqlEli,'');
			$resultado['men'] = "Se elimin&oacute; el usuario con &eacute;xito.";
			$resultado['estado'] = 1;
			return $resultado;
    }
	
   
	public function buscaUsuarios($rol_b,$edo_b,$nombre_b,$rol_entro){
		$sqlB = "SELECT u.id, concat(u.nombre, ' ', u.paterno,' ', u.materno) 'nombre', ru.rol,e.nombre_estado,DATE_FORMAT(u.fecha_registro,'%d-%m-%Y') 'registrada',esu.estatus  from usuario u inner join estatus_usuario esu on u.estatus_id = esu.id inner join rol_usuario ru on u.rol_usuario_id = ru.id inner join estado e on u.donde_representante_o_enlace_id = e.id";
		$wa = 0;
		if(!empty($rol_b)){
			$sqlB .= " where u.rol_usuario_id = ".$rol_b;
			$wa++;
		}
		if(!empty($edo_b)){
			$and = ($wa > 0)? " and ": " where ";
			$sqlB .= $and."u.donde_representante_o_enlace_id = ".$edo_b;
			$wa++;
		}
		if(!empty($nombre_b)){
			$and = ($wa > 0)? " and ": " where ";
			$sqlB .= $and."u.nombre like '%".$nombre_b."%'";
		}
		
		if($rol_entro != md5(5)){
			$and = ($wa > 0)? " and ": " where ";
			$sqlB .= $and."u.rol_usuario_id != 5 and u.estatus_id != 3";
		}
		
		$sqlB .= ";";
		return $this->query($sqlB,'arregloAsociado');
	}
	
	public function formUsuario(){
		$form = '
			<form method="POST" id="userForm" action="herramientas/funciones/usuario.php">
				<input type="hidden" name="id" id="id" />
				<input type="hidden" name="opcion" id="opcion" />
				<div class="page-header has-error has-feedback" id="titulo"><h1>Nuevo usuario</h1></div>
				<div class="row">
					<div class="form-group col-md-4">
						<label class="control-label" for="nombre">Nombre(s)<span class="required-tag">*</span>:</label>
						<input name="nombre"  maxlength="40" type="text" class="form-control"  id="nombre"/>
					</div>
					<div class="form-group col-md-4">
						<label class="control-label" for="paterno">Apellido paterno<span class="required-tag">*</span>:</label>
						<input name="paterno"  maxlength="40" type="text" class="form-control"  id="paterno" />
					</div>
					<div class="form-group col-md-4">
						<label class="control-label" for="materno">Apellido materno<span class="required-tag">*</span>:</label>
						<input name="materno"  maxlength="40" type="text" class="form-control"  id="materno" />
					</div>
				</div>
				<div class="row">
					 <div class="form-group col-md-4">
						<label class="control-label" for="sexo">Sexo<span class="required-tag">*</span>:</label>
						<select name="sexo" class="form-control" id="sexo"></select> 
					</div>
					<div class="form-group col-md-4">
						<label for="fecha_nacimiento" class="ontrol-label">Fecha de nacimiento:</label>
                        <div class="input-group date" id="fecha_nacimientoDiv">
							<input type="text" class="form-control input-sm" id="fecha_nacimiento" name="fecha_nacimiento"/>
							<span class="input-group-addon glyphicon glyphicon-calendar" id="glyph_nacimiento"></span>
                        </div>
					</div>
					<div class="form-group col-md-4">
						<label class="control-label" for="correo">Correo:</label>
						<input name="correo" type="text" class="form-control"  id="correo" maxlength="50" />
					</div>
                </div>
				<div class="row">
					<div class="form-group col-md-4">
						<label class="control-label" for="usuario">Usuario<span class="required-tag">*</span>:</label>
						<input name="usuario" type="text" maxlength="30" class="form-control"  id="usuario" /><span id="validU"></span>
					</div>
					<div class="form-group col-md-4">
						<label class="control-label" for="clave">Contrase&ntilde;a<span class="required-tag">*</span>:</label>
						<input name="clave"  minlength="6" maxlength="30" type="password" class="form-control"  id="clave" />
					</div>
					<div class="form-group col-md-4">
						<label class="control-label" for="confirmacion">Confirmaci&oacute;n contrase&ntilde;a<span class="required-tag">*</span>:</label>
						<input name="confirmacion"  maxlength="30" type="password" class="form-control"  id="confirmacion" />
					</div>
				</div>
				<div class="row">
					 <div class="form-group col-md-4">
						<label class="control-label" for="rol">Rol de usuario<span class="required-tag">*</span>:</label>
						<select name="rol" class="form-control"  id="rol"></select> 
					</div>
					<div class="form-group col-md-4">
						<label class="control-label" for="asignado">Estado/Condado asignado<span class="required-tag">*</span>:</label>
						<select name="asignado" class="form-control"  id="asignado"></select>
					</div>
					<div class="form-group col-md-4">
						<label class="control-label" for="estatus">Estatus de usuario:<span class="required-tag">*</span>:</label>
						<select name="estatus" class="form-control"  id="estatus"></select>
					</div>
                </div>
				<div id="permisos" class="row">
				</div>
			</form><br/>
		
		';
		return $form;	
	}
	
	public function formPermisos($rol){
		$per = array();
		$tabPer= '';
		$sqlPR = "select a.id, a.accion,a.clave from accion a inner join accion_por_rol apr on a.id = apr.accion_id where a.activo = true and a.nivel_menu_id = 1 and apr.rol_usuario_id = %d order by a.orden;";
		$per_gral = $this->query(sprintf($sqlPR,$rol),'arregloAsociado');
		//print_r($per_gral);
		$tabPer .= '<div class="page-header has-error has-feedback"><h3>Permisos para el usuario</h3></div><div class="list-group">';

		for($i = 0; $i < count($per_gral); $i++){
			$tabPer .= '<div class="list-group-item active">
							<input type="checkbox" value="'.$per_gral[$i]['id'].'" name="'.$per_gral[$i]['clave'].'" id="'.$per_gral[$i]['clave'].'" class="chgrup">&nbsp;&nbsp;'.utf8_encode($per_gral[$i]['accion']).
						'</div>';
			
			$sqlPS = "select a.id, a.accion,a.clave from accion a inner join accion_por_rol apr on a.id = apr.accion_id where a.activo = true and apr.rol_usuario_id = %d and a.modulo_pertenece = '%s' and (a.nivel_menu_id = 2 or a.nivel_menu_id = 3) order by a.id;";
			//echo sprintf($sqlPS,$rol,$per_gral[$i]['clave'])."<br/>";
			$per_sec = $this->query(sprintf($sqlPS,$rol,$per_gral[$i]['clave']),'arregloAsociado');
			for($j = 0; $j < count($per_sec); $j++){
				$tabPer .= '<div class="list-group-item">
								&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" class="cksub" name="'.$per_sec[$j]['clave'].'" id="'.$per_sec[$j]['clave'].'" value="'.$per_sec[$j]['id'].'" for="'.$per_gral[$i]['clave'].'">&nbsp;&nbsp;'.utf8_encode($per_sec[$j]['accion']).
							'</div>';
						$per_sec2 = $this->query(sprintf($sqlPS,$rol,$per_sec[$j]['clave']),'arregloAsociado');
						for($k = 0; $k < count($per_sec2); $k++){
							$tabPer .= '<div class="list-group-item">
										&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" class="cksub" name="'.$per_sec2[$k]['clave'].'" id="'.$per_sec2[$k]['clave'].'" value="'.$per_sec2[$k]['id'].'" for="'.$per_sec2[$k]['clave'].'">&nbsp;&nbsp;'.utf8_encode($per_sec2[$k]['accion']).
										'</div>';
						}
			}
		}
		$tabPer .= '</div>
		<script>eveChck();</script>';
		return $tabPer;
	}
	
	public function btnBuscarNuevo($idusu){
		$perNuevo = $this->validarPermiso($idusu,0,'MURU');
		$nuevo = (!empty($perNuevo['activo']) && $perNuevo['activo'] != 0)? '<button name="formU" id="formU" class="btn btn-info">Nuevo</button>':'' ;
		echo '<div class="row">
                    <div class="form-group col-md-8"></div>
                    <div class="form-group col-md-4">
                        <div class="pull-right">
                            <button  name="buscar_usu" id="buscar_usu" class="btn btn-primary" >Buscar usuario</button>
                            '.$nuevo.'
                        </div>
                    </div>
                </div>';
		
	}
	
	public function btnEditaElimina($idusu){
		$perEdita = $this->validarPermiso($idusu,0,'MUMU');
		$perElimina = $this->validarPermiso($idusu,0,'MUEU');
		$edita = (!empty($perEdita['activo']) && $perEdita['activo'] != 0)? '<button name="formUedita" id="formUedita" class="btn btn-warning">Actualizar</button>':'<script>$("#userForm :input").not("#regresar").prop("disabled",true);</script>' ;
		$elimina = (!empty($perElimina['activo']) && $perElimina['activo'] != 0)? '<button name="formUelimina" id="formUelimina" class="btn btn-danger">Eliminar</button>':'' ;
		echo '<div class="row">
                    <div class="form-group col-md-8"></div>
                    <div class="form-group col-md-4">
                        <div class="pull-right">
                            <button  name="regresar" id="regresar" class="btn btn-primary" >Regresar</button>
                            '.$edita.'&nbsp;'.$elimina.'
                        </div>
                    </div>
                </div>
				<script>editaYelimina();</script>
				';
	}
	
	public function btnAgregar(){
		return '<div class="row">
                    <div class="form-group col-md-8"></div>
                    <div class="form-group col-md-4">
                        <div class="pull-right">
                            <button  name="regresar" id="regresar" class="btn btn-primary" >Regresar</button>
                            <button name="agregar_usuario" id="agregar_usuario" class="btn btn-success">Agregar</button>
                        </div>
                    </div>
                </div>';
	}
	
	public function cargaDatosUsu($idusuPer,$usuOpe){
		$sqlDat = "select * from usuario where id = %d;";
		$infoUs = $this->query(sprintf($sqlDat,$usuOpe),'registro');
		//print_r($infoUs);
		
		if(count($infoUs)>0){
			$nac = "";
			if($infoUs['fecha_nacimiento'] != "0000-00-00"){
				$fecha_nac = new DateTime($infoUs['fecha_nacimiento']);
				$nac = "$('#fecha_nacimiento').prop('value','".$fecha_nac->format('d-m-Y')."');";
			}
			
			echo "<script>
				$('#titulo').html('<h1>Informaci&oacute;n Usuario</h1>');
				$('#id').val(".$infoUs['id'].");
				$('#nombre').val('".utf8_encode($infoUs['nombre'])."');
				$('#paterno').val('".utf8_encode($infoUs['paterno'])."');
				$('#materno').val('".utf8_encode($infoUs['materno'])."');
				$('#sexo').val(".$infoUs['sexo_id'].");
				".$nac."
				$('#correo').val('".$infoUs['correo']."');
				$('#usuario').val('".$infoUs['usuario_cuenta']."');
				//$('#clave').val('".$infoUs['clave']."');
				//$('#confirmacion').val('".$infoUs['clave']."');
				$('#rol').val(".$infoUs['rol_usuario_id'].").change();
				$('#estatus').val(".$infoUs['estatus_id'].");
				$('#asignado').val(".$infoUs['donde_representante_o_enlace_id'].");
				
			</script>";
			
		}else{
			echo "<script>$('#usuarioCo').html('<div class=\"alert alert-warning text-center \"><i>Sin resultados</i></div>');</script>";
		}
	}
	
	public function permisoOperaciones($idusuPer,$usuOpe){
		$sqlPerUsu = "SELECT p.*,a.clave FROM permiso p inner join accion a on p.accion_id = a.id where p.usuario_id = %d and p.activo = true;";
		$per = $this->query(sprintf($sqlPerUsu,$usuOpe),'arregloAsociado');
			if(!empty($per[0]['id'])){
				echo "<script>";
				for($i = 0; $i < count($per); $i++){
					echo "$('#".$per[$i]['clave']."').prop('checked',true);";
				}
				echo "</script>";
			}
	}
	
	public function validarPermiso($idusu,$idper,$cveper = null){
		if(!empty($cveper)){
			$sqlPer = "select p.* from permiso p inner join accion a on p.accion_id = a.id where p.usuario_id = ".$idusu." and a.clave = '".$cveper."'; ;";
		}else{
			$sqlPer = "select * from permiso where usuario_id = ".$idusu." and accion_id = ".$idper.";";
		}
		return $this->query($sqlPer,'registro');
		
	}
	
	public function validarUsu($usuario,$id = null){
		$res = array();
		if(!empty($id)){
			$sqlU = 'select count(*) "existe" from usuario where usuario_cuenta = "'.$usuario.'" and id != '.$id.';';
		}else{
			$sqlU = 'select count(*) "existe" from usuario where usuario_cuenta = "'.$usuario.'";';
		}
		$exist = $this->query($sqlU,'registro');
		if($exist['existe'] == 0){
			$res['estado'] = 1;
		}else{
			$res['estado'] = 0;
			$res['msg'] = "El usuario existe, ingrese uno diferente.";
		}
		return $res;
	}
	
	public function verPermisosPrincipal($idusu){
        $sqlPer = "select ac.* from usuario u inner join permiso p on u.id = p.usuario_id inner join accion ac on ac.id = p.accion_id where p.activo = true and u.id = ".$idusu." and ac.nivel_menu_id = 1 order by ac.orden;";
        return $this->query($sqlPer,'arregloAsociado');
    }
	
	public function verPermisosSecundarios($idusu,$principal){
		$sqlPer = "select ac.* from usuario u inner join permiso p on u.id = p.usuario_id inner join accion ac on ac.id = p.accion_id where p.activo = true and u.id = ".$idusu." and ac.nivel_menu_id = 2 AND ac.modulo_pertenece = '".$principal."' order by ac.orden;";
		return $this->query($sqlPer,'arregloAsociado');
	}
	
	 public function verPermisoUsu($idusu,$clave,$nivel){
        $sqlPer = "select COUNT(*) 't' from usuario u inner join permiso p on u.id = p.usuario_id inner join accion ac on ac.id = p.accion_id where p.activo = true and u.id = ".$idusu." and ac.nivel_menu_id = ".$nivel." AND ac.clave = '".$clave."';";
        $p = $this->query($sqlPer,'registro');
		//echo $p['t'];
        if($p['t'] > 0){
            return true;
        }else{
            return false;
        }
    }
	
   
}




?>