@extends('layouts.app')
@section('title', 'Nuevo Crédito')
@section('content')
<div class="row justify-content-center">
 <div class="col-md-8">
 <div class="card shadow-sm">
 <div class="card-header bg-primary text-white">Registrar Nuevo Crédito</div>
 <div class="card-body">
 <form action="{{ route('creditos.store') }}" method="POST">
 @csrf
 
 <div class="mb-3">
 <label for="id_cliente" class="form-label">Cliente</label>
 <select name="id_cliente" id="id_cliente" class="form-select 
@error('id_cliente') is-invalid @enderror" required>
 <option value="">-- Seleccione un Cliente --</option>
 @foreach($clientes as $cliente)
 <option value="{{ $cliente->id }}" {{ old('id_cliente') == 
$cliente->id ? 'selected' : '' }}>
 {{ $cliente->nombre }} ({{ $cliente->email }})
 </option>
 @endforeach
 </select>
 @error('id_cliente') <div class="invalid-feedback">{{ $message 
}}</div> @enderror
 </div>
 <div class="mb-3">
 <label for="fecha" class="form-label">Fecha del Crédito</label>
 <input type="date" name="fecha" id="fecha" class="form-control 
@error('fecha') is-invalid @enderror" value="{{ old('fecha', date('Y-m-d')) }}" required>
 @error('fecha') <div class="invalid-feedback">{{ $message }}</div> 
@enderror
 </div>
 <div class="row">
 <div class="col-md-6 mb-3">
 <label for="monto" class="form-label">Monto Total</label>
 <input type="number" step="0.01" name="monto" id="monto" 
class="form-control @error('monto') is-invalid @enderror" value="{{ old('monto') }}" 
required>
 @error('monto') <div class="invalid-feedback">{{ $message 
}}</div> @enderror
 </div>
 <div class="col-md-6 mb-3">
 <label for="cuota" class="form-label">Valor de Cuota</label>
 <input type="number" step="0.01" name="cuota" id="cuota" 
class="form-control @error('cuota') is-invalid @enderror" value="{{ old('cuota') }}" 
required>
 @error('cuota') <div class="invalid-feedback">{{ $message 
}}</div> @enderror
 </div>
 </div>
 <div class="row">
 <div class="col-md-6 mb-3">
 <label for="ncuotas" class="form-label">Número de 
Cuotas</label>
 <input type="number" name="ncuotas" id="ncuotas" class="form-control @error('ncuotas') is-invalid @enderror" value="{{ old('ncuotas') }}" required>
 @error('ncuotas') <div class="invalid-feedback">{{ $message 
}}</div> @enderror
 </div>
 <div class="col-md-6 mb-3">
 <label for="tipo" class="form-label">Tipo de Crédito</label>
<select name="tipo" id="tipo" class="form-select 
@error('tipo') is-invalid @enderror" required>
 <option value="Personal" {{ old('tipo') == 'Personal' ? 
'selected' : '' }}>Personal</option>
 <option value="Hipotecario" {{ old('tipo') == 
'Hipotecario' ? 'selected' : '' }}>Hipotecario</option>
 <option value="Automotriz" {{ old('tipo') == 'Automotriz' 
? 'selected' : '' }}>Automotriz</option>
 <option value="Comercial" {{ old('tipo') == 'Comercial' ? 
'selected' : '' }}>Comercial</option>
 </select>
@error('tipo') <div class="invalid-feedback">{{ $message 
}}</div> @enderror
 </div>
 </div>
 <div class="mb-3">
    <label for="estado" class="form-label">Estado del Crédito</label>
    <select name="estado" id="estado" class="form-select @error('estado') is-invalid @enderror" required>
        <option value="Activo" {{ old('estado') == 'Activo' ? 'selected' : '' }}>Activo</option>
        <option value="Inactivo" {{ old('estado') == 'Inactivo' ? 'selected' : '' }}>Inactivo</option>
    </select>
    @error('estado') <div class="invalid-feedback">{{ $message }}</div> @enderror
 </div>
 <button type="submit" class="btn btn-success">Guardar Crédito</button>
 <a href="{{ route('creditos.index') }}" class="btn btn-secondary">Cancelar</a>
 </form>
 </div>
 </div>
 </div>
</div>
@endsection