@extends('layouts.pages.dashboard')

@section('content-page')
    <div class="content-page">
        <div class="card-body">
            <div class="card">
                <h1 class="fw-bold text-primary pt-5 text-center">Dashboard SAT-TCC</h1>

                <div class="container  py-5">
                    <div class="row">
                        <div class="col-md-12 my-1">
                            <h2 class="h4">Bem-vindo(a) ao Sistema SAT TCC</h2>
                            <div class="card">
                                <div class="card-body">
                                    <p>O SAT-TCC é um sistema web desenvolvido para simplificar a escolha de temas para o
                                        Pré-TCC de estudantes aptos a realizar. Este sistema facilita não apenas a seleção
                                        de um tema relevante para o trabalho de conclusão de curso, mas também simplifica o
                                        processo de encontrar um orientador adequado. Ele leva em consideração a afinidade
                                        entre a área do tema escolhido pelo aluno e a expertise do orientador, garantindo
                                        uma combinação harmoniosa e produtiva para o desenvolvimento do trabalho acadêmico.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 my-1">
                            <h2 class="h4">Principais funcionalidades</h2>
                            <div class="card">
                                <div class="card-body">
                                    <ul class="nav flex-column">
                                        <li class="nav-item">
                                            * Cadastro de informações relevantes para o processo de escolha e gerenciamento
                                            de um tema de TCC.
                                        </li>
                                        <li class="nav-item">
                                            * Estruturar e disponibilizar acesso às propostas de temas já apresentadas no
                                            Pré-TCC e TCC.
                                        </li>
                                        <li class="nav-item">
                                            * Registrar e apresentar propostas de temas para o Trabalho de Conclusão de
                                            Curso (TCC)
                                        </li>
                                        <li class="nav-item">
                                            * Disponibilizar esses temas para que os alunos possam escolher com base na área
                                            de sua preferência, considerando também a afinidade com o orientador na
                                            respectiva área de escolha.
                                        </li>
                                        <li class="nav-item">
                                            * Implementar uma seção onde os professores possam visualizar quais alunos os
                                            escolheram como orientadores, permitindo-lhes verificar se há afinidade para
                                            ajudar o aluno no tema escolhido. Essa funcionalidade também incluirá a
                                            capacidade de deferir ou indeferir temas nos quais os professores foram
                                            selecionados, considerando a possibilidade de falta de afinidade com o tema ou a
                                            impossibilidade de orientar mais alunos.
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
    <script></script>
@endpush
