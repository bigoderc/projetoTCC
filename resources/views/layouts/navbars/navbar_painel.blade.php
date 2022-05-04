{{-- Navbar da tela de principal de produtos --}}
<nav class="navbar navbar-dark bg-primary shadow-sm">
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
                    <ul class="nav flex-column text-center">
                        <li class="nav-item ">
                            <a class="nav-link" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="fas fa-sign-out-alt"></i>
                                {{ __('Sair') }}
                            </a>
        
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('painel') }}" class="nav-link"><i class="fas fa-th"></i> {{ __('Painel') }}</a>
                        </li>
                    </ul>
                </div>
            </li>
        </ul>
    </div>
</nav>
{{-- Fim da Navbar da tela de principal de produtos --}}