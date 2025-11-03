<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;
use App\Models\Store;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::all();
        return view('products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
       // Pega o store_id da URL (?store_id=3)
    $storeId = $request->query('store_id');
    
    // Verifica se o usuário é dono dessa loja
    $store = Store::where('id', $storeId)
                  ->where('owner_id', auth()->id())
                  ->firstOrFail();
    
    return view('products.create', compact('store'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    $data = $request->validate([
        'name' => 'required|string|max:255',
        'description' => 'nullable|string',
        'price' => 'required|numeric',
        'min_price' => 'nullable|numeric',
        'store_id' => 'required|exists:stores,id', // ← Adicione esta validação
    ]);

    // Verifica se o usuário é dono dessa loja
    $store = Store::where('id', $data['store_id'])
                  ->where('owner_id', auth()->id())
                  ->firstOrFail();

    // Salva a imagem (se houver)
    if ($request->hasFile('image_path')) {
        $data['image_path'] = $request->file('image_path')->store('products', 'public');
    }

    Product::create($data);

    return redirect()->route('stores.show', $store->id)
                     ->with('success', 'Produto criado com sucesso!');
}

    /**
     * Display the specified resource.
     */
    public function show(string $id, Product $product)
    {
        return view('products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
       // Verifica se o usuário é dono da loja desse produto
    $store = Store::where('id', $product->store_id)
                  ->where('owner_id', auth()->id())
                  ->firstOrFail();
    
    return view('products.edit', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
       // Verifica se o usuário é dono da loja
    $store = Store::where('id', $product->store_id)
                  ->where('owner_id', auth()->id())
                  ->firstOrFail();

    $data = $request->validate([
        'name' => 'required|string|max:255',
        'description' => 'nullable|string',
        'price' => 'required|numeric|min:0',
        'min_price' => 'nullable|numeric|min:0',
    ]);

    // Atualiza imagem se houver nova
    if ($request->hasFile('image_path')) {
        // Deleta imagem antiga se existir
        if ($product->image_path) {
            Storage::disk('public')->delete($product->image_path);
        }
        $data['image_path'] = $request->file('image_path')->store('products', 'public');
    }

    $product->update($data);

    return redirect()->route('stores.show', $product->store_id)
                     ->with('success', 'Produto atualizado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
        public function destroy(Product $product)
    {
        // Verifica se o usuário é dono da loja
        $store = Store::where('id', $product->store_id)
                    ->where('owner_id', auth()->id())
                    ->firstOrFail();

        // Deleta a imagem se existir
        if ($product->image_path) {
            \Storage::disk('public')->delete($product->image_path);
        }

        $product->delete();

        // Redireciona de volta para a loja (não sai do local)
        return back()->with('success', 'Produto excluído com sucesso!');
    }
}
