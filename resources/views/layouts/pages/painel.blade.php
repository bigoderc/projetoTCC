@extends('layouts.app')

@section('content')
    @include('layouts.navbars.navbar_painel')
    @yield('content-page')
    @include('layouts.footers.footer_painel')
@endsection