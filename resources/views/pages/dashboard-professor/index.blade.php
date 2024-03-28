@extends('layouts.pages.dashboard')

@section('content-page')
    @component('components.filter',
    [
        'action' => 'dashboardAluno/search', // Define a rota para submissão do formulário
        'id' =>'filter_dashboard_aluno', // Define a rota para submissão do formulário
        'table' => 'my_table_id', // Define a rota para submissão do formulário
        'name' => 'Valor Padrão do Nome', // Defina aqui o valor padrão para o campo "name"
        'areas' =>[], // Defina aqui o valor para o campo "email" vindo de uma variável, por exemplo
        'professores' =>[], // Defina aqui o valor para o campo "email" vindo de uma variável, por exemplo
    ])
    @endcomponent
    <div class="content-page">
        <div class="card-body">
            <div class="card">
                <div class="card-header card-title text-white bg-transparent border-0 m-3">
                    <span class="h4">Temas</span>
                </div>
                
                <div class="card-body">
                    <button class="btn btn-secondary text-white me-0 mb-3" data-toggle="modal" data-target="#filter">
                        <i class="fa fa-filter"></i> Filtro
                    </button>
                    <div id="toolbar">
                        
                        <div class="modal fade" id="searchCaminhao" tabindex="-1" aria-labelledby="searchCaminhao"
                            aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="titulo">Buscar Ordem</h5>
                                        <button type="button" class="close" onclick="fecharModal()" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <form id="addLinha" class="needs-validation" novalidate>
                                        @csrf
                                        <div class="modal-body" class="my-2">
                                            <div class="col">
                                                <label for="tempo_carregamento">Ordem</label>
                                                <div class="input-group">
                                                    <input type="text" class="form-control" id="placa"
                                                        name="placa">
                                                    <div class="input-group-append">
                                                        <button class="btn btn-outline-secondary" onclick="getAll()"
                                                            title="Pesquisar" type="button">
                                                            <i class="fa fa-search"></i>
                                                        </button>
                                                    </div>
                                                    <div class="invalid-feedback">
                                                        Dados com a chave específicada não foram encontrados.
                                                    </div>
                                                </div>
                                            </div>
                                            <hr>

                                        </div>
                                        <div class="modal-footer">
                                            <div class="d-flex flex-wrap justify-content-between">
                                                <button type="button" class="btn btn-secondary mb-2 mr-2"
                                                    onclick="fecharModal()">Fechar</button>
                                                <button type="submit" id="salvar"
                                                    class="btn btn-primary mb-2 mr-2">Buscar</button>
                                                <button type="button" id="bloquear" onclick="bloquearEntrada()"
                                                    class="btn btn-primary mb-2 mr-2 d-none">Bloquear Entrada</button>
                                                <button type="button" id="saida" onclick="liberarSaida()"
                                                    class="btn btn-primary mb-2 mr-2 d-none ">Liberar Saída</button>
                                            </div>
                                        </div>

                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="container pe-0">
                        <div class="main-timeline" id="timeline-container">
                            <!-- Os cards serão renderizados aqui -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @include('pages.dashboard-professor.parts.info')
        @include('pages.dashboard-professor.parts.deferido')
    </div>
@endsection

@push('scripts')
    <script>
        //Ajax TOKEN
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        });

        //Adicionar uma nova linha e lançar via ajax
        $(document).ready(function() {
            getAll()
            
        });
        $("#searchCaminhao").submit(function(event) {
            event.preventDefault();
            var placa = document.getElementById('placa').value;
            getAll()
        })
        //Excluir uma nova linha
        function getAll() {
            const query_params = new URLSearchParams(window.location.search);
            partialLoader();
            $.ajax({
                url: query_params.has('todos') ? `{{ url('dashboardProfessor/linkThemeCheck?todos=true') }}` :`{{ route('dashboardProfessor.linkThemeCheck') }}`,
                type: "GET",
                dataType: "json",
                success: function(response) {
                    renderizarCards(response);
                    partialLoader(false);
                    if(!query_params.has('todos')){
                        getNotification()
                    }
                    
                },
                error: function(xhr, status, error) {
                    partialLoader(false);
                    errorResponse(xhr.status, xhr.responseJSON.data, xhr.responseText);
                }
            });
        }
        function getNotification() {
            $.ajax({
                url: `{{ route('dashboardProfessor.notification') }}`,
                type: "GET",
                dataType: "json",
                success: function(response) {
                    console.log(response);
                    if(response > 0){
                        var s = response > 1 ? 's' : '';
                        notification('info',  'Proposta de tema', `Você possui ${response} novo${s} tema${s} para avaliação!`).then((result) => {
                            if(result.isConfirmed){
                                // Redirecionamento para a página atual com um parâmetro 'todos=true'
                                window.location.href = window.location.href + '?todos=true';

                            }
                        });
                    }
                    
                },
                error: function(xhr, status, error) {
                    errorResponse(xhr.status, xhr.responseJSON.data, xhr.responseText);
                }
            });
        }

        function fecharModal() {
            $('#searchCaminhao').modal('hide');
            // Realiza as ações para redefinir o estado inicial do modal

            // Por exemplo, você pode redefinir os campos de entrada do formulário dentro do modal
            $('input:not(#data_fim, #data_inicio)').val("");

            // Também pode redefinir outras partes do modal, como alterar classes CSS ou conteúdo

            // Execute outras ações necessárias para redefinir o estado inicial
            $(`#salvar`).prop('disabled', false);
            $('.form-motorista').addClass('d-none');
            $('#bloquear').addClass('d-none');
            $(`#salvar`).text(`Buscar`);
            // Se desejar, você pode adicionar um atraso antes de redefinir o estado inicial para dar tempo ao modal de se fechar completamente
            // setTimeout(function() {
            //   // Realize as ações de redefinição do estado inicial aqui
            // }, 500);
        }

        function renderizarCards(data) {
            const timelineContainer = document.getElementById('timeline-container');

            // Limpe o conteúdo existente (caso haja)
            timelineContainer.innerHTML = '';

            // Itere pelos dados e crie os cards
            data.forEach(function(item, index) {
                let nome_areas = [];
                for (const area of item.areas) {
                        nome_areas.push(area?.nome ?? '');
                    }
                    nome_areas = [...new Set(nome_areas)];

                // Criar uma string separada por vírgulas
                var areas_to_string = nome_areas.join(', ');
                const card = document.createElement('div');
                card.className = 'timeline right';
                card.innerHTML = `
                <div class="card styled-border placeholder-glow shadow-sm mb-2">
                    <div class="card-body pb-0">
                        <div class="card-title text-white fw-bold mb-1"><span class="ml-1 mt-2  big">${item.nome}</span></div>
                        <div>
                            <span class="small fw-bold">Descrição: </span>
                            <span class=" small">${item.descricao ?? ''}</span>
                        </div>
                        <div>
                            <span class="small fw-bold">Área: </span>
                            <span class="small">${areas_to_string ?? ''}</span>
                        </div>
                       
                        <div>
                            <span class="small fw-bold">Escolhido por: </span>
                            <span class="small">${item.tema_aluno?.aluno?.nome ?? ''}</span>
                        </div>
                        <div>
                            <span class="small fw-bold">Lançado por: </span>
                            <span class="small">${item.criado?.name ?? ''}</span>
                        </div>
                        <div>
                            <span class="small fw-bold">Lançado em: </span>
                            <span class="small">${item.created_at ?? ''}</span>
                        </div>
                        <div>
                            <span class="small fw-bold">Status: </span>
                            <span class="small">${item.tema_aluno?.deferido ==true ? 'Deferido':(item.tema_aluno?.deferido ==false ? 'Indeferido' : 'Aguardando')}</span>
                        </div>    
                        <button type="button" title="Exibir detalhes" class="btn btn-primary btn-sm mb-3" onclick="showDetails(${item.id})">
                            <i class="fa fa-info"></i>
                        </button>
                        <a href="mailto:${item.criado?.email}" title="Enviar e-mail" class="btn btn-success btn-sm mb-3">
                            <i class="fa fa-envelope"></i>
                        </a>
                        
                        ${item.tema_aluno?.deferido !=true ? `
                                <button type="button" title=Aceitar tema" class="btn btn-warning btn-sm mb-3" onclick="showDeferido(${item.id})">
                                    <i class="fa fa-check-square"></i>
                                </button>`:``}
                            
                        </div>

                    </div>
                </div>
            `;

                timelineContainer.appendChild(card);
            });
        }
        function changeStatus(params,column) {
            deleteAlert().then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ route('dashboardAluno.linkTheme') }}",
                        type: "POST",
                        data: {tema_id:params, column:column},
                        dataType: "json",
                        success: function(response) {
                            renderizarCards(response);
                            partialLoader(false);
                            
                            successResponse();
                            
                        },
                        error: function(xhr, status, error) {
                            partialLoader(false);
                            errorResponse(xhr);
                        }
                    });
                }
            });
        }
        function changeOrientador(params) {
            setprofessor(params);
        }
        function showDeferido(params) {
            setDeferido(params);
        }
        function showDetails(params) {
            setInfo(params)
        }
    </script>
@endpush
@push('css')
    <style>
        .texto-limitado {
            overflow: hidden;
            white-space: nowrap;
            text-overflow: ellipsis;
            max-width: 100%; /* Ou qualquer largura desejada */
            display: inline-block; /* Isso é importante para o texto não quebrar em várias linhas */
        }
    </style>
@endpush
