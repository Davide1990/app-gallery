<?php

use Illuminate\Database\Seeder;
use App\User;
// creare una seed per poter alimentare le tabelle di dati: php artisan make:seed SeedUsersTable
// lanciare la seed:  php artisan db:seed --class=SeedUsersTable OPPURE andare nel DatabaseSeeder e
// chiamare la classe con $this->call(nomeClasse::class);

class SeedUsersTable extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        User::truncate();
        factory(User::class,30)->create();
        
    }

   
}




/*
        public function run () {
            $sql='insert into users (name,email,password) ';    
            $sql .= ' values (:name, :email, :password) ';

            for($i=0;$i<29;$i++){
                DB::statement($sql, [
                    'name'=>Str::random(10),
                    'email' =>Str::random(10) . '@gmail.com',
                    'password' =>Hash::make('password'),
                ]);
            }

        }
            
        OPPURE :

        public function run()
        {
        
            User::truncate();

            for($i=0;$i<29;$i++){

                utilizzando sempre la facades DB
                DB::table('users')->insert([
                    'name'=>Str::random(10),
                    'email' =>Str::random(10) . '@gmail.com',
                    'password' =>Hash::make('password'),
                    created_at' => Carbon::now()
                ]);

            }
            
        } 
        */