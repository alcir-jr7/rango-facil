<!DOCTYPE html>
<html>
<head>
    <title>Lista de Produtos</title>
</head>
<body>    
    <h1>Lista de Produtos</h1>        

    <!-- Botão para criar novo produto -->
    <div style="margin-bottom: 15px;">
        <a href="{{ route('products.create') }}">
            <button style="padding: 8px 16px; background-color: #4CAF50; color: white; border: none; cursor: pointer;">
                + Novo Produto
            </button>
        </a>
    </div>

    <div>
        <table border="1" cellpadding="8" cellspacing="0">
            <tr style="background-color: #f2f2f2;">
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
                    <!-- Botão Visualizar -->
                    <a href="{{ route('products.show', $product) }}">
                        <button style="background-color: #2196F3; color: white; border: none; padding: 5px 10px; cursor: pointer;">
                            Visualizar
                        </button>
                    </a>

                    <!-- Botão Editar -->
                    <a href="{{ route('products.edit', $product) }}">
                        <button style="background-color: #FFC107; color: black; border: none; padding: 5px 10px; cursor: pointer;">
                            Editar
                        </button>
                    </a>

                    <!-- Botão Excluir -->
                    <form action="{{ route('products.destroy', $product) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button style="background-color: #F44336; color: white; border: none; padding: 5px 10px; cursor: pointer;"
                                onclick="return confirm('Deseja excluir este produto?')">
                            Excluir
                        </button>
                    </form>
                </td>
            </tr>
            @endforeach
        </table>
    </div>
</body>
</html>
