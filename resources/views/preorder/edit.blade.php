@extends('layouts.layout')
@section('styles')
    <link rel="stylesheet" href="../css/create.css">
@endsection
@section('title')Создать предзаказ@endsection
{{--{{dd($item)}}--}}
@section('content')
    <main>

        <div class="container">
            <div class="col-md-12 col-lg-6 offset-lg-3">

                @include('layouts.include.result_message')

                <form action="{{route('edit.store', $item->id)}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="country">Страна закупки</label>
                        <select name="country" id="country" class="form-control">
                            @foreach($countries as $c)
                                @if($c->id == $item->country_id)
                                    <option value="{{$c->id}}" selected>{{$c->name}} {{$c->currency}}</option>
                                @else
                                    <option value="{{$c->id}}">{{$c->name}} {{$c->currency}}</option>
                                @endif
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
                        <label for="group">Подгруппа</label>
                        <select name="group" id="group" class="form-control">
                            <option value="" disabled>Выберите Подгруппу</option>
                            @foreach($groups as $g)
                                @if($g->id == $item->gg->id)
                                    <option selected value="{{$g->id}}">{{$g->name}}</option>
                                @else
                                    <option value="{{$g->id}}">{{$g->name}}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="group">Категория</label>
                        <select name="category" id="category" class="form-control">
                            <option value="{{$item->category->name}}">{{$item->category->name}}</option>
                        </select>
                    </div>


                    <div class="form-group">
                        <p for="channel">Каналы сбыта</p>
                        <span class="mr-2 h4">CityBluzka</span><input name="channel[]" class="form-check-inline"
                                                                      value="CityBluzka" type="checkbox"
                                                                      @if(strstr($item->channel, 'CityBluzka')) checked @endif >
                        <span class="mr-2 h4">OLKO</span><input name="channel[]" class="form-check-inline" value="OLKO"
                                                                type="checkbox" @if(strstr($item->channel, 'OLKO')) checked @endif >
                        <span class="mr-2 h4">Vip-опт</span><input name="channel[]" class="form-check-inline"
                                                                   value="Vip-опт" type="checkbox"
                                                                   @if(strstr($item->channel, 'Vip-опт')) checked @endif >
                        <span class="mr-2 h4">Опт</span><input name="channel[]" class="form-check-inline" value="Опт"
                                                               type="checkbox" @if(strstr($item->channel, 'Опт')) checked @endif >
                    </div>

                    <div class="form-group">
                        <label for="season">Сезон продаж</label>
                        <select name="season" id="season" class="form-control">
                            <option value="ВЛ" @if($item->season == 'ВЛ') selected @endif >Весна-лето</option>
                            <option value="ОЗ" @if($item->season == 'ОЗ') selected @endif >Осень-зима</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="price">Цена закупки</label>
                        <input id="price" name="price" type="number" step="0.01" class="form-control" placeholder="В валюте страны"
                               value="{{$item->price}}" required>
                    </div>

                    <div class="form-group mt-5">
                        <p>Загрузить фотографию</p>
                        <input id="file" name="file[]" type="file" multiple accept="image/*">
                    </div>

                    <div class="form-group">
                        <button type="submit" id="button" class="btn btn-primary">Обновить</button>
                    </div>

                </form>
            </div>
        </div>
    </main>
@endsection

@section('script')
    <script src="/js/create.js"></script>
@endsection


<script>
    var cat_route = '{{route('create.cat')}}'
</script>
