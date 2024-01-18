  <!-- Modal -->
  <div class="modal fade" id="modal-delete{{$agenda->id_agenda}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <form action="{{ route('delete',$agenda->id_agenda)}}" method="post">
            @csrf
            @method('DELETE')
      <div class="modal-content">
        <div class="modal-header bg-danger text-light">
          <h5 class="modal-title" id="exampleModalLabel">Elimina Actividad</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
             <div class="fs-2 fw-bold text-center text-danger">¿Deseas eliminar?</div>
            <div class="fw-bold fs-5 text-center lh-sm">{{$agenda->descripcion}} </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
          <button type="submit" class="btn btn-danger">Eliminar</button>
        </div>
      </div>
        </form>
    </div>
  </div>

