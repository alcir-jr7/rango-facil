<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Minhas Lojas</title>
</head>
<body>

    <nav>
        <a href="{{ route('dashboard') }}">Dashboard</a> › Minhas Lojas
    </nav>

    <h1>Minhas Lojas</h1>
    <a href="{{ route('stores.create') }}">Nova Loja</a>

    @if(session('success'))
        <div>
            {{ session('success') }}
        </div>
    @endif

    @if($stores->isEmpty())
        <div>
            <h3>Você ainda não tem lojas cadastradas</h3>
            <p>Crie sua primeira loja para começar a vender!</p>
        </div>
    @else
        @foreach($stores as $store)
            <div style="border:1px solid #000; padding:10px; margin:10px 0;">
                <h2>{{ $store->name }}</h2>
                <p>
                    Status:
                    <strong>{{ $store->is_open ? 'Aberta' : 'Fechada' }}</strong>
                </p>
                <p>Criada em {{ $store->created_at->format('d/m/Y') }}</p>

                <p>Auto-confirmar pedidos:
                    <strong>{{ $store->auto_confirm_orders ? 'Sim' : 'Não' }}</strong>
                </p>

                <div>
                    <a href="{{ route('stores.show', $store) }}">Gerenciar Loja</a>
                </div>

                <form action="{{ route('stores.toggleOpen', $store) }}" method="POST">
                    @csrf
                    <button type="submit">
                        {{ $store->is_open ? 'Fechar Loja' : 'Abrir Loja' }}
                    </button>
                </form>

                <a href="{{ route('stores.edit', $store) }}">Configurar</a>

                <form action="{{ route('stores.destroy', $store) }}" method="POST" onsubmit="return confirm('Tem certeza que deseja excluir esta loja? Esta ação não pode ser desfeita.')">
                    @csrf
                    @method('DELETE')
                    <button type="submit">Excluir Loja</button>
                </form>
            </div>
        @endforeach
    @endif

</body>
</html>
