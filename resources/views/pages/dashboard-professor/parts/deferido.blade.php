<div class="card-body">
    <div class="modal fade" id="deferido" tabindex="-1" aria-labelledby="deferido" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="titulo">Deferir ou Indeferir</h5>
                    <button type="button" class="close" onclick="fecharModalprofessor()" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="formDeferido" class="needs-validation" novalidate>
                    @csrf
                    <div class="row">
                        <input type="hidden" class="form-control" id="tema_id" name="tema_id">
                        <div class="col-12">
                            <div class="col">
                                <label for="status">Status</label>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="deferido" id="deferido-true"
                                        value="true" checked>
                                    <label class="form-check-label" for="deferido-true">
                                        Deferido
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="deferido" id="deferido-false"
                                        value="false">
                                    <label class="form-check-label" for="deferido-false">
                                        Indeferido
                                    </label>
                                </div>

                            </div>
                            <div class="col d-none" id="bloco-justificativa">
                                <div class="form-group">
                                    <label for="justificativa">Justificativa</label>
                                    <textarea class="form-control" name="justificativa" id="justificativa" rows="3"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary"
                            onclick="fecharModalprofessor()">Fechar</button>
                        <button type="button" id="salvar" onclick="defefir()"
                            class="btn btn-primary">Salvar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@push('scripts')
    <script>
        function setDeferido(params) {
            $(`#tema_id`).val(params);
            init();
            $('#deferido').modal('show');
        }

        function init() {
            $.ajax({
                url: `{{ route('docente.show', 1) }}`,
                type: "GET",
                success: function(response) {
                    $('#tema_table').bootstrapTable('removeAll');
                    $('#tema_table').bootstrapTable('append', response);
                },
                error: function(xhr, status, error) {
                    partialLoader(false);
                    errorResponse(xhr.status, xhr.responseJSON.data, xhr
                        .responseText);
                }
            });
        }

        function defefir(params) {

            var disponibilidade = 0;
            $.ajax({
                url: `{{ route('dashboardProfessor.getDashboard') }}`,
                type: "GET",
                dataType: "json",
                async: false, // Define a requisição como síncrona
                success: function(response) {
                    disponibilidade = response.disponibilidade;
                },
                error: function(xhr, status, error) {
                    errorResponse(xhr.status, xhr.responseJSON.data, xhr.responseText);
                }
            });
            const radios = document.querySelectorAll('input[name="deferido"]');
            let selectedValue;
            for (const radio of radios) {
                if (radio.checked) {
                    selectedValue = radio.value;
                    break;
                }
            }
            if (selectedValue && disponibilidade == 0) {
                var payload = $('#formDeferido').serialize();
                payload += '&incrementar=true';
                deleteAlert('Alerta de Disponibilidade Informamos que a disponibilidade do docente está esgotada.',
                        'Caso aceite a proposta, será incrementada mais uma disponibilidade de orientação no seu cadastro. Deseja prosseguir?')
                    .then((result) => {
                        if (result.isConfirmed) {
                            partialLoader();
                            $.ajax({
                                url: "{{ route('dashboardProfessor.deferir') }}",
                                type: "POST",
                                data: payload,
                                dataType: "json",
                                success: function(response) {
                                    $('#deferido').modal('hide');


                                    successResponse();
                                    fecharModalprofessor();
                                    renderizarCards(response);
                                },
                                error: function(xhr, status, error) {
                                    partialLoader(false);
                                    errorResponse(xhr.status, xhr.responseJSON.data, xhr
                                        .responseText);
                                }
                            })
                        }
                    });
            } else {
                partialLoader();
                $.ajax({
                    url: "{{ route('dashboardProfessor.deferir') }}",
                    type: "POST",
                    data: $('#formDeferido').serialize(),
                    dataType: "json",
                    success: function(response) {
                        $('#deferido').modal('hide');


                        successResponse();
                        fecharModalprofessor();
                        renderizarCards(response);
                    },
                    error: function(xhr, status, error) {
                        partialLoader(false);
                        errorResponse(xhr.status, xhr.responseJSON.data, xhr
                            .responseText);
                    }
                })
            }



        }

        function fecharModalprofessor(params) {
            $("input[type='radio']").prop('checked', false);
            $('#deferido').modal('hide');
        }
        document.querySelectorAll('input[name="deferido"]').forEach(function(radio) {
            radio.addEventListener('change', function() {
                // Verifica se o radio button com valor "false" está selecionado
                if (document.getElementById('deferido-false').checked) {
                    // Remove a classe d-none da div específica
                    document.getElementById('bloco-justificativa').classList.remove('d-none');
                } else {
                    // Adiciona a classe d-none à div específica
                    document.getElementById('bloco-justificativa').classList.add('d-none');
                }
            });
        });
    </script>
@endpush
