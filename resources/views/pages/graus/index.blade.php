@extends('layouts.pages.dashboard', [
    'title' => 'checked',
    'checked' => true,
])
@section('content-page')
    <div class="content-page">
        <div class="card-body">
            <div class="card">
                <div class="card-header card-title text-white bg-transparent border-0 m-3">
                    <span class="h4">Graus</span>
                </div>
                <div class="card-body">
                    <div id="toolbar">
                        @can('insert-grau')
                            <button class="btn btn-secondary" data-toggle="modal" data-target="#novalinha"><i
                                    class="fa fa-plus"></i> Adicionar novo grau</button>
                        @endcan
                        <div class="modal fade" id="novalinha" tabindex="-1" aria-labelledby="novalinha"
                            aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Adicionar</h5>
                                        <button id="fechar" type="button" class="close" onclick="clearForm('addLinha','novalinha')"
                                            aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <form id="addLinha" class="needs-validation" novalidate>
                                        @csrf
                                        <div class="modal-body" class="my-2">
                                            <input type="hidden" class="form-control" id="id" name="id">
                                            <label for="nome">Nome</label>
                                            <input type="text" class="form-control" maxlength="60" id="nome"
                                                name="nome" required>
                                            <label for="nome">Descrição</label>
                                            <input type="text" class="form-control" id="nome" name="descricao">
                                        </div>
                                        <div class="modal-footer">
                                            <button id="fechar" type="button" class="btn btn-secondary"
                                                onclick="clearForm('addLinha','novalinha')">Fechar</button>
                                            <button type="submit" class="btn btn-primary">Adicionar</button>
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
                        data-url="{{ route('grau.show', 1) }}">
                        <thead>
                            <tr>
                                <th data-field="nome" data-editable="false" class="col-3" aria-required="true">Nome</th>
                                <th data-field="descricao" data-editable="false" class="col-3" aria-required="true">
                                    Descrição</th>
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
                        var formdata = new FormData($("form[name='addLinha']")[0]);
                        let id = document.getElementById('id').value;
                        $.ajax({
                            url: id > 0 ? `{{ url('grau/update/${id}') }}` :
                                "{{ route('grau.store') }}",
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
                });

            });
        });

        //Excluir uma nova linha
        window.acaoEvents = {
            'click .remove': function(e, value, row) {
                deleteAlert().then((result) => {
                    if (result.isConfirmed) {
                        partialLoader();
                        $.ajax({
                            url: "grau/" + row.id,
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

        function setIdModal(id,disabled) {
            partialLoader();
            document.getElementById('id').value = id;
            $.ajax({
                url: `{{ url('grau/findById/${id}') }}`,
                type: "GET",
                success: function(response) {
                    partialLoader(false);
                    $(`#titulo`).text(`Editar Grau ${response.nome}`);
                    $(`#salvar`).text(`Salvar`);
                    $(`#nome`).val(response.nome);
                    $(`#descricao`).val(response.descricao);
                    if (disabled) {
                        $('#novalinha :input:not(#visualizar, #fechar)').prop('disabled', true);
                        $('#novalinha select').prop('disabled', true);
                    }else{
                        $('#novalinha :input').prop('disabled', false);
                        $('#novalinha select').prop('disabled', false);
                    }
                    $('#novalinha').modal('show');
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
                `<a class="text-info p-1" href="#" onclick="setIdModal(${row.id},true)">`,
                `<i class="fa fa-eye" aria-hidden="true"></i>`,
                `</a>`,
                ` @can('update-grau')<a class="text-info p-1" href="#" onclick="setIdModal(${row.id})"title="Editar Registro">`,
                `<i class="fa fa-edit"></i>`,
                `</a>@endcan`,
                '@can('delete-grau')<a class="remove p-1" href="javascript:void(0)" title="Remove">',
                '<i class="fa fa-trash"></i>',
                '</a>@endcan'
            ].join('');
        }
    </script>
@endpush
