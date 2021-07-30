@extends('layouts.layout')
@section('styles')
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/main.css') }}" rel="stylesheet">
    <link href="{{ asset('vendor/fontawesome/css/all.min.css') }}" rel="stylesheet">
@endsection

@section('title')Создать предзаказ@endsection

@section('content')
    <main>
        <div class="scrolling">

            <div class="row">
                <div class="col-md-12 col-lg-6 offset-lg-3">
                    @if(Session::has('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <div class="alert-heading">
                                {{ Session::get('success') }}
                            </div>
                        </div>
                    @endif
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('order.store') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="country">Страна закупки</label>
                            <select name="country" id="country" class="form-control">
                                @foreach($countries as $c)
                                    @if(isset($_COOKIE['cookie-country']) and $c->id == $_COOKIE['cookie-country'])
                                        <option value="{{$c->id}}" selected>{{$c->name}} {{$c->currency}}</option>
                                    @else
                                        <option value="{{$c->id}}">{{$c->name}} {{$c->currency}}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="priznak">Признак закупки</label>
                            <select name="priznak" id="priznak" class="form-control">
                                <option value="1">В наличии</option>
                                <option value="2">Под заказ</option>
                            </select>
                        </div>

                        <div class="form-group" id="makeTimeBlock">
                            <label for="makeTime">Дата изготовления</label>
                            <input id="makeTime" name="makeTime" type="date" class="form-control w-auto" value="0">
                        </div>

                        <div class="form-group">
                            <label for="delivery">Способ доставки</label>
                            <select name="delivery" id="delivery" class="form-control">
                                <option value="Земля">Земля</option>
                                <option value="Самолет">Самолет</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="group">Подгруппа</label>
                            <select name="group" id="group" class="form-control">
                                <option value="" disabled selected>Выберите Подгруппу</option>
                                @foreach($groups as $g)
                                    <option value="{{$g->id}}">{{$g->name}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="group">Категория</label>
                            <select name="category" id="category" class="form-control">

                            </select>
                        </div>


                        <div class="form-group">
                            <p for="channel">Каналы сбыта</p>
                            <span class="mr-2 h4">CityBluzka</span><input name="channel[]" class="form-check-inline"
                                                                          value="1" type="checkbox">
                            <span class="mr-2 h4">OLKO</span><input name="channel[]" class="form-check-inline" value="2"
                                                                    type="checkbox">
                            <span class="mr-2 h4">Vip-опт</span><input name="channel[]" class="form-check-inline"
                                                                       value="3" type="checkbox">
                            <span class="mr-2 h4">Опт</span><input name="channel[]" class="form-check-inline" value="4"
                                                                   type="checkbox">
                        </div>

                        <div class="form-group">
                            <label for="season">Сезон продаж</label>
                            <select name="season" id="season" class="form-control">
                                <option value="ВЛ">Весна-лето</option>
                                <option value="ОЗ">Осень-зима</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="price">Цена закупки</label>
                            <input id="price" name="price" type="number" step="0.01" class="form-control" placeholder="В валюте страны" required>
                        </div>

                        <div class="form-group">
                            <label for="comment">Примечание</label>
                            <textarea id="comment" name="comment" class="form-control"
                                      rows="5">{{ old('comment') }}</textarea>
                        </div>

                        <div class="form-group mt-5">
                            <p>Загрузить фотографию</p>
                            <input id="photo" name="photo[]" type="file" multiple accept="image/*">
                        </div>

                        <div class="form-group">
                            <button type="submit" id="button" class="btn btn-primary">Создать</button>
                        </div>

                    </form>
                </div>
            </div>

        </div>
    </main>
@endsection

@section('scripts')
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('vendor/fontawesome/js/all.min.js') }}"></script>
    <script>
        (function ($) {
            const csrf = $('meta[name="csrf-token"]').attr("content");

            /** Mobile menu show/hide **/
            $('#mobile-menu-open').on('click', function () {
                $('#nav-box').addClass('active');
            });
            $('#menu-close').on('click', function () {
                $('#nav-box').removeClass('active');
            });

            $('#priznak').change(function () {
                $timeInput = $('#makeTimeBlock');
                switch ($(this).val()) {
                    case '1':
                        $timeInput.hide(400);
                        break;
                    case '2':
                        $timeInput.show(400);
                        break;
                }
            });

            $('#group').change(function () {
               var data = $('#group').serialize();
                $.ajax({
                    url: '{{route('get.cat')}}',
                    data: data,
                    success: function (data) {
                        var ops;
                        data.forEach(el => ops += '<option value="'+el+'">' +el+'</option>');
                        $('#category').html(ops);
                    },
                    error: function () {
                        console.log('e')
                    },
                    dataType: 'json'
                })
            });

        })(jQuery);
    </script>
@endsection