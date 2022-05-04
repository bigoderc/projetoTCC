<div class="sidebar bg-primary">
    <div class="logo-details">
        <h1 class="logo_name text-white">{{ 'GRC' }}</h1>
        <i class="fas fa-align-justify" id="btn" ></i>
    </div>
    <ul class="nav-list">
        <li>
            <a href="{{ route('painel') }}">
                <i class="fas fa-home"></i>
                <span class="links_name">{{ ('Inicio') }}</span>
            </a>
            <span class="tooltip">{{ ('Inicio') }}</span>
        </li>
        @can('usuario')
            <li >
                <a   href="{{ route('users.index') }}">
                    <i class="fas fa-user-plus"></i>
                    <span class="links_name" >{{('Usuário') }}</span>
                </a>  
                <span class="tooltip" >{{('Usuário') }}</span>    
            </li>
        @endcan
        @can('aluno')
            <li >
                <a href="{{ route('alunos.index') }}">
                <i class="fas fa-user"></i>
                    <span class="links_name" >{{('Aluno') }}</span>
                </a>
                <span class="tooltip" >{{('Aluno') }}</span>      
            </li>
        @endcan
        @can('professor')
            <li >
                <a href="{{ route('professores.index') }}">
                <i class="fab fa-product-hunt"></i>
                    <span class="links_name" >{{('Professor') }}</span>
                </a> 
                <span class="tooltip" >{{('Professor') }}</span>     
            </li>
        @endcan
        @can('areas')
            <li >
                <a  href="{{ route('areas.index') }}">
                <i class="fa fa-list-alt"></i>
                    <span class="links_name" >{{('Áreas') }}</span>
                </a> 
                <span class="tooltip" >{{('Áreas') }}</span>     
            </li>
        @endcan
        @can('tema')
            <li >
                <a  href="{{ route('temas.index') }}">
                <i class="fa fa-list-alt"></i>
                    <span class="links_name" >{{('Temas') }}</span>
                </a>
                <span class="tooltip" >{{('Temas') }}</span>      
            </li>
        @endcan
        @can('projeto')
            <li >
                <a  href="{{ route('projetos.index') }}">
                <i class="fa fa-list-alt"></i>
                    <span class="links_name" >{{('Projetos') }}</span>
                </a>
                <span class="tooltip" >{{('Projetos') }}</span>      
            </li>
        @endcan
        @can('configuracoes')
            <li>
                <a href="{{ route('configuracoes.index') }}">
                    <i class="fas fa-cog"></i>
                    <span class="links_name">{{ ('Configurações') }}</span>
                </a>
                <span class="tooltip">{{ ('Configurações') }}</span>
            </li>
        @endcan
        <li>
            <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="text-center">
                <i class="fas fa-sign-out-alt"></i>
                <span class="links_name">{{ ('Sair') }}</span>
                
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </a>
            <span class="tooltip">{{ ('Sair') }}</span>
        </li>
          
        <li class="profile">
            <div class="profile-details">
                <i class="fas fa-user"></i>
            <div class="name_job">
                <div class="name">{{ Auth::user()->name }}</div>
                <div class="job">Administrador</div>
            </div>
            </div>
            <i class='bx bx-log-out' id="log_out" >V1.0.1</i>
        </li>
    </ul>
</div>
  