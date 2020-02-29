<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

// php artisan make:migration albums_update_column_name --table albums  
// il comando table  per modificare colonne
// php artisan migrate:fresh significa eliminare tutte le tabelle e lanciare le migrazioni
// php artisan migrate:refresh --seed per fare il rolling back e lanciare di nuovo le migrazioni e anche i seed
class AlbumsUpdateColumnName extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('albums', function (Blueprint $table) {
            $table->string('album_name',200)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('albums', function (Blueprint $table) {
            $table->string('album_name',128)->change();
        });
    }
}
