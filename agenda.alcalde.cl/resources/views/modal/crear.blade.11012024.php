 <!-- Modal -->
 <div class="modal fade" id="modal-create{{$fecha->fecha}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <form action="{{ route('store')}}" method="post">
            @csrf
       <input type="hidden" name="id_profe" value="{{ Auth::user()->id_profe }}">     
      <div class="modal-content">
        <div class="modal-header" style="background-color: #990505">
          <h5 class="modal-title" id="exampleModalLabel" style="color: #fff;">Crear Actividad {{$fecha->fecha}}</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        {{-- @php   
            $sql="select * from movil.categoria_movil;";
            $sql1="select * from movil.marca_movil;";
            DB::setDefaultConnection("mysql");
            $categorias = DB::select($sql);
            $marcas = DB::select($sql1);
            // use App\Models\AuditDoctos;
            // $cant_doctos = AuditDoctos::count();
            @endphp --}}
        <div class="modal-body">
         <div class="row">
            <div class="col-4 mb-2">
            <label class="form-label" for="hora"><strong>Hora</strong></label>
            {{-- <input type="text" id="name" name="name" class="form-control" placeholder="Nombre Articulo" required> --}}
            <select class="form-control " id="slectHora" name="slectHora">
                <!-- js-example-basic-single -->
                <option value="0">Seleccionar Hora</option>
                <option value="07:30:00">7:30</option>
                <option value="08:00:00">8:00</option>
                <option value="08:30:00">8:30</option>
                <option value="09:00:00">9:00</option>
                <option value="09:30:00">9:30</option>
                <option value="10:00:00">10:00</option>
                <option value="10:30:00">10:30</option>
                <option value="11:00:00">11:00</option>
                <option value="11:30:00">11:30</option>
                <option value="12:00:00">12:00</option>
                <option value="12:30:00">12:30</option>
                <option value="13:00:00">13:00</option>
                <option value="13:30:00">13:30</option>
                <option value="14:00:00">14:00</option>
                <option value="14:30:00">14:30</option>
                <option value="15:00:00">15:00</option>
                <option value="15:30:00">15:30</option>
                <option value="16:00:00">16:00</option>
                <option value="16:30:00">16:30</option>
                <option value="17:00:00">17:00</option>
                <option value="17:30:00">17:30</option>
                <option value="18:00:00">18:00</option>
                <option value="18:30:00">18:30</option>
                <option value="19:00:00">19:00</option>
                <option value="19:30:00">19:30</option>
                <option value="20:00:00">20:00</option>
                <option value="20:30:00">20:30</option>
                <option value="21:00:00">21:00</option>
                <option value="21:30:00">21:30</option>
                <option value="22:00:00">22:00</option>
                <option value="22:30:00">22:30</option>
            </select>
            </div>
            <div class="col-4">
                <label class="form-label" for="frmactividad"><strong>Fecha</strong></label>
                <input id="inputFecha" type="date" name="frmactividad" class="form-control" value="{{$fecha->fecha}}>
            </div>
            <div class="col-md-6 mt">
                <label class="form-label" for="txtareaActividad"><strong>Actividads</strong></label>
                <textarea id="txtareaActividad" name="txtareaActividad" class="form-control" rows="4" cols="50"></textarea>
            </div>
         </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
          <button type="submit" class="btn btn-success">Crear</button>
        </div>
      </div>
        </form>
    </div>
  </div>

  <script>
    var fechaActual = new Date();
    var dia = String(fechaActual.getDate()).padStart(2, '0');
    var mes = String(fechaActual.getMonth() + 1).padStart(2, '0');
    var anio = fechaActual.getFullYear();
    document.getElementById('inputFecha').value = anio + '-' + mes + '-' + dia;
  </script>