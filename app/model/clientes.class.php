<?php
/*
 * Copyright 2021 - Felipe angel cerda contreras 
 * felipeangelcerdacontreras@gmail.com
 */
$_SITE_PATH = $_SERVER["DOCUMENT_ROOT"] . "/" . explode("/", $_SERVER["PHP_SELF"])[1] . "/";
require_once($_SITE_PATH . "/app/model/principal.class.php");

class clientes extends AW
{

    var $id;
    var $nombres;
    var $ape_paterno;
    var $ape_materno;
    var $fecha_nacimiento;
    var $estatus;
    var $fecha_ingreso;

    var $usuario_edicion;
    var $fecha_modificacion;
    var $usuario_creacion;
   
    var $direccion;
    
    var $checador;
   
    var $user_id;
   

    public function __construct($sesion = true, $datos = NULL)
    {
        parent::__construct($sesion);

        if (!($datos == NULL)) {
            if (count($datos) > 0) {
                foreach ($datos as $idx => $valor) {
                    if (gettype($valor) === "array") {
                        $this->{$idx} = $valor;
                    } else {
                        $this->{$idx} = addslashes($valor);
                    }
                }
            }
        }
    }

    public function Listado()
    {   
        $sqlEstatus = "";
        if (!empty($this->estatus)) {
            $sqlEstatus = "Where estatus = '{$this->estatus}'";
        }

        $sql = "SELECT
            id,
            nombres,
            ape_paterno,
            ape_materno,
            fecha_ingreso,
        CASE
            WHEN estatus = 1 THEN
            'ACTIVO' 
            WHEN estatus = 0 THEN
            'BAJA' ELSE 'OTRO' 
        END AS estatus 
    FROM
        clientes  {$sqlEstatus}
    ORDER BY
        nombres ASC";
        return $this->Query($sql);
    }

    public function Informacion()
    {

        $sql = "select * from clientes where  id='{$this->id}'";
        $res = parent::Query($sql);

        if (!empty($res) && !($res === NULL)) {
            foreach ($res[0] as $idx => $valor) {
                $this->{$idx} = $valor;
            }
        } else {
            $res = NULL;
        }
        return $res;
    }



    public function Existe()
    {
        $sql = "select id from clientes where id='{$this->id}'";
        $res = $this->Query($sql);

        $bExiste = false;

        if (count($res) > 0) {
            $bExiste = true;
        }
        return $bExiste;
    }

    public function Desactivar() {

        $sql = "UPDATE `clientes`
        SET
        `estatus` = '{$this->estatus}'
        WHERE `id` = '{$this->id}';
        ";
                 // echo nl2br($sql);
        return $this->NonQuery($sql);
    }

    public function Actualizar()
    {

        $sql = "update
                    clientes
                set
                nombres ='{$this->nombres}',
                ape_paterno = '{$this->ape_paterno}',
                ape_materno = '{$this->ape_materno}',
                fecha_nacimiento =  '{$this->fecha_nacimiento}',
                fecha_ingreso = '{$this->fecha_ingreso}',
                direccion   = '{$this->direccion}',
                checador = '{$this->checador}',
                usuario_edicion = '{$this->user_id}'
                where
                  id='{$this->id}'";
        $result = $this->NonQuery($sql);

        return $result;
    }

    public function Agregar()
    {

        $sql = "insert into clientes
                (id,nombres, ape_paterno,ape_materno, fecha_nacimiento, direccion, fecha_ingreso, checador,
                usuario_creacion, estatus)
                values
                ('0','".ucwords(strtolower($this->nombres))."', '".ucwords(strtolower($this->ape_paterno))."', '".ucwords(strtolower($this->ape_materno))."','" . $this->fecha_nacimiento . "',
                 '".ucwords(strtolower($this->direccion))."', '{$this->fecha_ingreso}',
                 '{$this->checador}','{$this->user_id}','1')";
        $bResultado = $this->NonQuery($sql);

        $sql1 = "select id from clientes order by id desc limit 1";
        $res = $this->Query($sql1);

        $this->id = $res[0]->id;

        return $bResultado;
    }

    public function Guardar()
    {

        $bRes = false;
        if ($this->Existe() === true) {
            $bRes = $this->Actualizar();
        } else {
            $bRes = $this->Agregar();
        }

        return $bRes;
    }
}
