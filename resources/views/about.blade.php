@extends('templates/layout')
@section('title', $title)
    

@section('content')
    
<h1> {{$title}} </h1>

    @component('components/card',
    [
        'img_title' => 'immagine di about',
        'img_url' => 'http://lorempixel.com/400/200'
    ])
    <p> ciao questo è il testo che viene inserito in automatico dove c'è la direttiva $slot nel componente </p>
    @endcomponent


    @component('components/card')
    @slot('img_title', 'Seconda immagine')
    @slot('img_url', 'http://lorempixel.com/400/200/sports')
    <p> ciao questo è il testo che viene inserito in automatico dove c'è la direttiva $slot nel componente </p>
    @endcomponent



@endsection