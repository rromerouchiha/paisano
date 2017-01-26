agregarObli();
cargaListas();
//$(".chosen-select").chosen();


function cargaListas() {
    var url = 'herramientas/funciones/combos.php?consulta=';
    llenaCombo(url+'1','#tipo_atencion');
    llenaCombo(url+'2','#tema');
}