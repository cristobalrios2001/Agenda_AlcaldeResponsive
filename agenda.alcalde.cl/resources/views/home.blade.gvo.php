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
                <img src="{{ asset('banner_superior_agenda/banner_superior_agenda.jpg') }}" width="100%" hidden="hidden" id="banner">
                <h3>Actividades del Dia <strong>
                    {{ now()->format('d-m-Y') }}
                </strong>
                </h3></div>
             
                <div id="areaImprimir" class="card-body">
                    <div class="col-xl-12 mb-3">
                        <div class="row">
                            <div class="col-2">
                                <div class="">
                                <a class="btn btn-success border-light" data-bs-toggle="modal" data-bs-target="#modal-create">
                                <span class="fas fa-plus-circle"></span>
                                
                                </a>
                                </div>
                                 @include('modal.crear') 
                             </div>
                             <div class="col-2">
                                <div class="">
                                <a class="btn btn-primary border-light" data-bs-toggle="modal" data-bs-target="#modal-search">
                                <span class="fas fa-search"></span>
                                </a>
                                </div>
                                 @include('modal.search') 
                             </div>
                             
                             <div class="col-2">
                                {{-- <div class="">
                                <a class="btn btn-danger border-light" onclick="imprimir('areaImprimir')">
                                <span class="fas fa-print"></span>
                                
                                </a>
                                </div> --}}
                                <button class="btn btn-danger" onclick="printDiv('areaImprimir')">
                                    <span class="fas fa-print"></span>
                                </button>
                                
                             </div>

                        </div>
                       <hr>
                </div>
                    <table id="agenda" class="table table-striped mt-2">
                        <thead style="background-color:#990505;">
                            <th style="color:#0e0303;">Fecha</th>
                            <th style="color:#0e0303;">Hora</th>
                            <th style="color:#0e0303;">Descripcion</th>
                            <th style="color:#0e0303;">Acciones</th>
                            <th></th>
                        </thead>
                        
                        <tbody>
                           @foreach ($agendas as $agenda)
                           <tr>
                            <td>{{date('d-m-Y',strtotime($agenda->fecha))}}</td>
                            <td>{{date('H:i',strtotime($agenda->hora))}}</td>
                            <td>{{$agenda->descripcion}}</td>
                            
                            <td> <button type="button" class="btn btn-link" data-bs-toggle="modal" data-bs-target="#modal-edit{{$agenda->id_agenda}}">
                                    <i class="far fa-edit"></i>
                                </button> 
                            </td>
                            <td>
                                <button type="button" class="btn btn-link" data-bs-toggle="modal" data-bs-target="#modal-delete{{$agenda->id_agenda}}" style="color: #990505;">
                                    <i class="far fa-trash-alt"></i>
                                </button>  
                            </td>
                           </tr>
                           @include('modal/edit') 
                           @include('modal/delete') 
                           @endforeach
                        </tbody>
                    </table>
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
         <script src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap5.min.js"></script>
                                  
         <script>
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
          </script> 
<script>
    function printDiv(nombreDiv) {
     var contenido= document.getElementById(nombreDiv).innerHTML;
     var contenidoOriginal= document.body.innerHTML;

     document.body.innerHTML = contenido;

     window.print();

     document.body.innerHTML = contenidoOriginal;
}
</script>

@endsection




