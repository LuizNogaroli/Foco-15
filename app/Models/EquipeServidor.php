<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EquipeServidor extends Model
{
    use HasFactory;

    protected $table = 'equipe_servidores';

    protected $fillable = [
        'user_id',
        'perfil',
        'uf',
        'ativo',
    ];

    protected $casts = [
        'ativo' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
