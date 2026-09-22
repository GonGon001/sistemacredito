<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration
{
 public function up(): void
 {
 Schema::create('creditos', function (Blueprint $table) {
 $table->id();
 $table->date('fecha');
 $table->decimal('monto', 10, 2);
 $table->foreignId('id_cliente')->constrained('clientes')->onDelete('cascade');
 $table->decimal('cuota', 10, 2);
 $table->integer('ncuotas');
 $table->string('tipo', 50);
 $table->string('estado', 50)->default('Activo');
 $table->timestamps();
 });
 }
 public function down(): void
 {
 Schema::dropIfExists('creditos');
 }
};
