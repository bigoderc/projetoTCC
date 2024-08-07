@extends('layouts.pages.dashboard')

@section('content-page')
    <div class="content-page">
        <div class="card">
            <div class="card-header card-title text-white bg-transparent border-0 m-3">
                <span class="h4 m-0">Configurações</span>
            </div>
            <div class="card-body">
                <div id="toolbar">
                    @can('insert-configuracao')
                        <button class="btn btn-secondary" data-toggle="modal" data-target="#novalinha"><i class="fa fa-plus"></i>
                            Adicionar</button>
                    @endcan
                    {{-- <div class="modal fade" id="add" tabindex="-1" role="dialog" aria-labelledby="modalCenter" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="bg-white modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="modalLong">Atribuir Permissão</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form id="addPermission" name="">
                                    @csrf
                                    <input type="hidden" id="teste" name="role">
                                    @foreach ($permissions as $permission)
                                        <div class="form-check">
                                            <div class="col-md-12">
                                                <input  class="form-check-input"  type="checkbox" name="permission[]" value="{{$permission->id}}" id="permission" />
                                                <label for="color_red">{{$permission->acao}}</label>
                                            </div>
                                        </div>
                                    @endforeach
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                                        <button type="submit" id="btnAnexo" class="btn btn-primary ml-2">Importar</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div> --}}
                    <div class="modal fade" id="novalinha" tabindex="-1" aria-labelledby="novalinha" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="titulo">Adicionar</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <form id="addLinha">
                                    @csrf
                                    <div class="modal-body" class="my-2">
                                        <label for="nome">Nome</label>
                                        <input type="text" class="form-control" id="nome" name="name">

                                        <label for="nome" class="my-2">Descrição</label>
                                        <input type="text" class="form-control" id="hospital" name="description">
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

                <table id="my_table_id" class="text-center" data-toggle="table" data-editable="true" data-editable-pk="id"
                    data-editable-mode="inline" data-editable-type="text" data-locale="pt-BR" data-search="true"
                    data-show-columns="true" data-show-export="true" data-click-to-select="true" data-toolbar="#toolbar"
                    data-unique-id="id" data-id-field="id" data-page-size="25" data-page-list="[5, 10, 25, 50, 100, all]"
                    data-pagination="true" data-search-accent-neutralise="true"
                    data-editable-url="{{ route('configuracao.update') }}" data-url="{{ route('configuracao.show') }}">
                    <thead>
                        <tr>
                            <th data-field="nome" data-editable="true" data-sortable="true" class="col-3"
                                aria-required="true">NOME</th>
                            <th data-field="description" data-editable="true" data-sortable="true" class="col-4"
                                aria-required="true">DESCRIÇAO</th>
                            <th data-field="acao" class="col-1" data-formatter="acaoFormatter" data-events="acaoEvents">
                                Ação</th>
                        </tr>
                    </thead>
                </table>
                <span style="font-weight: bold">Dê duplo clique para editar e Enter para salvar!</span>
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
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            });
            $("#addLinha").submit(function(event) {
                event.preventDefault();

                $.ajax({
                    url: "{{ route('configuracao.store') }}",
                    type: "POST",
                    data: $(this).serialize(),
                    dataType: "json",
                    success: function(response) {
                        if (response.success === true) {
                            $('#novalinha').modal('hide');
                            $('#my_table_id').bootstrapTable('append', response.dados);
                        } else {
                            alert('erro');
                        }
                    },
                    error: function(xhr, status, error) {
                        toast('error', responseError(error));
                    }
                });
                $("input").val("");
            });

            $("#addPermission").submit(function(event) {
                event.preventDefault();

                $.ajax({
                    url: "{{ route('configuracao.setRole') }}",
                    type: "POST",
                    data: $(this).serialize(),
                    dataType: "json",
                    success: function(response) {
                        if (response.success === true) {
                            $('#add').modal('hide');
                            $('#my_table_id').bootstrapTable('append', response.dados);
                        } else {
                            alert('erro');
                        }
                    },
                    error: function(xhr, status, error) {
                        toast('error', responseError(error));
                    }
                });
                for (i = 0; i < document.testes.elements.length; i++) {
                    if (document.f1.elements[i].type == "checkbox") {
                        document.f1.elements[i].checked = false;
                    }
                }
            });
        });

        //Excluir uma nova linha
        window.acaoEvents = {
            'click .remove': function(e, value, row) {
                $('#my_table_id').bootstrapTable('remove', {
                    field: 'id',
                    values: [row.id]
                });
            },
            'click .add': function(e, value, row) {
                document.getElementById('teste').value = row.id
                var form = document.getElementById("add")
                var checks = form.getElementsByTagName("input");
                for (var i = 0; i < checks.length; i++) {
                    var chk = checks[i];
                    if (chk.name == "permission[]")
                        chk.checked = this.checked;
                }
            }
        }

        //Criar colunar ação
        function acaoFormatter(value, row, index, field) {
            return [
                '@can('delete-configuracao')
                <a class="remove" href="javascript:void(0)" title="Remove">',
                '<i class="fa fa-trash"></i>',
                '</a>@endcan',
                `@if(Gate::check('insert-configuracao') || Gate::check('update-configuracao')) <a class="text-info p-1 add" href="configuracao/permission/${row['id']}" title="Atribuir Permissão">`,
                `<i class="fa fa-plus" aria-hidden="true"></i>`,
                `</a>@endif`
            ].join('');
        }
    </script>
@endpush
