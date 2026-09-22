@extends('layouts.app')

@section('title', 'Nuevo Usuario')

@section('content')
<div class="row justify-content-center">
 <div class="col-md-8">
 <div class="card shadow-sm">
 <div class="card-header bg-primary text-white">Registrar Nuevo Usuario</div>
 <div class="card-body">
 <form action="{{ route('users.store') }}" method="POST">
 @csrf
 <div class="mb-3">
 <label for="name" class="form-label">Nombre</label>
 <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required>
 @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
 </div>
 <div class="mb-3">
 <label for="email" class="form-label">Correo Electrónico</label>
 <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required>
 @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
 </div>
 <div class="mb-3">
 <label for="password" class="form-label">Contraseña</label>
 <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror" required>
 @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
 </div>
 <div class="mb-3">
 <label for="password_confirmation" class="form-label">Confirmar Contraseña</label>
 <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required>
 </div>
 <div class="mb-3" id="client-fields">
 <label for="fechanac" class="form-label">Fecha de nacimiento del cliente</label>
 <input type="date" name="fechanac" id="fechanac" class="form-control @error('fechanac') is-invalid @enderror" value="{{ old('fechanac') }}">
 @error('fechanac') <div class="invalid-feedback">{{ $message }}</div> @enderror
 </div>
 <div class="mb-3">
 <label for="role" class="form-label">Rol</label>
 <select name="role" id="role" class="form-select @error('role') is-invalid @enderror" required>
  <option value="">Selecciona un rol</option>
  @foreach(['administrador' => 'Administrador', 'asesor' => 'Asesor', 'usuario' => 'Usuario'] as $value => $label)
  <option value="{{ $value }}" @selected(old('role') === $value)>{{ $label }}</option>
  @endforeach
 </select>
 @error('role') <div class="invalid-feedback">{{ $message }}</div> @enderror
 </div>
 <button type="submit" class="btn btn-success">Guardar Usuario</button>
 <a href="{{ route('dashboard') }}" class="btn btn-secondary">Cancelar</a>
 </form>
 </div>
 </div>
 </div>
</div>
<script>
 const role = document.getElementById('role');
 const clientFields = document.getElementById('client-fields');
 const birthDate = document.getElementById('fechanac');

 function toggleClientFields() {
  const isClient = role.value === 'usuario';
  clientFields.hidden = !isClient;
  birthDate.required = isClient;
 }

 role.addEventListener('change', toggleClientFields);
 toggleClientFields();
</script>
@endsection