@extends('layouts.pages.dashboard')

@section('content-page')
<div class="content-page">
    <div class="card-body">
        <div class="card">
            <div class="card-header card-title text-white bg-transparent border-0 m-3">
                <span class="h4">Pré-TCC</span>
            </div>
            <div class="card-body">

                <div id="toolbar">
                    @can('insert-pre_tcc')
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
                                <form id="addLinha" name="addLinha" enctype="multipart/form-data"
                                    class="needs-validation" novalidate>
                                    @csrf
                                    <div class="modal-body" class="my-2">
                                        <input type="hidden" class="form-control" id="id" name="id">
                                        <label for="nome" class="my-2">Projeto</label>
                                        <input type="text" class="form-control" id="nome" name="nome" required>
                                        <label for="aluno" class="my-2">Discente</label>
                                        <select class="form-control" name="fk_aluno_id" id="fk_aluno_id" aria-label="Selecione" required>
                                            <option value="" selected>Selecione</option>
                                            @foreach($alunos as $aluno)
                                                <option value="{{$aluno->id}}">{{$aluno->nome}}</option>
                                            @endforeach
                                        </select>
                                        <label for="area" class="my-2">Área</label>
                                        <select class="form-control" name="fk_areas_id" id="fk_areas_id" aria-label="Selecione" required>
                                            <option value="" selected>Selecione</option>
                                            @foreach($areas as $area)
                                                <option value="{{$area->id}}">{{$area->nome}}</option>
                                            @endforeach
                                        </select>
                                        <label for="instituicao" class="my-2">Instituição</label>
                                        <input type="text" class="form-control" id="instituicao" value="IF BAIANO" name="instituicao">
                                       <label for="orientador" class="my-2">Orientador</label>
                                        <select class="form-control" name="fk_professores_id" id="fk_professores_id"  aria-label="Default select example" required>
                                            <option value="" selected>Selecione</option>
                                            @foreach($professores as $professor)
                                            <option value="{{$professor->id}}">{{$professor->nome}}</option>
                                            @endforeach
                                        </select>
                                        <label for="arquivo" class="my-2">Arquivo</label>
                                        <input type="file" class="form-control" accept=".png,.jpeg,.pdf" id="arquivo" name="arquivo" required>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            onclick="clearForm('addLinha','novalinha')">Fechar</button>
                                        <button type="submit" id="salvar" class="btn btn-primary">Adicionar</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <table id="my_table_id" class="text-center" data-toggle="table" data-editable="true"
                data-editable-pk="id" data-editable-mode="inline" data-editable-type="text" data-locale="pt-BR"
                data-search="true" data-show-columns="true" data-show-export="true" data-click-to-select="true"
                data-toolbar="#toolbar" data-unique-id="id" data-id-field="id" data-page-size="25"
                data-page-list="[5, 10, 25, 50, 100, all]" data-pagination="true"
                data-search-accent-neutralise="true" data-editable-url="#"
                data-url="{{ route('pre-tcc.show', 1) }}">
                <thead>
                    <tr>
                        <th data-field="id" class="col-1">ID</th>
                        <th data-field="nome" class="col-3" aria-required="true">PROJETO</th>
                        <th data-field="aluno.nome" class="col-3" aria-required="true">DISCENTE</th>
                        <th data-field="instituicao" class="col-3" aria-required="true">INSTITUIÇÃO</th>
                        <th data-field="area.nome" class="col-3" aria-required="true">ÁREA</th>
                        <th data-field="professor.nome" class="col-3" aria-required="true">PROFESSOR</th>
                        <th data-field="acao" class="col-1" data-formatter="acaoFormatter"
                            data-events="acaoEvents">Ação</th>
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

//Adicionar uma nova linha e lançar via ajax
$(document).ready(function() {
    var forms = document.getElementsByClassName('needs-validation');
    $("#addLinha").submit(function(event) {
        event.preventDefault();
        var formdata = new FormData($("form[name='addLinha']")[0]);
        var validation = Array.prototype.filter.call(forms, function(form) {
            if (form.checkValidity() === false) {
                form.classList.add('was-validated');

            } else {
                partialLoader();
                let id = document.getElementById('id').value;
                $.ajax({
                    url: id > 0 ? `{{ url('pre-tcc/update/${id}') }}` :
                        "{{ route('pre-tcc.store') }}",
                    type:"POST",
                    data: formdata,
                    dataType: "json",
                    processData: false,
                    contentType: false,
                    success: function(response) {

                        clearForm('addLinha', 'novalinha')
                        partialLoader(false);

                        id > 0 ? $('#my_table_id').bootstrapTable(
                            'updateByUniqueId', {
                                id: id,
                                row: response,
                                replace: false
                            }) : $('#my_table_id').bootstrapTable('prepend',
                            response);
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
    });
});

//Excluir uma nova linha
window.acaoEvents = {
    'click .remove': function(e, value, row) {
        deleteAlert().then((result) => {
            if (result.isConfirmed) {
                partialLoader();
                $.ajax({
                    url: "pre-tcc/" + row.id,
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
    partialLoader();
    document.getElementById('id').value = id;
    $.ajax({
        url: `{{ url('pre-tcc/findById/${id}') }}`,
        type: "GET",
        success: function(response) {
            $(`#titulo`).text(`Editar Professor ${response.nome}`);
            $(`#salvar`).text(`Salvar`);
            $(`#nome`).val(response.nome);
            $(`#aluno`).val(response.aluno);
            $(`#apresentacao`).val(response.apresentacao);
            $(`#instituicao`).val(response.instituicao);
            $(`#fk_professores_id option[value=${response.fk_professores_id}]`).prop('selected', 'selected')
            .change();
            $(`#fk_areas_id option[value=${response.fk_areas_id}]`).prop('selected', 'selected')
            .change(); 
            $(`#fk_aluno_id option[value=${response.fk_aluno_id}]`).prop('selected', 'selected')
            .change(); 
            $(`#arquivo`).prop('required',false);
           $('#novalinha').modal('show');

            partialLoader(false);

        },
        error: function(xhr, status, error) {
            partialLoader(false);
            errorResponse(xhr.status, xhr.responseJSON.data, xhr
                .responseText);
        }
    });

}


//Criar colunar ação
function acaoFormatter(value, row, index) {
    const actions = [
        `@can('update-pre_tcc')<a class="text-info p-1" href="#" onclick="setIdModal(${row.id})">`,
        `<i class="fa fa-edit"></i>`,
        `</a>@endcan`,
        // Verificar se row.arquivo é diferente de null antes de adicionar o link
        row.projeto !== null ? `<a rel="tooltip" class="text-success p-1 m-1" title="Visualizar Anexo" href="${row.storage}" target="_blank">` +
            `<i class="fa fa-search" aria-hidden="true"></i>` +
            `</a>` : '',
        '@can('delete-pre_tcc')<a class="remove" href="javascript:void(0)" title="Remove">',
        '<i class="fa fa-trash"></i>',
        '</a>@endcan'
    ];

    return actions.join('');
}
</script>
@endpush
