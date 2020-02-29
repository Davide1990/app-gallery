<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Album;
use App\Photo;
use App\AlbumCategory;
use App\CategoryAlbum;

class GalleryController extends Controller
{
    public function index(){
        
        $albums = Album::latest()->with('categories')->get();

        return view('gallery/albumGallery')->with('albums', $albums );
    }

    public function showAlbumImages(Album $album){
        //Sì: Eloquent toglie where, quindi rimane AlbumId. 
        //A questo punto divide la parola in due  e unisce i pezzi con _ e viene fuori:album_id,
        //e usa where('album_id', $album->id)
        return view('gallery/galleryImages',[
            'images' => Photo::whereAlbumId($album->id)->latest()->get(),
            'album' => $album
        ]);
    }

    public function showAlbumsForCategory(AlbumCategory $category){

        return view('gallery/albumGallery')->with('albums', $category->albums );

    }


}
