@extends('layouts.app')

@section('title', 'Usuarios')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
 <h1 class="h3 mb-0">Usuarios</h1>
 <a href="{{ route('users.create') }}" class="btn btn-primary">Agregar usuario</a>
</div>

<div class="card shadow-sm">
 <div class="card-body p-0">
  <div class="table-responsive">
   <table class="table table-hover mb-0">
    <thead>
     <tr>
      <th>Nombre</th>
      <th>Correo electrónico</th>
      <th>Rol</th>
      <th class="text-end">Acciones</th>
     </tr>
    </thead>
    <tbody>
     @forelse($users as $user)
     <tr>
      <td>{{ $user->name }}</td>
      <td>{{ $user->email }}</td>
      <td>{{ ucfirst($user->role) }}</td>
      <td class="text-end">
        <a href="{{ route('users.edit', $user) }}" class="btn btn-sm btn-outline-warning">Editar</a>
       @if($user->is(auth()->user()))
       <span class="text-muted">Cuenta actual</span>
       @else
       <form method="POST" action="{{ route('users.destroy', $user) }}" class="d-inline" onsubmit="return confirm('¿Eliminar este usuario?');">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-sm btn-outline-danger">Eliminar</button>
       </form>
       @endif
      </td>
     </tr>
     @empty
     <tr>
      <td colspan="4" class="text-center text-muted py-4">No hay usuarios registrados.</td>
     </tr>
     @endforelse
    </tbody>
   </table>
  </div>
 </div>
</div>
@endsection