@extends('layouts.app')

@section('content')
<div class="container-fluid d-flex align-items-center justify-content-center">
    <div class="col-lg-3 bg-primary rounded text-center p-3">
        <img class="mb-4" src="{{ asset('img/LSMais.svg') }}" alt="" width="80">
        
        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="bg-white mb-2 p-4 radius-main">
                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="Email" autofocus>
                
                @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
                
                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror mt-2" name="password" required autocomplete="current-password" placeholder="Senha">
                
                @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
                    
                <div class="mt-2">
                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
        
                    <label class="form-check-label" for="remember">
                        {{ __('Lembrar') }}
                    </label>
                </div>
            </div>
            <button type="submit" class="btn btn-gold w-50 my-2">
                {{ __('Entrar') }}
            </button>
        </form>

        @if (Route::has('password.request'))
        <a class="text-white" href="{{ route('password.request') }}">
            {{ __('Esqueceu sua senha?') }}
        </a>
        @endif
    </div>
</div>
@endsection

@push('css')
<style>
    .container-fluid {
        height: 100vh;
    }

    .rounded {
        border-radius: 10px !important;
    }
</style>
@endpush
