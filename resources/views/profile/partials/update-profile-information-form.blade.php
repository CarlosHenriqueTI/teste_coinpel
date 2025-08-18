<form method="post" action="{{ route('profile.update') }}">
    @csrf
    @method('patch')

    <div class="mb-3">
        <label for="name" class="form-label">Nome</label>
        <input id="name" name="name" type="text" class="form-control @error('name') is-invalid @enderror" 
               value="{{ old('name', $user->name) }}" required autofocus autocomplete="name">
        @error('name')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="email" class="form-label">E-mail</label>
        <input id="email" name="email" type="email" class="form-control @error('email') is-invalid @enderror" 
               value="{{ old('email', $user->email) }}" required autocomplete="username">
        @error('email')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="d-flex align-items-center justify-content-end">
        <button type="submit" class="btn text-white" style="background-color: #593E75;">Salvar</button>
    </div>
</form>
