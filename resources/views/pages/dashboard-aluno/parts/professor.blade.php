<div class="card-body">
    <div class="modal fade" id="professor" tabindex="-1" aria-labelledby="professor" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="titulo">Associar orientador</h5>
                    <button type="button" class="close" onclick="fecharModalprofessor()" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="row">
                    <input type="hidden" class="form-control" id="orientador_id" name="orientador_id">
                    <div class="col-12">
                        <div class="col">
                            <table id="orientador_table" class="text-center" data-toggle="table"
                                data-editable="true" data-editable-pk="id" data-editable-mode="inline"
                                data-editable-type="text" data-locale="pt-BR" data-search="true"
                                data-show-columns="false" data-show-export="false"
                                data-search-accent-neutralise="true" data-editable-url="#">
                                <thead>
                                    <tr>
                                        <th data-field="id" class="col-1">ID</th>
                                        <th data-field="nome" class="col-3" aria-required="true">NOME</th>
                                        <th data-field="siape" class="col-3" aria-required="true">SIAPE</th>
                                        <th data-field="areas.nome" class="col-3" aria-required="true">ÁREA</th>
                                        <th data-field="especialidade.nome" class="col-3" aria-required="true">ESPECIALIDADE
                                        </th>
                                        <th data-field="graus.nome" class="col-3" aria-required="true">GRAU</th>
                                        <th data-field="cargo.nome" class="col-3" aria-required="true">CARGO</th>
                                
                                        <th data-field="acao" class="col-1"
                                            data-formatter="acaoFormattercheck2">
                                            Ação</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" onclick="fecharModalprofessor()">Fechar</button>
                    <button type="button" id="salvar" onclick="associar()"
                        class="btn btn-primary">Salvar</button>
                </div>
            </div>
        </div>
    </div>
    @include('pages.dashboard-aluno.parts.trabalhos')
</div>
@push('scripts')
    <script>
        function setprofessor(params) {
            $(`#orientador_id`).val(params);
            init1();
            $('#professor').modal('show');
        }
        function acaoFormattercheck2(value, row, index) {
            return [
                `<input type="radio" class="orientador-radio" name="orientador" id="orientador-${row.id}" value="${row.id}">`,
                `<a rel="tooltip" class="text-success p-1 m-1" title="Visualizar Trabalhos"  onclick="showTrabalhos(${row.id})">`,
                `<i class="fa fa-search" aria-hidden="true"></i>`,
                `</a>`,
            ].join('');
            //return `<input type="radio" class="orientador-radio" name="orientador" id="orientador-${row.id}" value="${row.id}">`;
        }
        function showTrabalhos(params) {
            getTrabalhos(params)
        }
        function init1() {
            $.ajax({
                url: `{{ route('professores.show',1) }}`,
                type: "GET",
                success: function(response) {
                    $('#orientador_table').bootstrapTable('removeAll');
                    $('#orientador_table').bootstrapTable('append',response);
                },
                error: function(xhr, status, error) {
                    partialLoader(false);
                    errorResponse(xhr);
                }
            });
        }

        function associar(params) {

            var id = $(`#orientador_id`).val();
            var radios = document.getElementsByName('orientador');
            var valorSelecionado = '';

            for (var i = 0; i < radios.length; i++) {
                if (radios[i].checked) {
                    valorSelecionado = radios[i].value;
                    break;
                }
            }

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
                    fecharModalprofessor();
                    renderizarCards(response);
                },
                error: function(xhr, status, error) {
                    partialLoader(false);
                    errorResponse(xhr);
                }
            })
        }

        function fecharModalprofessor(params) {
            $("input[type='radio']").prop('checked', false);
            $('#professor').modal('hide');
        }
    </script>
@endpush
