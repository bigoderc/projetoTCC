@extends('layouts.pages.dashboard')

@section('content-page')
    {{-- @component('components.filter',
    [
        'action' => 'operacao/search', // Define a rota para submissão do formulário
        'id' =>'filter_operacao', // Define a rota para submissão do formulário
        'table' => 'my_table_id', // Define a rota para submissão do formulário
        'name' => 'Valor Padrão do Nome', // Defina aqui o valor padrão para o campo "name"
        'docas' =>$docas, // Defina aqui o valor para o campo "email" vindo de uma variável, por exemplo
        'equipes' =>$equipes, // Defina aqui o valor para o campo "email" vindo de uma variável, por exemplo
        'grades' =>$grades, // Defina aqui o valor para o campo "email" vindo de uma variável, por exemplo
        'placa' =>'', // Defina aqui o valor para o campo "email" vindo de uma variável, por exemplo
        'caminhoes' =>$caminhoes, // Defina aqui o valor para o campo "email" vindo de uma variável, por exemplo
        'status' =>[
            ['id' => 1, 'nome' => 'Agendado'],
            ['id' => 2, 'nome' => 'Em pátio'],
            ['id' => 3, 'nome' => 'Em carregamento'],
            ['id' => 4, 'nome' => 'Carregamento Finalizado']
        ], 
    ])
    @endcomponent --}}
    <div class="content-page">
        <div class="card-body">
            
            <div class="card">
                <div class="card-header card-title text-white bg-transparent border-0 m-3">
                    <span class="h4">Controle de entregas</span>
                </div>
                <div class="card-body">
                    <div id="toolbar">
                        <button class="btn btn-secondary text-white me-2" data-toggle="modal" data-target="#filter">
                            <i class="fa fa-filter"></i> Filtro
                        </button> 
                    </div>
                    <table id="my_table_id" class="text-left" data-toggle="table" data-editable="true" data-editable-pk="id"
                    data-editable-mode="inline" data-editable-type="text" data-locale="pt-BR" data-search="true"
                    data-show-columns="true" data-show-export="true" data-click-to-select="true" data-toolbar="#toolbar"
                    data-unique-id="id" data-id-field="id" data-page-size="50" data-page-list="[5, 10, 25, 50, 100, all]"
                    data-pagination="true" data-search-accent-neutralise="true" data-editable-url="#"
                        data-url="{{ route('entrega.show') }}" data-width="1500" data-response-handler="responseHandler">
                        <thead>
                            <tr>
                                {{-- <th data-field="id" data-sortable="true" class="col-1">ID</th> --}}
                                <th data-field="pedido" data-sortable="true" data-editable="false" class="col-2"
                                aria-required="true">OC</th>
                                <th data-field="nome" data-sortable="true" data-editable="false" class="col-2"
                                    aria-required="true">Cliente</th>
                                <th data-field="ordem_entrega" data-editable="false" data-sortable="true" class="col-2"
                                    aria-required="true">Orden de entrega</th>
                                <th data-field="data_prevista" data-editable="false" data-sortable="true" class="col-2"
                                aria-required="true">Data entrega</th>
                                <th data-field="quantidade" data-editable="false" data-sortable="true" class="col-2"
                                aria-required="true">Volume</th>
                                <th data-field="peso_liquido" data-sortable="true" data-editable="false" class="col-2"
                                    aria-required="true">Peso </th>
                                <th data-field="status_desc" data-editable="false" data-sortable="true" class="col-2"
                                    aria-required="true">Status</th>
                               
                                {{-- <th data-field="acao" class="col-1" data-formatter="acaoFormatter"  data-events="acaoEvents">Ação</th> --}}
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
         //Criar colunar ação
        function acaoFormatter(value, row, index) {
            return [
                `<a class="text-success p-1" href="#" onclick="setOcorrencia(${row.id})"title="Abrir Ocorrência">`,
                `<i class="fa fa-newspaper-o"></i>`,
                `</a>`,,
            ].join('');
        }
        function responseHandler(res) {
            for (const obj of res) {
                // Define valores padrão usando operador de coalescência nula (??)
                obj['carregamento'] = obj['carregamento'] ?? {};
                obj['carregamento']['equipe'] = obj['carregamento']['equipe'] ?? {};
                obj['carregamento']['equipe']['nome'] = obj['carregamento']['equipe']['nome'] ?? '';
            }
            return res;
        }

        window.acaoEvents = {
        'click .remove': function(e, value, row) {
            if (confirm("Deseja Excluir " + row.name + "?")) {
                $.ajax({
                    url: "delete/" + row.id,
                    type: "DELETE",
                    dataType: "json",
                    success: function(response) {
                        $('#my_table_id').bootstrapTable('remove', {
                                field: 'id',
                                values: [row.id]
                            });
                        successResponse();
                    },
                    error: function(xhr, status, error) {
                        partialLoader(false);
                        errorResponse(xhr);
                    }
                });
            }
        }
        
    } 
    function setOcorrencia(params) {
            console.log(params);
            deleteAlert().then((result) => {
                if (result.isConfirmed) {
                    partialLoader();
                    $.ajax({
                        url: `{{ url('operacao/noShow/${params}') }}`,
                        type: "GET",
                        dataType: "json",
                        success: function(response) {
                            partialLoader(false);
                            $('#my_table_id').bootstrapTable('updateByUniqueId', {
                                id: params,
                                row: response,
                                replace: false
                            })
                            successResponse('sucesso')
                        },
                        error: function(xhr, status, error) {
                            partialLoader(false);
                            errorResponse(xhr);
                        }
                    });
                }
            })
        }
        $(document).ready(function() {
            partialLoader();
            $('#my_table_id').on('load-success.bs.table', function() {
                partialLoader(false);
            })
        })
    </script>
@endpush
@push('css')
    <style>
        .ball {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            margin: 6px auto;
            text-align: right;
        }

        .checkbox-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            grid-gap: 10px;
        }

        .selected {
            border: 2px solid green;
        }

        .custom-width {
            width: 126px;
        }

        th[data-field="acao"] {
            white-space: nowrap;
        }
    </style>
@endpush
