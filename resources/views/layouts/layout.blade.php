<!doctype html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="/css/app.css">
    <link rel="stylesheet" href="/css/main.css">
    @yield('styles')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
            crossorigin="anonymous"></script>
    <script src="/js/main.js"></script>
    <title>@yield('title')</title>
</head>
<div class="container">
    <header class="d-flex flex-wrap align-items-center justify-content-center justify-content-md-between py-3 mb-4 border-bottom">
        <a href="{{route('main.index')}}"><h1>Предзаказ</h1></a>

        <ul class="nav col-12 col-md-auto mb-2 justify-content-center mb-md-0">
            @if(\Illuminate\Support\Facades\Auth::user()->admin())
                <li><a href="" class="nav-link px-2 link-secondary">Настройки</a></li>
            @endif
            @if(\Illuminate\Support\Facades\Auth::user()->role == 'Закупка')
                <li><a href="{{route('create.index')}}" class="nav-link px-2 link-secondary">Создать</a></li>
            @endif
            <li>
                <button class="btn filter-button">Фильтр</button>
            </li>
        </ul>
        <div class="filter">
            <input type="text" class="form-control" disabled value="lorem">
            <input type="text" class="form-control" disabled value="lorem">
            <input type="text" class="form-control" disabled value="lorem">
            <input type="text" class="form-control" disabled value="lorem">
            <input type="text" class="form-control" disabled value="lorem">
            <input type="text" class="form-control" disabled value="lorem">
        </div>
    </header>
</div>
<body>
@yield('content')
</body>
@yield('script')
</html>
