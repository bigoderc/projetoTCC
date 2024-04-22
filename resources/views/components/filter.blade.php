<div class="modal fade" id="filter" tabindex="-1" aria-labelledby="filter" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="titulo">Filtro</h5>
                <button type="button" class="close" onclick="fecharModalFilter()" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="{{ $id }}">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <!-- Adiciona a classe row para criar uma linha flexível com alinhamento à direita -->
                            <div class="col mb-2">
                                <!-- Adiciona as classes col para definir o tamanho das colunas em diferentes tamanhos de tela -->
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">De</span>
                                    </div>
                                    <input type="date" name="data_inicio" id="data_inicio" class="form-control">
                                </div>
                            </div>

                            <div class="col mb-2">
                                <!-- Mesmo para o segundo input -->
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Até</span>
                                    </div>
                                    <input type="date" name="data_fim" id="data_fim" class="form-control">
                                </div>
                            </div>
                            @isset($placa)
                                <div class="col mb-2">
                                    <!-- Mesmo para o segundo input -->
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Placa</span>
                                        </div>
                                        <input type="text" name="placa" id="placa_f" class="form-control">
                                    </div>
                                </div>
                            @endisset
                            @isset($areas)
                            <div class="col mb-2" >
                                <div class="input-group">
                                  <div class="input-group-prepend">
                                    <span class="input-group-text">Área</span>
                                  </div>
                                  <div class="form-control ">
                                    <select class="select-custom" id="area_id" name="areas[]" multiple
                                      multiselect-hide-x="true" multiselect-search="true"
                                      multiselect-max-items="5" required>
                                      @foreach ($areas as $area)
                                        <option value="{{ $area->id }}">{{ $area->nome }}</option>
                                      @endforeach
                                    </select>
                                    
                                  </div>
                                </div>
                            </div>
                            
                            @endisset
                            @isset($professores)
                                <div class="col mb-2">
                                    <!-- Adiciona as classes col para definir o tamanho das colunas em diferentes tamanhos de tela -->
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Docente</span>
                                        </div>
                                        <select class="form-control" name="equipe_id" id="equipe_id">
                                            <option value="">Selecione</option>
                                            @foreach ($professores as $professor)
                                                <option value="{{ $professor->id }}">{{ $professor->nome }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            @endisset
                            @isset($grades)
                                <div class="col mb-2">
                                    <!-- Adiciona as classes col para definir o tamanho das colunas em diferentes tamanhos de tela -->
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Grades</span>
                                        </div>
                                        <select class="form-control" name="tempo_carregamento" id="tempo_carregamento">
                                            <option value="">Selecione</option>
                                            @foreach ($grades as $grade)
                                                <option value="{{ $grade->tempo_carregamento }}">{{ $grade->tempo_carregamento }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            @endisset
                            @isset($caminhoes)
                                <div class="col mb-2">
                                    <!-- Adiciona as classes col para definir o tamanho das colunas em diferentes tamanhos de tela -->
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Perfil caminhão</span>
                                        </div>
                                        <select class="form-control" name="perfil_caminhao_id" id="perfil_caminhao_id">
                                            <option value="">Selecione</option>
                                            @foreach ($caminhoes as $caminhao)
                                                <option value="{{ $caminhao->id }}">{{ $caminhao->nome }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            @endisset
                            @isset($status)
                                <div class="col mb-2">
                                    <!-- Adiciona as classes col para definir o tamanho das colunas em diferentes tamanhos de tela -->
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Status</span>
                                        </div>
                                        <select class="form-control" name="status" id="status">
                                            <option value="">Selecione</option>
                                            @foreach ($status as $statu)
                                                <option value="{{ $statu['id'] }}">{{ $statu['nome'] }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            @endisset
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" onclick="fecharModalFilter()">Fechar</button>
                    <button type="button" onclick="filtrar()"  class="btn btn-primary">Filtrar</button>
                </div>
            </form>
        </div>
    </div>
</div>
@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
    <script>
        const id = '{{ $id }}'
        const table = '{{ $table }}'
        const action = '{{ $action }}'
        document.addEventListener('DOMContentLoaded', function() {
            // Get the current date
            var currentDate = moment().format('YYYY-MM-DD');

            // Get the date one month ago from the current date
            var oneMonthAgo = moment().subtract(1, 'months').format('YYYY-MM-DD');

            // Set the default values for the date inputs
            var dataInicioInput = document.getElementById('data_inicio');
            var dataFimInput = document.getElementById('data_fim');

            @isset($inicio)
                dataInicioInput.value = '{{ $inicio }}';
            @else
                dataInicioInput.value = oneMonthAgo;
            @endisset

            @isset($fim)
                dataFimInput.value = '{{ $fim }}';
            @else
                dataFimInput.value = currentDate;
            @endisset
        });
        function filtrar(params) {
            
            partialLoader();
            $.ajax({
                url: `{{ url('${action}') }}`,
                type: "POST",
                data: $(`#${id}`).serialize(),
                dataType: "json",
                success: function(response) {
                    fecharModalFilter();
                    $(`#${table}`).bootstrapTable('removeAll');
                    $(`#${table}`).bootstrapTable('prepend', response)
                    if(table =='dashboard_professor'){
                        renderizarCards(response);
                    }
                    partialLoader(false);

                },
                error: function(xhr, status, error) {
                    partialLoader(false);
                    switch (xhr.status) {
                        case 422:
                            var data = xhr.responseJSON.data;
                            var msg = '';
                            // Verificando se há propriedades no objeto "data"
                            if (data) {
                                for (var key in data) {
                                    if (data.hasOwnProperty(key)) {
                                        var value = data[key];
                                        msg += key + ": " + value
                                    }
                                }
                            }
                            errorResponse(msg);
                            // Trate o erro de validação conforme necessário
                            break;
                        case 500:
                            errorResponse('Erro interno do servidor ' + xhr.responseText);
                            // Trate o erro interno do servidor conforme necessário
                            break;
                        default:
                            errorResponse('Erro desconhecido: ' + xhr.responseText);
                            // Trate outros erros conforme necessário
                            break;
                    }
                }
            });
        }
        function fecharModalFilter(params) {
            $('#filter').modal('hide');
        }
    </script>
@endpush
