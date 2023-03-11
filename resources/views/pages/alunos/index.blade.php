@extends('layouts.pages.dashboard')

@section('content-page')
<div class="content-page">
    <div class="card-body">
        <div class="card">
            <div class="card-header card-title text-white bg-transparent border-0 m-3">
                <span class="h4">Alunos</span>
            </div>
            <div class="card-body">
                <div id="toolbar">
                    <button class="btn btn-secondary" data-toggle="modal" data-target="#novalinha"><i class="fa fa-plus"></i> Adicionar nova linha</button>

                    <div class="modal fade" id="novalinha" tabindex="-1" aria-labelledby="novalinha" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="titulo">Adicionar Aluno</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
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
                                                    <option value="S" selected>Sim</option>
                                                    <option value="N">Não</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col">
                                                <label for="nome">Período</label>
                                                <input type="text" class="form-control" maxlength="10" id="periodo" name="periodo">
                                            </div>
                                            <div class="col">
                                                <label for="nome">Ingresso</label>
                                                <input type="month" class="form-control" id="ingresso" maxlength="10" name="ingresso" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
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
                    data-pagination="true" data-search-accent-neutralise="true" data-editable-url="#" data-url="{{ route('alunos.show',1) }}">
                    <thead>
                        <tr>
                            <th data-field="id" class="col-1">ID</th>
                            <th data-field="nome" data-editable="true" class="col-3" aria-required="true">NOME</th>
                            <th data-field="matricula" data-editable="true" class="col-3" aria-required="true">MÁTRICULA</th>
                            <th data-field="matriculado_desc" data-editable="true" class="col-3" aria-required="true">MATRICULADO</th>
                            <th data-field="curso.nome" data-editable="false" class="col-3" aria-required="true">CURSO</th>
                            <th data-field="turma.nome" data-editable="false" class="col-3" aria-required="true">TURMA</th>
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
                    fullLoader();
                    let id =document.getElementById('id').value;
                    $.ajax({
                        url: id > 0 ? `{{ url('alunos/update/${id}') }}` : "{{ route('alunos.store') }}",
                        type: id >0 ? "PUT" : "POST",
                        data: $(this).serialize(),
                        dataType: "json",
                        success: function(response) {
                            console.log(id);
                            $('#novalinha').modal('hide');
                            id >0 ? $('#my_table_id').bootstrapTable('updateByUniqueId', {id:id, row: response,replace:false}):$('#my_table_id').bootstrapTable('append', response);
                            
                        },
                        error: function(result) {
                            console.log(result.matricula);
                        }
                    });
                    fullLoader(false);
                    $("input").val("");
                }
                
            })
        });
    });

    //Excluir uma nova linha
    window.acaoEvents = {
        'click .remove': function(e, value, row) {
            if (confirm("Deseja Excluir " + row.nome + "?")) {
                $.ajax({
                    url: "alunos/" + row.id,
                    type: "DELETE",
                    dataType: "json",
                    success: function(response) {
                        if (response.success === true) {
                            $('#my_table_id').bootstrapTable('remove', {
                                field: 'id',
                                values: [row.id]
                            });
                        } else {
                            alert('Impossível Excluir');
                        }
                    }
                });
            }
        }
    }

    //Criar colunar ação
    function acaoFormatter(value, row, index) {
        return [
            `<a class="text-info p-1" href="#" onclick="setIdModal(${row.id})"title="Editar Registro">`,
            `<i class="fa fa-edit"></i>`,
            `</a>`,
            '<a class="remove" href="javascript:void(0)" title="Remove">',
            '<i class="fa fa-trash"></i>',
            '</a>'
        ].join('');
    }
    $("#fk_curso_id").change(function() {
        fullLoader();
        $("#turma").find("*").not("label").remove();
        let id_curso = $(this).val();
        $.ajax({
            url:`{{ url('turmas/${id_curso}') }}`,
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
                fullLoader(false);
            },
            error: function(result) {
            }
        });
    });
    function setIdModal(id) {
        document.getElementById('id').value = id;
        $.ajax({
                url: `{{ url('alunos/findById/${id}') }}`,
                type: "GET",
                success: function(response) {
                    $(`#titulo`).text(`Editar Aluno ${response.nome}`);
                    $(`#salvar`).text(`Salvar`);
                    $(`#nome`).val(response.nome);
                    $(`#email`).val(response.email);
                    $(`#instituicao`).val(response.instituicao);
                    $(`#matricula`).val(response.matricula);
                    $(`#matriculado option[value=${response.matriculado}]`).prop('selected','selected').change();
                    $(`#periodo`).val(response.periodo);
                    $(`#ingresso`).val(response.ingresso);
                    $(`#fk_curso_id option[value=${response.fk_curso_id}]`).prop('selected','selected').change();
                    $(`#fk_turma_id option[value=${response.fk_turma_id}]`).prop('selected','selected').change();
                    $('#novalinha').modal('show');
                },
                error: function(result) {
                    alert('erro');
                }
            });
        
    }
</script>
@endpush