<?php

namespace Tests\Feature;

use App\Models\Cliente;
use App\Models\Credito;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CreditPaymentTest extends TestCase
{
    use RefreshDatabase;

    public function test_client_can_pay_their_credit_and_balance_is_reduced(): void
    {
        $user = User::factory()->create(['role' => 'usuario']);
        $cliente = Cliente::create([
            'user_id' => $user->id,
            'nombre' => 'Cliente de prueba',
            'fechanac' => '1990-01-01',
            'email' => 'cliente@example.com',
        ]);
        $credito = Credito::create([
            'fecha' => '2026-09-01',
            'monto' => 1000,
            'id_cliente' => $cliente->id,
            'cuota' => 100,
            'ncuotas' => 10,
            'tipo' => 'Personal',
            'estado' => 'Activo',
        ]);

        $this->actingAs($user)
            ->post(route('creditos.pay', $credito), [
                'monto' => 250,
                'fecha' => '2026-09-22',
            ])
            ->assertRedirect(route('creditos.show', $credito));

        $this->assertDatabaseHas('pagos', [
            'credito_id' => $credito->id,
            'monto' => 250,
            'fecha' => '2026-09-22',
        ]);
        $this->assertSame(750.0, $credito->fresh()->saldoPendiente());
    }

    public function test_client_cannot_pay_more_than_the_pending_balance(): void
    {
        $user = User::factory()->create(['role' => 'usuario']);
        $cliente = Cliente::create([
            'user_id' => $user->id,
            'nombre' => 'Cliente de prueba',
            'fechanac' => '1990-01-01',
            'email' => 'cliente2@example.com',
        ]);
        $credito = Credito::create([
            'fecha' => '2026-09-01',
            'monto' => 1000,
            'id_cliente' => $cliente->id,
            'cuota' => 100,
            'ncuotas' => 10,
            'tipo' => 'Personal',
            'estado' => 'Activo',
        ]);

        $this->actingAs($user)
            ->post(route('creditos.pay', $credito), [
                'monto' => 1000.01,
                'fecha' => '2026-09-22',
            ])
            ->assertStatus(422);

        $this->assertDatabaseCount('pagos', 0);
    }

    public function test_client_cannot_pay_another_clients_credit(): void
    {
        $user = User::factory()->create(['role' => 'usuario']);
        $owner = User::factory()->create(['role' => 'usuario']);
        $cliente = Cliente::create([
            'user_id' => $owner->id,
            'nombre' => 'Otro cliente',
            'fechanac' => '1990-01-01',
            'email' => 'cliente3@example.com',
        ]);
        $credito = Credito::create([
            'fecha' => '2026-09-01',
            'monto' => 1000,
            'id_cliente' => $cliente->id,
            'cuota' => 100,
            'ncuotas' => 10,
            'tipo' => 'Personal',
            'estado' => 'Activo',
        ]);

        $this->actingAs($user)
            ->post(route('creditos.pay', $credito), [
                'monto' => 100,
                'fecha' => '2026-09-22',
            ])
            ->assertForbidden();
    }
}