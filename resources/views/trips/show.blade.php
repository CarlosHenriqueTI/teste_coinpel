<x-app-layout>
    {{-- Seção para o botão "Voltar" no cabeçalho principal --}}
    @section('header-actions')
        <a href="{{ route('trips.index') }}" class="btn btn-outline-secondary fw-semibold" 
           style="border: 1px solid #e2e8f0; border-radius: 8px; padding: 0.5rem 1rem; font-size: 14px; color: #4a5568; text-decoration: none;">
            Voltar
        </a>
    @endsection

    {{-- Faixa cinza com o título da viagem, abaixo do cabeçalho --}}
    <div style="background-color: #f8f9fa; border-bottom: 1px solid #e2e8f0; padding: 1rem 0;">
        <div class="d-flex justify-content-center align-items-center" style="font-size: 1.125rem;">
            <span style="color: #6c757d;">{{ $trip->origin ?? 'Pelotas' }}</span>
            <i class="bi bi-chevron-right mx-2" style="font-size: 0.875rem; color: #6c757d;"></i>
            <span class="fw-semibold" style="color: #212529;">{{ $trip->destination ?? 'Gramado' }}</span>
        </div>
    </div>

    {{-- Conteúdo principal da página com formulário --}}
    <div class="container-fluid trip-details-page" style="padding: 0; min-height: calc(100vh - 200px); overflow: visible;">
        <div style="padding: 1.5rem 1.5rem 6rem 1.5rem;">
            <!-- Botão de Status Dropdown -->
            <div class="mb-4 d-flex">
                @php
                    $statusConfig = [
                        'in_progress' => ['label' => 'Em andamento', 'color' => '#ffffff', 'bg' => '#F59E0B'],
                        'completed' => ['label' => 'Concluída', 'color' => '#ffffff', 'bg' => '#10B981'],
                        'cancelled' => ['label' => 'Cancelada', 'color' => '#ffffff', 'bg' => '#EF4444']
                    ];
                    $currentStatus = $trip->status ?? 'in_progress';
                    $config = $statusConfig[$currentStatus] ?? $statusConfig['in_progress'];
                @endphp

                <div class="dropdown" id="statusDropdown">
                    <button id="statusButton" class="btn d-flex align-items-center justify-content-between text-white" type="button" data-bs-toggle="dropdown" aria-expanded="false" 
                            style="background-color: {{ $config['bg'] }}; border: none; border-radius: 12px; padding: 12px 20px; font-size: 15px; min-width: 180px; font-weight: 500; box-shadow: none;">
                        <span id="statusLabel">{{ $config['label'] }}</span>
                        <i class="bi bi-chevron-down ms-3" style="font-size: 12px; opacity: 0.8;"></i>
                    </button>
                    <ul class="dropdown-menu mt-2 border-0" id="statusMenu" style="background: transparent; box-shadow: none; border-radius: 8px; padding: 8px; width: 180px;">
                        <li><a class="dropdown-item status-option text-white fw-medium" href="#" data-status="in_progress" data-bg-color="#F59E0B" style="background-color: #F59E0B; border-radius: 12px; margin-bottom: 4px; padding: 12px 20px; min-width: 180px;">
                            Em andamento
                        </a></li>
                        <li><a class="dropdown-item status-option text-white fw-medium" href="#" data-status="completed" data-bg-color="#10B981" style="background-color: #10B981; border-radius: 12px; margin-bottom: 4px; padding: 12px 20px; min-width: 180px;">
                            Concluída
                        </a></li>
                        <li><a class="dropdown-item status-option text-white fw-medium" href="#" data-status="cancelled" data-bg-color="#EF4444" style="background-color: #EF4444; border-radius: 12px; padding: 12px 20px; min-width: 180px;">
                            Cancelada
                        </a></li>
                    </ul>
                </div>
            </div>

            <!-- Formulário -->
            <form id="tripForm" action="{{ route('trips.update', $trip) }}" method="POST">
                @csrf
                @method('PUT')
                
                <!-- Seções do formulário (sem alterações na estrutura interna) -->
                <div class="mb-2">
                    <h5 class="fw-semibold mb-1" style="color: #2d3748; font-size: 16px;">Informações da viagem:</h5>
                    <div class="mb-1">
                        <label class="form-label">Nome da viagem:</label>
                        <input type="text" class="form-control" name="trip_name" value="{{ $trip->trip_name ?? 'ChocoFest' }}">
                    </div>
                    <div class="row g-1 mb-1">
                        <div class="col-md-6">
                            <label class="form-label">Regra:</label>
                            <select class="form-select" name="rule">
                                <option value="Turismo" {{ ($trip->rule ?? 'Turismo') == 'Turismo' ? 'selected' : '' }}>Turismo</option>
                                <option value="Executivo" {{ ($trip->rule ?? '') == 'Executivo' ? 'selected' : '' }}>Executivo</option>
                                <option value="Regular" {{ ($trip->rule ?? '') == 'Regular' ? 'selected' : '' }}>Regular</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Data:</label>
                            <input type="date" class="form-control" name="trip_date" value="{{ $trip->departure_time ? \Carbon\Carbon::parse($trip->departure_time)->format('Y-m-d') : '2021-03-30' }}">
                        </div>
                    </div>
                     <div class="row g-1 mb-1">
                        <div class="col-md-6">
                            <label class="form-label">Horário de Saída:</label>
                            <input type="time" class="form-control" name="departure_time" value="{{ $trip->departure_time ? \Carbon\Carbon::parse($trip->departure_time)->format('H:i') : '15:00' }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Origem:</label>
                            <input type="text" class="form-control" name="origin" value="{{ $trip->origin ?? 'Pelotas' }}">
                        </div>
                    </div>
                    <div class="row g-1 mb-1">
                        <div class="col-md-6">
                            <label class="form-label">Destino:</label>
                            <input type="text" class="form-control" name="destination" value="{{ $trip->destination ?? 'Gramado' }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Valor da passagem avulsa:</label>
                            <input type="text" class="form-control" name="ticket_price" value="{{ $trip->ticket_price ?? 'R$ 40,00' }}">
                        </div>
                    </div>
                </div>
                <div class="mb-2">
                    <h5 class="fw-semibold mb-1">Dados do veículo:</h5>
                    <div class="row g-1 mb-1">
                        <div class="col-md-6">
                            <label class="form-label">Veículo:</label>
                            <select class="form-select" name="vehicle_id">
                                @foreach($vehicles as $vehicle)
                                    <option value="{{ $vehicle->id }}" {{ $trip->vehicle_id == $vehicle->id ? 'selected' : '' }}>
                                        {{ $vehicle->plate }} - {{ $vehicle->model }}
                                    </option>
                                @endforeach
                                @if($vehicles->isEmpty())
                                    <option selected>202 - Scania</option>
                                @endif
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Número de passageiros:</label>
                            <input type="number" class="form-control" name="passenger_count" value="{{ $trip->passenger_count ?? '35' }}">
                        </div>
                    </div>
                </div>
                <div class="mb-2">
                    <h5 class="fw-semibold mb-1">Motorista:</h5>
                    <div class="row g-1 mb-1">
                        <div class="col-md-6">
                            <label class="form-label">Nome:</label>
                            <select class="form-select" name="driver_id">
                                @foreach($drivers as $driver)
                                    <option value="{{ $driver->id }}" {{ $trip->driver_id == $driver->id ? 'selected' : '' }}>
                                        {{ $driver->name }}
                                    </option>
                                @endforeach
                                @if($drivers->isEmpty())
                                    <option selected>Carlos Vinícius</option>
                                @endif
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Matrícula:</label>
                            <input type="text" class="form-control" name="driver_registration" value="{{ $trip->driver_registration ?? '12548793' }}">
                        </div>
                    </div>
                </div>
                
                <input type="hidden" name="status" id="trip_status" value="{{ $currentStatus }}">

                <!-- Botões de Ação (agora abaixo do formulário) -->
                <div class="mt-5 d-flex gap-2" style="margin-bottom: 4rem;">
                    <button type="submit" form="tripForm" class="btn text-white fw-semibold" 
                            style="background-color: #593E75; border: none; border-radius: 8px; padding: 0.75rem 1.75rem; font-size: 14px;">
                        Salvar alterações
                    </button>
                    <a href="{{ route('trips.index') }}" class="btn btn-outline-secondary fw-semibold" 
                       style="border: 1px solid #e2e8f0; border-radius: 8px; padding: 0.75rem 1.75rem; font-size: 14px; color: #4a5568;">
                        Cancelar
                    </a>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
    <style>
        /* Estilos para garantir a aparência e funcionalidade corretas */
        .trip-details-page {
            scrollbar-width: thin !important;
            scrollbar-color: rgba(89, 62, 117, 0.3) transparent !important;
            min-height: auto !important;
            height: auto !important;
        }
        .trip-details-page::-webkit-scrollbar {
            width: 6px !important;
        }
        .trip-details-page::-webkit-scrollbar-thumb {
            background-color: rgba(89, 62, 117, 0.3) !important;
            border-radius: 3px !important;
        }
        .form-control, .form-select {
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 0.625rem;
            font-size: 14px;
        }
        .form-control:focus, .form-select:focus {
            border-color: #593E75 !important;
            box-shadow: 0 0 0 0.2rem rgba(89, 62, 117, 0.25) !important;
        }
        .form-label {
            color: #718096 !important;
            font-weight: 500 !important;
            font-size: 14px;
            margin-bottom: 0.125rem !important;
        }
        
        /* Estilos específicos para os botões de status */
        #statusButton {
            transition: none !important;
            border-radius: 12px !important;
            font-weight: 500 !important;
            font-size: 15px !important;
            padding: 12px 20px !important;
            border: none !important;
            box-shadow: none !important;
            outline: none !important;
        }
        
        /* Remove seta padrão do Bootstrap dropdown */
        #statusButton::after {
            display: none !important;
        }
        
        /* Remove hover effects dos itens do dropdown */
        .dropdown-menu .dropdown-item {
            color: #ffffff !important;
            border: none !important;
            padding: 12px 20px !important;
            border-radius: 12px !important;
            margin: 2px 0px !important;
            font-weight: 500 !important;
            font-size: 15px !important;
            min-width: 180px !important;
            width: 100% !important;
            box-sizing: border-box !important;
            transition: none !important;
            transform: none !important;
            animation: none !important;
        }
        
        /* Remove TODOS os efeitos visuais dos itens de status */
        .dropdown-menu .dropdown-item.status-option,
        .dropdown-menu .dropdown-item.status-option:hover,
        .dropdown-menu .dropdown-item.status-option:focus,
        .dropdown-menu .dropdown-item.status-option:active,
        .dropdown-menu .dropdown-item.status-option:visited {
            color: #ffffff !important;
            border: none !important;
            box-shadow: none !important;
            transform: none !important;
            outline: none !important;
            opacity: 1 !important;
            transition: none !important;
            animation: none !important;
            text-decoration: none !important;
        }
        
        /* Mantém cores sólidas originais em todos os estados */
        .dropdown-menu .dropdown-item[data-status="in_progress"],
        .dropdown-menu .dropdown-item[data-status="in_progress"]:hover,
        .dropdown-menu .dropdown-item[data-status="in_progress"]:focus,
        .dropdown-menu .dropdown-item[data-status="in_progress"]:active {
            background-color: #F59E0B !important;
        }
        
        .dropdown-menu .dropdown-item[data-status="completed"],
        .dropdown-menu .dropdown-item[data-status="completed"]:hover,
        .dropdown-menu .dropdown-item[data-status="completed"]:focus,
        .dropdown-menu .dropdown-item[data-status="completed"]:active {
            background-color: #10B981 !important;
        }
        
        .dropdown-menu .dropdown-item[data-status="cancelled"],
        .dropdown-menu .dropdown-item[data-status="cancelled"]:hover,
        .dropdown-menu .dropdown-item[data-status="cancelled"]:focus,
        .dropdown-menu .dropdown-item[data-status="cancelled"]:active {
            background-color: #EF4444 !important;
        }
        
        /* Garante que o dropdown tenha a largura correta */
        .dropdown-menu {
            min-width: 180px !important;
            width: 180px !important;
            box-shadow: none !important;
            border: none !important;
        }
        
        /* Padronização das cores dos status */
        .status-cancelled { background-color: #EF4444 !important; }
        .status-in-progress { background-color: #F59E0B !important; }
        .status-completed { background-color: #10B981 !important; }
    </style>
    
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const statusButton = document.getElementById('statusButton');
            const statusLabel = document.getElementById('statusLabel');
            const hiddenInput = document.getElementById('trip_status');
            const statusOptions = document.querySelectorAll('.status-option');

            statusOptions.forEach(option => {
                option.addEventListener('click', function (e) {
                    e.preventDefault();
                    
                    const newStatusValue = this.dataset.status;
                    const newBgColor = this.dataset.bgColor;
                    const newStatusLabel = this.textContent;

                    // Atualiza o texto e a cor do botão
                    statusLabel.textContent = newStatusLabel;
                    statusButton.style.backgroundColor = newBgColor;
                    
                    // Atualiza o valor do campo hidden no formulário
                    hiddenInput.value = newStatusValue;
                });
            });
        });
    </script>
    @endpush
</x-app-layout>
