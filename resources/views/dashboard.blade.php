@extends('layouts.app')

@section('title', 'Panel principal')

@section('content')
<div class="py-4">
    <h1 class="h3">Panel principal</h1>
    <p class="text-secondary">Bienvenido, {{ auth()->user()->name }}. Tu rol es <strong>{{ ucfirst(auth()->user()->role) }}</strong>.</p>

    @if(auth()->user()->role === 'usuario')
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-info text-white">Mi estado</div>
        <div class="card-body">
            @if($cliente)
            <p><strong>Nombre:</strong> {{ $cliente->nombre }}</p>
            <p><strong>Correo:</strong> {{ $cliente->email }}</p>
            <p><strong>Créditos:</strong> {{ $cliente->creditos->count() }}</p>
            <a href="{{ route('clientes.show', $cliente) }}" class="btn btn-primary">Ver mi estado</a>
            <a href="{{ route('creditos.index') }}" class="btn btn-outline-primary">Ver mis créditos</a>
            @else
            <p class="mb-0 text-muted">Tu cuenta todavía no tiene un cliente asociado.</p>
            @endif
        </div>
    </div>
    @endif
</div>
@endsection