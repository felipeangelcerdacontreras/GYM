<?php
/*
 * Copyright 2021 - Felipe angel cerda contreras 
 * felipeangelcerdacontreras@gmail.com
 */
session_start();

$_SITE_PATH = $_SERVER["DOCUMENT_ROOT"] . "/" . explode("/", $_SERVER["PHP_SELF"])[1] . "/";
require_once($_SITE_PATH . "/app/model/asistencia.class.php");

$oAsistencia = new asistencia(true, $_POST);
$oAsistencia->id = addslashes(filter_input(INPUT_POST, "id"));
$nombre = addslashes(filter_input(INPUT_POST, "nombre"));
$lstasistencia = $oAsistencia->Listado_asistencia();
?>
<script type="text/javascript">
    $(document).ready(function() {
        $('#dataTable2').DataTable({
            "paging": false,
            dom: 'Brtip',
            buttons: [{
                extend: 'pdfHtml5',
                title: 'Reporte Asistencia del ' + $("#fecha_inicial").val() + ' al ' + $("#fecha_final").val(),
                text: 'Exportar a pdf',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5]
                }
            }]
        });
        $(".buttons-html5 ").addClass("btn btn-outline-info");
        $(".dt-buttons").attr("hidden", "hidden");
        $("#btn").button().click(function(e) {
            $(".buttons-pdf").trigger('click');
        });
    });
</script>
<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable2" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Nombre Empleado</th>
                        <th>Fecha</th>
                        <th>Hora entrada</th>
                        <th>Hora salida</th>
                        <th>Estatus</th>
                        <th>Dia</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (count($lstasistencia) > 0) {
                        foreach ($lstasistencia as $idx => $campo) {
                    ?>
                            <tr>
                                <td style="text-align: center;"><?= $campo->nombres . " " . $campo->ape_paterno . " " . $campo->ape_materno ?></td>
                                <td style="text-align: center;"><?php echo date_format(date_create($campo->fecha), 'd-m-Y') ?></td>
                                <td style="text-align: center;" <?php if ($campo->retraso == 'A tiempo') {
                                                                    echo "";
                                                                } else if ($campo->permiso == 'Permiso entrada'){
                                                                    echo "class='bg-warning'";
                                                                } else if ($campo->estatus_entrada == 1) {
                                                                    echo "";
                                                                } else {
                                                                    echo "class='btn-danger'";
                                                                } ?>><?php echo date("g:i A", strtotime($campo->hora_entrada)) ?></td>
                                <td style="text-align: center;"><?php if (!empty($campo->hora_salida) && $campo->estatus_salida > 0) echo (date("h:i:s A", strtotime($campo->hora_salida))); ?></td>
                                <td style="text-align: center;"><?= $campo->retraso == ''? $campo->permiso:$campo->retraso?></td>
                                <td style="text-align: center;"><?= $campo->dia ?></td>
                            </tr>
                    <?php
                        }
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>