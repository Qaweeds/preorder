
@if(Session::has('success'))
    <div class="alert alert-success text-center card-wrap">
        <div class="alert-heading">
            {{ Session::get('success') }}
        </div>
    </div>
@endif
@if ($errors->any())
    <div class="alert alert-danger card-wrap">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
