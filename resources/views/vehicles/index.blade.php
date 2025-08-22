<x-app-layout>
    @section('header-actions')
    <div>
        <button class="btn fw-semibold" style="background-color: #593E75; color: white; border-radius: 8px; padding: 0.75rem 1.25rem; font-size: 14px; border: none;" data-bs-toggle="offcanvas" data-bs-target="#offcanvasVehicle">
            <i class="bi bi-plus-lg me-2"></i>Adicionar veículo
        </button>
        <button class="btn btn-outline-secondary ms-3 fw-semibold" style="border-radius: 8px; padding: 0.75rem 1.25rem; font-size: 14px; color: #718096; border-color: #e2e8f0;">
            Filtrar
        </button>
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
                <a href="{{ route('vehicles.index') }}" class="btn btn-sm btn-outline-secondary ms-2">
                    <i class="bi bi-x"></i> Limpar pesquisa
                </a>
            </div>
        </div>
    @endif

    <table class="table table-hover align-middle bg-white w-100" style="margin: 0;">
        <thead>
                <tr class="table-light">
                    <th scope="col" class="ps-4" style="color: #718096; font-size: 14px; font-weight: 500;">Prefixo</th>
                    <th scope="col" style="color: #718096; font-size: 14px; font-weight: 500;">Placa</th>
                    <th scope="col" style="color: #718096; font-size: 14px; font-weight: 500;">Modelo</th>
                    <th scope="col" style="color: #718096; font-size: 14px; font-weight: 500;">Chassi</th>
                    <th scope="col" style="color: #718096; font-size: 14px; font-weight: 500;">Tipo de veículo</th>
                    <th scope="col" style="color: #718096; font-size: 14px; font-weight: 500;">Capacidade</th>
                    <th scope="col" style="color: #718096; font-size: 14px; font-weight: 500;">Ano</th>
                    <th scope="col" class="text-end pe-4" style="width: 50px;"></th>
                </tr>
            </thead>
            <tbody>
                @forelse ($vehicles as $vehicle)
                <tr style="border-bottom: 1px solid #f1f5f9;">
                    <td class="ps-4" style="padding: 1rem 0; font-size: 14px; color: #374151;">{{ $vehicle->prefix ?? 'N/A' }}</td>
                    <td style="padding: 1rem 0; font-size: 14px; color: #374151;">{{ $vehicle->plate }}</td>
                    <td style="padding: 1rem 0; font-size: 14px; color: #6b7280;">{{ $vehicle->brand }} {{ $vehicle->model }}</td>
                    <td style="padding: 1rem 0; font-size: 14px; color: #6b7280;">{{ $vehicle->chassis ?? 'N/A' }}</td>
                    <td style="padding: 1rem 0; font-size: 14px; color: #6b7280;">{{ $vehicle->type ?? 'Ônibus' }}</td>
                    <td style="padding: 1rem 0; font-size: 14px; color: #6b7280;">{{ $vehicle->capacity ?? '45' }}</td>
                    <td style="padding: 1rem 0; font-size: 14px; color: #6b7280;">{{ $vehicle->year ?? 'N/A' }}</td>
                    <td class="text-end pe-4" style="padding: 1rem 0;">
                        <div class="dropdown">
                            <button class="btn btn-sm btn-light border-0" type="button" data-bs-toggle="dropdown" aria-expanded="false" style="background: transparent; color: #718096;">
                                <i class="bi bi-three-dots" style="font-size: 16px;"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end" style="border: none; border-radius: 0; padding: 0; min-width: 200px; background: transparent; box-shadow: none;">
                                <li style="margin-bottom: 0.5rem;">
                                    <a class="dropdown-item d-flex align-items-center" href="#" onclick="editVehicle({{ $vehicle->id }}, '{{ $vehicle->plate }}', '{{ $vehicle->model }}', '{{ $vehicle->brand }}')"
                                       style="padding: 0.875rem 1rem; font-size: 14px; color: #2d3748; border-radius: 8px; background: #ffffff; border: 1px solid #f0f0f0; transition: all 0.2s; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                                        <i class="bi bi-pencil me-2" style="color: #718096;"></i>
                                        Editar veículo
                                    </a>
                                </li>
                                
                                <li>
                                    <form action="{{ route('vehicles.destroy', $vehicle) }}" method="POST" onsubmit="return confirm('Tem a certeza que deseja excluir este veículo?');" class="m-0">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="dropdown-item d-flex align-items-center w-100" 
                                                style="padding: 0.875rem 1rem; font-size: 14px; color: #e53e3e; border-radius: 8px; background: #ffffff; border: 1px solid #f0f0f0; transition: all 0.2s; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                                            <i class="bi bi-trash me-2" style="color: #e53e3e;"></i>
                                            Deletar veículo
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center text-muted py-4">
                        @if(request('search'))
                            <i class="bi bi-search me-2"></i>
                            Nenhum veículo encontrado para "{{ request('search') }}".
                            <br>
                            <a href="{{ route('vehicles.index') }}" class="btn btn-sm btn-outline-primary mt-2">
                                Ver todos os veículos
                            </a>
                        @else
                            <i class="bi bi-car-front me-2"></i>
                            Nenhum veículo cadastrado.
                        @endif
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>

        {{-- Paginação --}}
        @if($vehicles->hasPages())
            <div class="d-flex justify-content-center mt-4">
                {{ $vehicles->links() }}
            </div>
        @endif

    {{-- Modal para Adicionar Veículo --}}
    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasVehicle" aria-labelledby="offcanvasVehicleLabel" style="width: 400px;">
        <div class="offcanvas-header border-bottom d-flex justify-content-between align-items-center" style="padding: 1.5rem;">
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close" style="margin: 0; padding: 0; width: 32px; height: 32px;"></button>
            <h5 class="offcanvas-title fw-semibold text-center flex-grow-1 m-0" id="offcanvasVehicleLabel" style="color: #2d3748;">Veículo</h5>
            <button type="button" class="btn btn-sm btn-outline-secondary p-1" style="width: 32px; height: 32px;">
                <i class="bi bi-trash" style="font-size: 14px;"></i>
            </button>
        </div>
        <div class="offcanvas-body" style="padding: 0.75rem 1.5rem;">
            <form action="{{ route('vehicles.store') }}" method="POST" id="vehicleForm">
                @csrf
                <div class="form-fields-container">
                    <div class="mb-1">
                        <label for="prefix" class="form-label" style="color: #718096; font-size: 14px; margin-bottom: 0.125rem;">Prefixo:</label>
                        <input type="text" class="form-control @error('prefix') is-invalid @enderror" id="prefix" name="prefix" value="{{ old('prefix') }}" 
                               style="border: 1px solid #e2e8f0; border-radius: 8px; padding: 0.5rem; font-size: 14px;" 
                               placeholder="Digite o prefixo">
                        @error('prefix')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-1">
                        <label for="plate" class="form-label" style="color: #718096; font-size: 14px; margin-bottom: 0.125rem;">Placa:</label>
                        <input type="text" class="form-control @error('plate') is-invalid @enderror" id="plate" name="plate" value="{{ old('plate') }}" required 
                               style="border: 1px solid #e2e8f0; border-radius: 8px; padding: 0.5rem; font-size: 14px;" 
                               placeholder="Digite a placa">
                        @error('plate')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-1">
                        <label for="model" class="form-label" style="color: #718096; font-size: 14px; margin-bottom: 0.125rem;">Modelo:</label>
                        <input type="text" class="form-control @error('model') is-invalid @enderror" id="model" name="model" value="{{ old('model') }}" required 
                               style="border: 1px solid #e2e8f0; border-radius: 8px; padding: 0.5rem; font-size: 14px;" 
                               placeholder="Digite o modelo">
                        @error('model')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-1">
                        <label for="brand" class="form-label" style="color: #718096; font-size: 14px; margin-bottom: 0.125rem;">Marca:</label>
                        <input type="text" class="form-control @error('brand') is-invalid @enderror" id="brand" name="brand" value="{{ old('brand') }}" required 
                               style="border: 1px solid #e2e8f0; border-radius: 8px; padding: 0.5rem; font-size: 14px;" 
                               placeholder="Digite a marca">
                        @error('brand')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-1">
                        <label for="chassis" class="form-label" style="color: #718096; font-size: 14px; margin-bottom: 0.125rem;">Chassi:</label>
                        <input type="text" class="form-control @error('chassis') is-invalid @enderror" id="chassis" name="chassis" value="{{ old('chassis') }}" 
                               style="border: 1px solid #e2e8f0; border-radius: 8px; padding: 0.5rem; font-size: 14px;" 
                               placeholder="Digite o chassi">
                        @error('chassis')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-1">
                        <label for="type" class="form-label" style="color: #718096; font-size: 14px; margin-bottom: 0.125rem;">Tipo de veículo:</label>
                        <select class="form-select @error('type') is-invalid @enderror" id="type" name="type" 
                                style="border: 1px solid #e2e8f0; border-radius: 8px; padding: 0.5rem; font-size: 14px;">
                            <option value="Ônibus" {{ old('type') == 'Ônibus' ? 'selected' : '' }}>Ônibus</option>
                            <option value="Van" {{ old('type') == 'Van' ? 'selected' : '' }}>Van</option>
                            <option value="Micro-ônibus" {{ old('type') == 'Micro-ônibus' ? 'selected' : '' }}>Micro-ônibus</option>
                        </select>
                        @error('type')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-1">
                        <label for="capacity" class="form-label" style="color: #718096; font-size: 14px; margin-bottom: 0.125rem;">Capacidade:</label>
                        <input type="number" class="form-control @error('capacity') is-invalid @enderror" id="capacity" name="capacity" value="{{ old('capacity') }}" 
                               style="border: 1px solid #e2e8f0; border-radius: 8px; padding: 0.5rem; font-size: 14px;" 
                               placeholder="Digite a capacidade">
                        @error('capacity')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-1">
                        <label for="year" class="form-label" style="color: #718096; font-size: 14px; margin-bottom: 0.125rem;">Ano:</label>
                        <input type="number" class="form-control @error('year') is-invalid @enderror" id="year" name="year" value="{{ old('year') }}" 
                               style="border: 1px solid #e2e8f0; border-radius: 8px; padding: 0.5rem; font-size: 14px;" 
                               placeholder="Digite o ano" min="1900" max="2030">
                        @error('year')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Equipamentos adicionais --}}
                    <div class="mb-2">
                        <label class="form-label" style="color: #718096; font-size: 14px; margin-bottom: 0.5rem;">Equipamentos:</label>
                        <div class="features-container" style="height: 160px; overflow-y: auto; padding: 0.75rem; border: 1px solid #e2e8f0; border-radius: 8px; background-color: #f8f9fa;">
                            <div class="row g-2">
                                <div class="col-6">
                                    <div class="feature-item">
                                        <input class="feature-checkbox" type="checkbox" id="internet" name="features[]" value="Internet" 
                                               {{ in_array('Internet', old('features', [])) ? 'checked' : '' }}>
                                        <label class="feature-label" for="internet">
                                            <i class="bi bi-wifi me-2"></i>Internet
                                        </label>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="feature-item">
                                        <input class="feature-checkbox" type="checkbox" id="wc" name="features[]" value="WC" 
                                               {{ in_array('WC', old('features', [])) ? 'checked' : '' }}>
                                        <label class="feature-label" for="wc">
                                            <i class="bi bi-door-open me-2"></i>WC
                                        </label>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="feature-item">
                                        <input class="feature-checkbox" type="checkbox" id="tomada" name="features[]" value="Tomada" 
                                               {{ in_array('Tomada', old('features', [])) ? 'checked' : '' }}>
                                        <label class="feature-label" for="tomada">
                                            <i class="bi bi-lightning-charge me-2"></i>Tomada
                                        </label>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="feature-item">
                                        <input class="feature-checkbox" type="checkbox" id="ar_condicionado" name="features[]" value="Ar Condicionado" 
                                               {{ in_array('Ar Condicionado', old('features', [])) ? 'checked' : '' }}>
                                        <label class="feature-label" for="ar_condicionado">
                                            <i class="bi bi-snow me-2"></i>Ar Condicionado
                                        </label>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="feature-item">
                                        <input class="feature-checkbox" type="checkbox" id="geladeira" name="features[]" value="Geladeira" 
                                               {{ in_array('Geladeira', old('features', [])) ? 'checked' : '' }}>
                                        <label class="feature-label" for="geladeira">
                                            <i class="bi bi-thermometer-snow me-2"></i>Geladeira
                                        </label>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="feature-item">
                                        <input class="feature-checkbox" type="checkbox" id="calefacao" name="features[]" value="Calefação" 
                                               {{ in_array('Calefação', old('features', [])) ? 'checked' : '' }}>
                                        <label class="feature-label" for="calefacao">
                                            <i class="bi bi-thermometer-sun me-2"></i>Calefação
                                        </label>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="feature-item">
                                        <input class="feature-checkbox" type="checkbox" id="video" name="features[]" value="Vídeo" 
                                               {{ in_array('Vídeo', old('features', [])) ? 'checked' : '' }}>
                                        <label class="feature-label" for="video">
                                            <i class="bi bi-play-btn me-2"></i>Vídeo
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                {{-- Botões no final do modal --}}
                <div class="form-buttons-container">
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn text-white fw-semibold" style="background-color: #593E75; border: none; border-radius: 8px; padding: 0.625rem; font-size: 14px;">
                            Finalizar cadastro
                        </button>
                        <button type="button" class="btn btn-outline-secondary fw-semibold" data-bs-dismiss="offcanvas" 
                                style="border: 1px solid #e2e8f0; border-radius: 8px; padding: 0.625rem; font-size: 14px; color: #4a5568;">
                            Cancelar
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
    <style>
        /* Estilos para os modais seguirem o design do Figma */
        #offcanvasVehicle .offcanvas-body {
            display: flex;
            flex-direction: column;
            height: calc(100vh - 80px);
            padding: 0.75rem 1.5rem 1rem 1.5rem !important;
            overflow-y: auto;
        }
        
        #offcanvasVehicle .offcanvas-body form {
            display: flex;
            flex-direction: column;
            flex: 1;
            min-height: 0;
        }
        
        /* Container de campos do formulário */
        #offcanvasVehicle .form-fields-container {
            flex: 1;
            overflow-y: auto;
            padding-right: 0.25rem;
            margin-bottom: 1rem;
        }
        
        /* Container de botões fixo */
        #offcanvasVehicle .form-buttons-container {
            flex-shrink: 0;
            margin-top: auto;
        }
        
        /* Hover effect para os inputs */
        #offcanvasVehicle .form-control:focus,
        #offcanvasVehicle .form-select:focus {
            border-color: #593E75;
            box-shadow: 0 0 0 0.2rem rgba(89, 62, 117, 0.25);
        }
        
        /* Estilo para o botão de lixeira */
        #offcanvasVehicle .btn-outline-secondary:hover {
            background-color: #f8f9fa;
            border-color: #dee2e6;
        }
        
        /* Estilo para os botões principais */
        #offcanvasVehicle .btn:hover[style*="background-color: #593E75"] {
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
        
        /* Estilos para os checkboxes */
        #offcanvasVehicle .form-check-input {
            border-color: #e2e8f0;
            border-radius: 4px;
        }
        
        #offcanvasVehicle .form-check-input:checked {
            background-color: #593E75;
            border-color: #593E75;
        }
        
        #offcanvasVehicle .form-check-input:focus {
            box-shadow: 0 0 0 0.2rem rgba(89, 62, 117, 0.25);
            border-color: #593E75;
        }
        
        #offcanvasVehicle .form-check-label {
            cursor: pointer;
        }
        
        /* Estilos para os equipamentos como botões */
        .features-container {
            scrollbar-width: thin;
            scrollbar-color: #cbd5e0 #f7fafc;
            overflow-y: auto !important;
            height: 160px !important;
        }
        
        .features-container::-webkit-scrollbar {
            width: 8px;
        }
        
        .features-container::-webkit-scrollbar-track {
            background: #f7fafc;
            border-radius: 4px;
        }
        
        .features-container::-webkit-scrollbar-thumb {
            background: #cbd5e0;
            border-radius: 4px;
        }
        
        .features-container::-webkit-scrollbar-thumb:hover {
            background: #a0aec0;
        }
        
        /* Garantir que o conteúdo force a rolagem */
        .features-container .row {
            min-height: 180px;
        }
        
        .feature-item {
            position: relative;
            margin-bottom: 0.5rem;
        }
        
        .feature-checkbox {
            position: absolute;
            opacity: 0;
            width: 0;
            height: 0;
        }
        
        .feature-label {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            padding: 0.625rem 0.75rem;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            background-color: #ffffff;
            color: #4a5568;
            font-size: 12px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s ease;
            text-align: center;
            user-select: none;
            min-height: 44px;
        }
        
        .feature-label:hover {
            border-color: #593E75;
            background-color: #f7f5fb;
            color: #593E75;
        }
        
        .feature-checkbox:checked + .feature-label {
            background-color: #593E75;
            border-color: #593E75;
            color: #ffffff;
        }
        
        .feature-checkbox:checked + .feature-label i {
            color: #ffffff;
        }
        
        .feature-label i {
            color: #718096;
            font-size: 14px;
        }
        
        .feature-checkbox:focus + .feature-label {
            box-shadow: 0 0 0 2px rgba(89, 62, 117, 0.2);
        }
    </style>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            console.log('Bootstrap:', typeof bootstrap);
        });
        
        window.editVehicle = function(id, plate, model, brand) {
            try {
                // TODO: Implementar modal de edição
                console.log('Edit vehicle:', { id, plate, model, brand });
            } catch (error) {
                console.error('Erro na função editVehicle:', error);
            }
        };
    </script>
    @endpush
</x-app-layout>
