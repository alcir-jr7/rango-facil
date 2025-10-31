<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Adicionar Produto</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container">
    <h1 class="my-4">Adicionar Produto</h1>

    <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <!-- Nome -->
        <div class="mb-3">
            <label for="name" class="form-label">Nome do Produto</label>
            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required>
            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <!-- Descrição -->
        <div class="mb-3">
            <label for="description" class="form-label">Descrição</label>
            <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description">{{ old('description') }}</textarea>
            @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <!-- Imagem -->
        <div class="mb-3">
            <label for="image_path" class="form-label">Imagem</label>
            <input type="file" class="form-control @error('image_path') is-invalid @enderror" id="image_path" name="image_path" accept="image/*">
            @error('image_path') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <!-- Preço -->
        <div class="mb-3">
            <label for="price" class="form-label">Preço</label>
            <input type="number" step="0.01" class="form-control @error('price') is-invalid @enderror" id="price" name="price" value="{{ old('price') }}" required>
            @error('price') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <!-- Preço mínimo -->
        <div class="mb-3">
            <label for="min_price" class="form-label">Preço Mínimo (opcional)</label>
            <input type="number" step="0.01" class="form-control @error('min_price') is-invalid @enderror" id="min_price" name="min_price" value="{{ old('min_price') }}">
            @error('min_price') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <button type="submit" class="btn btn-success">Salvar</button>
        <a href="{{ route('products.index') }}" class="btn btn-secondary">Voltar</a>
    </form>
</div>
</body>
</html>
