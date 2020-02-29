<?php

use Illuminate\Database\Seeder;
use App\AlbumCategory;
use App\User;

class SeedAlbumCategoriesTable extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $cats =[
            'abstract',
            'animals',
            'city',
            'food',
            'nightlife',
            'nature'
        ];

        foreach ($cats as $cat){
            
            AlbumCategory::create([
                'category_name' => $cat,
                'user_id' => User::inRandomOrder()->first()->id
            ]);
        }
    }
}
