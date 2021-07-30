@extends('layouts.layout')
@section('styles')
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/main.css') }}" rel="stylesheet">
    <link href="{{ asset('vendor/fontawesome/css/all.min.css') }}" rel="stylesheet">
@endsection

@section('title')Редактировать предзаказ@endsection

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

                    <form action="{{ route('order.update', $model->id) }}" method="post" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group">
                            <label for="category">Подгруппа</label>
                            <select name="group" id="group" class="form-control">
                                @foreach($groups as $g)
                                    @if($g->id == $model->category)
                                        <option value="{{$g->id}}" selected>{{$g->name}}</option>
                                    @else
                                        <option value="{{$g->id}}">{{$g->name}}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="priznak">Признак закупки</label>
                            <select name="priznak" id="priznak" class="form-control">
                                <option value="1" @if($model->priznak == 1) selected @endif>В наличии</option>
                                <option value="2" @if($model->priznak == 2) selected @endif>Под заказ</option>

                            </select>
                        </div>

                        <div class="form-group">
                            <label for="country">Страна закупки</label>
                            <select name="country" id="country" class="form-control">
                                @foreach($countries as $c)
                                    @if($c->id == $model->country)
                                        <option value="{{$c->id}}" selected>{{$c->name}}</option>
                                    @else
                                        <option value="{{$c->id}}">{{$c->name}}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="delivery">Способ доставки</label>
                            <select name="delivery" id="delivery" class="form-control">
                                <option value="Земля" @if($model->delivery == 'Земля') selected @endif>Земля</option>
                                <option value="Самолет" @if($model->delivery == 'Самолет') selected @endif>Самолет
                                </option>
                            </select>
                        </div>

                        <div class="form-group">
                            <p for="channel">Каналы сбыта</p>

                            <span class="mr-2 h4">CityBluzka</span><input name="channel[]" class="form-check-inline"
                                                                          value="1" type="checkbox"
                                                                          @if(strstr($model->channel, '1')) checked @endif>
                            <span class="mr-2 h4">OLKO</span><input name="channel[]" class="form-check-inline" value="2"
                                                                    type="checkbox"
                                                                    @if(strstr($model->channel, '2')) checked @endif>
                            <span class="mr-2 h4">Vip-опт</span><input name="channel[]" class="form-check-inline"
                                                                       value="3" type="checkbox"
                                                                       @if(strstr($model->channel, '3')) checked @endif>
                            <span class="mr-2 h4">Опт</span><input name="channel[]" class="form-check-inline" value="4"
                                                                   type="checkbox"
                                                                   @if(strstr($model->channel, '4')) checked @endif>
                        </div>

                        <div class="form-group">
                            <label for="season">Сезон продаж</label>
                            <select name="season" id="season" class="form-control">
                                <option value="ВЛ" @if($model->season == 'ВЛ') selected @endif>Весна-лето</option>
                                <option value="ОЗ" @if($model->season == 'ОЗ') selected @endif>Осень-зима</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="price">Цена закупки</label>
                            <input id="price" name="price" type="number" step="0.01" class="form-control"
                                   value="{{$model->price}}" required>
                        </div>

                        <div class="form-group">
                            <label for="comment">Примечание</label>
                            <textarea id="comment" name="comment" class="form-control"
                                      rows="5">{{ $model->comment }}</textarea>
                        </div>

                        <div class="form-group mt-5">
                            <p>Загрузить фотографию</p>
                            <input id="photo" name="photo[]" type="file" multiple accept="image/*">
                        </div>

                        <div class="form-group">
                            <button type="submit" id="button" class="btn btn-primary">Обновить</button>
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
        })(jQuery);
    </script>
@endsection