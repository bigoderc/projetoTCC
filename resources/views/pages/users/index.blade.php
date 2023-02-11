@extends('layouts.pages.dashboard')

@section('content-page')
<div class="content-page p-1 m-1">
    <h2>Tabela</h2>
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
                                    <input type="text" class="form-control" id="nome" name="name">

                                    <label for="nome" class="my-2">email</label>
                                    <input type="email" class="form-control" id="hospital" name="email">

                                    <label for="nome" class="my-2">Password</label>
                                    <input type="password" class="form-control" id="valor" name="password">
                                    <label for="nome" class="my-2">Perfil</label>
                                    <select class="form-control" name="fk_roles_id" aria-label="Default select example">
                                        
                                        <option  selected>Selecione o Perfil</option>
                                        @foreach($roles as $role)
                                            <option value="{{$role->id}}">{{$role->nome}}</option>
                                        @endforeach
                                    </select>
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
            data-search-accent-neutralise="true">
                <thead>
                    <tr>
                        <th data-field="id" class="col-1">ID</th>
                        <th data-field="name" data-editable="true" class="col-3" aria-required="true">NOME</th>
                        <th data-field="email" data-editable="true" class="col-4" aria-required="true">email</th>
                        <th data-field="acao" class="col-1" data-formatter="acaoFormatter" data-events="acaoEvents">Ação</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                        <tr >
                            <td>{{$user->id}}</td>
                            <td>{{$user->name}}</td>
                            <td>{{$user->email}}</td>
                            <td>

                            </td>
                            <div class="modal fade" id="edit{{$user->id}}" tabindex="-1" aria-labelledby="novalinha" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Editar {{$user->descricao}}</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <form action="{{ route('users.update',$user->id) }}" class="form" method="POST" enctype='multipart/form-data'>
                                        @method('PUT')
                                        @csrf
                                        <div class="modal-body" class="my-2">
                                            <label for="nome">Nome</label>
                                            <input type="text" class="form-control" id="nome" value="{{ old('name',$user->name) }}" name="name">

                                            <label for="nome" class="my-2">email</label>
                                            <input type="email" class="form-control" id="hospital" name="email" value="{{ old('email',$user->email) }}">

                                           
                                           
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                                            <button type="submit" class="btn btn-primary" >Salvar</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        </tr>
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
            url: "{{ route('users.store') }}",
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
        $('#my_table_id').bootstrapTable('remove', {
        field: 'id',
        values: [row.id]
      });
    }
}

//Criar colunar ação
function acaoFormatter(value, row, index) {
    return [
      `<a class="text-info p-1" href="#" data-toggle="modal" title="Editar Registro" data-target="#edit${row.id}">`,
      `<i class="fas fa-edit"></i>`,
      '<a class="remove" href="javascript:void(0)" title="Remove">',
      '<i class="fa fa-trash"></i>',
      '</a>'
  ].join('');
}
</script>
@endpush
