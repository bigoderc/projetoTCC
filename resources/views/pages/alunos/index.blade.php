@extends('layouts.pages.dashboard',[
    'title'=>'checked',
    'checked'=>true
])

@section('content-page')
<div class="content-page">
    <div class="card-body">
        <div class="card">
            <div class="card-header card-title text-white bg-transparent border-0 m-3">
                <span class="h4">Discente</span>
            </div>
            <div class="card-body">
                <div id="toolbar">
                    @can('insert-discente')
                        <button class="btn btn-secondary" data-toggle="modal" data-target="#novalinha"><i class="fa fa-plus"></i> Adicionar novo discente</button>
                    @endcan
                    <div class="modal fade" id="novalinha" tabindex="-1" aria-labelledby="novalinha" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="titulo">Adicionar</h5>
                                    <button id="fechar" type="button" class="close" onclick="clearForm('addLinha','novalinha')" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <form id="addLinha" class="needs-validation" novalidate>
                                    @csrf
                                    <div class="modal-body" class="my-2">
                                        <input type="hidden" class="form-control" id="id" name="id">
                                        <label for="nome">Nome</label>
                                        <input type="text" class="form-control" id="nome" name="nome" required>
                                        <label for="nome">Instituição</label>
                                        <input type="text" class="form-control" id="instituicao" name="instituicao" required>
                                        <label for="nome">Email</label>
                                        <input type="text" class="form-control" id="email" name="email" required>
                                        <div class="row">
                                            <div class="col">
                                                <label for="nome">Curso</label>
                                                <select class="form-control" name="fk_curso_id" id="fk_curso_id" aria-label="Default select example" required>
                                                    <option value="" selected>Selecione o Curso</option>
                                                    @foreach($cursos as $curso)
                                                    <option value="{{$curso->id}}">{{$curso->nome}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col" id="turma">
                                                <label for="nome">Turma</label>
                                                
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col">
                                                <label for="nome">Mátricula</label>
                                                <input type="text" class="form-control" id="matricula" name="matricula" required>
                                            </div>
                                            <div class="col">
                                                <label for="nome">Matriculado</label>
                                                <select class="form-control" name="matriculado" id="matriculado" aria-label="Default select example">
                                                    <option value="" selected>Selecione</option>
                                                    <option value="S">Sim</option>
                                                    <option value="N">Não</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row mb-2">
                                            <div class="col">
                                                <label for="nome">Período de Ingresso</label>
                                                <input type="text" class="form-control" maxlength="2" id="periodo" name="periodo">
                                            </div>
                                            <div class="col">
                                                <label for="nome">Ano de Ingresso</label>
                                                <input type="year" class="form-control" id="ingresso" maxlength="4" name="ingresso" required>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" value="1" name="formado" id="formado">
                                                    <label class="form-check-label" for="formado">
                                                        Formado
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button id="fechar" type="button" class="btn btn-secondary" onclick="clearForm('addLinha','novalinha')">Fechar</button>
                                        <button type="submit" id="salvar" class="btn btn-primary">Adicionar</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <table id="my_table_id" class="text-center" data-toggle="table" data-editable="true" data-editable-pk="id"
                    data-editable-mode="inline" data-editable-type="text" data-locale="pt-BR" data-search="true"
                    data-show-columns="true" data-show-export="true" data-click-to-select="true" data-toolbar="#toolbar"
                    data-unique-id="id" data-id-field="id" data-page-size="25" data-page-list="[5, 10, 25, 50, 100, all]"
                    data-pagination="true" data-search-accent-neutralise="true" data-editable-url="#" data-url="{{ route('discente.show',1) }}">
                    <thead>
                        <tr>
                            <th data-field="nome" data-editable="true" class="col-3" aria-required="true">Nome</th>
                            <th data-field="matricula" data-editable="true" class="col-3" aria-required="true">Mátricula</th>
                            <th data-field="matriculado_desc" data-editable="true" class="col-3" aria-required="true">Matriculado</th>
                            <th data-field="curso.nome" data-editable="false" class="col-3" aria-required="true">Curso</th>
                            <th data-field="turma.nome" data-editable="false" class="col-3" aria-required="true">Turma</th>
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

    //Adicionar uma nova linha e lançar via ajax
    $(document).ready(function() {
        
        var forms = document.getElementsByClassName('needs-validation');
        $("#addLinha").submit(function(event) {
            event.preventDefault();
            var validation = Array.prototype.filter.call(forms, function(form) {
                if (form.checkValidity() === false) {
                    form.classList.add('was-validated');
                    
                }else{
                    
                    partialLoader();
                    let id =document.getElementById('id').value;
                    $.ajax({
                        url: id > 0 ? `{{ url('discente/update/${id}') }}` : "{{ route('discente.store') }}",
                        type: id >0 ? "PUT" : "POST",
                        data: $(`#addLinha`).serialize(),
                        dataType: "json",
                        success: function(response) {
                            partialLoader(false);
                            $(`#formado`).prop('checked',false);
                            clearForm('addLinha','novalinha');
                            
                            
                            id >0 ? $('#my_table_id').bootstrapTable('updateByUniqueId', {id:id, row: response,replace:false}):$('#my_table_id').bootstrapTable('append', response);
                            successResponse();
                        },
                        error: function(xhr, status, error) {
                            partialLoader(false);
                            errorResponse(xhr.status,xhr.responseJSON.data,xhr.responseText);
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
                        url: "discente/" + row.id,
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
                            errorResponse(xhr.status,xhr.responseJSON.data,xhr.responseText);
                        }
                    });
                }
            })
        }
    }

    //Criar colunar ação
    function acaoFormatter(value, row, index) {
        return [
            `<a class="text-info p-1" href="#" onclick="setIdModal(${row.id},true)">`,
                `<i class="fa fa-eye" aria-hidden="true"></i>`,
            `</a>`,
            ` @can('update-discente')<a class="text-info p-1" href="#" onclick="setIdModal(${row.id})"title="Editar Registro">`,
            `<i class="fa fa-edit"></i>`,
            `</a>@endcan`,
            ' @can('delete-discente')<a class="remove" href="javascript:void(0)" title="Remove">',
            '<i class="fa fa-trash"></i>',
            '</a>@endcan'
        ].join('');
    }
    $("#fk_curso_id").change(function() {
        
        $("#turma").find("*").not("label").remove();
        let id_curso = $(this).val();
        $.ajax({
            url:`{{ url('turma/${id_curso}') }}`,
            type: "GET",
            success: function(response) { 
                let select = document.createElement("select");
                select.setAttribute('id', "fk_turma_id");
                select.setAttribute('name', "fk_turma_id");
                select.setAttribute('required', true);
                select.setAttribute('class', 'form-control');
                for (var i = 0; i < response.length; i++) {

                    let option = document.createElement("option");
                    option.setAttribute('value', response[i]['id']);
                    option.innerText = response[i]['nome'];

                    select.append(option);
                }
                document.getElementById("turma").append(select);
                
            },
            error: function(xhr, status, error) {
               
                errorResponse(xhr.status,xhr.responseJSON.data,xhr.responseText);
            }
        });
    });
    function setIdModal(id, disabled = false) {
        partialLoader();
        document.getElementById('id').value = id;
        $.ajax({
                url: `{{ url('discente/findById/${id}') }}`,
                type: "GET",
                success: function(response) {
                    $(`#titulo`).text(`Editar Discente ${response.nome}`);
                    $(`#salvar`).text(`Salvar`);
                    $(`#nome`).val(response.nome);
                    
                    $(`#email`).val(response.user?.email);
                    if (response.user) {
                        $(`#email`).prop('disabled', true);
                    }
                    $(`#instituicao`).val(response.instituicao);
                    $(`#matricula`).val(response.matricula);
                    $(`#matriculado option[value=${response.matriculado}]`).prop('selected','selected').change();
                    $(`#periodo`).val(response.periodo);
                    $(`#ingresso`).val(response.ingresso);
                    $(`#formado`).prop('checked',response.formado);
                    $(`#fk_curso_id option[value=${response.fk_curso_id}]`).prop('selected','selected').change();
                   
                    setTimeout(function () {
                        $(`#fk_turma_id option[value=${response.fk_turma_id}]`).prop('selected', 'selected').change();
                        if (disabled) {
                            $('#novalinha :input:not(#visualizar, #fechar)').prop('disabled', true);
                            $('#novalinha select').prop('disabled', true);
                        }else{
                            $('#novalinha :input').prop('disabled', false);
                            $('#novalinha select').prop('disabled', false);
                        }
                        $('#novalinha').modal('show');
                        partialLoader(false);
                    }, 1500);
                    
                },
                error: function(xhr, status, error) {
                    partialLoader(false);
                    errorResponse(xhr.status,xhr.responseJSON.data,xhr.responseText);
                }
            });
        
    }
</script>
@endpush