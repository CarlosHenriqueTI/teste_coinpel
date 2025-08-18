<form method="post" action="{{ route('password.update') }}">
    @csrf
    @method('put')

    <div class="mb-3">
        <label for="update_password_current_password" class="form-label">Senha Atual</label>
        <input id="update_password_current_password" name="current_password" type="password" 
               class="form-control @error('current_password', 'updatePassword') is-invalid @enderror" 
               autocomplete="current-password">
        @error('current_password', 'updatePassword')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="update_password_password" class="form-label">Nova Senha</label>
        <input id="update_password_password" name="password" type="password" 
               class="form-control @error('password', 'updatePassword') is-invalid @enderror" 
               autocomplete="new-password">
        @error('password', 'updatePassword')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="update_password_password_confirmation" class="form-label">Confirmar Senha</label>
        <input id="update_password_password_confirmation" name="password_confirmation" type="password" 
               class="form-control @error('password_confirmation', 'updatePassword') is-invalid @enderror" 
               autocomplete="new-password">
        @error('password_confirmation', 'updatePassword')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="d-flex align-items-center justify-content-end">
        <button type="submit" class="btn text-white" style="background-color: #593E75;">Salvar</button>
    </div>
</form>
