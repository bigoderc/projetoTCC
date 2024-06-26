
<div class="modal fade" id="professor_modal" tabindex="-1" aria-labelledby="professor" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="titulo">Associar orientador</h5>
                <button type="button" class="close" onclick="fecharModalprofessor1()" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="hidden" class="form-control" id="orientador_id" name="orientador_id">
                <div class="col-12">
                    <div class="col">
                        <table id="orientador_table" class="text-center" data-toggle="table" data-editable="true"
                            data-editable-pk="id" data-editable-mode="inline" data-editable-type="text"
                            data-locale="pt-BR" data-search="true" data-show-columns="false"
                            data-show-export="false" data-search-accent-neutralise="true" data-editable-url="#">
                            <thead>
                                <tr>
                                    <th data-field="nome" class="col-3" aria-required="true">Nome</th>
                                    <th data-field="siape" class="col-3" aria-required="true">Siape</th>
                                    <th data-field="linha_pesquisa_desc" class="col-3" aria-required="true">Linha de
                                        Pesquisa</th>
                                    <th data-field="especialidade.nome" class="col-3" aria-required="true">Área
                                    </th>
                                    <th data-field="grau.nome" class="col-3" aria-required="true">Grau</th>
                                    <th data-field="disponibilidade_desc" class="col-3" aria-required="true">Disponibilidade</th>

                                    <th data-field="acao" class="col-1" data-formatter="acaoFormattercheck2">
                                        Ação</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="fecharModalprofessor1()">Fechar</button>
                <button type="button" id="salvar" onclick="associar()" class="btn btn-primary">Salvar</button>
            </div>
        </div>
    </div>
</div>
@include('pages.dashboard-aluno.parts.trabalhos')
@include('pages.dashboard-aluno.parts.form_professor')
@push('scripts')
    <script>
        function setprofessor(params) {
            $(`#orientador_id`).val(params);
            init1();
            $('#professor_modal').modal('show');
        }

        function acaoFormattercheck2(value, row, index) {
            const isDisabled = row.disponibilidade_desc < 1 ? 'disabled' : '';
            return [
                `<a class="text-info p-1" href="#" title="Visualizar" onclick="showForm(${row.id})">`,
                `<i class="fa fa-eye" aria-hidden="true"></i>`,
                `</a>`,
                `<input type="radio" class="orientador-radio" name="orientador" id="orientador-${row.id}" value="${row.id}" ${isDisabled}>`,
                `<a rel="tooltip" class="text-success p-1 m-1" title="Visualizar Trabalhos"  onclick="showTrabalhos(${row.id})">`,
                `<i class="fa fa-search" aria-hidden="true"></i>`,
                `</a>`,
            ].join('');
            //return `<input type="radio" class="orientador-radio" name="orientador" id="orientador-${row.id}" value="${row.id}">`;
        }

        function showTrabalhos(params) {
            getTrabalhos(params)
        }
        function showForm(params) {
            setIdModal(params, true)
        }

        

        function init1() {
            $.ajax({
                url: `{{ route('docente.show', 1) }}`,
                type: "GET",
                success: function(response) {
                    $('#orientador_table').bootstrapTable('removeAll');
                    $('#orientador_table').bootstrapTable('append', response);
                },
                error: function(xhr, status, error) {
                    partialLoader(false);
                    errorResponse(xhr.status, xhr.responseJSON.data, xhr
                        .responseText);
                }
            });
        }

        function associar(params) {

            var id = $(`#orientador_id`).val();
            var radios = document.getElementsByName('orientador');
            var valorSelecionado = null;

            for (var i = 0; i < radios.length; i++) {
                if (radios[i].checked) {
                    valorSelecionado = radios[i].value;
                    break;
                }
            }
            if (valorSelecionado == null) {
                errorResponse(422, {
                    professor: 'Docente é obrigatório'
                }, 'Docente vazio');

            } else {
                partialLoader();
                $.ajax({
                    url: "{{ route('dashboardAluno.store') }}",
                    type: "POST",
                    data: {
                        id: id,
                        professor_id: valorSelecionado
                    },
                    dataType: "json",
                    success: function(response) {
                        $('#professor').modal('hide');

                        partialLoader(false);
                        successResponse();
                        fecharModalprofessor1();
                        renderizarCards(response);
                    },
                    error: function(xhr, status, error) {
                        partialLoader(false);
                        errorResponse(xhr.status, xhr.responseJSON.data, xhr
                            .responseText);
                    }
                })
            }
        }

        function fecharModalprofessor1(params) {
            $("input[type='radio']").prop('checked', false);
            $('#professor_modal').modal('hide');
        }
    </script>
@endpush
