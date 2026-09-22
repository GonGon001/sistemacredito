@extends('layouts.app')

@section('title', 'Editar Usuario')

@section('content')
<div class="row justify-content-center">
 <div class="col-md-8">
 <div class="card shadow-sm">
 <div class="card-header bg-primary text-white">Editar Usuario</div>
 <div class="card-body">
 <form action="{{ route('users.update', $user) }}" method="POST">
 @csrf
 @method('PUT')
 <div class="mb-3">
 <label for="name" class="form-label">Nombre</label>
 <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $user->name) }}" required>
 @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
 </div>
 <div class="mb-3">
 <label for="email" class="form-label">Correo Electrónico</label>
 <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $user->email) }}" required>
 @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
 </div>
 <div class="mb-3">
 <label for="password" class="form-label">Nueva Contraseña</label>
 <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror">
 @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
 </div>
 <div class="mb-3">
 <label for="password_confirmation" class="form-label">Confirmar Contraseña</label>
 <input type="password" name="password_confirmation" id="password_confirmation" class="form-control">
 </div>
 <div class="mb-3" id="client-fields">
 <label for="fechanac" class="form-label">Fecha de nacimiento del cliente</label>
 <input type="date" name="fechanac" id="fechanac" class="form-control @error('fechanac') is-invalid @enderror" value="{{ old('fechanac', $user->cliente?->fechanac) }}">
 @error('fechanac') <div class="invalid-feedback">{{ $message }}</div> @enderror
 </div>
 <div class="mb-3">
 <label for="role" class="form-label">Rol</label>
 <select name="role" id="role" class="form-select @error('role') is-invalid @enderror" required>
  @foreach(['administrador' => 'Administrador', 'asesor' => 'Asesor', 'usuario' => 'Usuario'] as $value => $label)
  <option value="{{ $value }}" @selected(old('role', $user->role) === $value)>{{ $label }}</option>
  @endforeach
 </select>
 @error('role') <div class="invalid-feedback">{{ $message }}</div> @enderror
 </div>
 <button type="submit" class="btn btn-success">Guardar Cambios</button>
 <a href="{{ route('users.index') }}" class="btn btn-secondary">Cancelar</a>
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