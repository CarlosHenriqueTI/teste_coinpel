<x-app-layout>
    @section('header-actions')
    <div>
        <button class="btn fw-semibold" style="background-color: #593E75; color: white; border-radius: 8px; padding: 0.75rem 1.25rem; font-size: 14px; border: none;" data-bs-toggle="offcanvas" data-bs-target="#offcanvasTrip">
            <i class="bi bi-plus-lg me-2"></i>Adicionar viagem
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
                <a href="{{ route('trips.index') }}" class="btn btn-sm btn-outline-secondary ms-2">
                    <i class="bi bi-x"></i> Limpar pesquisa
                </a>
            </div>
        </div>
    @endif

    <table class="table table-hover align-middle bg-white w-100" style="margin: 0;">
        <thead>
                <tr class="table-light">
                    <th scope="col" class="ps-4" style="color: #718096; font-size: 14px; font-weight: 500;">Status</th>
                    <th scope="col" style="color: #718096; font-size: 14px; font-weight: 500;">Nome</th>
                    <th scope="col" style="color: #718096; font-size: 14px; font-weight: 500;">Data</th>
                    <th scope="col" style="color: #718096; font-size: 14px; font-weight: 500;">Horário</th>
                    <th scope="col" style="color: #718096; font-size: 14px; font-weight: 500;">Rota</th>
                    <th scope="col" style="color: #718096; font-size: 14px; font-weight: 500;">Veículo</th>
                    <th scope="col" style="color: #718096; font-size: 14px; font-weight: 500;">Regra</th>
                    <th scope="col" style="color: #718096; font-size: 14px; font-weight: 500;">Motorista</th>
                    <th scope="col" class="text-end pe-4" style="width: 50px;"></th>
                </tr>
            </thead>
            <tbody>
                @forelse ($trips as $trip)
                <tr style="border-bottom: 1px solid #f1f5f9;">
                    <td class="ps-4" style="padding: 1rem 0;">
                        @php
                            $now = now();
                            $departure = \Carbon\Carbon::parse($trip->departure_time);
                            $arrival = \Carbon\Carbon::parse($trip->arrival_time);
                            
                            if ($now < $departure) {
                                $status = 'Em andamento';
                                $statusColor = '#f59e0b';
                                $bgColor = '#fef3c7';
                            } elseif ($now >= $departure && $now <= $arrival) {
                                $status = 'Em andamento';
                                $statusColor = '#f59e0b';
                                $bgColor = '#fef3c7';
                            } else {
                                $status = 'Completa';
                                $statusColor = '#10b981';
                                $bgColor = '#d1fae5';
                            }
                        @endphp
                        <span style="background-color: {{ $bgColor }}; color: {{ $statusColor }}; padding: 0.25rem 0.75rem; border-radius: 16px; font-size: 12px; font-weight: 500;">
                            {{ $status }}
                        </span>
                    </td>
                    <td style="padding: 1rem 0; font-size: 14px; color: #374151;">{{ $trip->driver->name ?? 'N/A' }}</td>
                    <td style="padding: 1rem 0; font-size: 14px; color: #6b7280;">{{ \Carbon\Carbon::parse($trip->departure_time)->format('d/m/Y') }}</td>
                    <td style="padding: 1rem 0; font-size: 14px; color: #6b7280;">{{ \Carbon\Carbon::parse($trip->departure_time)->format('H:i') }}</td>
                    <td style="padding: 1rem 0;">
                        <div class="d-flex align-items-center">
                            <span style="font-size: 14px; color: #374151;">{{ $trip->origin }}</span>
                            <i class="bi bi-arrow-right mx-2" style="color: #9ca3af; font-size: 12px;"></i>
                            <span style="font-size: 14px; color: #6b7280;">{{ $trip->destination }}</span>
                        </div>
                    </td>
                    <td style="padding: 1rem 0; font-size: 14px; color: #6b7280;">{{ $trip->vehicle->model ?? 'N/A' }} - {{ $trip->vehicle->brand ?? '' }}</td>
                    <td style="padding: 1rem 0; font-size: 14px; color: #6b7280;">{{ $trip->vehicle->plate ?? 'N/A' }}</td>
                    <td style="padding: 1rem 0; font-size: 14px; color: #374151;">{{ $trip->driver->name ?? 'N/A' }}</td>
                    <td class="text-end pe-4" style="padding: 1rem 0;">
                        <div class="dropdown">
                            <button class="btn btn-sm btn-light border-0" type="button" data-bs-toggle="dropdown" aria-expanded="false" style="background: transparent; color: #718096;">
                                <i class="bi bi-three-dots" style="font-size: 16px;"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end" style="border: none; border-radius: 0; padding: 0; min-width: 200px; background: transparent; box-shadow: none;">
                                <li style="margin-bottom: 0.5rem;">
                                    <a class="dropdown-item d-flex align-items-center" href="{{ route('trips.details', $trip) }}" 
                                       style="padding: 0.875rem 1rem; font-size: 14px; color: #2d3748; border-radius: 8px; background: #ffffff; border: 1px solid #f0f0f0; transition: all 0.2s; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                                        <i class="bi bi-pencil me-3" style="font-size: 14px; color: #718096;"></i>
                                        Editar viagem
                                    </a>
                                </li>
                                
                                <li>
                                    <form action="{{ route('trips.destroy', $trip) }}" method="POST" onsubmit="return confirm('Tem a certeza que deseja excluir esta viagem?');" class="m-0">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="dropdown-item d-flex align-items-center w-100 border-0 bg-transparent text-start" 
                                                style="padding: 0.875rem 1rem; font-size: 14px; color: #e53e3e; border-radius: 8px; background: #ffffff; border: 1px solid #f0f0f0; transition: all 0.2s; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                                            <i class="bi bi-trash me-3" style="font-size: 14px; color: #e53e3e;"></i>
                                            Deletar viagem
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="9" class="text-center text-muted py-4">
                        @if(request('search'))
                            <i class="bi bi-search me-2"></i>
                            Nenhuma viagem encontrada para "{{ request('search') }}".
                            <br>
                            <a href="{{ route('trips.index') }}" class="btn btn-sm btn-outline-primary mt-2">
                                Ver todas as viagens
                            </a>
                        @else
                            <i class="bi bi-car-front me-2"></i>
                            Nenhuma viagem cadastrada.
                        @endif
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>

        {{-- Paginação --}}
        @if($trips->hasPages())
            <div class="d-flex justify-content-center mt-4">
                {{ $trips->links() }}
            </div>
        @endif

    {{-- Modal para Adicionar Viagem --}}
    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasTrip" aria-labelledby="offcanvasTripLabel" style="width: 400px;">
        <div class="offcanvas-header border-bottom d-flex justify-content-between align-items-center" style="padding: 1.5rem;">
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close" style="margin: 0; padding: 0; width: 32px; height: 32px;"></button>
            <h5 class="offcanvas-title fw-semibold text-center flex-grow-1 m-0" id="offcanvasTripLabel" style="color: #2d3748;">Viagem</h5>
            <button type="button" class="btn btn-sm btn-outline-secondary p-1" style="width: 32px; height: 32px;">
                <i class="bi bi-trash" style="font-size: 14px;"></i>
            </button>
        </div>
        <div class="offcanvas-body" style="padding: 2rem 1.5rem;">
            <form action="{{ route('trips.store') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="driver_id" class="form-label" style="color: #718096; font-size: 14px; margin-bottom: 0.5rem;">Motorista:</label>
                    <select class="form-select @error('driver_id') is-invalid @enderror" id="driver_id" name="driver_id" required 
                            style="border: 1px solid #e2e8f0; border-radius: 8px; padding: 0.75rem; font-size: 14px;">
                        <option value="">Selecione um motorista</option>
                        @foreach(\App\Models\Driver::all() as $driver)
                            <option value="{{ $driver->id }}" {{ old('driver_id') == $driver->id ? 'selected' : '' }}>
                                {{ $driver->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('driver_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="vehicle_id" class="form-label" style="color: #718096; font-size: 14px; margin-bottom: 0.5rem;">Veículo:</label>
                    <select class="form-select @error('vehicle_id') is-invalid @enderror" id="vehicle_id" name="vehicle_id" required 
                            style="border: 1px solid #e2e8f0; border-radius: 8px; padding: 0.75rem; font-size: 14px;">
                        <option value="">Selecione um veículo</option>
                        @foreach(\App\Models\Vehicle::all() as $vehicle)
                            <option value="{{ $vehicle->id }}" {{ old('vehicle_id') == $vehicle->id ? 'selected' : '' }}>
                                {{ $vehicle->model }} {{ $vehicle->brand }} - {{ $vehicle->plate }}
                            </option>
                        @endforeach
                    </select>
                    @error('vehicle_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="origin" class="form-label" style="color: #718096; font-size: 14px; margin-bottom: 0.5rem;">Origem:</label>
                    <input type="text" class="form-control @error('origin') is-invalid @enderror" id="origin" name="origin" value="{{ old('origin') }}" required 
                           style="border: 1px solid #e2e8f0; border-radius: 8px; padding: 0.75rem; font-size: 14px;" 
                           placeholder="Digite a origem">
                    @error('origin')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="destination" class="form-label" style="color: #718096; font-size: 14px; margin-bottom: 0.5rem;">Destino:</label>
                    <input type="text" class="form-control @error('destination') is-invalid @enderror" id="destination" name="destination" value="{{ old('destination') }}" required 
                           style="border: 1px solid #e2e8f0; border-radius: 8px; padding: 0.75rem; font-size: 14px;" 
                           placeholder="Digite o destino">
                    @error('destination')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="departure_time" class="form-label" style="color: #718096; font-size: 14px; margin-bottom: 0.5rem;">Data e Hora de Partida:</label>
                    <input type="datetime-local" class="form-control @error('departure_time') is-invalid @enderror" id="departure_time" name="departure_time" value="{{ old('departure_time') }}" required 
                           style="border: 1px solid #e2e8f0; border-radius: 8px; padding: 0.75rem; font-size: 14px;">
                    @error('departure_time')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="arrival_time" class="form-label" style="color: #718096; font-size: 14px; margin-bottom: 0.5rem;">Data e Hora de Chegada:</label>
                    <input type="datetime-local" class="form-control @error('arrival_time') is-invalid @enderror" id="arrival_time" name="arrival_time" value="{{ old('arrival_time') }}" required 
                           style="border: 1px solid #e2e8f0; border-radius: 8px; padding: 0.75rem; font-size: 14px;">
                    @error('arrival_time')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                {{-- Espaço flexível para empurrar os botões para o final --}}
                <div style="flex-grow: 1;"></div>
                
                {{-- Botões no final do modal --}}
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

    @push('scripts')
    <style>
        /* Estilos para os modais seguirem o design do Figma */
        #offcanvasTrip .offcanvas-body {
            display: flex;
            flex-direction: column;
            height: calc(100vh - 100px);
        }
        
        #offcanvasTrip .offcanvas-body form {
            display: flex;
            flex-direction: column;
            height: 100%;
        }
        
        /* Hover effect para os inputs */
        #offcanvasTrip .form-control:focus,
        #offcanvasTrip .form-select:focus {
            border-color: #593E75;
            box-shadow: 0 0 0 0.2rem rgba(89, 62, 117, 0.25);
        }
        
        /* Estilo para o botão de lixeira */
        #offcanvasTrip .btn-outline-secondary:hover {
            background-color: #f8f9fa;
            border-color: #dee2e6;
        }
        
        /* Estilo para os botões principais */
        #offcanvasTrip .btn:hover[style*="background-color: #593E75"] {
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
        
        window.editTrip = function(id, origin, destination, departureTime, arrivalTime, driverId, vehicleId) {
            try {
                // TODO: Implementar modal de edição
                console.log('Edit trip:', { id, origin, destination, departureTime, arrivalTime, driverId, vehicleId });
            } catch (error) {
                console.error('Erro na função editTrip:', error);
            }
        };
    </script>
    @endpush
</x-app-layout>
