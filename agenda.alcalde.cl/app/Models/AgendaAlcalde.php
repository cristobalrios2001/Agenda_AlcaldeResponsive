<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AgendaAlcalde extends Model
{
    use HasFactory;
    protected $table='control_alcalde_agenda.agenda_alcalde';
    protected $primaryKey='id_agenda';

    public $timestamps=false;

    protected $fillable=[
        'id_agenda',
        'fecha',
        'hora',
        'descripcion',
        'estado'
    ];
}
