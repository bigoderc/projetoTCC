<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="{{ url('/img/LSMais_colored.svg') }}" />
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

     <!-- teste - select -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
 


    <title>GRC</title>

    <!-- Styles -->
    <link href="{{ url('css/app.css') }}" rel="stylesheet">
    <link href="{{ url('css/bootstrap-table.css') }}" rel="stylesheet">
    <link href="{{ url('css/bootstrap-editable.css') }}" rel="stylesheet">
    <link href="{{ url('css/style.css') }}" rel="stylesheet">
    <link href="{{ url('css/fullcalendar.css') }}" rel="stylesheet">
    <link href="{{ url('css/nucleo-icons.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/css/select2.min.css" rel="stylesheet"/>
  
    @stack('css')
</head>
<body class="bg-light">
    @yield('content')
    
    <!-- Scripts -->
    <script src="{{ url('js/jquery.js') }}"></script>
    <script src="{{ url('js/bootstrap.bundle.js') }}"></script>
    <script src="{{ url('js/app.js') }}"></script>
    <script src="{{ url('js/chart.js') }}"></script>
    <script src="{{ url('js/chartjs.min.js') }}"></script>
    <script src="{{ url('js/bootstrap-table.js') }}"></script>
    <script src="{{ url('js/bootstrap-editable.js') }}"></script>
    <script src="{{ url('js/bootstrap-table-editable.js') }}"></script>
    <script src="{{ url('js/bootstrap-table-locale-all.js') }}"></script>
    <script src="{{ url('js/bootstrap-table-export.js') }}"></script>
    <script src="{{ url('js/tableExport.min.js') }}"></script>
    <script src="{{ url('js/moment.js') }}"></script>
    <script src="{{ url('js/fullcalendar.js') }}"></script>
    <script src="{{ url('js/locale-all.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://www.gstatic.com/charts/loader.js"></script>
    <script src="https://use.fontawesome.com/118f1fcf7b.js"></script>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/i18n/defaults-*.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/js/standalone/selectize.min.js" integrity="sha256-+C0A5Ilqmu4QcSPxrlGpaZxJ04VjsRjKu+G82kl5UJk=" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/css/selectize.bootstrap3.min.css" integrity="sha256-ze/OEYGcFbPRmvCnrSeKbRTtjG4vGLHXgOqsyLFTRjg=" crossorigin="anonymous" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>
    <!-- select2 -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/js/select2.full.min.js"></script>
    <!-- Sweetalert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- plugin jquery dataTable -->
    <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
    <!-- Mascaras jquery -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>
    <!-- Chart JS -->
    @stack('scripts')

</body>
</html>
