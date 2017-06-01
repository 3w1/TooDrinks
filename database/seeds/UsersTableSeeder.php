<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\Models\Pais;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = faker::create();

			for ($i=0; $i < 50; $i++)
			{

					// se genera un id al inserta cada registro
			     \DB::table('users')->insert(array(
			           'name' => $faker->unique()->userName,
			           'email'  => $faker->unique()->freeEmail,
			           'password'  => '1234',
			           'nombre'  => $faker->firstNameMale,
			           'apellido' => $faker->lastName,
			           'direccion' => $faker->address,
			          	'telefono' => $faker->e164PhoneNumber, 
			           'codigo_postal' => $faker->postcode,
			           'pais_id' => '1', 
			           'provincia_region_id' =>'1', 
			          	'avatar' => '54643123123123123123',
			           'estado_datos' => $faker->randomElement(['false', 'true'])

			    ));
			}
    }
}

        

                        