
<div class="filter">
    <form action="{{route('main.filter')}}" name="filter-form" method="POST">
        @csrf
        <div class="form-group">
            <label for="season">Сезон</label>
            <select id="season" name="season" class="form-control">
                <option value="">Все</option>
                @foreach($seasons as $s)
                    <option value="{{$s}}">{{ $s}}</option> @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="country">Страна</label>
            <select id="country" name="country" class="form-control">
                <option value="">Все</option>
                @foreach($countries as $c)

                    <option value="{{ $c->country_id }}">{{ $c->country->name }}</option> @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="category">Категория</label>
            <select id="category" name="category" class="form-control">
                <option value="">Все</option>
                @foreach($categories as $c)
                    <option value="{{ $c->category_id }}">{{ $c->category->name }}</option> @endforeach
            </select>
        </div>

        @if(auth()->user()->can_see_all_prices())
            <div class="form-group">
                <label for="channel">Канал сбыта</label>
                <select id="channel" name="channel" class="form-control">
                    <option value="">Все</option>
                    <option value="CityBluzka">CityBluzka</option>
                    <option value="OLKO">OLKO</option>
                    <option value="Vip-опт">Vip-опт</option>
                    <option value="Опт">Опт</option>
                </select>
            </div>
        @endif

        <div class="form-group">
            <label for="fio">ФИО</label>
            <select id="fio" name="fio" class="form-control">
                <option value="">Все</option>
                @foreach($users as $u)
                    <option value="{{ $u->user_id }}">{{ $u->user->name }}</option> @endforeach
            </select>
        </div>
        <div class="form-group">
            <button id="filter-apply" type="submit" class="btn btn-primary " style="display: block;">
                Применить
            </button>
        </div>
    </form>
</div>
