

/*
$(".file").fileinput({
        language: 'es',
        showRemove: false,
        showUpload: false,
        allowedFileExtensions: ['pdf']
});
$(".fileimage").fileinput(
        {
                previewFileType: "image",
                browseClass: "btn btn-success",
                browseLabel: "Examinar",
                browseIcon: "<i class=\"glyphicon glyphicon-picture\"></i> ",
                language: 'es',
                showRemove: false,
                showUpload: false,
                allowedFileExtensions: ["jpg", "gif", "png"]    
        }
);
$('#fecha_recepciond').datetimepicker({format: 'DD-MM-YYYY',minDate: 'now',maxDate: 'now', locale: 'es',defaultDate:'now'});
$('#fecha_hechosd').datetimepicker({format: 'DD-MM-YYYY',locale:'es'});

$(".oculta").hide();
agregarObli();
cargaListas();

function cargaListas() {
    var url = "herramientas/funciones/combos.php?consulta=";
    llenaCombo(url+"3","#tipo_registro");
    llenaCombo(url+"4","#medio_recepcion");
    llenaCombo(url+"5","#pais_hechos, #pais_origen");
    llenaCombo(url+"9","#sexoq, #sexo_servidor");
    llenaCombo(url+"10","#tez_servidor");
    llenaCombo(url+"11","#complexion_servidor");
    llenaCombo(url+"12","#ojos_servidor");
    llenaCombo(url+"13","#dependencia_servidor, #dependencia_atencion");
}

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
                }else if (val == 3) {
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
                }else if (val == 3) {
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
        var val = $(this).val();
        var url = "herramientas/funciones/combos.php?consulta=";
        if (val > 0) {
            llenaCombo(url+"8&tr="+val,"#causa");
             quitarObli();
            if (val == 2) {
                $("#estado_hechos, #ciudad_hechos").find("option").remove(); 
                $(".queja").val("").removeClass("requerido").attr("disabled", true);

            }else{
                $("#fecha_hechos").addClass("requerido");
                $(".queja").attr("disabled", false);
                $('#identificaciones_causa').slideUp();
                $("#id_solicitante,#id_alocalizar").removeClass("requerido");
            }
            agregarObli();
        }else{
            $("#causa").val('').find("option").remove();  
        }
        
});

$('#causa').on('change',function(){
        quitarObli();
        if ($(this).val() == 15) {
                $('#identificaciones_causa').slideDown();
                $("#id_solicitante,#id_alocalizar").addClass("requerido");
        }else{
                $('#identificaciones_causa').slideUp();
                $("#id_solicitante,#id_alocalizar").removeClass("requerido");
        }
        agregarObli();
});

$("#anonimo").on('click',function(){
        quitarObli();
        if( $(this).prop('checked') ) {
                $(".anonimore").removeClass("requerido");
        }else{
                $(".anonimore").addClass("requerido");
        }
        agregarObli();
});

$('#siguienteqyp').on('click',function(){
        if(validaForm()){
                quitarObli();
               $("#quejaypeticion").slideUp();
               if ($("#tipo_registro").val() == 1) {
                   $('.qjare').addClass("requerido");                             
                   $("#queja").slideDown();
               }else{
                   $('.rpet').addClass("requerido");
                   $("#peticion").slideDown();  
               }
                agregarObli();
                $('html,body').animate({
                        scrollTop: $("#contP").offset().top
                }, 500);
        }
});

$('#regresar').on('click',function(){
         quitarObli();
         $('.qjare').removeClass("requerido");
        $("#queja").slideUp();
        $("#quejaypeticion").slideDown();
        agregarObli();
        $('html,body').animate({scrollTop: $("#contP").offset().top}, 500);
});

$('#regresar2').on('click',function(){
         quitarObli();
        $('.rpet').removeClass("requerido");
        $("#peticion").slideUp();
        $("#quejaypeticion").slideDown();
        agregarObli();
        $('html,body').animate({scrollTop: $("#contP").offset().top}, 500);
});

$("#limpiar2").on('click', function(){
        $('.pet').val('');
        $('#archivo_atencion').fileinput('reset');
        $("#siVehiculo").slideUp();
});
$("#limpiar").on('click', function(){
        $('.qja').val('');
        $('#pruebas_servidor').fileinput('reset')
});
   
$("input:radio[name=vehiculo_servidor]").on('click',function(){
        if( $('input:radio[name=vehiculo_servidor]:checked').val() == 1) {  
				$("#siVehiculo").slideDown();
		} else{  
				$("#siVehiculo").slideUp();
                $('.siveh').val(''); 
		} 
       
});
   /*
function valLat(campo) {
    if ($('#fcodigo').attr("value")!= '' && carLatinos($('#fcodigo').attr("value")) == null) {
        //code
    }
}
   */
