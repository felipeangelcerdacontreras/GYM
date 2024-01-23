<?php
/*
 * Copyright 2021 - Felipe angel cerda contreras 
 * felipeangelcerdacontreras@gmail.com
 */
$_SITE_PATH = $_SERVER["DOCUMENT_ROOT"] . "/" . explode("/", $_SERVER["PHP_SELF"])[1] . "/";
require_once($_SITE_PATH . "/app/model/principal.class.php");

class asistencia extends AW
{

    var $id;
    var $id_cliente;
    var $fecha;
    var $hora_entrada;
    var $hora_salida;
    var $estatus;
    var $dia;
    var $usr;

    //busqueda 
    var $fecha_inicial;
    var $fecha_final;

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
        $sql = "SELECT a.nombres, a.ape_paterno, a.ape_materno, count(dia)   as dia, id_cliente  FROM clientes as a 
        left join asistencia as b on a.id = b.id_cliente where 1=1 and fecha between '{$this->fecha_inicial}' and '{$this->fecha_final}' group by a.id";

        return $this->Query($sql);
    }

    public function Listado_asistencia()
    {
        $sqlcliente = "";
        if (!empty($this->id_cliente)) {
            $sqlcliente = " order by a.fecha asc";
        } else {
            $sqlcliente = "order by a.order desc limit 5";
        }

        $sql = "SELECT a.id,b.nombres, b.ape_paterno, b.ape_materno, a.fecha, a.hora_entrada,a.hora_salida,a.estatus_entrada,a.estatus_salida, 
            IF(a.dia = 0,'Domingo',
            IF(a.dia = 1,'Lunes',
            IF(a.dia = 2,'Martes',
            IF(a.dia = 3,'Miercoles',
            IF(a.dia = 4,'Jueves',
            IF(a.dia = 5,'Viernes',
            IF(a.dia = 6, 'Sabado', ''))))))) AS dia
            FROM asistencia as a 
            left join clientes as b on b.id = a.id_cliente
            where 1=1 and fecha between '{$this->fecha_inicial}' and '{$this->fecha_final}' {$sqlcliente} ";
        return $this->Query($sql);
    }

    public function Informacion()
    {

        $sql = "select * from asistencia where  id='{$this->id}'";
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

    public function Liquidar()
    {

        $sql = "update
                    asistencia
                set
                    estatus = '{$this->estatus}'
                where
                  id='{$this->id}'";
        return $this->NonQuery($sql);
    }

    public function Existe()
    {
        $sql1 = "select * from clientes where checador = '{$this->usr}' order by id desc limit 1";
        $res1 = $this->Query($sql1);

        $bExiste = false;
        if (count($res1) > 0) {
            $this->id_cliente = $res1[0]->id;

            $sql = "SELECT * FROM asistencia where fecha = '{$this->fecha_inicial}' and id_cliente = '{$this->id_cliente}' order by id desc limit 1";
            $res = $this->Query($sql);

            if (count($res) > 0) {
                $bExiste = true;
            }
        }
        return $bExiste;
    }

    public function Actualizar()
    {
        $now = date("Y-m-d");
        $now2 = date("Y-m-d H:i:s");

        $bResultado = 0;
        $sqlActualizar = "SELECT id FROM asistencia where fecha = '{$this->fecha_inicial}' and id_cliente = '{$this->id_cliente}'";
        $resActualizar = $this->Query($sqlActualizar);

        $this->id = $resActualizar[0]->id;

        $sql1 = "select * from clientes where checador = '{$this->usr}' order by id desc limit 1";
        $res1 = $this->Query($sql1);

        $this->id_cliente = $res1[0]->id;

            $sql = "{$this->id_cliente}|UPDATE `asistencia`
            SET
            `hora_salida` = '{$this->hora}',
            `order` = '{$now2}',
            `estatus_salida` = '3'
            WHERE `id` = '{$this->id}'";
            $this->NonQuery($sql, false);
            $bResultado = 2;
        

        return $bResultado;
    }

    public function Agregar()
    {
        $now = date("Y-m-d");
        $now2 = date("Y-m-d H:i:s");

        $bResultado = 0;
        $sql1 = "select * from clientes where checador = '{$this->usr}' order by id desc limit 1";
        $res1 = $this->Query($sql1);

        $this->id_cliente = $res1[0]->id;

     
        $sql = "{$this->id_cliente}|INSERT INTO 
                `asistencia` (`id_cliente`,`fecha`,`hora_entrada`,`dia`,`order`, `estatus_entrada`,`quitar_bonos`)
                VALUES
                ('{$this->id_cliente}','{$now}','{$this->hora}','{$this->diaActual}','{$now2}', '2','1')";
            $this->NonQuery($sql, false);

            $bResultado = 1;
        return $bResultado;
    }
    public function Existe_Sincronizar()
    {
        $sql = "SELECT * FROM asistencia where fecha = '{$this->fecha_}' and id_cliente = '{$this->id_cliente_}' order by id desc limit 1";
        $res = $this->Query($sql);
        $result = 0;
        if (count($res) > 0) {
            if ($this->update_ != "" && $this->update_ != null) {
                $this->update_ = str_replace("\'", "'", $this->update_);
                $update_new = explode("`id` =", $this->update_);
                $rs = $this->NonQuery($update_new[0] . "`id` = '{$res[0]->id}'");
                if ($rs) {
                    $result = 1;
                }
            }
        } else {
            $this->insert_ = str_replace("\'", "'", $this->insert_);
            $this->update_ = str_replace("\'", "'", $this->update_);

            $rs = $this->NonQuery($this->insert_);
            if ($rs > 0 && $this->update_ != "") {
                $sql = "SELECT * FROM asistencia where fecha = '{$this->fecha_}' and id_cliente = '{$this->id_cliente_}' order by id desc limit 1";
                $res = $this->Query($sql);
                if (count($res) > 0) {
                    $update_new = explode("`id` =", $this->update_);
                    $rs = $this->NonQuery($update_new[0] . "`id` = '{$res[0]->id}'");
                    if ($rs) {
                        $result = 1;
                    }
                }
            }
        }
        return $result;
    }

    public function AgregarAsis()
    {
        $sql = "SELECT * FROM asistencia where fecha = '{$this->fecha}' and id_cliente = '{$this->id_cliente}' order by id desc limit 1";
        $res = $this->Query($sql);

        $result = 0;
        if (count($res) > 0 && empty($this->hora_salida)) {
            $result = 1;
        } else {
            $sql = "INSERT INTO 
            `asistencia` (`id_cliente`,`fecha`,`hora_entrada`,`dia`, `estatus_entrada`,`quitar_bonos`)
            VALUES
            ('{$this->id_cliente}','{$this->fecha}','{$this->hora_entrada}','{$this->dia}', '{$this->AgregarAsis}','{$this->quitar_bonos}')";
            $rs = $this->NonQuery($this->sql);
            if ($rs && !empty($this->hora_salida)) {
                $sql = "UPDATE `asistencia`
               SET
               `hora_salida` = '{$this->hora_salida}',
               `estatus_salida` = '{$this->estatus_salida}',
               WHERE fecha = '{$this->fecha}' and id_cliente = '{$this->id_cliente}'";
                $rs = $this->NonQuery($this->sql);
            }
        }
        return $result;
    }
    
    function eliminar_simbolos($string){
 
        $string = trim($string);
     
        $string = str_replace(
            array("\'"),
            "'",
            $string
        );
    return $string;
    } 

    public function Guardar()
    {

        $sql1 = "select * from clientes where checador = '{$this->usr}' and estatus = '1' order by id desc limit 1";
        $res1 = $this->Query($sql1);

        $bRes = 0;
        if (count($res1) > 0) {
            $existe = $this->Existe();
            if ($existe) {
                $bRes = $this->Actualizar();
            } else {
                $bRes = $this->Agregar();
            }
        } else {
            $bRes = 3;
        }
        return $bRes;
    }
}
