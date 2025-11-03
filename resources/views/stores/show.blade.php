<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciar {{ $store->name }}</title>
</head>
<body>

    <a href="{{ route('stores.index') }}">← Voltar para Minhas Lojas</a>

    <h1>{{ $store->name }}</h1>
    <p>
        <strong>{{ $store->is_open ? '● Loja Aberta' : '● Loja Fechada' }}</strong>
    </p>

    <a href="{{ route('stores.edit', $store) }}">Configurações</a>

    @if(session('success'))
        <div>{{ session('success') }}</div>
    @endif

    <h2>Estatísticas</h2>
    <ul>
        <li>Produtos: {{ $store->products->count() ?? 0 }}</li>
        <li>Pedidos Hoje: 0</li>
        <li>Pedidos Pendentes: 0</li>
        <li>Vendas do Mês: R$ 0,00</li>
    </ul>

    <h2>Ações Rápidas</h2>
    <form action="{{ route('stores.toggleOpen', $store) }}" method="POST">
        @csrf
        <button type="submit">
            {{ $store->is_open ? 'Fechar Loja' : 'Abrir Loja' }}
        </button>
    </form>

    <form action="{{ route('stores.toggleAutoConfirm', $store) }}" method="POST">
        @csrf
        <button type="submit">
            Auto-confirmar: {{ $store->auto_confirm_orders ? 'Ativado' : 'Desativado' }}
        </button>
    </form>

    <h2>Informações da Loja</h2>
    <ul>
        <li>Criada em: {{ $store->created_at->format('d/m/Y') }}</li>
        <li>Última atualização: {{ $store->updated_at->format('d/m/Y H:i') }}</li>
        <li>Proprietário: {{ $store->owner->name ?? 'N/A' }}</li>
    </ul>

    <h2>Produtos da Loja</h2>
    <a href="{{ route('products.create') }}?store_id={{ $store->id }}">Adicionar Produto</a>

    @if($store->products && $store->products->count() > 0)
        <table border="1" cellpadding="5" cellspacing="0">
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Preço</th>
                    <th>Estoque</th>
                    <th>Status</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach($store->products as $product)
                    <tr>
                        <td>
                            <strong>{{ $product->name }}</strong><br>
                            @if($product->description)
                                <small>{{ Str::limit($product->description, 50) }}</small>
                            @endif
                        </td>
                        <td>R$ {{ number_format($product->price ?? 0, 2, ',', '.') }}</td>
                        <td>{{ $product->stock ?? 'N/A' }}</td>
                        <td>{{ ($product->active ?? true) ? 'Ativo' : 'Inativo' }}</td>
                        <td>
                            <a href="{{ route('products.edit', $product) }}">Editar</a>
                            <form action="{{ route('products.destroy', $product) }}" method="POST" onsubmit="return confirm('Deseja excluir este produto?')" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit">Excluir</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>Nenhum produto cadastrado.</p>
        <a href="{{ route('products.create') }}?store_id={{ $store->id }}">Adicionar Primeiro Produto</a>
    @endif

    <h2>Pedidos Recentes</h2>
    <p>Nenhum pedido ainda. Os pedidos aparecerão aqui quando os clientes começarem a comprar.</p>

</body>
</html>
