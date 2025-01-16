<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartaoFidelidade extends Model
{
    use HasFactory;

    protected $fillable = ['cliente_id', 'qtd_carimbos', 'finalizado'];
}
