@if ($message = Session::get('success'))
    <div class="alert alert-success" id="alert-box" role="alert">
        {{ $message }}
    </div>
@endif

@if ($message = Session::get('error'))
    <div class="alert alert-danger" id="alert-box" role="alert">
        {{ $message }}
    </div>
@endif
