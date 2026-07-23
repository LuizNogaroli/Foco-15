<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Foco extends Model
{
    use HasFactory;

    protected $table = 'foco';

    protected $fillable = [
        'processo_id',
        'aba_salva',
    ];

    public function processo()
    {
        return $this->belongsTo(Processo::class);
    }

    public function aba1()
    {
        return $this->hasOne(FocoAba1::class);
    }

    public function aba2()
    {
        return $this->hasOne(FocoAba2::class);
    }

    public function aba3()
    {
        return $this->hasOne(FocoAba3::class);
    }

    public function rips()
    {
        return $this->hasMany(FocoRip::class);
    }

    public function cadastrosMinimos()
    {
        return $this->hasMany(FocoCadastroMinimo::class);
    }
}
