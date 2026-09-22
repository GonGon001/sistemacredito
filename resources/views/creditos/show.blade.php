@extends('layouts.app')
@section('title', 'Detalle de Crédito')
@section('content')
<div class="row justify-content-center">
 <div class="col-md-8">
 <div class="card shadow-sm">
 <div class="card-header bg-info text-white">Información del Crédito #{{ 
$credito->id }}</div>
 <div class="card-body">
 <p><strong>Cliente:</strong> {{ $credito->cliente->nombre ?? 'N/A' }} ({{ 
$credito->cliente->email ?? 'N/A' }})</p>
 <p><strong>Fecha:</strong> {{ $credito->fecha }}</p>
 <p><strong>Monto Total:</strong> ${{ number_format($credito->monto, 2) 
}}</p>
 <p><strong>Total Pagado:</strong> ${{ number_format($credito->pagos->sum('monto'), 2) }}</p>
 <p><strong>Saldo Pendiente:</strong> ${{ number_format($credito->saldoPendiente(), 2) }}</p>
 <p><strong>Valor de Cuota:</strong> ${{ number_format($credito->cuota, 2) 
}}</p>
 <p><strong>Número de Cuotas:</strong> {{ $credito->ncuotas }}</p>
 <p><strong>Tipo de Crédito:</strong> {{ $credito->tipo }}</p>

 @if(session('success'))
 <div class="alert alert-success">{{ session('success') }}</div>
 @endif

 @if(auth()->user()->role === 'usuario' && $credito->saldoPendiente() > 0)
 <hr>
 <h5>Realizar pago</h5>
 <form action="{{ route('creditos.pay', $credito) }}" method="POST" class="row g-3 mb-4">
  @csrf
  <div class="col-md-5">
   <label for="monto" class="form-label">Monto</label>
   <input type="number" name="monto" id="monto" class="form-control" min="0.01" max="{{ $credito->saldoPendiente() }}" step="0.01" value="{{ old('monto') }}" required>
   @error('monto') <div class="text-danger">{{ $message }}</div> @enderror
  </div>
  <div class="col-md-5">
   <label for="fecha" class="form-label">Fecha</label>
   <input type="date" name="fecha" id="fecha" class="form-control" value="{{ old('fecha', now()->toDateString()) }}" required>
   @error('fecha') <div class="text-danger">{{ $message }}</div> @enderror
  </div>
  <div class="col-md-2 d-flex align-items-end">
   <button type="submit" class="btn btn-success w-100">Pagar</button>
  </div>
 </form>
 @endif

 <h5>Historial de pagos</h5>
 <table class="table table-sm">
  <thead><tr><th>Fecha</th><th class="text-end">Monto</th></tr></thead>
  <tbody>
  @forelse($credito->pagos as $pago)
   <tr><td>{{ $pago->fecha->format('Y-m-d') }}</td><td class="text-end">${{ number_format($pago->monto, 2) }}</td></tr>
  @empty
   <tr><td colspan="2">Aún no hay pagos registrados.</td></tr>
  @endforelse
  </tbody>
 </table>
 
 <a href="{{ route('creditos.index') }}" class="btn btn-secondary">Volver 
al Listado</a>
 </div>
 </div>
 </div>
</div>
@endsection