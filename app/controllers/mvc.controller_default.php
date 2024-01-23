<?php

/*
 * Copyright 2021 - Felipe angel cerda contreras 
 * cerda@redzpot.com
 *  */
$_SITE_PATH = $_SERVER["DOCUMENT_ROOT"] . "/" . explode("/", $_SERVER["PHP_SELF"])[1] . "/";
require_once($_SITE_PATH . "/app/controllers/mvc.controller.php");
require_once($_SITE_PATH . "/app/model/principal.class.php");

class mvc_controller_default extends mvc_controller {

    public function __construct() {
        parent::__construct();
        /*
         * Constructor de la clase
         */
    }
    public function bienvenida() {
        include_once("app/views/default/modules/m.bienvenida.php");
    }
    //catalogos
   
    public function horarios () {
        include_once("app/views/default/modules/catalogos/horarios/m.horarios.buscar.php");
    }
    public function clientes () {
        include_once("app/views/default/modules/catalogos/clientes/m.clientes.buscar.php");
    }
    //modulos 
    public function asistencia () {
        include_once("app/views/default/modules/modulos/asistencia/m.asistencia.buscar.php");
    }
}
?>
