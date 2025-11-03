<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Loja</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">Editar Loja</h1>

        <form action="{{ route('stores.update', $store) }}" method="POST">
            @csrf
            @method('PUT')

            <!-- Nome -->
            <div class="mb-3">
                <label for="name" class="form-label">Nome da Loja</label>
                <input type="text"
                       class="form-control @error('name') is-invalid @enderror"
                       id="name" name="name"
                       value="{{ old('name', $store->name) }}" required>
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Botões -->
            <button type="submit" class="btn btn-success">Atualizar</button>
            <a href="{{ route('stores.index') }}" class="btn btn-secondary">Voltar</a>
        </form>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
