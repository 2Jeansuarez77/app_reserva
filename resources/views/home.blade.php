@extends('layouts.app')

@section('content_landing')

  <div class="container mt-5">
    <div class="row">
      
      <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/"><b>Menu</b> </a></li>
            <li class="breadcrumb-item active" aria-current="page">Reservas</li>
        </ol>
    </nav>

    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
      <a href="{{route('socio.index')}}" class="btn btn-info"> Ver socios</a>
    </div>
    
      <table class="table table-hover">
        <thead>
          <th>#</th>
          <th>Butacas</th>
          <th>Fecha reserva</th>
          <th>Socio</th>
          <th>Opt</th>
        </thead>

        <tbody>

        </tbody>

      </table>

    </div>
  </div>


@endsection

