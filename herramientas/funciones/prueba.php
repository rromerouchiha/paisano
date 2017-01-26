<?php

echo '
<!DOCTYPE html>
<html>
<head></head>
<body>

<form role="form" action="herramientas/funciones/solicitud.php" id="repMen" method="POST">
            <input type="hidden" name="opcion" id="opcion" value="15"/>
            <div class="row">
                <div class="form-group col-md-4">
                    <label for="fecha_inicio_re" class="control-label">Fecha inicial<span class="required-tag">*</span>:</label>
                    <div class="input-group date" id="fecha_inicio_rediv">
                        <input type="text" class="form-control input-sm" id="fecha_inicio_re" name="fecha_inicio_re"/>
                        <span class="input-group-addon glyphicon glyphicon-calendar" id="glyph_inicio_re"></span>
                    </div>
                </div>
                <div class="form-group col-md-4">
                    <label for="fecha_final_re" class="control-label">Fecha de final<span class="required-tag">*</span>:</label>
                    <div class="input-group date" id="fecha_final_rediv">
                        <input type="text" class="form-control input-sm" id="fecha_final_re" name="fecha_final_re"/>
                        <span class="input-group-addon glyphicon glyphicon-calendar" id="glyph_final_re"></span>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-8"></div>
                <div class="form-group col-md-4">
                    <div class="pull-right">
                        <button name="limpia_re" id="limpia_re" class="btn btn-default"><span class="glyphicon glyphicon-share-alt"></span>&nbsp;Limpiar</button>
                        <button name="buscar_re" id="buscar_re" class="btn btn-primary"><span class="glyphicon glyphicon-search"></span>&nbsp;Buscar</button>
                    </div>
                </div>
            </div>
        </form>
        <div class="row"><div class="col-md-12" id="BusMenMen"></div></div>
        <div class="row">
            <div class="col-md-12" id="carga" style="display:none;"><center><img src="includes/img/loading.gif" style="width:100px;"/></center></div>
        </div>
        <!-- Modal -->
        <div class="modal fade" id="ModalGral" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header" id="modal-header"></div>
                    <div class="modal-body" id="modal-body"></div>
                    <div class="modal-footer" id="modal-footer"></div>
                </div>
            </div>
        </div>




<form role="form" name="reporteFrameForm" id="reporteFrameForm" action="reportes.php" target="idFrameRep" method="POST">
                                                <input type="text" name="finicio" value="sdas" />
                                                <input type="text" name="r" value="1" />
                                                <input type="text" name="ffin" value="asdas" />
                                                <input type="text" name="estados" value="asdasd" />
                                                <button name="EnlacePdf" id="EnlacePdf" class="btn btn btn-default"><img src="includes/img/pdf.png"  class="IMGicono"  style="width:20px;"> Generar</button>
                                                <input type="submit" value="enviar"/>
                                        </form>
                                        <iframe name="idFrameRep" id="idFrameRep"></iframe>
</body>
</html>



';
?>