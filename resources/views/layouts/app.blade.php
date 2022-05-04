<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Titulo_Generico') }}</title>

    <!-- Styles -->
    <link href="{{ url(mix('css/bootstrap-table.css')) }}" rel="stylesheet">
    <link href="{{ url(mix('css/bootstrap-editable.css')) }}" rel="stylesheet">
    <link href="{{ url(mix('css/app.css')) }}" rel="stylesheet">
    <link href="{{ url(mix('css/style.css')) }}" rel="stylesheet">
</head>
<body class="bg-light">
    @yield('content')

    <!-- Scripts -->
    <script src="{{ url(mix('js/jquery.js')) }}"></script>
    <script src="{{ url(mix('js/bootstrap.bundle.js')) }}"></script>
    <script src="{{ url(mix('js/chart.js')) }}"></script>
    <script src="{{ url(mix('js/app.js')) }}"></script>
    <script src="{{ url(mix('js/bootstrap-table.js')) }}"></script>    
    <script src="{{ url(mix('js/bootstrap-editable.js')) }}"></script>  
    <script src="{{ url(mix('js/bootstrap-table-editable.js')) }}"></script>
    <script src="{{ url(mix('js/bootstrap-table-locale-all.js')) }}"></script>
    <script src="{{ url(mix('js/bootstrap-table-export.js')) }}"></script>
    <script src="{{ url(mix('js/tableExport.min.js')) }}"></script>
    
    @stack('scripts')
</body>
</html>
