<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Storage;
use Illuminate\Support\Facades\Auth;
use App\Photo;
use App\Album;
use Illuminate\Validation\Rule;
// php artisan make:controller PhotosController --resource  per creare un controller risorsa


class PhotosController extends Controller
{


    public function __construct(){

        // per un resource controller
        // in automatico laravel mapperà tutti i metodi della policy per la risorsa che gli passi
        // cosi non si deve fare manualmente metodo per metodo
        $this->authorizeResource(Photo::class);
    }

    public function rules(Photo $photo){
        return [

            'album_id' => ['required','exists:albums,id'],
            'name' => [
                'required',
                 Rule::unique('photos','name')->ignore(Photo::find($photo->id),'id')
            ],
            'description' => ['required'],
            'img_path' => ['required','image']
        ];
    }

       


    protected $errorMessages = [
        'album_id.required' => 'Il campo "Album" è richiesto',
        'name.required' => 'Il campo "Nome Foto" è richiesto',
        'description.required' => 'Il campo "Descrizione Foto" è richiesto',
        'img_path.required' => 'Il campo "Immagine" è richiesto'
    ];

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $req)
    {
        $id = $req->has('album_id') ? $req->input('album_id') : null;
    
        
        // firstOrNew : se trova un album con quel id lo salva in $album altrimenti crea una nuova istanza di Album
        $album = Album::firstOrNew(['id' => $id]);
        $albums = $this->getAlbums();
        $photo = new Photo();
        return view('photos/editphoto',compact('album','photo','albums'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Photo $photo, Request $req)
    {
        
        // cosi se non passa la validazione noon conttinua il resto delle istruzioni
        $this->validate($req, $this->rules($photo), $this->errorMessages);

        $photo = new Photo();
        $photo->name = $req->input('name');
        $photo->description = $req->input('description');
        $photo->album_id = $req->input('album_id');
        $this->processFile($photo,$req);
        $res = $photo->save();
        if ($res){
            $messaggio = $res ? "Foto inserita" : "Foto non inserita";
            session()->flash('message', $messaggio);
            return redirect()->route('album.getImages',$photo->album_id);
        }
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Photo $photo)
    {

        $albums = $this->getAlbums();
        $album = $photo->album; //gli inettiamo la relazione, cosi abbiamo l'album a cui appartiene la foto 
        // OPPURE  invece di caricare la relazione cosi fare
        // $photo = Photo::with('album')->find($photo) senza il typehint nel metodo
        // dd($album); mi trova l'album a cui appartiene la foto
        return view('photos/editPhoto', compact('photo','albums', 'album'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $req, Photo $photo)
    {
        
        $req->validate($this->rules($photo), $this->errorMessages);

        $this->processFile($photo, $req);
        $photo->name = $req->input('name');
        $photo->description = $req->input('description');
        $photo->album_id = $req->input('album_id');
        $res = $photo->save();
        $messaggio = $res ? "Foto aggiornata" : "Foto non aggiornata";
        session()->flash('message', $messaggio);
        return redirect()->route('album');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Photo $photo)
    {

        $res = $photo->delete();
        if ($res){
            $this->deleteFile($photo);
        }
        
        return '' . $res;
    }

    public function deleteFile(Photo $photo){

        $disk = config('filesystems.default');
        if ($photo->img_path && Storage::disk($disk)->has($photo->img_path)){
            return Storage::disk($disk)->delete($photo->img_path);
        }
        return false;

    }

    public function processFile(Photo $photo, Request $req = null){

        if (!$req){
            $req = request();
        }

        if (!$req->hasFile('img_path')){
            return false;
        }

        $file = $req->file('img_path');

        if (!$file->isValid()){
            return false;
        }

        $filename = $file->store(env('IMG_DIR') .'/' .  $photo->album_id, 'public');

        $photo->img_path = $filename;
        return true;

    }

    public function getAlbums(){

        return Album::orderBy('album_name')->where('user_id', Auth::user()->id)->get();
    }


}
