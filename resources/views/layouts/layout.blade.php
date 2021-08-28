<!doctype html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=noshrink-to-fit=no">
    <link rel="stylesheet" href="/css/app.css">
    <link rel="stylesheet" href="/css/main.css">
    @yield('styles')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
            crossorigin="anonymous"></script>
    <script src="/js/main.js"></script>
    <title>@yield('title')</title>
</head>
<body>
<div id="alert"></div>
<div id="success"></div>
<div class="container">
    <header class="d-flex flex-wrap align-items-center justify-content-center justify-content-md-between py-3 mb-4 border-bottom">
        <a href="{{route('main.index')}}"><h1>Предзаказ</h1></a>
        <ul class="nav col-12 col-md-auto mb-2 justify-content-center mb-md-0">
            <li>
                <button class="btn filter-button">Фильтр</button>
            </li>

            @if(auth()->user()->role == 'Закупка' || auth()->user()->can_decide())
                <li><a href="{{route('create.index')}}" class="nav-link px-2 link-secondary">Создать</a></li>
            @endif

            @if(auth()->user()->admin())
                <li><a href="{{route('admin.index')}}" class="nav-link px-2 link-secondary">Настройки</a></li>
            @endif

            <li><a href="{{route('logout')}}" class="nav-link px-2 link-secondary">Выйти</a></li>
        </ul>
        @include('layouts.include.filter_form')
    </header>

    @yield('content')
</div>
</body>
@yield('script')
</html>
