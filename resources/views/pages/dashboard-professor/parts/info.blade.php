<div class="card-body">
    <div class="modal fade" id="info" tabindex="-1" aria-labelledby="info" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="titulo">Informações</h5>
                    <button type="button" class="close" onclick="fecharModalinfo()" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="row">
                    <input type="hidden" class="form-control" id="carregamento_id" name="carregamento_id">
                    <div class="col-12">
                        <div class="col">
                            <div class="modal-body" class="my-2">
                                <div class="row mb-3">
                                    <div class="col">
                                        <label for="tema">Tema</label>
                                        <input type="text" class="form-control" id="tema" name="tema"
                                            required>
                                    </div>
                                    <div class="col">
                                        <label for="descricao">Descrição</label>
                                        <textarea class="form-control" name="descricao" id="descricao" rows="3"></textarea>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <label for="link_tema">Mais informações em</label>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="link_tema"></span>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="embed-responsive embed-responsive-16by9" id="pdfViewerTema"></div>
                                    </div>
                                </div>
                                <hr class="my-4">
                                <div class="row mb-3">
                                    <div class="col">
                                        <label for="area">Área</label>
                                        <input type="text" class="form-control" id="area" name="area"
                                            required>
                                    </div>
                                    <div class="col">
                                        <label for="descricao_area">Descrição</label>
                                        <textarea class="form-control" name="descricao_area" id="descricao_area" rows="3"></textarea>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <label for="link_area">Mais informações em</label>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text w-25" id="link_area"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="embed-responsive embed-responsive-16by9" id="pdfViewerArea"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" onclick="fecharModalinfo()">Fechar</button>
                </div>
            </div>
        </div>
    </div>
</div>
@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.10.377/pdf.min.js"></script>
    <script>
        function setInfo(params) {
            initInfo(params);
            $('#info').modal('show');
        }

        function initInfo(params) {
            partialLoader();
            $.ajax({
                url: `{{ url('dashboardAluno/findById/${params}') }}`,
                type: "GET",
                success: function(response) {

                    viewPDFArea(response.area?.storage);
                    viewPDFTema(response.storage);
                    partialLoader(false);
                    $(`#tema`).val(response.nome);
                    $(`#descricao`).val(response.descricao);
                    $(`#link_tema`).text(response.link);
                    $(`#area`).val(response.area?.nome);
                    $(`#descricao_area`).val(response.area.descricao);
                    $(`#link_area`).text(response.area.link);
                },
                error: function(xhr, status, error) {
                    partialLoader(false);
                    errorResponse(xhr.status, xhr.responseJSON.data, xhr
                        .responseText);
                }
            });
        }

        function fecharModalinfo(params) {
            $("input[type='radio']").prop('checked', false);
            $('#info').modal('hide');
        }

        function viewPDFTema(params) {
            const pdfFile = `${params}`;
            // Crie um elemento iframe
            const iframe = document.createElement('iframe');

            // Defina a largura e altura desejadas para o iframe
            iframe.width = '550';
            iframe.height = '300';

            // Defina o atributo src do iframe para o arquivo PDF
            iframe.src = pdfFile;

            // Adicione o iframe ao elemento com id 'pdfViewer' (ou substitua conforme necessário)
            document.getElementById('pdfViewerTema').appendChild(iframe);
        }
        function viewPDFArea(params) {
            const pdfFile = `${params}`;
            // Crie um elemento iframe
            const iframe = document.createElement('iframe');

            // Defina a largura e altura desejadas para o iframe
            iframe.width = '550';
            iframe.height = '300';

            // Defina o atributo src do iframe para o arquivo PDF
            iframe.src = pdfFile;

            // Adicione o iframe ao elemento com id 'pdfViewer' (ou substitua conforme necessário)
            document.getElementById('pdfViewerArea').appendChild(iframe);
        }
    </script>
@endpush
@push('css')
    <style></style>
@endpush
