<?php
$_SITE_PATH = $_SERVER["DOCUMENT_ROOT"] . "/" . explode("/", $_SERVER["PHP_SELF"])[1] . "/";

?>
<!DOCTYPE html>
<html lang="en">
<?php require_once('app/views/default/link.html'); ?>

<head>
    <title>Renova</title>
    <meta http-equiv="refresh" content="600">

    <?php require_once('app/views/default/head.html'); ?>
    <?php require_once('app/views/default/script_h.html'); ?>
    <script>
    </script>
    <script type="text/javascript">
       
        $(document).ready(function(e) {
            $("#token").val('<?php echo $_GET["token"]; ?>');
            $("#id").val('');
            $("#usr").val('');
            Listado();
            //$("#usr").focus();
            $("#usr").change(function() {
                var value = $("#usr").val();
                $("#id").val(value);
            });
            $("#usr").keyup(function(event) {
                var tecla = event.keyCode;
                if (tecla == 13) {
                    Guardar();
                    //$("#frmFormulario").submit();
                }
            });
        });

        function Guardar() {
            $('#frmFormulario').submit(function(e) {
                e.preventDefault();
                $.ajax({
                    type: "POST",
                    url: $(this).attr('action'),
                    data: "usr=" + $("#id").val(),
                    success: function(response) {
                        console.log(response);
                        var str = response;
                        var datos0 = str.split("@")[0];
                        var datos1 = str.split("@")[1];
                        var datos2 = str.split("@")[2];
                        if ((datos3 = str.split("@")[3]) === undefined) {
                            datos3 = "";
                        } else {
                            datos3 = str.split("@")[3];
                        }
                        Alert(datos0, datos1 + "" + datos3, datos2, 1100, false);
                        Listado();
                        $("#usr").val("");
                        $("#usr").focus();
                    }
                });
            });
        }

        function Listado() {
            $("#id").val('');
            $("#usr").val('');
            var jsonDatos = {};
            $.ajax({
                data: jsonDatos,
                type: "POST",
                url: "app/views/default/modules/checador/checador.listado.php",
                beforeSend: function() {
                    $("#divListado").html(
                        '<div class="container"><center><img src="app/views/default/img/loading.gif" border="0"/><br />Leyendo información de la Base de Datos, espere un momento por favor...</center></div>'
                    );
                },
                success: function(datos) {
                    $("#divListado").html(datos);
                }
            });
            //$("#id").focus();
        }
       

        function mueveReloj() {
            var today = new Date();
            var hr = today.getHours();
            var min = today.getMinutes();
            var sec = today.getSeconds();
            $("#hora").val(checkTime(hr) + ":" + checkTime(min) + ":" + checkTime(sec));
            ap = (hr < 12) ? "AM" : "PM";
            hr = (hr == 0) ? 12 : hr;
            hr = (hr > 12) ? hr - 12 : hr;
            //Add a zero in front of numbers<10
            hr = checkTime(hr);
            min = checkTime(min);
            sec = checkTime(sec);

            var months = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
            var days = ['Dom', 'Lun', 'Mar', 'Mie', 'Jue', 'Vie', 'Sab'];
            var curWeekDay = days[today.getDay()];
            var curDay = today.getDate();
            var curMonth = months[today.getMonth()];
            var curYear = today.getFullYear();
            var date = curWeekDay + ", " + curDay + " " + curMonth + " " + curYear;
            $("#diaActual").val(today.getDay());

            $("#horalocal").text(date + " " + hr + ":" + min + ":" + sec + " " + ap);

            setTimeout("mueveReloj()", 1000)
        }

        function checkTime(i) {
            if (i < 10) {
                i = "0" + i;
            }
            return i;
        }
    </script>

<body class="bg-gradient-info" onload="mueveReloj()">

    <div class="container">
        <!-- Outer Row -->
        <div class="row justify-content-center">
            <div class="col-xl-10 col-lg-5 col-md-9">
                <label class="control-label" id="lat"></label>
                <label class="control-label" id="lon"></label>
                <label class="control-label" id="distancia"></label>
                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="p-5">
                                    <form class="user" id="frmFormulario" name="frmFormulario" action="app\views\default\modules\checador\m.checador_procesa.php" enctype="multipart/form-data" method="post" target="_self" class="">
                                        <div class="form-group" id="inputChecador">
                                            <h1 id="horalocal" class="text-center"></h1>
                                            <input type="text" class="form-control form-control-user" aria-describedby="emailHelp" autocomplete="off" id="usr" placeholder="" required="required">
                                        </div>
                                        <input type="hidden" name="accion" value="CHECAR">
                                        <input type="hidden" name="usr" id="id" value="">
                                        <input type="hidden" name="fecha_inicial" id="fecha_" value="<?= date('Y-m-d') ?>">
                                        <input type="hidden" name="fecha_final" value="<?= date('Y-m-d') ?>">
                                        <input type="hidden" name="hora" id="hora" value="">
                                        <input type="hidden" name="diaActual" id="diaActual" value="">
                                        <input type="hidden" name="" id="token" value="">
                                    </form>
                                </div>
                                <div id="divListado"></div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="navbar-default navbar-fixed-bottom">
            <div class="text-center footer" style="color:#000;">Copyright © <script>
                    document.write(new Date().getFullYear());
                </script> Angel Contreras. All Right Reserved.</div>
        </div>
    </div>
    <?php require_once('app/views/default/script_f.html'); ?>
</body>

</html>