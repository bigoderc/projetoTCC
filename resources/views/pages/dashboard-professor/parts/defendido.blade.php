<div class="card-body">
    <div class="modal fade" id="defendido" tabindex="-1" aria-labelledby="defendido" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="titulo2">Defendido</h5>
                    <button type="button" class="close" onclick="fecharModalprofessor12()" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="formDefender" class="needs-validation" novalidate  name="addLinha" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <input type="hidden" class="form-control" id="id" name="id">
                        <input type="hidden" class="form-control" id="tema_id2" name="tema_id">
                        <div class="col-12">
                            <div class="col">
                                <label for="data_apresentacao" class="my-2">Data Apresentação</label>
                                <input type="date" class="form-control" id="apresentacao" name="apresentacao">
                                <label for="arquivo" class="my-2">Arquivo</label>
                                <input type="file" class="form-control mb-1" accept=".png,.jpeg,.pdf" id="arquivo"
                                    name="arquivo">
                            </div>
                            
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary"
                            onclick="fecharModalprofessor12()">Fechar</button>
                        <button type="button" id="salvar" onclick="defendido()"
                            class="btn btn-primary">Salvar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@push('scripts')
    <script>
        function setDefendido(params) {
            $(`#tema_id2`).val(params);
            $.ajax({
                url: `{{ url('dashboardProfessor/findByTema/${params}') }}`,
                type: "GET",
                success: function(response) {
                    if(response){
                        $(`#titulo2`).text(`TCC Defendido`);
                    }else{
                        $(`#titulo2`).text(`Pré-TCC Defendido`);
                    }
                    
                    $('#defendido').modal('show');
                },
                error: function(xhr, status, error) {
                    errorResponse(xhr.status, xhr.responseJSON.data, xhr
                        .responseText);
                }
            }); 
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

        function defendido(params) {
            partialLoader();
            var formdata = new FormData($("form[name='addLinha']")[0]);
            $.ajax({
                url: "{{ route('dashboardProfessor.defendido') }}",
                type: "POST",
                data: formdata,
                dataType: "json",
                processData: false,
                contentType: false,
                success: function(response) {
                    $('#defendido').modal('hide');

                    partialLoader(false);
                    successResponse();
                    fecharModalprofessor12();
                    renderizarCards(response);
                },
                error: function(xhr, status, error) {
                    partialLoader(false);
                    errorResponse(xhr.status, xhr.responseJSON.data, xhr
                        .responseText);
                }
            })
        }

        function fecharModalprofessor12(params) {
            $('#defendido').modal('hide');
            clearForm('formDefender','defendido')
        }
    </script>
@endpush
