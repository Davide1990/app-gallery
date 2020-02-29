
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Jekyll v3.8.5">
    <title>@yield('title','Staff')</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.css" media="screen">

    <link rel="stylesheet" href="/css/style.css">
    <link rel="stylesheet" href="/css/mdb.css">
    <link rel="stylesheet" href="/css/fontawesome.min.css">
    <link rel="stylesheet" href="/css/solid.min.css">
    <link rel="stylesheet" href="/css/lightbox.css">
    <style>
      .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
      }

      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }
    </style>
    <!-- Custom styles for this template -->
    <link href="starter-template.css" rel="stylesheet">
    <script>
      window.Laravel = {!! json_encode([
          'csrfToken' => csrf_token()
        ])
      !!};
    </script>
  </head>
  <body>
    <nav class="navbar navbar-expand-md fixed-top">
      <div class="container">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

          <div class="collapse navbar-collapse" id="navbarsExampleDefault">
            <ul class="navbar-nav mr-auto">
              <!-- il metodo check verifica che l'utente sia loggato a prescindere dal livello di autenticazione -->
              @if (Auth::check())
                <li class="nav-item active">
                  <a class="nav-link" href="{{route('home')}}">Home </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="{{route('album')}}">Albums</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="{{route('album.create')}}" >New Album</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('photos.create')}}" >New Photo</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('categories.index')}}" >Categories </a>
                  </li>
                  @if (Auth::user()->isAdmin())
                    <li class="nav-item">
                      <a class="nav-link" href="{{route('users.list')}}" >Admin Panel </a>
                    </li>
                  @endif
              @else
                <li class="nav-item">
                  <a class="nav-link" href="{{route('album.gallery')}}" >Home </a>
                </li>
               
              @endif 
              
            </ul>


            <ul class="navbar-nav ml-auto">
                <!-- Authentication Links -->
                @guest
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                    </li>
                    @if (Route::has('register'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                        </li>
                    @endif
                @else
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            {{ Auth::user()->name }} <span class="caret"></span>
                        </a>

                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ route('logout') }}"
                               onclick="event.preventDefault();
                                             document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </div>
                    </li>
                @endguest
            </ul>

            
          </div>
      </div>
    </nav>

<main role="main" class="container">
<!-- yield significa renderizza qui la sezione content -->
@yield('content')


</main><!-- /.container -->
@section('footer')

<script src="/js/jquery.js" type="text/javascript"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" crossorigin="anonymous"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"  crossorigin="anonymous"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.js"></script>

<script src="/js/mdb.js" type="text/javascript"></script>
<script src="/js/lightboxInit.js" type="text/javascript"></script>
<script src="/js/lightbox.js" type="text/javascript"></script>
@show
<!-- integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
  integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"
  integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" 
-->
</body>
</html>
