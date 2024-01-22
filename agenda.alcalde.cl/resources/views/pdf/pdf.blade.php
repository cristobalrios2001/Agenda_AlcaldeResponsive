<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Document</title>

        <style>
            table {
                width: 100%;
                border-collapse: collapse;
                /* page-break-inside: avoid; */
            }

            th, td {
                border: 1px solid black;
                padding: 4px; /* Ajusta el relleno según tus preferencias */
                text-align: center;
            }
            th {
                background-color: black;
                color: white;
            }

            td:first-child {
                background-color: grey;
                color: white;
            }
            td.description {
                background-color: grey;
                color: white;
            }
            

            p {
                margin-left: auto;
                margin-right: auto;
                margin-top: 0px;
                margin-bottom: 10px;
            }

            #header {
                text-align: center; /* Centra el contenido horizontalmente */
                margin-bottom: 5px; /* Ajusta según sea necesario */
            }
            
            .mayus {
                text-transform: uppercase;
            }
            .header-container {
                display: flex;
                justify-content: space-between;
                align-items: center;
                text-align: center;
                width: 100%;
                page-break-inside: avoid;
            }

            .header-text {
                font-weight: bold;
                font-size: 18px;
                margin-bottom: 5px;
            }
            .date-text {
                font-size: 16px;
                float: right;
            }
        </style>
        
    </head>
    <body>

        <div id="header">
            <img src="banner_superior_agenda/banner_superior_agenda.jpg" width="722px" alt="">
            <?php
                $fechaOriginal = $fechas[0]->fecha;
                $fechaFormateada = date("d-m-Y", strtotime($fechaOriginal));
            ?>
            <p style="font-weight: bold; font-size: 18px; margin-bottom: 5px;">ACTIVIDADES DEL DIA    {{ $fechaFormateada }} </p>
        </div>
    
        
    
        <div class="">
        
            <table class="table">
                <thead>
                    <tr>
                        <th style="width: 10%;">Hora</th>
                        <th style="width: 90%;">Actividad</th>
                        
                    </tr>
                </thead>
                <tbody>
                    @foreach ($agendas as $agenda)
                        <tr>
                            <td>{{ date('H:i', strtotime($agenda->hora)) }}</td>
                            <td class="{{ $agenda->id_agenda != 0 ? 'description' : '' }}">
                                @if ($agenda->id_agenda != 0)
                                    {{ $agenda->descripcion }}
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </body>
</html>