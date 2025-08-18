<x-app-layout>
    @section('header-actions')
    <div>
        <button class="btn fw-bold" style="background-color: #593E75; color: white;" data-bs-toggle="offcanvas" data-bs-target="#offcanvasUser">
            <i class="bi bi-plus-lg"></i> Adicionar usuário
        </button>
        <button class="btn btn-light border ms-2">Filtrar</button>
    </div>
    @endsection

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <table class="table table-hover align-middle bg-white w-100">
        <thead>
            <tr class="table-light">
                <th scope="col" class="ps-4">Usuário</th>
                <th scope="col">E-mail</th>
                <th scope="col" class="text-end pe-4" style="width: 50px;"></th>
            </tr>
        </thead>
        <tbody>
            @forelse ($users as $user)
            <tr>
                <td class="ps-4">{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td class="text-end pe-4">
                    <div class="dropdown">
                        <button class="btn btn-sm btn-light" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            ⋯
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="#" onclick="editUser({{ $user->id }}, '{{ $user->name }}', '{{ $user->email }}')">
                                <i class="bi bi-pencil"></i> Editar
                            </a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form action="{{ route('users.destroy', $user) }}" method="POST" onsubmit="return confirm('Tem a certeza que deseja excluir este utilizador?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="dropdown-item text-danger">
                                        <i class="bi bi-trash"></i> Excluir
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="3" class="text-center text-muted py-4">Nenhum utilizador cadastrado.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasUser" aria-labelledby="offcanvasUserLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="offcanvasUserLabel">Adicionar Novo Usuário</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <form action="{{ route('users.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label">Nome Completo</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">E-mail</label>
                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required>
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <p class="text-muted small">Uma senha temporária segura será gerada. O utilizador será solicitado a alterá-la no primeiro login.</p>
                <button type="submit" class="btn w-100 text-white" style="background-color: #593E75;">Salvar Usuário</button>
            </form>
        </div>
    </div>

    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasEditUser" aria-labelledby="offcanvasEditUserLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="offcanvasEditUserLabel">Editar Usuário</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <form id="editUserForm" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label for="edit_name" class="form-label">Nome Completo</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="edit_name" name="name" required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="edit_email" class="form-label">E-mail</label>
                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="edit_email" name="email" required>
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="edit_password" class="form-label">Nova Senha (opcional)</label>
                    <input type="password" class="form-control @error('password') is-invalid @enderror" id="edit_password" name="password" placeholder="Deixe em branco para manter a senha atual">
                    <div class="form-text">Deixe em branco se não quiser alterar a senha</div>
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <button type="submit" class="btn w-100 text-white" style="background-color: #593E75;">Atualizar Usuário</button>
            </form>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            console.log('Bootstrap:', typeof bootstrap);
        });
        
        window.editUser = function(id, name, email) {
            try {
                document.getElementById('edit_name').value = name;
                document.getElementById('edit_email').value = email;
                document.getElementById('edit_password').value = '';
                
                document.getElementById('editUserForm').action = `/users/${id}`;
                
                const offcanvasElement = document.getElementById('offcanvasEditUser');
                if (offcanvasElement && typeof bootstrap !== 'undefined') {
                    const offcanvas = new bootstrap.Offcanvas(offcanvasElement);
                    offcanvas.show();
                } else {
                    console.error('Elemento offcanvas ou Bootstrap não encontrado');
                }
            } catch (error) {
                console.error('Erro na função editUser:', error);
            }
        };
    </script>
    @endpush
</x-app-layout>
