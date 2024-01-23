<?php
/*
 * Copyright 2021 - Felipe angel cerda contreras 
 * felipeangelcerdacontreras@gmail.com
*/
$_SITE_PATH = $_SERVER["DOCUMENT_ROOT"] . "/" . explode("/", $_SERVER["PHP_SELF"])[1] . "/";
require_once($_SITE_PATH . "/app/controllers/mvc.controller.php");
require_once($_SITE_PATH . "/app/controllers/mvc.controller_default.php");
require_once($_SITE_PATH . "/app/controllers/mvc.controller_administrador.php");


$mvc = new mvc_controller();
$action = addslashes(filter_input(INPUT_GET, "action"));
session_start();
if ($action === "login") {
    $mvc->login();
} else if (strpos($action, "checador") !== false && $action != "ubicacion_checador") {
    $mvc->checador();
} else if (strpos($action, "comedor") !== false && $action != "nomina_comedor") {
    $mvc->comedor();
}  else {
    $mvc->ExisteSesion();

    $mvc_default = new mvc_controller_default();

    if ($action === "bienvenida") {// muestra el modulo de bienvenida
        $mvc_default->bienvenida();
    }else if ($action === "usuarios") {
        $mvc_admin = new mvc_controller_administrador();
        $mvc_admin->usuarios();
    }else if ($action === "horarios") {
        $mvc_default->horarios();
    }else if ($action === "asistencia") {
        $mvc_default->asistencia();
    }else if ($action === "clientes") {
        $mvc_default->clientes();
    }else if ($action === "cerrar_sesion") {
        $mvc->CerrarSesion();
    }else if ($action === "acceso_denegado") {
        $mvc->acceso_denegado();
    } else {
        $mvc->error_page();
    }
}
