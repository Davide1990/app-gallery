<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\AlbumCategory;
use App\Http\Requests\CategoryRequest;
use Auth;

class AlbumCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // col with gli dici pre caricami questa relazione invece che andarmela a prendere record per record
        // cosi poi quando nella vista fai $albumCategories->albums farà la query una volta solo

        //$categories =  AlbumCategory::withCount('albums')->latest()->get();
        //$categories = Auth::user()->albumCategories()->withCount('albums')->latest()->get();

        // UTILIZZO DI LOCAL SCOPE 
        $categories = AlbumCategory::getCategoriesByUserId(auth()->user())->get();
        $category = new AlbumCategory();
        return view('categories/categories', compact('categories','category'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryRequest $request)
    {
        $category = new AlbumCategory;
        $category->category_name = $request->input('category');
        $category->user_id = Auth::id();
        $res = $category->save();
        if ($request->expectsJson()){
            return [
                'message' => $res ? 'Categoria inserita' : 'Problemi a contattare il server',
                'success' => (bool) $res,
                'data' => $category,
                
            ];
        } else {
            return redirect()->route('categories.index');
        }
        

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(AlbumCategory $category)
    {
        return $category->category_name;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(AlbumCategory $category)
    {
        return view('categories/manageCategory', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AlbumCategory $category)
    {
        $category->category_name = $request->input('category');
        $res = $category->save();
        if ($request->expectsJson()){
            return [
                'message' => $res ? 'Categoria aggiornata' : 'Problemi a contattare il server',
                'success' => (bool) $res,
                'data' => $category,
                'id' => $category->id ?: ''
            ];
        } else{
            return redirect()->route('categories.index');
        }
       
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(AlbumCategory $category, Request $req)
    {
        $res = $category->delete();

        if ($req->expectsJson()){

            return [
                'message' => $res ? 'Categoria cancellata' : 'Problemi a contattare il server',
                'success' => (bool) $res
            ];
        } else {
            return redirect()->route('categories.index');
        }
        
    }
}
