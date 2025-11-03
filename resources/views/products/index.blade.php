<!DOCTYPE html>
<html>
<head>
    <title>Lista de Produtos</title>
</head>
<body>
    <h1>Lista de Produtos</h1>

    <!-- Botão para criar novo produto -->
    <div>
        <a href="{{ route('products.create') }}">
            <button>+ Novo Produto</button>
        </a>
    </div>

    <div>
        <table border="1" cellpadding="8" cellspacing="0">
            <tr>
                <th>ID</th>
                <th>Store ID</th>
                <th>Nome</th>
                <th>Descrição</th>
                <th>Imagem</th>
                <th>Preço</th>
                <th>Preço Mínimo</th>
                <th>Criado em</th>
                <th>Ações</th>
            </tr>

            @foreach($products as $product)
            <tr>
                <td>{{ $product->id }}</td>
                <td>{{ $product->store_id }}</td>
                <td>{{ $product->name }}</td>
                <td>{{ $product->description }}</td>
                <td>
                    @if($product->image_path)
                        <img src="{{ asset('storage/' . $product->image_path) }}" alt="Imagem do Produto" width="80">
                    @else
                        Sem imagem
                    @endif
                </td>
                <td>R$ {{ number_format($product->price, 2, ',', '.') }}</td>
                <td>
                    @if($product->min_price)
                        R$ {{ number_format($product->min_price, 2, ',', '.') }}
                    @else
                        -
                    @endif
                </td>
                <td>{{ $product->created_at->format('d/m/Y') }}</td>

                <td>
                    <a href="{{ route('products.show', $product) }}">
                        <button>Visualizar</button>
                    </a>

                    <a href="{{ route('products.edit', $product) }}">
                        <button>Editar</button>
                    </a>

                    <form action="{{ route('products.destroy', $product) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button onclick="return confirm('Deseja excluir este produto?')">Excluir</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </table>
    </div>
</body>
</html>
