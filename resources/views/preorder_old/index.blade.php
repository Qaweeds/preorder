@php use App\Http\Controllers\GetterController @endphp
@extends('layouts.layout')
@section('styles')
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/main.css') }}" rel="stylesheet">
    <link href="{{ asset('vendor/fontawesome/css/all.min.css') }}" rel="stylesheet">
@endsection
@section('title')Предзаказ@endsection
@section('content')
    <main>
        <div class="scrolling">
            <div id="cards">
            </div>
            @if(Session::has('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <div class="alert-heading">
                        {{ Session::get('success') }}
                    </div>
                </div>
            @endif
            @foreach($cat as $item)

                @if(strpos(' '.$item->channel, $channel_id) or $manager->is_admin() or $manager->is_director() or $manager->is_tovaroved() or $manager->is_zakupka())
                    <div class="card @if(!$item->active) inactive @endif" id="card-{{$item->id}}">
                        <div class="card-body">
                            <a href="{{route('show', $item->id)}}">
                                <div class="image">
                                    <img class="viewbox" src="../storage/pics/{{explode(',',$item->photo)[0]}}"
                                         alt="pic">
                                </div>
                            </a>
                            <div class="info">
                                <div class="header">
                                    <div class="title">
                                        <div class="name">{{$item->id}}
                                            . {{GetterController::getCategoryAlias($item->category)}}
                                            , {{$item->category2}} </div>
                                        <div class="name">{{$item->user->name}}</div>
                                        <div class="country">{{$item->countries->name}}</div>
                                        <div class="country">@if($item->priznak == 1){{'Готовое'}}@else {{'Заказное'}}@endif
                                            , {{$item->date_sale}}</div>
                                        <div class="country">@if($item->season === 'ОЗ'){{'Осень-Зима'}}@else {{'Весна-Лето'}}@endif</div>
                                        <div class="country">
                                            @if(GetterController::getReserveNumber($item->id))
                                                <span class="text-dark font-weight-bold">Заказали: {{GetterController::getReserveNumber($item->id) }}
                                                    чел.</span>
                                            @endif
                                        </div>

                                    </div>
                                    <div class="price">
                                        <div class="ret">
                                            <span>
                                                @if(is_array(GetterController::sellPrice($item->price, $item->country, $item->season, $item->category, $item->channel)))
                                                    @foreach (GetterController::sellPrice($item->price, $item->country, $item->season, $item->category, $item->channel) as $chn => $price)
                                                        <small>{{$chn}}: {{$price}}</small><br>
                                                    @endforeach
                                                    @if($manager->is_tovaroved() or $manager->is_admin() or $manager->is_director() or
                                                    $manager->is_zakupka())
                                                        <div class="opt"><span><small>Cебест: {{$item->selfprice}} {{GetterController::getCountryCurrency($item->country)}}</small></span></div>
                                                        <div class="opt"><span><small>Закупка: {{$item->price}} {{GetterController::getCountryCurrency($item->country)}}</small></span></div>
                                                    @endif
                                                @else
                                                    <div>{{GetterController::sellPrice($item->price, $item->country, $item->season, $item->category, $item->channel)}}</div>
                                                @endif
                                            </span>
                                        </div>
                                        <div class="opt"><span
                                                    class="text-dark ">Оценка: <span
                                                        class="card-point"> {{round($item->raiting, 1)}}</span></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="info-table">
                                <div class="row-table">
                                    @foreach(explode(',', $item->channel) as $ch)
                                        <div class="col-table">{{GetterController::getChannel($ch)}}</div>
                                    @endforeach
                                </div>
                                <div class="row-table">
                                    <form class="w-100" action="{{route('order.vote')}}" method="get" name="vote-form">
                                        <div class="p-2">
                                            <input type="hidden" name="model" value="{{$item->id}}">
                                            <input type="range" name="mark" min="0" max="4" value="0" step="0.1"
                                                   class="form-control-range vote-range">
                                            <div class="d-flex justify-content-between range-num-wrap">
                                                <p>0</p>
                                                <p>4</p>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <div class="card-footer">
                            <div class="button-group tile">

                                @if($manager->id == $item->user_id)
                                    <a href="{{route('order.edit', $item->id)}}"
                                       class="update-link"><span>Редактирование</span></a>
                                @else
                                    <div class="reserve-wrap">
                                        <button type="button" class="btn btn-default btn-warning reserve">
                                            <span>Резерв</span></button>
                                        <div class="order-quantity">
                                            <form action="{{route('reserve')}}">
                                                <input type="hidden" name="model" value="{{$item->id}}">
                                                <input type="text" name="reserve" class="form-control"
                                                       placeholder="Количество">
                                                <input type="submit" class="form-control btn-success" value="Резерв">
                                            </form>
                                        </div>
                                    </div>
                                @endif

                                <button class="btn btn-default comment-button">Комментарии</button>
                                @if(GetterController::getCommentsNumber($item->id))
                                    <div class="button-counter">{{GetterController::getCommentsNumber($item->id)}}</div>
                                @endif
                            </div>
                            <div class="comments-body-main">
                                @if(GetterController::getReserveNumber($item->id) and ($manager->id == $item->user_id  or $manager->is_director()or $manager->is_admin() ))
                                    <div class="reserve-body">
                                        <h5>Заказали:</h5>
                                        @foreach(GetterController::getReserve($item->id) as $res)
                                            <small>{{GetterController::getUser($res->user_id)}}: {{$res->quantity}}
                                                Шт.
                                            </small>
                                        @endforeach
                                    </div>
                                @endif
                                @foreach(GetterController::getComments($item->id) as $comment)
                                    <div class="comments-body">
                                        <h4 class="-comment-autor">{{GetterController::getUser($comment->user_id)}}</h4>
                                        <small>{{$comment->created_at}}</small>
                                        <p>{{$comment->comment}}</p>
                                    </div>
                                @endforeach
                            </div>

                            @if($manager->id == $item->user_id or $manager->is_admin() or $manager->is_director())
                                <div class="button-group tile">
                                    <button name="{{$item->id}}" type="button" class="btn btn-default profit">
                                        <span>В заказ</span>
                                    </button>
                                    <button name="{{$item->id}}" type="button" class="btn btn-default loss ">
                                        <span>Отказ</span>
                                    </button>
                                </div>
                            @endif
                        </div>

                    </div>
                @endif
            @endforeach
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

            /** Filters **/
            $('#mobile-filter-open').on('click', function () {
                $('#filter-box').addClass('active');
            });

            $('#filter-close').on('click', function () {
                $('#filter-box').removeClass('active');
            });

            $('#filter-clear').on('click', function () {
                $('#season_filter').find('option').first().prop('selected', true);
                $('#country_filter').find('option').first().prop('selected', true);
                $('#channel_filter').find('option').first().prop('selected', true);
                $('#category_filter').find('option').first().prop('selected', true);
            });

            $('.reserve').click(function () {
                $(this).next('.order-quantity').toggle('slow');
            });

            @if (isset($item))
            $('.loss').click(function () {
                if (confirm(areyousure))
                    window.location.href = window.location + "/delete/" + this.getAttribute('name');
            });
            $('.profit').click(function () {
                if (confirm(areyousure)) window.location.href = window.location + "/success/" + this.getAttribute('name');
            });
            @endif

            $('.comment-button').click(function () {
                $(this).parent().next('.comments-body-main').toggle('slow');
            });
            $('.vote-range').change(function () {
                var data = $(this).closest('form').serializeArray();
                $.ajax({
                    url: '{{route('order.vote')}}',
                    data: data,
                    success: function (mark) {
                        $('#card-' + data[0]['value']).find('.card-point').html(mark);
                    },
                    error: function () {
                        console.log('e')
                    },
                    dataType: 'html'
                })
            });

            $('.inactive *').click(function (event) {
                event.preventDefault();
            }).attr('disabled', true);
            $('.inactive button').off();

        })(jQuery);
    </script>
@endsection
