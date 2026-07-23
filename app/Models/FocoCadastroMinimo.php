<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FocoCadastroMinimo extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'foco_cadastros_minimos';

    protected $fillable = [
        'foco_id',
        'cep',
        'logradouro',
        'numero',
        'complemento',
        'municipio',
        'uf',
        'area',
        'observacoes',
    ];

    public function foco()
    {
        return $this->belongsTo(Foco::class);
    }
}
