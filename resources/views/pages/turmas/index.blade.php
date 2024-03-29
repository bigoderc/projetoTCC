@extends('layouts.pages.dashboard',[
    'title'=>'checked',
    'checked'=>true
])
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
                    @can('insert-turma')
                        <button class="btn btn-secondary" data-toggle="modal" data-target="#novalinha"><i class="fa fa-plus"></i> Adicionar nova linha</button>
                    @endcan
                    <div class="modal fade" id="novalinha" tabindex="-1" aria-labelledby="novalinha" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Adicionar nova linha</h5>
                                    <button type="button" class="close" onclick="clearForm('addLinha','novalinha')" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <form id="addLinha" class="needs-validation" novalidate>
                                    @csrf
                                    <div class="modal-body" class="my-2">
                                        <label for="nome">Nome</label>
                                        <input type="text" class="form-control" id="nome" name="nome" required>
                                        <label for="nome">Descrição</label>
                                        <input type="text" class="form-control" id="descricao" name="descricao">
                                        <input type="hidden" class="form-control fk_curso_id" name="fk_curso_id">
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" onclick="clearForm('addLinha','novalinha')">Fechar</button>
                                        <button type="submit" class="btn btn-primary">Adicionar</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <table id="my_table_id" class="text-center" data-toggle="table" data-editable="true" data-editable-pk="id" data-editable-mode="inline" data-editable-type="text" data-locale="pt-BR" data-search="true" data-show-columns="true" data-show-export="true" data-click-to-select="true" data-toolbar="#toolbar" data-unique-id="id" data-id-field="id" data-page-size="25" data-page-list="[5, 10, 25, 50, 100, all]" data-pagination="true" data-search-accent-neutralise="true" data-editable-url="{{ route('turma.update1') }}">
                    <thead>
                        <tr>
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
        $('#my_table_id').bootstrapTable('removeAll');
        partialLoader();
        let id_curso = `${document.getElementById('cursoSelect').value}`;
        $(`.fk_curso_id`).val(id_curso);
        $.ajax({
            url:`{{ url('turma/${id_curso}') }}`,
            type: "GET",
            success: function(response) {
                $('#my_table_id').bootstrapTable('append', response);
                partialLoader(false);
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
        var forms = document.getElementsByClassName('needs-validation');
        $("#addLinha").submit(function(event) {
            event.preventDefault();
            var validation = Array.prototype.filter.call(forms, function(form) {
            if (form.checkValidity() === false) {
                form.classList.add('was-validated');

            } else {
                $.ajax({
                    url: "{{ route('turma.store') }}",
                    type: "POST",
                    data: $("#addLinha").serialize(),
                    dataType: "json",
                    success: function(response) {
                        
                        clearForm('addLinha', 'novalinha')
                        partialLoader(false);
                        $('#my_table_id').bootstrapTable('append', response);
                        successResponse();
                    },
                    error: function(xhr, status, error) {
                        partialLoader(false);
                        errorResponse(xhr.status, xhr.responseJSON.data, xhr
                            .responseText);
                    }
                });
            }
        });
        });
     
    });

    //Excluir uma nova linha
    window.acaoEvents = {
    'click .remove': function(e, value, row) {
        deleteAlert().then((result) => {
            if (result.isConfirmed) {
                partialLoader();
                $.ajax({
                    url: "turma/" + row.id,
                    type: "DELETE",
                    dataType: "json",
                    success: function(response) {
                        partialLoader(false);
                        $('#my_table_id').bootstrapTable('remove', {
                            field: 'id',
                            values: [row.id]
                        });
                        successResponse();
                    },
                    error: function(xhr, status, error) {
                        partialLoader(false);
                        errorResponse(xhr.status, xhr.responseJSON.data, xhr
                            .responseText);
                    }
                });
            }
        })
    }
}

    function setIdModal(id) {
        document.getElementById('id').value = id;
    }
    //Criar colunar ação
    function acaoFormatter(value, row, index) {
        return [
            '@can('update-turma')<a class="remove" href="javascript:void(0)" title="Remove">',
            '<i class="fa fa-trash"></i>',
            '</a>@endcan'
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
