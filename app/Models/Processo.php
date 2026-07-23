<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Processo extends Model
{
    use HasFactory;

    protected $fillable = [
        'numero_requerimento',
        'status_atual',
        'tipo_requerimento',
        'uf',
        'municipio',
        'tramitacao',
    ];

    public function tramites()
    {
        return $this->hasMany(Tramite::class);
    }

    public function foco()
    {
        return $this->hasOne(Foco::class);
    }

    public function requerimento()
    {
        return $this->hasOne(Requerimento::class, 'numero_requerimento', 'numero_requerimento');
    }
}
