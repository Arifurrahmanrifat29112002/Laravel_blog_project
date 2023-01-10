@extends('auth.layouts.guest')

@section('conect')
    <div class="main-wrapper">
        <div class="page-wrapper full-page">
            <div class="page-content d-flex align-items-center justify-content-center">

                <div class="row w-100 mx-0 auth-page">
                    <div class="col-md-8 col-xl-6 mx-auto">
                        <div class="card">
                            <div class="row">
                                <div class="col-md-4 pr-md-0">
                                    <div class="auth-left-wrapper">

                                    </div>
                                </div>
                                <div class="col-md-8 pl-md-0">
                                    <div class="auth-form-wrapper px-4 py-5">
                                        <a href="#" class="noble-ui-logo d-block mb-2">UI<span>Blog</span></a>
                                        <h5 class="text-muted font-weight-normal mb-4">Welcome back! Log in to your account.
                                        </h5>
                                       @if (session('status'))
                                       <div class="alert alert-success" role="alert">
                                        <p class="text-danger">{{ session('status') }}</p>
                                    </div>
                                       @endif

                                            <form class="forms-sample" method="POST" action="{{ route('login') }}">
                                                @csrf
                                                <div class="form-group">
                                                    <label for="exampleInputEmail1">Email address</label>
                                                    <input type="email" class="form-control" id="exampleInputEmail1"
                                                        placeholder="Email" name="email" value="{{ old('email') }}">
                                                    @error('email')
                                                        <div class="alert alert-success" role="alert">
                                                            <p class="text-danger">{{ $message }}</p>
                                                        </div>
                                                    @enderror
                                                </div>
                                                <div class="form-group">
                                                    <label for="exampleInputPassword1">Password</label>
                                                    <input type="password" class="form-control" id="exampleInputPassword1"
                                                        autocomplete="current-password" placeholder="Password"
                                                        name="password">
                                                    @error('password')
                                                        <div class="alert alert-success" role="alert">
                                                            <p class="text-danger">{{ $message }}</p>
                                                        </div>
                                                    @enderror
                                                </div>
                                                <div class="form-check form-check-flat form-check-primary">
                                                    <label class="form-check-label">
                                                        <input type="checkbox" class="form-check-input" name="remember">
                                                        Remember me
                                                    </label>
                                                </div>
                                                @if (Route::has('password.request'))
                                                    <a class="" href="{{ route('password.request') }}">
                                                        Forgot your password?
                                                    </a>
                                                @endif
                                                <button type="submit" class="btn btn-info d-block w-60">Log in</button>
                                                <a href="{{ route('register') }}" class="d-block mt-3 text-muted">Not a user? Sign
                                                    up</a>
                                            </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection













