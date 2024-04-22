<div class="modal fade" id="trabalhos" tabindex="-1" aria-labelledby="trabalhos" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="titulo">Informações</h5>
                <button type="button" class="close" onclick="fecharModalinfo()" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="row">
                <input type="hidden" class="form-control" id="carregamento_id" name="carregamento_id">
                <div class="col-12">
                    <div class="col">
                        <div class="modal-body" class="my-2">
                            <div class="container pe-0">
                                <div class="main-timeline" id="timeline-container2">
                                    <!-- Os cards serão renderizados aqui -->
                                </div>
                            </div>                                
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="fecharModalinfo()">Fechar</button>
            </div>
        </div>
    </div>
</div>
@push('scripts')
    <script>
        function getTrabalhos(params) {
            initTrabalhos(params);
            $('#professor').modal('hide');
            $('#trabalhos').modal('show');
        }

        function initTrabalhos(params) {
            partialLoader();
            $.ajax({
                url: `{{ url('tcc/findByProfessor/${params}') }}`,
                type: "GET",
                success: function(response) {
                    partialLoader(false);
                    renderizarCards2(response);
                },
                error: function(xhr, status, error) {
                    partialLoader(false);
                    errorResponse(xhr.status, xhr.responseJSON.data, xhr
                        .responseText);
                }
            });
        }
        function renderizarCards2(data) {
            const timelineContainer = document.getElementById('timeline-container2');

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
                        <div class=" card-title text-white fw-bold mb-1"><span class="ml-1 mt-2 texto-limitado big">${item.nome}</span></div>
                        <div>
                            <span class="small fw-bold">Aluno: </span>
                            <span class=" small">${item.aluno?.nome ?? ''}</span>
                        </div>
                        <div>
                            <span class="small fw-bold">Área: </span>
                            <span class="small">${areas_to_string ?? ''}</span>
                        </div>
                        <div>
                            <span class="small fw-bold">Apresentado em: </span>
                            <span class="small">${item.apresentado_desc ?? ''}</span>
                        </div>
                        <div>
                            <span class="small fw-bold">Orientado por: </span>
                            <span class="small">${item.professor.nome ?? ''}</span>
                        </div>
                        <div class="mt-3 mb-3">
                                                   
                            <a href="${item.storage}" title="Arquivo" class="btn btn-success btn-sm mb-3" target="_blank">
                                <i class="fa fa-file-pdf-o" aria-hidden="true"></i>
                            </a>
                            
                            
                        </div>

                    </div>
                </div>
            `;

                timelineContainer.appendChild(card);
            });
        }
        function fecharModalinfo(params) {
            $("input[type='radio']").prop('checked', false);
            $('#trabalhos').modal('hide');
            $('#professor').modal('show');
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
