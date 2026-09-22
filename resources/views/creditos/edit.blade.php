@extends('layouts.app')
@section('title', 'Editar Crédito')
@section('content')
<div class="row justify-content-center">
 <div class="col-md-8">
 <div class="card shadow-sm">
 <div class="card-header bg-warning text-dark">Editar Crédito #{{ $credito->id 
}}</div>
 <div class="card-body">
 <form action="{{ route('creditos.update', $credito) }}" method="POST">
 @csrf
 @method('PUT')
 <div class="mb-3">
 <label for="id_cliente" class="form-label">Cliente</label>
 <select name="id_cliente" id="id_cliente" class="form-select 
@error('id_cliente') is-invalid @enderror" required>
 @foreach($clientes as $cliente)
 <option value="{{ $cliente->id }}" {{ old('id_cliente', $credito->id_cliente) == $cliente->id ? 'selected' : '' }}> {{ $cliente->nombre }} ({{ $cliente->email }})
 </option>
 @endforeach
 </select>
 @error('id_cliente') <div class="invalid-feedback">{{ $message }}</div> @enderror
 </div>
 <div class="mb-3">
 <label for="fecha" class="form-label">Fecha del Crédito</label>
 <input type="date" name="fecha" id="fecha" class="form-control 
@error('fecha') is-invalid @enderror" value="{{ old('fecha', $credito->fecha) }}" 
required>
 @error('fecha') <div class="invalid-feedback">{{ $message }}</div> 
@enderror
 </div>
 <div class="row">
 <div class="col-md-6 mb-3">
 <label for="monto" class="form-label">Monto Total</label>
<input type="number" step="0.01" name="monto" id="monto" 
class="form-control @error('monto') is-invalid @enderror" value="{{ old('monto', $credito->monto) }}" required>
 @error('monto') <div class="invalid-feedback">{{ $message 
}}</div> @enderror
 </div>
 <div class="col-md-6 mb-3">
 <label for="cuota" class="form-label">Valor de Cuota</label>
<input type="number" step="0.01" name="cuota" id="cuota" 
class="form-control @error('cuota') is-invalid @enderror" value="{{ old('cuota', $credito->cuota) }}" required>
 @error('cuota') <div class="invalid-feedback">{{ $message 
}}</div> @enderror
 </div>
 </div>
 <div class="row">
 <div class="col-md-6 mb-3">
 <label for="ncuotas" class="form-label">Número de Cuotas</label>
 <input type="number" name="ncuotas" id="ncuotas" class="form-control @error('ncuotas') is-invalid @enderror" value="{{ old('ncuotas', $credito->ncuotas) }}" required>
 @error('ncuotas') <div class="invalid-feedback">{{ $message }}</div> @enderror
 </div>
 <div class="col-md-6 mb-3">
 <label for="tipo" class="form-label">Tipo de Crédito</label>
<select name="tipo" id="tipo" class="form-select @error('tipo') is-invalid @enderror" required>
 <option value="Personal" {{ old('tipo', $credito->tipo) == 'Personal' ? 'selected' : '' }}>Personal</option>
 <option value="Hipotecario" {{ old('tipo', $credito->tipo) == 'Hipotecario' ? 'selected' : '' }}>Hipotecario</option>
 <option value="Automotriz" {{ old('tipo', $credito->tipo) == 'Automotriz' ? 'selected' : '' }}>Automotriz</option>
 <option value="Comercial" {{ old('tipo', $credito->tipo) == 'Comercial' ? 'selected' : '' }}>Comercial</option>
 </select>
@error('tipo') <div class="invalid-feedback">{{ $message }}</div> @enderror
 </div>
 </div>
 <div class="mb-3">
	<label for="estado" class="form-label">Estado del Crédito</label>
	<select name="estado" id="estado" class="form-select @error('estado') is-invalid @enderror" required>
		<option value="Activo" {{ old('estado', $credito->estado) == 'Activo' ? 'selected' : '' }}>Activo</option>
		<option value="Inactivo" {{ old('estado', $credito->estado) == 'Inactivo' ? 'selected' : '' }}>Inactivo</option>
	</select>
	@error('estado') <div class="invalid-feedback">{{ $message }}</div> @enderror
 </div>
 <button type="submit" class="btn btn-primary">Actualizar Crédito</button>
 <a href="{{ route('creditos.index') }}" class="btn btn-secondary">Cancelar</a>
 </form>
 </div>
 </div>
 </div>
</div>
@endsection
