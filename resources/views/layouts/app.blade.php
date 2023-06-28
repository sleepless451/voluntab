<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>VolunTab</title>

    <!-- Scripts <script src="{{ asset('js/app.js') }}" defer></script> -->


    <!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css"
          integrity="sha256-kLaT2GOSpHechhsozzB+flnD+zUyjE2LlfWPgU04xyI="
          crossorigin=""/>

    <!-- Styles -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">
    <script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js"
            integrity="sha256-WBkoXOwTeyKclOHuWtc+i2uENFpDZ9YPdf5Hf+D7ewM="
            crossorigin=""></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <link href="{{ asset('css/tagify.css') }}" rel="stylesheet" type="text/css">
    <style>
        #map { height: 500px;}
    </style>
</head>

<body>
    <style>
        .tagify {
            overflow-y: hidden;
            letter-spacing: 1px;
            width: 100%;
            height: auto;
            margin-bottom: 10px;
            border: 1px solid #cccccc;
            border-radius: 5px;
            transition: all .2s ease-out;
            padding: 2px 6px;
            background-color: white;
            /*flex-wrap: nowrap;*/
        }

        .tagify__input .tagify__tag {
            margin: 3px 2px;
        }

        .form-select {
            height: 44px;
        }

    </style>

    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light navbar-laravel">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    VolunTab
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Right Side Of Navbar -->
                    <form class="d-flex" action="{{ route('search') }}" method="POST">
                        @csrf
                        <input class="mr-2 input-group-text" type="text" name="search" placeholder="Введіть текст для пошуку">
                        <input type="submit" class="btn btn-primary" value="Пошук">
                    </form>
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">Логін</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('register') }}">Реєстрація</a>
                            </li>
                        @else
                            @if(Auth::user()->role === \App\User::ROLE_ADMIN)
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('posts-dashboard') }}">Панель постів</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('users-dashboard') }}">Панель користувачів</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('tags-dashboard') }}">Панель тегів</a>
                                </li>
                            @endif
                            <li class="nav-item dropdown" id="exclude">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <div id="dropdown" class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('create-post') }}">Створити оголошення</a>
                                    <a class="dropdown-item" href="{{ route('show-user-posts', Auth::user()->id) }}">Мої оголошення</a>
                                    <a class="dropdown-item" href="{{ route('show-profile', Auth::user()->id) }}">Мій профіль</a>
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        Вихід
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

        <main class="py-4">
            @yield('content')
        </main>
    </div>
</body>

<script src="{{ asset('js/jquery-3.7.0.min.js') }}"></script>
<script src="{{ asset('js/jQuery.tagify.min.js') }}"></script>

<script>
    var whitelist = [
        @foreach($tags as $tag)
            {!! '{"value":"' . $tag->name . '","slug":"' . $tag->id . '"},' !!}
        @endforeach
    ];

    var input = document.getElementById("tagify");
    tagify = new Tagify(input, {
        enforceWhitelist: true,
        whitelist: whitelist,
        dropdown: {
            searchKeys: ["slug", "value"],
            highlightFirst: true,
            maxItems: 10,
            classname: "tags-look",
            enabled: 0,
            closeOnSelect: false
        }
    });

    $('.nav-item, .dropdown').on('click', function (event){
        if($('#dropdown').hasClass('show')){
            $('#dropdown').removeClass("show");
        } else {
            $('#dropdown').addClass("show");
        }
    });

    $('body').on('click', function (event){
        if (event.target.id !== 'except' && event.target.id !== 'navbarDropdown') {
            $('#dropdown').removeClass("show");
        }
    });
</script>

@stack('js')
</html>
