@extends('layouts.pages.dashboard', [
    'title' => 'checked',
    'checked' => true,
])
@section('content-page')
    <div class="content-page">
        <div class="card-body">
            <div class="card">
                <div class="card-header card-title text-white bg-transparent border-0 m-3">
                    <span class="h4">Proposta de Tema</span>
                </div>
                <div class="card-body">
                    <div id="toolbar">
                        @can('insert-proposta_tema')
                            <button class="btn btn-secondary" data-toggle="modal" data-target="#novalinha"><i
                                    class="fa fa-plus"></i> Adicionar nova proposta de tema</button>
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
                                    <form id="addLinha" name="addLinha" enctype="multipart/form-data"
                                        class="needs-validation" novalidate>
                                        @csrf
                                        <div class="modal-body" class="my-2">
                                            <input type="hidden" class="form-control" id="id" name="id">
                                            <label for="nome">Título da proposta</label>
                                            <input type="text" class="form-control" id="nome" name="nome"
                                                required>
                                            <label for="nome">Descrição</label>
                                            <textarea class="form-control" id="descricao" rows="5" name="descricao"></textarea>
                                            <label for="nome" class="my-2">Área</label>
                                            <select class="form-control" id="fk_areas_id" name="areas[]" multiple
                                                multiselect-hide-x="true" multiselect-search="true"
                                                multiselect-max-items="5" required onchange="limitarSelecao(this,5)">

                                                @foreach ($areas as $area)
                                                    <option value="{{ $area->id }}">{{ $area->nome }}</option>
                                                @endforeach
                                            </select>
                                            @if($aluno)
                                                <label for="professor" class="my-2">Professor</label>
                                                <select class="form-control" id="professor_id" name="professor_id" >
                                                    <option value="">Selecione</option>
                                                    @foreach ($professores as $professor)
                                                        <option value="{{ $professor->id }}">{{ $professor->nome }}</option>
                                                    @endforeach
                                                </select>
                                            @endif
                                            <label for="nome">Link</label>
                                            <input type="text" class="form-control" id="link" name="link">
                                            <label for="nome" class="my-2">Arquivo</label>
                                            <input type="file" class="form-control" accept=".png,.jpeg,.pdf"
                                                id="file" name="file">
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" onclick="clearForm('addLinha','novalinha')" class="btn btn-secondary"
                                                data-dismiss="modal">Fechar</button>
                                            <button type="submit" id="salvar" class="btn btn-primary">Adicionar</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <table id="my_table_id" class="text-center table" data-toggle="table" data-editable="true"
                        data-editable-pk="id" data-editable-mode="inline" data-editable-type="text" data-locale="pt-BR"
                        data-search="true" data-show-columns="true" data-show-export="true" data-click-to-select="true"
                        data-toolbar="#toolbar" data-unique-id="id" data-id-field="id" data-page-size="25"
                        data-page-list="[5, 10, 25, 50, 100, all]" data-pagination="true"
                        data-search-accent-neutralise="true" data-editable-url="#"
                        data-url="{{ route('proposta-tema.show', 1) }}">
                        <thead>
                            <tr>
                                <th data-field="nome" class="col-12" aria-required="true">TÍTULO DA PROPOSTA</th>
                                {{-- <th data-field="descricao" class=" truncate-text" aria-required="true"
                                    data-formatter="nameFormatter">DESCRIÇÃO</th> --}}
                                <th data-field="areas_desc"  aria-required="true"
                                >ÁREA</th>
                                <th data-field="criado.name" class="" aria-required="true">PROPONENTE</th>
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
                                            <button type="button" class="close"
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
        $(document).ready(function() {
            $('[data-toggle="tooltip"]').tooltip();
        });

        function nameFormatter(value, row) {
            var icon = '';
            var tooltipText = value;
            var $temp = $('<div class="truncate-text">' + value + '</div>').appendTo('body');

            // Verificar se o texto está truncado
            if ($temp.prop('scrollWidth') > $temp.prop('clientWidth')) {
                icon = 'fa-solid fa-info-circle'; // Ícone para exibir
                // Definindo o tooltip com o valor completo
                tooltipText = value;
            }

            // Remover o elemento temporário do DOM
            $temp.remove();

            // Retornando o HTML com o ícone e o tooltip
            return '<div class="truncate-text">' + (icon ? '<i class="icon-show fa ' + icon +
                '" data-toggle="tooltip" title="' + tooltipText + '"></i>' : '') + ' ' + value + '</div>';
        }

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
                            url: id > 0 ? `{{ url('proposta-tema/update/${id}') }}` :
                                "{{ route('proposta-tema.store') }}",
                            type: "POST",
                            data: formdata,
                            dataType: "json",
                            processData: false,
                            contentType: false,
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
                            url: "proposta-tema/" + row.id,
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
                url: `{{ url('proposta-tema/findById/${id}') }}`,
                type: "GET",
                success: function(response) {
                    partialLoader(false);
                    $(`#titulo`).text(`Editar Tema ${response.nome}`);
                    $(`#salvar`).text(`Salvar`);
                    $(`#nome`).val(response.nome);
                    $(`#descricao`).val(response.descricao);
                    $(`#link`).val(response.link);
                    var select = document.getElementById('fk_areas_id');

                    response.areas.forEach(function(valor) {
                        // Encontrar a opção pelo valor e defini-la como selecionada
                        var option = select.querySelector('option[value="' + valor.id + '"]');
                        if (option) {

                            option.selected = true;
                        }
                        select.loadOptions();
                    });
                    // $(`#fk_areas_id option[value=${response.fk_areas_id}]`).prop('selected', 'selected')
                    // .change();
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
            const actions = [

                `@can('update-proposta_tema')<a class="text-info p-1" href="#" onclick="setIdModal(${row.id})">`,
                `<i class="fa fa-edit"></i>`,
                `</a>@endcan`,
                // Verificar se row.arquivo é diferente de null antes de adicionar o link
                row.arquivo !== null ?
                `<a rel="tooltip" class="text-success p-1 m-1" title="Visualizar Anexo" href="${row.storage}" target="_blank">` +
                `<i class="fa fa-search" aria-hidden="true"></i>` +
                `</a>` : '',
                '@can('delete-proposta_tema')<a class="remove" href="javascript:void(0)" title="Remove">',
                '<i class="fa fa-trash"></i>',
                '</a>@endcan'
            ];

            return actions.join('');
        }
    </script>
@endpush
@push('css')
    <style>
        .truncate-text {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 250px;
        }
    </style>
@endpush
