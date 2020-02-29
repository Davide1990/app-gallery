<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\Album;
use App\User;
use App\Photo;
use Illuminate\Support\Str;
use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$colors  =[
    '0000FF',
    'FF0000',
    'FFFF00',
    '000000',
    '329da8',
    '329da8'
];

$factory->define(User::class, function (Faker $faker) {
    return [
      
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'email_verified_at' => now(),
        'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        'remember_token' => Str::random(10),
          /*
        'name' => 'Davide',
        'email' => 'davide.bord.90@gmail.com',
        'email_verified_at' => now(),
        'password' => 'davidedavide', // password
        'remember_token' => Str::random(10),
        'role' => 'admin'*/
    ];
});



// quando chiami un metodo statico di un modello ti viene restituito un query builder,
// sul quale puoi chiamare i vari metodi

$factory->define(Album::class, function (Faker $faker) use($colors) {
    return [
        'album_name' => $faker->name,
        'description' => $faker->text(128),
        'user_id' => User::inRandomOrder()->first()->id,
        'album_thumb' => 'https://via.placeholder.com/300' . '/' . $faker->randomElement($colors)

    ];
});


$factory->define(Photo::class, function (Faker $faker) use($colors) {
    
    return [
        'name' => $faker->text(64),
        'description' => $faker->text(128),
        'album_id' => 1,
        'img_path' => 'https://via.placeholder.com/300' . '/' . $faker->randomElement($colors)  
        
    ];
});
