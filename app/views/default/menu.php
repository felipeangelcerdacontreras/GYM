<?php
$_SITE_PATH = $_SERVER["DOCUMENT_ROOT"] . "/" . explode("/", $_SERVER["PHP_SELF"])[1] . "/";
require_once($_SITE_PATH . "/Configuracion.class.php");
require_once($_SITE_PATH . "/app/model/usuarios.class.php");

$oConfig = new Configuracion();

$sesion = $_SESSION[$oConfig->NombreSesion];
//print_r($sesion);
$oUsuario = new usuarios();
$oUsuario->id = $sesion->id;
$oUsuario->Informacion();

$aPermisos = empty($oUsuario->perfiles_id) ? array() : explode("@", $oUsuario->perfiles_id);
?>
<script>
    $(document).ready(function(e) {
        $('#empleados').attr('href', "index.php?action=empleados&token=" + localStorage.getItem("srnPc"));
    });
</script>
<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-info sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php?action=bienvenida">
        <div class="sidebar-brand-icon rotate-n-15">
            <img src="app/views/default/img/icon.png" style="width: 116%;">
        </div>
        <div class="sidebar-brand-text mx-3"><sup></sup></div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <hr class="sidebar-divider">
    <!-- Heading -->

    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
            <i class="fas fa-fw fa-cog"></i>
            <span>Catalogós</span>
        </a>

        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <?php if ($oUsuario->ExistePermiso("usuarios", $aPermisos) === true) { ?>
                    <a class='collapse-item' href='index.php?action=usuarios'>Usuarios</a>
                <?php } ?>
                <?php if ($oUsuario->ExistePermiso("horarios", $aPermisos) === true) { ?>
                    <a class='collapse-item' href='index.php?action=horarios'>Horarios</a>
                <?php } ?>
                <?php if ($oUsuario->ExistePermiso("clientes", $aPermisos) === true) { ?>
                    <a class='collapse-item' href='index.php?action=clientes'>Clientes</a>
                <?php } ?>
            </div>
        </div>
    </li>
    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages" aria-expanded="true" aria-controls="collapsePages">
            <i class="fas fa-fw fa-folder"></i>
            <span>Modulos</span>
        </a>
        <div id="collapsePages" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
               
                <?php if ($oUsuario->ExistePermiso("asistencia", $aPermisos) === true) { ?>
                    <a class='collapse-item' href='index.php?action=asistencia'>Asistencia</a>
                <?php } ?>
            </div>
        </div>
    </li>
    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
<!-- End of Sidebar -->
<!-- ////////////////////////////////////////////////////////////////////////////////////////////menu lateral izquierdo-->