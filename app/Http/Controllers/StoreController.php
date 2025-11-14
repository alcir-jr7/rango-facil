<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Store;
use App\Http\Requests\StoreStoreRequest;
use App\Http\Requests\UpdateStoreRequest;
use Inertia\Inertia;

class StoreController extends Controller
{
    // Lista todas as lojas do usuário logado
    public function index()
    {
        $stores = Store::where('owner_id', Auth::id())->get();
        return Inertia::render('stores/index', compact('stores'));
    }

    // Form de criação de loja
    public function create()
    {
        return Inertia::render('stores/create');
    }

    // Salva a nova loja
    public function store(StoreStoreRequest $request)
{
    Store::create([
        'name' => $request->name,
        'is_open' => $request->is_open ?? false,
        'auto_confirm_orders' => $request->auto_confirm_orders ?? false,
        'owner_id' => Auth::id(), // Definido aqui, não vem do form
    ]);

    return redirect()->route('stores.index')->with('success', 'Loja criada com sucesso!');
}

    // Exibe detalhes da loja
    public function show(Store $store)
    {
       $this->authorizeStore($store);
    
    // Carrega os produtos junto com a loja
    $store->load('products');
    
    return view('stores.show', compact('store'));
    }

    // Form de edição da loja
    public function edit(Store $store)
    {
        $this->authorizeStore($store);
        return view('stores.edit', compact('store'));
    }

    // Atualiza a loja
    public function update(UpdateStoreRequest $request, Store $store)
    {
        $this->authorizeStore($store);
        $store->update($request->all());

        return redirect()->route('stores.index')->with('success', 'Loja atualizada com sucesso!');
    }

    // Remove a loja
    public function destroy(Store $store)
    {
        $this->authorizeStore($store);
        $store->delete();

        return redirect()->route('stores.index')->with('success', 'Loja excluída com sucesso!');
    }

    // Toggle Abrir/Fechar loja
    public function toggleOpen(Store $store)
    {
        $this->authorizeStore($store);
        $store->update(['is_open' => !$store->is_open]);

        return back()->with('success', 'Status da loja atualizado!');
    }

    // Toggle Auto-confirmar pedidos
    public function toggleAutoConfirm(Store $store)
    {
        $this->authorizeStore($store);
        $store->update(['auto_confirm_orders' => !$store->auto_confirm_orders]);

        return back()->with('success', 'Auto-confirmar pedidos atualizado!');
    }

    // Verifica se o usuário logado é dono da loja
    private function authorizeStore(Store $store)
    {
        if ($store->owner_id !== Auth::user()->id) {
            abort(403, 'Você não tem permissão para acessar esta loja.');
        }
    }
}
