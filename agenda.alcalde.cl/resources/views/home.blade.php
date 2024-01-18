@extends('layouts.app')


@section('content')
<div class="container-fluid">
    <div>
        @if(\Session::has('alert'))
            <div class="alert alert-danger">
                <p>{{\Session::get('alert')}}</p>
            </div>
            @php
                header('Refresh:2'); 
            @endphp
        @endif 

        @if(\Session::has('success'))
            <div class="alert alert-success">
                <p>{{\Session::get('success')}}</p>
            </div>
            @php
                header('Refresh:2'); 
            @endphp
        @endif  

        @if(\Session::has('edit'))
            <div class="alert alert-success">
                <p>{{\Session::get('edit')}}</p>
            </div>
            @php
                header('Refresh:2'); 
            @endphp
        @endif  

        @if(\Session::has('delete'))
            <div class="alert alert-success">
                <p>{{\Session::get('delete')}}</p>
            </div>
            @php
                header('Refresh:2'); 
            @endphp
        @endif 
    </div>

    <div>
        @php
            // Obtener todas las horas ocupadas
            $horasOcupadas = [];
            foreach ($agendas as $agenda) {
                $horasOcupadas[] = date('H:i', strtotime($agenda->hora));
            }

            // Obtener rango de horas posibles
            $horasPosibles = [];
            $horaInicio = strtotime('07:30');
            $horaFin = strtotime('22:30');
            $intervalo = 30 * 60; // Intervalo de 15 minutos

            for ($hora = $horaInicio; $hora <= $horaFin; $hora += $intervalo) {
                $horasPosibles[] = date('H:i', $hora);
            }
        @endphp
    </div>

    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header" id="nonPrintContent" style="display: block">
                <h3>Actividades del Dia <strong>
                    @foreach ($fechas as $fecha)
                     {{date('d-m-Y',strtotime($fecha->fecha))}} 
                    @endforeach
                </strong>
                </h3>
                </div>

                <div id="printContent" style="display: none;">
                    <div class="logo-container">
                        <img class="img-fluid" src="http://www.laserena.cl/img/logo-blanco.png" alt="Logo" style="filter: invert(100%);">
                    </div>
                    <h2>Agenda Alcalde: <strong>Roberto Jacob J.</strong></h2>
                    <h3>Actividades del Dia 
                        <strong>
                            @foreach ($fechas as $fecha)
                                {{ date('d-m-Y', strtotime($fecha->fecha)) }} 
                            @endforeach
                        </strong>
                    </h3>                    
                </div>
             
                <!--div id="areaImprimir" class="card-body"-->
                <div class="card-body">
                    
                    <div class="col-12 mb-3  d-print-none">
                        <div class="row">
                            <div class="col-md-2 col-4">
                                <div class="d-grid">
                                {{-- <a class="btn btn-success border-light" data-bs-toggle="modal" data-bs-target="#modal-create"> --}}
                                <a class="btn btn-success border-light" data-bs-toggle="modal" data-bs-target="#modal-create{{$fecha->fecha}}">
                                <span class="fas fa-plus-circle"></span>
                                </a>
                                </div>
                                 @include('modal.crear') 
                             </div>
                             <div class="col-md-2 col-4">
                                <div class="d-grid">
                                    <form action="{{ route('search') }}" method="post">
                                        @csrf
                                        <div class="input-group">
                                            <input type="date" name="frmactividad" class="form-control" value="{{$fecha->fecha}}" onkeydown=" return false">
                                            <button type="submit" class="btn btn-primary border-light">
                                                <span class="fas fa-search"></span>
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            {{-- <div class="col-md-2  col-4">
                                <div class="d-grid">
                                <a class="btn btn-primary border-light" data-bs-toggle="modal" data-bs-target="#modal-search">
                                <span class="fas fa-search"></span>
                                </a>
                                </div>
                                 @include('modal.search') 
                             </div> --}}
                             
                             <div class="col-md-2  col-4">
                                <div class="d-grid">
                                    <button class="printbutton btn btn-primary"><span class="fas fa-print"></span></button>
                                 </div>
                            
                             </div>

                        </div>
                       <hr>
                    </div>

                    <div> 
                        <img src="{{ asset('banner_superior_agenda/banner_superior_agenda.jpg') }}" width="100%" hidden="hidden" id="banner">
                        <h3 hidden="hidden" id="fechaActual">Actividades del Dia <strong>
                            @if (!Empty($fecha->fecha))
                            {{date('d-m-Y',strtotime($fecha->fecha))}} 
                                
                           @else
                            {{-- {{ now()->format('d-m-Y') }} --}}
                            {{ now()->format('d-m-Y') }}
                            @endif
                        </strong>
                    </div>

                    <div class="" id="nonPrintContent">

                        <div class="border text-center bg-dark text-light d-none d-md-block mb-1 d-print-block">
                            <div class="row">
                                <div class="col-2"><div class="text-uppercase">fecha</div></div>
                                <div class="col-1"><div class="text-uppercase">hora</div></div>
                                <div class="col"><div class="text-uppercase">descripción</div></div>
                                <div class="col-2 d-print-none"><div class="text-uppercase">acciones</div></div>
                            </div>
                        </div>

                        <!--PC-->
                        
                        
                        <div class=" d-print-block" id="printContent">
                            @foreach ($horasPosibles as $horaPosible)
                                <div class="border d-none d-md-block mb-1 d-print-block" >
                                    <div class="row align-items-center border-bottom">
                                        <div class="col-2">
                                            @if (!empty($fecha->fecha))
                                                <div class="text-uppercase text-center small pt-2 pb-2">{{ date('d-m-Y', strtotime($fecha->fecha)) }}</div>
                                            @else
                                                <div class="text-uppercase text-center small pt-2 pb-2">{{ now()->format('d-m-Y') }}</div>
                                            @endif
                                        </div>

                                        <div class="col-1">
                                            <div class="text-uppercase text-center small pt-2 pb-2">{{ $horaPosible }}</div>
                                        </div>

                                        <div class="col">
                                            <div class="text-uppercase small lh-1 text-start pt-2 pb-2">
                                                @php
                                                    $ocupada = false;
                                                    $descripcion = '';
                                                    if (in_array($horaPosible, $horasOcupadas)) {
                                                        $ocupada = true;
                                                        $descripcion = $agendas[array_search($horaPosible, $horasOcupadas)]->descripcion;
                                                    }
                                                @endphp
                                                @if ($ocupada)
                                                    {{ $descripcion }}
                                                @endif
                                            </div>
                                        </div>

                                        <div class="col-md-2 d-print-none">
                                            <div class="text-uppercase text-center pt-2 pb-2">
                                                @if ($ocupada)
                                                    <!-- Agrega aquí tus botones de acción según sea necesario -->
                                                    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modal-edit{{ $agendas[array_search($horaPosible, $horasOcupadas)]->id_agenda }}">
                                                        <i class="far fa-edit"></i>
                                                    </button> 
                                                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modal-delete{{ $agendas[array_search($horaPosible, $horasOcupadas)]->id_agenda }}">
                                                        <i class="far fa-trash-alt"></i>
                                                    </button>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>



                        
                        
                        <!--PC-->

                        <!--MOVIL-->
                             <div class="d-block d-md-none d-print-none card  mb-3 p-2">
                                <div class="row align-items-center ">
                                    <div class="col-6 pe-0">
                                        <div class="text-uppercase text-center fw-bold pt-1 pb-1 bg-dark text-light">{{date('d-m-Y',strtotime($agenda->fecha))}}</div>
                                    </div>

                                    <div class="col-6 ps-0">
                                        <div class="text-uppercase text-center fw-bold pt-1 pb-1 bg-secondary text-light">{{date('H:i',strtotime($agenda->hora))}}</div>
                                    </div>

                                    <div class="col-12">
                                        <div class="text-uppercase small lh-1 text-start pt-3 pb-3 mt-2 mb-2">{{$agenda->descripcion}}</div>
                                    </div>

                                    <div class="col-12">
                                        <div class="text-uppercase text-end pt-2 pb-2">
                                            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modal-edit{{$agenda->id_agenda}}" >
                                            <i class="far fa-edit"></i>
                                            </button> 
                                            <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modal-delete{{$agenda->id_agenda}}" >
                                            <i class="far fa-trash-alt"></i>
                                        </button>  
                                        </div>
                                    </div>
                                </div>
                            </div> 
                        
                            

                        <!--MOVIL-->                        


                        @include('modal/edit') 
                        @include('modal/delete') 
                        

                        
                                    
                    </div>

                    <div id="printContent">
    

                    <!--table id="" class="table table-striped mt-2">
                        <thead style="background-color:#990505;">
                            <th style="color:#0e0303;">Fecha</th>
                            <th style="color:#0e0303;">Hora</th>
                            <th style="color:#0e0303;">Descripcion</th>
                            <th style="color:#0e0303;">Acciones</th>
                            <th></th>
                        </thead>
                        
                        <tbody>
                           {{--@foreach ($agendas as $agenda)--}}
                           <tr>
                            <td>{{--date('d-m-Y',strtotime($agenda->fecha))--}}</td>
                            <td>{{--date('H:i',strtotime($agenda->hora))--}}</td>
                            <td>{{--$agenda->descripcion--}}</td>
                            
                            <td> <button type="button" class="btn btn-link" data-bs-toggle="modal" data-bs-target="#modal-edit{{--$agenda->id_agenda--}}" >
                                    <i class="far fa-edit"></i>
                                </button> 
                            </td>
                            <td>
                                <button type="button" class="btn btn-link" data-bs-toggle="modal" data-bs-target="#modal-delete{{--$agenda->id_agenda--}}" style="color: #990505;" >
                                    <i class="far fa-trash-alt"></i>
                                </button>  
                            </td>
                           </tr>
                           {{--@include('modal/edit') 
                           @include('modal/delete') 
                           @endforeach--}}
                        </tbody>
                    </table-->
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    @media print {
        #printContent {
            display: flex;
            align-items: center;
        }

        #printContent .logo-container {
            display: flex;
            justify-content: center; /* Cambiado de flex-end a center para centrar */
            align-items: center; /* Alineación vertical al centro */
            height: 65px; /* Altura del contenedor, ajusta según sea necesario */
            
           
        }

        #printContent .logo-container img {
            max-width: 85%;
            max-height: 85%;
            filter: invert(100%);
        }

        #printContent h2,
        #printContent h3 {
            
            font-size: 20px; /* Ajusta el tamaño de la letra según sea necesario */
            margin-left: 20px;
        }
    }
</style>



@endsection



@section('js')
<!-- JS -->
         <script src="https://code.jquery.com/jquery-3.5.1.js"></script> 
         <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>


         <script>
    document.querySelectorAll('.printbutton').forEach(function(element) {
        element.addEventListener('click', function() {
            // Cambia la visibilidad del contenido al imprimir
            document.getElementById('printContent').style.display = 'block';
            document.getElementById('nonPrintContent').style.display = 'none';

            // Lanza la función de impresión
            print();

            // Vuelve a la visibilidad original después de imprimir
            document.getElementById('printContent').style.display = 'none';
            document.getElementById('nonPrintContent').style.display = 'block';
        });
    });
</script>



         <!--script src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap5.min.js"></script-->
                                  
         <!--script>
                $(document).ready(function() {
              //  alert('hola');
                $('#agenda').DataTable({
            // "language": {
           // "url": "/dataTables/i18n/de_de.lang"
           // },
               language: {
               lengthMenu: 'Mostrar _MENU_ registros por pagina',
               zeroRecords: 'No se encontró nada - lo siento',
               info: 'Mostrando pagina _PAGE_ de _PAGES_',
               infoEmpty: 'No hay registros disponibles',
               infoFiltered: '(filtrado de _MAX_ resgistros totales)',
               loadingRecords: "Cargando...",
               paginate: {
               first: "Primero",
               last: "Último",
               next: "Siguiente",
               previous: "Anterior"                                    
               },
               search: "Buscar:",
               },
               });
               });
          </script--> 



<!--script>
    function printDiv(nombreDiv) {

    var buttonDivs = document.querySelectorAll(".col-2");
    buttonDivs.forEach(function(div) {
        div.style.display = "none";
    });

    
    document.getElementById("banner").removeAttribute("hidden");
    document.getElementById("fechaActual").removeAttribute("hidden");

    var tableColumns = document.querySelectorAll("table th");
    tableColumns.forEach(function(column) {
        if (column.textContent !== "Fecha" && column.textContent !== "Hora" && column.textContent !== "Descripcion") {
        column.style.display = "none";
        }
    });

    var tableRows = document.querySelectorAll("table tr");
    tableRows.forEach(function(row) {
        row.querySelectorAll("td .btn-link").forEach(function(button) {
        button.style.display = "none";
        });
    });

    var contenido= document.getElementById(nombreDiv).innerHTML;
    var contenidoOriginal= document.body.innerHTML;
    document.body.innerHTML = contenido;
    window.print();
    document.body.innerHTML = contenidoOriginal;

    

    setTimeout(function () {
        document.getElementById("banner").setAttribute("hidden", "hidden");
        document.getElementById("fechaActual").setAttribute("hidden", "hidden");
    }, 200);

    buttonDivs.forEach(function(div) {
        div.style.display = "";
    });

    

    setTimeout(function () {
        location.reload(window.location + 'administrador');
    }, 200);

     
}
</script-->

@endsection




