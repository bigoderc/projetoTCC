@extends('layouts.pages.dashboard')

@section('content-page')
    <div class="content-page">
        <div class="card-body">
            <div class="card">
                <div class="card-header card-title text-white bg-transparent border-0 m-3">
                    <span class="h4">Temas</span>
                </div>
                <div class="card-body">
                    <div id="toolbar">
                        <button class="btn btn-secondary" data-toggle="modal" data-target="#novalinha"><i
                                class="fa fa-plus"></i> Adicionar nova linha</button>

                        <div class="modal fade" id="novalinha" tabindex="-1" aria-labelledby="novalinha"
                            aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="titulo">Adicionar nova linha</h5>
                                        <button type="button" class="close" onclick="clearForm('addLinha','novalinha')" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <form id="addLinha" name="addLinha" enctype="multipart/form-data"
                                        class="needs-validation" novalidate>
                                        @csrf
                                        <div class="modal-body" class="my-2">
                                            <input type="hidden" class="form-control" id="id" name="id">
                                            <label for="nome">Nome</label>
                                            <input type="text" class="form-control" id="nome" name="nome"
                                                required>
                                            <label for="nome">Descrição</label>
                                            <input type="text" class="form-control" id="descricao" name="descricao">
                                            <label for="nome" class="my-2">Área</label>
                                            <select class="form-control" id="fk_areas_id" name="fk_areas_id"
                                                aria-label="Default select example" required>
                                                <option value="" selected>Selecione a Área</option>
                                                @foreach ($areas as $area)
                                                    <option value="{{ $area->id }}">{{ $area->nome }}</option>
                                                @endforeach
                                            </select>
                                            <label for="nome">Link</label>
                                            <input type="text" class="form-control" id="link" name="link">
                                            <label for="nome" class="my-2">Arquivo</label>
                                            <input type="file" class="form-control" accept=".png,.jpeg,.pdf"
                                                id="file" name="file">
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-dismiss="modal">Fechar</button>
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
                        data-search-accent-neutralise="true" data-editable-url="#" data-url="{{ route('temas.show', 1) }}">
                        <thead>
                            <tr>
                                <th data-field="id" class="col-1">ID</th>
                                <th data-field="nome" class="col-2" aria-required="true">NOME</th>
                                <th data-field="descricao" class="col-2" aria-required="true">DESCRIÇÃO</th>
                                <th data-field="area.nome" class="col-2" aria-required="true">ÁREA</th>
                                <th data-field="link" class="col-3" aria-required="true">LINK</th>
                                <th data-field="acao" class="col-2" data-formatter="acaoFormatter"
                                    data-events="acaoEvents">Ação</th>
                            </tr>
                        </thead>
                    </table>
                    <div class="modal fade" id="upload" tabindex="-1" role="dialog" aria-labelledby="modalCenter"
                        aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="bg-white modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="modalupload">Enviar Arquivo</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form id="addUpload" name="addUpload" enctype="multipart/form-data">
                                        <label for="anexo">Selecione seu arquivo</label>
                                        <input type="file" name="file" accept=".pdf,.jpeg,.png" required="" />
                                        <input type="hidden" name="id" id="id_upload" value="" />
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                onclick="clearForm('addLinha','novalinha')">Fechar</button>
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
                        var formdata = new FormData($("form[name='addLinha']")[0]);
                        let id = document.getElementById('id').value;
                        $.ajax({
                            url: id > 0 ? `{{ url('temas/update/${id}') }}` :
                                "{{ route('temas.store') }}",
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
                                errorResponse(xhr.status, xhr.responseJSON.data, xhr
                                    .responseText);
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
                url: "{{ route('temas.upload') }}",
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
                    errorResponse(xhr.status, xhr.responseJSON.data, xhr
                        .responseText);
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
                            url: "temas/" + row.id,
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
                url: `{{ url('temas/findById/${id}') }}`,
                type: "GET",
                success: function(response) {
                    partialLoader(false);
                    $(`#titulo`).text(`Editar Tema ${response.nome}`);
                    $(`#salvar`).text(`Salvar`);
                    $(`#nome`).val(response.nome);
                    $(`#descricao`).val(response.descricao);
                    $(`#link`).val(response.link);
                    $(`#fk_areas_id option[value=${response.fk_areas_id}]`).prop('selected', 'selected')
                    .change();
                    $('#novalinha').modal('show');
                },
                error: function(xhr, status, error) {
                    partialLoader(false);
                    errorResponse(xhr.status, xhr.responseJSON.data, xhr
                        .responseText);
                }
            });
        }

        function setIdUpload(id) {
            partialLoader();
            document.getElementById('id_upload').value = id;
            $.ajax({
                url: `{{ url('temas/findById/${id}') }}`,
                type: "GET",
                success: function(response) {
                    partialLoader(false);
                    $(`#modalupload`).text(`Upload Tema ${response.nome}`);
                    $(`#salvar`).text(`Salvar`);
                    $('#upload').modal('show');
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
                `<a class="text-info p-1" href="#" onclick="setIdModal(${row.id})"title="Editar Registro">`,
                `<i class="fa fa-edit"></i>`,
                `</a>`,
                `<a class="text-danger m-1" href="#" onclick="setIdUpload(${row.id})" data-toggle="modal" title="Atualizar Anexo" data-target="#upload">`,
                `<i class="fa fa-upload " aria-hidden="true"></i>`,
                `</a>`,
                `<a rel="tooltip" class="text-success p-1 m-1" title="Visualizar Anexo" href="temas/toView/${row.id}"  target="_blank" >`,
                `<i class="fa fa-search" aria-hidden="true"></i>`,
                `</a>`,
                '<a class="remove" href="javascript:void(0)" title="Remove">',
                '<i class="fa fa-trash"></i>',
                '</a>'
            ].join('');
        }
    </script>
@endpush
