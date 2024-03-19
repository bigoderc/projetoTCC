@extends('layouts.app')

@section('content')
<div class="container-fluid d-flex align-items-center justify-content-center">
    <div class="col-lg-3  rounded text-center p-3" style="background-color: rgba(255, 255, 255, 0.6);">
        <span class="h2">SAT-TCC</span>
        @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
        @endif
        <form method="POST" action="{{ route('password.update') }}">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">
            <div class="">
                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>
                
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
                    <div class="password-icon password">
                        <input id="password_confirmation" type="password" class="form-control @error('password_confirmation') is-invalid @enderror mt-2" name="password_confirmation" required autocomplete="current-password" placeholder="Confirmar Senha">
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
        background-color:#243147;
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
