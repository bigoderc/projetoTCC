@extends('layouts.pages.dashboard',[
    'title'=>'checked',
    'checked'=>true
])

@section('content-page')
    <div class="content-page">
        <div class="card-body">
            <div class="card">
                <div class="card-header card-title text-white bg-transparent border-0 m-3">
                    <span class="h4">Áreas</span>
                </div>
                <div class="card-body">
                    <div id="toolbar">
                        @can('insert-area')
                            <button class="btn btn-secondary" data-toggle="modal" data-target="#novalinha"><i
                                class="fa fa-plus"></i> Adicionar nova linha</button>
                        @endcan
                        <div class="modal fade" id="novalinha" tabindex="-1" aria-labelledby="novalinha"
                            aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Adicionar nova linha</h5>
                                        <button type="button" class="close" onclick="clearForm('addLinha','novalinha')"
                                            aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <form id="addLinha" name="addLinha" enctype="multipart/form-data"
                                        class="needs-validation" novalidate>
                                        @csrf
                                        <div class="modal-body" class="my-2">
                                            <label for="nome">Nome</label>
                                            <input type="text" class="form-control" id="nome" name="nome"
                                                required>
                                            <label for="nome">Descrição</label>
                                            <input type="text" class="form-control" id="descricao" name="descricao"
                                                required>
                                            <label for="nome">Link</label>
                                            <input type="text" class="form-control" id="link" name="link">
                                            <label for="nome" class="my-2">Arquivo</label>
                                            <input type="file" class="form-control" accept=".png,.jpeg,.pdf"
                                                id="file" name="file">
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
                        data-search-accent-neutralise="true" data-editable-url="{{ route('area.update1') }}"
                        data-url="{{ route('area.show', 1) }}">
                        <thead>
                            <tr>
                                <th data-field="nome" data-editable="true" class="col-3" aria-required="true">NOME</th>
                                <th data-field="descricao" data-editable="true" class="col-3" aria-required="true">
                                    DESCRIÇÃO</th>
                                <th data-field="link" data-editable="true" class="col-3" aria-required="true">LINK</th>
                                <th data-field="acao" class="col-1" data-formatter="acaoFormatter"
                                    data-events="acaoEvents">Ação</th>
                            </tr>
                        </thead>
                    </table>
                    <div class="modal fade" id="upload" tabindex="-1" role="dialog" aria-labelledby="modalCenter"
                        aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="bg-white modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="modalLong">Enviar Arquivo</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form id="addUpload" name="addUpload" enctype="multipart/form-data">
                                        <label for="anexo">Selecione seu arquivo</label>
                                        <input type="file" name="file" accept=".pdf,.jpeg,.png" required="" />
                                        <input type="hidden" name="id" id="id" value="" />
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-dismiss="modal">Fechar</button>
                                            <button type="submit" id="btnAnexo"
                                                class="btn btn-primary ml-2">Importar</button>
                                        </div>
                                    </form>
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
                            url: "{{ route('area.store') }}",
                            type: "POST",
                            data: formdata,
                            dataType: "json",
                            processData: false,
                            contentType: false,
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
        $("#addUpload").submit(function(event) {
            event.preventDefault();
            partialLoader();
            var formdata = new FormData($("form[name='addUpload']")[0]);
            $.ajax({
                url: "{{ route('area.upload') }}",
                type: "POST",
                data: formdata,
                dataType: "json",
                processData: false,
                contentType: false,
                success: function(response) {
                    partialLoader(false);
                    $('#upload').modal('hide');
                    successResponse();
                },
                error: function(xhr, status, error) {
                    partialLoader(false);
                    errorResponse(xhr.status,xhr.responseJSON.data,xhr.responseText);
                }
            });
        });
        //Excluir uma nova linha
        window.acaoEvents = {
            'click .remove': function(e, value, row) {
                deleteAlert().then((result) => {
                    if (result.isConfirmed) {
                        partialLoader();
                        $.ajax({
                            url: "area/" + row.id,
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
                                errorResponse(xhr.status,xhr.responseJSON.data,xhr.responseText);
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
            const actions = [
                `@can('update-area')<a class="text-danger m-1" href="#" onclick="setIdModal(${row.id})" data-toggle="modal" title="Atualizar Anexo" data-target="#upload">`,
                `<i class="fa fa-upload" aria-hidden="true"></i>`,
                `</a>@endcan`,
                // Verificar se row.arquivo é diferente de null antes de adicionar o link
                row.arquivo !== null ? `<a rel="tooltip" class="text-success p-1 m-1" title="Visualizar Anexo" href="${row.storage}" target="_blank">` +
                    `<i class="fa fa-search" aria-hidden="true"></i>` +
                    `</a>` : '',
                '@can('delete-area')<a class="remove" href="javascript:void(0)" title="Remove">',
                '<i class="fa fa-trash"></i>',
                '</a>@endcan'
            ];

            return actions.join('');
        }

    </script>
@endpush
