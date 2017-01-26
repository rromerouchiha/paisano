$(".contenido").animate({
     height: "show"
}, 1000);

 $('#formLogueo').validate({
        errorElement: 'span',
        errorClass: 'error-message',
        rules:{
          usuario:{usuario:true,minlength: 6,maxlength: 15,required:true},
          clave:{pas:true,minlength: 6,maxlength: 15,required: true},
           
        },
        messages:{
          usuario:{required:'Campo obligatorio *',minlength: 'M&iacute;nimo 6 caracteres',maxlength: 'M&aacute;ximo 15 caracteres'},
          clave:{required:'Campo obligatorio *',minlength: 'M&iacute;nimo 6 caracteres',maxlength: 'M&aacute;ximo 15 caracteres'},
        }
 });



$('#formLogueo').on('submit',function(){
        $('#men').html("");
        if($('#formLogueo').valid()){
            var u = $("#usuario").val();
            var c = $("#clave").val();
            var url = "herramientas/funciones/acceso.php";
            var method = "POST";
            datos = {'usu':u,'con':c};
            var accion = function(res){
                if (res.estado == 0) {
                    $('#men').html('<div class="alert alert-danger">'+res.mensaje+'</div>');
                }else{
                    window.location="index.php";
                }
            }
            ajax(url,method,'json',datos,false,accion);
        }
        return false;
    });
