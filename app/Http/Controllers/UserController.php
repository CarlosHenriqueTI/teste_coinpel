<?php
// app/Http/Controllers/UserController.php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str; // Importar a classe Str
use Illuminate\Validation\Rules;

class UserController extends Controller
{
    public function index()
    {
        $users = User::latest()->paginate(10);
        return view('users.index', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
        ]);

        // Gera uma senha aleatória e segura
        $temporaryPassword = Str::password(12);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($temporaryPassword),
            'must_change_password' => true, // Força a troca de senha no primeiro login
        ]);

        // Opcional: Você pode exibir a senha temporária para o admin ou enviá-la por e-mail
        // Por agora, vamos apenas redirecionar com uma mensagem de sucesso.
        return redirect()->route('users.index')->with('success', 'Usuário cadastrado com sucesso. A senha temporária é: ' . $temporaryPassword);
    }

    public function update(Request $request, User $user)
    {
        // A lógica de atualização permanece a mesma
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
        ]);

        $user->update($request->only('name', 'email'));

        return redirect()->route('users.index')->with('success', 'Usuário atualizado com sucesso.');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index')->with('success', 'Usuário excluído com sucesso.');
    }
}
