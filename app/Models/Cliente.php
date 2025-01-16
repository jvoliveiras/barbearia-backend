<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;
    
    protected $fillable = ['empresa_id', 'nome', 'cpf', 'celular', 'ativo'];

    public function empresa()
    {
        return $this->belongsTo(Empresa::class);
    }

    public function cartoes()
    {
        return $this->hasMany('App\Models\CartaoFidelidade', 'cliente_id', 'id');
    }
}
