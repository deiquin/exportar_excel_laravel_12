<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>

    <form action="/laravel12_reporte_excel/public/Subscription_reports/export/" method="get" id="formulario_reporte_excel">
        @csrf
        <div class="container">
            <div class="mt-5">
                <h3>Reporte de suscritos</h3>
            </div>
            <div class="mt-5 mb-5">
                <strong>fecha1:</strong> <input type="date" name="fecha1" id="fecha1" class="datepicker"> <br>
                <strong>fecha2:</strong> <input type="date" name="fecha2" id="fecha2" class="datepicker"><br>
            </div>


            <input type="submit" class="btn btn-success" value="Exportar a Excel">
        </div>

    </form>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    <script>
         $(document).ready(function() {
            function validarFechas(fechaInicio, fechaFin) {
                var fInicio = new Date(fechaInicio);
                var fFin = new Date(fechaFin);
                var respuesta = true;

                if (fInicio.getTime() > fFin.getTime()) {
                    respuesta = false;
                }
                return respuesta;
            }

            $('#formulario_reporte_excel').submit(function(e) {
                var fecha1 = $('#fecha1').val();
                var fecha2 = $('#fecha2').val();

                if (!validarFechas(fecha1, fecha2)) {
                    alert('La fecha de inicio no puede ser posterior a la fecha final.');
                    e.preventDefault();
                }
            });
        });
    </script>
    
</body>
</html>
