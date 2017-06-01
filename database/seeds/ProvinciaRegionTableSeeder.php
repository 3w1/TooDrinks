<?php

use Illuminate\Database\Seeder;
use App\Models\Pais;
use Faker\Factory as Faker;

class ProvinciaRegionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        for($i = 0; $i < 50; $i ++) 
	    	{
	    		\DB::table('provincia_region')->insert(array( 
	            	'provincia'=> $faker->state,
	            	'region'=> $faker->stateAbbr,
	            	'pais_id'=> '1' 
	            		
	            	));
	    	}
	}
}
    