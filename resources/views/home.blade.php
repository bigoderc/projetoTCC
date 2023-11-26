@extends('layouts.pages.dashboard')

@section('content-page')
<div class="content-page">
    <h1 class="fw-bold text-primary pt-5 text-center">Dashboard GRC e Documentação</h1>

    <div class="container mt-3 py-5">
        <div class="row">
            <div class="col-md-6 my-1">
                <h2>Lista de Tecnologias utilizadas</h2>
                <ul class="nav flex-column">
                    <li class="nav-item">
                        "bootstrap": "^4.6.0"
                    </li>
                    <li class="nav-item">
                        "jquery": "^3.6.0"
                    </li>
                    <li class="nav-item">
                        "popper.js": "^1.16.1"
                    </li>
                    <li class="nav-item">
                        "fontawesome-free": "^5.15.4"
                    </li>
                    <li class="nav-item">
                        "chart.js": "^3.5.1"
                    </li>
                    <li class="nav-item">
                        "laravel": "^8.54"
                    </li>
                    <li class="nav-item">
                        "laravel/ui": "^3.3"
                    </li>
                    <li class="nav-item">
                        "php": "^8.0"
                    </li>
                    <li class="nav-item">
                        "bootstrap-table": "^1.18.3"
                    </li>
                    <li class="nav-item">
                        "tableexport.jquery.plugin": "^1.20.0"
                    </li>
                    <li class="nav-item">
                        "x-editable": "^1.5.1"
                    </li>
                </ul>
            </div>
            <div class="col-md-6 my-1">
                <h2>Gráficos</h2>
                <div class="card">
                    <div class="card-body">
                        <canvas id="myChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>      
</div>
@endsection

@push('scripts')
<script>

</script>
@endpush