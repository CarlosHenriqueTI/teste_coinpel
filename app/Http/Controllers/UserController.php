<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str; // Importar a classe Str
use Illuminate\Validation\Rules;

class UserController extends Controller
{
    /**
     * Normaliza texto removendo acentos e caracteres especiais
     */
    private function normalizeText($text)
    {
        $text = strtolower(trim($text));
        
        // Remove acentos
        $unwanted = [
            'á' => 'a', 'à' => 'a', 'ã' => 'a', 'â' => 'a', 'ä' => 'a',
            'é' => 'e', 'è' => 'e', 'ê' => 'e', 'ë' => 'e',
            'í' => 'i', 'ì' => 'i', 'î' => 'i', 'ï' => 'i',
            'ó' => 'o', 'ò' => 'o', 'õ' => 'o', 'ô' => 'o', 'ö' => 'o',
            'ú' => 'u', 'ù' => 'u', 'û' => 'u', 'ü' => 'u',
            'ç' => 'c', 'ñ' => 'n'
        ];
        
        return strtr($text, $unwanted);
    }

    public function index(Request $request)
    {
        $query = User::query();
        
        // Se há um termo de pesquisa, filtrar por nome ou email (super flexível)
        if ($search = $request->get('search')) {
            $originalTerm = trim($search);
            $normalizedTerm = $this->normalizeText($originalTerm);
            
            $query->where(function($q) use ($originalTerm, $normalizedTerm) {
                // Busca pelo termo original (case-insensitive)
                $q->whereRaw('LOWER(name) LIKE ?', ['%' . strtolower($originalTerm) . '%'])
                  ->orWhereRaw('LOWER(email) LIKE ?', ['%' . strtolower($originalTerm) . '%']);
                
                // Busca pelo termo normalizado (sem acentos)
                if ($normalizedTerm !== strtolower($originalTerm)) {
                    $q->orWhereRaw('LOWER(name) LIKE ?', ['%' . $normalizedTerm . '%'])
                      ->orWhereRaw('LOWER(email) LIKE ?', ['%' . $normalizedTerm . '%']);
                }
                
                // Busca removendo espaços
                if (str_contains($originalTerm, ' ')) {
                    $termWithoutSpaces = str_replace(' ', '', strtolower($originalTerm));
                    $q->orWhereRaw('LOWER(REPLACE(name, " ", "")) LIKE ?', ['%' . $termWithoutSpaces . '%']);
                }
                
                // Busca por partes separadas
                $searchParts = explode(' ', $normalizedTerm);
                if (count($searchParts) > 1) {
                    foreach ($searchParts as $part) {
                        $part = trim($part);
                        if (strlen($part) > 1) {
                            $q->orWhereRaw('LOWER(name) LIKE ?', ['%' . $part . '%'])
                              ->orWhereRaw('LOWER(email) LIKE ?', ['%' . $part . '%']);
                        }
                    }
                }
            });
        }
        
        $users = $query->latest()->paginate(10)->withQueryString();
        
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

        return redirect()->route('users.index')->with('success', 'Usuário cadastrado com sucesso. A senha temporária é: ' . $temporaryPassword);
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8',
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        if ($request->filled('password')) {
            $user->update([
                'password' => Hash::make($request->password),
                'must_change_password' => false
            ]);
        }

        return redirect()->route('users.index')->with('success', 'Usuário atualizado com sucesso.');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index')->with('success', 'Usuário excluído com sucesso.');
    }
}
