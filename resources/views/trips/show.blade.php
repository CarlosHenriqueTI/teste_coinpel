<x-app-layout>
    {{-- Botão de Voltar na barra de navegação --}}
    @section('header-actions')
        <a href="{{ route('trips.index') }}" class="btn btn-light border">
            <i class="bi bi-arrow-left me-2"></i>
            Voltar
        </a>
    @endsection

    {{-- Card principal que ocupa toda a altura disponível --}}
    <div class="card shadow-sm border-0" style="height: calc(100vh - 120px);">
        <div class="card-body p-0 d-flex flex-column">

            {{-- Cabeçalho da Página com Faixa --}}
            <div class="text-center py-3 bg-light border-bottom">
                <h4 class="fw-bold mb-0">
                    <span>{{ $trip->origin ?? 'Origem' }}</span>
                    <i class="bi bi-chevron-right mx-1 text-muted"></i>
                    <span>{{ $trip->destination ?? 'Destino' }}</span>
                </h4>
            </div>

            {{-- Container para o formulário com scroll --}}
            <div class="flex-grow-1 p-4" style="overflow-y: auto;">
                <form id="tripForm" action="{{ route('trips.update', $trip) }}" method="POST">
                    @csrf
                    @method('PUT')

                    {{-- Seletor de Status --}}
                    <div class="mb-4">
                        @php
                            // Mapeamento de status para classes e textos
                            $statusMap = [
                                'completed' => ['text' => 'Concluída', 'class' => 'btn-success'],
                                'in_progress' => ['text' => 'Em andamento', 'class' => 'btn-warning'],
                                'cancelled' => ['text' => 'Cancelada', 'class' => 'btn-danger'],
                            ];
                            $currentStatus = $trip->status ?? 'in_progress';
                            $currentStatusData = $statusMap[$currentStatus] ?? $statusMap['in_progress'];
                        @endphp
                        <div class="dropdown">
                            <button id="statusDropdown" class="btn {{ $currentStatusData['class'] }} dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                {{ $currentStatusData['text'] }}
                            </button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="#" onclick="updateStatus('completed', 'Concluída', 'btn-success')">Concluída</a></li>
                                <li><a class="dropdown-item" href="#" onclick="updateStatus('in_progress', 'Em andamento', 'btn-warning')">Em andamento</a></li>
                                <li><a class="dropdown-item" href="#" onclick="updateStatus('cancelled', 'Cancelada', 'btn-danger')">Cancelada</a></li>
                            </ul>
                            <input type="hidden" name="status" id="trip_status" value="{{ $currentStatus }}">
                        </div>
                    </div>

                    {{-- Secção: Informações da viagem --}}
                    <h5 class="mb-3 fw-bold">Informações da viagem:</h5>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="trip_name" class="form-label">Nome da viagem:</label>
                            <input type="text" class="form-control" id="trip_name" name="trip_name" value="ChocoFest">
                        </div>
                        <div class="col-md-6">
                            <label for="trip_date" class="form-label">Data:</label>
                            <input type="date" class="form-control" id="trip_date" name="trip_date" 
                                   value="{{ $trip->departure_time ? \Carbon\Carbon::parse($trip->departure_time)->format('Y-m-d') : '' }}">
                        </div>
                        <div class="col-md-6">
                            <label for="trip_rule" class="form-label">Regra:</label>
                            <select class="form-select" id="trip_rule" name="trip_rule">
                                <option selected>Turismo</option>
                                <option value="1">Excursão</option>
                                <option value="2">Fretamento</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="trip_origin" class="form-label">Origem:</label>
                            <input type="text" class="form-control" id="trip_origin" name="origin" value="{{ $trip->origin ?? '' }}">
                        </div>
                        <div class="col-md-6">
                            <label for="departure_time" class="form-label">Horário de Saída:</label>
                            <input type="time" class="form-control" id="departure_time" name="departure_time" 
                                   value="{{ $trip->departure_time ? \Carbon\Carbon::parse($trip->departure_time)->format('H:i') : '' }}">
                        </div>
                        <div class="col-md-6">
                            <label for="trip_destination" class="form-label">Destino:</label>
                            <input type="text" class="form-control" id="trip_destination" name="destination" value="{{ $trip->destination ?? '' }}">
                        </div>
                         <div class="col-md-6">
                            <label for="ticket_price" class="form-label">Valor da passagem avulsa:</label>
                            <input type="text" class="form-control" id="ticket_price" name="ticket_price" value="R$ 40,00">
                        </div>
                    </div>

                    <hr class="my-4">

                    {{-- Secção: Dados do veículo --}}
                    <h5 class="mb-3 fw-bold">Dados do veículo:</h5>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="vehicle_id" class="form-label">Veículo:</label>
                            <select class="form-select" id="vehicle_id" name="vehicle_id">
                                @if(isset($vehicles) && $vehicles->count() > 0)
                                    @foreach ($vehicles as $vehicle)
                                        <option value="{{ $vehicle->id }}" {{ $trip->vehicle_id == $vehicle->id ? 'selected' : '' }}>
                                            {{ $vehicle->plate ?? 'N/A' }} - {{ $vehicle->brand ?? '' }} {{ $vehicle->model ?? '' }}
                                        </option>
                                    @endforeach
                                @else
                                    <option value="">Nenhum veículo disponível</option>
                                @endif
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="passenger_count" class="form-label">Número de passageiros:</label>
                            <input type="number" class="form-control" id="passenger_count" name="passenger_count" value="35">
                        </div>
                        <div class="col-md-6">
                            <label for="driver_id" class="form-label">Motorista:</label>
                            <select class="form-select" id="driver_id" name="driver_id">
                                @if(isset($drivers) && $drivers->count() > 0)
                                    @foreach ($drivers as $driver)
                                        <option value="{{ $driver->id }}" {{ $trip->driver_id == $driver->id ? 'selected' : '' }}>
                                            {{ $driver->name ?? 'N/A' }}
                                        </option>
                                    @endforeach
                                @else
                                    <option value="">Nenhum motorista disponível</option>
                                @endif
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="driver_registration" class="form-label">Matrícula:</label>
                            <input type="text" class="form-control" id="driver_registration" name="driver_registration" value="12548793">
                        </div>
                    </div>
                </form>
            </div>

            {{-- Botões de Ação no Final --}}
            <div class="card-footer bg-white p-3 text-end">
                <a href="{{ route('trips.index') }}" class="btn btn-light border ms-2">Cancelar</a>
                <button type="submit" form="tripForm" class="btn text-white" style="background-color: #4A1D7B;">Salvar alterações</button>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        function updateStatus(value, text, btnClass) {
            const dropdownButton = document.getElementById('statusDropdown');
            const hiddenInput = document.getElementById('trip_status');

            // Atualiza o valor do input escondido
            hiddenInput.value = value;

            // Atualiza o texto do botão
            dropdownButton.textContent = text;

            // Remove classes de cor antigas e adiciona a nova
            dropdownButton.classList.remove('btn-secondary', 'btn-warning', 'btn-success', 'btn-danger');
            dropdownButton.classList.add(btnClass);
        }
    </script>
    @endpush
</x-app-layout>
