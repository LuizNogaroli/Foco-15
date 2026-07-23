<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FocoAba2 extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'foco_aba2';

    protected $fillable = [
        'foco_id',
        'situacao_ocupacional',
        'tempo_desocupacao',
        'data_conhecimento_ocupacao',
        'tipo_uso_atual',
        'tipo_uso_especifico_atual',
        'ha_incidencia',
        'incidencia_ambiental',
        'ha_riscos',
        'riscos',
        'ha_restricoes',
        'restricoes',
        'latitude',
        'longitude',
        'geo_cep',
        'observacoes_aba2',
    ];

    protected $casts = [
        'ha_incidencia' => 'array',
        'incidencia_ambiental' => 'array',
        'ha_riscos' => 'array',
        'riscos' => 'array',
        'ha_restricoes' => 'array',
        'restricoes' => 'array',
    ];

    public function foco()
    {
        return $this->belongsTo(Foco::class);
    }
}
