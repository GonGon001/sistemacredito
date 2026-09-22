@extends('layouts.app')
@section('title', 'Listado de Créditos')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
 <h2>Créditos Otorgados</h2>
 @if(in_array(auth()->user()->role, ['administrador', 'asesor'], true))
 <a href="{{ route('creditos.create') }}" class="btn btn-primary">Nuevo Crédito</a>
 @endif
</div>
<div class="card shadow-sm">
 <div class="card-body">
 <table class="table table-hover align-middle">
 <thead class="table-dark">
 <tr>
 <th>ID</th>
 <th>Cliente</th>
 <th>Fecha</th>
 <th>Monto</th>
 <th>Cuota</th>
 <th>N° Cuotas</th>
 <th>Tipo</th>
 <th>Estado</th>
 <th class="text-end">Acciones</th>
 </tr>
 </thead>
 <tbody>
 @forelse($creditos as $credito)
 <tr>
 <td>{{ $credito->id }}</td>
 <td>{{ $credito->cliente->nombre ?? 'N/A' }}</td>
 <td>{{ $credito->fecha }}</td>
 <td>${{ number_format($credito->monto, 2) }}</td>
 <td>${{ number_format($credito->cuota, 2) }}</td>
 <td>{{ $credito->ncuotas }}</td>
 <td><span class="badge bg-secondary">{{ $credito->tipo 
}}</span></td>
 <td><span class="badge bg-{{ $credito->estado === 'Activo' ? 'success' : 'secondary' }}">{{ $credito->estado }}</span></td>
 <td class="text-end">
 <a href="{{ route('creditos.show', $credito) }}" class="btn 
btn-info btn-sm text-white">Ver</a>
 @if(auth()->user()->role === 'administrador')
 <a href="{{ route('creditos.edit', $credito) }}" class="btn btn-warning btn-sm">Editar</a>
 <form action="{{ route('creditos.destroy', $credito) }}" 
method="POST" class="d-inline" onsubmit="return confirm('¿Desea eliminar este 
crédito?');">
 @csrf
 @method('DELETE')
<button class="btn btn-danger btn-sm">Eliminar</button>
 </form>
 @endif
 </td>
 </tr>
 @empty
 <tr>
 <td colspan="9" class="text-center">No hay créditos 
registrados.</td>
 </tr>
 @endforelse
 </tbody>
 </table>
 {{ $creditos->links() }}
 </div>
</div>
@endsection