@extends('layouts.layout')
@section('styles')
    <link rel="stylesheet" href="/css/admin.css">
@endsection
@section('content')
    <div class="container">

        @include('layouts.include.result_message')

        <div class="form-block" id="selfprice-block">
            <h4>Себестоимость</h4>
            <form action="{{route('selfprice.store')}}" method="post" id="selfprice-form">
                @csrf
                <div class="select-wrap">
                    <div class="select-block transport-width">
                        <label for="selfprice-delivery">Транспорт</label>
                        <select class="form-control" name="selfprice-delivery" id="selfprice-delivery">
                            <option value="" disabled selected>-------</option>
                            @foreach($selftprice['delivery'] as $o)
                                <option value="{{$o}}">{{$o}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="select-block country-width">
                        <label for="selfprice-country">Страна</label>
                        <select class="form-control" name="selfprice-country" id="selfprice-country">
                            <option value="" disabled selected>-------</option>
                            @foreach($selftprice['country'] as $o)
                                <option value="{{$o}}">{{$o}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="select-block season-width">
                        <label for="selfprice-season">Сезон</label>
                        <select class="form-control" name="selfprice-season" id="selfprice-season">
                            <option value="" disabled selected>-------</option>
                            @foreach($selftprice['season'] as $o)
                                <option value="{{$o}}">{{$o}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="select-block group-width">
                        <label for="selfprice-group">Группа</label>
                        <select class="form-control" name="selfprice-group" id="selfprice-group">
                            <option value="" disabled selected>-------</option>
                            @foreach($selftprice['goods_group'] as $o)
                                <option value="{{$o}}">{{$o}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="input-wrap">
                    <input type="submit" class="btn btn-primary" value="Сохранить">
                    <input type="number" name="selfprice-val" class="form-control" id="selfprice-val">
                </div>
            </form>
        </div>

        <div class="form-block" id="sellprice-block">
            <h4>Наценка</h4>
            <form action="{{route('sellprice.store')}}" method="post" id="sellprice-form">
                @csrf
                <div class="select-wrap">
                    <div class="select-block transport-width">
                        <label for="sellprice-channel">Канал</label>
                        <select class="form-control" name="sellprice-channel" id="sellprice-channel">
                            <option value="" disabled selected>-------</option>
                            @foreach($sellprice['channel'] as $o)
                                <option value="{{$o}}">{{$o}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="select-block country-width">
                        <label for="sellprice-country">Страна</label>
                        <select class="form-control" name="sellprice-country" id="sellprice-country">
                            <option value="" disabled selected>-------</option>
                            @foreach($sellprice['country'] as $o)
                                <option value="{{$o}}">{{$o}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="select-block season-width">
                        <label for="sellprice-season">Сезон</label>
                        <select class="form-control" name="sellprice-season" id="sellprice-season">
                            <option value="" disabled selected>-------</option>
                            @foreach($sellprice['season'] as $o)
                                <option value="{{$o}}">{{$o}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="select-block group-width">
                        <label for="sellprice-group">Группа</label>
                        <select class="form-control" name="sellprice-group" id="sellprice-group">
                            <option value="" disabled selected>-------</option>
                            @foreach($sellprice['goods_group'] as $o)
                                <option value="{{$o}}">{{$o}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="input-wrap">
                    <input type="submit" class="btn btn-primary" value="Сохранить">
                    <input type="number" name="sellprice-val" class="form-control" id="sellprice-val">
                </div>
            </form>
        </div>

        <div class="form-block" id="delivery_time-block">
            <h4>Время доставки</h4>
            <form action="{{route('delivery_time.store')}}" method="post" id="delivery_time-form">
                @csrf
                <div class="select-wrap">
                    <div class="select-block w-45">
                        <label for="delivery_time-country">Страна</label>
                        <select class="form-control" name="delivery_time-country" id="delivery_time-country">
                            <option value="" disabled selected>-------</option>
                            @foreach($deliveryTime['country'] as $o)
                                <option value="{{$o->country_id}}">{{$o->name}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="select-block w-45">
                        <label for="delivery_time-delivery">Транспорт</label>
                        <select class="form-control" name="delivery_time-delivery" id="delivery_time-delivery">
                            <option value="" disabled selected>-------</option>
                            @foreach($deliveryTime['delivery'] as $o)
                                <option value="{{$o}}">{{$o}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="input-wrap">
                    <input type="submit" class="btn btn-primary" value="Сохранить">
                    <input type="number" name="delivery_time-val" class="form-control" id="delivery_time-val">
                </div>
            </form>
        </div>

    </div>
@endsection

@section('script')
    <script src="/js/admin.js"></script>
@endsection
