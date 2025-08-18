<x-app-layout>
    {{-- Tabela de Utilizadores --}}
    <div class="card shadow-sm border-0">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr class="table-light">
                            <th scope="col" class="ps-4">Usuário</th>
                            <th scope="col">E-mail</th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- Exemplo de linha de utilizador 1 --}}
                        <tr>
                            <td class="ps-4">Maria Antônia da Silva</td>
                            <td>M.Antonia@gmail.com</td>
                            <td class="text-end pe-4">
                                <div class="dropdown">
                                    <button class="btn btn-sm btn-light" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="bi bi-three-dots-vertical"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li><a class="dropdown-item" href="#">Editar</a></li>
                                        <li><a class="dropdown-item text-danger" href="#">Excluir</a></li>
                                    </ul>
                                </div>
                            </td>
                        </tr>

                        {{-- Exemplo de linha de utilizador 2 --}}
                        <tr>
                            <td class="ps-4">Ricardo Martins</td>
                            <td>Ricardo.Martins@gmail.com</td>
                            <td class="text-end pe-4">
                                <div class="dropdown">
                                    <button class="btn btn-sm btn-light" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="bi bi-three-dots-vertical"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li><a class="dropdown-item" href="#">Editar</a></li>
                                        <li><a class="dropdown-item text-danger" href="#">Excluir</a></li>
                                    </ul>
                                </div>
                            </td>
                        </tr>

                        {{-- Adicione mais linhas conforme necessário --}}

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
