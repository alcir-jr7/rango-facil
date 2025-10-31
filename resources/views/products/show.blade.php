<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalhes do Produto</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">Detalhes do Produto</h1>

        <div class="card">
            <div class="card-header">
                Produto: {{ $product->name }}
            </div>
            <div class="card-body">
                <p><strong>ID:</strong> {{ $product->id }}</p>
                <p><strong>Nome:</strong> {{ $product->name }}</p>
                <p><strong>Descrição:</strong> {{ $product->description }}</p>
                <p><strong>Preço:</strong> R$ {{ number_format($product->price, 2, ',', '.') }}</p>
                @if($product->min_price)
                    <p><strong>Preço Mínimo:</strong> R$ {{ number_format($product->min_price, 2, ',', '.') }}</p>
                @endif
                @if($product->image_path)
                    <p><strong>Imagem:</strong></p>
                    <img src="{{ asset('storage/' . $product->image_path) }}" alt="Imagem do Produto" width="150">
                @endif
            </div>
        </div>

        <a href="{{ route('products.index') }}" class="btn btn-secondary mt-3">
            <i class="bi bi-arrow-left"></i> Voltar
        </a>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
