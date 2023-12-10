@extends('layouts.pages.dashboard')

@section('content-page')
    <div class="content-page">
        <div class="card-body">
            <div class="card">
                <div class="card-header card-title text-white bg-transparent border-0 m-3">
                    <span class="h4">Link Bibliotecas</span>
                </div>
                <div class="card-body">
                    <div id="toolbar">
                        @can('insert-biblioteca')
                            <button class="btn btn-secondary" data-toggle="modal" data-target="#novalinha"><i
                                class="fa fa-plus"></i> Adicionar nova linha</button>
                        @endcan
                        <div class="modal fade" id="novalinha" tabindex="-1" aria-labelledby="novalinha"
                            aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Adicionar nova linha</h5>
                                        <button type="button" class="close" onclick="clearForm('addLinha','novalinha')" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <form id="addLinha" class="needs-validation" novalidate>
                                        @csrf
                                        <div class="modal-body" class="my-2">
                                            <label for="nome">Nome</label>
                                            <input type="text" class="form-control" id="nome" name="nome" required>
                                            <label for="nome">Descrição</label>
                                            <input type="text" class="form-control" id="nome" name="descricao">
                                            <label for="nome">Link</label>
                                            <input type="text" class="form-control" id="link" name="link">
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
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
                        data-search-accent-neutralise="true" data-editable-url="{{ route('biblioteca.update1') }}"
                        data-url="{{ route('biblioteca.show', 1) }}">
                        <thead>
                            <tr>
                                <th data-field="id" class="col-1">ID</th>
                                <th data-field="nome" data-editable="true" class="col-3" aria-required="true">NOME</th>
                                <th data-field="descricao" data-editable="true" class="col-3" aria-required="true">
                                    DESCRIÇÃO</th>
                                <th data-field="link" data-editable="true" class="col-3" aria-required="true">
                                    LINK</th>
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
                        $.ajax({
                            url: "{{ route('biblioteca.store') }}",
                            type: "POST",
                            data:  $('#addLinha').serialize(),
                            dataType: "json",
                            success: function(response) {
                                clearForm('addLinha', 'novalinha')
                                partialLoader(false);
                                $('#my_table_id').bootstrapTable('append', response);
                                successResponse();
                            },
                            error: function(xhr, status, error) {
                                partialLoader(false);
                                errorResponse(xhr.status,xhr.responseJSON.data,xhr.responseText);
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
                            url: "biblioteca/" + row.id,
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
            document.getElementById('id').value = id;
        }
        //Criar colunar ação
        function acaoFormatter(value, row, index) {
            return [
                '@can('delete-biblioteca')<a class="remove" href="javascript:void(0)" title="Remove">',
                '<i class="fa fa-trash"></i>',
                '</a>@endcan'
            ].join('');
        }
    </script>
@endpush
