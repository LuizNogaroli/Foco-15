<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FocoDraft extends Model
{
    protected $fillable = ['processo_id', 'user_id', 'aba', 'data'];
    protected $casts = ['data' => 'array'];
}
