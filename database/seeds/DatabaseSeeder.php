<?php

use Illuminate\Database\Seeder;
use App\User;
use App\AlbumCategory;
use App\Album;
use App\Photo;
use App\CategoryAlbum;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // per disabilitare un attimo le foreign keys: DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // questo lo chiami quando fai php artisan db:seed senza specificare quale seed vuoi lanciare
     
        // $this->call(UsersTableSeeder::class);
        $this->call(SeedUsersTable::class);
        $this->call(SeedAlbumCategoriesTable::class); // lo mettiamo prima di album perchè nel seeder di album avremo bisogno della categoria per popolare la tabella pivot
        $this->call(SeedAlbumsTable::class);
        $this->call(SeedPhotosTable::class);
       
    }
}
