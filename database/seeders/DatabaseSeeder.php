<?php

namespace Database\Seeders;

use App\Models\CartaoFidelidade;
use App\Models\Empresa;
use App\Models\Cliente;
use App\Models\User;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $empresas = Empresa::factory()->count(10)->create();

        // $user = User::factory()->count(10)->create();

        // $empresas->each(function ($empresa) {

        //     for ($i = 0; $i < 15; $i++) {
        //         $cliente = Cliente::factory()->create([
        //             'empresa_id' => $empresa->id,
        //         ]);

        //         CartaoFidelidade::create([
        //             'cliente_id' => $cliente->id
        //         ]);
        //     }

        // });

        $empresas = Empresa::factory()->count(1)->create();

        $user = User::factory()->count(1)->create();
    }
}
