<?php

namespace App\Http\Controllers;

use App\Models\AgendaAlcalde;
use App\Models\Audita;
use Illuminate\Cache\Repository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

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

        $fechas = DB::select($fec);

        $sql = "select * from agenda_alcalde where fecha =  CURRENT_DATE() and estado =1;";
        $agendas = DB::select($sql);

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


                 // $newAgenda->fecha = date('Y-m-d H:i:s');
     
        return redirect()->route("home")->with("success","Registro Ingresado..!");
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

        return redirect()->route("home")->with("edit","Registro Actualizado..!");
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

        return redirect()->route("home")->with("delete","Registro Eliminado..!");
    }
    
    public function search(Request $request)
    {
        //return response()->json($request);
        $fecbusca = $request->post('frmactividad');
        $fec = 'select fecha from agenda_alcalde where fecha ="'.$fecbusca.'"and estado =1 group by fecha;';

        $fechas = DB::select($fec);
        if (count($fechas)==0)
        {
            return redirect()->route("home")->with("alert","No hay actividad para la fecha seleccionada..!");
        }else{
           
        $fechabusca = $request->post('frmactividad');
       
        $sql = 'select * from agenda_alcalde where fecha ="'.$fechabusca.'"and estado =1;';
        $agendas = DB::select($sql);
        
        return view('home',compact('agendas','fechas')); 
        }
        
    }
    
    public function obtenerDatosFechas(Request $request)
    {
        // return response()->json($request);
        // Obtén la fecha del request
        $fechaSeleccionada = $request->get('fecha');

        $fec = 'select hora from agenda_alcalde where fecha ="'.$fechaSeleccionada.'" and estado =1;';

        $fechas = DB::select($fec);
        // dd($fec);
        // Retorna los datos como respuesta JSON
        return response()->json($fechas);
    }
}

