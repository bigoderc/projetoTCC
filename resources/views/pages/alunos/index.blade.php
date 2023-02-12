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
                                        <label for="nome">Instituição</label>
                                        <input type="text" class="form-control" id="nome" name="instituicao">
                                        <label for="nome">Email</label>
                                        <input type="text" class="form-control" id="nome" name="email">
                                        <div class="row">
                                            <div class="col">
                                                <label for="nome">Curso</label>
                                                <select class="form-control" name="fk_curso_id" id="fk_curso_id" aria-label="Default select example">
                                                    <option selected>Selecione o Curso</option>
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
                                                <input type="text" class="form-control" id="nome" name="matricula">
                                            </div>
                                            <div class="col">
                                                <label for="nome">Matriculado</label>
                                                <select class="form-control" name="matriculado" aria-label="Default select example">
                                                    <option value="S" selected>Sim</option>
                                                    <option value="N">Não</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col">
                                                <label for="nome">Período</label>
                                                <input type="text" class="form-control" maxlength="10" id="nome" name="periodo">
                                            </div>
                                            <div class="col">
                                                <label for="nome">Ingresso</label>
                                                <input type="month" class="form-control" id="nome" maxlength="10" name="ingresso">
                                            </div>
                                        </div>
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
                            <th data-field="matriculado" data-editable="true" class="col-3" aria-required="true">MATRICULADO</th>
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
    $('select').select2({
        maximumInputLength: 20 // only allow terms up to 20 characters long
    });
    //Adicionar uma nova linha e lançar via ajax
    $(document).ready(function() {
        $("#addLinha").submit(function(event) {
            fullLoader();
            event.preventDefault();

            $.ajax({
                url: "{{ route('alunos.store') }}",
                type: "POST",
                data: $(this).serialize(),
                dataType: "json",
                success: function(response) {
                    $('#novalinha').modal('hide');
                    $('#my_table_id').bootstrapTable('append', response);
                    fullLoader(false);
                },
                error: function(result) {
                    alert('erro');
                }
            });
            $("input").val("");
        });
    });

    //Excluir uma nova linha
    window.acaoEvents = {
        'click .remove': function(e, value, row) {
            if (confirm("Deseja Excluir " + row.nome + "?")) {
                $.ajax({
                    url: "areas/" + row.id,
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
            `<a class="text-info p-1" href="#" data-toggle="modal" title="Editar Registro" data-target="#edit${row.id}">`,
            `<i class="fa fa-edit"></i>`,
            `</a>`,
            '<a class="remove" href="javascript:void(0)" title="Remove">',
            '<i class="fa fa-trash"></i>',
            '</a>'
        ].join('');
    }
    $("#fk_curso_id").change(function() {
        fullLoader();
        let id_curso = $(this).val();
        $.ajax({
            url:`{{ url('turmas/${id_curso}') }}`,
            type: "GET",
            success: function(response) {
                let select = document.createElement("select");
                select.setAttribute('id', "fk_turma_id");
                select.setAttribute('name', "fk_turma_id");
                select.setAttribute('required', true);

                for (var i = 0; i < response.length; i++) {

                    let option = document.createElement("option");
                    option.setAttribute('value', response[i]['id']);
                    option.innerText = response[i]['nome'];

                    select.append(option);
                }

                document.getElementById("turma").append(select);
                $("#fk_turma_id").select2();
                fullLoader(false);
            },
            error: function(result) {
            }
        });
    });
</script>
@endpush