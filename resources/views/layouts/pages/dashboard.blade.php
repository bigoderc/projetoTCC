@extends('layouts.app')

@section('content')
    @include('layouts.navbars.navbar_sidebar')
    @yield('content-page')
@endsection

@push('scripts')
<script>
    $("#btn").click(function() {
        $('.sidebar').toggleClass("open");
        $('#btn').toggleClass("fa-align-justify fa-align-right");
    });

    $(".content-page").click(function() {
        $('.sidebar').removeClass("open");
        $('#btn').removeClass("fa-align-right");
        $('#btn').addClass("fa-align-justify");
    });
</script>
@endpush