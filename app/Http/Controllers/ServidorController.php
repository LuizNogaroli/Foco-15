<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\EquipeServidor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ServidorController extends Controller
{
    private array $ufs = [
        'AC','AL','AP','AM','BA','CE','DF','ES','GO',
        'MA','MT','MS','MG','PA','PB','PR','PE','PI',
        'RJ','RN','RS','RO','RR','SC','SP','SE','TO',
    ];

    public function index(Request $request)
    {
        $busca = $request->input('busca');
        $uf = $request->input('uf');

        $query = User::orderBy('name');

        if ($busca) {
            $query->where(function ($q) use ($busca) {
                $q->where('name', 'like', "%{$busca}%")
                  ->orWhere('email', 'like', "%{$busca}%")
                  ->orWhere('cpf', 'like', "%{$busca}%");
            });
        }

        if ($uf) {
            $query->where('uf', $uf);
        }

        $servidores = $query->paginate(20)->withQueryString();
        $ufs = $this->ufs;

        return view('servidores.index', compact('servidores', 'ufs', 'busca', 'uf'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'cpf' => 'required|string|size:11|unique:users,cpf',
            'cargo' => 'nullable|string|max:255',
            'telefone' => 'nullable|string|max:20',
            'uf' => 'nullable|string|size:2',
            'password' => 'required|string|min:8|confirmed',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'cpf' => $request->cpf,
            'cargo' => $request->cargo,
            'telefone' => $request->telefone,
            'uf' => $request->uf,
            'password' => Hash::make($request->password),
        ]);

        return back()->with('success', 'Servidor criado com sucesso.');
    }

    public function edit(User $user)
    {
        $ufs = $this->ufs;
        $equipes = EquipeServidor::where('user_id', $user->id)
            ->where('ativo', true)
            ->get();

        return view('servidores.edit', compact('user', 'ufs', 'equipes'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'cpf' => 'required|string|size:11|unique:users,cpf,' . $user->id,
            'cargo' => 'nullable|string|max:255',
            'telefone' => 'nullable|string|max:20',
            'uf' => 'nullable|string|size:2',
        ]);

        $user->update($request->only('name', 'email', 'cpf', 'cargo', 'telefone', 'uf'));

        if ($request->input('password')) {
            $request->validate(['password' => 'string|min:8|confirmed']);
            $user->update(['password' => Hash::make($request->password)]);
        }

        return back()->with('success', 'Servidor atualizado com sucesso.');
    }

    public function destroy(User $user)
    {
        $user->equipes()->update(['ativo' => false]);
        $user->delete();

        return redirect()->route('servidores.index')->with('success', 'Servidor removido.');
    }
}
