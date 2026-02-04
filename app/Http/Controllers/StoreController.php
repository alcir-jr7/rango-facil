<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Store;
use App\Http\Requests\StoreStoreRequest;
use App\Http\Requests\UpdateStoreRequest;
use Inertia\Inertia;
use Illuminate\Support\Facades\Storage;

class StoreController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        $stores = Store::where('owner_id', $user->id)
            ->withCount([
                'favoritedBy as is_favorited' => function ($q) use ($user) {
                    $q->where('user_id', $user->id);
                },
            ])
            ->get();

        return Inertia::render('stores/index', [
            'stores' => $stores,
        ]);
    }

    public function create()
    {
        return Inertia::render('stores/create');
    }

    public function store(StoreStoreRequest $request)
    {
        $imagePath = null;

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('stores', 'public');
        }

        Store::create([
            'name' => $request->name,
            'image' => $imagePath,
            'is_open' => $request->is_open ?? false,
            'auto_confirm_orders' => $request->auto_confirm ? true : false,
            'owner_id' => Auth::id(),
        ]);

        return redirect()
            ->route('stores.index')
            ->with('success', 'Loja criada com sucesso!');
    }

    /**
     * ✅ SHOW PÚBLICO (SEM 403)
     */
    public function show(Store $store)
    {
        $store->load('products');

        return Inertia::render('stores/show', [
            'store' => [
                'id' => $store->id,
                'name' => $store->name,
                'image' => $store->image,
                'is_open' => $store->is_open,
                'auto_confirm_orders' => $store->auto_confirm_orders,
                'owner_id' => $store->owner_id,
                'opened_at' => $store->created_at,
                'followers_count' => 100,
                'following_count' => 10,
                'rating' => '4.9',
                'products' => $store->products,
            ],
            'authUserId' => Auth::id(), // 🔑 identifica dono no frontend
        ]);
    }

            public function edit(Store $store)
    {
        return Inertia::render('stores/edit', compact('store'));
    }

    public function update(UpdateStoreRequest $request, Store $store)
    {
        $this->authorizeStore($store);

        $data = $request->validated();

        // Se uma nova imagem foi enviada
        if ($request->hasFile('image')) {
            // Deleta a imagem antiga se existir
            if ($store->image) {
                Storage::disk('public')->delete($store->image);
            }
            
            // Faz upload da nova imagem
            $data['image'] = $request->file('image')->store('stores', 'public');
        }

        $store->update($data);

        return redirect()
            ->route('stores.show', $store->id)
            ->with('success', 'Loja atualizada com sucesso!');
    }

    public function destroy(Store $store)
    {
        $this->authorizeStore($store);
        $store->delete();

        return redirect()->route('stores.index')
            ->with('success', 'Loja excluída com sucesso!');
    }

    public function toggleOpen(Store $store)
    {
        $this->authorizeStore($store);
        $store->update(['is_open' => !$store->is_open]);

        return back()->with('success', 'Status da loja atualizado!');
    }

    public function toggleAutoConfirm(Store $store)
    {
        $this->authorizeStore($store);
        $store->update([
            'auto_confirm_orders' => !$store->auto_confirm_orders
        ]);

        return back()->with('success', 'Auto-confirmar atualizado!');
    }

    /**
     * 🔐 Validação de dono
     */
    private function authorizeStore(Store $store)
    {
        if (!Auth::check() || $store->owner_id !== Auth::id()) {
            abort(403, 'Você não tem permissão para acessar esta loja.');
        }
    }

    public function all(Request $request)
    {
        $user = $request->user();

        $stores = Store::withCount([
            'favoritedBy as is_favorited' => function ($q) use ($user) {
                $q->where('user_id', $user->id);
            },
        ])->get();

        return Inertia::render('stores/all', [
            'stores' => $stores,
        ]);
    }
}
