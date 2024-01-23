<?php
/*
 * Copyright 2021 - Felipe angel cerda contreras 
 * felipeangelcerdacontreras@gmail.com
*/
session_start();

$_SITE_PATH = $_SERVER["DOCUMENT_ROOT"] . "/" . explode("/", $_SERVER["PHP_SELF"])[1] . "/";
require_once($_SITE_PATH . "/app/model/clientes.class.php");
//require_once($_SITE_PATH . "app/model/PHPExcel/PHPExcel.php");

$accion = addslashes(filter_input(INPUT_POST, "accion"));


if ($accion == "GUARDAR") {
    $oClientes = new clientes(true, $_POST);
    if ($oClientes->Guardar() === true) {
        echo "Sistema@Se ha registrado exitosamente la información. @success";
    } else {
        echo "Sistema@Ha ocurrido un error al guardar la información , vuelva a intentarlo o consulte con el administrador del sistema.@warning";
    }
}    else if ($accion == "Desactivar"){
    $oClientes = new clientes(true, $_POST);

    if ($oClientes->Desactivar() === true) {
        echo "Sistema@Se ha registrado exitosamente la información. @success";
    } else {
        echo "Sistema@Ha ocurrido un error al guardar la información , vuelva a intentarlo o consulte con el administrador del sistema.@warning";
    }
} else if ($accion == 'ActivarSensor'){
    $oClientes = new clientes(true, $_POST);
    $resultado = $oClientes->ActivarSensor();
        print_r($resultado);
        //echo json_encode("{\"filas\":{$valor}");
} else if ($accion == 'carga_push'){
    $oClientes = new clientes(true, $_POST);
    $resultado = $oClientes->CargaPush();
        print_r($resultado);
        //echo json_encode("{\"filas\":{$valor}");
}
?>
