<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FocoRip extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'foco_rips';

    protected $fillable = [
        'foco_id',
        'numero_rip',
    ];

    public function foco()
    {
        return $this->belongsTo(Foco::class);
    }
}
