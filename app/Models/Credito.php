<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Credito extends Model
{
 use HasFactory;
 protected $table = 'creditos';
 protected $fillable = [
 'fecha',
 'monto',
 'id_cliente',
 'cuota',
 'ncuotas',
 'tipo',
 'estado',
 ];
 protected $casts = [
  'monto' => 'decimal:2',
  'cuota' => 'decimal:2',
  'fecha' => 'date',
 ];
 // Relación inversa: Un crédito pertenece a un cliente
 public function cliente()
 {
 return $this->belongsTo(Cliente::class, 'id_cliente');
 }

 public function pagos()
 {
 return $this->hasMany(Pago::class);
 }

 public function saldoPendiente(): float
 {
 return max(0, (float) $this->monto - (float) $this->pagos()->sum('monto'));
 }
}
