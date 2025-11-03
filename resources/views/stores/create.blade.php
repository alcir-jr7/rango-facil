<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Adicionar Loja</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container">
    <h1 class="my-4">Adicionar Loja</h1>

    <form action="{{ route('stores.store') }}" method="POST">
        @csrf

        <!-- Nome -->
        <div class="mb-3">
            <label for="name" class="form-label">Nome da Loja</label>
            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required>
            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <button type="submit" class="btn btn-success">Salvar</button>
        <a href="{{ route('stores.index') }}" class="btn btn-secondary">Voltar</a>
    </form>
</div>
</body>
</html>
