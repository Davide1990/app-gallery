<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PagesController extends Controller
{

    protected $data = [
        [
            'name' => 'John',
            'surname' => 'Gid'
        ],
        [
            'name' => 'Davide',
            'surname' => 'Bordin'
        ],
        [
            'name' => 'Luca',
            'surname' => 'Fattore'
        ]

    ];

    public function about(){

        // utilizzando container app, gli passiamo la view, lui ci crea la istanza della classe view
       // $view = app('view');
        //return $view('about');

        // utilizzando un helpers
        return view('about')->with('title', 'About');

        // utilizzando la facades 
        //return View::make('about');
    }

    public function staff(){



        // utilizzando container app, gli passiamo la view, lui ci crea la istanza della classe view
       // $view = app('view');
        //return $view('about');

        // utilizzando un helpers

        return view('staff', [
            'title' => 'Our staff',
            'staff' => $this->data
        ]);

        /* OPPURE 

        return view('staff')->with('title','Our staff')->with('staff', $this->data);

        OPPURE

        return view('staff')->withTitle('Our staff')->withStaff($this->data);

        OPPURE 

        $title = 'Our staff';
        $staff = $this->data;
        return view('staff',compact('title','staff'));

        */

        // utilizzando la facades 
        //return View::make('about');
    }

}
