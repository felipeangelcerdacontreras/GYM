<?php
/*
 * Copyright 2021 - Felipe angel cerda contreras 
 * felipeangelcerdacontreras@gmail.com
 */
session_start();

$_SITE_PATH = $_SERVER["DOCUMENT_ROOT"] . "/" . explode("/", $_SERVER["PHP_SELF"])[1] . "/";
require_once($_SITE_PATH . "/app/model/clientes.class.php");

$oClientes = new clientes();
$lstclientes = $oClientes->Listado();
?>
<script type="text/javascript">
    $(document).ready(function(e) {
        $("#dataTable").DataTable();

        $("#btnAgregar").button().click(function(e) {
            Editar("", "Agregar");
        });

    });
</script>
<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3" style="text-align:left">
        <h5 class="m-0 font-weight-bold text-info">clientes</h5>
        <div class="form-group" style="text-align:right">
            <input type="button" id="btnAgregar" class="btn btn-outline-info" name="btnAgregar" value="Agregar nuevo" />
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Fecha Ingreso</th>
                        <th>Estatus</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tfoot>
                    <th>Nombre</th>
                    <th>Fecha Ingreso</th>
                    <th>Estatus</th>
                    <th>Acciones</th>
                </tfoot>
                <tbody>
                    <?php
                    if (count($lstclientes) > 0) {
                        foreach ($lstclientes as $idx => $campo) {
                    ?>
                            <tr>
                                <td style="text-align: center;"><?= ucwords(strtolower($campo->ape_paterno . " " . $campo->ape_materno . " " . $campo->nombres)) ?></td>
                                <td style="text-align: center;"><?= $campo->fecha_ingreso ?></td>
                                <td style="text-align: center;"><?= $campo->estatus ?></td>
                                <td style="text-align: center;">
                                    <a class="btn btn-outline-sm btn-warning" href="javascript:Editar('<?= $campo->id ?>','Editar')">Editar</a>
                                    <?php if ($campo->estatus == "ACTIVO") { ?>
                                        <a class="btn btn-outline-sm btn-secondary" href="javascript:Editar('<?= $campo->id ?>','Desactivar')">Desactivar</a>
                                    <?php } else { ?>
                                        <a class="btn btn-outline-sm btn-success" href="javascript:Editar('<?= $campo->id ?>','Activar')">Activar</a>
                                    <?php } ?>
                                </td>
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