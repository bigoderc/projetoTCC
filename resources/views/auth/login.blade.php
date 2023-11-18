@extends('layouts.app')

@section('content')
<div class="container-fluid d-flex align-items-center justify-content-center">
    <div class="col-lg-3  rounded text-center p-3" style="background-color: rgba(255, 255, 255, 0.6);">
        <img class="mr-1 mb-2" src="#" alt="logo da empresa" width="100">
        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="">
                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="Email" autofocus>
                
                @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
                
                <div class="form-group">
                    <div class="password-icon password">
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror mt-2" name="password" required autocomplete="current-password" placeholder="Senha">
                        <i onclick="showPassword(event)" id="eyeIcon" class="fa fa-eye mt-2"></i>
                    </div>
                </div>
                @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <button type="submit" class="btn btn-gold w-50 my-2">
                {{ __('Entrar') }}
            </button>
        </form>

        @if (Route::has('password.request'))
        <a class="text-black" href="{{ route('password.request') }}">
            {{ __('Esqueceu sua senha?') }}
        </a>
        @endif
    </div>
</div>
@endsection
@push('scripts')
    <script>
        function showPassword(event) {
            const element = event.target.parentNode.querySelector('input');
            const eyeIcon = document.getElementById('eyeIcon');

            element.type = element.type === 'password' ? 'text' : 'password';
            eyeIcon.classList.toggle('fa-eye-slash', element.type === 'text');
            eyeIcon.classList.toggle('fa-eye', element.type === 'password');
        }
    </script>
@endpush
@push('css')
<style>
    .container-fluid {
        background-color:rgb(12, 160, 79);
        background-repeat: no-repeat;
        background-size: cover;
        width: 100vw;
        height: 100vh;
        position: fixed;
        top: 0;
        left: 0;
    }
    .password-icon {
            position: relative;
            display: inline-block;
            width: 100%;
        }

        .password-icon i {
            position: absolute;
            top: 20px;
            right: 10px;
            transform: translateY(-50%);
            cursor: pointer;
        }
    .rounded {
        border-radius: 10px !important;
    }
</style>
@endpush
