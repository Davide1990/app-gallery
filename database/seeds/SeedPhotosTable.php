<?php

use Illuminate\Database\Seeder;
use App\Photo;
use App\Album;


class SeedPhotosTable extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       
        //If you wish to truncate the entire table, which will remove all rows 
        // and reset the auto-incrementing ID to zero, you may use the truncate method:
        Photo::truncate();
        $albums=Album::get();
        foreach ($albums as $album){
            factory(Photo::class,20)->create([
                'album_id' => $album->id
            ]);

        }
    }
}
