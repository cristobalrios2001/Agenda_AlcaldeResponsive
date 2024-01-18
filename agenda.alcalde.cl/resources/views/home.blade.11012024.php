@extends('layouts.app')


@section('content')
<div class="container-fluid">
    <div>
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

    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                <h3>Actividades del Dia <strong>
                    @foreach ($fechas as $fecha)
                     {{date('d-m-Y',strtotime($fecha->fecha))}} 
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
                                <a class="btn btn-success border-light" data-bs-toggle="modal" data-bs-target="#modal-create">
                                <span class="fas fa-plus-circle"></span>
                                
                                </a>
                                </div>
                                 @include('modal.crear') 
                             </div>
                            <div class="col-md-2  col-4">
                                <div class="d-grid">
                                <a class="btn btn-primary border-light" data-bs-toggle="modal" data-bs-target="#modal-search">
                                <span class="fas fa-search"></span>
                                </a>
                                </div>
                                 @include('modal.search') 
                             </div>
                             
                             <div class="col-md-2  col-4">
                                {{-- <div class="">
                                <a class="btn btn-danger border-light" onclick="imprimir('areaImprimir')">
                                <span class="fas fa-print"></span>
                                
                                </a>
                                </div> --}}
                                <div class="d-grid">
                                    <button class="printbutton btn btn-primary"><span class="fas fa-print"></span></button>
                                   <!--input type="button" value="Imprimir" onclick="javascript:window.print()" /-->
                                <!--button class="btn btn-danger" onclick="printDiv('areaImprimir')">
                                    <span class="fas fa-print"></span>
                                </button-->
                                 </div>
                            
                             </div>

                        </div>
                       <hr>
                    </div>




                    <div> 
                        <img src="{{ asset('banner_superior_agenda/banner_superior_agenda.jpg') }}" width="100%" hidden="hidden" id="banner">
                        <h3 hidden="hidden" id="fechaActual">Actividades del Dia <strong>
                            {{-- {{ now()->format('d-m-Y') }} --}}
                            {{date('d-m-Y',strtotime($fecha->fecha))}} 
                        </strong>
                    </div>

                    <div class="">

                     <div class="border text-center bg-dark text-light d-none d-md-block mb-1 d-print-block">
                        <div class="row">
                            <div class="col-2"><div class="text-uppercase">fecha</div></div>
                            <div class="col-1"><div class="text-uppercase">hora</div></div>
                            <div class="col"><div class="text-uppercase">descripción</div></div>
                            <div class="col-2 d-print-none"><div class="text-uppercase">acciones</div></div>
                        </div>
                    </div>

                    
                        @foreach ($agendas as $agenda)
                        <!--PC-->
                         <div class="border d-none d-md-block mb-1 d-print-block">
                            <div class="row align-items-center border-bottom">
                                <div class="col-2">
                                    <div class="text-uppercase text-center small pt-2 pb-2">{{date('d-m-Y',strtotime($agenda->fecha))}}</div>
                                </div>

                                <div class="col-1">
                                    <div class="text-uppercase text-center small pt-2 pb-2">{{date('H:i',strtotime($agenda->hora))}}</div>
                                </div>

                                <div class="col">
                                    <div class="text-uppercase small lh-1 text-start pt-2 pb-2">{{$agenda->descripcion}}</div>
                                </div>

                                <div class="col-md-2 d-print-none">
                                    <div class="text-uppercase text-center pt-2 pb-2">
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
                         @endforeach
                                    
                    </div>

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
@endsection

@section('js')
<!-- JS -->
         <script src="https://code.jquery.com/jquery-3.5.1.js"></script> 
         <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>


<script>
  document.querySelectorAll('.printbutton').forEach(function(element) {
    element.addEventListener('click', function() {
        print();
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




