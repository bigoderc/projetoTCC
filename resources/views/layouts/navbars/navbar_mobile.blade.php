<nav class="navbar navbar-dark bg-primary shadow-sm sidebar-mobile">
    <div class="container">
        <a class="navbar-brand disabled" href="{{ url('/') }}">
            {{ config('app.name', 'Nome_Generico') }}
        </a>

        <div class="dropdown">
            <a id="navbarDropdown" class="nav-link dropdown-toggle text-white" href="#" role="button" aria-haspopup="true" aria-expanded="false" onclick="toggleDropdown('profileDropdown')">
                {{ Auth::user()->name }}
            </a>

            <div id="profileDropdown" class="dropdown-menu dropdown-menu-right mt-3" style="display: none;">
                <a class="dropdown-item" href="{{ route('home') }}">
                    <i class="px-2 fa fa-solid fa-home fa-lg"></i>{{ __('Painel') }}
                </a>
                <a class="dropdown-item" href="{{ route('profile.index') }}">
                    <i class="px-2 fa fa-solid fa-lg fa-user"></i>{{ __('Perfil') }}
                </a>
                @if(Gate::check('read-usuario') || 
                Gate::check('read-professor') || 
                Gate::check('read-discente') || 
                Gate::check('read-area')|| 
                Gate::check('read-proposta_tema')||
                Gate::check('read-tcc')||
                Gate::check('read-pre_tcc')||
                Gate::check('read-turma')||
                Gate::check('read-especialidade')||
                Gate::check('read-grau')||
                Gate::check('read-curso'))
                    <div class="dropdown">
                        <a class="dropdown-item dropdown-toggle" href="#" id="cadastroDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="lg nc-icon nc-single-copy-04 px-2"></i>{{ __('Cadastro') }}
                        </a>
                        <div class="dropdown-menu" aria-labelledby="cadastroDropdown">
                            @can('read-curso')
                                <a class="dropdown-item" href="{{ route('curso.index') }}">
                                    {{ __('Curso') }}
                                </a>
                            @endcan
                            @can('read-turma')
                                <a class="dropdown-item" href="{{ route('turma.index') }}">
                                    {{ __('Turma') }}
                                </a>
                            @endcan
                            @can('read-area')
                                <a class="dropdown-item" href="{{ route('linha-pesquisa.index') }}">
                                    {{ __('Área') }}
                                </a>
                            @endcan

                            @can('read-especialidade')
                                <a class="dropdown-item" href="{{ route('area.index') }}">
                                    {{ __('Especialidade') }}
                                </a>
                            @endcan
                            @can('read-grau')
                                <a class="dropdown-item" href="{{ route('grau.index') }}">
                                    {{ __('Grau') }}
                                </a>
                            @endcan
                            @can('read-discente')
                                <a class="dropdown-item" href="{{ route('discente.index') }}">
                                    {{ __('Discente') }}
                                </a>
                            
                            @endcan
                            
                            @can('read-professor')
                                <a class="dropdown-item" href="{{ route('docente.index') }}">
                                    {{ __('Docente') }}
                                </a>
                                
                            @endcan
                            @can('read-proposta_tema')
                                <a class="dropdown-item" href="{{ route('proposta-tema.index') }}">
                                    {{ __('Proposta de Tema') }}
                                </a>
                            @endcan
                            @can('read-pre_tcc')
                                <a class="dropdown-item" href="{{ route('pre-tcc.index') }}">
                                    {{ __('Pré-TCC') }}
                                </a>
                            @endcan
                            @can('read-tcc')
                                <a class="dropdown-item" href="{{ route('tcc.index') }}">
                                    {{ __('TCC') }}
                                </a>
                            @endcan  
                            @can('read-biblioteca')
                                <a class="dropdown-item" href="{{ route('biblioteca.index') }}">
                                    {{ __('Link Biblioteca') }}
                                </a>
                            @endcan                        
                            @can('read-usuario')
                                <a class="dropdown-item" href="{{ route('user.index') }}">
                                    {{ __('Usuário') }}
                                </a>
                                
                            @endcan
                        
                            <!-- Adicione mais opções conforme necessário -->
                        </div>
                    </div>
                @endif

                @can('read-configuracao')
                    <a class="dropdown-item" href="{{ route('configuracao.index') }}">
                        <i class="px-2 fa fa-solid fa-lg fa-cog"></i>{{ __('Configuração') }}
                    </a>
                @endcan

                <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="px-2 fa fa-solid fa-lg fa-sign-out"></i>{{ __('Sair') }}
                </a>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </div>
        </div>
    </div>

    <script>
        function toggleDropdown(dropdownId) {
            var dropdown = document.getElementById(dropdownId);
            if (dropdown.style.display === 'none' || dropdown.style.display === '') {
                dropdown.style.display = 'block';
            } else {
                dropdown.style.display = 'none';
            }
        }
    </script>
</nav>
