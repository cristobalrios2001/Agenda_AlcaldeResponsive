<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Audita extends Model
{
    use HasFactory;
    protected $table='control_alcalde_agenda.audita';
    protected $primaryKey='id_audita';

    public $timestamps=false;

    protected $fillable=[
        'usuario',
        'accion',
        'hora',
        'fecha',
        'descripcion',
        'ip_maquina',
        'fecha_actividad'
    ];
}
