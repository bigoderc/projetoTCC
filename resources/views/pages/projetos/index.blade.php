@extends('layouts.pages.dashboard')

@section('content-page')
<div class="content-page p-1 m-1">
    <h2>Projetos</h2>
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
                            <form action="{{ route('projetos.store') }}" class="form" method="POST" enctype='multipart/form-data'>
                                @csrf
                                <div class="modal-body" class="my-2">
                                    <label for="nome" class="my-2">Projeto</label>
                                    <input type="text" class="form-control"  id="nome" name="nome">
                                    <label for="nome" class="my-2">Instituição</label>
                                    <input type="text" class="form-control"  id="instituicao" name="instituicao">
                                    <label for="nome" class="my-2">Data Apresentação</label>
                                    <input type="date" class="form-control" id="data" name="apresentacao">
                                    <label for="nome" class="my-2">Orientador</label>
                                    <select class="form-control" name="fk_professores_id" aria-label="Default select example">
                                        <option  selected>Selecione</option>
                                        @foreach($professores as $professor)
                                            <option value="{{$professor->id}}">{{$professor->nome}}</option>
                                        @endforeach
                                    </select>
                                    <label for="nome" class="my-2">Arquivo</label>
                                    <input type="file" class="form-control" accept=".png,.jpeg,.pdf" id="hospital" name="arquivo">
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
            data-locale="pt-BR"
            data-search="true"
            data-show-columns="true"
            data-show-export="true"
            data-click-to-select="true"
            data-toolbar="#toolbar"
            data-unique-id="id"
            data-id-field="id"
            data-page-size="50"
            data-page-list="[50,75, 100, all]"
            data-pagination="true"
            data-search-accent-neutralise="true"
            data-editable-url="#"
            >
                <thead>
                    <tr>
                        <th data-field="id" class="col-1">ID</th>
                        <th data-field="name"  class="col-2" aria-required="true">NOME</th>
                        <th data-field="centro_custo"  class="col-2" aria-required="true">INSTITUIÇÃO</th>
                        <th data-field="tipo_gasto" class="col-2" aria-required="true" >APRESENTAÇÃO</th>
                        <th data-field="descricao" dclass="col-2" aria-required="true">ORIENTADOR</th>
                        <th data-field="acao" class="col-2" data-formatter="acaoFormatter" data-events="acaoEvents">AÇÃO</th>

                    </tr>
                </thead>
                <tbody>
                    
                    @foreach($projetos as $projeto)
                       
                        <tr >
                            <td>{{$projeto->id}}</td>
                            
                            <td>{{$projeto->nome}}</td>
                        
                            <td>{{$projeto->instituicao}}</td>
                            <td>{{date('d/m/Y', strtotime($projeto->apresentacao))}}</td>
                            <td>{{$projeto->professor->nome}}</td>
                            <td>

                            </td>
                        </tr>
                        
                        <div class="modal fade" id="edit{{$projeto->id}}" tabindex="-1" aria-labelledby="novalinha" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Editar {{$projeto->descricao}}</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <form action="{{ route('projetos.update',$projeto->id) }}" class="form" method="POST" enctype='multipart/form-data'>
                                        @method('PUT')
                                        @csrf
                                        <div class="modal-body" class="my-2">
                                            <label for="nome" class="my-2">Projeto</label>
                                            <input type="text" class="form-control" id="valor" value="{{ old('nome',$projeto->nome) }}" name="nome">
                                            <label for="nome" class="my-2">Instituição</label>
                                            <input type="text" class="form-control" id="valor" value="{{ old('instituicao',$projeto->instituicao) }}" name="instituicao">
                                            <label for="nome" class="my-2">Data Apresentacao</label>
                                            <input type="date" class="form-control" id="data" name="apresentacao" value="{{ old('data',$projeto->apresentacao) }}">
                                            <label for="nome" class="my-2">Orientador</label>
                                            <select class="form-control" name="fk_professores_id" aria-label="Default select example">
                                                <option value="{{$projeto->professor->id}}"  selected>{{$projeto->professor->nome}}</option>
                                                @foreach($professores as $professor)
                                                    <option value="{{$professor->id}}">{{$professor->nome}}</option>
                                                @endforeach
                                            </select>
                                            <label for="nome" class="my-2">Arquivo</label>
                                            <input type="file" class="form-control" accept=".png,.jpeg,.pdf" id="hospital" name="arquivo">
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                                            <button type="submit" class="btn btn-primary" >Salvar</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                       
                        <div class="modal fade" id="upload{{$projeto->id}}" tabindex="-1" role="dialog" aria-labelledby="modalCenter" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="bg-white modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="modalLong">Enviar Arquivo</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form method="POST"  action="{{ route('projetos.update',$projeto->id) }}" enctype="multipart/form-data">
                                            @csrf
                                            @method('put')
                                            <label for="anexo">Selecione seu arquivo</label>
                                            <input type="file" name="arquivo" accept=".pdf,.jpeg,.png" required="" />
                                            <input type="hidden" name="id" value="{{$projeto->id}}"/>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                                                <button type="submit" id="btnAnexo" class="btn btn-primary ml-2">Importar</button>
                                            </div>
                                        </form>
                                    </div>
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
    $('.money').mask('R$ #.##0,00', {reverse: true});
    $("#addLinha").submit(function(event){
        event.preventDefault();

        $.ajax({
            url: "{{ route('projetos.store') }}",
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
        if (confirm("Deseja Excluir ?")) {
            $.ajax({
                url: "projetos/destroy/"+row.id,
                type: "POST",
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
function priceFormatter(value) {
    // 16777215 == ffffff in decimal
    var color = '#' + Math.floor(Math.random() * 6777215).toString(16)
    return '<select>' +
      '<option>teste</option>' +
      '</select>'
  }
//Criar colunar ação
function acaoFormatter(value, row, index) {
    return [
        `<a class="text-info p-1" href="#" data-toggle="modal" title="Editar Registro" data-target="#edit${row.id}">`,
        `<i class="fas fa-edit"></i>`,
        `</a>`,
        `<a class="text-danger p-1" href="#" data-toggle="modal" title="Atualizar Anexo" data-target="#upload${row.id}">`,
        `<i class="fa fa-upload " aria-hidden="true"></i>`,
        `</a>`,
        `<a rel="tooltip" class="text-success p-1" title="Visualizar Anexo" href="projetos/${row.id}"  target="_blank" >`,
        `<i class="fa fa-search" aria-hidden="true"></i>`,
        `</a>`,
        '<a class="remove" href="javascript:void(0)" title="Remove">',
        '<i class="fa fa-trash"></i>',
        '</a>'
  ].join('');
}

</script>
@endpush
