<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FocoAba3 extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'foco_aba3';

    protected $fillable = [
        'foco_id',
        'dados_analise',
        'proposta_destinacao',
        'justificativa_devolucao',
        'devolucao_para',
    ];

    protected $casts = [
        'dados_analise' => 'array',
        'proposta_destinacao' => 'array',
    ];

    public function foco()
    {
        return $this->belongsTo(Foco::class);
    }
}
