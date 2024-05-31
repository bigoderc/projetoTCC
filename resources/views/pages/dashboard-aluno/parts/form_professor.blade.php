<div class="modal fade" id="novalinha" tabindex="-1" aria-labelledby="novalinha" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered  modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="titulo">Adicionar</h5>
                <button type="button" id="fechar" class="close" onclick="clearForm('addLinha','novalinha')"
                    aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="addLinha" class="needs-validation" novalidate>
                @csrf
                <div class="modal-body" class="my-2">
                    <input type="hidden" class="form-control" id="id" name="id">
                    <label for="nome">Nome</label>
                    <input type="text" class="form-control" id="nome" name="nome" required>
                    <label for="siape">Siape</label>
                    <input type="text" maxlength="7" class="form-control" id="siape" name="siape" required>
                    <label for="email">Email</label>
                    <input type="email" class="form-control" id="email" name="email" required>

                    <label for="nome" class="my-2">Linha de Pesquisa</label>
                    <select class="form-control" id="linha_pesquisa_id" name="linha_pesquisas[]" multiple
                        multiselect-hide-x="true" multiselect-search="true" required>

                        @foreach ($areas as $area)
                            <option value="{{ $area->id }}">{{ $area->nome }}</option>
                        @endforeach
                    </select>
                    <label for="especialidade">Área</label>
                    <select class="form-control" name="fk_especialidade_id" id="fk_especialidade_id"
                        aria-label="Default select example" required>
                        <option value="" selected>Selecione a Área</option>
                        @foreach ($especialidades as $especialidade)
                            <option value="{{ $especialidade->id }}">{{ $especialidade->nome }}
                            </option>
                        @endforeach
                    </select>
                    <label for="grau">Grau</label>
                    <select class="form-control" name="fk_grau_id" id="fk_grau_id" aria-label="Default select example"
                        required>
                        <option value="" selected>Selecione o Grau</option>
                        @foreach ($graus as $grau)
                            <option value="{{ $grau->id }}">{{ $grau->nome }}</option>
                        @endforeach
                    </select>
                    <label for="disponibilidade">Disponibilidade Orientação</label>
                    <input type="number" maxlength="7" class="form-control" id="disponibilidade"
                        name="disponibilidade">
                    <label for="curriculo_lattes">Currículo Lattes</label>
                    <div class="input-group">
                        <input type="text" class="form-control" id="curriculo_lattes" name="curriculo_lattes">
                        <button id="visualizar" class="btn border bg-body-tertiary"
                            onclick="abrirCurriculoLattes('curriculo_lattes')" type="button" title="Visualiar">
                            <i class="fa fa-eye" aria-hidden="true"></i>
                        </button>
                    </div>
                </div>
                <div class="modal-footer">
                    <button id="fechar" type="button" class="btn btn-secondary"
                        onclick="clearForm('addLinha','novalinha')">Fechar</button>
                    <button type="submit" id="salvar" class="btn btn-primary">Adicionar</button>
                </div>
            </form>
        </div>
    </div>
</div>
@push('scripts')
    <script>
        function setIdModal(id, disabled = false) {
            
            partialLoader();
            document.getElementById('id').value = id;
            $.ajax({
                url: `{{ url('docente/findById/${id}') }}`,
                type: "GET",
                success: function(response) {
                    $(`#titulo`).text(`Editar Docente ${response.nome}`);
                    $(`#salvar`).text(`Salvar`);
                    $(`#nome`).val(response.nome);
                    $(`#siape`).val(response.siape);
                    $(`#email`).val(response.user?.email);
                    $(`#curriculo_lattes`).val(response.curriculo_lattes);
                    $(`#disponibilidade`).val(response.disponibilidade);
                    if (response.user) {
                        $(`#email`).prop('disabled', true);
                    }

                    $(`#fk_especialidade_id option[value=${response.fk_especialidade_id}]`).prop('selected',
                        'selected').change();
                    $(`#fk_grau_id option[value=${response.fk_grau_id}]`).prop('selected', 'selected').change();
                    var select = document.getElementById('linha_pesquisa_id');

                    response.linha_pesquisas.forEach(function(valor) {
                        // Encontrar a opção pelo valor e defini-la como selecionada
                        var option = select.querySelector('option[value="' + valor.id + '"]');
                        if (option) {

                            option.selected = true;
                        }
                        select.loadOptions();
                    });
                    if (disabled) {
                        $('#novalinha :input:not(#visualizar, #fechar)').prop('disabled', true);
                        $('#novalinha select').prop('disabled', true);
                    } else {
                        $('#novalinha :input').prop('disabled', false);
                        $('#novalinha select').prop('disabled', false);
                    }

                    $('#novalinha').modal('show');
                    partialLoader(false);

                },
                error: function(xhr, status, error) {
                    partialLoader(false);
                    errorResponse(xhr.status, xhr.responseJSON.data, xhr
                        .responseText);
                }
            });

        }
    </script>
@endpush