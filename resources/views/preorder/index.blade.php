@extends('layouts.layout')
@section('title')Предзаказ@endsection
@section('content')
    <main>
        <div id="alert"></div>
        <div id="success"></div>
        <div class="container">

            @include('layouts.include.result_message')

            @foreach($items as $item)
                <div class="card card-wrap @if(!is_null($item->ordered)) inactive @endif " id="card-{{$item->id}}">
                    <div class="card-body p-0">
                        <div class="img-container">
                            @foreach(explode(',', $item->photo) as $pic)
                                <img class="" src="storage/preorder/images/{{$pic}}" alt="pic">
                            @endforeach
                        </div>
                        <div class="channels">
                            @foreach(explode(',', $item->channel) as $channel)
                                <span>{{$channel}}</span>
                            @endforeach
                        </div>
                        <div class="info-container">
                            <div class="left-col">
                                <div class="categories">
                                    <span>{{$item->id}}.</span>
                                    <span>{{$item->gg->alias}},</span>
                                    <span>{{$item->category->name}}</span>
                                </div>
                                <div class="name">
                                    <span>{{$item->user->name}}</span>
                                </div>
                                <div class="country">
                                    <span>{{$item->country->name}},</span>
                                    @if($item->ready_or_not == 1)
                                        <span>Готовое</span>
                                    @else
                                        <span>Заказное</span>
                                    @endif
                                </div>
                                <div class="date">
                                    <span>{{$item->date_start_sale}}</span>
                                </div>
                                <div class="season">
                                    @if($item->season == 'ВЛ')
                                        <span>Весна-лето</span>
                                    @else
                                        <span>Осень-Зима</span>
                                    @endif
                                </div>
                                <div class="order">
                                    @if(count($item->reserve))
                                        <div class="reserved @if($user->id == $item->user_id || $user->can_decide()) dropdown-toggle @endif ">
                                            <span>Заказали: {{count($item->reserve)}} чел.</span>
                                        </div>
                                        @if($user->id == $item->user_id || $user->can_decide())
                                            <div class="reserved-info">
                                                @foreach($item->reserve as $reserve)
                                                    <p>{{$reserve->user->name}}: {{$reserve->quantity}} шт.</p>
                                                @endforeach
                                            </div>
                                        @endif
                                    @endif
                                </div>
                            </div>
                            <div class="right-col">
                                <div class="prices">
                                    <div class="main-prices">
                                        @if($user->can_see_all_prices())
                                            <p class="price"> Закупка: {{round($item->price)}} {{$item->country->currency}}</p>
                                            <p class="self-price">СС: {{$item->selfprice()}} {{$item->country->currency}}</p>
                                            @foreach($item->sellprice() as $channel => $price)
                                                <div class="channel-prices">
                                                    <span class="channel-name">{{$channel}}: </span>
                                                    <span class="channel-price">{{$price}} грн.</span>
                                                </div>
                                            @endforeach
                                        @else
                                            <div class="channel-prices">
                                                <span class="channel-name">{{$user->role}}: </span>
                                                <span class="channel-price">{{$item->sellprice()}} грн.</span>
                                            </div>
                                        @endif
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="rating-container">
                            <div class="rating-mark" id="item-mark-{{$item->id}}">
                                <p>
                                    @if(!is_null($item->rating)){{round($item->rating, 1)}} @endif
                                </p>
                            </div>
                            <div class="form-container">
                                <form class="rating-form" action="#">
                                    <input type="hidden" name="model" value="{{$item->id}}">
                                    <input type="range" name="mark" min="0" max="5" value="0" step="0.1"
                                           class="form-control-range vote-range">
                                    <div class="d-flex justify-content-between range-num-wrap">
                                        <p>0</p>
                                        <p>5</p>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="admin-container">
                            @if(!$item->owner())
                                <div class="reserve-container">
                                    <button class="btn btn-secondary admin-button admin-button-reserve">Резерв</button>
                                    <div class="reserve-form-container">
                                        <form action="">
                                            <input type="hidden" name="reserve" value="{{$item->id}}">
                                            <input type="number" class="reserve-input form-control width" name="reserve-amount">
                                            <button class="reserve-button btn btn-success">Резерв</button>
                                        </form>
                                    </div>
                                </div>
                            @endif
                            <button class="btn btn-primary admin-button admin-button-comments">КОММЕНТАРИИ
                                @if(count($item->comments))
                                    <span class="comments-count">
                                        {{count($item->comments)}}
                                    </span>
                                @endif
                            </button>
                            @if($item->owner() or $user->admin())
                                <a href="{{route('edit.index', $item->id)}}" class="btn btn-warning admin-button">Редактирование</a>
                            @endif
                            @if($item->owner() or $user->can_decide())
                                <button name="{{$item->id}}" class="btn btn-success admin-button order-success">В Заказ</button>
                                <button name="{{$item->id}}" class="btn btn-danger btn-success admin-button order-denied">Отказ</button>
                            @endif
                        </div>
                        <div class="comments">
                            <div class="new-comment">
                                <form action="#">
                                    <input type="hidden" name="item" value="{{$item->id}}">
                                    <textarea name="comment" id="comment-{{$item->id}}" rows="3"></textarea>
                                    <button class="btn btn-primary comment-button">Отравить</button>
                                </form>
                            </div>
                            <div class="comment-wrap">
                                @foreach($item->comments as $comment)
                                    <div class="comment-body">
                                        <h5>{{$comment->user->name}}</h5>
                                        <small>{{\Carbon\Carbon::parse($comment->created_at)->format('d-m-Y, H:i')}}</small>
                                        <p>{{$comment->comment}}</p>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
        @endforeach


    </main>

@endsection
<script>
    let vote_route = '{{route('rating.vote')}}'
    let comment_route = '{{route('comment')}}'
    let reserve_route = '{{route('reserve')}}'
    let user = '{{$user->name}}'
</script>
