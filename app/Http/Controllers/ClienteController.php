<?php
namespace App\Http\Controllers;
use App\Models\Cliente;
use Illuminate\Http\Request;
class ClienteController extends Controller
{
 public function index()
 {
 $query = Cliente::orderBy('id', 'desc');

 if (auth()->user()->role === 'usuario') {
 $query->where('user_id', auth()->id());
 }

 $clientes = $query->paginate(10);
 return view('clientes.index', compact('clientes'));
 }
 public function create()
 {
 return view('clientes.create');
 }
 public function store(Request $request)
 {
 $request->validate([
 'nombre' => 'required|string|max:255',
 'fechanac' => 'required|date',
 'email' => 'required|email|unique:clientes,email',
 ]);
 Cliente::create($request->all());
 return redirect()->route('clientes.index')
 ->with('success', 'Cliente registrado exitosamente.');
 }
 public function show(Cliente $cliente)
 {
 $this->authorizeClient($cliente);
 $cliente->load('creditos');
 return view('clientes.show', compact('cliente'));
 }
 public function edit(Cliente $cliente)
 {
 return view('clientes.edit', compact('cliente'));
 }
 public function update(Request $request, Cliente $cliente)
 {
 $request->validate([
 'nombre' => 'required|string|max:255',
 'fechanac' => 'required|date',
 'email' => 'required|email|unique:clientes,email,' . $cliente->id,
 ]);
 $cliente->update($request->all());
 return redirect()->route('clientes.index')
 ->with('success', 'Cliente actualizado exitosamente.');
 }
 public function destroy(Cliente $cliente)
 {
 $cliente->delete();
 return redirect()->route('clientes.index')
 ->with('success', 'Cliente eliminado correctamente.');
 }

 private function authorizeClient(Cliente $cliente): void
 {
  abort_unless(
   auth()->user()->role !== 'usuario' || $cliente->user_id === auth()->id(),
   403
  );
 }
}