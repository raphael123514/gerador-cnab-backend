<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FundsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('funds')->insert([
            [
                'name' => 'Fundo Alpha', //
                'cnpj' => '12.345.678/0001-01', //
                'corporate_name' => 'Fundo de Investimentos Alpha', //
                'address_street' => 'Rua das Árvores', //
                'address_number' => '123', //
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Fundo Beta', //
                'cnpj' => '98.765.432/0001-02', //
                'corporate_name' => 'Fundo Beta Capital', //
                'address_street' => 'Av. Brasil', //
                'address_number' => '456', //
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Fundo Gama', //
                'cnpj' => '11.222.333/0001-03', //
                'corporate_name' => 'Gama Investimentos Financeiros', //
                'address_street' => 'Alameda Santos', //
                'address_number' => '789', //
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
