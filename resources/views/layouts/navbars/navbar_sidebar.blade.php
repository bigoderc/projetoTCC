<div class="position-absolute bg-primary extended sidebar p-2" style="
    z-index: 1;">
    <div class="d-flex justify-content-center align-items-center text-white my-3">
        <div class="img" >
			<span class="h2">GRC</span>
      	</div>
      
    </div>

    <div>
        <ul class="nav flex-column">
            <li class="bg-gold border-gold rounded my-1 overflow-hidden">
                <div class="d-flex justify-content-center">
                    <a class="text-decoration-none text-nowrap text-white" href="{{ route('home') }}">
                        <i class="px-2 fa fa-solid fa-home fa-lg"></i>
                        <span class="d-none">{{ ('Inicio') }}</span>
                    </a>
                </div>
            </li>

            @if(Gate::check('usuario') || Gate::check('professor') || Gate::check('aluno') || Gate::check('areas')|| Gate::check('tema')||Gate::check('projeto')||Gate::check('curso'))
            <li class="bg-gold border-gold rounded my-1 overflow-hidden">
                <div class="d-flex justify-content-center" role="button">
                    <a class="text-decoration-none text-nowrap text-white" href="#">
                        <i class="lg nc-icon nc-single-copy-04 px-2"></i>
                        <span class="d-none">Cadastro</span>

                    </a>
                </div>
                <ul class="list-group text-left d-none">
                    @can('curso')
                        <li class="list-group-item bg-white py-1">
                            <a class="text-decoration-none text-dark" href="{{ route('curso.index') }}">
                                <span>{{ ('Curso') }}</span>
                            </a>
                        </li>
                    @endcan
                    @can('turma')
                        <li class="list-group-item bg-white py-1">
                            <a class="text-decoration-none text-dark" href="{{ route('turma.index') }}">
                                <span>{{ ('Turma') }}</span>
                            </a>
                        </li>
                    @endcan
                    @can('area')
                        <li class="list-group-item bg-white py-1">
                            <a class="text-decoration-none text-dark" href="{{ route('area.index') }}">
                                <span>{{ ('Área') }}</span>
                            </a>
                        </li>
                    @endcan
                    
                    @can('especialidade')
                        <li class="list-group-item bg-white py-1">
                            <a class="text-decoration-none text-dark" href="{{ route('especialidade.index') }}">
                                <span>{{ ('Especialidade') }}</span>
                            </a>
                        </li>
                    @endcan
                    @can('grau')
                        <li class="list-group-item bg-white py-1">
                            <a class="text-decoration-none text-dark" href="{{ route('grau.index') }}">
                                <span>{{ ('Grau') }}</span>
                            </a>
                        </li>
                    @endcan
                    @can('aluno')
                        <li class="list-group-item bg-white py-1">
                            <a class="text-decoration-none text-dark" href="{{ route('discente.index') }}">
                                <span>{{ ('Discente') }}</span>

                            </a>
                        </li>
                    @endcan
                    
                    @can('professor')
                        <li class="list-group-item bg-white py-1">
                            <a class="text-decoration-none text-dark" href="{{ route('professor.index') }}">
                                <span>{{ ('Professor') }}</span>
                            </a>
                        </li>
                    @endcan
                    @can('tema')
                        <li class="list-group-item bg-white py-1">
                            <a class="text-decoration-none text-dark" href="{{ route('proposta-tema.index') }}">
                                <span>{{ ('Proposta de Tema') }}</span>
                            </a>
                        </li>
                    @endcan
                    @can('pre-tcc')
                    <li class="list-group-item bg-white py-1">
                        <a class="text-decoration-none text-dark" href="{{ route('pre-tcc.index')}}">
                            <span>{{('Pré-TCC')}}</span>
                        </a>
                    </li>
                    @endcan
                    @can('tcc')
                    <li class="list-group-item bg-white py-1">
                        <a class="text-decoration-none text-dark" href="{{ route('tcc.index')}}">
                            <span>{{('TCC')}}</span>
                        </a>
                    </li>
                    @endcan                   
                    @can('usuario')
                        <li class="list-group-item bg-white py-1">
                            <a class="text-decoration-none text-dark" href="{{ route('user.index') }}">
                                <span>{{ ('Usuário') }}</span>
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>
            @endif
            
            @can('configuracoes')
            <li class="bg-gold border-gold rounded my-1 overflow-hidden">
                <div class="d-flex justify-content-center">
                    <a class="text-decoration-none text-nowrap text-white" href="{{ route('configuracoes.index') }}">
                        <i class="px-2 fa fa-solid fa-lg fa-cog"></i>
                        <span class="d-none">{{ ('Configuração') }}</span>
                    </a>
                </div>
            </li>
            @endcan
            <li class="bg-gold border-gold rounded my-1 overflow-hidden">
                <div class="d-flex justify-content-center">
                    <a class="text-decoration-none text-nowrap text-white" href="{{ route('profile.index') }}">
                        <i class="px-2 fa fa-solid fa-lg fa-user"></i>
                        <span class="d-none">{{ 'Perfil' }}</span>
                    </a>
                </div>
            </li>
            <li class="bg-gold border-gold rounded my-1 overflow-hidden">
                <div class="d-flex justify-content-center">
                    <a class="text-decoration-none text-nowrap text-white" href="{{ route('login') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="px-2 fa fa-solid fa-lg fa-sign-out"></i>
                        <span class="d-none">{{ ('Sair') }}</span>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
                    </a>
                </div>
            </li>
        </ul>
    </div>

    <div class="bg-gold fixed-bottom position-absolute">
        <div class="d-flex justify-content-center text-white  text-nowrap py-2">
            <div class="user d-none ">
                <div class="d-flex align-items-center user">
                    <i class="fa fa-solid fa-user mr-2"></i>
                    <div class="name">{{ Auth::user()->name }}</div>
                    <div class="job">{{ Auth::user()->funcao }}</div>
                </div>
            </div>
            <div class="version">
                <div class="d-flex align-items-center version">
                    <i>v1.0.6</i>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- <div class="position-absolute sidebar-btn p-3">
    <div role="button">
        <i class="fa fa-solid fa-bars fa-lg"></i>
    </div>
</div> --}}

@push('css')
    <style>
        #navbar {
            height: calc(100vh - 66px - 40px - 1rem);
            overflow: auto;

            -ms-overflow-style: none;
            /* Internet Explorer 10+ */
            scrollbar-width: none;
            /* Firefox */
        }

        #navbar::-webkit-scrollbar {
            display: none;
            /* Safari and Chrome */
        }

        .rounded {
            border-radius: 0.375rem !important;
        }
    </style>
@endpush

@push('scripts')
    <script>
        let $sidebar = $(".sidebar");
        let $button = $(".sidebar > div > ul > li");
        let $buttonDiv = $(".sidebar > div > ul > li > div");
        let $buttonSpan = $(".sidebar > div > ul > li > div > a > span");
        let $dropdown = $(".sidebar > div > ul > li > ul");

        function hide(element) {
            element.addClass("d-none");

        }

        function show(element) {
            element.removeClass("d-none");
        }

        function open() {
            $sidebar.addClass("extended");

            $buttonDiv.removeClass("justify-content-center");
            show($buttonSpan);
            $dropdown.prev().children("a").addClass("dropdown-toggle")

            show($(".proj-name"));
            show($(".user"));
            hide($(".version"));
        }
        $(document).ready(function() {
            open();
            $button.on("click", function() {

                var $thisDropdown = $(this).children("ul");

                if ($thisDropdown.css('display') == "none") {
                    hide($dropdown);
                    show($thisDropdown);
                } else {
                    hide($thisDropdown);
                }
            });
        });
    </script>
@endpush
