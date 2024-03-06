@extends('layouts.pages.dashboard',[
    'title'=>'checked',
    'checked'=>true
])
@section('content-page')
    <div class="content-page">
        <div class="card-body">
            <div class="card">
                <div class="card-header card-title text-white bg-transparent border-0 m-3">
                    <span class="h4">Usuários</span>
                </div>
                <div class="card-body">
                    <div id="toolbar">
                        @can('insert-usuario')
                            <button class="btn btn-secondary" data-toggle="modal" data-target="#novalinha"><i
                                class="fa fa-plus"></i> Adicionar nova linha</button>
                        @endcan
                        <div class="modal fade" id="novalinha" tabindex="-1" aria-labelledby="novalinha"
                            aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="titulo">Adicionar nova linha</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <form id="addLinha" class="needs-validation" novalidate>
                                        @csrf
                                        <div class="modal-body" class="my-2">
                                            <input type="hidden" class="form-control" id="id" name="id">
                                            <label for="name">Nome</label>
                                            <input type="text" class="form-control" id="name" name="name" required>
                                            <label for="email" class="my-2">email</label>
                                            <input type="email" class="form-control" id="email" name="email" required>
                                            <label for="perfil" class="my-2">Perfil</label>
                                            <select class="form-control" name="fk_roles_id" id="fk_roles_id"
                                                aria-label="Default select example" required>

                                                <option value="" selected>Selecione o Perfil</option>
                                                @foreach ($roles as $role)
                                                    <option value="{{ $role->id }}">{{ $role->nome }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-dismiss="modal">Fechar</button>
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
                        data-search-accent-neutralise="true" 
                        data-url="{{ route('user.show', 1) }}">
                        <thead>
                            <tr>
                                <th data-field="name" data-editable="true" class="col-3" aria-required="true">NOME</th>
                                <th data-field="email" data-editable="true" class="col-3" aria-required="true">
                                    EMAIL</th>
                                <th data-field="role.nome" data-editable="true" class="col-3" aria-required="true">
                                    PERFIL</th>
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
                            url: id > 0 ? `{{ url('user/update/${id}') }}` :
                                "{{ route('user.store') }}",
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
                            url: "user/" + row.id,
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
                url: `{{ url('user/findById/${id}') }}`,
                type: "GET",
                success: function(response) {
                    $(`#titulo`).text(`Editar Usuário ${response.name}`);
                    $(`#salvar`).text(`Salvar`);
                    $(`#name`).val(response.name);

                    $(`#email`).val(response.email);
                    
                    $(`#fk_roles_id option[value=${response.role.id}]`).prop('selected', 'selected')
                    .change();
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
                `@can('update-usuario')<a class="text-info p-1" href="#" onclick="setIdModal(${row.id})">`,
                `<i class="fa fa-edit"></i>`,
                `</a>@endcan`,
                '@can('delete-usuario')<a class="remove" href="javascript:void(0)" title="Remove">',
                '<i class="fa fa-trash"></i>',
                '</a>@endcan'
            ].join('');
        }
    </script>
@endpush
