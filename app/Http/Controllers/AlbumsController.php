<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers;
use DB;
use App\Album;
use App\AlbumCategory;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use App\Photo;
use App\Http\Requests\AlbumRequest;
use App\Http\Requests\AlbumUpdateRequest;
use function config;
use App\Events\NewAlbumCreated;

class AlbumsController extends Controller
{

    /*
    un altro modo per verificare l'autorizzazzione
    public function __construct()
    {
        $this->middleware('auth');
        OPPURE solo per un metodo del controller
        $this->middleware('auth')->only('create')
        OPPURE per piu metodi 
        $this->middleware('auth')->only(['create','edit'])
        OPPURE se vuoou escluderne 
        $this->middleware('auth')->except(['create','edit'])
    }
    */

    // per validare i dati con una request si usa php artisan make:request AlbumRequest
    // e poi utilizzare come typehint AlbumRequest invece di Request

    public function processFile($id, $req, &$album){


        if(!$req->hasFile('album_thumb')){
            return false;
        }

            $file = $req->file('album_thumb');

            if (!$file->isValid()){
                return false;
                
            }
            $fileName= $file->store(env('ALBUM_THUMB_DIR'), 'public');

            $album->album_thumb = $fileName;

            return true;
            /*
            oppure
            $fileName = $id . '.' . $file->extension();
            $file->storeAs(env('ALBUM_THUMB_DIR'), $fileName, 'public');
            */
            
           
            
        
    }

    public function index(Request $request){

        /*
        $sql='select * from albums where 1=1';
        $where = [];

        if ($request->has('id')){
            $where['id'] = $request->get('id');
            $sql .= ' and id=? ';
        }

        if ($request->has('album_name')){
            $where['album_name'] = $request->get('album_name');
            $sql .= ' and album_name=? ';
        }
        // select ci ritorna un array di record e ogni record è una standard classe le cui proprietà
        // sono le colonne della tabella 
        // $sql .= ' where id=' . $request->get('id'); se c'è un numero basta fare il cast a int e non hai il rischio di sql injection
        $albums = DB::select($sql, array_values($where));
        return view('album/album', ['albums' => $albums]);
        */

        /* CON QUERY BUILDER */

        /*
        $queryBuilder = DB::table('albums')->orderBy('id','DESC');

        if ($request->has('id')){
            $queryBuilder->where('id','=',$request->get('id'));
        }

        if ($request->has('album_name')){
            $queryBuilder->where('album_name','like', '%' . $request->input('album_name'). '%') ;
        }

        $albums = $queryBuilder->get();  // il get restituisce una collezione

        */

        /* OPPURE CON MODEL */

        $queryBuilder = Album::orderBy('id','DESC')->withCount('photos')->with('categories');
        $queryBuilder->where('user_id', Auth::user()->id);
        
        // abbiamo accesso ai dati dell'utente dalla request o con la facades Auth
        // l'utente viene iniettato direttamento nella request
        //dd($request->user());
        $albums = $queryBuilder->get();
        return view('album/album')->with('albums', $albums) ;
    }

    public function show(Album $album){
        /*
        $sql = ' select * from albums where id = :id';
        $singolo = DB::select($sql, ['id' => $id]);
        //return redirect()->back();
        */

        $singolo = Album::find($album->id);
        
        return view('album/singolo')->with('singolo', $singolo);

    }


    public function getImages(Album $album){
        // Route model binding 
        // dato che il parametro $album è di tipo  Album e il nome di variabile corrisponde a quello nella
        // rotta, Laravel inietterà automaticamente l'istanza del modello che ha un ID corrispondente
        // al valore corrispondente dall'URI della richiesta.
        
        $photos = Photo::where('album_id', $album->id)->latest()->paginate(env('IMG_PER_PAGE'));
        return view('photos/imagesAlbum',compact('album','photos'));

    }


    public function delete($id){

        /*
        $sql = ' delete from albums where id = :id';
        return DB::delete($sql, ['id' => $id]);
        //return redirect()->back();
        */

         /* CON QUERY BUILDER */

         /*
        $res = DB::table('albums')->where('id',$id)->delete();
        return $res;
        */

        /* OPPURE */
        // $res = Album::where('id',$id)->delete();
         /* OPPURE */
        // questo metodo però ritorna o true o false, il metodo sopra invece restituisce 1 se cancella il record
        // e la response di javascript non accetta un valore booleano, ma di tipo stringa

        $album = Album::find($id);

        /*
        if (Gate::denies('manage-album',$album)){
            abort(401,'Unouthorized');
        }
        */

        $this->authorize('update',$album);
        // OPPURE 
        //Auth::user()->can('update',$album);

        $disk = config('filesystems.default'); // vado a leggermi il disco di default nel filesystem
        $res = $album->delete();
        $thumbnail = $album->album_thumb;
        if ($res) {
            if ($thumbnail && Storage::disk($disk)->has($thumbnail)){
                Storage::disk($disk)->delete($thumbnail);
            }
        }
        if (request()->ajax()){
            
            return response()->json(['response' => ''.$res]);  // fai il cast a stringa cosi
        } else {
            return redirect()->route('album');
        }
        
    }

    public function edit($id){

        /*
        $sql="select album_name, description from albums where id=:id";
        $album = DB::select($sql, ['id' => $id]);
        return view('album/edit')->with('album', $album[0]);
        */
        $album = Album::find($id);

        // per proteggere gli accessi alle risorse si possono utilizzare i Gate oppure le Policy
        // i Gate li definisci sotto providers/authserviceprovider nel metodo boot
        // se la condizione che c'è di la nel gate risulta false allora fammi un abort  
        // Le Policy le crei con php artisan make:policy AlbumPolicy --model=Album
        // e poi devi registrarla in AuthserviceProvider su $policies
        // e poi le usi con $this->authorize('update', $album)


        $this->authorize($album);
        /*
        if (Gate::denies('manage-album',$album)){
            abort(401,'Non autorizzato');
        }
        */

        $categories = AlbumCategory::get();
        $selectedCategories = $album->categories->pluck('id')->toArray();
        /*dd ($selectedCategories); array:2 [
                    0 => 2
                    1 => 6
                ] */

        return view('album/edit')->with([
            'album' => $album,
            'categories' => $categories,
            'selectedCategories' => $selectedCategories
            ]
        );

    }

    public function store($id, AlbumUpdateRequest $req){

       /*
        $data=$req->only(['name','description']);
        $data['id'] = $id;
        $sql=" update albums set album_name=:name, description=:description ";
        $sql .= " where id=:id";
      
        $album = DB::update($sql,$data);
        */

        $album = Album::find($id); 
        /*
        if (Gate::denies('manage-album',$album)){
            abort(401,'Unouthorized');
        }
        */
        $this->authorize($album);
        $album->album_name = $req->input('name');
        $album->description = $req->input('description');
        $album->user_id = $req->user()->id;
        

        $this->processFile($id, $req, $album);

        $album->save(); // con il model vai a modificare in automatico la colonna updated at quindi 
        // restituirà sempre 1 e dunque il messaggio darà sempre "album aggiornato", mentre con la 
        // facade DB  DB::update($sql,$data) se non aggiorni non vai a toccare nessna colonna e quindi
        // se non aggiorni nessuna colonna ti darà 0 e il messaggio "album non aggiornato"
        //dd($res); $res restituisce true o false

        // sincronizza i valori che ci sono con i nuovi valori, cioè gli id che non sono presenti 
        // nella lista di categorie che inviamo vengono eliminati e  i nuovi id inseriti
        $album->categories()->sync($req->input('categories'));

        $messaggio = $album ? "Album aggiornato" : "Album non aggiornato";
        session()->flash('message', $messaggio);
        return redirect()->route('album');
       



    }

    public function create(){

       
       $album = new Album();
       $this->authorize($album);
       $categories = AlbumCategory::get();
        return view('album/create', [
            'album' => $album,
            'categories' => $categories,
            'selectedCategories' => []
            ]);
    }

    public function save(AlbumRequest $req){

        /*
        $sql = 'insert into albums (album_name, description, user_id) ';
        $sql.= ' values (:name, :description, :user_id) ' ;
        $data = request()->only('name', 'description');
        $data['user_id'] = 1;
        $album = DB::insert($sql,$data);
        */

        /*
        $album = DB::table('albums')->insert([
            'album_name' => request()->input('name'),
            'description' => request()->input('description'),
            'user_id' => 1,
        ]);
        */

        /*
        $album =Album::insert([
            'album_name' => request()->input('name'),
            'description' => request()->input('description'),
            'user_id' => 1,
        ]);

        */

        /*
        BISOGNA CREARE LA VARIABILE FILLABLE NEL MODEL CON CREATE, CIOè VALORI CHE DEVONO ESSERE INSERITI 
        $album =Album::create([
            'album_name' => request()->input('name'),
            'description' => request()->input('description'),
            'user_id' => 1,
        ]);



        */
        /* OPPURE SENZA BISOGNO DI CREARE LA VARIABILE FILLABLE NEL MODEL */
        
        $album = new Album();
        $album->album_name = $req->input('name');
        $album->description = $req->input('description');
        $album->user_id =  $req->user()->id;;
        $album->album_thumb = "";
        
       
        $res = $album->save();

       

        if ($res) {
            event(new NewAlbumCreated($album, Auth::user()));
            //vai a verificare se sta passando le categorie dopo che viene salvato l'album perchè altrimenti
            // non avrei l 'id dell'album
            // si usa l'attach per andare direttamente ad inserire i dati nella tabella pivot
            // il metodo attach fa creare nuove relazioni nella tabella pivot
            if ($req->has('categories')){
                $album->categories()->attach($req->input('categories'));
            }

            if ($this->processFile($album->id, $req, $album)){
                $res = $album->save();
            }
        }
        $messaggio = $res ? "Album inserito" : "Album non inserito";
        session()->flash('message', $messaggio);
        //dd($album->user->email);
        return redirect()->route('album');

        
    }


}
