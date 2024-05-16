@session('message')
    <div class="m-3 alert alert-success alert-dismissible fade show" id="x-alert">
        {{ session('message') }}
    </div>
@endsession
@session('error')
    <div class="m-3 alert alert-danger alert-dismissible fade show" id="x-alert">
        {{ session('error') }}
    </div>
@endsession
@if ($errors->all())
    @foreach ($errors->all() as $error)
        <div class="m-3 alert alert-danger alert-dismissible fade show" id="x-alert">
            {{ $error }}
        </div>
    @endforeach
@endif
{{-- TODO change style --}}
