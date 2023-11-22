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
                                        <input type="text" class="form-control" id="descricao" name="descricao">
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
                                    <div class="col d-none">
                                        <canvas id="pdfViewer" style="border: 1px solid black;"></canvas>
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
                                        <input type="text" class="form-control" id="descricao_area" name="descricao_area">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <label for="link_area">Mais informações em</label>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="link_area"></span>
                                            </div>
                                            
                                        </div>
                                    </div>
                                    <div class="col d-none">
                                        <canvas id="pdfViewer" style="border: 1px solid black;"></canvas>
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
            init(params);
            $('#info').modal('show');
        }

        function init(params) {
            $.ajax({
                url: `{{ url('dashboardAluno/findById/${params}') }}`,
                type: "GET",
                success: function(response) {
                    //viewPDF()
                    $(`#tema`).val(response.nome);
                    $(`#descricao`).val(response.descricao);
                    $(`#link_tema`).text(response.link); 
                    $(`#area`).val(response.area.nome);
                    $(`#descricao_area`).val(response.area.descricao);
                    $(`#link_area`).text(response.area.link); 
                },
                error: function(xhr, status, error) {
                    partialLoader(false);
                    errorResponse(xhr);
                }
            });
        }
        function fecharModalinfo(params) {
            $("input[type='radio']").prop('checked', false);
            $('#info').modal('hide');
        }
        function viewPDF(params) {
            const urlParams = new URLSearchParams(window.location.search);
            const pdfFile = `D:/projetos/tcc/storage/app/public/projeto/Documentodeequipe(1).pdf`;

            pdfjsLib.getDocument(pdfFile).then(pdf => {
                pdf.getPage(1).then(page => {
                    const canvas = document.getElementById('pdfViewer');
                    const context = canvas.getContext('2d');
                    const viewport = page.getViewport({ scale: 1.5 });

                    canvas.width = viewport.width;
                    canvas.height = viewport.height;

                    page.render({ canvasContext: context, viewport: viewport });
                });
            });
        }
    </script>
@endpush
@push('css')
    <style></style>
@endpush
