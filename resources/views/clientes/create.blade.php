@extends('layouts.app')
@section('title', 'Nuevo Cliente')
@section('content')
<div class="row justify-content-center">
 <div class="col-md-8">
 <div class="card shadow-sm">
 <div class="card-header bg-primary text-white">Registrar Nuevo Cliente</div>
 <div class="card-body">
 <form action="{{ route('clientes.store') }}" method="POST">
 @csrf
 <div class="mb-3">
 <label for="nombre" class="form-label">Nombre Completo</label>
 <input type="text" name="nombre" id="nombre" class="form-control 
@error('nombre') is-invalid @enderror" value="{{ old('nombre') }}" required>
 @error('nombre') <div class="invalid-feedback">{{ $message 
}}</div> @enderror
 </div>
 <div class="mb-3">
 <label for="fechanac" class="form-label">Fecha de 
Nacimiento</label>
 <input type="date" name="fechanac" id="fechanac" class="form-control @error('fechanac') is-invalid @enderror" value="{{ old('fechanac') }}" required>
 @error('fechanac') <div class="invalid-feedback">{{ $message 
}}</div> @enderror
 </div>
 <div class="mb-3">
 <label for="email" class="form-label">Correo Electrónico</label>
 <input type="email" name="email" id="email" class="form-control 
@error('email') is-invalid @enderror" value="{{ old('email') }}" required>
 @error('email') <div class="invalid-feedback">{{ $message }}</div> 
@enderror
 </div>
 <button type="submit" class="btn btn-success">Guardar Cliente</button>
 <a href="{{ route('clientes.index') }}" class="btn btn-secondary">Cancelar</a>
 </form>
 </div>
 </div>
 </div>
</div>
@endsection