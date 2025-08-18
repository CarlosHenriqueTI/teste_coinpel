<div class="alert alert-danger">
    <h6><i class="bi bi-exclamation-triangle-fill me-2"></i>Excluir Conta</h6>
    <p class="mb-0">Uma vez que sua conta for excluída, todos os recursos e dados serão excluídos permanentemente do banco de dados. Esta ação não pode ser desfeita.</p>
</div>

<form method="post" action="{{ route('profile.destroy') }}" onsubmit="return confirm('⚠️ ATENÇÃO: Tem certeza que deseja excluir sua conta?\n\nEsta ação irá:\n• Excluir permanentemente sua conta\n• Remover todos os seus dados do banco\n• Fazer logout automático\n• Não pode ser desfeita\n\nDigite sua senha e clique em Confirmar para continuar.');">
    @csrf
    @method('delete')

    <div class="mb-3">
        <label for="password" class="form-label fw-bold">Confirme sua senha para excluir a conta</label>
        <input id="password" name="password" type="password" class="form-control @error('password', 'userDeletion') is-invalid @enderror" placeholder="Digite sua senha atual" required>
        @error('password', 'userDeletion')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
        <div class="form-text">Por segurança, você deve confirmar sua senha para excluir a conta.</div>
    </div>

    <button type="submit" class="btn btn-danger">
        <i class="bi bi-trash3-fill me-2"></i>Excluir Conta Permanentemente
    </button>
</form>
