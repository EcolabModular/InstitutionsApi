<?php

use App\Institution;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();

        Institution::create([
            'name' => 'Centro Universitario de Ciencias Exactas e Ingenierías',
            'description' => 'El Centro Universitario de Ciencias Exactas e Ingenierías (CUCEI) es la división de la Universidad de Guadalajara en México destinada a la educación superior relacionada con los campos de ingenierías, ciencias físicas, químicas y matemáticas.',
            'address' => 'Blvd. Gral. Marcelino García Barragán 1421, Olímpica, 44430 Guadalajara, Jal.',
            'acronym' => 'CUCEI',
            'logo' => url('/') . '/instiphotos/cucei.png',
        ]);

        Institution::create([
            'name' => 'Centro Universitario de Ciencias Económico Administrativas',
            'description' => 'El Centro Universitario de Ciencias Económico-Administrativas (CUCEA), es la división de la Universidad de Guadalajara en México destinada a la educación superior relacionada con los campos de la economía, administración de empresas y ciencias complementarias.',
            'address' => 'Periférico Norte N° 799 Núcleo Universitario, Los Belenes, 45100 Zapopan, Jal.',
            'acronym' => 'CUCEA',
            'logo' => url('/') . '/instiphotos/cucea.png',
        ]);
    }
}
