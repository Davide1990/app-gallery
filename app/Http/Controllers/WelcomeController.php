<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    public function welcome( $name, Request $req){
        return "ciao " . $name . ' ' . $req->input('cognome');
    }
}
