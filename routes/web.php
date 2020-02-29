<?php

use App\Photo;
use App\Mail\testEmail;
use App\Album;
use App\Events\NewAlbumCreated;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// i middleware sono delle classi che controllano i nostri dati prima che vengano passati ai metodi
// php artisan route:list  ti da la lista delle rotte




//la class route automaticamente mi passa i segnaposto ai metodi che ho mappato per quella rotta 
Route::get('welcome/{name?}', 'WelcomeController@welcome')
    ->where([
    'name' => '[a-zA-Z]+'
    ]);

/*
Route::get('/{name?}', function($name = '') {
    //return view('welcome');
    return "ciao " . $name;
})->where([
    'name' => '[a-zA-Z]+'
]);


*/

// si controlla se si puo visualizzare un album attraverso la policy view, e si passa la risorsa come secondo parametro
// possiamo mettere un middleware per controllare una policy  
// una volta che supera il controllo sulla policy, allora chiamami il metodo show di albumcontroller
Route::get('/album/{album}', 'AlbumsController@show')->where('id','[0-9]+')->middleware('can:view,album')->name('album.show');

Route::group([
    'middleware' => ['auth','verified'],
    'prefix' => 'dashboard'
    ],
function(){

    
    //Route::get('/home', 'AlbumsController@index')->name('albums');
    Route::get('/', 'AlbumsController@index')->name('albums.list');
    Route::get('/album', 'AlbumsController@index')->name('album');
   
    Route::get('/album/{album}/images', 'AlbumsController@getImages')->where('album','[0-9]+')->name('album.getImages');
    Route::get('/album/create', 'AlbumsController@create')->name('album.create');
    // i middleware che vengono chiamati alle rotte protette da web
    //il metodo delete ha bisogno di un csrf token perche queste rotte sono protette con un token da questo middleware (VerifyCsrfToken che fa parte dei middleware web)
    Route::delete('/album/{id}', 'AlbumsController@delete')->name('album.delete');
    Route::get('/album/{id}/edit', 'AlbumsController@edit')->name('album.edit');
    Route::patch('/album/{id}/edit', 'AlbumsController@store');
    Route::post('/album/save', 'AlbumsController@save')->name('album.save');

    Route::resource('photos', 'PhotosController');
    Route::resource('categories', 'AlbumCategoryController');
});



// php artisan make:auth per permettere a laravel di fornirti tutte le rotte e le view necessarie per 
// l'autenticazione 

Auth::routes(['verify' => true]);

Route::group([
    'prefix' => 'gallery'
],function(){

    Route::get('albums','GalleryController@index')->name('album.gallery');
    Route::get('/','GalleryController@index');
    Route::get('albums/{album}/images','GalleryController@showAlbumImages')->name('album.gallery.images');
    Route::get('albums/category/{category}', 'GalleryController@showAlbumsForCategory')->name('album.gallery.category');
    }   

);


Route::get('/', 'GalleryController@index')->name('home');

/* esempio mail */
// mi creo una classe mailable com php artisan make:mail
// prima verifico i parametri di configurazione su config/mail e su env

Route::get('testEmail', function(){
    \Mail::to('davide@uanweb.it')->send(new testEmail(Auth::user()));
});
//Route::view('testEmail','mail/templateEmail',['username' => 'Davide']);

Route::get('testEvent',function(){
    $album = Album::first();
    event(new NewAlbumCreated($album));
});