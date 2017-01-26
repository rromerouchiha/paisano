//**************************************************
//****** Romero Villegas Rafael Alejandro **********
//********* Eventos Búsqueda Usuarios **************
//**************** 15/07/2016 **********************
//**************************************************

//Función con eventos para la búsqueda
function busqueda(){
    $("#usuarioCo").slideUp("slow",function(){$(this).html('');});
    var url = "herramientas/funciones/combos.php?consulta=";
    llenaCombo(url+"14","#rol_bus");
    var form = $( "#usuario_bus" );
    
    $("#rol_bus").on('change', function(){
        if ($(this).val() == 2) {
            llenaCombo(url+"16","#edo_bus");
        }else if($(this).val() == 1 || $(this).val() == 5){
            llenaCombo(url+"21","#edo_bus");
        }else if($(this).val() == 0 || $(this).val() == ''){
            $('#edo_bus').html('');
        }else{
            llenaCombo(url+"15","#edo_bus");
        }
        
    });
    
    $('#buscar_usu').click(function(){
       $("#usuarioCo").slideUp("slow",function(){$(this).html('');});
       $.ajax({
            dataType: "html",
            type: "POST",
            data: {'rol_b': $('#rol_bus').val(),'edo_b': $('#edo_bus').val(),'nombre_b': $('#nombre_bus').val(),'opcion': 1},
            url: 'herramientas/funciones/usuario.php',
            success: function(datos){
                 $('#usuarioCo').slideDown('slow',function(){
                    $("#usuarioCo").html(datos);
                    $('html,body').animate({
                            scrollTop: $("#usuarioCo").offset().top
                    }, 500);
                });
            },
            statusCode: {
                404: function() {
                  alert( "pagina no encontrada" );
                }
            }
        });
        return false;
    });
    
    $("#formU").on('click',function(){
        $('#usuarioCo').slideUp("slow",function(){$(this).html('');});
        $.ajax({
            dataType: "html",
            type: "POST",
            data: {'opcion': 2},
            url: 'herramientas/funciones/usuario.php',
            success: function(datos){
                $('#usuarioCo').slideDown('slow',function(){
                    $(this).html(datos);
                    $('html,body').animate({
                            scrollTop: $("#usuarioCo").offset().top
                    }, 500);
                });
            },
            statusCode: {
                404: function() {
                  alert( "pagina no encontrada" );
                }
            }
        });
        return false;
    });

}

//Eventos para componentes de la tabla de usuarios 
function eventosTabla() {
    
    $('.ver').on('click',function(){
        $("#usuarioCo").slideUp("slow",function(){$(this).html('');});
        $.ajax({
            dataType: 'html',
            type: 'POST',
            url: 'herramientas/funciones/usuario.php',
            data:{'opcion': 4, 'usuario':$(this).attr('for')},
            success: function(datos){
                $('#usuarioCo').slideDown('slow',function(){
                    $("#usuarioCo").html(datos);
                    $('html,body').animate({
                            scrollTop: $("#usuarioCo").offset().top
                    }, 500);
                });
            }
        });
    
    });
}


//Eventos para el formulario de usuarios
function formUsuario() {
    $('#fecha_nacimientoDiv').datetimepicker({format: 'DD-MM-YYYY',maxDate:fechaMayorEdad(15),minDate:fechaMayorEdad(130),locale:'es'});
    $('#fecha_nacimiento').prop('value','');
    
    $("#fecha_nacimiento").on("click",function(e){
        e.preventDefault();
        $("#glyph_nacimiento").click();
    });
    
    var url = "herramientas/funciones/combos.php?consulta=";
    llenaCombo(url+"14","#rol");
    llenaCombo(url+"9","#sexo");
    llenaCombo(url+"5","#pais");
    llenaCombo(url+"17","#estatus");
    
    $('#pais').on('change', function(){
        var val = $(this).val();
        $("#estado, #ciudad").val('').attr("disabled",false).find("option").remove(); 
         if (val > 0) {
                if (val == 1) {
                        llenaCombo(url+"6&pa="+val,"#estado");
                }else if (val == 2) {
                        llenaCombo(url+"6&pa="+val,"#estado");
                        $("#ciudad").attr('disabled',true);
                }else {
                        $("#estado,#ciudad").attr('disabled',true);
                }
        }
    });
    
    $('#estado').on('change',function(){
        var val = $(this).val();
        $("#ciudad").val('').find("option").remove(); 
         if (val > 0) {
                if ($('#pais').val() == 1) {
                    llenaCombo(url+"7&es="+val,"#ciudad");
                }
        }
    });
    
    $("#rol").on('change', function(){
        if ($(this).val() == 2) {
            llenaCombo(url+"16","#asignado");
        }else if($(this).val() == 1 || $(this).val() == 5){
            llenaCombo(url+"21","#asignado");
        }else if($(this).val() == 0 || $(this).val() == ''){
            $('#asignado').html('');
        }else{
            llenaCombo(url+"15","#asignado");
        }
        $('#permisos').html('');
        $.ajax({
            dataType: "html",
            type: 'POST',
            url: 'herramientas/funciones/usuario.php',
            data: {'opcion':3, 'rol':$(this).val()},
            success: function(permisos){
                $('#permisos').html(permisos);
                if ($('#id').val() == '') {
                    $("input[type=checkbox]").prop("checked",true);
                }else{
                    $.ajax({
                        dataType: "html",
                        type: 'POST',
                        url: 'herramientas/funciones/usuario.php',
                        data: {'opcion':5, 'usuario':$('#id').val(),'editar':1},
                        success: function(permisosUsu){
                            $('#permisos').append(permisosUsu);
                        }
                    });
                }
                
            }
        });
    });
    $('#userForm').validate({
        errorElement: 'span',
        errorClass: 'error-message',
        rules:{
            nombre:{required:true,textocomun:true,maxlength: 40},
            paterno:{required:true,textocomun:true,maxlength: 40},
            materno:{required:true,textocomun:true,maxlength: 40},
            sexo:{required:true},
            correo:{email: true,maxlength: 50},
            usuario:{required:true, alphanumeric:true,minlength: 6,maxlength: 15},
            clave:{ pas: true,required: true ,minlength: 6,maxlength: 15,},
            confirmacion:{ pas: true,required:true,equalTo: "#clave",minlength: 6,maxlength: 15},
            rol:{required:true},
            asignado:{required:true},
            estatus:{required:true}
        },
        messages:{
            nombre:{required:'Campo obligatorio *',textocomun:'S&oacute;lo letras',maxlength: 'M&aacute;ximo de caracteres alcanzado'},
            paterno:{required:'Campo obligatorio *',textocomun:'S&oacute;lo letras',maxlength: 'M&aacute;ximo de caracteres alcanzado'},
            materno:{required:'Campo obligatorio *',textocomun:'S&oacute;lo letras',maxlength: 'M&aacute;ximo de caracteres alcanzado'},
            sexo:{required:'Campo obligatorio *'},
            correo:{email:'Ingrese un correo valido',maxlength: 'M&aacute;ximo de caracteres alcanzado'},
            usuario:{required:'Campo obligatorio *',alphanumeric:'S&oacute;lo alfanumericos',maxlength: 'M&aacute;ximo 15 caracteres'},
            clave:{required: 'Campo obligatorio *',minlength: 'M&iacute;nimo 6 caracteres', maxlength: 'M&aacute;ximo 15 caracteres'},
            confirmacion:{ required:'Campo obligatorio *',equalTo: "No coincide con la contrase&ntilde;a",minlength: 'M&iacute;nimo 6 caracteres', maxlength: 'M&aacute;ximo 15 caracteres'},
            rol:{required:'Campo obligatorio *'},
            asignado:{required:'Campo obligatorio *'},
            estatus:{required:'Campo obligatorio *'}
        }
        
    });
    
    $('#agregar_usuario').click(function(){
        if($('#userForm').valid()){
            $('#opcion').attr('value',7);
           $("#agregar_usuario").attr("disabled",true);
            var form  = $('#userForm');
            var datos = new FormData(document.getElementById("userForm"));
            var tipo  = form.attr("method");
            var url  = form.attr("action");
            $.ajax({
                dataType: "json",
                type : tipo,
                url: url,
                data: datos,
                cache: false,
                contentType: false,
                processData: false,
                success: function(datos) {
                        if (datos.estado == 1) {
                            $('#usuarioMen').fadeIn(500).removeClass("alert alert-warning").addClass("alert alert-success").html(datos.men);
                            $('#usuarioCo').slideUp('slow',function(){});
                            
                        }else {
                             $('#usuarioMen').fadeIn(500).removeClass("alert alert-success").addClass("alert alert-warning").html(datos.men);
                        }
                        $('html,body').animate({
                            scrollTop: $("#contP").offset().top
                        }, 500);
                        
                        setTimeout(function() {
                            $("#usuarioMen").fadeOut(1500);
                        },3000);
                        $("#agregar_usuario").attr("disabled",false);
                },
            });
            
            
        }else{
            //alert("Capture correctamente los campos");
            $("#modal-header").html('').append('<button type="button" class="close" data-dismiss="modal">&times;</button><h4 class="modal-title" style="color:#577492;">¡Atenci&oacute;n!</h4>');
            $("#modal-body").html('').append('<p>¡Verifique la informaci&oacute;n ingresada, a&uacute;n no es correcta!.</p>');
            $("#modal-footer").html('').append('<button type="button" class="btn btn-default" data-dismiss="modal">OK</button>');
            $("#ModalGral").modal({backdrop: "static"});
            $("#ModalGral").modal("show");
             //alert("¡Verifique la informaci\u00f3n ingresada, a\u00fan no es correcta!");
             $("#agregar_usuario").attr("disabled",false);
            return false;
        }
        return false;
    });
    $('#regresar').on('click',function(){
        $('#usuarioCo').slideUp('slow',function(){});
        return false;
    });
    
    $('#formUedita').on('click',function(){
        if($('#userForm').valid()){
            $('#opcion').attr('value',8);
           $("#formUedita").attr("disabled",true);
            var form  = $('#userForm');
            var datos = new FormData(document.getElementById("userForm"));
            var tipo  = form.attr("method");
            var url  = form.attr("action");
            $.ajax({
                dataType: "json",
                type : tipo,
                url: url,
                data: datos,
                cache: false,
                contentType: false,
                processData: false,
                success: function(datos) {
                    //alert('ya entro');
                     if (datos.estado == 1) {
                            $('#usuarioMen').fadeIn(500).removeClass("alert alert-warning").addClass("alert alert-success").html(datos.men);
                            //$('#usuarioCo').slideUp('slow',function(){});
                        }else {
                             $('#usuarioMen').fadeIn(500).removeClass("alert alert-success").addClass("alert alert-warning").html(datos.men);
                        }
                        $('html,body').animate({
                            scrollTop: $("#contP").offset().top
                        }, 500);
                        
                        setTimeout(function() {
                            $("#usuarioMen").fadeOut(1500);
                        },3000);
                },
            });
            $("#formUedita").attr("disabled",false);
            
        }else{
            $("#modal-header").html('').append('<button type="button" class="close" data-dismiss="modal">&times;</button><h4 class="modal-title" style="color:#577492;">¡Atenci&oacute;n!</h4>');
            $("#modal-body").html('').append('<p>¡Verifique la informaci&oacute;n ingresada, a&uacute;n no es correcta!.</p>');
            $("#modal-footer").html('').append('<button type="button" class="btn btn-default" data-dismiss="modal">OK</button>');
            $("#ModalGral").modal({backdrop: "static"});
            $("#ModalGral").modal("show");
            //alert("¡Verifique la informaci\u00f3n ingresada, a\u00fan no es correcta!");
            return false;
        }
        return false;
    });
    
     $('#formUelimina').on('click',function(){
        $("#usuarioMen").fadeIn(200).css('padding-bottom','45px').removeClass("alert alert-success").addClass("alert alert-warning").html('<center><div class="col-lg-10 text-left" style="padding-top:10px;font-size:20px;">&iquest;Est&aacute; seguro que desea eliminar este usuario? &nbsp;</div><div class="col-lg-2"><button name="eleminarRegF" id="eleminarRegF" class="btn btn-danger" cual="'+$("#id").val()+'"><span class="glyphicon glyphicon-trash"></span>&nbsp;Si</button>&nbsp;&nbsp;<button name="noeli" id="noeli" class="btn btn-primary" ><span class="glyphicon glyphicon-floppy-disk"></span>&nbsp;No</button></div></center>');
        $('html,body').animate({
            scrollTop: $("#usuarioMen").offset().top
         }, 500);
        
        $('#eleminarRegF').on('click',function(){
            $("#usuarioMen").css('padding-bottom','10px')
           if($('#userForm').valid()){
                $('#opcion').attr('value',9);
               $("#agregar_usuario").attr("disabled",true);
                var form  = $('#userForm');
                var datos = new FormData(document.getElementById("userForm"));
                var tipo  = form.attr("method");
                var url  = form.attr("action");
                $.ajax({
                    dataType: "json",
                    type : tipo,
                    url: url,
                    data: datos,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function(datos) {
                        
                        if (datos.estado == 1) {
                            $('#usuarioMen').fadeIn(500).removeClass("alert alert-warning").addClass("alert alert-success").html(datos.men);
                            $('#usuarioCo').slideUp('slow',function(){});
                            
                        }else {
                             $('#usuarioMen').fadeIn(500).removeClass("alert alert-success").addClass("alert alert-warning").html(datos.men);
                        }
                        $('html,body').animate({
                            scrollTop: $("#contP").offset().top
                        }, 500);
                        
                        setTimeout(function() {
                            $("#usuarioMen").fadeOut(1500);
                        },3000);
                    },
                });
                $("#agregar_usuario").attr("disabled",false);
                
            }else{
                $("#modal-header").html('').append('<button type="button" class="close" data-dismiss="modal">&times;</button><h4 class="modal-title" style="color:#577492;">¡Atenci&oacute;n!</h4>');
                $("#modal-body").html('').append('<p>¡Verifique la informaci&oacute;n ingresada, a&uacute;n no es correcta!.</p>');
                $("#modal-footer").html('').append('<button type="button" class="btn btn-default" data-dismiss="modal">OK</button>');
                $("#ModalGral").modal({backdrop: "static"});
                $("#ModalGral").modal("show");
               // alert("¡Verifique la informaci\u00f3n ingresada, a\u00fan no es correcta!");
                return false;
            }
            return false;
        });
        $('#noeli').on('click',function(){
            $('#eleminarRegF').attr("disabled",true);
            setTimeout(function() {
                             $('#usuarioMen').fadeOut(1500).removeClass("alert alert-success alert-warning").html('').css('padding-bottom','10px');
            },1000);
            
           
            return false;
        });
        
     });
    
    
    $("#usuario").on('keyup',function(){
        validaUsuario();
    });
    
}

function soloActivo() {
    $("#estatus").html('');
    $('#estatus').append('<option value="1" selected="selected">Activo</option>');
}



//Eventos para los Checkboxs de permisos 
function eveChck() {
    $('.chgrup').on('click',function(){
            var cuales = $(this).attr('id'); 
            if( $(this).prop('checked')) {
                $('input[for ='+ cuales +']').each(function(){
                    //alert($(this));
                    $(this).prop('checked', 'checked');
                });
            }else{
                $('input[for ='+ cuales +']').each(function(){
                    //alert($(this));
                    $(this).prop('checked', false);
                });
            }    
    });
    $('.cksub').on('click', function(){
        var mod = $(this).attr('for');
        if( $(this).prop('checked')) {
            if(!$('#'+mod).prop('checked')) {
                $('#'+mod).prop('checked', 'checked');
            } 
         }else{
            var cuantas = 0;
            $('input[for ='+ mod +']').each(function(){
                    if($(this).prop('checked')) {
                        cuantas++;
                    }
            });
            if (cuantas == 0) {
                $('#'+mod).prop('checked', false);
            }
         }
    
    });
}


//Eventos cuando se puede Editar o eliminar
function editaYelimina() {
    if ($('#id').val() != '') {
        $( "#clave" ).rules( "remove" );
        $( "#confirmacion" ).rules( "remove" );
        
        $( "#confirmacion" ).rules( "add", {
            pas:true,
            equalTo: "#clave",
            messages: {
              equalTo: "No coincide con la contrase&ntilde;a"
            }
         });
        $( "#clave" ).rules( "add", {
            pas:true
            
         });
        
    }
}

//Función para validar usuario 
function validaUsuario() {
    var id = $("#id").val();
    var usuario = $("#usuario").val();
    if (id != '') {
        var data = {'id': id, 'usuario': usuario, 'opcion' : 6};
    }else{
         var data = {'usuario': usuario, 'opcion' : 6};
    }
    $.ajax({
        dataType: "json",
        type: "POST",
        data: data,
        url: 'herramientas/funciones/usuario.php',
        success: function(res){
            if (res.estado == 0) {
                $("#validU").html(res.msg).addClass('error-message');
                $("#usuario").addClass('error-message');
                $("#agregar_usuario,#formUedita").attr("disabled",true);
                
            }else{
                $("#validU").html("").removeClass('error-message');
                $("#usuario").removeClass('error-message');
                $("#agregar_usuario, #formUedita").attr("disabled",false);
            }
        }
    });
}

function paginadorEv() {
    $(".btn-paginador").on("click",function(){
        var p = $(this).attr('pagina');
        $("#usuarioCo").slideUp("slow",function(){$(this).html('');});
       $.ajax({
            dataType: "html",
            type: "POST",
            data: {'rol_b': $('#rol_bus').val(),'edo_b': $('#edo_bus').val(),'nombre_b': $('#nombre_bus').val(),'opcion': 1,'p':p},
            url: 'herramientas/funciones/usuario.php',
            success: function(datos){
                $('#usuarioCo').slideDown('slow',function(){
                    $("#usuarioCo").html(datos);
                     $('html,body').animate({
                            scrollTop: $("#usuarioCo").offset().top
                    }, 500);
                });
            },
            statusCode: {
                404: function() {
                  alert( "pagina no encontrada" );
                }
            }
        });
        return false;
        
    });
}
           