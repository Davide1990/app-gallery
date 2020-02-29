<?php

use Illuminate\Database\Seeder;
use App\Album;
use App\CategoryAlbum;
use App\AlbumCategory;

class SeedAlbumsTable extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //create ritorna una collection
        factory(Album::class,10)->create()->each(function($album){
            $cats = AlbumCategory::inRandomOrder()->take(3)->pluck('id'); // in modo da avere una collection solo con id
            $cats->each(function($cats_id) use ($album){
                CategoryAlbum::create([
                    'album_id' =>$album->id,
                    'category_id' => $cats_id
                ]);
            });
        });
    }
}
