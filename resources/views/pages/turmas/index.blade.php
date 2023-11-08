@extends('layouts.pages.dashboard')

@section('content-page')
<div class="content-page">
    <div class="card-body">
        <div class="card">
            <div class="card-header card-title text-white bg-transparent border-0 m-3">
                <span class="h4">Turmas</span>
            </div>
            <div class="card-body">
                <div id="toolbar">
                    <div  class="input-group mb-4">
                        <div class="input-group-prepend">
                            <label class="input-group-text" for="cursoSelect">Curso</label>
                        </div>
                        <select  class="rounded-right " id="cursoSelect"
                            onchange="getNewCurso()">
                            <option value="" disabled>Selecione</option>
                            @foreach ($cursos as $curso)
                                <option value="{{ $curso->id }}" {{ request()->curso == $curso->id ? 'selected' : '' }}>
                                    {{ $curso->nome }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button class="btn btn-secondary" data-toggle="modal" data-target="#novalinha"><i class="fa fa-plus"></i> Adicionar nova linha</button>

                    <div class="modal fade" id="novalinha" tabindex="-1" aria-labelledby="novalinha" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Adicionar nova linha</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <form id="addLinha">
                                    @csrf
                                    <div class="modal-body" class="my-2">
                                        <label for="nome">Nome</label>
                                        <input type="text" class="form-control" id="nome" name="nome">
                                        <label for="nome">Descrição</label>
                                        <input type="text" class="form-control" id="descricao" name="descricao">
                                        <input type="hidden" class="form-control" id="fk_curso_id" name="fk_curso_id">
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                                        <button type="submit" class="btn btn-primary">Adicionar</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <table id="my_table_id" class="text-center" data-toggle="table" data-editable="true" data-editable-pk="id" data-editable-mode="inline" data-editable-type="text" data-locale="pt-BR" data-search="true" data-show-columns="true" data-show-export="true" data-click-to-select="true" data-toolbar="#toolbar" data-unique-id="id" data-id-field="id" data-page-size="25" data-page-list="[5, 10, 25, 50, 100, all]" data-pagination="true" data-search-accent-neutralise="true" data-editable-url="{{ route('turmas.update1') }}" data-url="#">
                    <thead>
                        <tr>
                            <th data-field="id" class="col-1">ID</th>
                            <th data-field="nome" data-editable="true" class="col-3" aria-required="true">NOME</th>
                            <th data-field="descricao" data-editable="true" class="col-3" aria-required="true">DESCRIÇÃO</th>
                            <th data-field="curso.nome" data-editable="false" class="col-3" aria-required="true">CURSO</th>
                            <th data-field="acao" class="col-1" data-formatter="acaoFormatter" data-events="acaoEvents">Ação</th>
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
            'X-CSRF-TOKEN': '{{csrf_token()}}'
        }
    });
    

    function getNewCurso() {
        fullLoader();
        let id_curso = `${document.getElementById('cursoSelect').value}`;
        document.getElementById('fk_curso_id').value = id_curso;
        $.ajax({
            url:`{{ url('turmas/${id_curso}') }}`,
            type: "GET",
            success: function(response) {
                if(response.length >0){
                    $('#my_table_id').bootstrapTable('append', response);
                }else{
                    $('#my_table_id').bootstrapTable('removeAll');
                }
                fullLoader(false);
            },
            error: function(result) {
                $('#my_table_id').bootstrapTable('removeAll');
            }
        });
    }
    //Adicionar uma nova linha e lançar via ajax
    $(document).ready(function() {
        getNewCurso();
        form = ['nome','descricao'];
        $("#addLinha").submit(function(event) {
            event.preventDefault();

            $.ajax({
                url: "{{ route('turmas.store') }}",
                type: "POST",
                data: $(this).serialize(),
                dataType: "json",
                success: function(response) {
                    
                    $('#novalinha').modal('hide');
                    $('#my_table_id').bootstrapTable('append', response);
                    successResponse();
                },
                error: function(result) {
                    errorResponse('Erro inesperado');
                }
            });
            form.map(function(elem) {
                document.getElementById(`${elem}`).value = "";
            })
        });
     
    });

    //Excluir uma nova linha
    window.acaoEvents = {
        'click .remove': function(e, value, row) {
            if (confirm("Deseja Excluir " + row.nome + "?")) {
                $.ajax({
                    url: "turmas/" + row.id,
                    type: "DELETE",
                    dataType: "json",
                    success: function(response) {
                        if (response.success === true) {
                            $('#my_table_id').bootstrapTable('remove', {
                                field: 'id',
                                values: [row.id]
                            });
                            successResponse();
                        } else {
                            errorResponse('Erro inesperado');
                        }
                    }
                });
            }
        }
    }

    function setIdModal(id) {
        document.getElementById('id').value = id;
    }
    //Criar colunar ação
    function acaoFormatter(value, row, index) {
        return [
            '<a class="remove" href="javascript:void(0)" title="Remove">',
            '<i class="fa fa-trash"></i>',
            '</a>'
        ].join('');
    }
</script>
@endpush
@push('css')
    <style>
       
        .input-group{
            flex-wrap: initial;
        }
        
    </style>
@endpush
