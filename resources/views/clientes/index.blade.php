@extends('layouts.app')
@section('title', 'Listado de Clientes')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
 <h2>Clientes</h2>
 @if(in_array(auth()->user()->role, ['administrador', 'asesor'], true))
 <a href="{{ route('clientes.create') }}" class="btn btn-primary">Nuevo Cliente</a>
 @endif
</div>
<div class="card shadow-sm">
 <div class="card-body">
 <table class="table table-hover align-middle">
 <thead class="table-dark">
 <tr>
 <th>ID</th>
 <th>Nombre</th>
 <th>Fecha Nacimiento</th>
 <th>Email</th>
 <th class="text-end">Acciones</th>
 </tr>
 </thead>
 <tbody>
 @forelse($clientes as $cliente)
 <tr>
 <td>{{ $cliente->id }}</td>
 <td>{{ $cliente->nombre }}</td>
 <td>{{ $cliente->fechanac }}</td>
 <td>{{ $cliente->email }}</td>
 <td class="text-end">
 <a href="{{ route('clientes.show', $cliente) }}" class="btn 
btn-info btn-sm text-white">Ver</a>
 @if(auth()->user()->role === 'administrador')
 <a href="{{ route('clientes.edit', $cliente) }}" class="btn btn-warning btn-sm">Editar</a>
 <form action="{{ route('clientes.destroy', $cliente) }}" 
method="POST" class="d-inline" onsubmit="return confirm('¿Desea eliminar este 
cliente?');">
 @csrf
@method('DELETE')
<button class="btn btn-danger btn-sm">Eliminar</button>
 </form>
 @endif
 </td>
 </tr>
 @empty
 <tr>
 <td colspan="5" class="text-center">No hay clientes 
registrados.</td>
 </tr>
 @endforelse
 </tbody>
 </table>
 {{ $clientes->links() }}
 </div>
</div>
@endsection