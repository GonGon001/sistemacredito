<!DOCTYPE html>
<html lang="es">
<head>
 <meta charset="UTF-8">
 <meta name="viewport" content="width=device-width, initial-scale=1.0">
 <title>@yield('title', 'Sistema de Créditos')</title>
 <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" 
rel="stylesheet">
</head>
<body class="bg-light">
 <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
 <div class="container">
 <a class="navbar-brand" href="{{ route('dashboard') }}">Sistema de Créditos</a>
 <div class="collapse navbar-collapse">
 <ul class="navbar-nav me-auto mb-2 mb-lg-0">
 <li class="nav-item"><a class="nav-link" href="{{ route('clientes.index') }}">Clientes</a></li>
 <li class="nav-item"><a class="nav-link" href="{{ route('creditos.index') }}">Créditos</a></li>
 @if(auth()->user()->role === 'administrador')
 <li class="nav-item"><a class="nav-link" href="{{ route('users.index') }}">Usuarios</a></li>
 @endif
 </ul>
 <span class="navbar-text me-3">{{ auth()->user()->name }} ({{ ucfirst(auth()->user()->role) }})</span>
 <form method="POST" action="{{ route('logout') }}">
  @csrf
  <button type="submit" class="btn btn-outline-light btn-sm">Cerrar sesión</button>
 </form>
 </div>
 </div>
 </nav>
 <div class="container">
 @if(session('success'))
 <div class="alert alert-success alert-dismissible fade show" role="alert">
 {{ session('success') }}
 <button type="button" class="btn-close" data-bs-dismiss="alert" arialabel="Close"></button>
 </div>
 @endif
 @if(session('error'))
 <div class="alert alert-danger alert-dismissible fade show" role="alert">
 {{ session('error') }}
 <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
 </div>
 @endif
 @yield('content')
 </div>
 <script 
src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></scrip
t>
</body>
</html>