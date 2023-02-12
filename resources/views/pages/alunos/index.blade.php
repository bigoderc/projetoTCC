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
                                                <input type="text" class="form-control" id="nome" maxlength="10" name="ingresso">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col">
                                                <label for="nome">Turma</label>
                                                <input type="text" class="form-control" maxlength="10" id="nome" name="turma">
                                            </div>
                                            <div class="col">
                                                <label for="nome">Curso</label>
                                                <input type="text" class="form-control" id="nome" maxlength="120" name="curso">
                                            </div>

                                        </div>
                                        <label for="nome">Instituição</label>
                                        <input type="text" class="form-control" id="nome" name="instituicao">
                                        <label for="nome">Email</label>
                                        <input type="text" class="form-control" id="nome" name="email">
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
                    data-pagination="true" data-search-accent-neutralise="true" data-editable-url="#">
                    <thead>
                        <tr>
                            <th data-field="id" class="col-1">ID</th>
                            <th data-field="nome" data-editable="true" class="col-3" aria-required="true">NOME</th>
                            <th data-field="matricula" data-editable="true" class="col-3" aria-required="true">MÁTRICULA</th>
                            <th data-field="matriculado" data-editable="true" class="col-3" aria-required="true">MATRICULADO</th>
                            <th data-field="curso" data-editable="false" class="col-3" aria-required="true">CURSO</th>
                            <th data-field="turma" data-editable="false" class="col-3" aria-required="true">TURMA</th>
                            <th data-field="acao" class="col-1" data-formatter="acaoFormatter" data-events="acaoEvents">Ação</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($alunos as $aluno)
                        <tr>
                            <td>{{$aluno->id}}</td>
                            <td>{{$aluno->nome}}</td>
                            <td>{{$aluno->matricula}}</td>
                            <td>{{$aluno->matriculado =='S'? 'Matriculado' :'Inativo'}}</td>
                            <td>{{$aluno->curso}}</td>
                            <td>{{$aluno->turma}}</td>
                            <td></td>

                        </tr>
                        <div class="modal fade" id="edit{{$aluno->id}}" tabindex="-1" aria-labelledby="novalinha" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Editar {{$aluno->descricao}}</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <form action="{{ route('alunos.update',$aluno->id) }}" class="form" method="POST" enctype='multipart/form-data'>
                                        @method('PUT')
                                        @csrf
                                        <div class="modal-body" class="my-2">
                                            <label for="nome">Nome</label>
                                            <input type="text" class="form-control" value="{{ old('nome',$aluno->nome) }}" id="nome" name="nome">
                                            <div class="row">
                                                <div class="col">
                                                    <label for="nome">Mátricula</label>
                                                    <input type="text" class="form-control" value="{{ old('matricula',$aluno->matricula) }}" id="nome" name="matricula">
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
                                                    <input type="text" class="form-control" value="{{ old('periodo',$aluno->periodo) }}" maxlength="10" id="nome" name="periodo">
                                                </div>
                                                <div class="col">
                                                    <label for="nome">Ingresso</label>
                                                    <input type="text" class="form-control" value="{{ old('ingresso',$aluno->ingresso) }}" id="nome" maxlength="10" name="ingresso">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col">
                                                    <label for="nome">Turma</label>
                                                    <input type="text" class="form-control" value="{{ old('turma',$aluno->turma) }}" maxlength="10" id="nome" name="turma">
                                                </div>
                                                <div class="col">
                                                    <label for="nome">Curso</label>
                                                    <input type="text" class="form-control" value="{{ old('curso',$aluno->curso) }}" id="nome" maxlength="120" name="curso">
                                                </div>

                                            </div>
                                            <label for="nome">Instituição</label>
                                            <input type="text" class="form-control" value="{{ old('instituicao',$aluno->instituicao) }}" id="nome" name="instituicao">
                                            <label for="nome">Email</label>
                                            <input type="text" class="form-control" value="{{ old('email',$aluno->email) }}" id="nome" name="email">
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                                            <button type="submit" class="btn btn-primary">Salvar</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </tbody>
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
        $("#addLinha").submit(function(event) {
            event.preventDefault();

            $.ajax({
                url: "{{ route('alunos.store') }}",
                type: "POST",
                data: $(this).serialize(),
                dataType: "json",
                success: function(response) {
                    if (response.success === true) {

                        $('#novalinha').modal('hide');
                        $('#my_table_id').bootstrapTable('append', response.dados);

                    } else {
                        alert('erro');
                    }
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
</script>
@endpush