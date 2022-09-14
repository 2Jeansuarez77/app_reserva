@extends('layouts.app')

@section('content_landing')

  <div class="container mt-5" id="app">
    <div class="row">
      
      <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/"><b>Menu</b> </a></li>
            <li class="breadcrumb-item active" aria-current="page">Reservas</li>
        </ol>
    </nav>



    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
      <button type="button" class="btn btn-success" v-on:click="nuevoReserva()"> <span class="fa fa-check-square"></span> Nueva Reserva</button>
      <a href="{{route('socio.index')}}" class="btn btn-info"> Gestionar socios</a>
    </div>
    
      <table class="table table-hover">
        <thead>
          <tr>
            <th>#</th>
            <th>Fecha reserva</th>
            <th>Socio</th>
            <th>N° Butacas</th>
            <th>Opt</th>
          </tr>

        </thead>
        <tbody>
          <tr v-for="(value, index) in reservas">
            <td v-text="index+1"></td>
            <td v-text="value.fecha_reserva"></td>
            <td v-text="value.nombres+' '+value.apellidos"></td>
            <td>
              <p v-for="butaca in value.butacas" v-text="'Fila:'+ butaca.fila + ' Columna:' + butaca.columna "></p>
            </td>
            <td>

              <button type="button" class="btn btn-info" title="Clic para editar reserva" v-on:click="editarReserva(value)"> 
                  <span class="fa fa-pencil-square-o"> </span> 
              </button>
              
              <button type="button" class="btn btn-danger" title="Clic para eliminar reserva" v-on:click="eliminarReserva(value)"> 
                  <span class="fa fa-trash"> </span> 
              </button>
              
            </td>
          </tr>
        </tbody>

      </table>

    </div>


     <!-- Modal -->
    <div class="modal fade" id="form_reservas" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
      <div class="modal-dialog">
          <div class="modal-content">
          <div class="modal-header">
              <h5 class="modal-title" id="staticBackdropLabel">Formulario reservas</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <div class="alert alert-danger mb-12" id="error_panel" style="display: none" role="alert">
            </div>

            <div class="mb-3">
                <label for="socio_id" class="form-label text-danger">Seleccionar Socio *</label>
                <select class="form-select" aria-label="Default select example" v-model="reserva.socio_id">
                  <option v-for="socio in socios" v-text="socio.nombres + ' ' + socio.apellidos" :value = "socio.id"></option>
                </select>
            </div>

            <div class="mb-3">
              <label for="nombres" class="form-label text-danger">Fecha de reserva*</label>
              <input type="date" class="form-control" id="fecha_reserva" v-model="reserva.fecha_reserva">
            </div>

            <p> <b>  Ingresa la fila y la columna: </b> </p>

            <div class="input-group mb-3">
              <span class="input-group-text">Fila</span>
              <input type="number" min="0" class="form-control" id="fila" v-model="fila" placeholder="Fila">


              <span class="input-group-text">Columna</span>
              <input type="number" min="0" class="form-control" id="columna" v-model="columna" placeholder="Columna">
              

              <button type="button" class="btn btn-primary" title="Agregar butacas" v-on:click="addButacas()"> 
                <span class="fa fa-plus-square"> </span> 
            </button>
            </div>


            <table class="table table-bordered">
              <thead>
                  <th>Fila</th>
                  <th>Columna</th>
                  <th>opt</th>
              </thead>
              <tbody  class="table-group-divider">
                <tr  v-for="(butaca,index) in reserva.butacas">
                  <td v-text="butaca.fila"></td>
                  <td v-text="butaca.columna"></td>
                  <th>
                    <button type="button" class="btn btn-danger" title="Clic para eliminar butaca" v-on:click="eliminarButaca(index)"> 
                      <span class="fa fa-trash"> </span> 
                    </button>
                  </th>
                </tr>
              </tbody>
            </table>

            
          </div>
          <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" v-on:click="getreservas()">Salir</button>

              <button v-if="reserva.id > 0" id="btn-save"  type="button" class="btn btn-success"  v-on:click ="actualizarReserva()"> Actualizar</button>
              <button v-else type="button" id="btn-save" class="btn btn-success" v-on:click ="createReserva()">Guardar</button>
          </div>
          </div>
      </div>
    </div>

  </div>

  @include('layouts.script')

<script> 
    const URL_RESERVA = "{{ route('reserva.getReservas') }}";
    const URL_RESERVA_CREATE = "{{ route('reserva.create') }}";
    const URL_RESERVA_ELIMINAR = "{{ route('reserva.eliminar') }}";
    const URL_RESERVA_ACTUALIZAR = "{{ route('reserva.actualizar') }}";
    const URL_RESERVA_DISPONIBLE = "{{ route('reserva.disponible') }}";
    const URL_SOCIOS = "{{ route('socio.getSocios') }}";


    const _TOKEN =  "{{ csrf_token() }}";

</script>

<script type="text/javascript" src="{{asset('js/vue/reserva.js')}}"></script>

@endsection

