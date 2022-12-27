<!DOCTYPE html>

<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name', 'Laravel') }}</title>
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
        <!-- Styles -->
        <link rel="stylesheet" href="/assets/css/style.css">

        
        <!-- Scripts -->
        <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
        <script src="https://kit.fontawesome.com/d6770acc88.js"></script>
        <script src="/assets/js/site.js"></script>
    </head>
    <body>
        <div class="main_container">
            <div class="header">
                <div class="top_right">
                    <i class="fas fa-home"></i><a href="/">Главная</a>
                    
                    @auth
                    <i class="far fa-window-restore"></i><a href="{{route('files.index')}}">Файлы</a>
                    <i class="far fa-window-restore"></i><a href="{{route('profile.edit')}}">Профиль</a>
                    <i class="fas fa-sign-out-alt"></i>
                    <form method="POST" id="form_logout" style="display: inline-block;" action="{{ route('logout') }}">
                        @csrf
                        <a href="route('logout')"onclick="event.preventDefault();
                        $('#form_logout').submit();">Выйти </a>
                    </form>
                    @endauth
                </div>
            </div>

            @yield('content')

            <div class="footer">
                <div class="links">
                    <a href="/"> cloud-storage-api test project </a>
                </div>
            </div>

        </div>


<script>

</script>

    </body>
</html>
