<div class="card-body">
    <div class="modal fade" id="indeferido" tabindex="-1" aria-labelledby="indeferido" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="titulo">Indeferido</h5>
                    <button type="button" class="close" onclick="fecharModalprofessor()" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
               
                <form id="formDeferido" class="needs-validation" novalidate>
                    @csrf
                    <div class="row">
                        <input type="hidden" class="form-control" id="tema_id" name="tema_id">
                        <div class="col-12">
                            <div class="col " id="bloco-justificativa">
                                <div class="form-group">
                                    <label for="justificativa">Justificativa</label>
                                    <textarea class="form-control" name="justificativa" id="justificativa" rows="3"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" onclick="fecharModalprofessor()">Fechar</button>
                        <button type="button" id="salvar" onclick="confirmed()" class="btn btn-primary">Confirmar</button>
                    </div>
                </form>


            </div>
        </div>
    </div>
</div>
@push('scripts')
    <script>
        function setIndeferido(params) {
            $(`#tema_id`).val(params);
            init(params);
            $('#indeferido').modal('show');
        }
        function init(params) {
            partialLoader();
            $.ajax({
                url: `{{ url('dashboardAluno/findById/${params}') }}`,
                type: "GET",
                success: function(response) {
                    $(`#justificativa`).val(response.tema_aluno.justificativa)
                    partialLoader(false);
                },
                error: function(xhr, status, error) {
                    partialLoader(false);
                    errorResponse(xhr);
                }
            });
        }

        function confirmed(params) {

            
            partialLoader();
            $.ajax({
                url: "{{ route('dashboardAluno.confirmed') }}",
                type: "POST",
                data:  $('#formDeferido').serialize(),
                dataType: "json",
                success: function(response) {
                    $('#indeferido').modal('hide');

                    partialLoader(false);
                    successResponse();
                    fecharModalprofessor();
                    renderizarCards(response);
                },
                error: function(xhr, status, error) {
                    partialLoader(false);
                    errorResponse(xhr);
                }
            })
        }

        function fecharModalprofessor(params) {
            $("input[type='radio']").prop('checked', false);
            $('#indeferido').modal('hide');
        }
        document.querySelectorAll('input[name="indeferido"]').forEach(function(radio) {
            radio.addEventListener('change', function() {
                // Verifica se o radio button com valor "false" está selecionado
                if (document.getElementById('indeferido-false').checked) {
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
