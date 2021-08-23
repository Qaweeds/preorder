@extends('layouts.layout')
@section('styles')
    <link rel="stylesheet" href="css/create.css">
@endsection
@section('title')Создать предзаказ@endsection

@section('content')
    <main>
        <div class="container">
            <div class="col-md-12 col-lg-6 offset-lg-3">

                @if(Session::has('success'))
                    <div class="alert alert-success text-center card-wrap">
                        <div class="alert-heading">
                            {{ Session::get('success') }}
                        </div>
                    </div>
                @endif

                <form action="{{route('create.store')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="country">Страна закупки</label>
                        <select name="country" id="country" class="form-control">
                            @foreach($countries as $c)
                                <option @if(Cookie::get('country') == $c->id) selected @endif value="{{$c->id}}">{{$c->name}}
                                    {{$c->currency}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="ready_or_not">Признак закупки</label>
                        <select name="ready_or_not" id="ready_or_not" class="form-control">
                            <option value="1">В наличии</option>
                            <option value="2">Под заказ</option>
                        </select>
                    </div>

                    <div class="form-group" id="makeTimeBlock">
                        <label for="makeTime">Дата изготовления</label>
                        <input id="date_start_sale" name="date_start_sale" type="date" class="form-control w-auto" value="0">
                    </div>

                    <div class="form-group">
                        <label for="delivery">Способ доставки</label>
                        <select name="delivery" id="delivery" class="form-control">
                            <option value="Земля">Земля</option>
                            <option value="Самолет">Самолет</option>
                        </select>
                    </div>

                    <div class="form-group">
                        @error('group')
                        <span class="error-msg">{{$message}} </span>
                        @enderror
                        <label for="group">Подгруппа</label>
                        <select name="group" id="group" class="form-control" required>
                            <option value="" disabled selected>Выберите Подгруппу</option>
                            @foreach($groups as $g)
                                <option value="{{ $g->id}}" {{ (old("group") == $g->id ? "selected":"") }}>{{ $g->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        @error('category')
                        <span class="error-msg">{{$message}} </span>
                        @enderror
                        <label for="group">Категория</label>
                        <select id="category" name="category" class="form-control category" required>
                            @if(old('category'))
                                <option value="{{old('category')}}" selected>{{old('category')}}</option>
                            @else
                                <option value="" selected disabled>Сначала Выберите Подгруппу</option>
                            @endif
                        </select>
                    </div>


                    <div class="form-group">
                        @error('channel')
                        <span class="error-msg">{{$message}} </span>
                        @enderror
                        <p>Каналы сбыта</p>
                        <span class="mr-2 h4">CityBluzka</span><input name="channel[]" class="form-check-inline"
                                                                      value="CityBluzka" type="checkbox">
                        <span class="mr-2 h4">OLKO</span><input name="channel[]" class="form-check-inline" value="OLKO"
                                                                type="checkbox">
                        <span class="mr-2 h4">Vip-опт</span><input name="channel[]" class="form-check-inline"
                                                                   value="Vip-опт" type="checkbox">
                        <span class="mr-2 h4">Опт</span><input name="channel[]" class="form-check-inline" value="Опт"
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
                        @error('price')
                        <span class="error-msg">{{$message}} </span>
                        @enderror
                        <label for="price">Цена закупки</label>
                        <input id="price" name="price" type="number" step="0.01" class="form-control" placeholder="В валюте страны"
                               value="{{old('price')}}"
                               required>
                    </div>

                    <div class="form-group">
                        <label for="comment">Примечание</label>
                        <textarea id="comment" name="comment" class="form-control"
                                  rows="5">{{ old('comment') }}</textarea>
                    </div>

                    <div class="form-group mt-5">
                        @error('file')
                        <span class="error-msg">{{$message}} </span>
                        @enderror
                        <p>Загрузить фотографию</p>
                        <input id="file" name="file[]" type="file" multiple accept="image/*" required>
                    </div>
                    <div class="form-group">
                        <button type="submit" id="button" class="btn btn-primary">Создать</button>
                    </div>

                </form>
            </div>
        </div>
    </main>
@endsection

@section('script')
    <script src="js/create.js"></script>
@endsection


<script>
    var cat_route = '{{route('create.cat')}}'
</script>
