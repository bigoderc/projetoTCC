{{-- Navbar da tela de principal de produtos --}}
<nav class="navbar navbar-dark bg-primary shadow-sm sidebar-mobile">
    <div class="container">
        {{-- Titulo da navbar --}}
        <a class="navbar-brand disabled" href="{{ url('/') }}">
            {{-- Alterar titulo no app.name --}}
            {{ config('app.name', 'Nome_Generico') }}
        </a>

        {{-- Dropdown de menu da navbar --}}
        <ul class="nav">
            <li class="nav-item dropdown">
                <a id="navbarDropdown" class="nav-link dropdown-toggle text-white" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                    {{ Auth::user()->name }}
                </a>

                <div class="dropdown-menu dropdown-menu-right mt-3" aria-labelledby="navbarDropdown">
                    <ul class="nav flex-column text-left">
                        <li class="nav-item">
                            <a href="{{ route('home') }}" class="nav-link"><i class="px-2 fa fa-solid fa-home fa-lg"></i> {{ __('Painel') }}</a>
                        </li>
                        
                        @can('configuracoes')
                            <li class="nav-item ">
                                <a class="nav-link" href="{{ route('configuracoes.index') }}">
                                    <i class="px-2 fa fa-solid fa-lg fa-cog"></i>
                                    {{ __('Configuracão') }}
                                </a>
                            </li> 
                        @endcan
                        <li class="nav-item ">
                            <a class="nav-link" href="{{ route('profile.index') }}">
                                <i class="px-2 fa fa-solid fa-lg fa-user"></i>
                                {{ __('Perfil') }}
                            </a>
                        </li>
                        <li class="nav-item ">
                            <a class="nav-link" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="px-2 fa fa-solid fa-lg fa-sign-out"></i>
                                {{ __('Sair') }}
                            </a>
        
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </li>
                    </ul>
                </div>
            </li>
        </ul>
    </div>
</nav>
{{-- Fim da Navbar da tela de principal de produtos --}}