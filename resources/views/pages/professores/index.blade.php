@extends('layouts.pages.dashboard', [
    'title' => 'checked',
    'checked' => true,
])
@section('content-page')
    <div class="content-page">
        <div class="card-body">
            <div class="card">
                <div class="card-header card-title text-white bg-transparent border-0 m-3">
                    <span class="h4">Docente</span>
                </div>
                <div class="card-body">
                    <div id="toolbar">
                        @can('insert-professor')
                            <button class="btn btn-secondary" data-toggle="modal" data-target="#novalinha"><i
                                    class="fa fa-plus"></i> Adicionar novo docente</button>
                        @endcan

                        <div class="modal fade" id="novalinha" tabindex="-1" aria-labelledby="novalinha"
                            aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="titulo">Adicionar</h5>
                                        <button type="button" class="close" onclick="clearForm('addLinha','novalinha')"
                                            aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <form id="addLinha" class="needs-validation" novalidate>
                                        @csrf
                                        <div class="modal-body" class="my-2">
                                            <input type="hidden" class="form-control" id="id" name="id">
                                            <label for="nome">Nome</label>
                                            <input type="text" class="form-control" id="nome" name="nome"
                                                required>
                                            <label for="siape">Siape</label>
                                            <input type="text" maxlength="7" class="form-control" id="siape"
                                                name="siape" required>
                                            <label for="email">Email</label>
                                            <input type="email" class="form-control" id="email" name="email"
                                                required>

                                            <label for="nome" class="my-2">Linha de Pesquisa</label>
                                            <select class="form-control" id="linha_pesquisa_id" name="linha_pesquisas[]" multiple
                                                multiselect-hide-x="true" multiselect-search="true"
                                                required>

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
                                            <select class="form-control" name="fk_grau_id" id="fk_grau_id"
                                                aria-label="Default select example" required>
                                                <option value="" selected>Selecione o Grau</option>
                                                @foreach ($graus as $grau)
                                                    <option value="{{ $grau->id }}">{{ $grau->nome }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                onclick="clearForm('addLinha','novalinha')">Fechar</button>
                                            <button type="submit" id="salvar" class="btn btn-primary">Adicionar</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <table id="my_table_id" class="text-center" data-toggle="table" data-editable="true"
                        data-editable-pk="id" data-editable-mode="inline" data-editable-type="text" data-locale="pt-BR"
                        data-search="true" data-show-columns="true" data-show-export="true" data-click-to-select="true"
                        data-toolbar="#toolbar" data-unique-id="id" data-id-field="id" data-page-size="25"
                        data-page-list="[5, 10, 25, 50, 100, all]" data-pagination="true"
                        data-search-accent-neutralise="true" data-editable-url="#"
                        data-url="{{ route('docente.show', 1) }}">
                        <thead>
                            <tr>
                                <th data-field="nome" class="col-3" aria-required="true">NOME</th>
                                <th data-field="siape" class="col-3" aria-required="true">SIAPE</th>
                                <th data-field="linha_pesquisa_desc" class="col-3" aria-required="true">LINHA DE PESQUISA</th>
                                <th data-field="especialidade.nome" class="col-3" aria-required="true">ÁREA
                                </th>
                                <th data-field="grau.nome" class="col-3" aria-required="true">GRAU</th>
                                <th data-field="acao" class="col-1" data-formatter="acaoFormatter"
                                    data-events="acaoEvents">Ação</th>
                            </tr>
                        </thead>

                    </table>
                </div>
            </div>
        </div>
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
            var forms = document.getElementsByClassName('needs-validation');
            $("#addLinha").submit(function(event) {
                event.preventDefault();

                var validation = Array.prototype.filter.call(forms, function(form) {
                    if (form.checkValidity() === false) {
                        form.classList.add('was-validated');

                    } else {
                        partialLoader();
                        let id = document.getElementById('id').value;
                        $.ajax({
                            url: id > 0 ? `{{ url('docente/update/${id}') }}` :
                                "{{ route('docente.store') }}",
                            type: id > 0 ? "PUT" : "POST",
                            data: $("#addLinha").serialize(),
                            dataType: "json",
                            success: function(response) {

                                clearForm('addLinha', 'novalinha')
                                partialLoader(false);

                                id > 0 ? $('#my_table_id').bootstrapTable(
                                    'updateByUniqueId', {
                                        id: id,
                                        row: response,
                                        replace: false
                                    }) : $('#my_table_id').bootstrapTable('prepend',
                                    response);
                                successResponse();
                            },
                            error: function(xhr, status, error) {
                                partialLoader(false);
                                errorResponse(xhr.status, xhr.responseJSON.data, xhr
                                    .responseText);
                            }
                        });

                    }

                })
            });
        });

        //Excluir uma nova linha
        window.acaoEvents = {
            'click .remove': function(e, value, row) {
                deleteAlert().then((result) => {
                    if (result.isConfirmed) {
                        partialLoader();
                        $.ajax({
                            url: "professor/" + row.id,
                            type: "DELETE",
                            dataType: "json",
                            success: function(response) {
                                partialLoader(false);
                                $('#my_table_id').bootstrapTable('remove', {
                                    field: 'id',
                                    values: [row.id]
                                });
                                successResponse();
                            },
                            error: function(xhr, status, error) {
                                partialLoader(false);
                                errorResponse(xhr.status, xhr.responseJSON.data, xhr
                                    .responseText);
                            }
                        });
                    }
                })
            }
        }

        function setIdModal(id) {
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


        //Criar colunar ação
        function acaoFormatter(value, row, index) {
            return [
                `@can('update-professor')<a class="text-info p-1" href="#" onclick="setIdModal(${row.id})">`,
                `<i class="fa fa-edit"></i>`,
                `</a>@endcan`,
                '@can('delete-professor')<a class="remove" href="javascript:void(0)" title="Remove">',
                '<i class="fa fa-trash"></i>',
                '</a>@endcan'
            ].join('');
        }
    </script>
@endpush
