{{-- resources/views/layouts/navigation.blade.php --}}
<nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom py-3">
    <div class="container-fluid">
        {{-- Botões de Ação --}}
        <div>
            <button class="btn fw-bold" style="background-color: #4A1D7B; color: white;">+ Adicionar usuário</button>
            <button class="btn btn-outline-secondary ms-2">Filtrar</button>
        </div>

        <div class="d-flex align-items-center ms-auto">
            {{-- Formulário de Pesquisa --}}
            <form class="d-flex" role="search">
                <div class="input-group">
                    <input class="form-control" type="search" placeholder="Pesquisar usuário" aria-label="Search">
                    <button class="btn btn-outline-secondary" type="submit"><i class="bi bi-search"></i></button>
                </div>
            </form>

            {{-- Ícone de Notificações com ponto vermelho --}}
            <ul class="navbar-nav ms-4">
                <li class="nav-item">
                    <a class="nav-link position-relative" href="#">
                        <i class="bi bi-bell fs-5"></i>
                        <span class="position-absolute top-0 start-100 translate-middle p-1 bg-danger border border-light rounded-circle">
                            <span class="visually-hidden">New alerts</span>
                        </span>
                    </a>
                </li>
            </ul>

            {{-- Dropdown do Utilizador --}}
            <div class="dropdown ms-4">
                <a href="#" class="d-flex align-items-center text-dark text-decoration-none dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="https://i.pravatar.cc/40?u={{ auth()->user()->id }}" alt="" width="40" height="40" class="rounded-circle">
                    <div class="ms-2 text-start">
                        <div class="fw-bold">{{ auth()->user()->name }}</div>
                        <div class="text-muted" style="font-size: 0.8rem;">Administrador</div>
                    </div>
                </a>
                <ul class="dropdown-menu dropdown-menu-end text-small shadow">
                    <li>
                        <a class="dropdown-item d-flex align-items-center" href="#">
                            <i class="bi bi-people me-2"></i> Usuários
                        </a>
                    </li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <a class="dropdown-item d-flex align-items-center" href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();">
                                <i class="bi bi-box-arrow-right me-2"></i> Sair
                            </a>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav>
