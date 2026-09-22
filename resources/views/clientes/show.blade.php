@extends('layouts.app')
@section('title', 'Detalle de Cliente')
@section('content')
<div class="card shadow-sm mb-4">
 <div class="card-header bg-info text-white">Información del Cliente</div>
 <div class="card-body">
 <p><strong>ID:</strong> {{ $cliente->id }}</p>
 <p><strong>Nombre:</strong> {{ $cliente->nombre }}</p>
 <p><strong>Fecha Nacimiento:</strong> {{ $cliente->fechanac }}</p>
 <p><strong>Email:</strong> {{ $cliente->email }}</p>
 <a href="{{ route('clientes.index') }}" class="btn btn-secondary">Volver al 
Listado</a>
 </div>
</div>
<h4>Créditos Asociados</h4>
<div class="card shadow-sm">
 <div class="card-body">
 <table class="table table-bordered align-middle">
 <thead class="table-light">
 <tr>
 <th>ID Crédito</th>
 <th>Fecha</th>
 <th>Monto</th>
 <th>Cuota</th>
 <th>N° Cuotas</th>
 <th>Tipo</th>
 <th>Estado</th>
 </tr>
 </thead>
 <tbody>
 @forelse($cliente->creditos as $credito)
 <tr>
 <td>{{ $credito->id }}</td>
 <td>{{ $credito->fecha }}</td>
 <td>${{ number_format($credito->monto, 2) }}</td>
 <td>${{ number_format($credito->cuota, 2) }}</td>
 <td>{{ $credito->ncuotas }}</td>
 <td>{{ $credito->tipo }}</td>
 <td>{{ $credito->estado }}</td>
 </tr>
 @empty
 <tr>
 <td colspan="7" class="text-center">Este cliente no posee créditos 
registrados.</td>
 </tr>
 @endforelse
 </tbody>
 </table>
 </div>
</div>
@endsection