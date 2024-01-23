<?php
/*
 * Copyright 2021 - Felipe angel cerda contreras 
 * felipeangelcerdacontreras@gmail.com
 */
session_start();

$_SITE_PATH = $_SERVER["DOCUMENT_ROOT"] . "/" . explode("/", $_SERVER["PHP_SELF"])[1] . "/";
require_once($_SITE_PATH . "/app/model/usuarios.class.php");

$oUsuarios = new Usuarios();
$oUsuarios->id = addslashes(filter_input(INPUT_POST, "id"));
$nombre = addslashes(filter_input(INPUT_POST, "nombre"));
$sesion = $_SESSION[$oUsuarios->NombreSesion];
$oUsuarios->Informacion();

$aPermisos = empty($oUsuarios->perfiles_id) ? array() : explode("@", $oUsuarios->perfiles_id);
?>
<script type="text/javascript">
    $(document).ready(function(e) {
        $("#nameModal").text("<?php echo $nombre ?> Usuario");
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
            }
        });
    });
</script>
<form id="frmFormulario" name="frmFormulario" action="app/views/default/modules/catalogos/usuarios/m.usuarios.procesa.php" enctype="multipart/form-data" method="post" target="_self" class="form-horizontal">
    <div>
        <div class="row">
            <div class="col">
                <div class="form-group">
                    <strong class="">Nombre:</strong>
                    <div class="form-group">
                        <input type="text" description="Ingrese el nombre" aria-describedby="" id="nombre_usuario" required name="nombre_usuario" value="<?= $oUsuarios->nombre_usuario ?>" class="form-control obligado" />
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="form-group">
                    <strong class="">Usuario:</strong>
                    <div class="form-group">
                        <input type="text" description="Ingrese el usuario" aria-describedby="" id="usuario" required name="usuario" value="<?= $oUsuarios->usuario ?>" class="form-control obligado" />
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div class="form-group">
                    <strong class="">Correo:</strong>
                    <div class="form-group">
                        <input type="text" description="Ingrese el correo" aria-describedby="" id="correo" required name="correo" value="<?= $oUsuarios->correo ?>" class="form-control obligado" />
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group">
            <strong class="">Permisos </strong>
            <div class="row">
                <div class="col">
                    <strong class="">Modulos </strong><br>
                    <input type="checkbox" name="perfiles_id[]" value="usuarios" <?php if ($oUsuarios->ExistePermiso("usuarios", $aPermisos) === true) echo "checked" ?>><strong> Usuarios</strong><br>
                    <input type="checkbox" name="perfiles_id[]" value="notificaciones" <?php if ($oUsuarios->ExistePermiso("notificaciones", $aPermisos) === true) echo "checked" ?>><strong> Notificaciones</strong><br>
                    <input type="checkbox" name="perfiles_id[]" value="clientes" <?php if ($oUsuarios->ExistePermiso("clientes", $aPermisos) === true) echo "checked" ?>><strong> Clientes</strong><br />
                    <input type="checkbox" name="perfiles_id[]" value="horarios" <?php if ($oUsuarios->ExistePermiso("horarios", $aPermisos) === true) echo "checked" ?>><strong> Horarios</strong><br />
                    <input type="checkbox" name="perfiles_id[]" value="asistencia" <?php if ($oUsuarios->ExistePermiso("asistencia", $aPermisos) === true) echo "checked" ?>><strong> Asistencia</strong><br />
                </div>
            </div>
        </div>
        <div class="form-group">
            <strong>Nivel del usuario</strong>
            <div class="form-group">
                <select id="nvl_usuario" description="Seleccione el nivel del usuario" class="form-control obligado" name="nvl_usuario">
                    <option value="">--SELECCIONE--</option>
                    <option value="1" <?php if ($oUsuarios->nvl_usuario == "1") echo "selected"; ?>>Administrador</option>
                    <option value="2" <?php if ($oUsuarios->nvl_usuario == "2") echo "selected"; ?>>Usuario</option>
                </select>
            </div>
        </div>
        <div class="form-group">
            <strong class="">Contraseña:</strong>
            <div class="form-group">
                <input type="text" description="Ingrese la contraseña" aria-describedby="" id="clave_usuario" required name="clave_usuario" value="" class="form-control" />
            </div>
        </div>
        <input type="hidden" id="id" name="id" value="<?= $oUsuarios->id ?>" />
        <input type="hidden" id="user_id" name="user_id" value="<?= $sesion->id ?>">
        <input type="hidden" id="accion" name="accion" value="GUARDAR" />
    </div>
</form>