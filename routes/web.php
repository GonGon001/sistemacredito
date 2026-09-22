<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\CreditoController;
use App\Http\Controllers\UserController;

Route::get('/', function () {
	return auth()->check()
		? redirect()->route('dashboard')
		: view('auth.login');
});

Route::middleware('guest')->group(function () {
	Route::get('/login', [AuthController::class, 'create'])->name('login');
	Route::post('/login', [AuthController::class, 'store'])->name('login.store');
});

Route::post('/logout', [AuthController::class, 'destroy'])
	->middleware('auth')
	->name('logout');

Route::middleware('auth')->group(function () {
	Route::get('/dashboard', function () {
		$cliente = auth()->user()->cliente;
		$cliente?->load('creditos');

		return view('dashboard', compact('cliente'));
	})->name('dashboard');

	Route::middleware('role:administrador,asesor')->group(function () {
		Route::resource('clientes', ClienteController::class)->only(['create', 'store']);
		Route::resource('creditos', CreditoController::class)->only(['create', 'store']);
	});

	Route::resource('clientes', ClienteController::class)->only(['index', 'show']);
	Route::resource('creditos', CreditoController::class)->only(['index', 'show']);
	Route::post('/creditos/{credito}/pagos', [CreditoController::class, 'pay'])->name('creditos.pay');

	Route::middleware('role:administrador')->group(function () {
		Route::get('/usuarios', [UserController::class, 'index'])->name('users.index');
		Route::get('/usuarios/create', [UserController::class, 'create'])->name('users.create');
		Route::post('/usuarios', [UserController::class, 'store'])->name('users.store');
		Route::get('/usuarios/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
		Route::put('/usuarios/{user}', [UserController::class, 'update'])->name('users.update');
		Route::delete('/usuarios/{user}', [UserController::class, 'destroy'])->name('users.destroy');
		Route::resource('clientes', ClienteController::class)->only(['edit', 'update', 'destroy']);
		Route::resource('creditos', CreditoController::class)->only(['edit', 'update', 'destroy']);
	});

});