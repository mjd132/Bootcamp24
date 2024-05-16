<x-layout>
    <main class="d-flex align-items-center py-4 bg-body-tertiary vw-100 vh-100">
        <div class="form-signin w-25 mx-75 m-auto">
            <form action="{{ route('auth.register') }}" method="POST">
                @csrf
                <h1 class="h3 mb-3 fw-normal">Register</h1>
                <div class="form-floating">
                    <input type="text" name="name" class="form-control" id="floatingInput">
                    <label for="floatingInput">Name</label>
                </div>
                <div class="form-floating my-2">
                    <input type="email" name="email" class="form-control" id="floatingInput">
                    <label for="floatingInput">Email address</label>
                </div>
                <div class="form-floating ">
                    <input type="password" name="password" class="form-control" id="floatingPassword">
                    <label for="floatingPassword">Password</label>
                </div>
                <div class="form-floating my-2">
                    <input type="password" name="password_confirmation" class="form-control" id="floatingPassword">
                    <label for="floatingPassword">Confirm Password</label>
                </div>
                {{-- <div class="form-check text-start my-3">
                    <input class="form-check-input" type="checkbox" value="remember-me" id="flexCheckDefault">
                    <label class="form-check-label" for="flexCheckDefault">
                        Remember me
                    </label>
                </div> --}}
                <button class="btn btn-primary my-3 w-100 py-2" type="submit">Register</button>

            </form>
        </div>
    </main>
</x-layout>
