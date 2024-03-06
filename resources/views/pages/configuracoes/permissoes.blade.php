@extends('layouts.pages.dashboard')

@section('content-page')
    <div class="content-page">
        <div class="card">
            <div class="card-header card-title text-white bg-transparent border-0 m-3">
                <span class="h4">Permissões</span>
            </div>
            <div class="card-body">
                <div id="toolbar">
                    <div  class="input-group mb-3">
                        <div class="input-group-prepend">
                            <label class="input-group-text" for="profileSelect">Perfil</label>
                        </div>
                        <select  class="rounded-right " id="profileSelect"
                            onchange="getNewProfile()">
                            @foreach ($model as $role)
                                <option value="{{ $role->id }}" {{ request()->role == $role->id ? 'selected' : '' }}>
                                    {{ $role->nome }}</option>
                            @endforeach
                        </select>
                    </div>
                    {{-- <div class="modal fade" id="novalinha" tabindex="-1" aria-labelledby="novalinha" aria-hidden="true">
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

                                    <label for="nome" class="my-2">Descrição</label>
                                    <input type="text" class="form-control" id="hospital" name="description">
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                                    <button type="submit" class="btn btn-primary" >Adicionar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div> --}}
                </div>

                <table id="teste" class="text-center" data-toggle="table" data-locale="pt-BR" data-search="true"
                    data-toolbar="#toolbar" data-page-size="25" data-page-list="[5, 10, 25, 50, 100, all]"
                    data-pagination="true" data-search-accent-neutralise="true"
                    data-url="{{ route('configuracao.getPermission',request()->role ) }}">
                    <thead>
                        <tr>
                            <th data-field="description" data-sortable="true" class="col-3">PERMISSÃO</th>
                            <th data-field="permission" data-formatter="permissionFormatter" class="col-auto">PROPRIEDADES
                            </th>
                        </tr>
                    </thead>
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
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        });
        $('select').select2({
            maximumInputLength: 20 // only allow terms up to 20 characters long
        });

        function getNewProfile() {
            location.href = `${document.getElementById('profileSelect').value}`;
            
        }


        function setPermission(id) {

            let value = [];

            if ($(`#read-${id}`).prop("checked")) {
                value.push("read");
            }

            if ($(`#update-${id}`).prop("checked")) {
                value.push("update");
            }

            if ($(`#delete-${id}`).prop("checked")) {
                value.push("delete");
            }

            if ($(`#insert-${id}`).prop("checked")) {
                value.push("insert");
            }

            let data = {
                role: parseInt(@json(request()->role)),
                permission: id,
                acao: value
            };

            $.ajax({
                url: "{{ route('configuracao.setPermission') }}",
                type: "POST",
                data: data,
                dataType: "json",
                success: function(response) {}
            });

        }

        function checkAll(id) {
            let value = $(`#all-${id}`).prop("checked");

            $(`#read-${id}`).prop('checked', value);
            $(`#update-${id}`).prop('checked', value);
            $(`#delete-${id}`).prop('checked', value);
            $(`#insert-${id}`).prop('checked', value);
        }

        function permissionFormatter(value, row, index) {

            return `<div class="container d-inline-flex justify-content-between">
            <div class="px-2 align-items-center d-flex">
                <span class="p-2">Visualizar</span>
                <label class="switch m-0">
                <input id="read-${row.id}" onClick="setPermission(${row.id})" ${row.read ? 'checked' : ''} type="checkbox">
                <span class="slider round"></span>
                </label>
            </div>
            <div class="x-2 align-items-center d-flex">
                <span class="p-2">editar</span>
                <label class="switch m-0">
                <input id="update-${row.id}" onClick="setPermission(${row.id})" ${row.update ? 'checked' : ''} type="checkbox">
                <span class="slider round"></span>
                </label>
            </div>
            <div class="x-2 align-items-center d-flex">
                <span class="p-2">Apagar</span>
                <label class="switch m-0">
                <input id="delete-${row.id}" onClick="setPermission(${row.id})" ${row.delete ? 'checked' : ''} type="checkbox">
                <span class="slider round"></span>
                </label>
            </div>
            <div class="x-2 align-items-center d-flex">
                <span class="p-2">Inserir</span>
                <label class="switch m-0">
                <input id="insert-${row.id}" onClick="setPermission(${row.id})" ${row.insert ? 'checked' : ''} type="checkbox">
                <span class="slider round"></span>
                </label>
            </div>
            <div class="x-2 align-items-center d-flex">
                <span class="p-2">Todos</span>
                <label class="switch m-0">
                <input id="all-${row.id}" onClick="checkAll(${row.id}), setPermission(${row.id})" ${(row.read && row.update && row.delete && row.insert) ? 'checked' : ''} type="checkbox">
                <span class="slider round"></span>
                </label>
            </div>
        </div>`;
        }
    </script>
@endpush

@push('css')
    <style>
        .selectpicker~button{
            border-radius: 0 0.25rem 0.25rem 0 !important;
            background-color: #e9ecef;
            border: 1px solid #ced4da;
            box-shadow: none !important;
        }

        /* The switch - the box around the slider */
        .switch {
            position: relative;
            display: inline-block;
            width: 60px;
            height: 34px;
        }
        .input-group{
            flex-wrap: initial;
        }
        /* Hide default HTML checkbox */
        .switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        /* The slider */
        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            -webkit-transition: .4s;
            transition: .4s;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 26px;
            width: 26px;
            left: 4px;
            bottom: 4px;
            background-color: white;
            -webkit-transition: .4s;
            transition: .4s;
        }

        input:checked+.slider {
            background-color: #28a745;
        }

        input:focus+.slider {
            box-shadow: 0 0 1px #28a745;
        }

        input:checked+.slider:before {
            -webkit-transform: translateX(26px);
            -ms-transform: translateX(26px);
            transform: translateX(26px);
        }

        /* Rounded sliders */
        .slider.round {
            border-radius: 34px;
        }

        .slider.round:before {
            border-radius: 50%;
        }
    </style>
@endpush
