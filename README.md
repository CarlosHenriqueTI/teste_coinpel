# 🚌 Coinpel Trips

<p align="center">
  <img src="https://img.shields.io/badge/Laravel-12.24.0-red?style=for-the-badge&logo=laravel" alt="Laravel">
  <img src="https://img.shields.io/badge/PHP-8.3.16-blue?style=for-the-badge&logo=php" alt="PHP">
  <img src="https://img.shields.io/badge/PostgreSQL-17.6-blue?style=for-the-badge&logo=postgresql" alt="PostgreSQL">
  <img src="https://img.shields.io/badge/Bootstrap-5.3-purple?style=for-the-badge&logo=bootstrap" alt="Bootstrap">
</p>

Sistema de gerenciamento de viagens para a empresa Coinpel, desenvolvido em Laravel com interface moderna e responsiva.

## 📋 Sobre o Projeto

O **Coinpel Trips** é um sistema completo para gerenciamento de viagens corporativas que permite:

- 👥 **Gestão de Usuários** - Cadastro e controle de acesso
- 🚗 **Gestão de Veículos** - Controle completo da frota com características detalhadas
- 👨‍✈️ **Gestão de Motoristas** - Cadastro e controle dos condutores
- 🎫 **Gestão de Viagens** - Criação, edição e controle de viagens
- 📊 **Dashboard Intuitivo** - Interface amigável para visualização de dados

## 🛠️ Tecnologias Utilizadas

### Backend
- **[Laravel 12.24.0](https://laravel.com)** - Framework PHP moderno
- **[PHP 8.3.16](https://php.net)** - Linguagem de programação
- **[PostgreSQL 17.6](https://postgresql.org)** - Banco de dados relacional
- **[Eloquent ORM](https://laravel.com/docs/eloquent)** - Mapeamento objeto-relacional

### Frontend
- **[Bootstrap 5.3](https://getbootstrap.com)** - Framework CSS responsivo
- **[Blade Templates](https://laravel.com/docs/blade)** - Engine de templates do Laravel
- **[Vite](https://vitejs.dev)** - Bundler moderno para assets
- **JavaScript ES6+** - Interatividade frontend

### Ferramentas de Desenvolvimento
- **[Composer](https://getcomposer.org)** - Gerenciador de dependências PHP
- **[NPM](https://npmjs.com)** - Gerenciador de pacotes Node.js
- **[Git](https://git-scm.com)** - Controle de versão
- **[Laragon](https://laragon.org)** - Ambiente de desenvolvimento local

## 📦 Pré-requisitos

Antes de executar o projeto, certifique-se de ter instalado:

- **PHP >= 8.2** com extensões:
  - `pdo_pgsql`
  - `pgsql`
  - `mbstring`
  - `openssl`
  - `tokenizer`
  - `xml`
  - `ctype`
  - `json`
- **PostgreSQL >= 15**
- **Composer**
- **Node.js >= 18**
- **Git**

## 🚀 Instalação e Configuração

### 1. Clone o repositório
```bash
git clone https://github.com/CarlosHenriqueTI/teste_coinpel.git
cd teste_coinpel
```

### 2. Instale as dependências PHP
```bash
composer install
```

### 3. Instale as dependências Node.js
```bash
npm install
```

### 4. Configure o ambiente
```bash
# Copie o arquivo de exemplo
cp .env.example .env

# Gere a chave da aplicação
php artisan key:generate
```

### 5. Configure o banco de dados
Edite o arquivo `.env` com suas configurações de banco:

```env
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=coinpel_db
DB_USERNAME=postgres
DB_PASSWORD=sua_senha
```

### 6. Execute as migrações e seeders
```bash
# Criar e configurar o banco
php artisan migrate

# Popular com dados de exemplo
php artisan db:seed
```

### 7. Compile os assets
```bash
# Para desenvolvimento
npm run dev

# Para produção
npm run build
```

### 8. Inicie o servidor
```bash
php artisan serve
```

Acesse: **http://127.0.0.1:8000**

## 🔐 Credenciais de Acesso

### Usuário de Teste
- **Email:** `test@example.com`
- **Senha:** `password`

## 📁 Estrutura do Projeto

```
coinpel-trips/
├── app/
│   ├── Http/Controllers/     # Controladores
│   ├── Models/              # Modelos Eloquent
│   └── Providers/           # Provedores de serviço
├── database/
│   ├── migrations/          # Migrações do banco
│   ├── seeders/            # Seeders para popular dados
│   └── factories/          # Factories para testes
├── resources/
│   ├── views/              # Templates Blade
│   ├── js/                 # JavaScript
│   └── scss/               # Arquivos SCSS
├── routes/
│   ├── web.php             # Rotas web
│   └── auth.php            # Rotas de autenticação
└── public/                 # Arquivos públicos
```

## 🔧 Comandos Úteis

```bash
# Limpar caches
php artisan config:clear
php artisan cache:clear
php artisan view:clear

# Executar migrações
php artisan migrate
php artisan migrate:rollback

# Executar seeders
php artisan db:seed
php artisan db:seed --class=TripSeeder

# Compilar assets
npm run dev          # Desenvolvimento
npm run watch        # Watch mode
npm run build        # Produção
```

## 📊 Funcionalidades Principais

### Gestão de Veículos
- Cadastro completo com modelo, marca, ano
- Controle de características (ar-condicionado, GPS, etc.)
- Status de disponibilidade

### Gestão de Viagens
- Criação de viagens com origem e destino
- Atribuição de motorista e veículo
- Controle de status e preços
- Data e hora de saída/chegada

### Dashboard
- Visão geral do sistema
- Estatísticas importantes
- Interface responsiva

## 🤝 Contribuindo

1. Faça um fork do projeto
2. Crie uma branch para sua feature (`git checkout -b feature/AmazingFeature`)
3. Commit suas mudanças (`git commit -m 'Add some AmazingFeature'`)
4. Push para a branch (`git push origin feature/AmazingFeature`)
5. Abra um Pull Request

## 👨‍💻 Autor

**Carlos Henrique**
- GitHub: [@CarlosHenriqueTI](https://github.com/CarlosHenriqueTI)
- Email: carloshenriqueti09@gmail.com

---

<p align="center">
  Desenvolvido com ❤️ para a Coinpel
</p>
