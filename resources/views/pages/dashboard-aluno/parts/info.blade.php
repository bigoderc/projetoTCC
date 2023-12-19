<div class="card-body">
    <div class="modal fade" id="info" tabindex="-1" aria-labelledby="info" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="titulo">Informações</h5>
                    <button type="button" class="close" onclick="fecharModalinfo1()" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body my-2">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="tema">Tema</label>
                            <textarea  class="form-control" id="tema" name="tema" rows="5"></textarea>
                        </div>
                        <div class="col-md-6">
                            <label for="descricao">Descrição</label>
                            <textarea class="form-control" name="descricao" id="descricao" rows="5"></textarea>
                        </div>
                    </div>
                
                    <div class="row">
                        <div class="col-md-6">
                            <label for="link_tema">Mais informações em</label>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="link_tema"></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="embed-responsive embed-responsive-16by9" id="pdfViewerTema"></div>
                        </div>
                    </div>
                
                </div>
                

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" onclick="fecharModalinfo1()">Fechar</button>
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

                  
                    viewPDFTema(response.storage);
                    partialLoader(false);
                    $(`#tema`).val(response.nome);
                    $(`#descricao`).val(response.descricao);
                    $(`#link_tema`).text(response.link);
                   
                },
                error: function(xhr, status, error) {
                    partialLoader(false);
                    errorResponse(xhr.status, xhr.responseJSON.data, xhr
                        .responseText);
                }
            });
        }

        function fecharModalinfo1(params) {
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
