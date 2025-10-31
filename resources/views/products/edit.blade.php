<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Produto</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">Editar Produto</h1>

        <form action="{{ route('products.update', $product) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- Nome -->
            <div class="mb-3">
                <label for="name" class="form-label">Nome do Produto</label>
                <input type="text"
                       class="form-control @error('name') is-invalid @enderror"
                       id="name" name="name"
                       value="{{ old('name', $product->name) }}" required>
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Descrição -->
            <div class="mb-3">
                <label for="description" class="form-label">Descrição</label>
                <textarea class="form-control @error('description') is-invalid @enderror"
                          id="description"
                          name="description">{{ old('description', $product->description) }}</textarea>
                @error('description')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Imagem -->
            <div class="mb-3">
                <label for="image_path" class="form-label">Imagem do Produto</label><br>
                @if($product->image_path)
                    <img src="{{ asset('storage/' . $product->image_path) }}" alt="Imagem atual" width="120" class="mb-2"><br>
                @endif
                <input type="file" class="form-control @error('image_path') is-invalid @enderror" id="image_path" name="image_path" accept="image/*">
                @error('image_path')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Preço -->
            <div class="mb-3">
                <label for="price" class="form-label">Preço</label>
                <input type="number" step="0.01"
                       class="form-control @error('price') is-invalid @enderror"
                       id="price" name="price"
                       value="{{ old('price', $product->price) }}" required>
                @error('price')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Preço mínimo -->
            <div class="mb-3">
                <label for="min_price" class="form-label">Preço Mínimo (opcional)</label>
                <input type="number" step="0.01"
                       class="form-control @error('min_price') is-invalid @enderror"
                       id="min_price" name="min_price"
                       value="{{ old('min_price', $product->min_price) }}">
                @error('min_price')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Botões -->
            <button type="submit" class="btn btn-success">
                <i class="bi bi-save"></i> Atualizar
            </button>
            <a href="{{ route('products.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Voltar
            </a>
        </form>
    </div>

    <!-- Bootstrap JS (opcional, para componentes como modais) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
