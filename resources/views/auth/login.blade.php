@extends('layouts.app')
@section('title', 'Poll Maker - Login')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-8 col-md-6 col-lg-4">
                <div id="login" class="text-center">
                    <img class="img-fluid my-5" src="{{ asset('images/logo.png') }}" alt=""/>
                    <form action="{{ route('login') }}" method="post">
                        @csrf
                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right"></label>
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                                   name="email" value="{{ old('email') }}" placeholder="Email" required
                                   autocomplete="email" autofocus>
                            @error('email')
                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>
                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right"></label>
                            <input id="password" type="password"
                                   class="form-control @error('password') is-invalid @enderror" name="password"
                                   placeholder="Contraseña" required autocomplete="current-password">
                            @error('email')
                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>
                        <div class="form-group row justify-content-center">
                            <div class="form-check ">
                                <input class="form-check-input" type="checkbox" name="remember"
                                       id="remember" {{ old('remember') ? 'checked' : '' }}>
                                <label class="form-check-label" for="remember">Recuérdame</label>
                            </div>
                        </div>
                        <div class="form-group row justify-content-center">
                            <button type="submit" class="btn btn-block btn-primary my-4 text-uppercase">
                                Iniciar sesión
                            </button>
                        </div>
                        <div class="form-group row justify-content-center">
                            @if (Route::has('register'))
                                <a class="nav-link" href="{{ route('register') }}">¿No tienes cuenta? Regístrate</a>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
