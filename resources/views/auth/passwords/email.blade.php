@extends('layouts.app')

@section('content')
<div class="container-fluid d-flex align-items-center justify-content-center">
    <div class="col-lg-3  rounded text-center p-3" style="background-color: rgba(255, 255, 255, 0.6);">
        <span class="h2">SAT-TCC</span>
        <form method="POST" action="{{ route('password.email') }}">
            @csrf
           
            <div class="">
                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="Email" autofocus>
                
                @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
                
               
            </div>
            <button type="submit" class="btn btn-gold w-50 my-2">
                {{ __('Enviar Email') }}
            </button>
        </form>

       
    </div>
</div>
@endsection
@push('scripts')
    
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
