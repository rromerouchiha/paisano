function formCargaAtencionRep() {
    $('#fecha_registrod').datetimepicker({format: 'DD-MM-YYYY',maxDate: 'now', locale: 'es',defaultDate:'now'});
    
    $("#fecha_registro").on("click",function(e){
        e.preventDefault();
        $("#glyph_registro").click();
    });
    
    $("#npersonas").numeric({ decimal: false, negative: false });
    
    $(".oculta").hide();
    cargaListasRep();
    $('#nacionalidad').on('change',function(){
            var val = $(this).val();
            $("#estado_origen, #ciudad_origen").val('').attr("disabled",false).find("option").remove(); 
            var url = "herramientas/funciones/combos.php?consulta=";
             if (val > 0) {
                    if (val == 1) {
                            llenaCombo(url+"6&pa="+val,"#estado_origen");
                    }else if (val == 2) {
                            llenaCombo(url+"6&pa="+val,"#estado_origen");
                            $("#ciudad_origen").attr('disabled',true);
                    }else {
                            $("#estado_origen,#ciudad_origen").attr('disabled',true);
                    }
            }
    });
    
    $('#estado_origen').on('change',function(){
            var val = $(this).val();
            $("#ciudad_origen").val('').find("option").remove(); 
            var url = "herramientas/funciones/combos.php?consulta=";
             if (val > 0) {
                    if ($('#nacionalidad').val() == 1) {
                        llenaCombo(url+"7&es="+val,"#ciudad_origen");
                    }
            }
    });
    
     $(' #estado_residencia').on('change',function(){
            var val = $(this).val();
            $("#ciudad_residencia").val('').find("option").remove(); 
            var url = "herramientas/funciones/combos.php?consulta=";
             if (val > 0) {
                    
                        llenaCombo(url+"7&es="+val,"#ciudad_residencia");
            }
    });
     
    $(".obliC").on('keyup',function(){
        if ($("#telefono").val() != "" || $("#correo").val() != "" ) {
            $("#obliContacto").slideUp("slow");
        }else{
            $("#obliContacto").slideDown("slow");
        }
    });
     
     $('#arepForm').validate({
        errorElement: 'span',
        errorClass: 'error-message',
        rules:{
            tipo_atencion:{required:true},
            fecha_registro:{required:true},
            tema:{required:true},
            nombre: {required:true,textocomun: true,maxlength: 50},
            apellidos: {required:true,textocomun: true,maxlength: 50},
            sexo: {required:true},
            telefono:{number:true,minlength: 3,maxlength: 18},
            correo:{email: true,maxlength: 50},
        },
        messages:{
            tipo_atencion:{required:'Campo obligatorio *'},
            fecha_registro:{required:'Campo obligatorio *'},
            tema:{required:'Campo obligatorio *'},
            nombre: {required:'Campo obligatorio *',textocomun: 'Solo Letras',maxlength: 'M&aacute;ximo de caracteres alcanzado (50)'},
            apellidos: {required:'Campo obligatorio *',textocomun: 'Solo Letras',maxlength: 'M&aacute;ximo de caracteres alcanzado (50)'},
            sexo: {required:'Campo obligatorio *'},
            telefono:{number:'Solo n&uacute;meros [0-9]',minlength: 'M&iacute;nimo 3 n&uacute;meros',maxlength: 'M&aacute;ximo 16 n&uacute;meros'},
            correo:{email:'Ingrese un correo valido',maxlength: 'M&aacute;ximo de caracteres alcanzado'},
        }
    }); 
     
      $("#tema").on('change',function(){
        $("#otro_tema").val('').rules('remove');
        if($(this).val() == 11){
                $("#otro_temaDiv").slideDown();
                $("#otro_tema").rules( "add", {
                    required: true,
                    textocomun: true,
                    maxlength: 50,
                    messages: {
                      required: 'Campo obligatorio *',
                      textocomun: 'Solo Letras',
                      maxlength: 'M&aacute;ximo de caracteres alcanzado (50)'
                    }
                 });
        }else{
             $('#otro_temaDiv').slideUp();
             $("#otro_tema").val('');
        }    
    });
     
    $("#tipo_atencion").on('change',function(){
        if( $(this).val() == "" || $(this).val() != 4) {
                $(".grupalre").each(function(){
                    $(this).rules("remove");
                    $(this).attr("disabled",true);
                });
                $("label[for= "+ $("#sedes").attr('id') +" ]").html($("label[for= "+ $("#sedes").attr('id') +" ]").text().replace('*:', ':'));
                $("label[for= "+ $("#npersonas").attr('id') +" ]").html($("label[for= "+ $("#npersonas").attr('id') +" ]").text().replace('*:', ':'));
                $("#sedes,#npersonas").removeClass("error-message");
                $('#arepForm').validate().element( "#sedes" );
                $('#arepForm').validate().element( "#npersonas" );
        }else {
                 $(".grupalre").each(function(){
                    $(this).attr("disabled",false);
                });
                $("label[for= "+ $("#sedes").attr('id') +" ]").html($("label[for= "+ $("#sedes").attr('id') +" ]").text().replace(':', '<span class="required-tag">*</span>:'));
                $("label[for= "+ $("#npersonas").attr('id') +" ]").html($("label[for= "+ $("#npersonas").attr('id') +" ]").text().replace(':', '<span class="required-tag">*</span>:'));
                $("#sedes").rules( "add", {
                    required: true,
                    textocomun: true,
                    maxlength: 50,
                    messages: {
                      required: 'Campo obligatorio *',
                      textocomun: 'Solo letras',
                      maxlength: 'M&aacute;ximo de caracteres alcanzado (50)'
                    }
                 });
                $("#npersonas").rules( "add", {
                    required: true,
                    number: true,
                    minlength: 2,
                    messages: {
                      required: 'Campo obligatorio *',
                      number: 'Solo n&uacute;meros',
                      minlength: 'Minimo 2 personas'
                    }
                 }); 
        }
       
       
    });
    
     $("#limpiaratre").on('click', function(){
            $('#otro_temaDiv').slideUp();
            $('.pet').val('');
            $('#archivo_peticion').fileinput('reset');
            $("#siVehiculo").slideUp();
            $('option', $('#dependencia_peticion')).each(function(element) {
                $(this).removeAttr('selected').prop('selected', false);
            });
            $('#dependencia_peticion').multiselect('refresh');
            return false;
    });
     
     $('#guardaratere').on('click',function(){

         if($('#arepForm').valid()){
            if ($("#telefono").val() == "" && $("#correo").val() == "" ) {
                $("#modal-header").html('').append('<button type="button" class="close" data-dismiss="modal">&times;</button><h4 class="modal-title" style="color:#577492;">¡Atenci&oacute;n!</h4>');
                $("#modal-body").html('').append('<p>Debe ingresar al menos uno de los datos solicitados en el apartado de "Datos de contacto de la persona atendida".</p>');
                $("#modal-footer").html('').append('<button type="button" class="btn btn-default" data-dismiss="modal">OK</button>');
                $("#ModalGral").modal({backdrop: "static"});
                $("#ModalGral").modal("show");
                return false;
            }
            
            $(this).attr('disabled',true);
            $("#opcionEd").val(1);
            $('#arepForm').submit();
           
        }else{
            $("#modal-header").html('').append('<button type="button" class="close" data-dismiss="modal">&times;</button><h4 class="modal-title" style="color:#577492;">¡Atenci&oacute;n!</h4>');
            $("#modal-body").html('').append('<p>¡Verifique la informaci&oacute;n ingresada, a&uacute;n no es correcta!.</p>');
            $("#modal-footer").html('').append('<button type="button" class="btn btn-default" data-dismiss="modal">OK</button>');
            $("#ModalGral").modal({backdrop: "static"});
            $("#ModalGral").modal("show");
             //alert("¡Verifique la informaci\u00f3n ingresada, a\u00fan no es correcta!");
            $(this).attr('disabled',false);
            return false;
        }
        
        return false;
    });
}

function cargaListasRep() {
    var url = "herramientas/funciones/combos.php?consulta=";
    llenaCombo(url+"24","#tipo_atencion");
    llenaCombo(url+"23","#tema");
    llenaCombo(url+"22","#nacionalidad");
    llenaCombo(url+"9","#sexo");
    llenaCombo(url+"6&pa=1","#estado_residencia");
}