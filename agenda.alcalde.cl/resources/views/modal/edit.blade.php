  <!-- Modal -->
  <div class="modal fade" id="modal-edit{{$agenda->id_agenda}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <form action="{{ url('update/'.$agenda->id_agenda)}}" method="post" enctype="multipart/form-data">
            @csrf
            
      <div class="modal-content">
        <div class="modal-header bg-success text-light">
          <h5 class="modal-title" id="exampleModalLabel">Editar Actividad</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="row">

            <div class="col-12 mb-2">
            <label class="form-label" for="name" ><strong>Fecha</strong></label>
            <input type="text" id="name" name="fecha" class="form-control" value="{{ date('d-m-Y',strtotime($agenda->fecha))}}" disabled>
            </div>
            <div class="col-12 mb-2">
            <label class="form-label" for="name" ><strong>Hora</strong></label>
            <input type="text" id="name" name="hora" class="form-control" value="{{ date('H:i',strtotime($agenda->hora))}}" disabled>
            </div>
            <div class="col-12 mb-2">
            <label class="form-label" for="name" ><strong>Hora</strong></label>
            <textarea name="txtareaActividad" class="form-control" rows="4" cols="50" >{{ isset($agenda->descripcion)?$agenda->descripcion:'' }}</textarea>
            {{-- <input type="text" id="name" name="name" class="form-control" value="{{ isset($agenda->descripcion)?$agenda->descripcion:'' }}"> --}}
            </div>
          </div>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-bs-dismiss="modal">CERRAR</button>
          <button type="submit" class="btn btn-success">GUARDAR</button>
        </div>
      </div>
        </form>
    </div>
  </div>
