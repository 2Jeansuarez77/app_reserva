@extends('layouts.app')

@section('content_landing')

    <div class="container mt-5" id="app">
        <div class="row">
            
            <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/"><b>Menu</b> </a></li>
                    <li class="breadcrumb-item active" aria-current="page">Socios</li>
                </ol>
            </nav>

            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                <button type="button" class="btn btn-info" v-on:click="nuevoSocio()"> <span class="fa fa-user"></span> Nuevo</button>
            </div>

            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">DNI</th>
                        <th scope="col">Nombres</th>
                        <th scope="col">Apellidos</th>
                        <th scope="col">Fecha de alta</th>
                        <th scope="col">Opt</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(socio, key) in socios">
                        <td v-html="key + 1"></td>
                        <td v-html="socio.dni"></td>
                        <td v-html="socio.nombres"></td>
                        <td v-html="socio.apellidos"></td>
                        <td v-html="socio.fecha_alta"></td>
                        <td>

                            <button type="button" class="btn btn-info" title="Clic para editar socio" v-on:click="editarSocio(socio)"> 
                                <span class="fa fa-pencil-square-o"> </span> 
                            </button>
                            
                            <button type="button" class="btn btn-danger" title="Clic para eliminar socio" v-on:click="eliminarSocio(socio)"> 
                                <span class="fa fa-trash"> </span> 
                            </button>
                            
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

         <!--- formulario socios -->

        <!-- Modal -->
        <div class="modal fade" id="form_socios" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Formulario socios</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    
                    <div class="alert alert-danger mb-12" id="error_panel" style="display: none" role="alert">
                    </div>

                    <div class="mb-3">
                        <label for="dni" class="form-label text-danger">DNI *</label>
                        <input type="text" class="form-control" id="dni" v-model="socio.dni" placeholder="Ingrese su DNI">
                    </div>
                    <div class="mb-3">
                        <label for="nombres" class="form-label text-danger">Nombres *</label>
                        <input type="text" class="form-control" id="nombres" v-model="socio.nombres" placeholder="Ingrese nombre completo">
                    </div>

                    <div class="mb-3">
                        <label for="apellidos" class="form-label text-danger">Apellidos *</label>
                        <input type="text" class="form-control" id="apellidos" v-model="socio.apellidos" placeholder="Ingrese sus apellidos">
                    </div>

                    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" v-on:click="getSocios()">cancelar</button>

                    <button v-if="socio.id > 0" id="btn-save"  type="button" class="btn btn-success" v-on:click ="actualizarSocio()"> Actualizar</button>
                    <button v-else type="button" id="btn-save" class="btn btn-success" v-on:click ="createSocio()">Guardar</button>
                </div>
                </div>
            </div>
        </div>

    </div>


   


@include('layouts.script')

<script> 
    const URL_SOCIOS = "{{ route('socio.getSocios') }}";
    const URL_SOCIOS_CREATE = "{{ route('socio.create') }}";
    const URL_SOCIOS_ELIMINAR = "{{ route('socio.eliminar') }}";
    const URL_SOCIOS_ACTUALIZAR = "{{ route('socio.actualizar') }}";

    const _TOKEN =  "{{ csrf_token() }}";

</script>

<script type="text/javascript" src="{{asset('js/vue/socios.js')}}"></script>

@endsection