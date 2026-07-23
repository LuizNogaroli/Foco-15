<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Processo;

class DashboardController extends Controller
{
    public function index()
    {
        $totalProcessos = Processo::count();
        $viabilidadesConfirmadas = Processo::where('status_atual', 'Aprovado')->count(); 
        $taxaSucesso = $totalProcessos > 0 ? round(($viabilidadesConfirmadas / $totalProcessos) * 100) : 0;
        
        $retidos = Processo::whereIn('status_atual', ['Aguardando SPU'])->count();

        $ufCounts = Processo::selectRaw('uf, count(*) as total')
            ->whereNotNull('uf')
            ->groupBy('uf')
            ->orderByDesc('total')
            ->pluck('total', 'uf')
            ->toArray();

        $tipoCounts = Processo::selectRaw('tipo_requerimento, count(*) as total')
            ->whereNotNull('tipo_requerimento')
            ->groupBy('tipo_requerimento')
            ->pluck('total', 'tipo_requerimento')
            ->toArray();

        // SLAs simulados para manter layout
        $checkpointSLAs = [
            'SPU/UF' => ['soma' => 150, 'count' => 10],
            'Direção' => ['soma' => 45, 'count' => 5],
            'CDE' => ['soma' => 30, 'count' => 2]
        ];
        
        return view('dashboard', compact(
            'totalProcessos',
            'viabilidadesConfirmadas',
            'taxaSucesso',
            'retidos',
            'ufCounts',
            'tipoCounts',
            'checkpointSLAs'
        ));
    }
}
