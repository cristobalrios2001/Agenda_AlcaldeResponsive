<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <style>
        /* Estilos del encabezado */
        .header-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            text-align: center;
            width: 100%;
            /* Agrega otros estilos según sea necesario */
        }
    </style>
</head>
<body>
    <div class="header-container">
        <p style="font-weight: bold; font-size: 18px; margin-bottom: 5px;">ACTIVIDADES DEL DIA {{ $fechaFormateada }}</p>
    </div>
</body>
</html>
