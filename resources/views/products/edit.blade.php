<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Produto - {{ $product->name }}</title>
</head>
<body>
    <h1>Editar Produto</h1>

    <nav>
        <a href="{{ route('stores.index') }}">Minhas Lojas</a> › 
        <a href="{{ route('stores.show', $product->store_id) }}">{{ $product->store->name ?? 'Loja' }}</a> › 
        Editar Produto
    </nav>

    <h3>{{ $product->name }}</h3>

    @if ($errors->any())
        <div>
            <p><strong>Atenção!</strong></p>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('products.update', $product) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div>
            <label for="name">Nome do Produto *</label><br>
            <input type="text" id="name" name="name" value="{{ old('name', $product->name) }}" required>
        </div>

        <div>
            <label for="description">Descrição</label><br>
            <textarea id="description" name="description" rows="4">{{ old('description', $product->description) }}</textarea>
        </div>

        <div>
            <label for="price">Preço de Venda *</label><br>
            <input type="number" step="0.01" id="price" name="price" value="{{ old('price', $product->price) }}" required>
        </div>

        <div>
            <label for="min_price">Preço Mínimo</label><br>
            <input type="number" step="0.01" id="min_price" name="min_price" value="{{ old('min_price', $product->min_price) }}">
        </div>

        <div>
            <label for="image_path">Imagem do Produto</label><br>
            @if($product->image_path)
                <p>Imagem Atual:</p>
                <img src="{{ asset('storage/' . $product->image_path) }}" alt="Imagem atual" width="150"><br>
            @endif
            <input type="file" id="image_path" name="image_path" accept="image/*">
        </div>

        <br>
        <div>
            <a href="{{ route('stores.show', $product->store_id) }}">Cancelar</a>
            <button type="submit">Atualizar Produto</button>
        </div>
    </form>

    <hr>

    <h4>Informações do Produto</h4>
    <ul>
        <li><strong>Cadastrado em:</strong> {{ $product->created_at->format('d/m/Y H:i') }}</li>
        <li><strong>Última atualização:</strong> {{ $product->updated_at->format('d/m/Y H:i') }}</li>
        @if($product->store)
            <li><strong>Loja:</strong> {{ $product->store->name }}</li>
        @endif
    </ul>
</body>
</html>
