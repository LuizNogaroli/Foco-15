<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Tramite extends Model
{
    use HasFactory;

    protected $fillable = [
        'processo_id',
        'etapa',
        'acao',
        'usuario_id',
        'justificativa',
        'dados_snapshot',
    ];

    protected $casts = [
        'dados_snapshot' => 'array',
    ];

    public function processo()
    {
        return $this->belongsTo(Processo::class);
    }

    public function usuario()
    {
        return $this->belongsTo(User::class);
    }
}
