<?php
namespace App\Http\Controllers;
use App\Models\Credito;
use App\Models\Cliente;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
class CreditoController extends Controller
{
 public function index()
 {
 // Carga ansiosa (eager loading) de la relación cliente
 $query = Credito::with('cliente')->orderBy('id', 'desc');

 if (auth()->user()->role === 'usuario') {
 $query->whereHas('cliente', function ($clienteQuery) {
  $clienteQuery->where('user_id', auth()->id());
 });
 }

 $creditos = $query->paginate(10);
 return view('creditos.index', compact('creditos'));
 }
 public function create()
 {
 $clientes = Cliente::orderBy('nombre', 'asc')->get();
 return view('creditos.create', compact('clientes'));
 }
 public function store(Request $request)
 {
 $request->validate([
 'fecha' => 'required|date',
 'monto' => 'required|numeric|min:0',
 'id_cliente' => 'required|exists:clientes,id',
 'cuota' => 'required|numeric|min:0',
 'ncuotas' => 'required|integer|min:1',
 'tipo' => 'required|string|max:50',
 'estado' => 'required|string|max:50',
 ]);
 Credito::create($request->all());
 return redirect()->route('creditos.index')
 ->with('success', 'Crédito otorgado exitosamente.');
 }
 public function show(Credito $credito)
 {
 $this->authorizeCredit($credito);
    $credito->load(['cliente', 'pagos' => fn ($query) => $query->latest('fecha')]);
 return view('creditos.show', compact('credito'));
 }

 public function pay(Request $request, Credito $credito)
 {
   abort_unless(
    auth()->user()->role === 'usuario' && $credito->cliente?->user_id === auth()->id(),
    403
   );

    $validated = $request->validate([
     'monto' => ['required', 'numeric', 'gt:0'],
     'fecha' => ['required', 'date'],
    ]);

    $saldo = $credito->saldoPendiente();
    abort_if((float) $validated['monto'] > $saldo, 422, 'El pago no puede superar el saldo pendiente.');

    DB::transaction(function () use ($credito, $validated) {
     $credito->pagos()->create($validated);
    });

    return redirect()->route('creditos.show', $credito)
     ->with('success', 'Pago registrado correctamente.');
 }
 public function edit(Credito $credito)
 {
 $clientes = Cliente::orderBy('nombre', 'asc')->get();
 return view('creditos.edit', compact('credito', 'clientes'));
 }
 public function update(Request $request, Credito $credito)
 {
 $request->validate([
 'fecha' => 'required|date',
 'monto' => 'required|numeric|min:0',
 'id_cliente' => 'required|exists:clientes,id',
 'cuota' => 'required|numeric|min:0',
 'ncuotas' => 'required|integer|min:1',
 'tipo' => 'required|string|max:50',
 'estado' => 'required|string|max:50',
 ]);
 $credito->update($request->all());
 return redirect()->route('creditos.index')
 ->with('success', 'Crédito actualizado correctamente.');
 }
 public function destroy(Credito $credito)
 {
 $credito->delete();
 return redirect()->route('creditos.index')
 ->with('success', 'Crédito eliminado correctamente.');
 }

 private function authorizeCredit(Credito $credito): void
 {
  abort_unless(
   auth()->user()->role !== 'usuario' || $credito->cliente?->user_id === auth()->id(),
   403
  );
 }
}
