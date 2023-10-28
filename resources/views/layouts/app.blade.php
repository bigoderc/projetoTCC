<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="{{ url('/img/LSMais_colored.svg') }}" />
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Gestão Patio</title>

    <!-- Styles -->
    <link href="{{ url('css/app.css') }}" rel="stylesheet">
    <link href="{{ url('css/bootstrap-table.css') }}" rel="stylesheet">
    <link href="{{ url('css/bootstrap-editable.css') }}" rel="stylesheet">
    <link href="{{ url('css/style.css') }}" rel="stylesheet">
    <link href="{{ url('css/nucleo-icons.css') }}" rel="stylesheet">
    @stack('css')
</head>
<body class="bg-light">
    @yield('content')
    
    <!-- Scripts -->
    <script src="{{ url('js/jquery.js') }}"></script>
    <script src="{{ url('js/bootstrap.bundle.js') }}"></script>
    <script src="{{ url('js/app.js') }}"></script>
    <script src="{{ url('js/bootstrap-table.js') }}"></script>
    <script src="{{ url('js/bootstrap-editable.js') }}"></script>
    <script src="{{ url('js/bootstrap-table-editable.js') }}"></script>
    <script src="{{ url('js/bootstrap-table-locale-all.js') }}"></script>
    <!-- Importe a biblioteca jspdf antes do plugin de exportação do bootstrap-table -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
    <script src="{{ url('js/bootstrap-table-export.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.70/pdfmake.min.js"></script>
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.70/vfs_fonts.js"></script> --}}
    <script src="{{ url('js/tableExport.min.js') }}"></script>
    <script src="{{ url('js/moment.js') }}"></script>
    <script src="{{ url('js/fullcalendar.js') }}"></script>
    <script src="{{ url('js/locale-all.js') }}"></script>
    
    <script src="https://use.fontawesome.com/118f1fcf7b.js"></script>
    <script src="{{ url('js/notify.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Chart JS -->
    @stack('scripts')

</body>
</html>
