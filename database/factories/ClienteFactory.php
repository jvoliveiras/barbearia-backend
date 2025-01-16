<?php

namespace Database\Factories;

use App\Models\Cliente;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ClienteFactory extends Factory
{
    public function definition()
    {
        return [
            'nome' => $this->faker->word,
            // CPF com 9 dígitos
            'cpf' => $this->faker->numerify('#########'), 
            // Celular no formato (27) 9XXXX-XXXX
            'celular' => '(27) 9' . $this->faker->numerify('####-####'), 
            'ativo' => 1,
        ];
    }
}
