<?php

namespace App\Http\Controllers;

use App\Models\AgendaAlcalde;
use App\Models\Audita;
use Illuminate\Cache\Repository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\App;
use Carbon\Carbon;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $fec = "select fecha from agenda_alcalde
        where fecha = CURRENT_DATE() and estado = 1 group by fecha;";
        //dd($fec);
        $fechas = DB::select($fec);
        //dd($fechas);
        $sql = "select * from agenda_alcalde where fecha =  CURRENT_DATE() and estado =1;";
        $agendas = DB::select($sql);
        //dd($agendas);

        // Generar horas posibles
        $horasPosibles = [];
        $horaInicio = strtotime('07:30:00');
        $horaFin = strtotime('22:30:00');
        $intervalo = 30 * 60; // Intervalo de 30 minutos

        for ($hora = $horaInicio; $hora <= $horaFin; $hora += $intervalo) {
            $horasPosibles[] = date('H:i:s', $hora);
        }

        // Comparar y modificar la agenda
        $agendasMod = [];
        if (!empty($fechas)){        
            foreach ($horasPosibles as $horaPosible) {
                $coincidencia = false;

                foreach ($agendas as $agenda) {
                    if ($agenda->hora == $horaPosible) {
                        $agendasMod[] = $agenda;
                        $coincidencia = true;
                        break;
                    }
                }

                if (!$coincidencia) {
                    $nuevaAgenda = new AgendaAlcalde([
                        'id_agenda' => 0,
                        'hora' => $horaPosible,
                        'fecha' => $fechas[0]->fecha,
                        'descripcion' => '',
                        'estado' => 0
                    ]);

                    $agendasMod[] = $nuevaAgenda;
                }
            }
        }
        else{
            // SI NO EXISTE ACTIVIDAD PARA LA FECHA ACTUAL, SE REGISTRAN SOLO LAS HORAS POSIBLES
            $fechaActual = Carbon::now();
            $fechaActualSoloFecha = Carbon::now()->format('Y-m-d');
            //dd($fechaActualSoloFecha);
            foreach ($horasPosibles as $horaPosible) {
                $nuevaAgenda = new AgendaAlcalde([
                    'id_agenda' => 0,
                    'hora' => $horaPosible,
                    'fecha' => $fechaActualSoloFecha,
                    'descripcion' => '',
                    'estado' => 0
                ]);

                $agendasMod[] = $nuevaAgenda;
            }
            $objetoFechaActual = new \stdClass();
            $objetoFechaActual->fecha = $fechaActualSoloFecha;

            // Almacenar el objeto en el array $fechas
            $fechas = [$objetoFechaActual];
            //dd($fechas);
        }
        $agendas = $agendasMod;

        

        return view('home',compact('agendas','fechas'));
    }

    public function store(Request $request)

    {
        response()->json($request);
        date_default_timezone_set('America/Santiago');

        $clientIP = request()->ip();
        $usuarioString ='';

        if($request->post('id_profe')==200){
            $usuarioString = '(XR)';
        }else{
            if($request->post('id_profe')==1441){
                $usuarioString = '(JGC)';
            }else{
                if($request->post('id_profe')==1136){
                    $usuarioString = '(MAR)';
                }
            }
        }

         $newAgenda = new AgendaAlcalde();
         $newAgenda->fecha = $request->post('frmactividad');
         $fechas = $request->post('frmactividad');
         $newAgenda->hora = $request->post('slectHora');
         $newAgenda->descripcion = $request->post('txtareaActividad').' '.$usuarioString;
         $newAgenda->estado = 1;
         
         $newAgenda->save();

         //graba en audita accion Ingreso
         $audita = new Audita();
         $audita->usuario = Auth::user()->name; 
         $audita->accion = 'Ingresado';
         $audita->hora = $newAgenda->hora;
         $audita->fecha = $newAgenda->fecha;
         $audita->descripcion = $newAgenda->descripcion;
         $audita->ip_maquina =$clientIP ;
         $audita->fecha_actividad = date('Y-m-d');
         $audita->save();


        //  -------------- REDIRECCIONAR FECHA ACTIVIDAD ALMACENADA -------------

        $fechabusca = $request->post('frmactividad');
       
        $sql = 'select * from agenda_alcalde where fecha ="'.$fechabusca.'"and estado =1;';
        $agendas = DB::select($sql);
        
        $fec = 'select fecha from agenda_alcalde where fecha ="'.$fechabusca.'"and estado =1 group by fecha;';
        $fechas = DB::select($fec);

        // dd($agendas);

        // Generar horas posibles
        $horasPosibles = [];
        $horaInicio = strtotime('07:30:00');
        $horaFin = strtotime('22:30:00');
        $intervalo = 30 * 60; // Intervalo de 30 minutos

        for ($hora = $horaInicio; $hora <= $horaFin; $hora += $intervalo) {
            $horasPosibles[] = date('H:i:s', $hora);
        }

        // Comparar y modificar la agenda
        $agendasMod = [];
        if (!empty($fechas)){ 
            foreach ($horasPosibles as $horaPosible) {
                $coincidencia = false;

                foreach ($agendas as $agenda) {
                    if ($agenda->hora == $horaPosible) {
                        $agendasMod[] = $agenda;
                        $coincidencia = true;
                        break;
                    }
                }

                if (!$coincidencia) {
                    $nuevaAgenda = new AgendaAlcalde([
                        'id_agenda' => 0,
                        'hora' => $horaPosible,
                        'fecha' => $fechas[0]->fecha,
                        'descripcion' => '',
                        'estado' => 0
                    ]);

                    $agendasMod[] = $nuevaAgenda;
                }
            }
        }else{            
            foreach ($horasPosibles as $horaPosible) {
                $nuevaAgenda = new AgendaAlcalde([
                    'id_agenda' => 0,
                    'hora' => $horaPosible,
                    'fecha' => $fechabusca,
                    'descripcion' => '',
                    'estado' => 0
                ]);

                $agendasMod[] = $nuevaAgenda;
            }
            $objetoFechaActual = new \stdClass();
            $objetoFechaActual->fecha = $fechabusca;

            // Almacenar el objeto en el array $fechas
            $fechas = [$objetoFechaActual];
            //dd($fechas);
        }

        $agendas = $agendasMod;

                 
        return view('home', compact('agendas', 'fechas'))->with('successMessage', 'Registro ingresado..!');  
     }
    

    public function update(Request $request, $id)
    {
        
        $clientIP = request()->ip();
        $usuarioString ='';

        if($request->post('id_profe')==200){
            $usuarioString = '(XR)';
        }else{
            if($request->post('id_profe')==1441){
                $usuarioString = '(JGC)';
            }else{
                if($request->post('id_profe')==1136){
                    $usuarioString = '(MAR)';
                }
            }
        }

        $descripcion =  $request->post('txtareaActividad');
        $sql='update agenda_alcalde set descripcion ="'.$descripcion.'" where id_agenda ='.$id;
        DB::select($sql);

        $sql1= "select * from agenda_alcalde where id_agenda =".$id;
        $modAgendas = DB::select($sql1);

        foreach ($modAgendas as $modAgenda)
        {

        }
    
        //dd($modAgenda);
        //graba en audita accion Ingreso
        $audita = new Audita();
        $audita->usuario = Auth::user()->name; 
        $audita->accion = 'Actualizar';
        $audita->hora = $modAgenda->hora;
        $audita->fecha = $modAgenda->fecha;
        $audita->descripcion = $descripcion.' '.$usuarioString;
        $audita->ip_maquina =$clientIP ;
        $audita->fecha_actividad = date('Y-m-d');
        //dd($audita);
        $audita->save();
        

        // -------------- REDIRECCIONAR FECHA ACTIVIDAD MODIFICADA -------------
        $sql1= "select fecha from agenda_alcalde where id_agenda =".$id;
        $fechas = DB::select($sql1);

        //conversion de fecha a string para utilizarla en la query
        $fecha = $fechas[0]->fecha;
        $fechaString = date('Y-m-d', strtotime($fecha));

        $sql = 'select * from agenda_alcalde where fecha ="'.$fechaString.'"and estado =1;';
        $agendas = DB::select($sql);

        // Generar horas posibles
        $horasPosibles = [];
        $horaInicio = strtotime('07:30:00');
        $horaFin = strtotime('22:30:00');
        $intervalo = 30 * 60; // Intervalo de 30 minutos

        for ($hora = $horaInicio; $hora <= $horaFin; $hora += $intervalo) {
            $horasPosibles[] = date('H:i:s', $hora);
        }

        // Comparar y modificar la agenda
        $agendasMod = [];
        if (!empty($fechas)){ 
            foreach ($horasPosibles as $horaPosible) {
                $coincidencia = false;

                foreach ($agendas as $agenda) {
                    if ($agenda->hora == $horaPosible) {
                        $agendasMod[] = $agenda;
                        $coincidencia = true;
                        break;
                    }
                }

                if (!$coincidencia) {
                    $nuevaAgenda = new AgendaAlcalde([
                        'id_agenda' => 0,
                        'hora' => $horaPosible,
                        'fecha' => $fechas[0]->fecha,
                        'descripcion' => '',
                        'estado' => 0
                    ]);

                    $agendasMod[] = $nuevaAgenda;
                }
            }
        }else{  
            foreach ($horasPosibles as $horaPosible) {
                $nuevaAgenda = new AgendaAlcalde([
                    'id_agenda' => 0,
                    'hora' => $horaPosible,
                    'fecha' => $fechaString,
                    'descripcion' => '',
                    'estado' => 0
                ]);

                $agendasMod[] = $nuevaAgenda;
            }
            $objetoFechaActual = new \stdClass();
            $objetoFechaActual->fecha = $fechaString;

            // Almacenar el objeto en el array $fechas
            $fechas = [$objetoFechaActual];
            //dd($fechas);
        }


        $agendas = $agendasMod;

        return view('home', compact('agendas', 'fechas'))->with('editMessage', 'Registro modificado..!');
    }

    public function delete(Request $request, $id)
    {
        $clientIP = request()->ip();
        $usuarioString ='';

        if($request->post('id_profe')==200){
            $usuarioString = '(XR)';
        }else{
            if($request->post('id_profe')==1441){
                $usuarioString = '(JGC)';
            }else{
                if($request->post('id_profe')==1136){
                    $usuarioString = '(MAR)';
                }
            }
        }

        $sql='update agenda_alcalde set estado = 0 where id_agenda ='.$id;
        DB::select($sql);

        $sql1= "select * from agenda_alcalde where id_agenda =".$id;
        $eliAgendas = DB::select($sql1);

        foreach ($eliAgendas as $eliAgenda)
        {

        }

         //graba en audita accion Ingreso
         $audita = new Audita();
         $audita->usuario = Auth::user()->name; 
         $audita->accion = 'Eliminar';
         $audita->hora = $eliAgenda->hora;
         $audita->fecha = $eliAgenda->fecha;
         $audita->descripcion = $eliAgenda->descripcion.' '.$usuarioString;
         $audita->ip_maquina =$clientIP ;
         $audita->fecha_actividad = date('Y-m-d');
         //dd($audita);
         $audita->save();        

         // -------------- REDIRECCIONAR FECHA ACTIVIDAD ELIMINADA -------------
         $sql1= "select fecha from agenda_alcalde where id_agenda =".$id;
         $fechas = DB::select($sql1);
 
         //conversion de fecha a string para utilizarla en la query
         $fecha = $fechas[0]->fecha;
         $fechaString = date('Y-m-d', strtotime($fecha));
 
         $sql = 'select * from agenda_alcalde where fecha ="'.$fechaString.'"and estado =1;';
         $agendas = DB::select($sql);

         // Generar horas posibles
        $horasPosibles = [];
        $horaInicio = strtotime('07:30:00');
        $horaFin = strtotime('22:30:00');
        $intervalo = 30 * 60; // Intervalo de 30 minutos

        for ($hora = $horaInicio; $hora <= $horaFin; $hora += $intervalo) {
            $horasPosibles[] = date('H:i:s', $hora);
        }

        // Comparar y modificar la agenda
        $agendasMod = [];
        if(!empty($fechas)){
        foreach ($horasPosibles as $horaPosible) {
            $coincidencia = false;

            foreach ($agendas as $agenda) {
                if ($agenda->hora == $horaPosible) {
                    $agendasMod[] = $agenda;
                    $coincidencia = true;
                    break;
                }
            }

            if (!$coincidencia) {
                $nuevaAgenda = new AgendaAlcalde([
                    'id_agenda' => 0,
                    'hora' => $horaPosible,
                    'fecha' => $fechas[0]->fecha,
                    'descripcion' => '',
                    'estado' => 0
                ]);

                $agendasMod[] = $nuevaAgenda;
            }
        }
        }else{
            foreach ($horasPosibles as $horaPosible) {
                $nuevaAgenda = new AgendaAlcalde([
                    'id_agenda' => 0,
                    'hora' => $horaPosible,
                    'fecha' => $fechaString,
                    'descripcion' => '',
                    'estado' => 0
                ]);

                $agendasMod[] = $nuevaAgenda;
            }
            $objetoFechaActual = new \stdClass();
            $objetoFechaActual->fecha = $fechaString;

            // Almacenar el objeto en el array $fechas
            $fechas = [$objetoFechaActual];
        }
        $agendas = $agendasMod;

         return view('home', compact('agendas', 'fechas'))->with('deleteMessage', 'Registro Eliminado..!');
    }
    
    public function search(Request $request)
    {        
        $horasPosibles = [];
        $horaInicio = strtotime('07:30:00');
        $horaFin = strtotime('22:30:00');
        $intervalo = 30 * 60; // Intervalo de 30 minutos
        for ($hora = $horaInicio; $hora <= $horaFin; $hora += $intervalo) {
            $horasPosibles[] = date('H:i:s', $hora);
        }

        $fecbusca = $request->post('frmactividad');
        $fec = 'select fecha from agenda_alcalde where fecha ="'.$fecbusca.'"and estado =1 group by fecha;';

        $fechas = DB::select($fec);

        $fechabusca = $request->post('frmactividad');
        if (count($fechas)==0)
        {   
            $agendasMod = [];
            foreach ($horasPosibles as $horaPosible) {
                $nuevaAgenda = new AgendaAlcalde([
                    'id_agenda' => 0,
                    'hora' => $horaPosible,
                    'fecha' => $fechabusca,
                    'descripcion' => '',
                    'estado' => 0
                ]);

                $agendasMod[] = $nuevaAgenda;
            }
            $objetoFechaActual = new \stdClass();
            $objetoFechaActual->fecha = $fechabusca;

            // Almacenar el objeto en el array $fechas
            $fechas = [$objetoFechaActual];
            $agendas = $agendasMod;

            return view('home', compact('agendas', 'fechas'))->with('alertMessage', 'No se han encontrado registros..!');
            //return redirect()->route("home")->with("alert","No hay actividad para la fecha seleccionada..!");
        }else{
           
        
        
        $sql = 'select * from agenda_alcalde where fecha ="'.$fechabusca.'"and estado =1;';
        $agendas = DB::select($sql);


        
        

        

        // Comparar y modificar la agenda
        $agendasMod = [];
        if(!empty($fechas)){        
            foreach ($horasPosibles as $horaPosible) {
                $coincidencia = false;

                foreach ($agendas as $agenda) {
                    if ($agenda->hora == $horaPosible) {
                        $agendasMod[] = $agenda;
                        $coincidencia = true;
                        break;
                    }
                }

                if (!$coincidencia) {
                    $nuevaAgenda = new AgendaAlcalde([
                        'id_agenda' => 0,
                        'hora' => $horaPosible,
                        'fecha' => $fechas[0]->fecha,
                        'descripcion' => '',
                        'estado' => 0
                    ]);

                    $agendasMod[] = $nuevaAgenda;
                }
            }
        }else{
            foreach ($horasPosibles as $horaPosible) {
                $nuevaAgenda = new AgendaAlcalde([
                    'id_agenda' => 0,
                    'hora' => $horaPosible,
                    'fecha' => $fechabusca,
                    'descripcion' => '',
                    'estado' => 0
                ]);

                $agendasMod[] = $nuevaAgenda;
            }
            $objetoFechaActual = new \stdClass();
            $objetoFechaActual->fecha = $fechabusca;

            // Almacenar el objeto en el array $fechas
            $fechas = [$objetoFechaActual];
        }
        $agendas = $agendasMod;
        
        return view('home',compact('agendas','fechas')); 
        }
        
    }
    
    public function obtenerDatosFechas(Request $request)
    {
        // Obtiene la fecha seleccionada
        $fechaSeleccionada = $request->get('fecha');

        $fec = 'select hora from agenda_alcalde where fecha ="'.$fechaSeleccionada.'" and estado =1;';

        $fechas = DB::select($fec);
        
        // Retorna los datos como respuesta JSON
        return response()->json($fechas);
    }

    public function send()
    {
        return view('send');
    }

    public function pdf(Request $request)
    {
        $fechas = $request->input('fechas');
        $fecha = $fechas[0]['fecha'];        

        $fec = "select fecha from agenda_alcalde where fecha = '" . $fecha . "' and estado = 1 group by fecha";

        //dd($fec);
        $fechas = DB::select($fec);
        //dd($fechas);
        $sql = "select * from agenda_alcalde where fecha = '" . $fecha . "' and estado = 1";
        $agendas = DB::select($sql);
        //dd($agendas);

        // Generar horas posibles
        $horasPosibles = [];
        $horaInicio = strtotime('07:30:00');
        $horaFin = strtotime('22:30:00');
        $intervalo = 30 * 60; // Intervalo de 30 minutos

        for ($hora = $horaInicio; $hora <= $horaFin; $hora += $intervalo) {
            $horasPosibles[] = date('H:i:s', $hora);
        }

        // Comparar y modificar la agenda
        $agendasMod = [];
        if(!empty($fechas)){        
            foreach ($horasPosibles as $horaPosible) {
                $coincidencia = false;

                foreach ($agendas as $agenda) {
                    if ($agenda->hora == $horaPosible) {
                        $agendasMod[] = $agenda;
                        $coincidencia = true;
                        break;
                    }
                }

                if (!$coincidencia) {
                    $nuevaAgenda = new AgendaAlcalde([
                        'id_agenda' => 0,
                        'hora' => $horaPosible,
                        'fecha' => $fechas[0]->fecha,
                        'descripcion' => '',
                        'estado' => 0
                    ]);

                    $agendasMod[] = $nuevaAgenda;
                }
            }
        }else{
            foreach ($horasPosibles as $horaPosible) {
                $nuevaAgenda = new AgendaAlcalde([
                    'id_agenda' => 0,
                    'hora' => $horaPosible,
                    'fecha' => $fecha,
                    'descripcion' => '',
                    'estado' => 0
                ]);

                $agendasMod[] = $nuevaAgenda;
            }
            $objetoFechaActual = new \stdClass();
            $objetoFechaActual->fecha = $fecha;

            // Almacenar el objeto en el array $fechas
            $fechas = [$objetoFechaActual];
        }

        $agendas = $agendasMod;

        
        
        $pdf = PDF::loadView('pdf.pdf', ['agendas' => $agendas , 'fechas' => $fechas]);
        
        $pdf->setPaper('legal', 'portrait');
        
        return $pdf->stream();
        
    }
}

