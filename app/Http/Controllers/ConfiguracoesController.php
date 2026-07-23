<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;

class ConfiguracoesController extends Controller
{
    public function index()
    {
        $users = User::with('roles')->get();
        
        $isAdmin = auth()->user() && auth()->user()->hasRole('Administrador');
        if (request()->cookie('perfil_simulado') === 'Administrador' || request()->cookie('perfil_simulado') === 'ALL') {
            $isAdmin = true;
        }

        return view('configuracoes', compact('users', 'isAdmin'));
    }

    public function salvar(Request $request)
    {
        $assignments = $request->input('assignments', []);
        
        foreach ($assignments as $uf => $usersList) {
            // No futuro, podemos remover as roles de usuários que saíram da lista.
            // Para o protótipo, vamos iterar e atualizar.
            foreach ($usersList as $item) {
                $user = User::where('name', $item['server'])->first();
                if ($user) {
                    $user->syncRoles([$item['profile']]);
                }
            }
        }
        
        return response()->json(['success' => true]);
    }

    public function atualizarStatusProcesso(Request $request)
    {
        $numero = $request->input('numero_requerimento');
        $novoStatus = $request->input('novo_status');
        $tagFluxo = $request->input('tag_fluxo', 'Normal');

        if ($numero && $novoStatus) {
            $processo = \App\Models\Processo::where('numero_requerimento', $numero)->first();
            if ($processo) {
                $processo->status_atual = $novoStatus;
                if ($tagFluxo) {
                    $processo->tramitacao = $tagFluxo;
                }
                $processo->save();
            } else {
                \App\Models\Processo::create([
                    'numero_requerimento' => $numero,
                    'status_atual' => $novoStatus,
                    'tipo_requerimento' => 'Cessão Gratuita',
                    'uf' => substr($numero, 0, 2),
                    'municipio' => 'Não Informado',
                    'tramitacao' => $tagFluxo ?? 'Normal',
                ]);
            }
        }

        return response()->json(['success' => true]);
    }
}
