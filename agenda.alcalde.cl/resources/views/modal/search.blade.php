 <!-- Modal -->
 <div class="modal fade" id="modal-search" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <form action="{{ route('search')}}" method="post">
            @csrf
            {{-- @method('DELETE') --}}
      <div class="modal-content">
        <div class="modal-header bg-danger text-light">
          <h5 class="modal-title" id="exampleModalLabel">Buscar Actividad</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
             <div class="fs-2 fw-bold text-center text-danger">Ingrese Fecha a Buscar..!</div>
            {{-- <div class="fw-bold fs-5 text-center lh-sm">{{$agenda->descripcion}} </div> --}}
            <input type="date" name="frmactividad" class="form-control">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
          <button type="submit" class="btn btn-danger">Buscar</button>
        </div>
      </div>
        </form>
    </div>
  </div>
