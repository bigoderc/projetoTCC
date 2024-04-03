@extends('layouts.pages.dashboard')

@section('content-page')
<div class="content-page">
    <div class="card-body">
        <div class="card">
            <h1 class="fw-bold text-primary pt-5 text-center">Dashboard SAT-TCC</h1>

            <div class="container mt-3 py-5">
                <div class="row">
                    <div class="col-md-6 my-1">
                        <h2>Principais funcionalidades</h2>
                        <div class="card">
                            <div class="card-body">
                                <ul class="nav flex-column">
                                    <li class="nav-item">
                                       * Cadastro de informações relevantes
                                    </li>
                                    <li class="nav-item">
                                        * Estruturar e fornecer acesso aos trabalhos já apresentados no Pré-TCC e TCC
                                    </li>
                                    <li class="nav-item">
                                        * Registrar e apresentar propostas de temas para o Trabalho de Conclusão de Curso (TCC)
                                    </li>
                                    <li class="nav-item">
                                        * Disponibilizar esses temas para que os alunos possam escolher com base na área de sua preferência, considerando também a afinidade com o orientador na respectiva área de escolha.
                                    </li>
                                    <li class="nav-item">
                                        * Disponibilizar uma seção onde os professores possam visualizar quais alunos os escolheram como orientadores, permitindo-lhes verificar se têm afinidade para ajudar o aluno no tema escolhido, tendo em mente que outros alunos também podem lançar propostas de temas.
                                    </li>
                                    <li class="nav-item">
                                        * Funcionalidade de deferir ou indeferir temas nos quais os professores foram escolhidos, uma vez que pode ocorrer falta de afinidade do professor com o tema ou a impossibilidade de orientar mais alunos.
                                    </li>
                                                                        
                                </ul>
                            </div>
                        </div>
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