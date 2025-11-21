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
    /**
     * Lista todas as lojas do usuário logado (Inertia view)
     */
    public function index()
    {
        $stores = Store::where('owner_id', Auth::id())->get();
        return Inertia::render('stores/index', compact('stores'));
    }

    /**
     * Form de criação de loja (Inertia view)
     */
    public function create()
    {
        return Inertia::render('stores/create');
    }

    /**
     * Salva a nova loja
     */
    public function store(StoreStoreRequest $request)
    {
        Store::create([
            'name' => $request->name,
            'is_open' => $request->is_open ?? false,
            'auto_confirm_orders' => $request->auto_confirm ? true : false,
            'owner_id' => Auth::id(),
        ]);

        return redirect()->route('stores.index')->with('success', 'Loja criada com sucesso!');
    }

    /**
     * Exibe detalhes da loja (blade/view tradicional)
     */
    public function show(Store $store)
    {
        $this->authorizeStore($store);

        // Carrega os produtos junto com a loja
        $store->load('products');

        return view('stores.show', compact('store'));
    }

    /**
     * Form de edição da loja (blade/view tradicional)
     */
    public function edit(Store $store)
    {
        $this->authorizeStore($store);
        return view('stores.edit', compact('store'));
    }

    /**
     * Atualiza a loja
     */
    public function update(UpdateStoreRequest $request, Store $store)
    {
        $this->authorizeStore($store);
        $store->update($request->all());

        return redirect()->route('stores.index')->with('success', 'Loja atualizada com sucesso!');
    }

    /**
     * Remove a loja
     */
    public function destroy(Store $store)
    {
        $this->authorizeStore($store);
        $store->delete();

        return redirect()->route('stores.index')->with('success', 'Loja excluída com sucesso!');
    }

    /**
     * Endpoint API: retorna as lojas do usuário logado com status (JSON)
     * GET /api/stores/statuses
     */
    public function statuses()
    {
        $stores = Store::where('owner_id', auth()->id())
            ->select('id', 'name', 'is_open', 'auto_confirm_orders')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $stores
        ]);
    }

    /**
     * Endpoint API: alterna abrir/fechar para a loja informada na rota
     * POST /api/stores/{store}/toggle-status
     */
    public function toggleStatus(Store $store)
    {
        if ($store->owner_id !== auth()->id()) {
            return response()->json([
                'success' => false,
                'message' => 'Você não tem permissão para alterar esta loja.'
            ], 403);
        }

        $store->is_open = !$store->is_open;
        $store->save();

        return response()->json([
            'success' => true,
            'message' => 'Status da loja atualizado!',
            'data' => [
                'id' => $store->id,
                'is_open' => $store->is_open
            ]
        ]);
    }

    /**
     * Rota Inertia para Dashboard (se estiver usando)
     */
    public function dashboard()
    {
        $stores = Store::all();

        return Inertia::render('Dashboard', [
            'stores' => $stores
        ]);
    }

    /**
     * Toggle Abrir/Fechar loja via web (form/button tradicional)
     */
    public function toggleOpen(Store $store)
    {
        $this->authorizeStore($store);
        $store->update(['is_open' => !$store->is_open]);

        return back()->with('success', 'Status da loja atualizado!');
    }

    /**
     * Toggle Auto-confirmar pedidos (web)
     */
    public function toggleAutoConfirm(Store $store)
    {
        $this->authorizeStore($store);
        $store->update(['auto_confirm_orders' => !$store->auto_confirm_orders]);

        return back()->with('success', 'Auto-confirmar pedidos atualizado!');
    }

    /**
     * Verifica se o usuário logado é dono da loja
     */
    private function authorizeStore(Store $store)
    {
        if (Auth::user() === null || $store->owner_id !== Auth::user()->id) {
            abort(403, 'Você não tem permissão para acessar esta loja.');
        }
    }
}
