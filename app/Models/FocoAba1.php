<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FocoAba1 extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'foco_aba1';

    protected $fillable = [
        'foco_id',
        'conceituacao_imovel',
        'resposta_devolucao',
        'solicitacao_criacao_rip',
    ];

    public function foco()
    {
        return $this->belongsTo(Foco::class);
    }
}
