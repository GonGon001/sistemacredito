<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_administrator_can_create_a_user_with_any_supported_role(): void
    {
        $administrator = User::factory()->create(['role' => 'administrador']);

        $response = $this->actingAs($administrator)->post(route('users.store'), [
            'name' => 'Nuevo Asesor',
            'email' => 'asesor@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'role' => 'asesor',
        ]);

        $response->assertRedirect(route('dashboard'));
        $this->assertDatabaseHas('users', [
            'email' => 'asesor@example.com',
            'role' => 'asesor',
        ]);
    }

    public function test_non_administrator_cannot_access_user_creation(): void
    {
        $user = User::factory()->create(['role' => 'asesor']);

        $this->actingAs($user)
            ->get(route('users.create'))
            ->assertForbidden();
    }

    public function test_administrator_can_delete_another_user(): void
    {
        $administrator = User::factory()->create(['role' => 'administrador']);
        $user = User::factory()->create(['role' => 'usuario']);

        $this->actingAs($administrator)
            ->delete(route('users.destroy', $user))
            ->assertRedirect(route('users.index'));

        $this->assertDatabaseMissing('users', ['id' => $user->id]);
    }

    public function test_administrator_cannot_delete_their_own_user(): void
    {
        $administrator = User::factory()->create(['role' => 'administrador']);

        $this->actingAs($administrator)
            ->delete(route('users.destroy', $administrator))
            ->assertRedirect(route('users.index'))
            ->assertSessionHas('error');

        $this->assertDatabaseHas('users', ['id' => $administrator->id]);
    }

    public function test_only_administrator_can_edit_users(): void
    {
        $administrator = User::factory()->create(['role' => 'administrador']);
        $advisor = User::factory()->create(['role' => 'asesor']);
        $user = User::factory()->create(['role' => 'asesor']);

        $this->actingAs($administrator)
            ->get(route('users.edit', $user))
            ->assertOk();

        $this->actingAs($advisor)
            ->get(route('users.edit', $user))
            ->assertForbidden();
    }
}