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

    @if(request('search'))
        <div class="alert alert-info d-flex align-items-center mb-3" role="alert">
            <i class="bi bi-search me-2"></i>
            <div>
                Mostrando resultados para: <strong>"{{ request('search') }}"</strong>
                <a href="{{ route('users.index') }}" class="btn btn-sm btn-outline-secondary ms-2">
                    <i class="bi bi-x"></i> Limpar pesquisa
                </a>
            </div>
        </div>
    @endif

    <table class="table table-hover align-middle bg-white w-100" style="margin: 0;">
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
                        <button class="btn btn-sm btn-light border-0" type="button" data-bs-toggle="dropdown" aria-expanded="false" style="background: transparent; color: #718096;">
                            <i class="bi bi-three-dots" style="font-size: 16px;"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end" style="border: none; border-radius: 0; padding: 0.75rem; min-width: 200px; background: transparent; box-shadow: none;">
                            <li style="margin-bottom: 0.5rem;">
                                <a class="dropdown-item d-flex align-items-center" href="#" onclick="editUser({{ $user->id }}, '{{ $user->name }}', '{{ $user->email }}')" 
                                   style="padding: 0.875rem 1rem; font-size: 14px; color: #2d3748; border-radius: 8px; background: #ffffff; border: 1px solid #f0f0f0; transition: all 0.2s; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                                    <i class="bi bi-pencil me-3" style="font-size: 14px; color: #718096;"></i>
                                    Editar usuário
                                </a>
                            </li>
                            
                            <li style="margin-bottom: 0.5rem;">
                                <a class="dropdown-item d-flex align-items-center" href="#" 
                                   style="padding: 0.875rem 1rem; font-size: 14px; color: #2d3748; border-radius: 8px; background: #ffffff; border: 1px solid #f0f0f0; transition: all 0.2s; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                                    <i class="bi bi-slash-circle me-3" style="font-size: 14px; color: #718096;"></i>
                                    Bloquear usuário
                                </a>
                            </li>
                            
                            <li>
                                <form action="{{ route('users.destroy', $user) }}" method="POST" onsubmit="return confirm('Tem a certeza que deseja excluir este utilizador?');" class="m-0">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="dropdown-item d-flex align-items-center w-100 border-0 bg-transparent text-start" 
                                            style="padding: 0.875rem 1rem; font-size: 14px; color: #e53e3e; border-radius: 8px; background: #ffffff; border: 1px solid #f0f0f0; transition: all 0.2s; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                                        <i class="bi bi-trash me-3" style="font-size: 14px; color: #e53e3e;"></i>
                                        Deletar usuário
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="3" class="text-center text-muted py-4">
                    @if(request('search'))
                        <i class="bi bi-search me-2"></i>
                        Nenhum usuário encontrado para "{{ request('search') }}".
                        <br>
                        <a href="{{ route('users.index') }}" class="btn btn-sm btn-outline-primary mt-2">
                            Ver todos os usuários
                        </a>
                    @else
                        <i class="bi bi-people me-2"></i>
                        Nenhum utilizador cadastrado.
                    @endif
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasUser" aria-labelledby="offcanvasUserLabel" style="width: 400px;">
        <div class="offcanvas-header border-bottom d-flex justify-content-between align-items-center" style="padding: 1.5rem;">
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close" style="margin: 0; padding: 0; width: 32px; height: 32px;"></button>
            <h5 class="offcanvas-title fw-semibold text-center flex-grow-1 m-0" id="offcanvasUserLabel" style="color: #2d3748;">Usuário</h5>
            <button type="button" class="btn btn-sm btn-outline-secondary p-1" style="width: 32px; height: 32px;">
                <i class="bi bi-trash" style="font-size: 14px;"></i>
            </button>
        </div>
        <div class="offcanvas-body" style="padding: 2rem 1.5rem;">
            <form action="{{ route('users.store') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="name" class="form-label" style="color: #718096; font-size: 14px; margin-bottom: 0.5rem;">Nome completo:</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required 
                           style="border: 1px solid #e2e8f0; border-radius: 8px; padding: 0.75rem; font-size: 14px;" 
                           placeholder="Digite o nome completo">
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="email" class="form-label" style="color: #718096; font-size: 14px; margin-bottom: 0.5rem;">E-mail:</label>
                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required 
                           style="border: 1px solid #e2e8f0; border-radius: 8px; padding: 0.75rem; font-size: 14px;" 
                           placeholder="Digite o e-mail">
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="password" class="form-label" style="color: #718096; font-size: 14px; margin-bottom: 0.5rem;">Senha provisória:</label>
                    <input type="password" class="form-control" id="password" name="password" value="••••••••••" readonly 
                           style="border: 1px solid #e2e8f0; border-radius: 8px; padding: 0.75rem; font-size: 14px; background-color: #f7fafc;">
                    <small class="text-muted" style="font-size: 12px; color: #a0aec0;">Uma senha temporária será gerada automaticamente</small>
                </div>
                
                <!-- Espaço flexível para empurrar os botões para o final -->
                <div style="flex-grow: 1;"></div>
                
                <!-- Botões no final do modal -->
                <div class="d-grid gap-2" style="margin-top: auto; padding-top: 2rem;">
                    <button type="submit" class="btn text-white fw-semibold" style="background-color: #593E75; border: none; border-radius: 8px; padding: 0.875rem; font-size: 14px;">
                        Finalizar cadastro
                    </button>
                    <button type="button" class="btn btn-outline-secondary fw-semibold" data-bs-dismiss="offcanvas" 
                            style="border: 1px solid #e2e8f0; border-radius: 8px; padding: 0.875rem; font-size: 14px; color: #4a5568;">
                        Cancelar
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasEditUser" aria-labelledby="offcanvasEditUserLabel" style="width: 400px;">
        <div class="offcanvas-header border-bottom d-flex justify-content-between align-items-center" style="padding: 1.5rem;">
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close" style="margin: 0; padding: 0; width: 32px; height: 32px;"></button>
            <h5 class="offcanvas-title fw-semibold text-center flex-grow-1 m-0" id="offcanvasEditUserLabel" style="color: #2d3748;">Usuário</h5>
            <button type="button" class="btn btn-sm btn-outline-secondary p-1" style="width: 32px; height: 32px;">
                <i class="bi bi-trash" style="font-size: 14px;"></i>
            </button>
        </div>
        <div class="offcanvas-body" style="padding: 2rem 1.5rem;">
            <form id="editUserForm" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-4">
                    <label for="edit_name" class="form-label" style="color: #718096; font-size: 14px; margin-bottom: 0.5rem;">Nome completo:</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="edit_name" name="name" required 
                           style="border: 1px solid #e2e8f0; border-radius: 8px; padding: 0.75rem; font-size: 14px;" 
                           placeholder="Digite o nome completo">
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="edit_email" class="form-label" style="color: #718096; font-size: 14px; margin-bottom: 0.5rem;">E-mail:</label>
                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="edit_email" name="email" required 
                           style="border: 1px solid #e2e8f0; border-radius: 8px; padding: 0.75rem; font-size: 14px;" 
                           placeholder="Digite o e-mail">
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="edit_password" class="form-label" style="color: #718096; font-size: 14px; margin-bottom: 0.5rem;">Nova senha (opcional):</label>
                    <input type="password" class="form-control @error('password') is-invalid @enderror" id="edit_password" name="password" 
                           style="border: 1px solid #e2e8f0; border-radius: 8px; padding: 0.75rem; font-size: 14px;" 
                           placeholder="Digite a nova senha">
                    <small class="text-muted" style="font-size: 12px; color: #a0aec0;">Deixe em branco para manter a senha atual</small>
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <!-- Espaço flexível para empurrar os botões para o final -->
                <div style="flex-grow: 1;"></div>
                
                <!-- Botões no final do modal -->
                <div class="d-grid gap-2" style="margin-top: auto; padding-top: 2rem;">
                    <button type="submit" class="btn text-white fw-semibold" style="background-color: #593E75; border: none; border-radius: 8px; padding: 0.875rem; font-size: 14px;">
                        Atualizar usuário
                    </button>
                    <button type="button" class="btn btn-outline-secondary fw-semibold" data-bs-dismiss="offcanvas" 
                            style="border: 1px solid #e2e8f0; border-radius: 8px; padding: 0.875rem; font-size: 14px; color: #4a5568;">
                        Cancelar
                    </button>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
    <style>
        /* Estilos para os modais seguirem o design do Figma */
        #offcanvasUser .offcanvas-body,
        #offcanvasEditUser .offcanvas-body {
            display: flex;
            flex-direction: column;
            height: calc(100vh - 100px);
        }
        
        #offcanvasUser .offcanvas-body form,
        #offcanvasEditUser .offcanvas-body form {
            display: flex;
            flex-direction: column;
            height: 100%;
        }
        
        /* Hover effect para os inputs */
        #offcanvasUser .form-control:focus,
        #offcanvasEditUser .form-control:focus {
            border-color: #593E75;
            box-shadow: 0 0 0 0.2rem rgba(89, 62, 117, 0.25);
        }
        
        /* Estilo para o botão de lixeira */
        #offcanvasUser .btn-outline-secondary:hover,
        #offcanvasEditUser .btn-outline-secondary:hover {
            background-color: #f8f9fa;
            border-color: #dee2e6;
        }
        
        /* Estilo para os botões principais */
        #offcanvasUser .btn:hover[style*="background-color: #593E75"],
        #offcanvasEditUser .btn:hover[style*="background-color: #593E75"] {
            background-color: #4a3260 !important;
        }
        
        /* Estilos para o dropdown menu como botões independentes */
        .dropdown-menu .dropdown-item {
            border: 1px solid #f0f0f0 !important;
            border-radius: 8px !important;
            background: #ffffff !important;
            margin-bottom: 0.5rem;
            transition: all 0.2s ease;
        }
        
        .dropdown-menu .dropdown-item:hover {
            background-color: #f8f9fa !important;
            border-color: #e2e8f0 !important;
            color: #2d3748 !important;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            transform: translateY(-1px);
        }
        
        .dropdown-menu .dropdown-item:hover i {
            color: #593E75 !important;
        }
        
        /* Hover especial para o item de deletar */
        .dropdown-menu .dropdown-item[style*="color: #e53e3e"]:hover {
            background-color: #fef2f2 !important;
            border-color: #fecaca !important;
            color: #e53e3e !important;
        }
        
        .dropdown-menu .dropdown-item[style*="color: #e53e3e"]:hover i {
            color: #e53e3e !important;
        }
        
        /* Remove margin do último item */
        .dropdown-menu li:last-child {
            margin-bottom: 0 !important;
        }
        
        .dropdown-menu li:last-child .dropdown-item {
            margin-bottom: 0 !important;
        }
        
        /* Estilo para o botão de três pontos */
        .dropdown-toggle:hover {
            background-color: #f8f9fa !important;
            color: #593E75 !important;
        }
    </style>
    
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
