<?php

use Illuminate\Database\Seeder;
use App\Category;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
         DB::table('categories')->delete(); //si queremos borrarlo todo antes
       
        factory(Category::class,5)->create();
                
        
        DB::table('categories')->insert([
            //'id' => rand(0, 9), si quisiésemos hacer un aleatorio
            'name' => str_random(10),
            'description' => str_random(50),
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
