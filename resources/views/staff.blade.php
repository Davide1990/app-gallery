@extends('templates/layout')

@section('title',$title)


@section('content')
<h1>
 {{$title}}
 </h1> 

@if ($staff)
<ul>
    @foreach ($staff as $person)
        <li style="{{$loop->first ? 'color:red' : '' }}"> {{$person['name']}} {{$person['surname']}} </li>

    @endforeach
</ul>
@endif

@endsection

<!-- OPPURE FAI -->

        {{--
    <!-- <ul> -->
        @forelse ($staff as $person)
            <li> {{$person['name']}} {{$person['surname']}} </li>
        @empty
            <li> No Staff </li>
        @endforelse
    <!-- </ul>   -->

--}}

@section('footer')
@parent
<script>
    
</script>
@stop