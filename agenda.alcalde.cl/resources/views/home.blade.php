@extends('layouts.app')


@section('content')
<div class="container-fluid">
    <div>
        @if(isset($successMessage))
            <div class="alert alert-success">
                <p>{{ $successMessage }}</p>
            </div>
            <script>
                setTimeout(function(){
                    $('.alert-success').fadeOut();
                }, 2000); // 2 segundos
            </script>
        @endif

        @if(isset($editMessage))
            <div class="alert alert-success">
                <p>{{ $editMessage }}</p>
            </div>
            <script>
                setTimeout(function(){
                    $('.alert-success').fadeOut();
                }, 2000); // 2 segundos
            </script>
        @endif

        @if(isset($deleteMessage))
            <div class="alert alert-success">
                <p>{{ $deleteMessage }}</p>
            </div>
            <script>
                setTimeout(function(){
                    $('.alert-success').fadeOut();
                }, 2000); // 2 segundos
            </script>
        @endif

        @if(\Session::has('alert'))
            <div class="alert alert-danger">
                <p>{{\Session::get('alert')}}</p>
            </div>
            @php
                header('Refresh:2'); 
            @endphp
        @endif 
    </div>
    

    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-print-none">
                    <h3>Actividades del Dia 
                        <strong>
                            @foreach ($fechas as $fecha)
                                {{date('d-m-Y',strtotime($fecha->fecha))}} 
                            @endforeach
                        </strong>
                    </h3>
                </div>             
                
                <div class="card-body">
                    
                    <div class="col-12 mb-3  d-print-none">
                        <div class="row">

                            <!-- BOTON PARA CREAR ACTIVIDAD -->
                            <div class="col-md-2 col-4">
                                <div class="d-grid">                               
                                    <a class="btn btn-success border-light" data-bs-toggle="modal" data-bs-target="#modal-create{{$fecha->fecha}}">
                                        <span class="fas fa-plus-circle"></span>
                                    </a>
                                </div>
                                @include('modal.crear') 
                            </div>

                            <!-- CALENDARIO PARA FILTRAR POR FECHA LAS ACTIVIDADES -->
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

                            <!-- BOTON PARA IMPRIMIR -->
                            <div class="col-md-2  col-4">
                                <div class="d-grid">
                                    <a href="{{ route('agenda.pdf', ['fechas' => $fechas]) }}" class="btn btn-primary">
                                        <span class="fas fa-print"></span>
                                    </a>
                                </div>                            
                            </div>
                        </div>
                       <hr>
                    </div>                    

                    <!-- CONTENIDO DE AGENDA -> ACTIVIDADES -->
                    <div class="" id="nonPrintContent">

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
                         <div class="border d-none d-md-block mb-1 d-print-block" hidden="hidden">
                            <div class="row align-items-center border-bottom">
                                <!-- FECHA ACTIVIDAD -->
                                <div class="col-2">
                                    <div class="text-uppercase text-center small pt-2 pb-2">{{date('d-m-Y',strtotime($agenda->fecha))}}</div>
                                </div>

                                <!-- HORA ACTIVIDAD -->
                                <div class="col-1">
                                    <div class="text-uppercase text-center small pt-2 pb-2">{{date('H:i',strtotime($agenda->hora))}}</div>
                                </div>

                                <!-- DESCRIPCION ACTIVIDAD -->
                                <div class="col">
                                    <div class="text-uppercase small lh-1 text-start pt-2 pb-2">
                                        @if ($agenda->id_agenda!=0)
                                            {{$agenda->descripcion}}
                                        @else
                                            <span class="text-danger">No hay actividades en este horario</span>
                                        @endif

                                        
                                    </div>
                                </div>

                                <!-- ACCIONES -->
                                <div class="col-md-2 d-print-none">
                                    <div class="text-uppercase text-center pt-2 pb-2">
                                        @if ($agenda->id_agenda!=0)
                                        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modal-edit{{$agenda->id_agenda}}" >
                                        <i class="far fa-edit"></i>
                                        </button> 
                                        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modal-delete{{$agenda->id_agenda}}" >
                                        <i class="far fa-trash-alt"></i>
                                        @endif
                                    </button>  
                                    </div>
                                </div>
                            </div>
                         </div>


                        
                        
                        <!--PC-->

                        <!--MOVIL-->
                        <div class="d-block d-md-none d-print-none card  mb-3 p-2">
                            <div class="row align-items-center ">
                                <!-- FECHA ACTIVIDAD -->
                                <div class="col-6 pe-0">
                                    <div class="text-uppercase text-center fw-bold pt-1 pb-1 bg-dark text-light">{{date('d-m-Y',strtotime($agenda->fecha))}}</div>
                                </div>

                                <!-- HORA ACTIVIDAD -->
                                <div class="col-6 ps-0">
                                    <div class="text-uppercase text-center fw-bold pt-1 pb-1 bg-secondary text-light">{{date('H:i',strtotime($agenda->hora))}}</div>
                                </div>

                                <!-- DESCRIPCION ACTIVIDAD -->
                                <div class="col-12">
                                    <div class="text-uppercase small lh-1 text-start pt-3 pb-3 mt-2 mb-2">
                                        @if ($agenda->id_agenda!=0)
                                            {{$agenda->descripcion}}
                                        @else
                                            <span class="text-danger">No hay actividades en este horario</span>

                                        @endif</div>
                                </div>

                                <!-- ACCIONES -->
                                <div class="col-12">
                                    <div class="text-uppercase text-end pt-2 pb-2">
                                    @if ($agenda->id_agenda!=0)
                                        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modal-edit{{$agenda->id_agenda}}" >
                                        <i class="far fa-edit"></i>
                                        </button> 
                                        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modal-delete{{$agenda->id_agenda}}" >
                                        <i class="far fa-trash-alt"></i>
                                    </button>  
                                    @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--MOVIL-->                        


                        @include('modal/edit') 
                        @include('modal/delete') 
                        @endforeach
                                    
                    </div>
                                      
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
