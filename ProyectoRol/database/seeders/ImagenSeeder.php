<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Aventura;

class AventuraSeeder extends Aventura
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Aventura::factory()->count(20)->create();
    }
}
