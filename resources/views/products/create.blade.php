<!DOCTYPE html>
<html>
<head>
    <title>Adicionar Produto - {{ $store->name }}</title>
</head>
<body>
    <h1>Adicionar Produto - {{ $store->name }}</h1>

    <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="store_id" value="{{ $store->id }}">

        <label>Nome:</label>
        <input type="text" name="name" value="{{ old('name') }}" required><br>

        <label>Descrição:</label>
        <textarea name="description">{{ old('description') }}</textarea><br>

        <label>Preço:</label>
        <input type="number" step="0.01" name="price" value="{{ old('price') }}" required><br>

        <label>Preço Mínimo:</label>
        <input type="number" step="0.01" name="min_price" value="{{ old('min_price') }}"><br>

        <label>Imagem:</label>
        <input type="file" name="image_path"><br><br>

        <button type="submit">Salvar Produto</button>
    </form>

    <a href="{{ route('stores.show', $store) }}">Voltar</a>
</body>
</html>
