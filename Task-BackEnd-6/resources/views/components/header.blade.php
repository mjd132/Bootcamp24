<header class="border-bottom mb-4">
    <div class="container p-2 d-flex justify-content-between align-items-center">
        <h2>Majid Blog</h2>
        @auth
            <div>
                <h6>You logged in as {{ Auth::user()->email }} <a href="{{ route('auth.logout') }}">Logout</a></h6>

            </div>
        @else
            <div>
                <a class="btn btn-warning" href="{{ route('login') }}" role="button">Login</a>
                <a class="btn btn-primary" href="{{ route('register') }}" role="button">Signup</a>
            </div>
        @endauth


    </div>
</header>
