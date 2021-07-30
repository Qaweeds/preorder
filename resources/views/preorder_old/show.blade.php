@php use App\Http\Controllers\GetterController @endphp
@extends('layouts.layout')
{{--{{dd($comments[0]->comment)}}--}}

@section('styles')
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/main.css') }}" rel="stylesheet">
    <link href="{{ asset('vendor/fontawesome/css/all.min.css') }}" rel="stylesheet">
@endsection

@section('title')Модель@endsection

@section('content')
    <main>
        <div class="scrolling">
            <div id="cards">
                @if(Session::has('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <div class="alert-heading">
                            {{ Session::get('success') }}
                        </div>
                    </div>
                @endif
                <div class="card maxwidthcard">
                    <div class="card-body p-3">
                        <div class="image mb-5">
                            @foreach(explode(',', $model->photo) as $pic)
                                <img class="width33 h-auto" src="../../storage/pics/{{$pic}}" alt="pic">
                            @endforeach
                        </div>
                        <div class="info width50">
                            <div class="header">
                                <div class="title">
                                    <div class="name">{{$model->id}}
                                        . {{GetterController::getCategory($model->category)}}</div>
                                    <div class="name">{{GetterController::getUser($model->user_id)}}</div>
                                    <div class="country">{{GetterController::getCountry($model->country)}}</div>
                                    <div class="country">@if($model->priznak == 1){{'В наличии'}}@else {{'Под заказ'}}@endif</div>
                                    <div class="country">@if($model->season === 'ОЗ'){{'Осень-Зима'}}@else {{'Весна-Лето'}}@endif</div>
                                </div>
                                <div class="price">
                                    <div class="ret">
                                            <span>
                                                @if(is_array(GetterController::sellPrice($model->price, $model->country, $model->season, $model->category, $model->channel)))
                                                    @foreach (GetterController::sellPrice($model->price, $model->country, $model->season, $model->category, $model->channel) as $chn => $price)
                                                        <small>{{$chn}}: {{$price}}</small><br>
                                                    @endforeach
                                                    @if($manager->is_tovaroved() or $manager->is_admin() or $manager->is_director())
                                                        <div class="opt"><span><small>Cебест: {{$model->selfprice}} {{GetterController::getCountryCurrency($model->country)}}</small></span></div>
                                                        <div class="opt"><span><small>Закупка: {{$model->price}} {{GetterController::getCountryCurrency($model->country)}}</small></span></div>
                                                    @endif
                                                @else
                                                    <div>{{GetterController::sellPrice($model->price, $model->country, $model->season, $model->category, $model->channel)}}</div>
                                                @endif
                                            </span>
                                    </div>
                                    <div class="opt"><span
                                                class="text-dark ">Оценка: <span
                                                    class="card-point"> {{round($model->raiting, 1)}}</span></span>
                                    </div>
                                </div>
                            </div>
                            <div class="main">
                                @if(GetterController::getReserve($model->id))
                                    <div class="reserve-block">
                                    </div>
                                @endif
                            </div>
                            <div class="info-table">
                                <div class="row-table">
                                    <div class="col-table">Старт продаж: <b>{{$model->date_sale}}</b></div>
                                </div>
                                <div class="row-table">
                                    @foreach(explode(',', $model->channel) as $ch)
                                        <div class="col-table">{{GetterController::getChannel($ch)}}</div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="info-table width50">
                                <div class="row-table mb-5">
                                    <form class="w-100" action="{{route('order.vote')}}" method="get" name="vote-form">
                                        <div class="p-2">
                                            <input type="hidden" name="model" value="{{$model->id}}">
                                            <input type="range" name="mark" min="0" max="4" value="0" step="0.1"
                                                   class="form-control-range vote-range">
                                            <div class="d-flex justify-content-between range-num-wrap">
                                                <p>0</p>
                                                {{--<button class="btn btn-dark mt-2" type="submit">Оценить</button>--}}
                                                <p>4</p>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer width50">
                            <div class="button-group tile">

                                @if($manager->id == $model->user_id)
                                    <a href="{{route('order.edit', $model->id)}}"
                                       class="update-link"><span>Редактирование</span></a>
                                @else
                                    <div class="reserve-wrap w-100 d-block">
                                        <button type="button" class="btn btn-default btn-warning reserve">
                                            <span>Резерв</span></button>
                                        <div class="order-quantity position-static w-100">
                                            <form action="{{route('reserve')}}" class="show-form">
                                                <input type="hidden" name="model" value="{{$model->id}}">
                                                <input type="text" name="reserve" class="form-control"
                                                       placeholder="Количество">
                                                <input type="submit" class="form-control btn-success" value="Резерв">
                                            </form>
                                        </div>
                                    </div>
                                @endif
                            </div>

                            @if($manager->id == $model->user_id or $manager->is_admin() or $manager->is_director())
                                <div class="button-group tile">
                                    <button name="{{$model->id}}" type="button" class="btn btn-default profit">
                                        <span>В заказ</span>
                                    </button>
                                    <button name="{{$model->id}}" type="button" class="btn btn-default loss ">
                                        <span>Отказ</span>
                                    </button>
                                </div>
                            @endif

                        </div>
                        @if(GetterController::getReserveNumber($model->id) and ($manager->id == $model->user_id  or $manager->is_director()or $manager->is_admin() ))
                            <div class="reserve-body mt-3 p-1 container">
                                <h5>Заказали:</h5>
                                @foreach(GetterController::getReserve($model->id) as $res)
                                    <small>{{GetterController::getUser($res->user_id)}}: {{$res->quantity}}
                                        Шт.
                                    </small>
                                @endforeach
                            </div>
                        @endif
                        <div class="info mt-5">
                            <div class="header">
                                <div class="title">
                                    <h3>Коментарии:</h3>
                                </div>
                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                            </div>
                            <div class="comments mb-5">
                                @foreach($comments as $comment)
                                    <div class="comments-body">
                                        <h4 class="-comment-autor">{{GetterController::getUser($comment->user_id)}}</h4>
                                        <small>{{$comment->created_at}}</small>
                                        <p>{{$comment->comment}}</p>
                                    </div>
                                @endforeach
                            </div>
                            <div class="overflow-hidden">
                                <form action="" method="post">
                                    @csrf
                                    <div class="form-group">
                                        <div class="title ">
                                            <h4>Оставить комментарий</h4>
                                        </div>
                                        <textarea name="comment" id="comment" rows="8" class="form-control"></textarea>
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" id="button" class="btn btn-primary float-right">Отправить
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
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
            $('.reserve').click(function () {
                $('.order-quantity').toggle('slow');
            });
            @if (isset($model))
            $('.loss').click(function () {
                if (confirm(areyousure)) window.location.href = "{{ route('order.delete', $model->id) }}";
            });
            $('.profit').click(function () {
                if (confirm(areyousure)) window.location.href = "{{ route('order.success', $model->id) }}";
            });

            $('.vote-range').change(function () {
                var data = $(this).closest('form').serializeArray();
                $.ajax({
                    url: '{{route('order.vote')}}',
                    data: data,
                    success: function (mark) {
                        $('#cards').find('.card-point').html(mark);
                    },
                    error: function () {
                        console.log('e')
                    },
                    dataType: 'html'
                })
            });
            @endif
        })(jQuery);
    </script>
@endsection