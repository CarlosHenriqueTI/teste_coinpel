<x-app-layout>
    @section('header-actions')
    <div>
        <h3 class="mb-0">Perfil do Usuário</h3>
    </div>
    @endsection

    {{-- Mensagem de sucesso --}}
    @if (session('status') == 'profile-updated')
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            Perfil atualizado com sucesso!
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if (session('status') == 'password-updated')
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            Senha atualizada com sucesso!
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if (auth()->user()->must_change_password)
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <strong>Atenção!</strong> Você deve alterar sua senha temporária antes de continuar.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Informações do Perfil</h5>
                </div>
                <div class="card-body">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card mb-3">
                <div class="card-header">
                    <h5 class="mb-0">Alterar Senha</h5>
                </div>
                <div class="card-body">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Excluir Conta</h5>
                </div>
                <div class="card-body">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
