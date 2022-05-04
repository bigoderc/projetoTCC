@extends('layouts.pages.dashboard')

@section('content-page')
<div class="content-page p-5">
    <h2>Professores</h2>
    <div class="card">
        <div class="card-body">
            <div id="toolbar">
                <button class="btn btn-secondary" data-toggle="modal" data-target="#novalinha"><i class="fas fa-plus"></i> Adicionar nova linha</button>

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
                                    <label for="nome">Siape</label>
                                    <input type="text" maxlength="7" class="form-control" id="nome" name="matricula">
                                    <label for="nome">Cargo</label>
                                    <input type="text" class="form-control"  id="matricula" name="cargo">      
                                    <label for="nome" class="my-2">Área</label>
                                    <select class="form-control" name="fk_areas_id" aria-label="Default select example">
                                        <option selected>Selecione a Área</option>
                                        @foreach($areas as $area)
                                            <option value="{{$area->id}}">{{$area->nome}}</option>
                                        @endforeach
                                    </select>
                                    <label for="nome">Especialidade</label>
                                    <input type="text" class="form-control"  id="matricula" name="especialidade" >
                                    
                                    <label for="nome">Grau</label>
                                    <input type="text" class="form-control"  id="matricula" name="grau" >
                                    
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                                    <button type="submit" class="btn btn-primary" >Adicionar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <table
            id="my_table_id"
            class="text-center"
            data-toggle="table"
            data-editable="true"
            data-editable-pk="id"
            data-editable-mode="inline"
            data-editable-type="text"
            data-locale="pt-BR"
            data-search="true"
            data-show-columns="true"
            data-show-export="true"
            data-click-to-select="true"
            data-toolbar="#toolbar"
            data-unique-id="id"
            data-id-field="id"
            data-page-size="5"
            data-page-list="[5, 10, 25, 50, 100, all]"
            data-pagination="true"
            data-search-accent-neutralise="true"
            data-editable-url="#"
            >
                <thead>
                    <tr>
                        <th data-field="id" class="col-1">ID</th>
                        <th data-field="nome" class="col-3" aria-required="true">NOME</th>
                        <th data-field="descricao" class="col-3" aria-required="true">SIAPE</th>
                        <th data-field="area" class="col-3" aria-required="true">ÁREA</th>
                        <th data-field="acao" class="col-1" data-formatter="acaoFormatter" data-events="acaoEvents">Ação</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($professores as $professor)
                        <tr>
                            <td>{{$professor->id}}</td>
                            <td>{{$professor->nome}}</td>
                            <td>{{$professor->matricula}}</td>
                            <td>{{$professor->areas->nome}}</td>
                            <td></td>
                        </tr>
                        <div class="modal fade" id="edit{{$professor->id}}" tabindex="-1" aria-labelledby="novalinha" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Editar {{$professor->nome}}</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <form action="{{ route('professores.update',$professor) }}" class="form" method="POST">
                                        @method('PUT')
                                        @csrf
                                        <div class="modal-body" class="my-2">
                                            <label for="nome">Nome</label>
                                            <input type="text" class="form-control" id="nome" name="nome" value="{{ old('nome',$professor->nome) }}">
                                            <label for="nome">Siape</label>
                                            <input type="text" class="form-control" maxlength="7" id="matricula" name="matricula" value="{{ old('matricula',$professor->matricula) }}">
                                            <label for="nome">Cargo</label>
                                            <input type="text" class="form-control"  id="matricula" name="cargo" value="{{ old('cargo',$professor->cargo) }}">
                                            <label for="nome" class="my-2">area</label>
                                            <select class="form-control" name="fk_area_id" aria-label="Default select example">
                                                <option value="{{ old('nome',$professor->areas->id) }}" selected>{{ $professor->areas->nome}}</option>
                                                @foreach($areas as $area)
                                                    <option value="{{$area->id}}">{{$area->nome}}</option>
                                                @endforeach
                                            </select>
                                            <label for="nome">Especialidade</label>
                                            <input type="text" class="form-control"  id="matricula" name="especialidade" value="{{ old('especialidade',$professor->especialidade) }}">
                                            
                                            <label for="nome">Grau</label>
                                            <input type="text" class="form-control"  id="matricula" name="grau" value="{{ old('grau',$professor->grau) }}">
                                            
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                                            <button type="submit" class="btn btn-primary" >Salvar</button>
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
$(document).ready(function () {
    $("#addLinha").submit(function(event){
        event.preventDefault();

        $.ajax({
            url: "{{ route('professores.store') }}",
            type: "POST",
            data: $(this).serialize(),
            dataType:"json",
            success: function(response) {
                if(response.success === true){
                    $('#novalinha').modal('hide');
                    $('#my_table_id').bootstrapTable('append', response.dados);
                }else{
                    alert('erro');
                }
            }
        });
        $("input").val("");
    });
});

//Excluir uma nova linha
window.acaoEvents = {
    'click .remove': function (e, value, row) {
        if (confirm("Deseja Excluir "+row.nome+"?")) {
            $.ajax({
                url: "professores/"+row.id,
                type: "DELETE",
                dataType:"json",
                success: function(response) {
                    if(response.success === true){
                        $('#my_table_id').bootstrapTable('remove', {
                            field: 'id',
                            values: [row.id]
                        });
                    }else{
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
       `<a class="text-info p-1" href="#" data-toggle="modal" data-target="#edit${row.id}">`,
      `<i class="fas fa-edit"></i>`,
      `</a>`,
      '<a class="remove" href="javascript:void(0)" title="Remove">',
      '<i class="fa fa-trash"></i>',
      '</a>'
    ].join('');
}
</script>
@endpush
