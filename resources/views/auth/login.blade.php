@extends('layouts.app')

@section('content')
<form method="POST" action="{{ route('login') }}">
    @csrf
    <div class="form-group has-feedback">
        <input id="name" type="name" placeholder="Nombre de Usuario" class="form-control" @error('name') is-invalid @enderror name="name" value="{{ old('name') }}" required autocomplete="name" style="text-transform:uppercase" autofocus>
        <span class="glyphicon glyphicon-user form-control-feedback"></span>
        @error('name')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>

    <div class="form-group has-feedback">
        <input id="password" type="password" placeholder="CONTRASEÑA" class="form-control" @error('password') is-invalid @enderror name="password" required autocomplete="current-password">
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
        @error('password')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>

    <div class="row">
        <div class="col-xs-6">
            <div class="checkbox icheck">
                <label for="remember">
                <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                    {{ __('Recordarme') }}
                </label>
            </div>
        </div>

        <div class="col-xs-6">
            <button type="submit" class="btn btn-primary btn-block btn-flat">
                {{ __('Iniciar Sesión') }}
            </button>
        </div>
    </div>
</form>
@if (Route::has('password.request'))
    <a class="text-center" href="{{ route('password.request') }}">
        {{ __('¿Olvidó su contraseña?') }}
    </a>
@endif
@endsection
