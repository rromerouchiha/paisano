
function cargaForm() {
    $(".file").fileinput({
            language: 'es',
            showRemove: false,
            showUpload: false,
             maxFileSize: 5000,
            allowedFileExtensions: ["jpg", "pdf", "png", "jpeg",]
    });
    $(".fileimage").fileinput({
            previewFileType: "image",
            browseClass: "btn btn-success",
            browseLabel: "Examinar",
            browseIcon: "<i class=\"glyphicon glyphicon-picture\"></i> ",
            language: 'es',
            showRemove: false,
            showUpload: false,
             maxFileSize: 5000,
            allowedFileExtensions: ["jpg", "pdf", "png", "jpeg"]    
    });
    var date = new Date();
    var primerDia = new Date(date.getFullYear(), date.getMonth(), 1);
    $('#fecha_recepciond').datetimepicker({format: 'DD-MM-YYYY',maxDate: 'now',minDate: primerDia, locale: 'es',defaultDate:'now'});//defaultDate:'now'
    
    $("#fecha_recepcion").on("click",function(e){
        e.preventDefault();
        $("#glyph_recepcion").click();
     });
    
    $('#fecha_hechosd').datetimepicker({format: 'DD-MM-YYYY',maxDate: 'now',locale:'es'});
    
    $("#fecha_hechos").on("click",function(e){
        e.preventDefault();
        $("#glyph_hechos").click();
     });
    
    $('#fecha_recepciond').on('dp.change',function(e){
        if($("#tipo_registro").val() == 1 || $("#tipo_registro").val() == ""){
            $('#fecha_hechosd').data("DateTimePicker").maxDate(e.date);
        }
        
    });
    
    cargaListas();
    $('#dependencia_peticion').multiselect({
                maxHeight: 200,
                buttonWidth :  '100%',
                enableCaseInsensitiveFiltering: true,
                filterPlaceholder: 'B\u00FAscar...',
                buttonText: function(options, select) {
                       if (options.length === 0) {
                           return 'Seleccione una opci\u00F3n...';
                       }
                       else if (options.length > 10) {
                           return options.length + ' opciones seleccionadas';
                       }
                        else {
                            var labels = [];
                            options.each(function() {
                                if ($(this).attr('label') !== undefined) {
                                    labels.push($(this).attr('label'));
                                }
                                else {
                                    labels.push($(this).html());
                                }
                            });
                            return labels.join(', ') + '';
                        }
                },
                onChange: function(option, checked, select) {
                    $('#qypForm').validate().element( "#dependencia_peticion" );
                    //alert($(option).val());
                    if ($(option).val() == 23) {
                        
                        if(checked) {
                            $("#otra_dep_petC").slideDown();
                            $("#otra_dep_pet").rules( "add", {
                                required: true,
                                textocomun: true,
                                maxlength: 50,
                                messages: {
                                   required: 'Campo obligatorio *',
                                   textocomun: 'S&oacute;lo Letras',
                                   maxlength: 'M&aacute;ximo de caracteres alcanzado (50)'
                                }
                            });
                        }else{
                            $('#otra_dep_petC').slideUp();
                            $("#otra_dep_pet").val('').rules('remove');
                        }    
                    }
                }
        });
    $(".oculta").hide();
    $("#estatus_peticion").val(1).attr("disabled",true);
    
    $('#pais_hechos').on('change',function(){
            var val = $(this).val();
            $("#estado_hechos, #ciudad_hechos").val('').attr("disabled",false).find("option").remove(); 
            var url = "herramientas/funciones/combos.php?consulta=";
             if (val > 0) {
                    if (val == 1) {
                            llenaCombo(url+"6&pa="+val,"#estado_hechos");
                    }else if (val == 2) {
                            llenaCombo(url+"6&pa="+val,"#estado_hechos");
                            $("#ciudad_hechos").attr('disabled',true);
                    }else {
                            $("#estado_hechos,#ciudad_hechos").attr('disabled',true);
                    }
            }
    });
    
    $('#estado_hechos').on('change',function(){
            var val = $(this).val();
            $("#ciudad_hechos").val('').find("option").remove(); 
            var url = "herramientas/funciones/combos.php?consulta=";
             if (val > 0) {
                    if ($('#pais_hechos').val() == 1) {
                        llenaCombo(url+"7&es="+val,"#ciudad_hechos");
                    }
            }
    });
    
    $('#pais_origen').on('change',function(){
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
                    if ($('#pais_origen').val() == 1) {
                        llenaCombo(url+"7&es="+val,"#ciudad_origen");
                    }
            }
    });
    
    $('#tipo_registro').on('change',function(){
        $("#otra_causa").val('').rules('remove');
        $("#otra_dep_pet").val('').rules('remove');
        $("#otra_dep_que").val('').rules('remove');
        $('#otra_causaC,#otra_dep_queC,#otra_dep_petC').slideUp();
        $('.qja, .pet').val('');
        $('option', $('#dependencia_peticion')).each(function(element) {
                $(this).removeAttr('selected').prop('selected', false);
            });
        $('#dependencia_peticion').multiselect('refresh');
        var val = $(this).val();
        var url = "herramientas/funciones/combos.php?consulta=";
        if (val > 0) {
            llenaCombo(url+"8&tr="+val,"#causa");
            if (val == 2) {
                $("#estado_hechos, #ciudad_hechos").find("option").remove(); 
                $(".queja").val("").attr("disabled", true).rules( "remove" );
                $(".queja").removeClass("error-message");
                $("label[for= "+ $("#fecha_hechos").attr('id') +" ]").html($("label[for= "+ $("#fecha_hechos").attr('id') +" ]").text().replace('*:', ':'));
                $("label[for= "+ $("#lugar_hechos").attr('id') +" ]").html($("label[for= "+ $("#lugar_hechos").attr('id') +" ]").text().replace('*:', ':'));
                if( $("#anonimo").prop('checked') ){
                    $("#anonimo").click();
                }
                $("#anonimo").attr("disabled",true);
                 $('#qypForm').validate().element( "#fecha_hechos" );
            }else if(val == 1){
                $("label[for= "+ $("#fecha_hechos").attr('id') +" ]").html($("label[for= "+ $("#fecha_hechos").attr('id') +" ]").text().replace(':', '<span class="required-tag">*</span>:'));
                $("label[for= "+ $("#lugar_hechos").attr('id') +" ]").html($("label[for= "+ $("#lugar_hechos").attr('id') +" ]").text().replace(':', '<span class="required-tag">*</span>:'));
                $("#lugar_hechos").rules( "add", {
                    required: true,
                    direccion: true,
                    maxlength: 250,
                    messages: {
                      required: 'Campo obligatorio *',
                      direccion: 'S&oacute;lo letras, n&uacute;meros y $%&()=¡!¿?',
                      maxlength: 'M&aacute;ximo de caracteres alcanzado (250)'
                    }
                 });
                $("#anonimo").attr("disabled",false);
                $("#fecha_hechos").rules( "add", {
                    required: true,
                    messages: {
                      required: 'Campo obligatorio *'
                    }
                 });
                $(".queja").attr("disabled", false);
                $('#identificaciones_causa').slideUp();
            }
            
        }else{
            $("#causa").val('').find("option").remove();
            $(".queja").attr("disabled", false).rules( "remove" );
            $("label[for= "+ $("#fecha_hechos").attr('id') +" ]").html($("label[for= "+ $("#fecha_hechos").attr('id') +" ]").text().replace('*:', ':'));
            $("label[for= "+ $("#lugar_hechos").attr('id') +" ]").html($("label[for= "+ $("#lugar_hechos").attr('id') +" ]").text().replace('*:', ':'));
            $('#identificaciones_causa').slideUp();
        }
       
    });
    
    $('#causa').on('change',function(){
         $("#otra_causa").val('').rules('remove');
        if ($(this).val() == 18) {
             $('#identificaciones_causa').slideDown();
              $('#otra_causaC').slideUp();
        }else if($(this).val() == 12){
                $('#identificaciones_causa').slideUp();
                $("#id_solicitante,#id_alocalizar").val('');
                $("#otra_causaC").slideDown();
                $("#otra_causa").rules( "add", {
                    required: true,
                    textocomun: true,
                    maxlength: 50,
                    messages: {
                      required: 'Campo obligatorio *',
                      textocomun: 'S&oacute;lo letras',
                      maxlength: 'M&aacute;ximo de caracteres alcanzado (50)'
                    }
                 });
        }else{
             $('#identificaciones_causa, #otra_causaC').slideUp();
             $("#id_solicitante,#id_alocalizar,#otra_causa").val('');
        }
         
    });
    
    $("#anonimo").on('click',function(){
        if( $(this).prop('checked') ) {
                $(".anonimore").each(function(){
                    $(this).removeClass("requerido").rules("remove");
                });
                $("label[for= "+ $("#nombreq").attr('id') +" ]").html($("label[for= "+ $("#nombreq").attr('id') +" ]").text().replace('*:', ':'));
                $("label[for= "+ $("#apellidosq").attr('id') +" ]").html($("label[for= "+ $("#apellidosq").attr('id') +" ]").text().replace('*:', ':'));
                $("label[for= "+ $("#sexoq").attr('id') +" ]").html($("label[for= "+ $("#sexoq").attr('id') +" ]").text().replace('*:', ':'));
                $("#nombreq").rules( "add", {
                    textocomun: true,
                    maxlength: 50,
                    messages: {
                      textocomun: 'S&oacute;lo letras',
                      maxlength: 'M&aacute;ximo de caracteres alcanzado (50)'
                    }
                 });
                $("#apellidosq").rules( "add", {
                    textocomun: true,
                    maxlength: 50,
                    messages: {
                      textocomun: 'S&oacute;lo letras',
                      maxlength: 'M&aacute;ximo de caracteres alcanzado (50)'
                    }
                 });  
                $("#sexoq,#nombreq,#apellidosq").removeClass("error-message");
        }else{
                $("label[for= "+ $("#nombreq").attr('id') +" ]").html($("label[for= "+ $("#nombreq").attr('id') +" ]").text().replace(':', '<span class="required-tag">*</span>:'));
                $("label[for= "+ $("#apellidosq").attr('id') +" ]").html($("label[for= "+ $("#apellidosq").attr('id') +" ]").text().replace(':', '<span class="required-tag">*</span>:'));
                $("label[for= "+ $("#sexoq").attr('id') +" ]").html($("label[for= "+ $("#sexoq").attr('id') +" ]").text().replace(':', '<span class="required-tag">*</span>:'));
                $("#nombreq").rules( "add", {
                    required: true,
                    textocomun: true,
                    maxlength: 50,
                    messages: {
                      required: 'Campo obligatorio *',
                      textocomun: 'S&oacute;lo letras',
                      maxlength: 'M&aacute;ximo de caracteres alcanzado (50)'
                    }
                 });
                $("#apellidosq").rules( "add", {
                    required: true,
                    textocomun: true,
                    maxlength: 50,
                    messages: {
                      required: 'Campo obligatorio *',
                      textocomun: 'S&oacute;lo letras',
                      maxlength: 'M&aacute;ximo de caracteres alcanzado (50)'
                    }
                 });
                $("#sexoq").rules( "add", {
                    required: true,
                    messages: {
                      required: 'Campo obligatorio *'
                    }
                 });   
        }
        $('#qypForm').validate().element( "#nombreq" );
        $('#qypForm').validate().element( "#apellidosq" );
        $('#qypForm').validate().element( "#sexoq" );
       
    });
    
    $(".obliC").on('keyup',function(){
        if ($("#direccionq").val() != "" || $("#telefonoq").val() != "" || $("#correoq").val() != "") {
            $("#obliContacto").slideUp("slow");
        }else{
            $("#obliContacto").slideDown("slow");
        }
    });    
    
     $('#qypForm').validate({
        errorElement: 'span',
        errorClass: 'error-message',
        rules:{
            tipo_registro:{required:true},
            fecha_recepcion:{required:true},
            medio_recepcion:{required:true},
            estatus_peticion:{required:true},
            causa:{required:true},
            nombreq: {required:true,textocomun: true,maxlength: 50},
            apellidosq: {required:true,textocomun: true,maxlength: 50},
            sexoq: {required:true},
            telefonoq:{number:true,minlength: 3,maxlength: 18},
            correoq:{email: true,maxlength: 50},
            direccionq:{direccion:true,maxlength: 250}
           
        },
        messages:{
            tipo_registro:{required:'Campo obligatorio *'},
            fecha_recepcion:{required:'Campo obligatorio *'},
            medio_recepcion:{required:'Campo obligatorio *'},
            estatus_peticion:{required:'Campo obligatorio *'},
            causa:{required:'Campo obligatorio *'},
            nombreq: {required:'Campo obligatorio *',textocomun: 'S&oacute;lo letras',maxlength: 'M&aacute;ximo de caracteres alcanzado (50)'},
            apellidosq: {required:'Campo obligatorio *',textocomun: 'S&oacute;lo letras',maxlength: 'M&aacute;ximo de caracteres alcanzado (50)'},
            sexoq: {required:'Campo obligatorio *'},
            telefonoq:{number:'S&oacute;lo n&uacute;meros [0-9]',minlength: 'M&iacute;nimo 3 n&uacute;meros',maxlength: 'M&aacute;ximo 18 n&uacute;meros'},
            correoq:{email:'Ingrese un correo valido',maxlength: 'M&aacute;ximo de caracteres alcanzado'},
            direccionq:{maxlength: 'M&aacute;ximo de caracteres alcanzado (250)'}
           
        }
        
    });
    
    $("#dependencia_servidor").on('change',function(){
       //alert($(this).val());
        $("#otra_dep_que").val('').rules('remove');
        if($(this).val() == 23){
                $("#otra_dep_queC").slideDown();
                $("#otra_dep_que").rules( "add", {
                    required: true,
                    textocomun: true,
                    maxlength: 50,
                    messages: {
                      required: 'Campo obligatorio *',
                      textocomun: 'S&oacute;lo letras',
                      maxlength: 'M&aacute;ximo de caracteres alcanzado (50)'
                    }
                 });
        }else{
             $('#otra_dep_queC').slideUp();
             $("#otra_dep_que").val('');
        }    
    });
    //
    
    $('#id_solicitante_a, #id_alocalizar').on("change",function(){
        if ($('#id_solicitante_a').val() != '' && $('#id_alocalizar').val() != '') {
            $("#identificaciones_causa div.file-caption").removeClass("error-message");
        }
    });
    
    $('#siguienteqyp').on('click',function(){
        if($('#qypForm').valid()){
            if(identificacionesVacias() == 0){
                return false;
            }
            if ($("#direccionq").val() == "" && $("#telefonoq").val() == "" && $("#correoq").val() == "") {
                $("#modal-header").html('').append('<button type="button" class="close" data-dismiss="modal">&times;</button><h4 class="modal-title" style="color:#577492;">¡Atenci&oacute;n!</h4>');
                $("#modal-body").html('').append('<p>Debe ingresar al menos uno de los tres datos solicitados en el apartado de "Datos de contacto del quejoso o del solicitante".</p>');
                $("#modal-footer").html('').append('<button type="button" class="btn btn-default" data-dismiss="modal">OK</button>');
                $("#ModalGral").modal({backdrop: "static"});
                $("#ModalGral").modal("show");
                return false;
            }
            $('.qjare').each(function(){$(this).rules("remove");});
            $('.rpet').each(function(){$(this).rules("remove");});
            
            
            $("#quejaypeticion").slideUp();
            if ($("#tipo_registro").val() == 1) {
                validacionQueja();                      
                $("#queja").slideDown();
                mostrarInvolucrados($("#id_queja").val(),$("#cveHuerfanos").val(),1);
                mostrarTestigos($("#id_solicitud").val(),$("#cveHuerfanos").val(),1);
            }else{
                validacionPeticion();
                $("#peticion").slideDown();
            }
            
            $('html,body').animate({
                scrollTop: $("#contP").offset().top
            }, 500);
                        
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
    
    $('#regresarqja').on('click',function(){
        $("#obliContacto").slideUp();
        $('.qjare').each(function(){
                $(this).removeClass("requerido").rules("remove");
        });
        $("#queja").slideUp();
        $("#quejaypeticion").slideDown();
        
        $('html,body').animate({scrollTop: $("#contP").offset().top}, 500);
        return false;
    });
    $("#limpiarqja").on('click', function(){
            $('#otra_dep_queC').slideUp();
            $('.qja').val('');
            $('#pruebas_servidor').fileinput('reset');
            return false;
    });
    
    $('#regresapet').on('click',function(){
         $("#obliContacto").slideUp();
            $('.rpet').each(function(){
                $(this).removeClass("requerido").rules("remove");
            });
            $("#peticion").slideUp();
            $("#quejaypeticion").slideDown();
            $('html,body').animate({scrollTop: $("#contP").offset().top}, 500);
            return false;
    });
    
    $("#limpiarpet").on('click', function(){
            $('#otra_dep_petC').slideUp();
            $('.pet').val('');
            $('#archivo_peticion').fileinput('reset');
            $("#siVehiculo").slideUp();
            $('option', $('#dependencia_peticion')).each(function(element){
                $(this).removeAttr('selected').prop('selected', false);
            });
            $('#dependencia_peticion').multiselect('refresh');
            return false;
    });
    
    
    /*------modQuejas-------------------------------------------------------------------------------------------*/
    agregarInvolucrado();
    agregarTestigo();
   
    
    $("input:radio[name=testigos_servidor]").on('click',function(){
            if( $('input:radio[name=testigos_servidor]:checked').val() == 1) {  
                $("#siTestigos").slideDown();
                validacionTestigo();
                $(".obliTestQueja").on('keyup',function(){
                    if ($("#correo_testigo").val() != "" || $("#telefono_testigo").val() != "" ) {
                        $("#obliTestigoDiv").slideUp("slow");
                        
                    }else{
                        $("#obliTestigoDiv").slideDown("slow");
                    }
                });
                
            } else{
                $("#siTestigos").slideUp();
                $('.sites').val('');
                $(".obliTestQueja").off().val('');
                quitarValidacionTestigo();
            } 
               
     });
    
    
     /*-------------------------------------------------------------------------------------------------*/

    $('#guardarqja, #guardapet').on('click',function(){
        quitarValidacionTestigo();
        quitarValidacionInvolucrado();
         if($('#qypForm').valid()){
            exesoQuejaNarracion();
            var tipo = $("#tipo_registro").val();
            if (tipo == 1) {
                
                
                if ($("#totInvolucrados").val() <= 0) {
                    $("#modal-header").html('').append('<button type="button" class="close" data-dismiss="modal">&times;</button><h4 class="modal-title" style="color:#577492;">¡Atenci&oacute;n!</h4>');
                    $("#modal-body").html('').append('<p>¡Debe capturar al menos un involucrado!.</p>');
                    $("#modal-footer").html('').append('<button type="button" class="btn btn-default" data-dismiss="modal">OK</button>');
                    $("#ModalGral").modal({backdrop: "static"});
                    $("#ModalGral").modal("show");
                    validacionTestigo();
                    validacionInvolucrado();
                    return false;
                }else{
                    if ($('input:radio[name=testigos_servidor]:checked').val() == 1) {
                        if ($("#totTestigos").val() <= 0) {
                            $("#modal-header").html('').append('<button type="button" class="close" data-dismiss="modal">&times;</button><h4 class="modal-title" style="color:#577492;">¡Atenci&oacute;n!</h4>');
                            $("#modal-body").html('').append('<p>¡Debe capturar al menos un Testigo!.</p>');
                            $("#modal-footer").html('').append('<button type="button" class="btn btn-default" data-dismiss="modal">OK</button>');
                            $("#ModalGral").modal({backdrop: "static"});
                            $("#ModalGral").modal("show");
                            validacionTestigo();
                            validacionInvolucrado();
                            return false;
                        }else{
                            $(this).attr('disabled',true);
                            $("#opcionEd").val(1);
                            reemplazaSaltos();
                            $('#qypForm').submit();
                        }
                    }else{
                        $(this).attr('disabled',true);
                        $("#opcionEd").val(1);
                        reemplazaSaltos();
                        $('#qypForm').submit();
                    }
                }
            }else{
                $(this).attr('disabled',true);
                $("#opcionEd").val(1);
                reemplazaSaltos();
                $('#qypForm').submit();
            }

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
    
    
    $("input:radio[name=vehiculo_servidor]").on('click',function(){
        if( $('input:radio[name=vehiculo_servidor]:checked').val() == 1) {  
				$("#siVehiculo").slideDown();
                $('#desc_vehi_servidor').rules( "add", {
                    required: true,
                    direccion: true,
                    maxlength: 250,
                    messages: {
                        required : 'Campo obligatorio *',
                        maxlength: 'M&aacute;ximo de caracteres alcanzado (250)'
                    }
                });
                
		} else{  
				$("#siVehiculo").slideUp();
                $('.siveh').val('');
                $("#desc_vehi_servidor").rules("remove");
                $("#desc_vehi_servidor").removeClass("error-message");
		} 
       
    });
    
    
}

function mostrarInvolucrados(quejaId,cveHuerfano,enlace){
    $.ajax({    
            dataType : "html",
            type : "POST",
            url : "herramientas/funciones/solicitud.php",
            data : {"opcion":18,"quejaId":quejaId,"huerfano": cveHuerfano,"enlace":enlace},
            async: false,
            success : function(datos){
                $("#tablaInvo").html(datos);
            },
            statusCode: {
                404: function() {
                    alert( "pagina no encontrada" );
                }
            }
    });
}

function limpiaInvolucrado(){
   $(".involucradoQja").each(function(){
        if ($(this).attr('type') != 'radio') {
            $(this).val('');
        }
    });
    document.getElementById('vehiculo_servidor2').checked = true;
     $("input:radio[id=vehiculo_servidor2]").click();
     $("#dependencia_servidor").change();
}


function agregarInvolucrado() {
    $("#agregaInv").on("click",function(){
        quitarValidacionTestigo();
        validacionInvolucrado();
        if($('#qypForm').valid()){
            //reemplazaSaltos();
                var texto1 = $("#senias_servidor").val();
                texto1 = texto1.replace(/\n/g, "<br />");
                $("#senias_servidor").val(texto1);
                $("#senias_servidor").rules("remove");
                var texto2 = $("#desc_vehi_servidor").val();
                texto2 = texto2.replace(/\n/g, "<br />");
                $("#desc_vehi_servidor").val(texto2);
                $("#desc_vehi_servidor").rules("remove");
            
            $(this).attr("disabled",true);
            var totInv = parseInt($("#totInvolucrados").val());
            if (totInv < 3) {
                var opcion = $("#opcionEd").val();
                $("#opcionEd").val(19);
               // alert(opcion + " -- " + $("#opcionEd").val());
                //return false;
                var form = $("#qypForm");
                var datos = new FormData(document.getElementById("qypForm"));
                var tipo = form.attr("method");
                var url = form.attr("action");
                $.ajax({
                    dataType : "html",
                    type : tipo,
                    url : url,
                    data : datos,
                    cache : false,
                    contentType:false,
                    processData : false,
                    success : function(datos){
                                $("#tablaInvo").html(datos).slideDown('slow');
                                $("#totInvolucrados").val((totInv + 1));
                                mostrarInvolucrados($("#id_queja").val(),$("#cveHuerfanos").val(),1);
                                limpiaInvolucrado();
                                $("#desc_vehi_servidor").removeClass("error-message");
                                if ($("#totInvolucrados").val() >= 3) {
                                    $("#agregaInv").attr("disabled",true).hide();
                                    $("#agregarInvolucradoFrm, #btnInvolucrado").slideUp();
                                }
                            }
                });
                $("#opcionEd").val(opcion);
            }else{
                $("#modal-header").html('').append('<button type="button" class="close" data-dismiss="modal">&times;</button><h4 class="modal-title" style="color:#577492;">¡Atenci&oacute;n!</h4>');
                $("#modal-body").html('').append('<p>¡Maximo tres involucrados!.</p>');
                $("#modal-footer").html('').append('<button type="button" class="btn btn-default" data-dismiss="modal">OK</button>');
                $("#ModalGral").modal({backdrop: "static"});
                $("#ModalGral").modal("show");
            }           
        }else{
            $("#modal-header").html('').append('<button type="button" class="close" data-dismiss="modal">&times;</button><h4 class="modal-title" style="color:#577492;">¡Atenci&oacute;n!</h4>');
            $("#modal-body").html('').append('<p>¡Verifique la informaci&oacute;n ingresada, a&uacute;n no es correcta!.</p>');
            $("#modal-footer").html('').append('<button type="button" class="btn btn-default" data-dismiss="modal">OK</button>');
            $("#ModalGral").modal({backdrop: "static"});
            $("#ModalGral").modal("show");
        }
        $(this).attr("disabled",false);
        validacionTestigo();
        return false;
    });
}


function modInv() {
   $("#modificaInvolucrado").off();
   $("#modificaInvolucrado").on("click",function(){
        quitarValidacionTestigo();
        validacionInvolucrado();
        if($('#qypForm').valid()){
            //alert();
            //reemplazaSaltos();
            $(this).attr("disabled",true);
                var opcion = $("#opcionEd").val();
                $("#opcionEd").val(25);
                var texto1 = $("#senias_servidor").val();
                texto1 = texto1.replace(/\n/g, "<br />");
                $("#senias_servidor").val(texto1);
                $("#senias_servidor").rules("remove");
                var texto2 = $("#desc_vehi_servidor").val();
                texto2 = texto2.replace(/\n/g, "<br />");
                $("#desc_vehi_servidor").val(texto2);
                $("#desc_vehi_servidor").rules("remove");
                
                var form = $("#qypForm");
                var datos = new FormData(document.getElementById("qypForm"));
                var tipo = form.attr("method");
                var url = form.attr("action");
                $.ajax({
                    dataType : "json",
                    type : tipo,
                    url : url,
                    data : datos,
                    cache : false,
                    contentType:false,
                    processData : false,
                    success : function(datos){
                        mostrarInvolucrados($("#id_queja").val(),$("#cveHuerfanos").val(),1);
                        limpiaInvolucrado();
                        if ($("#totInvolucrados").val() >= 3) {
                            $("#agregaInv").attr("disabled",true).hide();
                            $("#agregarInvolucradoFrm, #btnInvolucrado").slideUp();
                        }else if ($("#totInvolucrados").val() <= 2) {
                            $("#agregaInv").attr("disabled",false).slideDown();
                            $("#agregarInvolucradoFrm, #btnInvolucrado").slideDown();
                            $("#modificaInvolucrado, #cancelaModificaInv").slideUp();
                        }
                        if (datos.estatus == 1) {
                           $("#modal-header").html('').append('<button type="button" class="close" data-dismiss="modal">&times;</button><h4 class="modal-title" style="color:#577492;">¡Atenci&oacute;n!</h4>');
                            $("#modal-body").html('').append('<p>' + datos.mensaje + '</p>');
                            $("#modal-footer").html('').append('<button type="button" class="btn btn-default" data-dismiss="modal">OK</button>');
                            $("#ModalGral").modal({backdrop: "static"});
                            $("#ModalGral").modal("show");
                            $("#formSBedita").attr("disabled",false);
                                                    
                        }else{
                            $("#modal-header").html('').append('<button type="button" class="close" data-dismiss="modal">&times;</button><h4 class="modal-title" style="color:#577492;">¡Atenci&oacute;n!</h4>');
                            $("#modal-body").html('').append('<p>¡El involucrado no pudo actualizarse, intente de nuevo!.</p>');
                            $("#modal-footer").html('').append('<button type="button" class="btn btn-default" data-dismiss="modal">OK</button>');
                            $("#ModalGral").modal({backdrop: "static"});
                            $("#ModalGral").modal("show");
                        }
                        
                    }
                });
                $("#opcionEd").val(opcion);  
        }else{
            $("#modal-header").html('').append('<button type="button" class="close" data-dismiss="modal">&times;</button><h4 class="modal-title" style="color:#577492;">¡Atenci&oacute;n!</h4>');
            $("#modal-body").html('').append('<p>¡Verifique la informaci&oacute;n ingresada, a&uacute;n no es correcta!.</p>');
            $("#modal-footer").html('').append('<button type="button" class="btn btn-default" data-dismiss="modal">OK</button>');
            $("#ModalGral").modal({backdrop: "static"});
            $("#ModalGral").modal("show");
        }
        validacionTestigo();
        $(this).attr("disabled",false);
        return false;
    });
}


function eliminaInvolucrado(){
    $(".eliminarInvolucrado").on('click',function(){
            var cual = $(this).attr("for");
            $("#modal-header").html('').append('<button type="button" class="close" data-dismiss="modal">&times;</button><h4 class="modal-title" style="color:red;">¡Eliminar involucrado!</h4>');
            $("#modal-body").html('').append('<p>&iquest;Est&aacute; seguro de eliminar el involucrado? no podr&aacute; recuperar la informaci&oacute;n</p>');
            $("#modal-footer").html('').append('Borrar la Solicitud: <button type="button" class="btn btn-default" data-dismiss="modal">NO</button><button type="button" id="sielimina" for="'+ cual +'" class="btn btn-danger" data-dismiss="modal">SI</button>');
            $("#ModalGral").modal({backdrop: "static"});
            $("#ModalGral").modal("show");
            
            $("#sielimina").on("click",function(){
                var cualsi = $(this).attr("for");
                var queja_id = $("#id_queja").val();
                var huerfano = $("#cveHuerfanos").val();
                $.ajax({
                        dataType: "json",
                        type: "POST",
                        data: {'sel': cualsi,'opcion':20,'queja':queja_id,'huerfano':huerfano},
                        url: 'herramientas/funciones/solicitud.php',
                        async: false,
                        success: function(datos){
                            if (datos.estatus == 1) {
                                var totInv = parseInt($("#totInvolucrados").val());
                                $("#totInvolucrados").val((totInv - 1));
                                
                                mostrarInvolucrados(queja_id,huerfano,1);
                                if (totInv == 3) {
                                    $("#agregaInv").attr("disabled",false).slideDown();
                                    $("#agregarInvolucradoFrm, #btnInvolucrado").slideDown();
                                    $("#modificaInvolucrado").slideUp();
                                    $("#cancelaModificaInv").slideUp();
                                }
                                
                            }else{
                                $("#modal-header").html('').append('<button type="button" class="close" data-dismiss="modal">&times;</button><h4 class="modal-title" style="color:red;">Involucrado no eliminado!</h4>');
                                $("#modal-body").html('').append('<p>No fue posible eliminar al involucrado, por favor intente de nuevo.</p>');
                                $("#modal-footer").html('').append('<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>');
                                $("#ModalGral").modal({backdrop: "static"});
                                $("#ModalGral").modal("show");
                            }
                        },
                        statusCode: {
                            404: function() {
                                alert( "pagina no encontrada" );
                            }
                        }
                    });
            });
            return false;
     });
    
    $(".verInvolucrado").on("click",function(){
        $("#formSBedita").attr("disabled",true);
        $("#agregarInvolucradoFrm").slideDown();
        limpiaInvolucrado();
        quitarValidacionInvolucrado();
        $('#qypForm').validate().element( "#sexo_servidor" );
        $('#qypForm').validate().element( "#dependencia_servidor" );
        $('#qypForm').validate().element( "#uniforme_servidor" );
        validacionInvolucrado();

        var cual = $(this).attr("for");
        $.ajax({
            dataType: "html",
            type: "POST",
            data: {"opcion":24,"cual":cual},
            url: "herramientas/funciones/solicitud.php",
            async: true,
            success: function(datos){
                //alert();
                if ($("#totInvolucrados").val() == 3) {
                    $("#btnInvolucrado").slideDown();
                }
                $("#btnInvolucrado").append(datos);
                $("#modificaInvolucrado").slideDown();
                modInv();
                $("#cancelaModificaInv").slideDown();
                $("#agregaInv").attr("disabled",true).slideUp();
                
                $(".eliminarInvolucrado").attr("disabled",true);
                
                
                $("#cancelaModificaInv").on("click",function(){
                    limpiaInvolucrado();
                    $("#modificaInvolucrado").off();
                    if ($("#totInvolucrados").val() == 3) {
                        $("#agregaInv").attr("disabled",true).hide();
                        $("#agregarInvolucradoFrm, #btnInvolucrado").slideUp();
                    }else if ($("#totInvolucrados").val() < 3) {
                        $("#modificaInvolucrado").slideUp();
                        $("#cancelaModificaInv").slideUp();
                        $("#agregaInv").attr("disabled",false).slideDown();
                    }
                    $(".eliminarInvolucrado").attr("disabled",false);
                    $("#formSBedita").attr("disabled",false);
                    return false;
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





function mostrarTestigos(quejaId,cveHuerfano,enlace){
    $.ajax({    
            dataType : "html",
            type : "POST",
            url : "herramientas/funciones/solicitud.php",
            data : {"opcion":21,"quejaId":quejaId,"huerfano": cveHuerfano,"enlace":enlace},
            async: false,
            success : function(datos){
                $("#tablaTest").html(datos);
            },
            statusCode: {
                404: function() {
                    alert( "pagina no encontrada" );
                }
            }
    });
}

function limpiaTestigo(){
    $(".testigoQja").each(function(){
        $(this).val('');
    });
    
}

function agregarTestigo() {
     $("#agregaTest").on("click",function(){
        quitarValidacionInvolucrado();
        validacionTestigo();
        if($('#qypForm').valid()){
            if($("#telefono_testigo").val() == "" && $("#correo_testigo").val() == ""){
                $("#modal-header").html('').append('<button type="button" class="close" data-dismiss="modal">&times;</button><h4 class="modal-title" style="color:#577492;">¡Atenci&oacute;n!</h4>');
                $("#modal-body").html('').append('<p>Debe ingresar correo o telefono del testigo.</p>');
                $("#modal-footer").html('').append('<button type="button" class="btn btn-default" data-dismiss="modal">OK</button>');
                $("#ModalGral").modal({backdrop: "static"});
                $("#ModalGral").modal("show");
                validacionInvolucrado();
                return false;
            }
            var totTes = parseInt($("#totTestigos").val());
            if (totTes < 3) {
                var opcion = $("#opcionEd").val();
                $("#opcionEd").val(22);
               // alert($("#opcionEd").val());
                var form = $("#qypForm");
                var datos = new FormData(document.getElementById("qypForm"));
                var tipo = form.attr("method");
                var url = form.attr("action");
                $.ajax({
                    dataType : "html",
                    type : tipo,
                    url : url,
                    data : datos,
                    cache : false,
                    contentType:false,
                    processData : false,
                    success : function(datos){
                                $("#tablaTest").html(datos).slideDown('slow');
                                $("#totTestigos").val((totTes + 1));
                                mostrarTestigos($("#id_queja").val(),$("#cveHuerfanos").val(),1);
                                limpiaTestigo();
                                if ($("#totTestigos").val() >= 3) {
                                    $("#agregaTest").attr("disabled",true).hide();
                                    $("#agregarTestigoFrm").slideUp();
                                }
                            }
                });
                $("#opcionEd").val(opcion);
            }else{
                $("#modal-header").html('').append('<button type="button" class="close" data-dismiss="modal">&times;</button><h4 class="modal-title" style="color:#577492;">¡Atenci&oacute;n!</h4>');
                $("#modal-body").html('').append('<p>¡Maximo tres involucrados!.</p>');
                $("#modal-footer").html('').append('<button type="button" class="btn btn-default" data-dismiss="modal">OK</button>');
                $("#ModalGral").modal({backdrop: "static"});
                $("#ModalGral").modal("show");
            }
           
            //alert("agregado");
        }
        validacionInvolucrado();
        return false;
    });
}

function modTestigo() {
   $("#modificaTes").off();
   $("#modificaTes").on("click",function(){
        quitarValidacionInvolucrado();
        validacionTestigo();
        if($('#qypForm').valid()){
            //alert();
            $(this).attr("disabled",true);
                var opcion = $("#opcionEd").val();
                $("#opcionEd").val(27);
                var form = $("#qypForm");
                var datos = new FormData(document.getElementById("qypForm"));
                var tipo = form.attr("method");
                var url = form.attr("action");
                $.ajax({
                    dataType : "json",
                    type : tipo,
                    url : url,
                    data : datos,
                    cache : false,
                    contentType:false,
                    processData : false,
                    success : function(datos){
                        mostrarTestigos($("#id_queja").val(),$("#cveHuerfanos").val(),1);
                        limpiaTestigo();
                        $("#btnTestigo").slideDown();
                        if ($("#totTestigos").val() >= 3) {
                            $("#agregaTest").attr("disabled",true).hide();
                            $("#agregarTestigoFrm, #btnTestigo").slideUp();
                        }else if ($("#totTestigos").val() <= 2) {
                            $("#agregaTest").attr("disabled",false).slideDown();
                            $("#agregarTestigoFrm, #btnTestigo").slideDown();
                            $("#modificaTes, #cancelaModificaTes").slideUp();
                        }
                        if (datos.estatus == 1) {
                           $("#modal-header").html('').append('<button type="button" class="close" data-dismiss="modal">&times;</button><h4 class="modal-title" style="color:#577492;">¡Atenci&oacute;n!</h4>');
                            $("#modal-body").html('').append('<p>' + datos.mensaje + '</p>');
                            $("#modal-footer").html('').append('<button type="button" class="btn btn-default" data-dismiss="modal">OK</button>');
                            $("#ModalGral").modal({backdrop: "static"});
                            $("#ModalGral").modal("show");
                            $("#formSBedita").attr("disabled",false);
                                                    
                        }else{
                            $("#modal-header").html('').append('<button type="button" class="close" data-dismiss="modal">&times;</button><h4 class="modal-title" style="color:#577492;">¡Atenci&oacute;n!</h4>');
                            $("#modal-body").html('').append('<p>¡El testigo no pudo actualizarse, intente de nuevo!.</p>');
                            $("#modal-footer").html('').append('<button type="button" class="btn btn-default" data-dismiss="modal">OK</button>');
                            $("#ModalGral").modal({backdrop: "static"});
                            $("#ModalGral").modal("show");
                        }
                        
                    }
                });
                $("#opcionEd").val(opcion);  
        }else{
            $("#modal-header").html('').append('<button type="button" class="close" data-dismiss="modal">&times;</button><h4 class="modal-title" style="color:#577492;">¡Atenci&oacute;n!</h4>');
            $("#modal-body").html('').append('<p>¡Verifique la informaci&oacute;n ingresada, a&uacute;n no es correcta!.</p>');
            $("#modal-footer").html('').append('<button type="button" class="btn btn-default" data-dismiss="modal">OK</button>');
            $("#ModalGral").modal({backdrop: "static"});
            $("#ModalGral").modal("show");
        }
        validacionTestigo();
        $(this).attr("disabled",false);
        return false;
    });
}



function eliminaTestigo(){
    $(".eliminarTestigo").on('click',function(){
            var cual = $(this).attr("for");
            $("#modal-header").html('').append('<button type="button" class="close" data-dismiss="modal">&times;</button><h4 class="modal-title" style="color:red;">¡Eliminar testigo!</h4>');
            $("#modal-body").html('').append('<p>&iquest;Est&aacute; seguro de eliminar el testigo? no podr&aacute; recuperar la informaci&oacute;n</p>');
            $("#modal-footer").html('').append('Borrar la Solicitud: <button type="button" class="btn btn-default" data-dismiss="modal">NO</button><button type="button" id="sieliminat" for="'+ cual +'" class="btn btn-danger" data-dismiss="modal">SI</button>');
            $("#ModalGral").modal({backdrop: "static"});
            $("#ModalGral").modal("show");
            
            $("#sieliminat").on("click",function(){
                var cualsi = $(this).attr("for");
                var queja_id = $("#id_queja").val();
                var huerfano = $("#cveHuerfanos").val();
                $.ajax({
                        dataType: "json",
                        type: "POST",
                        data: {'sel': cualsi,'opcion':23,'queja':queja_id,'huerfano':huerfano},
                        url: 'herramientas/funciones/solicitud.php',
                        async: false,
                        success: function(datos){
                            if (datos.estatus == 1) {
                                var totTes = parseInt($("#totTestigos").val());
                                $("#totTestigos").val((totTes - 1));
                                mostrarTestigos(queja_id,huerfano,1);
                                $("#modificaTes").slideUp();
                                $("#cancelaModificaTes").slideUp();
                                if (totTes == 3) {
                                    $("#agregaTest").attr("disabled",false).slideDown();
                                    $("#agregarTestigoFrm,#btnTestigo").slideDown();
                                }
                                
                            }else{
                                $("#modal-header").html('').append('<button type="button" class="close" data-dismiss="modal">&times;</button><h4 class="modal-title" style="color:red;">Involucrado no eliminado!</h4>');
                                $("#modal-body").html('').append('<p>No fue posible eliminar al involucrado, por favor intente de nuevo.</p>');
                                $("#modal-footer").html('').append('<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>');
                                $("#ModalGral").modal({backdrop: "static"});
                                $("#ModalGral").modal("show");
                            }
                        },
                        statusCode: {
                            404: function() {
                                alert( "pagina no encontrada" );
                            }
                        }
                    });
            });
            return false;
     });
    
    $(".verTestigo").on("click",function(){
        $("#formSBedita").attr("disabled",true);
        $("#agregarTestigoFrm").slideDown();
        $("#obliTestigoDiv").hide();
        limpiaTestigo();
        quitarValidacionTestigo();
        $('#qypForm').validate().element( "#nombre_testigo" );
        validacionTestigo();
        var cual = $(this).attr("for");
        $.ajax({
            dataType: "html",
            type: "POST",
            data: {"opcion":26,"cual":cual},
            url: "herramientas/funciones/solicitud.php",
            async: true,
            success: function(datos){
                //alert();
               /* if ($("#opcionEd").val() == 13) {
                    $("#btnTestigo").slideDown();
                }else{
                    $("#btnTestigo").hide();
                }*/
                
                $("#btnTestigo").append(datos);
                $("#modificaTes,#btnTestigo").slideDown();
                modTestigo();
                $("#cancelaModificaTes").slideDown();
                $("#agregaTest").attr("disabled",true).slideUp();
                
                $(".eliminarTestigo").attr("disabled",true);                
                
                $("#cancelaModificaTes").on("click",function(){
                    limpiaTestigo();
                    $("#modificaTes").off();
                    if ($("#totTestigos").val() == 3) {
                        $("#agregaTest").attr("disabled",true).hide();
                        $("#agregarTestigoFrm, #btnTestigo").slideUp();
                    }else if ($("#totTestigos").val() < 3) {
                        $("#modificaTes").slideUp();
                        $("#cancelaModificaTes").slideUp();
                        $("#agregaTest").attr("disabled",false).slideDown();
                    }
                    $(".eliminarTestigo").attr("disabled",false);
                    $("#formSBedita").attr("disabled",false);
                    return false;
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




function eventoAgregarQP(mensaje,estatus) {
    window.parent.$("#qypForm").slideUp();
    window.parent.$("#modal-header").html("").append('<button type="button" class="close" data-dismiss="modal">&times;</button><h4 class="modal-title" style="color:#577492;">¡Atenci&oacute;n!</h4>');
    window.parent.$("#modal-body").html("").append("<p>" + mensaje + " </p>");
    window.parent.$("#modal-footer").html("").append('<button type="button" class="btn btn-default" data-dismiss="modal">OK</button>');
    window.parent.$("#ModalGral").modal({backdrop: "static"});
    window.parent.$("#ModalGral").modal("show");
    if(estatus == 1){
        $.ajax({    
            dataType : "html",
            type : "POST",
            url : "solicitud.php",
            data : {"opcion":2},
            success : function(datos){
                window.parent.$("#contSol").html(datos);
            },
            statusCode: {
                    404: function() {
                        alert( "pagina no encontrada" );
                    }
             }
        });
    }          
    
    window.parent.$("#qypForm").slideDown();
    window.parent.$("#guardarqja, #guardapet").attr("disabled",false);
    window.parent.$('html,body').animate({
                    scrollTop:  window.parent.$("#contInputBusqueda").offset().top
    }, 300);   
}

function identificacionesVacias(){
        if ($('#causa').val() == 18) {
            if ($('#id_solicitante_a').val() == '' || $('#id_alocalizar').val() == '') {
                $("#identificaciones_causa div.file-caption").addClass("error-message");
                $("#modal-header").html('').append('<button type="button" class="close" data-dismiss="modal">&times;</button><h4 class="modal-title" style="color:#577492;">¡Atenci&oacute;n!</h4>');
                $("#modal-body").html('').append('<p>Debe cargar las identificaciones.</p>');
                $("#modal-footer").html('').append('<button type="button" class="btn btn-default" data-dismiss="modal">OK</button>');
                $("#ModalGral").modal({backdrop: "static"});
                $("#ModalGral").modal("show");
                //alert("Debe cargar las identificaciones");
                return 0;
            }
        }
        return 1;
    }

function cargaListas() {
    var url = "herramientas/funciones/combos.php?consulta=";
    llenaCombo(url+"3","#tipo_registro");
    llenaCombo(url+"4","#medio_recepcion");
    llenaCombo(url+"18","#estatus_peticion");
    llenaCombo(url+"5","#pais_hechos, #pais_origen");
    llenaCombo(url+"9","#sexoq, #sexo_servidor");
    llenaCombo(url+"13","#dependencia_peticion",true);
    llenaCombo(url+"19","#dependencia_servidor");
}

function validacionInvolucrado(){
    $('.qjare').each(function(){
        $(this).rules( "add", {
            required: true,
            messages: {
                required: 'Campo obligatorio *'
            }
        });
    });
      $('#nombre_servidor').rules( "add", {
        textocomun: true,
        maxlength: 50,
        messages: {
            textocomun :'S&oacute;lo letras',
            maxlength: 'M&aacute;ximo de caracteres alcanzado (50)'
        }
    });
    
    $('#edad_servidor').rules( "add", {
        numeros:true,
        min: 1,
        max: 99,
        messages: {
            number:'S&oacute;lo n&uacute;meros [0-9]',
            min: 'Valor minimo 1',
            max: 'Valor maximo 99',
        }
    });
   $('#tez_servidor').rules( "add", {
        textocomun: true,
        maxlength: 250,
        messages: {
            textocomun: 'S&oacute;lo letras',
            maxlength: 'M&aacute;ximo de caracteres alcanzado (250)'
        }
    });
   $('#complexion_servidor').rules( "add", {
        textocomun: true,
        maxlength: 250,
        messages: {
            textocomun: 'S&oacute;lo letras',
            maxlength: 'M&aacute;ximo de caracteres alcanzado (250)'
        }
    });
   $('#ojos_servidor').rules( "add", {
        textocomun: true,
        maxlength: 250,
        messages: {
            textocomun: 'S&oacute;lo letras',
            maxlength: 'M&aacute;ximo de caracteres alcanzado (250)'
        }
    });
    $("#edad_servidor").numeric({ decimal: false, negative: false });
    $('#estatura_servidor').rules( "add", {
        estatura:true
    });
    $("#estatura_servidor").numeric({ decimalPlaces: 2,negative: false });
    $('#cargo_servidor').rules( "add", {
        textocomun: true,
    });
    
    $('#identificacion_servidor').rules( "add", {
        number: true,
        messages : {number:'S&oacute;lo n&uacute;meros [0-9]'}
    });
    
    $('#senias_servidor').rules( "add", {
        direccion: true,
        maxlength: 250,
        messages: {
            maxlength: 'M&aacute;ximo de caracteres alcanzado (250)'
        }
    });
     $('#desc_vehi_servidor').rules( "add", {
        direccion: true,
        maxlength: 250,
        messages: {
            maxlength: 'M&aacute;ximo de caracteres alcanzado (250)'
        }
    });
    $('#placas_servidor').rules( "add", {
        placa: true,
        maxlength: 20,
        messages: {
            maxlength: 'M&aacute;ximo de caracteres alcanzado (20)'
        }
    });
    $('#color_vehi_servidor').rules( "add", {
        textocomun: true,
        maxlength: 250,
        messages: {
            textocomun:"S&oacute;lo letras",
            maxlength: 'M&aacute;ximo de caracteres alcanzado (250)'
        }
    });
}
function quitarValidacionInvolucrado() {
    $(".involucradoQja").each(function(){
        $(this).rules('remove');    
    });
}

function validacionQueja() {
    $('#narracion_servidor').rules( "add", {
        direccion: true,
        maxlength: 300,
        messages: {
            maxlength: 'M&aacute;ximo de caracteres alcanzado (300)'
        }
    });
    
    $("#narracion_servidor").on('keyup',function(){
        var tot = $(this).val().length;
        //console.log(tot);
        if (tot < 150) {
            $("#contador_narracion_servidor").html("<h6>" + tot + " caracteres</h6>");
        }else if (tot > 150 && tot < 260) {
            $("#contador_narracion_servidor").html("<h6 style='color:#b9b748'>" + tot + " caracteres</h6>");
        }else if (tot > 260 && tot < 290) {
            $("#contador_narracion_servidor").html("<h6 style='color:#b98448'>" + tot + " caracteres</h6>");
        }else if (tot > 290 && tot < 300) {
            $("#contador_narracion_servidor").html("<h6 style='color:#b96b48'>" + tot + " caracteres</h6>");
        }else if ( tot == 300) {
            $("#contador_narracion_servidor").html("<h7 style='color:#b94a48;'>" + tot + " caracteres</h7>");
            return false;
        }else if(tot > 300){
            $("#contador_narracion_servidor").html("<h7 style='color:#b94a48;'>" + tot + " caracteres</h7>");
            return false;
        }
        
    });
     $("#narracion_servidor").on('keypress',function(){
        //alert($(this).val().length);
        if ($(this).val().length >= 300) {
            //return false;
        }
     });
     
    $("#narracion_servidor").on("change",function(){
        exesoQuejaNarracion();
    });
}
function exesoQuejaNarracion() {
    var tot = $("#narracion_servidor").val().length;
    var cont = $("#narracion_servidor").val();
    if (tot > 300) {
             $("#narracion_servidor").val(cont.substring(0, 300));
    }
    var tot2 = $("#narracion_servidor").val().length;
    $("#contador_narracion_servidor").html("<h7 style='color:#b94a48;'>" + tot2 + " caracteres</h7>");
}


function validacionTestigo() {
    $('#nombre_testigo').rules( "add", {
        required: true,
        textocomun: true,
        maxlength: 50,
        messages: {
            required : 'Campo obligatorio *',
            textocomun :'S&oacute;lo letras',
            maxlength: 'M&aacute;ximo de caracteres alcanzado (50)'
        }
    });
    $('#telefono_testigo').rules( "add", {
        number: true,
        minlength: 3,
        maxlength: 18,
        messages: {
            number :'S&oacute;lo n&uacute;meros [0-9]',
            minlength: 'Minimo 3 n&uacute;meros',
            maxlength: 'M&aacute;ximo 18 n&uacute;meros'
        }
    });
    $('#correo_testigo').rules( "add", {
        email: true,
        maxlength: 50,
        messages: {
            email :'Ingrese un correo valido',
            maxlength: 'M&aacute;ximo de caracteres alcanzado (50)'
        }
    });
}
function quitarValidacionTestigo() {
    $(".testigoQja").each(function(){
        $(this).rules('remove');    
    });
}

function validacionPeticion() {
    $('.rpet').each(function(){
        $(this).rules( "add", {
            required: true,
            messages: {
                required: 'Campo obligatorio *'
            }
        });
    });
    
    $('#solicitud_peticion').rules( "add", {
        direccion: true,
        maxlength: 250,
        messages: {
            direccion: 'S&oacute;lo letras y n&uacute;meros',
            maxlength: 'M&aacute;ximo de caracteres alcanzado (250)'
        }
    });
    
    $('#describe_peticion').rules( "add", {
        direccion: true,
        maxlength: 250,
        messages: {
            direccion: 'S&oacute;lo letras y n&uacute;meros',
            maxlength: 'M&aacute;ximo de caracteres alcanzado (250)'
        }
    });
    
}


//---------------------------------------------------SEGUIMIENTO------------------------------------------------------------------------

function inicioSeg() {
    $('#busquedaSolBtn').validate({
        errorElement: 'span',
        errorClass: 'error-message',
        rules:{
            busquedaSol:{busqueda:true},
        }
    });
    
      $("#busquedaSol").on('keyup',function(){
        if($('#busquedaSolBtn').valid()){
            var bus = $(this).val();
            //alert(bus);
            var tipo = $('#tipo').val();
            var url = "herramientas/funciones/solicitud.php";
            var rol = $('#rol').val();
            var datos = {'rol':rol,'tipo':tipo,'opcion':3,'busca':bus};
            $.ajax({
                    dataType : "html",
                    type : 'POST',
                    url : url,
                    data : datos,
                    async:false,
                    success : function(datos){
                        $("#pintaTabla").html(datos);
                    }
            });
        }
    });
    
    $("#actualiza").on('click',function(){
        var tipo = $('#tipo').val();
        var url = "herramientas/funciones/solicitud.php";
        var rol = $('#rol').val();
        $("#busquedaSol").val('');
        $("#pintaTabla").slideUp('slow',function(){
                $("#carga").show();
            }).delay(200).queue(function(){
                
                var datos = {'rol':rol,'tipo':tipo,'opcion':3};
                $.ajax({
                        dataType : "html",
                        type : 'POST',
                        url : url,
                        data : datos,
                        async:false,
                        success : function(datos){
                            $("#pintaTabla").html(datos);
                        }
                });
                 var datos2 = {'rol':rol,'tipo':tipo,'opcion':5};
                 $.ajax({
                        dataType : "html",
                        type : 'POST',
                        url : url,
                        data : datos2,
                        async:true,
                        success : function(datos){
                            $("#mBandeja").html(datos);
                            if (tipo == 1) {
                                $("#nuevas").addClass("list-group-item-success");
                                $("#asig_oic").removeClass("list-group-item-success");
                            }else if (tipo == 2) {
                                $("#asig_oic").addClass("list-group-item-success");
                                $("#nuevas").removeClass("list-group-item-success");
                            }
                        }
                });
                $("#carga").hide();
                $(this).dequeue(); //continúo con el siguiente ítem en la cola
         });
                 
         $("#pintaTabla").slideDown('slow');
        
    });
}


function bandeja() {
    $('#asig_oic').on('click',function(){
        $('#tipo').val(2);
        var tipo = $('#tipo').val();
        var url = "herramientas/funciones/solicitud.php";
        var rol = $('#rol').val();
        $("#busquedaSol").val('');
        $("#pintaTabla").slideUp('slow',function(){
                $("#carga").show();
            }).delay(200).queue(function(){
                
                var datos = {'rol':rol,'tipo':2,'opcion':3};
                $.ajax({
                        dataType : "html",
                        type : 'POST',
                        url : url,
                        data : datos,
                        async:false,
                        success : function(datos){
                            $("#pintaTabla").html(datos);
                        }
                });
                 var datos2 = {'rol':rol,'tipo':tipo,'opcion':5};
                 $.ajax({
                        dataType : "html",
                        type : 'POST',
                        url : url,
                        data : datos2,
                        async:true,
                        success : function(datos){
                            $("#mBandeja").html(datos);
                            if (tipo == 1) {
                                $("#nuevas").addClass("list-group-item-success");
                                $("#asig_oic").removeClass("list-group-item-success");
                            }else if (tipo == 2) {
                                $("#asig_oic").addClass("list-group-item-success");
                                $("#nuevas").removeClass("list-group-item-success");
                            }
                        }
                });
                $("#carga").hide();
                $(this).dequeue(); //continúo con el siguiente ítem en la cola
         });
                 
         $("#pintaTabla").slideDown('slow');
        
        
        $(this).addClass("list-group-item-success");
        $("#nuevas").removeClass("list-group-item-success");
       
        
    });
    $('#nuevas').on('click',function(){
        $('#tipo').val(1);
       var tipo = $('#tipo').val();
        var url = "herramientas/funciones/solicitud.php";
        var rol = $('#rol').val();
        $("#busquedaSol").val('');
        $("#pintaTabla").slideUp('slow',function(){
                $("#carga").show();
            }).delay(200).queue(function(){
                var datos = {'rol':rol,'tipo':1,'opcion':3};
                $.ajax({
                        dataType : "html",
                        type : 'POST',
                        url : url,
                        data : datos,
                        async:false,
                        success : function(datos){
                            $("#pintaTabla").html(datos);
                        }
                });
                 var datos2 = {'rol':rol,'tipo':tipo,'opcion':5};
                 $.ajax({
                        dataType : "html",
                        type : 'POST',
                        url : url,
                        data : datos2,
                        async:true,
                        success : function(datos){
                            $("#mBandeja").html(datos);
                            if (tipo == 1) {
                                $("#nuevas").addClass("list-group-item-success");
                                $("#asig_oic").removeClass("list-group-item-success");
                            }else if (tipo == 2) {
                                $("#asig_oic").addClass("list-group-item-success");
                                $("#nuevas").removeClass("list-group-item-success");
                            }
                        }
                });
                $("#carga").hide();
                $(this).dequeue(); //continúo con el siguiente ítem en la cola
         });
                 
         $("#pintaTabla").slideDown('slow');
        $(this).addClass("list-group-item-success");
        $("#asig_oic").removeClass("list-group-item-success");
    });

 
}

function botonesBandeja() {
     $("#todos").on('click',function(){
        if( $(this).prop('checked') ) {
            $(".seleccionado").each(function(){
                $(this).prop('checked',true);
            });
        }else{
            $(".seleccionado").each(function(){
                $(this).prop('checked',false);
                $(this).parent().parent().removeClass("danger");
            });
        }
    });
    
     $(".seleccionado").on('click',function(){
        var sel = 0;
        if(!$(this).prop('checked')){
            $(this).parent().parent().removeClass("danger");
        }
        $(".seleccionado").each(function(){
               if($(this).prop('checked')){
                    sel++;
               }
        });
        if (sel == 0) {
            $("#todos").prop('checked',false);
        }
     });
    
     $("#enviardnpp").on('click',function(){
        var sel = 0;
        var totalBien = 0;
        var rol = $('#rol').val();
        var cveSolicitud = $("#id_solicitud").val();
        //alert(cveSolicitud);
        if (cveSolicitud == undefined){
            $(".seleccionado").each(function(){
                    if($(this).prop('checked')){
                         sel++;
                         var cve = $(this).attr('clave');
                         $.ajax({
                             dataType: "json",
                             type: "POST",
                             data: {'sel': cve,'opcion':4,'rol':rol},
                             url: 'herramientas/funciones/solicitud.php',
                             async: false,
                             success: function(datos){
                                 //alert(datos.estatus);
                                 if (datos.estatus == 1) {
                                     totalBien++;
                                 }
                             },
                             statusCode: {
                                 404: function() {
                                   alert( "pagina no encontrada" );
                                 }
                             }
                         });
                    }
            });
             
             
             if (sel == 0) {
                 $("#modal-header").html('').append('<button type="button" class="close" data-dismiss="modal">&times;</button><h4 class="modal-title" style="color:#577492;">¡Atenci&oacute;n!</h4>');
                 $("#modal-body").html('').append('<p>Debe seleccionar al menos un elemento.</p>');
                 $("#modal-footer").html('').append('<button type="button" class="btn btn-default" data-dismiss="modal">OK</button>');
                 $("#ModalGral").modal({backdrop: "static"});
                 $("#ModalGral").modal("show");
                 //alert("Debe seleccionar al menos un elemento");
                 return false;
             }
             if (totalBien == sel) {
                 $("#modal-header").html('').append('<button type="button" class="close" data-dismiss="modal">&times;</button><h4 class="modal-title">¡Asignaci&oacute;n a DNPP correcta!</h4>');
                 $("#modal-body").html('').append('<p>Se asignaron correctamente los elementos seleccionados a la DNPP.</p>');
                 $("#modal-footer").html('').append('<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>');
                 $("#ModalGral").modal({backdrop: "static"});
             }else{
                 $("#modal-header").html('').append('<button type="button" class="close" data-dismiss="modal">&times;</button><h4 class="modal-title" style="color:red;">¡Asignaci&oacute;n a DNPP incorrecta!</h4>');
                 $("#modal-body").html('').append('<p>No se asignaron correctamente los elementos seleccionados a la DNPP, por favor intente de nuevo.</p>');
                 $("#modal-footer").html('').append('<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>');
                 $("#ModalGral").modal({backdrop: "static"});
                 $("#ModalGral").modal("show");
             }
        }else{
            $.ajax({
                dataType: "json",
                type: "POST",
                data: {'sel': cveSolicitud,'opcion':4,'rol':rol},
                url: 'herramientas/funciones/solicitud.php',
                async: false,
                success: function(datos){
                    if (datos.estatus == 1) {
                        $("#modal-header").html('').append('<button type="button" class="close" data-dismiss="modal">&times;</button><h4 class="modal-title">¡Asignaci&oacute;n a DNPP correcta!</h4>');
                        $("#modal-body").html('').append('<p>La solicitud se asigno correctamente a la DNPP.</p>');
                        $("#modal-footer").html('').append('<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>');
                        $("#ModalGral").modal({backdrop: "static"});
                    }else{
                        $("#modal-header").html('').append('<button type="button" class="close" data-dismiss="modal">&times;</button><h4 class="modal-title" style="color:red;">¡Asignaci&oacute;n a DNPP incorrecta!</h4>');
                        $("#modal-body").html('').append('<p>La solicitud no se asignao correctamente a la DNPP, por favor intente de nuevo.</p>');
                        $("#modal-footer").html('').append('<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>');
                        $("#ModalGral").modal({backdrop: "static"});
                        $("#ModalGral").modal("show");
                    }
                },
                statusCode: {
                    404: function() {
                        alert( "pagina no encontrada" );
                    }
                }
            });
        }
        $("#actualiza").click();
    });
     
     
     //-------------------------------
    $("#enviaroic").on('click',function(){
        var sel = 0;
        var totalBien = 0;
        var rol = $('#rol').val();
        var cveSolicitud = $("#id_solicitud").val();
        //alert(cveSolicitud);
        if (cveSolicitud == undefined)
        {
            var peticiones = 0;
            $(".seleccionado").each(function(){
                if($(this).prop('checked')){
                    var cve = $(this).attr('clave');
                   // alert("#nombre_operacion" + cve);
                    //alert($("#nombre_operacion" + cve).html());
                    if ($("#nombre_operacion" + cve).html() != "Queja") {
                        peticiones++;
                        $("#nombre_operacion" + cve).parent().addClass("danger");
                    }
                }
            });
            if (peticiones == 0) {
                $(".seleccionado").each(function(){
                        if($(this).prop('checked')){
                             sel++;
                             var cve = $(this).attr('clave');
                             $.ajax({
                                 dataType: "json",
                                 type: "POST",
                                 data: {'sel': cve,'opcion':6,'rol':rol},
                                 url: 'herramientas/funciones/solicitud.php',
                                 async: false,
                                 success: function(datos){
                                     if (datos.estatus == 1) {
                                         totalBien++;
                                     }
                                 },
                                 statusCode: {
                                     404: function() {
                                       alert( "pagina no encontrada" );
                                     }
                                 }
                             });
                        }
                });
                if (sel == 0) {
                     $("#modal-header").html('').append('<button type="button" class="close" data-dismiss="modal">&times;</button><h4 class="modal-title" style="color:#577492;">¡Atenci&oacute;n!</h4>');
                     $("#modal-body").html('').append('<p>Debe seleccionar al menos un elemento.</p>');
                     $("#modal-footer").html('').append('<button type="button" class="btn btn-default" data-dismiss="modal">OK</button>');
                     $("#ModalGral").modal({backdrop: "static"});
                     $("#ModalGral").modal("show");
                     return false;
                 }
                 if (totalBien == sel) {
                     $("#modal-header").html('').append('<button type="button" class="close" data-dismiss="modal">&times;</button><h4 class="modal-title">¡Asignaci&oacute;n a OIC correcta!</h4>');
                     $("#modal-body").html('').append('<p>Se asignaron correctamente los elementos seleccionados a OIC.</p>');
                     $("#modal-footer").html('').append('<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>');
                     $("#ModalGral").modal({backdrop: "static"});
                    // alert("Se asignaron correctamente a OIC los elementos seleccionados");
                 }else{
                     $("#modal-header").html('').append('<button type="button" class="close" data-dismiss="modal">&times;</button><h4 class="modal-title" style="color:red;">¡Asignaci&oacute;n a OIC incorrecta!</h4>');
                     $("#modal-body").html('').append('<p>No se asignaron correctamente los elementos seleccionados a OIC, por favor intente de nuevo.</p>');
                     $("#modal-footer").html('').append('<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>');
                     $("#ModalGral").modal({backdrop: "static"});
                     $("#ModalGral").modal("show");
                     //alert("no asignaron correctamente todos los elementos seleccionados a OIC");
                 }
                
            }else{
                 $("#modal-header").html('').append('<button type="button" class="close" data-dismiss="modal">&times;</button><h4 class="modal-title" style="color:#577492;">¡Atenci&oacute;n!</h4>');
                 $("#modal-body").html('').append('<p>Las peticiones de ayuda no pueden ser asignadas a OIC.</p>');
                 $("#modal-footer").html('').append('<button type="button" class="btn btn-default" data-dismiss="modal">OK</button>');
                 $("#ModalGral").modal({backdrop: "static"});
                 $("#ModalGral").modal("show");
                 return false;
            }
 
        }else{
            if ($("#tipo_registro").val() == 2) {
                 $("#modal-header").html('').append('<button type="button" class="close" data-dismiss="modal">&times;</button><h4 class="modal-title" style="color:#577492;">¡Atenci&oacute;n!</h4>');
                 $("#modal-body").html('').append('<p>Las peticiones de ayuda no pueden ser asignadas a OIC.</p>');
                 $("#modal-footer").html('').append('<button type="button" class="btn btn-default" data-dismiss="modal">OK</button>');
                 $("#ModalGral").modal({backdrop: "static"});
                 $("#ModalGral").modal("show");
                 return false;
            }else{
                 $.ajax({
                    dataType: "json",
                    type: "POST",
                    data: {'sel': cveSolicitud,'opcion':6,'rol':rol},
                    url: 'herramientas/funciones/solicitud.php',
                    async: false,
                    success: function(datos){
                        if (datos.estatus == 1) {
                            $("#modal-header").html('').append('<button type="button" class="close" data-dismiss="modal">&times;</button><h4 class="modal-title">¡Asignaci&oacute;n a OIC correcta!</h4>');
                            $("#modal-body").html('').append('<p>La solicitud se asigno correctamente a OIC.</p>');
                            $("#modal-footer").html('').append('<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>');
                            $("#ModalGral").modal({backdrop: "static"});
                        }else{
                            $("#modal-header").html('').append('<button type="button" class="close" data-dismiss="modal">&times;</button><h4 class="modal-title" style="color:red;">¡Asignaci&oacute;n a OIC incorrecta!</h4>');
                            $("#modal-body").html('').append('<p>La solicitud no se asignao correctamente a OIC, por favor intente de nuevo.</p>');
                            $("#modal-footer").html('').append('<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>');
                            $("#ModalGral").modal({backdrop: "static"});
                            $("#ModalGral").modal("show");
                        }
                    },
                    statusCode: {
                        404: function() {
                            alert( "pagina no encontrada" );
                        }
                    }
                });
            }
           
        }
        $("#actualiza").click();
        return false; 
    });
    
    //--------------------------------------------------------------------------------------------------
    $("#concluir").on('click',function(){
        var sel = 0;
        var totalBien = 0;
        var rol = $('#rol').val();
        var tipo = $('#tipo').val();
        var cveSolicitud = $("#id_solicitud").val();
        //alert(cveSolicitud);
        if (cveSolicitud == undefined)
        {
            //alert("no definida");return false;
            $(".seleccionado").each(function(){
                if($(this).prop('checked')){
                        sel++;
                        var cve = $(this).attr('clave');
                        $.ajax({
                            dataType: "json",
                            type: "POST",
                            data: {'sel': cve,'opcion':7,'rol':rol,'tipo':tipo},
                            url: 'herramientas/funciones/solicitud.php',
                            async: false,
                            success: function(datos){
                                //alert(datos.estatus);
                                if (datos.estatus == 1) {
                                    totalBien++;
                                }
                            },
                            statusCode: {
                                404: function() {
                                  alert( "pagina no encontrada" );
                                }
                            }
                        });
                }
            });
            
            if (sel == 0) {
                $("#modal-header").html('').append('<button type="button" class="close" data-dismiss="modal">&times;</button><h4 class="modal-title" style="color:#577492;">¡Atenci&oacute;n!</h4>');
                $("#modal-body").html('').append('<p>Debe seleccionar al menos un elemento.</p>');
                $("#modal-footer").html('').append('<button type="button" class="btn btn-default" data-dismiss="modal">OK</button>');
                $("#ModalGral").modal({backdrop: "static"});
                $("#ModalGral").modal("show");
                return false;
            }
            if (totalBien == sel) {
                $("#modal-header").html('').append('<button type="button" class="close" data-dismiss="modal">&times;</button><h4 class="modal-title">¡Solicitud concluida(s)!</h4>');
                $("#modal-body").html('').append('<p>Se concluy&oacute; correctamente los elementos seleccionados.</p>');
                $("#modal-footer").html('').append('<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>');
                $("#ModalGral").modal({backdrop: "static"});
                //alert("Se concluy&oacute; correctamente los elementos seleccionados");
            }else{
                 $("#modal-header").html('').append('<button type="button" class="close" data-dismiss="modal">&times;</button><h4 class="modal-title" style="color:red;">¡Solicitud no concluida(s)!</h4>');
                $("#modal-body").html('').append('<p>No se concluyeron correctamente los elementos seleccionados, por favor intente de nuevo.</p>');
                $("#modal-footer").html('').append('<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>');
                $("#ModalGral").modal({backdrop: "static"});
                $("#ModalGral").modal("show");
                //alert("no concluyo correctamente todos los elementos seleccionados");
            }
            
        }else{
            $.ajax({
                dataType: "json",
                type: "POST",
                data: {'sel': cveSolicitud,'opcion':7,'rol':rol,'tipo':tipo},
                url: 'herramientas/funciones/solicitud.php',
                async: false,
                success: function(datos){
                    if (datos.estatus == 1) {
                        $("#modal-header").html('').append('<button type="button" class="close" data-dismiss="modal">&times;</button><h4 class="modal-title">¡Solicitud concluida(s)!</h4>');
                        $("#modal-body").html('').append('<p>La solicitud se concluy&oacute; correctamente.</p>');
                        $("#modal-footer").html('').append('<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>');
                        $("#ModalGral").modal({backdrop: "static"});
                    }else{
                        $("#modal-header").html('').append('<button type="button" class="close" data-dismiss="modal">&times;</button><h4 class="modal-title" style="color:red;">¡Solicitud no concluida!</h4>');
                        $("#modal-body").html('').append('<p>La solicitud no se concluy&oacute; correctamente, por favor intente de nuevo.</p>');
                        $("#modal-footer").html('').append('<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>');
                        $("#ModalGral").modal({backdrop: "static"});
                        $("#ModalGral").modal("show");
                    }
                },
                statusCode: {
                    404: function() {
                        alert( "pagina no encontrada" );
                    }
                }
            });
        }
        $("#actualiza").click();
        return false;  
    });
        
    //--------------------------------------------------------------------------------------------------
        $("#rechazar").on('click',function(){
        var sel = 0;
        var totalBien = 0;
        var rol = $('#rol').val();
        var tipo = $('#tipo').val();
        var cveSolicitud = $("#id_solicitud").val();
        //alert(cveSolicitud);
        if (cveSolicitud == undefined){
            $(".seleccionado").each(function(){
                    if($(this).prop('checked')){
                         sel++;
                         var cve = $(this).attr('clave');
                         $.ajax({
                             dataType: "json",
                             type: "POST",
                             data: {'sel': cve,'opcion':8,'rol':rol,'tipo':tipo},
                             url: 'herramientas/funciones/solicitud.php',
                             async: false,
                             success: function(datos){
                                 //alert(datos.estatus);
                                 if (datos.estatus == 1) {
                                     totalBien++;
                                 }
                             },
                             statusCode: {
                                 404: function() {
                                   alert( "pagina no encontrada" );
                                 }
                             }
                         });
                    }
            });
            if (sel == 0) {
                 $("#modal-header").html('').append('<button type="button" class="close" data-dismiss="modal">&times;</button><h4 class="modal-title" style="color:#577492;">¡Atenci&oacute;n!</h4>');
                 $("#modal-body").html('').append('<p>Debe seleccionar al menos un elemento.</p>');
                 $("#modal-footer").html('').append('<button type="button" class="btn btn-default" data-dismiss="modal">OK</button>');
                 $("#ModalGral").modal({backdrop: "static"});
                 $("#ModalGral").modal("show");
                 return false;
            }
            if (totalBien == sel) {
                 $("#modal-header").html('').append('<button type="button" class="close" data-dismiss="modal">&times;</button><h4 class="modal-title">¡Rechazo completo!</h4>');
                 $("#modal-body").html('').append('<p>Se rechazaron correctamente los elementos seleccionados.</p>');
                 $("#modal-footer").html('').append('<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>');
                 $("#ModalGral").modal({backdrop: "static"});
                // alert("Se rechazo correctamente los elementos seleccionados");
            }else{
                  $("#modal-header").html('').append('<button type="button" class="close" data-dismiss="modal">&times;</button><h4 class="modal-title" style="color:red;">¡Rechazo incompleto!</h4>');
                 $("#modal-body").html('').append('<p>No se rechazaron correctamente los elementos seleccionados, por favor intente de nuevo.</p>');
                 $("#modal-footer").html('').append('<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>');
                 $("#ModalGral").modal({backdrop: "static"});
                 $("#ModalGral").modal("show");
                 //alert("no rechazo correctamente todos los elementos seleccionados");
            }
        }else{
            $.ajax({
                dataType: "json",
                type: "POST",
                data: {'sel': cveSolicitud,'opcion':8,'rol':rol,'tipo':tipo},
                url: 'herramientas/funciones/solicitud.php',
                async: false,
                success: function(datos){
                    if (datos.estatus == 1) {
                        $("#modal-header").html('').append('<button type="button" class="close" data-dismiss="modal">&times;</button><h4 class="modal-title">¡Rechazo completo!</h4>');
                        $("#modal-body").html('').append('<p>La solicitud se rechaz&oacute; correctamente.</p>');
                        $("#modal-footer").html('').append('<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>');
                        $("#ModalGral").modal({backdrop: "static"});
                    }else{
                        $("#modal-header").html('').append('<button type="button" class="close" data-dismiss="modal">&times;</button><h4 class="modal-title" style="color:red;">¡Rechazo incompleto!</h4>');
                        $("#modal-body").html('').append('<p>La solicitud no se rechaz&oacute; correctamente, por favor intente de nuevo.</p>');
                        $("#modal-footer").html('').append('<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>');
                        $("#ModalGral").modal({backdrop: "static"});
                        $("#ModalGral").modal("show");
                    }
                },
                statusCode: {
                    404: function() {
                        alert( "pagina no encontrada" );
                    }
                }
            });    
        }
        $("#actualiza").click();
    });
    
    $(".ver").on('click',function(){
         var cual = $(this).attr("for");
         $("#pintaTabla").slideUp('slow',function(){
                $("#carga").show();
            }).delay(200).queue(function(){
            $("#pintaTabla").html('');
            
            var rol = $('#rol').val();
            var tipo = $('#tipo').val();
            $.ajax({
                dataType: "html",
                type: "POST",
                data: {'cual': cual,'opcion':9,'rol':rol,'tipo':tipo,'vista':1},
                url: 'herramientas/funciones/solicitud.php',
                async: false,
                success: function(datos){
                    $("#pintaTabla").html(datos);
                },
                statusCode: {
                    404: function() {
                        alert( "pagina no encontrada" );
                    }
                }
            });
            $("#carga").hide();
            $(this).dequeue(); 
            $("#pintaTabla").slideDown('slow'); 
        });
        //alert(cual);
    });
    
     $(".eliminar").on('click',function(){
            var cual = $(this).attr("for");
            $("#modal-header").html('').append('<button type="button" class="close" data-dismiss="modal">&times;</button><h4 class="modal-title" style="color:red;">¡Eliminar solicitud!</h4>');
            $("#modal-body").html('').append('<p>&iquest;Est&aacute; seguro de eliminar la solicitud, si lo hace, no podr&aacute; recuperar la informaci&oacute;n?</p>');
            $("#modal-footer").html('').append('Borrar la Solicitud: <button type="button" class="btn btn-default" data-dismiss="modal">NO</button><button type="button" id="sielimina" for="'+ cual +'" class="btn btn-danger" data-dismiss="modal">SI</button>');
            $("#ModalGral").modal({backdrop: "static"});
            $("#ModalGral").modal("show");
            
            $("#sielimina").on("click",function(){
                var cualsi = $(this).attr("for");
                //alert(cualsi);
                $("#pintaTabla").slideUp('slow',function(){
                    $("#carga").show();
                }).delay(200).queue(function(){
                    $("#pintaTabla").html('');
                           
                    var rol = $('#rol').val();
                    var tipo = $('#tipo').val();
                    $.ajax({
                        dataType: "json",
                        type: "POST",
                        data: {'sel': cualsi,'opcion':10,'rol':rol,'tipo':tipo},
                        url: 'herramientas/funciones/solicitud.php',
                        async: false,
                        success: function(datos){
                            if (datos.estatus == 1) {
                                $("#modal-header").html('').append('<button type="button" class="close" data-dismiss="modal">&times;</button><h4 class="modal-title">¡Solicitud eliminada!</h4>');
                                $("#modal-body").html('').append('<p>La solicitud se elimino correctamente.</p>');
                                $("#modal-footer").html('').append('<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>');
                                $("#ModalGral").modal({backdrop: "static"});
                            }else{
                                $("#modal-header").html('').append('<button type="button" class="close" data-dismiss="modal">&times;</button><h4 class="modal-title" style="color:red;">¡Solicitud no eliminada!</h4>');
                                $("#modal-body").html('').append('<p>La solicitud no se elimino correctamente, por favor intente de nuevo.</p>');
                                $("#modal-footer").html('').append('<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>');
                                $("#ModalGral").modal({backdrop: "static"});
                                $("#ModalGral").modal("show");
                            }
                        },
                        statusCode: {
                            404: function() {
                                alert( "pagina no encontrada" );
                            }
                        }
                    });
                    $("#carga").hide();
                    $(this).dequeue(); 
                    $("#pintaTabla").slideDown('slow'); 
                });
                $("#actualiza").click();
        
            });
           
     });
}

function desactivaSolicitud() {
    $("#qypForm :input").prop("disabled",true);
    $(".fileC").hide();
    $("#arriba, #abajo").prop("disabled",false);
}

function paginadorEv() {
    $(".btn-paginador").on("click",function(){
        var p = $(this).attr('pagina');
        var tipo = $('#tipo').val();
        var url = "herramientas/funciones/solicitud.php";
        var rol = $('#rol').val();
        var busca = $("#busquedaSol").val();
        if (busca != '') {
            var datos = {'rol':rol,'tipo':tipo,'opcion':3,'pag':p,'busca':busca};
        }else{
            var datos = {'rol':rol,'tipo':tipo,'opcion':3,'pag':p};
        }
        $("#pintaTabla").slideUp('slow',function(){
                $("#carga").show();
        }).delay(200).queue(function(){
            
            $.ajax({
                    dataType : "html",
                    type : 'POST',
                    url : url,
                    data : datos,
                    async:false,
                    success : function(datos){
                        $("#pintaTabla").html(datos);
                    }
            });
            var datos2 = {'rol':rol,'tipo':tipo,'opcion':5};
            $.ajax({
                    dataType : "html",
                    type : 'POST',
                    url : url,
                    data : datos2,
                    async:true,
                    success : function(datos){
                        $("#mBandeja").html(datos);
                        if (tipo == 1) {
                            $("#nuevas").addClass("list-group-item-success");
                            $("#asig_oic").removeClass("list-group-item-success");
                        }else if (tipo == 2) {
                            $("#asig_oic").addClass("list-group-item-success");
                            $("#nuevas").removeClass("list-group-item-success");
                        }
                    }
            });
            $("#carga").hide();
            $(this).dequeue(); //continúo con el siguiente ítem en la cola
            $("#pintaTabla").slideDown('slow'); 
        });
        return false;
    });
}

//----Busqueda---------------------------------------------------------------------------------------------------------------------------------------------


function busInicio() {

     $('#fecha_inicio_bdiv').datetimepicker({format: 'DD-MM-YYYY',maxDate: 'now', locale: 'es'});//defaultDate:'now'
    
    $("#fecha_inicio_b").on("click",function(e){
        e.preventDefault();
        $("#glyph_inicio_b").click();
     });
    
    $('#fecha_final_bdiv').datetimepicker({format: 'DD-MM-YYYY',maxDate: 'now',locale:'es'});
    
    $("#fecha_final_b").on("click",function(e){
        e.preventDefault();
        $("#glyph_fin_b").click();
    });
    
    $('#fecha_inicio_bdiv').on('dp.change',function(e){
        fechaMax = new Date(mostrarFecha(365,e.date));
        hoy = new Date();
        
        $('#fecha_final_bdiv').data("DateTimePicker").minDate(e.date);
        if (fechaMax <= hoy) {
             $('#fecha_final_bdiv').data("DateTimePicker").maxDate(fechaMax);
        }else{
            $('#fecha_final_bdiv').data("DateTimePicker").maxDate(hoy);
        }
    });
    
    
    
    buscarEventoBusca();
    $("#contInputBusqueda").hide();
    cargaListasBus();
    
    $('#estados_b').multiselect({
                maxHeight: 200,
                buttonWidth :  '100%',
                enableCaseInsensitiveFiltering: true,
                filterPlaceholder: 'B\u00FAscar...',
                buttonText: function(options, select) {
                       if (options.length === 0) {
                           return 'Seleccione una opci\u00F3n...';
                       }
                       else if (options.length > 10) {
                           return options.length + ' opciones seleccionadas';
                       }
                        else {
                            var labels = [];
                            options.each(function() {
                                if ($(this).attr('label') !== undefined) {
                                    labels.push($(this).attr('label'));
                                }
                                else {
                                    labels.push($(this).html());
                                }
                            });
                            return labels.join(', ') + '';
                        }
                },
    });
    
    $("#tipo_b").on('change',function(){
        $("#causa_b").val('').find("option").remove();
        $("#dependencia_b").val('').find("option").remove();
        var val = $(this).val();
        var url = "herramientas/funciones/combos.php?consulta=";
        if (val > 0) {
            llenaCombo(url+"8&tr="+val,"#causa_b");
            if (val == 1) {//queja
                 llenaCombo(url+"19","#dependencia_b");
            }else{
                 llenaCombo(url+"13","#dependencia_b");
            }
           
        }
    });
    
    $('#busSol').validate({
        errorElement: 'span',
        errorClass: 'error-message',
        rules:{
            fecha_inicio_b:{required:true},
            fecha_final_b:{required:true},
            folio_b:{number:true,min:1},
            busca:{busqueda:true}
        },
         messages:{
            fecha_inicio_b:{required:'Campo obligatorio *'},
            fecha_final_b:{required:'Campo obligatorio *'},
            folio_b:{number:'S&oacute;lo n&uacute;meros [0-9]',min:'Debe ser mayor a 1'}
        }
    });
    
    var obligatorio = 0;
    var cambio_obligatorio = 0;
    $("#folio_b").on('keyup',function(){
        //alert();
        if ($(this).val().length == 0) {
            obligatorio = 0;
        }else{
            obligatorio = 1;
        }
        if($(this).val() != ""){
            $('.sol_bus_obli').each(function(){$(this).rules("remove");$(this).removeClass("error-message");});
            $("#causa_b").val('').find("option").remove();
            $("#dependencia_b").val('').find("option").remove();
        }else{
            $('.sol_bus_obli').each(function(){
                $(this).rules( "add", {
                    required: true,
                    messages: {
                      required: 'Campo obligatorio *'
                    }
                 });    
            });
        }
        
        $('#busSol').valid();
        if (obligatorio == 0 && cambio_obligatorio == 1) {
            $('.sol_bus_obli').each(function(){
                $("label[for= "+ $(this).attr('id') +" ]").html($("label[for= "+ $(this).attr('id') +" ]").text().replace(':', '<span class="required-tag">*</span>'));    
            });
            $("#busSol .tecleofolio").prop("disabled",false);
            $('#estados_b').multiselect('enable');
            cambio_obligatorio = 0;
        }else if (obligatorio == 1 && cambio_obligatorio == 0) {
            $('option', $('#estados_b')).each(function(element) {
                $(this).removeAttr('selected').prop('selected', false);
            });
            $('.sol_bus_obli').each(function(){
                $("label[for= "+ $(this).attr('id') +" ]").html($("label[for= "+ $(this).attr('id') +" ]").text().replace('*:', ':'));   
            });
            $("#busSol .tecleofolio").val('').prop("disabled",true);
            $('#estados_b').multiselect('disable');
            cambio_obligatorio = 1;
        }
        $("#estados_b").multiselect("refresh");   
    });
    
    
    $("#buscar_b").on('click',function(){
        //alert("busca busca busca");
        $("#pag").val(1);
         $("#busca").val('');
        if ($('#busSol').valid()) {
            $("#contBusqueda").slideUp('slow',function(){
            $("#carga").show();
            }).delay(200).queue(function(){
                    $("#contBusqueda").html('');
                    $(this).attr('disabled',true);
                    var form = $("#busSol");
                    var datos = new FormData(document.getElementById("busSol"));
                    var tipo = form.attr("method");
                    var url = form.attr("action");
                    $.ajax({
                        dataType : "html",
                        type : tipo,
                        url : url,
                        data : datos,
                        cache : false,
                        contentType:false,
                        processData : false,
                        success : function(datos){
                            $("#contInputBusqueda").slideDown('slow');
                            $("#contBusqueda").html(datos);
                        }
                    });
                     $("#carga").hide();
                    $(this).dequeue(); //continúo con el siguiente ítem en la cola
                    $("#contBusqueda").slideDown('slow',function(){
                        $('html,body').animate({
                                    scrollTop: $("#contInputBusqueda").offset().top
                        }, 500);
                    });

            });
            
        }else{
            $("#modal-header").html('').append('<button type="button" class="close" data-dismiss="modal">&times;</button><h4 class="modal-title" style="color:#577492;">¡Atenci&oacute;n!</h4>');
            $("#modal-body").html('').append('<p>¡Verifique la informaci&oacute;n ingresada, a&uacute;n no es correcta!.</p>');
            $("#modal-footer").html('').append('<button type="button" class="btn btn-default" data-dismiss="modal">OK</button>');
            $("#ModalGral").modal({backdrop: "static"});
            $("#ModalGral").modal("show");
        }
                            
        return false;
    });
    
     $("#limpia_b").on('click',function(){
        $("#busSol")[0].reset();
        $("#folio_b").val('').keyup();
        $("#causa_b").val('').find("option").remove();
        $('option', $('#estados_b')).each(function(element) {
                $(this).removeAttr('selected').prop('selected', false);
        });
        $("#busSol .tecleofolio").val('').prop("disabled",false);
        $('#estados_b').multiselect('enable');
        $("#estados_b").multiselect("refresh");
        $("#contInputBusqueda").slideUp();
        $("#busca").val('');
        $("#contBusqueda").slideUp().html();
        $('.sol_bus_obli').each(function(){$(this).rules("remove");$(this).removeClass("error-message");});
        $('#busSol').valid();
        $('.sol_bus_obli').each(function(){
                $(this).rules( "add", {
                    required: true,
                    messages: {
                      required: 'Campo obligatorio *'
                    }
                 });    
        });
     
        
        
        return false;
     });
    
    
}
function paginadorEvBus() {
    
    $(".btn-paginador").on("click",function(){
        var p = $(this).attr('pagina');
        $("#pag").val(p);
        $("#contBusqueda").slideUp('slow',function(){
                $("#carga").show();
        }).delay(200).queue(function(){
            var form = $("#busSol");
            var datos = new FormData(document.getElementById("busSol"));
            var tipo = form.attr("method");
            var url = "herramientas/funciones/solicitud.php";
            $.ajax({
                    dataType : "html",
                    type : 'POST',
                    url : url,
                    data : datos,
                    cache : false,
                    contentType:false,
                    processData : false,
                    success : function(datos){
                        $("#contBusqueda").html(datos);
                    }
            });
            $("#carga").hide();
            $(this).dequeue(); //continúo con el siguiente ítem en la cola
            $("#contBusqueda").slideDown('slow',function(){
                $('html,body').animate({
                        scrollTop: $("#contInputBusqueda").offset().top
                }, 500);    
            }); 
        });
        return false;
    });
    
    $("#reporte_bus").on("click",function(){
        if($('#busSol').valid()){
            $(this).attr('disabled',true);
           $("#busSol").attr("action","herramientas/funciones/reportes.php");
           $("#busSol").attr("target","blank");
            $("#busSol").submit();
            $("#busSol").attr("target","");
            $("#busSol").attr("action","herramientas/funciones/solicitud.php");
            $(this).attr('disabled',false);

        }else{
            $("#modal-header").html('').append('<button type="button" class="close" data-dismiss="modal">&times;</button><h4 class="modal-title" style="color:#577492;">¡Atenci&oacute;n!</h4>');
            $("#modal-body").html('').append('<p>¡Verifique la informaci&oacute;n ingresada, a&uacute;n no es correcta!.</p>');
            $("#modal-footer").html('').append('<button type="button" class="btn btn-default" data-dismiss="modal">OK</button>');
            $("#ModalGral").modal({backdrop: "static"});
            $("#ModalGral").modal("show");
            $(this).attr('disabled',false);
            return false;
        }
    });
}

function cargaListasBus() {
    var url = "herramientas/funciones/combos.php?consulta=";
    llenaCombo(url+"3","#tipo_b");
    llenaCombo(url+"20","#estados_b",null);
    llenaCombo(url+"18","#estatus_b");
    llenaCombo(url+"4","#medio_recepcion_b");

}

function buscarEventoBusca() {
   $("#busca").on('keyup',function(){
        if($('#busSol').valid()){
            $("#pag").val(1);
            var form = $("#busSol");
            var datos = new FormData(document.getElementById("busSol"));
            var tipo = form.attr("method");
            var url = "herramientas/funciones/solicitud.php";
            $.ajax({
                    dataType : "html",
                    type : 'POST',
                    url : url,
                    data : datos,
                    cache : false,
                    contentType:false,
                    processData : false,
                    success : function(datos){
                        $("#contBusqueda").html(datos);
                    }
            });
        }
    });
}

function eventosBusquedaSolDatos() {
    $(".verSol").on("click", function(){
        
        $("#contBusqueda, #busSol, #contInputBusqueda,#titBus").slideUp("slow");
        var cual = $(this).attr("for");
        //alert(cual);return false;
        $("#pintaTablaDet").hide('slow',function(){
            //alert();
                $("#carga").show();
            }).delay(100).queue(function(){
            $("#pintaTablaDet").html('');

            $.ajax({
                dataType: "html",
                type: "POST",
                data: {'cual': cual,'opcion':9,'vista':3,'boton':1},
                url: 'herramientas/funciones/solicitud.php',
                async: false,
                success: function(datos){
                    $("#pintaTablaDet").html(datos);
                },
                statusCode: {
                    404: function() {
                        alert( "pagina no encontrada" );
                    }
                }
            });
            $("#carga").hide();
            $(this).dequeue(); 
            $("#pintaTablaDet").slideDown('slow',function(){
                $('html,body').animate({
                    scrollTop: $("#titulo_f").offset().top
                }, 500);     
            });
            $("#tipo_registro").off().prop("disabled",true);
        });
    });
    
    $(".modificar").on("click", function(){
         $("#contBusqueda, #busSol, #contInputBusqueda,#titBus").slideUp("slow");
        var cual = $(this).attr("for");
        $("#pintaTablaDet").hide('slow',function(){
                $("#carga").show();
            }).delay(100).queue(function(){
            $("#pintaTablaDet").html('');
            
            var rol = $('#rol').val();
            var tipo = $('#tipo').val();
            $.ajax({
                dataType: "html",
                type: "POST",
                data: {'cual': cual,'opcion':9,'rol':rol,'vista':2,'boton':2},
                url: 'herramientas/funciones/solicitud.php',
                async: false,
                success: function(datos){
                    $("#pintaTablaDet").html(datos);
                },
                statusCode: {
                    404: function() {
                        alert( "pagina no encontrada" );
                    }
                }
            });
            $("#carga").hide();
            $(this).dequeue(); 
            $("#pintaTablaDet").slideDown('slow',function(){
                $('html,body').animate({
                    scrollTop: $("#titulo_f").offset().top
            }, 500);     
            });
            $("#tipo_registro").off().prop("disabled",true);
        });
    });
    
    
    $(".eliminarSol").on('click',function(){
            var cual = $(this).attr("for");
            $("#modal-header").html('').append('<button type="button" class="close" data-dismiss="modal">&times;</button><h4 class="modal-title" style="color:red;">¡Eliminar solicitud!</h4>');
            $("#modal-body").html('').append('<p>&iquest;Est&aacute; seguro de eliminar la solicitud, si lo hace, no podr&aacute; recuperar la informaci&oacute;n?</p>');
            $("#modal-footer").html('').append('Borrar la Solicitud: <button type="button" class="btn btn-default" data-dismiss="modal">NO</button><button type="button" id="sielimina" for="'+ cual +'" class="btn btn-danger" data-dismiss="modal">SI</button>');
            $("#ModalGral").modal({backdrop: "static"});
            $("#ModalGral").modal("show");
            
            $("#sielimina").on("click",function(){
                var cualsi = $(this).attr("for");
                //alert(cualsi); return false;
                $("#pintaTablaDet").slideUp('slow',function(){
                    $("#carga").show();
                }).delay(200).queue(function(){
                    $("#pintaTablaDet").html('');
                           
                    $.ajax({
                        dataType: "json",
                        type: "POST",
                        data: {'sel': cualsi,'opcion':12},
                        url: 'herramientas/funciones/solicitud.php',
                        async: true,
                        success: function(datos){
                            if (datos.estatus == 1) {
                                $("#modal-header").html('').append('<button type="button" class="close" data-dismiss="modal">&times;</button><h4 class="modal-title">¡Solicitud eliminada!</h4>');
                                $("#modal-body").html('').append('<p>La solicitud se elimino correctamente.</p>');
                                $("#modal-footer").html('').append('<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>');
                                $("#ModalGral").modal({backdrop: "static"});
                            }else{
                                $("#modal-header").html('').append('<button type="button" class="close" data-dismiss="modal">&times;</button><h4 class="modal-title" style="color:red;">¡Solicitud no eliminada!</h4>');
                                $("#modal-body").html('').append('<p>La solicitud no se elimino correctamente, por favor intente de nuevo.</p>');
                                $("#modal-footer").html('').append('<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>');
                                $("#ModalGral").modal({backdrop: "static"});
                                $("#ModalGral").modal("show");
                            }
                        },
                        statusCode: {
                            404: function() {
                                alert( "pagina no encontrada" );
                            }
                        }
                    });
                    $("#carga").hide();
                    $(this).dequeue(); 
                    $("#pintaTablaDet").slideDown('slow'); 
                });
                $("#buscar_b").click();
        
            });
           
    });   
}

function botonesBusquedaDetalle() {
    $("#regresarBus").on("click",function(){
        
        if ($("#opcionEd").val() == 13) {
             $("#modal-header").html('').append('<button type="button" class="close" data-dismiss="modal">&times;</button><h4 class="modal-title" style="color:red;">¡Cancelar cambios!</h4>');
            $("#modal-body").html('').append('<p>&iquest;Est&aacute; seguro de regresar?, si lo hace sus cambios no ser&aacute;n aplicados</p>');
            $("#modal-footer").html('').append('Regresar: <button type="button" class="btn btn-default" data-dismiss="modal">NO</button><button type="button" id="siregresa" class="btn btn-danger" data-dismiss="modal">SI</button>');
            $("#ModalGral").modal({backdrop: "static"});
            $("#ModalGral").modal("show");
            
            $("#siregresa").on("click",function(){
                $("#contBusqueda, #busSol, #contInputBusqueda,#titBus").slideDown("slow",function(){
                    $('html,body').animate({
                            scrollTop: $("#titBus").offset().top
                    }, 500);    
                });
                $("#pintaTablaDet").slideUp("slow");
            });
        }else{
            $("#contBusqueda, #busSol, #contInputBusqueda,#titBus").slideDown("slow",function(){
                    $('html,body').animate({
                            scrollTop: $("#titBus").offset().top
                    }, 500);    
            });
            $("#pintaTablaDet").slideUp("slow");
        }
        
        return false;
    });

    $("#formSBedita").on("click",function(event){
        event.preventDefault();
        $('#justificacion_mod').rules( "add", {
            required:true,
            direccion: true,
            maxlength: 250,
            messages: {
                required: 'Campo obligatorio *',
                maxlength: 'M&aacute;ximo de caracteres alcanzado (250)'
            }
        });
        quitarValidacionTestigo();
        quitarValidacionInvolucrado();
         if($('#qypForm').valid()){
            var tipo = $("#tipo_registro").val();
            
            if (tipo == 1) {
                exesoQuejaNarracion();
                if ($("#totInvolucrados").val() <= 0) {
                    $("#modal-header").html('').append('<button type="button" class="close" data-dismiss="modal">&times;</button><h4 class="modal-title" style="color:#577492;">¡Atenci&oacute;n!</h4>');
                    $("#modal-body").html('').append('<p>¡Debe capturar al menos un involucrado!.</p>');
                    $("#modal-footer").html('').append('<button type="button" class="btn btn-default" data-dismiss="modal">OK</button>');
                    $("#ModalGral").modal({backdrop: "static"});
                    $("#ModalGral").modal("show");
                    validacionTestigo();
                    validacionInvolucrado();
                    return false;
                }else{
                    if ($('input:radio[name=testigos_servidor]:checked').val() == 1) {
                        if ($("#totTestigos").val() <= 0) {
                            $("#modal-header").html('').append('<button type="button" class="close" data-dismiss="modal">&times;</button><h4 class="modal-title" style="color:#577492;">¡Atenci&oacute;n!</h4>');
                            $("#modal-body").html('').append('<p>¡Debe capturar al menos un Testigo!.</p>');
                            $("#modal-footer").html('').append('<button type="button" class="btn btn-default" data-dismiss="modal">OK</button>');
                            $("#ModalGral").modal({backdrop: "static"});
                            $("#ModalGral").modal("show");
                            validacionTestigo();
                            validacionInvolucrado();
                            return false;
                        }else{
                            $("#opcionEd").val(13);
                            $("#tipo_registro").prop("disabled",false);
                            reemplazaSaltos();
                            $('#qypForm').submit();
                        }
                    }else{
                        $("#opcionEd").val(13);
                        $("#tipo_registro").prop("disabled",false);
                        reemplazaSaltos();
                        $('#qypForm').submit();
                    }
                }
            }else{
                    $("#opcionEd").val(13);
                    $("#tipo_registro").prop("disabled",false);
                    reemplazaSaltos();
                    $('#qypForm').submit();
            }
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
        $('#justificacion_mod').rules("remove");
        return false;
    });
    
    $("#abajo").on("click",function(){
       $("#detalleEstatus").slideDown("slow");
       $("#arriba").show();
       $(this).hide();
       $('html,body').animate({
                    scrollTop: $("#detalleEstatus").offset().top
        }, 500);
       return false; 
    });
    
    $("#arriba").on("click",function(){
       $("#detalleEstatus").slideUp("slow");
       $("#abajo").show();
       $(this).hide();
       return false; 
    });
    /*
    $('#justificacion_mod').rules( "add", {
        required:true,
        descriptiva: true,
        maxlength: 250,
        messages: {
            required: 'Campo obligatorio *',
            textocomun: 'S&oacute;lo letras y n&uacute;meros',
            maxlength: 'M&aacute;ximo de caracteres alcanzado (250)'
        }
    });
    */
    
}

function eventoModificarQP(mensaje,estatus,cual) {
   // window.parent.$("#qypForm").slideUp();
    window.parent.$("#modal-header").html("").append('<button type="button" class="close" data-dismiss="modal">&times;</button><h4 class="modal-title" style="color:#577492;">¡Atenci&oacute;n!</h4>');
    window.parent.$("#modal-body").html("").append("<p>" + mensaje +" </p>");
    window.parent.$("#modal-footer").html("").append('<button type="button" class="btn btn-default" data-dismiss="modal">OK</button>');
    window.parent.$("#ModalGral").modal({backdrop: "static"});
    window.parent.$("#ModalGral").modal("show");
    if(estatus == 1){
        window.parent.$("#contBusqueda, #busSol, #contInputBusqueda,#titBus").slideDown("slow",function(){
                    window.parent.$('html,body').animate({
                            scrollTop: window.parent.$("#titBus").offset().top
                    }, 500);    
            });
            window.parent.$("#pintaTablaDet").slideUp("slow");
        
        //window.parent.$("#qypForm").slideUp();
         /*   window.parent.$("#pintaTablaDet").slideUp('slow');
            window.parent.$("#carga").show();
            //window.parent.$("#pintaTablaDet").html('');
            
                $.ajax({
                    dataType: "html",
                    type: "POST",
                    data: {'cual': cual,'opcion':9,'vista':2,'boton':2},
                    url: 'solicitud.php',
                   // async: false,
                    success: function(datos){
                        window.parent.$("#pintaTablaDet").html(datos);
                        window.parent.$("#tipo_registro").prop("disabled",true);
                    },
                    error: function (xhr, ajaxOptions, thrownError) {
                        alert(xhr.status);
                        alert(thrownError);
                    }
                });  */
    }          
 /*   window.parent.$("#carga").hide();
    window.parent.$("#pintaTablaDet").slideDown('slow');
    window.parent.$("#tipo_registro").off().prop("disabled",true);
    window.parent.$("#formSBedita").attr('disabled',false);
    window.parent.$("#qypForm").slideDown();
    window.parent.$("#guardarqja, #guardapet").attr("disabled",false);
    window.parent.$('html,body').animate({
                    scrollTop:  window.parent.$("#titulo_f").offset().top
    }, 300);
    window.parent.$("#tipo_registro").off().prop("disabled",true);*/
}



//------------------------------------------------------------------Cambio estatus----------------------------------------------------------------------------------------

function busEstatus() {
     $('#cambioEst').validate({
        errorElement: 'span',
        errorClass: 'error-message',
        rules:{
            folio_es:{number:true,min:1,required:true},
        },
         messages:{
            folio_es:{number:'S&oacute;lo n&uacute;meros [0-9]',min:'Debe ser mayor a 1',required:"Ingrese un n&uacute;mero de folio"}
        }
    });
     
    $('#cambioEst').on("submit",function(event){
        event.preventDefault();
        if ($('#cambioEst').valid()) {
            var form = $("#cambioEst");
            var datosF = new FormData(document.getElementById("cambioEst"));
            var tipo = form.attr("method");
            var url = form.attr("action");
            $("#carga").show(); 
            $("#contEstatus").slideUp(function(){
                    $.ajax({
                        dataType : "html",
                        type : tipo,
                        url : url,
                        data : datosF,
                        cache : false,
                        contentType:false,
                        processData : false,
                        success : function(datos){
                            $("#contEstatus").html(datos).slideDown("slow");
                            $("#carga").slideUp();
                            $('html,body').animate({
                                scrollTop: $("#contEstatus").offset().top
                             }, 500);
                        }
                    });
            });
            
            
            return false; 
        }else{
            $("#modal-header").html('').append('<button type="button" class="close" data-dismiss="modal">&times;</button><h4 class="modal-title" style="color:#577492;">¡Atenci&oacute;n!</h4>');
            $("#modal-body").html('').append('<p>¡Debe ingresar un n&uacute;mero de folio valido!</p>');
            $("#modal-footer").html('').append('<button type="button" class="btn btn-default" data-dismiss="modal">OK</button>');
            $("#ModalGral").modal({backdrop: "static"});
            $("#ModalGral").modal("show");
        }
        return false; 
    });
}


function cambioEstatus() {
    $('input[name="estatus"]').on("click",function(){
        if ($('input[name="estatus"]').is(':checked')) {
            var cve = $(this).val();
            var inCve = $(this).attr('id');
            $('input[name="estatus"]').each(function(){
                //var cveEl = $(this).val();
                var inCveBarr = $(this).attr('id');
                //alert("pulsada "+ inCve + " validada " + inCveBarr);
                if (inCveBarr > inCve) {
                    $('#' + $(this).attr('for')).removeClass('list-group-item-danger list-group-item-success').addClass('list-group-item-warning');
                }else{
                    $('#' + $(this).attr('for')).removeClass('list-group-item-warning');
                }
            });
            
        } else {
            alert('no select');
        }
    });
    
    $("#cambiarEstatus").on("click",function(){
        var cual = $('input:radio[name=estatus]:checked').val();
        $("#modal-header").html('').append('<button type="button" class="close" data-dismiss="modal">&times;</button><h4 class="modal-title" style="color:red;">¡Modificar estatus!</h4>');
            $("#modal-body").html('').append('<p>&iquest;Est&aacute; seguro de cambiar el estatus a la solicitud, si lo hace, no podr&aacute; recuperar la informaci&oacute;n posterior al estatus seleccionado?</p>');
            $("#modal-footer").html('').append('Cambiar estatus: <button type="button" class="btn btn-default" data-dismiss="modal">NO</button><button type="button" id="sielimina" for="'+ cual +'" class="btn btn-danger" data-dismiss="modal">SI</button>');
            $("#ModalGral").modal({backdrop: "static"});
            $("#ModalGral").modal("show");
            
            $("#sielimina").on("click",function(){
                var cualestatus = $(this).attr("for");
                var folio_id = $('#folioEstCam').val();
                var sol_id = $('#solicitudId').val();
                
                //alert(cualsi);
                $("#contInfoEstDat").slideUp('slow',function(){
                    $("#carga").show();
                }).delay(200).queue(function(){
                    $("#contInfoEstDat").html('');
                           
                    $.ajax({
                        dataType: "json",
                        type: "POST",
                        data: {'estatus_base': cualestatus,'opcion':16,'folio_es':folio_id,'sol':sol_id},
                        url: 'herramientas/funciones/solicitud.php',
                        async: false,
                        success: function(datos){
                            if (datos.estatus == 1) {
                                $("#modal-header").html('').append('<button type="button" class="close" data-dismiss="modal">&times;</button><h4 class="modal-title">Estatus actualizado!</h4>');
                                $("#modal-body").html('').append('<p>Se actualizo el estatus de la solicitud correctamente.</p>');
                                $("#modal-footer").html('').append('<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>');
                                $("#ModalGral").modal({backdrop: "static"});
                            }else{
                                $("#modal-header").html('').append('<button type="button" class="close" data-dismiss="modal">&times;</button><h4 class="modal-title" style="color:red;">¡Estatus no actualizado!</h4>');
                                $("#modal-body").html('').append('<p>No se logro actualizar el estatus de la solicitud, por favor intente de nuevo</p>');
                                $("#modal-footer").html('').append('<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>');
                                $("#ModalGral").modal({backdrop: "static"});
                                $("#ModalGral").modal("show");
                            }
                        },
                        statusCode: {
                            404: function() {
                                alert( "pagina no encontrada" );
                            }
                        }
                    });
                    $("#carga").hide();
                    $(this).dequeue();
                    $('#buscar_es').click(); 
                    $("#contInfoEstDat").slideDown('slow'); 
                });
        
            });
        
    });
    
    $("#reiniciaSolicitud").on("click",function(){
        var cual = $(this).attr("for");
        //alert(cual); return false;
        $("#modal-header").html('').append('<button type="button" class="close" data-dismiss="modal">&times;</button><h4 class="modal-title" style="color:red;">¡Modificar estatus!</h4>');
            $("#modal-body").html('').append('<p>&iquest;Est&aacute; seguro de cambiar el estatus a la solicitud a Nueva?</p>');
            $("#modal-footer").html('').append('Cambiar estatus: <button type="button" class="btn btn-default" data-dismiss="modal">NO</button><button type="button" id="siresetea" for="'+ cual +'" class="btn btn-danger" data-dismiss="modal">SI</button>');
            $("#ModalGral").modal({backdrop: "static"});
            $("#ModalGral").modal("show");
            
            $("#siresetea").on("click",function(){
                var cualestatus = $(this).attr("for");
                var folio_id = $('#folioEstCam').val();
                var sol_id = $('#solicitudId').val();
                
                //alert(cualsi);
                $("#contInfoEstDat").slideUp('slow',function(){
                    $("#carga").show();
                }).delay(200).queue(function(){
                    $("#contInfoEstDat").html('');
                           
                    $.ajax({
                        dataType: "json",
                        type: "POST",
                        data: {'estatus_base': cualestatus,'opcion':16,'folio_es':folio_id,'sol':sol_id},
                        url: 'herramientas/funciones/solicitud.php',
                        async: false,
                        success: function(datos){
                            if (datos.estatus == 1) {
                                $("#modal-header").html('').append('<button type="button" class="close" data-dismiss="modal">&times;</button><h4 class="modal-title">Estatus actualizado!</h4>');
                                $("#modal-body").html('').append('<p>Se actualizo el estatus de la solicitud correctamente.</p>');
                                $("#modal-footer").html('').append('<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>');
                                $("#ModalGral").modal({backdrop: "static"});
                            }else{
                                $("#modal-header").html('').append('<button type="button" class="close" data-dismiss="modal">&times;</button><h4 class="modal-title" style="color:red;">¡Estatus no actualizado!</h4>');
                                $("#modal-body").html('').append('<p>No se logro actualizar el estatus de la solicitud, por favor intente de nuevo</p>');
                                $("#modal-footer").html('').append('<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>');
                                $("#ModalGral").modal({backdrop: "static"});
                                $("#ModalGral").modal("show");
                            }
                        },
                        statusCode: {
                            404: function() {
                                alert( "pagina no encontrada" );
                            }
                        }
                    });
                    $("#carga").hide();
                    $(this).dequeue();
                    $('#buscar_es').click(); 
                    $("#contInfoEstDat").slideDown('slow'); 
                });
        
            });
        
    });
 
}
// -------------------------------------------------------------------------------Reporte mensual--------------------------------------------------------------------------------------

function reporteMensual() {
    var url = "herramientas/funciones/combos.php?consulta=";
    llenaCombo(url+"20","#estados_re");
   
  $('#fecha_inicio_rediv').datetimepicker({format: 'DD-MM-YYYY',maxDate: 'now', locale: 'es'});//defaultDate:'now'
    
    $("#fecha_inicio_re").on("click",function(e){
        e.preventDefault();
        $("#glyph_inicio_re").click();
     });
    
     $('#fecha_final_rediv').datetimepicker({format: 'DD-MM-YYYY',maxDate: 'now',locale:'es'});
    
    $("#fecha_final_re").on("click",function(e){
        e.preventDefault();
        $("#glyph_final_re").click();
    });
    
    $('#fecha_inicio_rediv').on('dp.change',function(e){
        fechaMax = new Date(mostrarFecha(365,e.date));
        hoy = new Date();
        
        $('#fecha_final_rediv').data("DateTimePicker").minDate(e.date);
        if (fechaMax <= hoy) {
             $('#fecha_final_rediv').data("DateTimePicker").maxDate(fechaMax);
        }else{
            $('#fecha_final_rediv').data("DateTimePicker").maxDate(hoy);
        }
    });
  

  
    $('#repMen').validate({
        errorElement: 'span',
        errorClass: 'error-message',
        rules:{
            fecha_inicio_re:{required:true},
            fecha_final_re:{required:true},
        },
         messages:{
            fecha_inicio_re:{required:'Campo obligatorio *'},
            fecha_final_re:{required:'Campo obligatorio *'},
        }
    });
    
    $("#buscar_re").on('click',function(){
        //alert("busca busca busca");
        $("#EnlacePdf").hide();
        if ($('#repMen').valid()) {
            $("#BusMenMen").slideUp('slow',function(){
            $("#carga").show();
            
            }).delay(200).queue(function(){
                    $(this).attr('disabled',true);
                    //$("#").val($("#").val());
                    var form = $("#repMen");
                    var datos = new FormData(document.getElementById("repMen"));
                    //alert(datos.fecha_inicio_re);
                    var tipo = form.attr("method");
                    var url = form.attr("action");
                    $.ajax({
                        dataType : "html",
                        type : tipo,
                        url : url,
                        data : datos,
                        cache : false,
                        contentType:false,
                        processData : false,
                        success : function(datos){
                            $("#BusMenMen").html(datos).slideDown('slow');
                            $("#EnlacePdf").slideDown();
                        }
                    });
                     $("#carga").hide();
                    $(this).dequeue(); //continúo con el siguiente ítem en la cola

            });
            
        }else{
            $("#modal-header").html('').append('<button type="button" class="close" data-dismiss="modal">&times;</button><h4 class="modal-title" style="color:#577492;">¡Atenci&oacute;n!</h4>');
            $("#modal-body").html('').append('<p>¡Verifique la informaci&oacute;n ingresada, a&uacute;n no es correcta!.</p>');
            $("#modal-footer").html('').append('<button type="button" class="btn btn-default" data-dismiss="modal">OK</button>');
            $("#ModalGral").modal({backdrop: "static"});
            $("#ModalGral").modal("show");
        }
                           
        return false;
    });
    $("#EnlacePdf").on("click",function(){
        $("#repMen").attr("target","reporteFrameForm");
        $("#repMen").attr("action","herramientas/funciones/reportes.php");
        $("#repMen").submit();
        $("#repMen").attr("target","");
        $("#repMen").attr("action","herramientas/funciones/solicitud.php");
        return false;
    });
    
     $("#limpia_re").on('click',function(){

        $("#estados_re").val("");
        $("#BusMenMen").slideUp().html();
        $('#fecha_inicio_re').prop('value','');
        $('#fecha_final_re').prop('value','');
        return false;
     });
    
    
}


function reemplazaSaltos() {
    $(".conSaltos").each(function(){
        var texto = $(this).val();
        //alert(texto);
        if (texto.length > 0) {
            texto = texto.replace(/\n/g, "<br />");
            $(this).val(texto);
            $(this).rules("remove");
        }
        
    });
}
