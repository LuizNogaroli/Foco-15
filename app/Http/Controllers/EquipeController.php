<?php

namespace App\Http\Controllers;

use App\Models\EquipeServidor;
use App\Models\User;
use App\Imports\ServidoresImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class EquipeController extends Controller
{
    private array $perfis = [
        'Equipe Destinação',
        'Equipe Caracterização',
        'Chefia',
        'Coordenação',
        'Superintendência',
        'Equipe C.G.',
        'Coordenação-Geral',
        'Direção',
        'CDE',
    ];

    private array $ufs = [
        'AC','AL','AP','AM','BA','CE','DF','ES','GO',
        'MA','MT','MS','MG','PA','PB','PR','PE','PI',
        'RJ','RN','RS','RO','RR','SC','SP','SE','TO',
    ];

    public function index(Request $request)
    {
        $uf = $request->input('uf', 'SP');

        $equipe = EquipeServidor::with('user')
            ->where('uf', $uf)
            ->where('ativo', true)
            ->get()
            ->groupBy('perfil');

        $servidores = User::orderBy('name')->get();

        return view('equipe.index', compact('uf', 'equipe', 'servidores'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'perfil' => 'required|string',
            'uf' => 'required|string|size:2',
        ]);

        $existe = EquipeServidor::where('user_id', $request->user_id)
            ->where('perfil', $request->perfil)
            ->where('uf', $request->uf)
            ->where('ativo', true)
            ->exists();

        if ($existe) {
            return back()->with('error', 'Este servidor já está vinculado a esta equipe/UF.');
        }

        EquipeServidor::create([
            'user_id' => $request->user_id,
            'perfil' => $request->perfil,
            'uf' => $request->uf,
            'ativo' => true,
        ]);

        return back()->with('success', 'Servidor adicionado à equipe.');
    }

    public function destroy(EquipeServidor $equipeServidor)
    {
        $equipeServidor->update(['ativo' => false]);

        return back()->with('success', 'Servidor removido da equipe.');
    }

    public function importar(Request $request)
    {
        $request->validate([
            'arquivo' => 'required|file|mimes:xlsx,xls,csv|max:5120',
        ]);

        $import = new ServidoresImport();
        Excel::import($import, $request->file('arquivo'));

        $importados = $import->getImportados();
        $erros = $import->getErros();
        $logErros = $import->getLogErros();

        $msg = "{$importados} servidor(es) importado(s) com sucesso.";
        if ($erros > 0) {
            $msg .= " {$erros} registro(s) com erro: " . implode('; ', array_slice($logErros, 0, 5));
        }

        $tipo = $erros > 0 && $importados === 0 ? 'error' : 'success';
        return back()->with($tipo, $msg);
    }
}
