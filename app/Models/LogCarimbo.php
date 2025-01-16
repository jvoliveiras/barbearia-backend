<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogCarimbo extends Model
{
    use HasFactory;

    protected $fillable = ['cartao_id', 'referencia', 'usuario_id'];
}
