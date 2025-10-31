<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

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
    public function create()
    {
        return view('products.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    $data = $request->validate([
        'name' => 'required|string|max:255',
        'description' => 'nullable|string',
        'image_path' => 'nullable|image',
        'price' => 'required|numeric',
        'min_price' => 'nullable|numeric',
    ]);

    // Define o ID da loja a partir do usuário logado / A espera do cadastro de usuários
    $data['store_id'] = auth()->user()->store->id;

    // Salva a imagem (se houver)
    if ($request->hasFile('image_path')) {
        $data['image_path'] = $request->file('image_path')->store('products', 'public');
    }

    Product::create($data);

    return redirect()->route('products.index')->with('success', 'Produto criado com sucesso!');
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
    public function edit(string $id, Product $product)
    {
        return view('products.edit', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id, Product $product)
    {
        $product->update($request->all());

        return view('products.show', compact('product'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->route('products.index');
    }
}
