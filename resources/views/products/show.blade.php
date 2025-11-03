<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalhes do Produto</title>
</head>
<body>
    <h1>Detalhes do Produto</h1>

    <div>
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

    <p>
        <a href="{{ route('products.index') }}">Voltar</a>
    </p>
</body>
</html>
