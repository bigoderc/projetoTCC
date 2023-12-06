@extends('layouts.pages.dashboard')

@section('content-page')
    <div class="content-page">
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="card teste-padding">
            <div class="card-header card-title text-white bg-transparent border-0 m-3">
                <span class="h4">MEU PERFIL</span>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3">
                        <div class="card h-100">
                            <div class="card-header rounded-0 text-center">
                                <span lass="fs-5 title">Perfil</span>
                            </div>
                            <div class="card-body">
                                <div class="h-100 d-flex flex-column justify-content-center align-items-center">
                                    @if (strlen(auth()->user()->foto_perfil))
                                        <div class="d-flex overflow-hidden rounded-circle mx-auto avatar">
                                            <img class="img-fluid my-auto"
                                                src="{{ url('storage/fotoPerfil/' . auth()->user()->foto_perfil) }}"
                                                alt="imagem de usuário">
                                        </div>                                        
                                    @else
                                        <i class="fa fa-user-circle avatar"></i>
                                    @endif
                                    <a class="d-flex flex-column justify-content-center text-decoration-none mt-3" type="button">
                                        <span class="fs-3 text-center">{{ auth()->user()->name }}</span>
                                        <span class="fs-6 text-center">{{ auth()->user()->email }}</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--1 pr-->
                    <div class="col-md-9">
                        <form class="w-100 mb-3" action="{{ route('profile.update', Auth::user()->id) }}" method="POST"
                            enctype='multipart/form-data'>
                            @csrf
                            @method('PUT')
                            <div class="card rounded shadow-none">
                                <div class="card-header rounded-0">
                                    <span lass="fs-5 title"> {{ __('Editar Perfil') }}</span>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <label class="col-md-3 col-form-label">{{ __('Nome') }}</label>
                                        <div class="col-md-9">
                                            <div class="form-group">
                                                <input type="text" class="form-control" name="name" id="nome"
                                                    value="{{ Auth::user()->name }}" aria-describedby="nome">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <label class="col-md-3 col-form-label">{{ __('Email') }}</label>
                                        <div class="col-md-9">
                                            <div class="form-group">
                                                <input type="email" class="form-control" name="email"
                                                    value="{{ Auth::user()->email }}" id="email"
                                                    aria-describedby="email">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <label class="col-md-3 col-form-label">{{ _('Anexar img. do perfil') }}</label>
                                        <div class="col-md-9">
                                            <div class="input-group mb-3">
                                                <input type="file" class="custom-file-input p-4 bs-custom-file-input"
                                                    accept=".png,.jpeg,.jpg,.svg" name="arquivo" id="fotoPerfil">
                                                <label class="custom-file-label text" data-browse="Upload" for="fotoPerfil">Arquivo 300x200, .png .jpeg .jpg ou .svg</label>
                                            </div>
                                        </div>

                                    </div>

                                </div>
                                <div class="card-footer">
                                    <div class="row">
                                        <div class="col-md-12 text-center">
                                            <button type="submit"
                                                class="btn btn-primary btn-round">{{ __('Salvar Alterações') }}</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <form class="w-100 mb-3" action="{{ route('profile.passwordRequest', Auth::user()->id) }}"
                            method="POST" enctype='multipart/form-data'>
                            @csrf
                            @method('PUT')
                            <div class="card rounded shadow-none">
                                <div class="card-header rounded-0">
                                    <span class="fs-5 title">{{ __('Alterar Senha') }}</span>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <label class="col-md-3 col-form-label">{{ __('Senha Atual') }}</label>
                                        <div class="col-md-9">
                                            <div class="form-group">
                                                <input required="required" type="password" name="old_password"
                                                    id="senhaatual"
                                                    class="form-control password-control {{ $errors->has('old_password') ? 'is-invalid' : '' }}" />
                                            </div>
                                            @if ($errors->has('old_password'))
                                                <span class="invalid-feedback" style="display: block;" role="alert">
                                                    <strong>{{ $errors->first('old_password') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="row">
                                        <label class="col-md-3 col-form-label">{{ __('Nova Senha') }}</label>
                                        <div class="col-md-9">
                                            <div class="form-group">
                                               
                                                <input required="required" type="password" name="password"
                                                    id="senhanova"
                                                    class="form-control password-control {{ $errors->has('password') ? 'is-invalid' : '' }}" />
                                            </div>
                                            @if ($errors->has('password'))
                                                <span class="invalid-feedback" style="display: block;" role="alert">
                                                    <strong>{{ $errors->first('password') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="row">
                                        <label class="col-md-3 col-form-label">{{ __('Confirmar Nova Senha') }}</label>
                                        <div class="col-md-9">
                                            <div class="input-group">
                                                
                                                <input required="required" type="password" name="password_confirmation"
                                                    id="senhanovaConf"
                                                    class="form-control password-control {{ $errors->has('password_confirmation') ? 'is-invalid' : '' }}" />
                                            </div>

                                            @if ($errors->has('password_confirmation'))
                                                <span class="invalid-feedback" style="display: block;" role="alert">
                                                    <strong>{{ $errors->first('password_confirmation') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer ">
                                    <div class="row">
                                        <div class="col-md-12 text-center">
                                            <button type="submit"
                                                class="btn btn-primary btn-round"">{{ __('Salvar Alterações') }}</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            // Atualiza o texto do rótulo com o nome do arquivo selecionado
            $('.custom-file-input').on('change', function() {
                var fileName = $(this).val().split('\\').pop();
                $(this).next('.custom-file-label').addClass('selected').html(fileName);
            });
        });
        $('#icon_password1').click(function(e) {
            e.preventDefault();
            if ($('#senhaatual').attr('type') == 'password') {
                $('#senhaatual').attr('type', 'text');
                $('#icon_password1').attr('class', 'fa fa-eye');
            } else {
                $('#senhaatual').attr('type', 'password');
                $('#icon_password1').attr('class', 'fa fa-eye-slash');
            }
        });

        $('#icon_password2').click(function(e) {
            e.preventDefault();
            if ($('#senhanova').attr('type') == 'password') {
                $('#senhanova').attr('type', 'text');
                $('#icon_password2').attr('class', 'fa fa-eye');
            } else {
                $('#senhanova').attr('type', 'password');
                $('#icon_password2').attr('class', 'fa fa-eye-slash');
            }
        });
        $('#icon_password3').click(function(e) {
            e.preventDefault();
            if ($('#senhanovaConf').attr('type') == 'password') {
                $('#senhanovaConf').attr('type', 'text');
                $('#icon_password3').attr('class', 'fa fa-eye');
            } else {
                $('#senhanovaConf').attr('type', 'password');
                $('#icon_password3').attr('class', 'fa fa-eye-slash');
            }
        });
    </script>
@endpush

@push('css')
<style>
    .avatar {
        width: 125px;
        height: 125px;
        font-size: 125px !important;
    }

    .avatar>img {
        transform: scale(1.9);   
    }
</style>
@endpush
