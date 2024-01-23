<?php
/*
 * Copyright 2021 - Felipe angel cerda contreras 
 * felipeangelcerdacontreras@gmail.com
 */
session_start();

$_SITE_PATH = $_SERVER["DOCUMENT_ROOT"] . "/" . explode("/", $_SERVER["PHP_SELF"])[1] . "/";
require_once($_SITE_PATH . "/app/model/clientes.class.php");
require_once($_SITE_PATH . "/app/model/horarios.class.php");

$oClientes = new clientes(true, $_POST);
$oClientes->id = addslashes(filter_input(INPUT_POST, "id"));
$nombre = addslashes(filter_input(INPUT_POST, "nombre"));
$sesion = $_SESSION[$oClientes->NombreSesion];
$oClientes->Informacion();

if ($oClientes->id != "") {
    $oClientes1 = new clientes();
    $oClientes1->id = addslashes(filter_input(INPUT_POST, "id"));
}

?>
<script type="text/javascript">
    $("#token").val(localStorage.getItem("srnPc"));
    $('.id_token').attr('id', $("#token").val());
    $('.id_token').attr('name', $("#token").val());
    $('._status').attr('id', $("#token").val() + "_status");
    $('._texto').attr('id', $("#token").val() + "_texto");

    $(document).ready(function(e) {
        $("#nameModal").text("<?php echo $nombre ?> Cliente");
        $("#frmFormulario").ajaxForm({
            beforeSubmit: function(formData, jqForm, options) {},
            success: function(data) {
                var str = data;
                var datos0 = str.split("@")[0];
                var datos1 = str.split("@")[1];
                var datos2 = str.split("@")[2];
                if ((datos3 = str.split("@")[3]) === undefined) {
                    datos3 = "";
                } else {
                    datos3 = str.split("@")[3];
                }
                Alert(datos0, datos1 + "" + datos3, datos2);
                Listado();
                $("#myModal_1").modal("hide");
                $("#" + $("#token").val()).attr("src", "imagenes/finger.png");
                $("#fingerPrint").css("display", "none");
            }
        });
        $('#estado_civil').select2({
            width: '100%'
        });

        $('[data-toggle="tooltip"]').tooltip();

        $('#rowTab li').on('click', function() {
            console.log("hola");
            $('#rowTab li').removeClass('divTabs');
            $(this).addClass('divTabs');
        });
    });
</script>
<style>
    .divTabs {
        border-top-left-radius: 10px !important;
        border-top-right-radius: 10px !important;
        background-color: #36b9cc !important;
        
    }
</style>
<form id="frmFormulario" name="frmFormulario" action="app/views/default/modules/catalogos/clientes/m.clientes.procesa.php" enctype="multipart/form-data" method="post" target="_self" class="form-horizontal">
    <div>
        <div class="form-component-container">
            <div class="panel panel-default form component main">
                <div class="panel-heading">
                    <ul id="rowTab" class="nav nav-tabs">
                        <li class="active divTabs">
                            <a data-toggle="tab" class="btn btn-outline-info" href="#tab1">Datos del cliente</a>
                        </li>
                        <li class=" ">
                            <a data-toggle="tab" class="btn btn-outline-info " href="#tab2">Checador</a>
                        </li>

                        <li>
                            <a data-toggle="tab" class="btn btn-outline-info" href="#tab5">Datos particulares</a>
                        </li>
                        <li>
                            <a data-toggle="tab" class="btn btn-outline-info" href="#tab6">Datos bancarios</a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div id="tab1" class="tab-pane fade active show">
                            <div class="row">
                                <div class="col">
                                    <div class="form-group">
                                        <strong class="">Nombres:</strong>
                                        <div class="form-group">
                                            <input type="text" description="Ingrese el nombre" class="form-control obligado" aria-describedby="" id="nombres" required name="nombres" value="<?= ucwords(strtolower($oClientes->nombres)) ?>" />
                                        </div>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group">
                                        <strong class="">Apellido Paterno:</strong>
                                        <div class="form-group">
                                            <input type="text" description="Ingrese el apellido paterno " aria-describedby="" id="ape_paterno" required name="ape_paterno" value="<?= ucwords(strtolower($oClientes->ape_paterno)) ?>" class="form-control obligado" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <div class="form-group">
                                        <strong class="">Apellido Materno:</strong>
                                        <div class="form-group">
                                            <input type="text" description="Ingrese el apellido materno" aria-describedby="" id="ape_materno" required name="ape_materno" value="<?= ucwords(strtolower($oClientes->ape_materno)) ?>" class="form-control obligado" />
                                        </div>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group">
                                        <strong class="">Fecha Nacimiento:</strong>
                                        <div class="form-group">
                                            <input type="date" description="Seleccione la fecha de nacimiento" aria-describedby="" id="fecha_nacimiento" required name="fecha_nacimiento" value="<?= $oClientes->fecha_nacimiento ?>" class="form-control obligado" />
                                        </div>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group">
                                        <strong class="">Fecha Ingreso:</strong>
                                        <div class="form-group">
                                            <input type="date" description="Seleccione la fecha de ingreso" aria-describedby="" id="fecha_ingreso" required name="fecha_ingreso" value="<?= $oClientes->fecha_ingreso ?>" class="form-control obligado" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="tab2" class="tab-pane fade">
                            <div class="form-group">
                                <strong class="">Reloj checador:</strong>
                                <div class="form-group">
                                    <input type="text" description="Conecte el lector para leer el numero" aria-describedby="" id="checador" required name="checador" value="<?= $oClientes->checador ?>" class="form-control obligado" />
                                </div>
                            </div>
                        </div>

                        <div id="tab5" class="tab-pane fade">
                            <div class="form-group">
                                <strong class="">Dirección:</strong>
                                <div class="form-group">
                                    <input type="text" description="Ingrese la dirección" aria-describedby="" id="direccion" name="direccion" value="<?= $oClientes->direccion ?>" class="form-control obligado" data-toggle="tooltip" title="" data-original-title="Escribir la direccion completa" />
                                </div>
                            </div>
                        </div>
                        <div id="tab6" class="tab-pane fade">

                        </div>
                    </div>
                </div>
            </div>

            <input type="hidden" id="id" name="id" value="<?= $oClientes->id ?>" />
            <input type="hidden" id="user_id" name="user_id" value="<?= $sesion->id ?>">
            <input type="hidden" id="token" name="token" value="">
            <input type="hidden" id="accion" name="accion" value="GUARDAR" />
        </div>
</form>