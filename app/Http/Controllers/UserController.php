<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class UserController extends Controller
{
    public function index(): View
    {
        $users = User::orderBy('name')->get();

        return view('users.index', compact('users'));
    }

    public function create(): View
    {
        return view('users.create');
    }

    public function edit(User $user): View
    {
        return view('users.edit', compact('user'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'role' => ['required', 'in:administrador,asesor,usuario'],
            'fechanac' => ['required_if:role,usuario', 'nullable', 'date'],
        ]);

        if ($validated['role'] === 'usuario') {
            $request->validate([
                'email' => ['unique:clientes,email'],
            ], [
                'email.unique' => 'Este correo ya está registrado como cliente.',
            ]);
        }

        DB::transaction(function () use ($validated) {
            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => $validated['password'],
                'role' => $validated['role'],
            ]);

            if ($user->role === 'usuario') {
                Cliente::create([
                    'user_id' => $user->id,
                    'nombre' => $user->name,
                    'fechanac' => $validated['fechanac'],
                    'email' => $user->email,
                ]);
            }
        });

        return redirect()->route('dashboard')
            ->with('success', 'Usuario creado exitosamente.');
    }

    public function update(Request $request, User $user): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
            'role' => ['required', 'in:administrador,asesor,usuario'],
            'fechanac' => ['required_if:role,usuario', 'nullable', 'date'],
        ]);

        if ($validated['role'] === 'usuario') {
            $request->validate([
                'email' => [
                    Rule::unique('clientes', 'email')->ignore($user->cliente?->id),
                ],
            ], [
                'email.unique' => 'Este correo ya está registrado como cliente.',
            ]);
        }

        DB::transaction(function () use ($validated, $user) {
            $attributes = [
                'name' => $validated['name'],
                'email' => $validated['email'],
                'role' => $validated['role'],
            ];

            if (! empty($validated['password'])) {
                $attributes['password'] = $validated['password'];
            }

            $user->update($attributes);

            if ($user->role === 'usuario') {
                $user->cliente()->updateOrCreate([], [
                    'nombre' => $user->name,
                    'fechanac' => $validated['fechanac'],
                    'email' => $user->email,
                ]);
            } else {
                $user->cliente()->delete();
            }
        });

        return redirect()->route('users.index')
            ->with('success', 'Usuario actualizado exitosamente.');
    }

    public function destroy(User $user): RedirectResponse
    {
        if ($user->is(auth()->user())) {
            return redirect()->route('users.index')
                ->with('error', 'No puedes eliminar tu propia cuenta.');
        }

        $user->delete();

        return redirect()->route('users.index')
            ->with('success', 'Usuario eliminado exitosamente.');
    }
}