<x-app-layout>
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>Motoristas</h1>
        <button class="btn text-white" style="background-color: #593E75;" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasDriver">
            + Adicionar motorista
        </button>
    </div>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr><th>Nome</th><th>CPF</th><th>Ações</th></tr>
                    </thead>
                    <tbody>
                        @forelse ($drivers as $driver)
                        <tr>
                            <td>{{ $driver->name }}</td>
                            <td>{{ $driver->cpf }}</td>
                            <td>
                                <button class="btn btn-sm btn-outline-primary me-1" 
                                        type="button" 
                                        data-bs-toggle="offcanvas" 
                                        data-bs-target="#offcanvasDriver"
                                        onclick="editDriver({{ $driver->id }}, '{{ $driver->name }}', '{{ $driver->cpf }}')">
                                    Editar
                                </button>
                                <form method="POST" action="{{ route('drivers.destroy', $driver) }}" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="btn btn-sm btn-outline-danger"
                                            onclick="return confirm('Tem a certeza que deseja excluir este motorista?')">
                                        Excluir
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="text-center">Nenhum motorista cadastrado.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Offcanvas para Adicionar/Editar -->
    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasDriver">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="offcanvasDriverTitle">Adicionar Novo Motorista</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
        </div>
        <div class="offcanvas-body scrollable-area">
            <form id="driverForm" action="{{ route('drivers.store') }}" method="POST">
                @csrf
                <input type="hidden" id="driverMethod" name="_method" value="">
                <input type="hidden" id="driverId" name="driver_id" value="">
                
                <div class="form-fields-container">
                    <div class="mb-3">
                        <label for="name" class="form-label">Nome Completo</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" 
                               id="name" name="name" value="{{ old('name') }}" required>
                        @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-3">
                        <label for="cpf" class="form-label">CPF</label>
                        <input type="text" class="form-control @error('cpf') is-invalid @enderror" 
                               id="cpf" name="cpf" value="{{ old('cpf') }}" required>
                        @error('cpf')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
                
                <div class="form-buttons-container">
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn text-white" style="background-color: #593E75;">
                            Salvar
                        </button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="offcanvas">
                            Cancelar
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        function editDriver(id, name, cpf) {
            // Mudar título e ação do formulário
            document.getElementById('offcanvasDriverTitle').textContent = 'Editar Motorista';
            document.getElementById('driverForm').action = `/drivers/${id}`;
            document.getElementById('driverMethod').value = 'PUT';
            document.getElementById('driverId').value = id;
            
            // Preencher campos
            document.getElementById('name').value = name;
            document.getElementById('cpf').value = cpf;
        }

        // Reset form when adding new driver
        document.querySelector('[data-bs-target="#offcanvasDriver"]').addEventListener('click', function() {
            if (!this.onclick) { // Se não tem função onclick (botão adicionar)
                document.getElementById('offcanvasDriverTitle').textContent = 'Adicionar Novo Motorista';
                document.getElementById('driverForm').action = '{{ route('drivers.store') }}';
                document.getElementById('driverMethod').value = '';
                document.getElementById('driverId').value = '';
                document.getElementById('name').value = '';
                document.getElementById('cpf').value = '';
            }
        });
    </script>
</x-app-layout>