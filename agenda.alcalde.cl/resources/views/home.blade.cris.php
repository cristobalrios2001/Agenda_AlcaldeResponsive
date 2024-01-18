@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            
                


                <!-- Boton para imprimir -->
                <button class="btn btn-primary" onclick="imprimir('areaImprimir')">
                    <span class="glyphicon glyphicon-print"></span> Imprimir Agenda
                </button>
                
                <!-- Area que se quiere imprimir -->
                <div id="areaImprimir" class="row">
                    <div id="date-popover" class="titulo titulo-print">
                        <div class="container-fluid">
                            <div class="row">
                                <img src="{{ asset('banner_superior_agenda/banner_superior_agenda.jpg') }}" width="100%" hidden="hidden" id="banner">
                                <strong class="col-xs-8 col-md-9 text-center">ACTIVIDADES DEL DIA</strong>
                                <div class="col-xs-4 col-md-3 text-center fecha-actual">
                                    <strong>
                                        Fecha: {{ now()->format('d/m/Y') }}
                                    </strong>
                                </div>
                                
                            </div>
                        </div>
                       
                    </div>

                    <!-- Contenido de la agenda -->
                    <div id="calendario_agenda" name="resultado_agenda">                        
                        <table class='table table_bordered' >
                            <tr>
                                <th>Fecha</th>
                                <th>Hora</th>
                                <th>Descrición</th>
                            </tr>
                            @foreach($agendas as $agenda)
                                <tr>
                                    <td>{{ $agenda->fecha }}</td>
                                    <td>{{ $agenda->hora }}</td>
                                    <td>{{ $agenda->descripcion }}</td>
                                </tr>


                                
                            @endforeach
                        </table>
                    </div>
                </div>  
            
        </div>
    </div>
</div>

<script scr="{{ asset('js/imprimirScript.js') }}"></script>
@endsection

